<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\LabelTable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
