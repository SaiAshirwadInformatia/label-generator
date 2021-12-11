<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Exclude extends Pivot
{
    protected $fillable = [ 'name' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
