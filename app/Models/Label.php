<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Labels are entities to track Label creation initiated by User
 *
 * @property string $name
 * @property string $path
 * @property array $settings
 * @property User $user
 * @property Collection|Set[] $sets
 * @property Collection|Field[] $fields
 * @property Collection|Download[] $downloads
 * @property Carbon $started_at
 * @property Carbon $completed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $id
 * @property int $user_id
 * @property-read int|null $downloads_count
 * @property-read int|null $fields_count
 * @property-read int|null $sets_count
 * @method static \Database\Factories\LabelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Label newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Label newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Label query()
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Label whereUserId($value)
 * @mixin \Eloquent
 */
class Label extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'settings'];

    /**
     * @var array
     */
    protected $casts = [
        'settings'     => 'array',
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $withCount = ['sets', 'fields', 'downloads'];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return mixed
     */
    public function sets()
    {
        return $this->hasMany(Set::class);
    }

    /**
     * @return mixed
     */
    public function fields()
    {
        return $this->hasManyThrough(Field::class, Set::class);
    }

    /**
     * @return mixed
     */
    public function downloads()
    {
        return $this->hasManyThrough(Download::class, Set::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
