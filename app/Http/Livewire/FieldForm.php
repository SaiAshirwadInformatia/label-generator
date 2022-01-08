<?php

namespace App\Http\Livewire;

use App\Models\Field;
use App\Models\Set;
use Livewire\Component;
use Log;

class FieldForm extends Component
{
    public Set $set;

    public Field $field;

    public array $columns;

    public bool $isLast;

    protected $rules = [
        'field.name' => 'required',
        'field.display_name' => 'required',
        'field.type' => 'required',
        'field.default' => 'nullable',
        'field.settings.font' => 'required',
        'field.settings.type' => 'required',
        'field.settings.size' => 'required'
    ];

    public function updating($propertyName, $value)
    {
        $propertyName = str_replace('field.', '', $propertyName);
        if (
            $propertyName == 'name' && (empty(trim($this->field->display_name)) ||
                str_starts_with($this->field->display_name, 'Field ') ||
                $this->field->display_name == $this->columns[$this->field->name]
            )
        ) {
            $this->field->display_name = $this->columns[$value];
        }
    }

    public function updated($propertName)
    {
        if ($this->field->type == 'EmptyRow') {
            $this->field->display_name = 'EmptyRow';
        }
        $this->field->save();
    }

    public function render()
    {
        $columns = ['NotSelected' => 'No Column'];
        foreach ($this->field->set->label->settings['columns'] as $index => $column) {
            $columns[$index] = $column;
        }
        $this->columns = $columns;

        return view('livewire.field-form', [
            'fontsConfig' => config('sai.fonts'),
            'fieldTypes' => config('sai.fieldTypes'),
        ]);
    }

    public function destroy()
    {
        $this->field->delete();
        $this->emit('refreshSet');
    }

    public function moveUp()
    {
        $sequence = $this->field->sequence;
        if ($sequence == 1) {
            return;
        }

        $sequence--;

        $this->set->fields()->where('sequence', $sequence)->update([
            'sequence' => $this->field->sequence
        ]);

        $this->field->sequence = $sequence;
        $this->field->save();
        $this->emit('refreshSet');
    }

    public function moveDown()
    {
        $sequence = $this->field->sequence;
        if ($sequence == $this->set->fields->count()) {
            return;
        }

        $sequence++;

        $this->set->fields()->where('sequence', $sequence)->update([
            'sequence' => $this->field->sequence
        ]);

        $this->field->sequence = $sequence;
        $this->field->save();
        $this->emit('refreshSet');
    }
}
