<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class People extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\PeopleFactory::new();
    }

    /**
     * Get the users for the people.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
