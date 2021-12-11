<?php

namespace App\Listeners;

use App\Events\LabelCreated;
use App\Models\Set;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateLabelFields implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\LabelCreated $event
     * @return void
     */
    public function handle(LabelCreated $event)
    {
        $path    = Storage::disk('public')->path($event->label->path);
        $columns = [];
        if (Str::endsWith($path, '.csv')) {
            $fp      = fopen($path, 'r');
            $columns = fgetcsv($fp);
            fclose($fp);
        } else {
            $reader = ReaderEntityFactory::createReaderFromFile($path);
            $reader->open($path);

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    // do stuff with the row
                    $cells = $row->getCells();
                    foreach ($cells as $cell) {
                        $columns[] = $cell->getValue();
                    }
                    break;
                }
                break;
            }
        }
        $settings               = $event->label->settings ?? [];
        $settings['columns']    = $columns;
        $event->label->settings = $settings;
        $event->label->save();
    }
}
