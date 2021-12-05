<?php

namespace App\Http\Livewire;

use App\Models\Set;
use Illuminate\Support\Str;
use Livewire\Component;

class LabelConfigure extends Component
{

    /**
     * @var mixed
     */
    public $label;

    /**
     * @var array
     */
    public $sets = [];

    /**
     * @var array
     */
    public $fields = [];

    public function mount()
    {
        $this->sets = $this->label->sets->toArray();
        foreach ($this->label->sets as $set) {
            $this->fields[$set->id] = $set->fields->toArray();
            if (count($this->fields[$set->id]) == 0) {
                $this->fields[$set->id] = [];
                foreach ($this->label->settings['columns'] as $column) {
                    $this->fields[$set->id][] = [
                        'name'         => $column,
                        'display_name' => Str::title($column),
                        'type'         => 'Text',
                        'default'      => '',
                        'settings'     => [],
                    ];
                }
            }
        }
    }

    /**
     * @param $property
     */
    public function updated($property)
    {
        if (Str::startsWith($property, 'sets')) {
            $this->resaveSets();
        } else if (Str::startsWith($property, 'field')) {

        }
    }

    private function resaveSets()
    {
        $this->label->sets()->delete();
        $sets = [];
        foreach ($this->sets as $set) {
            $s                = new Set();
            $s->name          = $set['name'];
            $s->type          = $set['type'];
            $s->columnName    = $set['columnName'];
            $s->is_downloaded = $set['is_downloaded'];
            $s->settings      = $set['settings'];
            $sets[]           = $s;
        }
        $this->label->sets()->saveMany($sets);
        $this->label->refresh();
    }

    /**
     * @param $setId
     * @param $fieldIndex
     */
    public function removeField($setId, $fieldIndex)
    {
        $fields = $this->fields[$setId];
        array_splice($fields, $fieldIndex, 1);
        $this->fields[$setId] = $fields;
    }

    /**
     * @param $setId
     */
    public function addField($setId)
    {
        if (!isset($this->fields[$setId])) {
            $this->fields[$setId] = [];
        }
        $this->fields[$setId][] = [
            'name'         => '',
            'display_name' => '',
            'type'         => 'Text',
            'default'      => '',
            'settings'     => [],
        ];
    }

    /**
     * @param $index
     */
    public function removeSet($index)
    {
        array_splice($this->sets, $index, 1);
        $this->resaveSets();
    }

    public function addNewSet()
    {
        $set       = new Set();
        $set->name = 'Label Set ' . ($this->label->sets()->count() + 1);
        $this->label->sets()->save($set);
        $this->label->refresh();
        $this->sets = $this->label->sets->toArray();
    }

    public function render()
    {
        $columns = ['' => ''];
        foreach ($this->label->settings['columns'] as $column) {
            $columns[$column] = $column;
        }
        return view('livewire.label-configure', [
            'columns'    => $columns,
            'fieldTypes' => config('sai.fieldTypes'),
        ]);
    }
}
