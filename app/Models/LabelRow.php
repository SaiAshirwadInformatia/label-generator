<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelRow extends Model
{
    use HasFactory;

    /**
     * @return mixed
     */
    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}
