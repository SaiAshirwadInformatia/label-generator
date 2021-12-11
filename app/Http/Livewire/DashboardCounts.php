<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DashboardCounts extends Component
{
    public $labels, $sets, $fields, $downloads, $excludes;

    public function mount()
    {
        $user = auth()->user();
        $this->labels = $user->labels()->count();
        $this->sets = $user->sets()->count();
        $this->fields = $user->fields()->count();
        $this->downloads = $user->downloads()->count();
        $this->excludes = $user->excludes()->count();
    }

    public function render()
    {
        return view('livewire.dashboard-counts');
    }
}
