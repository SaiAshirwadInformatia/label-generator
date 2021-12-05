<?php

namespace App\Http\Livewire;

use App\Events\LabelCreated;
use App\Models\Label;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

/**
 *
 * @property TemporaryUploadedFile $path
 */
class LabelCreate extends Component
{
    use WithFileUploads;

    /**
     * @var mixed
     */
    public $name;
    /**
     * @var mixed
     */
    public $path;
    /**
     * @var mixed
     */
    public $settings = [];

    /**
     * @var array
     */
    public $rules = [
        'name' => 'required',
        'path' => 'mimes:csv,xls,xlsx',
    ];

    public function updatedPath()
    {
        $this->validate([
            'path' => 'mimes:csv,xls,xlsx',
        ]);
        $this->name = $this->path->getClientOriginalName();
    }

    public function submitForm()
    {
        $this->validate();

        $label           = new Label();
        $label->name     = $this->name;
        $label->path     = $this->path->store('/uploads', 'public');
        $label->settings = $this->settings;
        auth()->user()->labels()->save($label);

        event(new LabelCreated($label));

        return redirect()->route('labels.configure', [
            'label' => $label->id,
        ]);
    }

    public function render()
    {
        $this->page        = config('sai.page');
        $this->orientation = config('sai.orientation');
        return view('livewire.label-create', [
            'pageOptions'      => config('sai.pageOptions'),
            'pageOrientations' => config('sai.pageOrientations'),
        ]);
    }
}
