<?php

namespace App\Events;

use App\Models\Label;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LabelCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var mixed
     */
    public $label;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Label $label)
    {
        $this->label = $label;
    }

}
