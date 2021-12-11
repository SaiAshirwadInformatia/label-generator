<?php

namespace App\Http\Livewire;

use App\Models\Field;
use App\Models\Label;
use App\Models\Set;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class LabelConfigure extends Component
{

    /**
     * @var mixed
     */
    public Label $label;

    public $fontsConfig;

    protected $rules = [
        'label.sets.*.name',
        'label.sets.*.type',
        'label.sets.*.columnName',
    ];

    public function mount($label)
    {
        $this->label = Label::find($label);
        $this->fontsConfig = config('sai.fonts');
    }

    /**
     * @param $property
     */
    public function updated($property)
    {
        if (Str::startsWith($property, 'sets')) {
            Log::info($property);
        } else if (Str::startsWith($property, 'field')) {
            Log::info($property);
            Log::info(json_encode($this->fields));
        }
    }

    private function resaveSets()
    {
        $this->label->refresh();
    }

    /**
     * @param $setId
     * @param $fieldIndex
     */
    public function removeField($setId, $fieldId)
    {
        Field::where('id', $fieldId)->delete();
        $this->label->refresh();
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
            'settings'     => [
                'font' => 'Roboto',
                'type' => 'Regular',
                'size' => '12'
            ],
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
