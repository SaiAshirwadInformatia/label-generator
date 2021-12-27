<?php

namespace App\Http\Livewire;

use App\Models\Field;
use Livewire\Component;
use Log;

class FieldForm extends Component
{
    public Field $field;

    public array $columns;

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

    public function updated()
    {
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
        $this->emit('fieldDeleted');
    }
}
