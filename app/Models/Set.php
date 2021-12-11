<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Set is a configuration within Label process for generating PDF's
 *
 * @property Label $label
 * @property Collection|Field[] $fields
 */
class Set extends Model
{
    use HasFactory;

    public const SINGLE  = 1;
    public const GROUPED = 2;

    /**
     * @var array
     */
    protected $fillable = ['name', 'type', 'columnName', 'settings'];

    /**
     * @var array
     */
    protected $casts = [
        'type'          => 'integer',
        'is_downloaded' => 'boolean',
        'settings'      => 'array',
    ];

    protected $with = ['fields'];

    /**
     * @return mixed
     */
    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    /**
     * @return mixed
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
