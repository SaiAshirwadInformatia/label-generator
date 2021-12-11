<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return mixed
     */
    public function labels()
    {
        return $this->hasMany(Label::class);
    }

    public function excludes()
    {
        return $this->hasMany(Exclude::class);
    }

    public function sets()
    {
        return $this->hasManyThrough(Set::class, Label::class);
    }

    public function fields()
    {
        return $this->sets()->join('fields', 'fields.set_id', '=', 'sets.id')
            ->select('fields.*')
            ->groupBy('fields.id');
    }

    public function downloads()
    {
        return $this->sets()->join('downloads', 'downloads.set_id', '=', 'sets.id')
            ->select('downloads.*')
            ->groupBy('downloads.id');
    }

    public function getTotalLabelsAttribute()
    {
    }
}
