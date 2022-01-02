<?php

namespace App\Services;

use App\Models\Set;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;

class PDFGeneratorService
{
    private int $recordCount = 0;

    public function count()
    {
        return $this->recordCount;
    }

    public function process(Set $set, bool $preview = false, int $previewLimit = 100): \Barryvdh\DomPDF\PDF
    {
        $label = $set->label;
        $columns = [];
        $records = [];

        $path = Storage::disk('public')->path($label->path);

        $reader = ReaderEntityFactory::createReaderFromFile($path);
        $reader->open($path);

        $previewRecords = 0;

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
                    $previewRecords++;
                }
                if ($preview && $previewRecords >= $previewLimit) {
                    break;
                }
            }
            if ($preview && $previewRecords >= $previewLimit) {
                break;
            }
        }

        $reader->close();
        $reader = null;

        $tableRows = collect($records)->groupBy($set->settings['differentPage']);
        $records = null;
        $incremental = 1;

        $tables = [];

        if ($set->type == Set::GROUPED) {
            foreach ($tableRows as $stateName => $records) {
                $records = $records->groupBy($set->columnName);
                $data = [];
                foreach ($records as $record) {
                    $subCount = count($record);
                    $record = $record->first();
                    $row = [];
                    foreach ($set->fields as $field) {
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
                $this->recordCount += count($data);
                $tables[$stateName] = $data;
            }
        } else {
            foreach ($tableRows as $stateName => $records) {
                $data = [];
                foreach ($records as $record) {
                    $row = [];
                    foreach ($set->fields as $field) {
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
                $this->recordCount += count($data);
                $tables[$stateName] = $data;
            }
        }

        return PDF::loadView('pdf.table', compact('set', 'tables'))
            ->setPaper($label->settings['size'], $label->settings['orientation']);
    }
}
