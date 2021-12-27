<?php

namespace App\Jobs;

use App\Mail\PDFReadyMail;
use App\Models\Ready;
use App\Models\Set;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class GeneratePDFJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Set $set;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Set $set)
    {
        $this->set = $set;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ready = new Ready();
        $ready->user_id = $this->set->label->user->id;
        $ready->set_id = $this->set->id;

        $path = Storage::disk('public')->path($this->set->label->path);
        $directory = Carbon::now()->format('Y' . DIRECTORY_SEPARATOR . 'm');
        if (!Storage::disk('local')->exists($directory)) {
            Storage::disk('local')->makeDirectory($directory);
        }
        $fileName = $directory . DIRECTORY_SEPARATOR . time() . '.pdf';
        $outputPath = Storage::disk('local')->path($fileName);
        $ready->path = $fileName;
        $ready->started_at = Carbon::now();
        $ready->save();

        $columns = [];
        $records = [];

        $reader = ReaderEntityFactory::createReaderFromFile($path);
        $reader->open($path);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                // do stuff with the row
                $cells = $row->getCells();
                $record = [];
                foreach ($cells as $cell) {
                    $record[] = $cell->getValue();
                }
                if (count($columns) == 0) {
                    // this is just to skip this row
                    $columns = $record;
                } else {
                    $records[] = $record;
                }
            }
        }

        $records = collect($records);
        $data = [];
        $incremental = 1;

        if ($this->set->type == Set::GROUPED) {
            $records = $records->groupBy($this->set->columnName);
            foreach ($records as $record) {
                $subCount = count($record);
                $record = $record->first();
                $row = [];
                foreach ($this->set->fields as $field) {
                    $row[] = match ($field->type) {
                        'Text' => $record[$field->name],
                        'Static' => $field->default,
                        'SubCount' => $subCount,
                        'Incremented' => $incremental++,
                        'Number' => intval($record[$field->name]),
                        'Float' => floatval($record[$field->name]),
                        'Boolean' => boolval($record[$field->name]) ? 'Yes' : 'No',
                        'dd/MM/YYYY' => Carbon::parse($record[$field->name])->format('d/m/Y'),
                        'INR' => 'Rs. ' . $record[$field->name]
                    };
                }
                $data[] = $row;
            }
        } else {
            foreach ($records as $record) {
                $row = [];
                foreach ($this->set->fields as $field) {
                    $row[] = match ($field->type) {
                        'Text' => $record[$field->name],
                        'Static' => $field->default,
                        'Incremented' => $incremental++,
                        'Number' => intval($record[$field->name]),
                        'Float' => floatval($record[$field->name]),
                        'Boolean' => boolval($record[$field->name]) ? 'Yes' : 'No',
                        'dd/MM/YYYY' => Carbon::parse($record[$field->name])->format('d/m/Y'),
                        'INR' => 'Rs. ' . $record[$field->name]
                    };
                }
                $data[] = $row;
            }
        }

        PDF::loadView(
            'pdf.table',
            [
                'set' => $this->set,
                'tableRows' => $data
            ]
        )
            ->setPaper($this->set->label->settings['size'], $this->set->label->settings['orientation'])
            ->save($outputPath);
        $ready->completed_at = Carbon::now();
        $ready->records = count($data);
        $ready->save();

        Mail::to($this->set->label->user)
            ->queue(new PDFReadyMail($ready));
    }
}
