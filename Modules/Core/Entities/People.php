<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Yeipi\Entities\Customer;

class People extends Model
{
    use HasFactory;

    protected $table = 'peoples';

    protected $fillable = [
        'tipo',
        'name',
        'otherName',
        'lastName',
        'otherLastName',
        'dateBirth',
        'country',
        'city',
        'phone',
        'sex',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\PeopleFactory::new();
    }

    public function getNameComplete()
    {
        return $this->name . ' ' . $this->otherName . ' ' . $this->lastName . ' ' . $this->otherLastName;
    }

    /**
     * Get the users for the people.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the customer associated with the People
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
    
}
