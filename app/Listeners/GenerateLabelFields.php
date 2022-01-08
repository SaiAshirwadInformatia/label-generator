<?php

namespace App\Listeners;

use App\Events\LabelCreated;
use App\Models\Field;
use App\Models\Set;
use App\Models\Template;
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

        if (isset($event->template_id)) {
            $template = Template::find($event->template_id);

            foreach ($template->options as $set) {
                // $this->removeUnwanted($set);
                $setObj = new Set();
                $setObj->fill($set);
                $setObj->label_id = $event->label->id;
                $setObj->save();
                foreach ($set['fields'] as $field) {
                    // $this->removeUnwanted($field);
                    $fieldObj = new Field();
                    $fieldObj->fill($field);
                    $fieldObj->set_id = $setObj->id;
                    $fieldObj->save();
                }
            }
        }
    }

    private function removeUnwanted(array &$array)
    {
        $keys = ['id', 'created_at', 'updated_at', 'set_id', 'label_id'];
        foreach ($array as $key => $arr) {
            if (in_array($key, $keys)) {
                unset($array[$key]);
            }
        }
    }
}
