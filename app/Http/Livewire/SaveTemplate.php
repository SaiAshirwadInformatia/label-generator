<?php

namespace App\Http\Livewire;

use App\Models\Label;
use App\Models\Template;
use Livewire\Component;

class SaveTemplate extends Component
{
    public Label $label;

    public Template $template;

    public $rules = [
        'template.name' => 'required'
    ];

    public function mount()
    {
        if (isset($this->label->template)) {
            $this->template = $this->label->template;
        } else {
            $this->template = new Template();
        }
    }
    public function render()
    {
        return view('livewire.save-template');
    }

    public function submit()
    {
        $this->validate();

        $this->label->load('sets', 'sets.fields');
        $this->template->user_id = auth()->id();
        $this->template->options = $this->label->sets;
        $this->template->save();

        $this->label->template_id = $this->template->id;
        $this->label->save();

        $this->emit('showSuccess', 'Templated saved!');
    }
}
