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
 * @property array $styles
 * @property User $user
 * @property Collection|LabelField[] $fields
 * @property Collection|LabelReady[] $readies
 * @property Collection|LabelRow[] $rows
 * @property Collection|LabelDownload[] $downloads
 * @property Carbon $started_at
 * @property Carbon $completed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Label extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'styles'];

    /**
     * @var array
     */
    protected $casts = [
        'styles'       => 'array',
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

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
    public function fields()
    {
        return $this->hasMany(LabelField::class);
    }

    /**
     * @return mixed
     */
    public function rows()
    {
        return $this->hasMany(LabelRow::class);
    }

    /**
     * @return mixed
     */
    public function readies()
    {
        return $this->hasMany(LabelReady::class);
    }

    /**
     * @return mixed
     */
    public function downloads()
    {
        return $this->hasMany(LabelDownload::class);
    }
}
