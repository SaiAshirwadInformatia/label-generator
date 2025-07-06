<?php

namespace App\Livewire\Forms;

use App\Models\Set;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Form;

class SetFormData extends Form
{

    #[Validate('required')]
    public string $name = '';

    #[Validate('required')]
    public string $type = '';

    #[Validate('nullable')]
    public ?string $columnName = '';

    #[Validate('nullable|numeric')]
    public ?int $limit = null;

    #[Validate('nullable|numeric')]
    public ?int $incremental = null;

    #[Validate('nullable|numeric')]
    public ?int $header_width = null;

    #[Validate('nullable|numeric')]
    public ?int $header_font = null;

    #[Validate('nullable|array')]
    public array $settings = [
        'columns' => [],
        'differentPage' => false,
        'fragile' => false,
        'filter' => null,
        'hideLabels' => false,
    ];

}
