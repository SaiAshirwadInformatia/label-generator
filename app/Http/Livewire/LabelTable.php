<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class LabelTable extends Component
{
    use WithPagination;

    /**
     * @var mixed
     */
    public $limit;

    public function updatingLimit()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        return view('livewire.label-table', [
            'labels' => $user->labels()->latest()->paginate($this->limit),
        ]);
    }
}
