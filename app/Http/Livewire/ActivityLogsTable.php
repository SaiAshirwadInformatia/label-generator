<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityLogsTable extends Component
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
        $query = Activity::query();

        /**
         * @var User
         */
        $loggedUser = auth()->user();
        if (!$loggedUser->isAdmin()) {
            $query = Activity::causedBy($loggedUser);
        }

        $query->latest();

        return view('livewire.activity-logs-table', [
            'activity_logs' => $query->paginate($this->limit),
        ]);
    }

    public function subjectDisplay(Activity $log)
    {
        $display = $log->subject_type.' ('.$log->subject_id.')';
        if (isset($log->subject?->name) && $log->subject_type != 'App\Models\Field') {
            return '<span title="'.$display.'">'.$log->subject->name.'</span>';
        }

        return $display;
    }
}
