<?php

namespace Tests\Feature\Livewire;

use App\Livewire\LabelTable;
use Livewire\Livewire;
use Tests\TestCase;

class LabelTableTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(LabelTable::class);

        $component->assertStatus(200);
    }
}
