<?php

namespace App\Services;

use App\Models\Field;
use App\Models\Set;
use Barryvdh\DomPDF\Facade\Pdf;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PDFGeneratorService
{
    private int $recordCount = 0;

    private bool $preview = false;

    private int $previewLimit = 2000;

    private bool $html = false;

    private int $chunkSize = 750;

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

    public function chunkSize(int $size): PDFGeneratorService
    {
        $this->chunkSize = $size;

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

        $count = 0;

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->getCells();
                $record = [];
                foreach ($cells as $cell) {
                    $record[] = $cell->getValue();
                }

                if (count($columns) == 0) {
                    // this is just to skip this row (header row)
                    $columns = $record;
                    continue;
                }

                $records[] = $record;
                $count++;

                // Stop reading the file entirely once we've hit the preview
                // limit — no point streaming the rest of a 50k row file just
                // to throw it away afterward.
                if ($this->preview && $count >= $this->previewLimit) {
                    break 2;
                }
            }
            break;
        }
        $reader->close();
        $reader = null;

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
                    if ($field->type == 'Concatenated') {
                        $value = $field->default;

                        foreach ($set->label->settings['columns'] as $column => $columnName) {

                            $value = str_replace('|' . $columnName . '|', $record[$column], $value);
                        }
                        $row[$field->name] = $value;
                        continue;
                    }
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

                $data[] = $row;
            }
            $this->recordCount += count($data);
            $tables['General'] = $data;

            return $tables;
        }

        if (isset($set->settings['differentPage']) && !blank($set->settings['differentPage'])) {
            $tableRows = collect($records)->groupBy($set->settings['differentPage']);
        } else {
            $tableRows = ['General' => collect($records)];
        }
        $records = null;

        if ($set->type === Set::GROUPED) {
            $index = 0;
            $filter = false;
            $filterGrouped = [];

            if (isset($set->settings['filter']) && !empty(trim($set->settings['filter']))) {
                $filterGrouped = explode(',', trim($set->settings['filter']));
                if (count($filterGrouped) > 0) {
                    $filter = true;
                }
            }

            foreach ($tableRows as $stateName => $records) {
                $records = $records->groupBy($set->columnName);
                $data = [];
                foreach ($records as $sub_records) {
                    $subCount = count($sub_records);
                    $record = $sub_records->first();

                    if ($filter && !in_array($record[$set->columnName], $filterGrouped, false)) {
                        continue;
                    }

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
                            'Concatenated' => $sub_records->pluck($field->name)->map(fn($v) => trim($v))->unique()->join(', '),
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

                        $concatenated = [];
                        $field_name = null;
                        if ($set->fields->contains(fn(Field $field) => $field->type == 'Concatenated')) {
                            $field_name = $set->fields->firstWhere('type', 'Concatenated')->name;
                            $concatenated = $sub_records->pluck($field_name)->unique()->toArray();
                        }

                        for ($i = 0; $i < intval(ceil($subCount / $limit)); $i++) {
                            if ($quantity > $limit) {
                                $row[$hasSubCount] = $limit;
                            } else {
                                $row[$hasSubCount] = $quantity;
                            }
                            if (!empty($concatenated) && $field_name != null) {
                                $row[$field_name] = implode(', ', array_splice($concatenated, 0, $row[$hasSubCount]));
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
                        if ($field->type == 'Concatenated') {
                            $value = $field->default;

                            foreach ($set->label->settings['columns'] as $column => $columnName) {
                                $value = str_replace('|' . $columnName . '|', $record[$column], $value);
                            }
                            $row[$field->name] = $value;
                            continue;
                        }

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

    public function process(Set $set): \Barryvdh\DomPDF\PDF|View
    {
        $label = $set->label;
        $records = $this->readExcel($set);

        $tables = $this->prepareTables($set, $records);

        if ($this->html) {
            return view('pdf.table', compact('set', 'tables'));
        }

        return Pdf::loadView('pdf.table', compact('set', 'tables'))
            ->setPaper($label->settings['size'], $label->settings['orientation']);
    }

    /**
     * Memory-safe path for large datasets: renders the label set in fixed-size
     * chunks (separate DomPDF instances, each discarded after saving), then
     * stitches the resulting single-page-per-chunk... multi-page PDFs back
     * together with FPDI. This caps DomPDF's peak memory at "one chunk" no
     * matter how large the source Excel file is.
     *
     * Returns the path the final merged PDF was written to.
     */
    public function processChunked(Set $set, string $outputPath): string
    {
        $label = $set->label;

        $records = $this->readExcel($set);
        $tables = $this->prepareTables($set, $records);
        unset($records);

        // Flatten every sub-table (grouped/differentPage) into one row list,
        // chunk it, render each chunk as its own small PDF, then merge.
        // If you need each named table (e.g. per-state) as a *separate*
        // output file instead of merged into one PDF, don't flatten here —
        // loop $tables and call a per-table chunk+save instead.
        $rows = [];
        foreach ($tables as $tableRows) {
            foreach ($tableRows as $row) {
                $rows[] = $row;
            }
        }
        unset($tables);

        $tmpDir = storage_path('app' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . uniqid('pdfchunk_'));
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        $partialPaths = [];

        try {
            $chunks = array_chunk($rows, $this->chunkSize);
            unset($rows);

            foreach ($chunks as $i => $chunk) {
                $tablesChunk = ['General' => $chunk];
                $partialPath = $tmpDir . DIRECTORY_SEPARATOR . "part-{$i}.pdf";

                Pdf::loadView('pdf.table', ['set' => $set, 'tables' => $tablesChunk])
                    ->setPaper($label->settings['size'], $label->settings['orientation'])
                    ->save($partialPath);

                $partialPaths[] = $partialPath;

                unset($tablesChunk, $chunks[$i]);
                gc_collect_cycles();
            }

            $this->mergePdfs($partialPaths, $outputPath);
        } finally {
            foreach ($partialPaths as $path) {
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
            @rmdir($tmpDir);
        }

        return $outputPath;
    }

    private function mergePdfs(array $partialPaths, string $outputPath): void
    {
        if (count($partialPaths) === 1) {
            // Nothing to merge, just move it into place.
            rename($partialPaths[0], $outputPath);
            // prevent double-unlink in the finally block above
            array_splice($partialPaths, 0, 1);

            return;
        }

        $pdf = new \setasign\Fpdi\Fpdi();

        foreach ($partialPaths as $path) {
            $pageCount = $pdf->setSourceFile($path);
            for ($p = 1; $p <= $pageCount; $p++) {
                $templateId = $pdf->importPage($p);
                $size = $pdf->getTemplateSize($templateId);
                $pdf->AddPage(
                    $size['orientation'],
                    [$size['width'], $size['height']]
                );
                $pdf->useTemplate($templateId);
            }
        }

        $pdf->Output('F', $outputPath);
    }
}