<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Label fields are customized columns of excel that represent as individual field
 *
 * @property string $name
 * @property string $display_name
 * @property string $type
 * @property string $default
 * @property array $settings
 * @property Label $label
 */
class Field extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'type', 'default', 'settings'];

    /**
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * @return mixed
     */
    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}
