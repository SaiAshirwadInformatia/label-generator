<?php

namespace App\View\Components\Icon;

use Illuminate\View\Component;

abstract class BaseIcon extends Component
{
    public $class;

    /**
     * Create a new component instance.
     *
     * @param mixed $class
     *
     * @return void
     */
    public function __construct($class = '')
    {
        $this->class = $class;
        // add default classes if missed
        $missingClass = ['w-' => 'w-6', 'h-' => 'h-6', 'inline-block' => 'inline-block', 'mr-' => 'mr-1'];
        array_walk(
            $missingClass,
            fn ($v, $k) => strpos($this->class, $k) === false ? $this->class .= " $v " : ''
        );
    }
}
