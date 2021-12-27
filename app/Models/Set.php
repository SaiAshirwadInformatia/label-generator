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
 * @property int $id
 * @property int $label_id
 * @property string $name
 * @property int $type
 * @property string|null $columnName
 * @property bool $is_downloaded
 * @property array|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $fields_count
 * @method static \Illuminate\Database\Eloquent\Builder|Set newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Set newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Set query()
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereColumnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereIsDownloaded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereLabelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Set whereUpdatedAt($value)
 * @mixin \Eloquent
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
