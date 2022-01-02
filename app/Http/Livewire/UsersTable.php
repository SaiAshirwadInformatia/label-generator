<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
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
        return view('livewire.users-table', [
            'users' => User::withCount('labels', 'sets', 'downloads')->paginate($this->limit),
        ]);
    }
}
