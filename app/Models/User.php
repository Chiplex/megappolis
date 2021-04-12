<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Core\Entities\Role;
use Modules\Core\Entities\App;
use Modules\Core\Entities\People;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'people_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users')->withTimestamps();
    }

    /**
     * Get the apps for the user.
     */
    public function apps()
    {
        return $this->hasMany(App::class);
    }

    /**
     * Get the people associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function people()
    {
        return $this->belongsTo(People::class);
    }
}
