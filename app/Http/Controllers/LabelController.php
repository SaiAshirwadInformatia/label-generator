<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Set;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class LabelController extends Controller
{

    public const PREVIEW = 1000;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('labels.create');
    }

    public function configure(Request $request, Label $label)
    {
        return view('labels.configure', compact('label'));
    }

    public function preview(Set $set)
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
                if ($previewRecords >= self::PREVIEW) {
                    break;
                }
            }
            if ($previewRecords >= self::PREVIEW) {
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
                $tables[$stateName] = $data;
            }
        }

        return PDF::loadView(
            'pdf.table',
            [
                'set' => $set,
                'tables' => $tables
            ]
        )
            ->setPaper($label->settings['size'], $label->settings['orientation'])
            ->stream();
    }
}
