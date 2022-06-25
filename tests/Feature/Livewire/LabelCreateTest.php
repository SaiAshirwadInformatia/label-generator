<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\LabelCreate;
use Livewire\Livewire;

test('the_component_can_render', function () {

    $component = Livewire::test(LabelCreate::class);

    $component->assertStatus(200);

});
