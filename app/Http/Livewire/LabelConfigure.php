<?php

namespace App\Http\Livewire;

use App\Models\Label;
use App\Models\Set;
use Livewire\Component;

class LabelConfigure extends Component
{
    /**
     * @var mixed
     */
    public Label $label;

    public array $fontsConfig;

    protected $listeners = [
        'setDeleted' => 'refresh',
    ];

    protected $rules = [
        'label.settings.size'        => 'required',
        'label.settings.orientation' => 'required',
        'label.settings.numbers'     => 'required',
        'label.settings.column_nos'  => 'required',
    ];

    public function mount($label)
    {
        $this->label = $label;
        $this->fontsConfig = config('sai.fonts');
    }

    /**
     * @param $property
     */
    public function updated($property)
    {
        if (str_starts_with($property, 'label.settings.')) {
            $this->label->save();
        }
    }

    public function addNewSet()
    {
        $set = new Set();
        $set->name = 'Label Set '.($this->label->sets()->count() + 1);
        $set->incremental = 1;

        $this->label->sets()->save($set);
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.label-configure', [
            'pageOptions'      => array_merge(config('sai.pageOptions')),
            'pageOrientations' => array_merge(config('sai.pageOrientations')),
        ]);
    }

    public function refresh()
    {
        $this->label->refresh();
    }
}
