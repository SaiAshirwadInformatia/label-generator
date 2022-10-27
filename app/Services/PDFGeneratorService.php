<?php

namespace App\Services;

use App\Models\Set;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Barryvdh\Snappy\PdfWrapper;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Browsershot\Browsershot;

class PDFGeneratorService
{
    private int $recordCount = 0;

    private bool $preview = false;

    private int $previewLimit = 50;

    private bool $html = false;

    public function count()
    {
        return $this->recordCount;
    }

    public function html(): PDFGeneratorService
    {
        $this->html = true;

        return $this;
    }

    public function preview(): PDFGeneratorService
    {
        $this->preview = true;

        return $this;
    }

    public function limit(int $limit): PDFGeneratorService
    {
        $this->previewLimit = $limit;

        return $this;
    }

    public function readExcel(Set $set): array
    {
        $label = $set->label;
        $columns = [];
        $records = [];

        $path = Storage::disk('public')->path($label->path);

        $reader = ReaderEntityFactory::createReaderFromFile($path);
        $reader->open($path);

        $previewRecords = 0;
        $onlyOneSheet = 1;
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
            }
            break;
        }
        $reader->close();
        $reader = null;

        if ($this->preview) {
            if (count($records) < $this->previewLimit) {
                $this->previewLimit = count($records);
            }
            $records = collect($records)->random($this->previewLimit)->toArray();
        }

        return $records;
    }

    public function prepareTables(Set $set, &$records): array
    {
        $incremental = $set->incremental ?? 1;

        $tables = [];

        if ($set->type != Set::GROUPED && !isset($set->settings['differentPage'])) {
            $data = [];

            foreach ($records as $record) {
                $row = [];
                $emptyRows = 0;
                foreach ($set->fields as $field) {
                    $row[$field->name] = match ($field->type) {
                        'Text' => $record[$field->name] ?? '',
                        'Static' => $field->default,
                        'Incremented' => $incremental++,
                        'Number' => intval($record[$field->name]),
                        'Float' => floatval($record[$field->name]),
                        'Boolean' => boolval($record[$field->name]) ? 'Yes' : 'No',
                        'dd/MM/YYYY' => Carbon::parse($record[$field->name])->format('d/m/Y'),
                        'INR' => 'Rs. ' . $record[$field->name],
                        default => ''
                    };
                    if ($field->type == 'EmptyRow') {
                        $emptyRows++;
                    }
                }

                $emptyCount = 1;
                foreach ($row as $v) {
                    if (empty(trim($v))) {
                        $emptyCount++;
                    }
                }
                if ($emptyCount >= $emptyRows + 3) {
                    continue;
                }

                $data[] = $row;
            }
            $this->recordCount += count($data);
            $tables['General'] = $data;

            return $tables;
        }

        if (isset($set->settings['differentPage'])) {
            $tableRows = collect($records)->groupBy($set->settings['differentPage']);
        } else {
            $tableRows = ['General' => collect($records)];
        }
        $records = null;



        if ($set->type == Set::GROUPED) {
            $index = 0;
            foreach ($tableRows as $stateName => $records) {
                $records = $records->groupBy($set->columnName);
                $data = [];
                foreach ($records as $sub_records) {
                    $subCount = count($sub_records);
                    $record = $sub_records->first();

                    $row = [];
                    $emptyRows = 0;
                    $hasSubCount = '';
                    $hasIncremented = '';

                    foreach ($set->fields as $field) {
                        if ($field->type == 'SubCount') {
                            $hasSubCount = $field->name;
                        } elseif ($field->type == 'Incremented') {
                            $hasIncremented = $field->name;
                        }

                        $row[$field->name] = match ($field->type) {
                            'Text' => $record[$field->name] ?? '',
                            'Static' => $field->default,
                            'SubCount' => $subCount,
                            'Concatenated' => $sub_records->pluck($field->name)->join('<br>'),
                            'Incremented' => $incremental++,
                            'Number' => intval($record[$field->name]),
                            'Float' => floatval($record[$field->name]),
                            'Boolean' => boolval($record[$field->name]) ? 'Yes' : 'No',
                            'dd/MM/YYYY' => Carbon::parse($record[$field->name])->format('d/m/Y'),
                            'INR' => 'Rs. ' . $record[$field->name],
                            default => ''
                        };

                        if ($field->type == 'EmptyRow') {
                            $emptyRows++;
                        }
                    }

                    $emptyCount = 1;
                    foreach ($row as $v) {
                        if (empty(trim($v))) {
                            $emptyCount++;
                        }
                    }
                    if ($emptyCount >= $emptyRows + 3) {
                        continue;
                    }

                    if ($hasSubCount && !empty($set->limit) && $set->limit > 0 && $row[$hasSubCount] > $set->limit) {
                        $quantity = $subCount;
                        $limit = $set->limit;

                        if ($subCount > 35) {
                             $limit = 30;
                        }

                        for ($i = 0; $i < intval(ceil($subCount / $limit)); $i++) {
                            if ($quantity > $limit) {
                                $row[$hasSubCount] = $limit;
                            } else {
                                $row[$hasSubCount] = $quantity;
                            }
                            $quantity = $quantity - $limit;
                            $data[] = $row;
                            if ($hasIncremented && $i != floor($subCount / $limit)) {
                                $row[$hasIncremented] = $incremental;
                                $incremental++;
                            }
                        }
                    } else {
                        $data[] = $row;
                    }
                }
                $this->recordCount += count($data);
                if (!empty($stateName)) {
                    $tables[$stateName] = $data;
                } else {
                    $tables[$index++] = $data;
                }
            }
        } else {
            $index = 0;
            foreach ($tableRows as $stateName => $records) {
                $data = [];
                foreach ($records as $record) {
                    $row = [];
                    $emptyRows = 0;
                    foreach ($set->fields as $field) {
                        $row[$field->name] = match ($field->type) {
                            'Text' => $record[$field->name] ?? '',
                            'Static' => $field->default,
                            'Incremented' => $incremental++,
                            'Number' => intval($record[$field->name]),
                            'Float' => floatval($record[$field->name]),
                            'Boolean' => boolval($record[$field->name]) ? 'Yes' : 'No',
                            'dd/MM/YYYY' => Carbon::parse($record[$field->name])->format('d/m/Y'),
                            'INR' => 'Rs. ' . $record[$field->name],
                            default => ''
                        };

                        if ($field->type == 'EmptyRow') {
                            $emptyRows++;
                        }
                    }
                    $emptyCount = 1;
                    foreach ($row as $v) {
                        if (empty(trim($v))) {
                            $emptyCount++;
                        }
                    }
                    if ($emptyCount >= $emptyRows + 3) {
                        continue;
                    }
                    $data[] = $row;
                }
                $this->recordCount += count($data);
                if (!empty($stateName)) {
                    $tables[$stateName] = $data;
                } else {
                    $tables[$index++] = $data;
                }
            }
        }

        return $tables;
    }

    public function process(Set $set): \Barryvdh\DomPDF\PDF|PdfWrapper|View
    {
        $label = $set->label;
        $records = $this->readExcel($set);

        $tables = $this->prepareTables($set, $records);

        if ($this->html) {
            return view('pdf.table', compact('set', 'tables'));
        }

        if (app()->environment('local')) {
//            return Pdf::loadView('pdf.table', compact('set', 'tables'))
//                ->setPaper($label->settings['size'], $label->settings['orientation']);
        }

        return SnappyPdf::loadView('pdf.table', compact('set', 'tables'))
            ->setPaper($label->settings['size'], $label->settings['orientation']);

//
//
//        $browserShot = Browsershot::html(view('pdf.table', compact('set', 'tables'))->render())
//            ->format($label->settings['size']);
//
//        if ($label->settings['orientation'] == 'landscape') {
//            $browserShot->landscape();
//        }
//
//        return $browserShot;
    }
}
