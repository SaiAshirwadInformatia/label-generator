<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Exclude
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Exclude newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exclude newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exclude query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exclude whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exclude whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exclude whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exclude whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exclude whereUserId($value)
 * @mixin \Eloquent
 */
class Exclude extends Pivot
{
    protected $fillable = [ 'name' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
