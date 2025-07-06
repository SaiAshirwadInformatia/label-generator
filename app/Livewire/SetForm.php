<?php

namespace App\Livewire;

use App\Jobs\GeneratePDFJob;
use App\Livewire\Forms\SetFormData;
use App\Models\Field;
use App\Models\Set;
use Livewire\Component;

class SetForm extends Component
{
    public Set $set;
    public SetFormData $formData;

    public array $columns;

    public string $previewLink;
    protected $listeners = [
        'refreshSet'  => 'refresh',
        'hidePreview' => 'hide',
    ];

    public function mount()
    {
        $this->formData->name = $this->set->name;
        $this->formData->type = $this->set->type;
        $this->formData->columnName = $this->set->columnName;
        $this->formData->limit = $this->set->limit;
        $this->formData->incremental = $this->set->incremental;
        $this->formData->header_width = $this->set->header_width;
        $this->formData->header_font = $this->set->header_font;
        $this->formData->settings = $this->set->settings ?? [];
    }


    public function updated($name, $value): void
    {
        if ($name == 'formData.limit' && empty($value)) {
            $this->formData->limit = null;
        }
        $this->set->fill($this->formData->all());
        $this->set->save();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $columns = ['NotSelected' => ''];
        foreach ($this->set->label->settings['columns'] ?? [] as $column) {
            $columns[] = $column;
        }
        $this->columns = $columns;

        return view('livewire.set-form');
    }

    public function generatePDF(): void
    {
        GeneratePDFJob::dispatch($this->set);
        $this->dispatch('showSuccess', 'PDF generation added to queue, you should receive email shortly!');
    }

    public function hide(): void
    {
        $this->previewLink = false;
    }

    public function previewPDF(): void
    {
        // $this->previewLink = route('labels.preview', ['set' => $this->set->id]);
        $this->dispatch('openLink', route('labels.preview', ['set' => $this->set->id]));
    }

    public function openWebPage(): void
    {
        $this->dispatch('openLink', route('labels.generate', ['set' => $this->set->id]));
    }

    public function destroy(): void
    {
        $this->set->delete();
        $this->dispatch('setDeleted');
    }

    public function addField(): void
    {
        $field = new Field();
        $field->name = 'Field '.$this->set->fields->count() + 1;
        $field->display_name = $field->name;
        $field->type = 'Text';
        $field->settings = [
            'font' => 'Roboto',
            'type' => 'Regular',
            'size' => '15',
            'hideLabels' => false
        ];
        $field->sequence = $this->set->fields()->count() + 1;
        $this->set->fields()->save($field);
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->set->refresh();
    }
}
