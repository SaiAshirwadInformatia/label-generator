<?php

namespace App\View\Components\Icon;

use Closure;

class Lock extends BaseIcon
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render()
    {
        return view('components.icon.lock');
    }
}
