<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_url', 'bio', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function prequestions(){

        return $this->hasMany('\App\PreQuestion', 'user_id');

    }

    public function questions(){

        return $this->hasMany('\App\Question', 'user_id');

    }


    public function answers(){

        return $this->hasMany('\App\Answer', 'user_id');

    }

    public function upvotes(){

        return $this->hasMany('\App\Upvote', 'user_id');

    }

    public function reported()
    {
        return $this->morphMany('\App\Report', 'reportable');
    }

    public function reports(){

        return $this->hasMany('\App\Report');

    }
    
}
