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
 * @property Set $set
 * @property int $id
 * @property int $set_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Field query()
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereUpdatedAt($value)
 * @mixin \Eloquent
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
    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function css()
    {
        $css = [];
        $font = 'font-family: ' . $this->settings['font'];
        $font .= '-' . $this->settings['type'];
        $css[] = strtolower($font);
        if (isset($this->settings['size'])) {
            $css[] = 'font-size: ' . $this->settings['size'] . 'px';
        }
        // if (isset($this->settings['color'])) {
        //     $css[] = 'color:' . (str_starts_with($this->settings['color'], '#') ? '' : '#') . $this->settings['color'];
        // }
        // if (isset($this->settings['background-color'])) {
        //     $css[] = 'background-color:' . (str_starts_with($this->settings['background-color'], '#') ? '' : '#') . $this->settings['background-color'];
        // }
        return implode(';', $css);
    }
}
