<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ready
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $set_id
 * @property string $path
 * @property int|null $records
 * @property int|null $started_at
 * @property int|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Set|null $set
 * @property-read \App\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Ready newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ready newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ready query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ready whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ready whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ready whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ready wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ready whereRecords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ready whereSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ready whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ready whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ready whereUserId($value)
 * @mixin \Eloquent
 */
class Ready extends Model
{
    use HasFactory;

    protected $casts = [
        'started_at' => 'timestamp',
        'completed_at' => 'timestamp',
        'records' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function set()
    {
        return $this->belongsTo(Set::class);
    }
}
