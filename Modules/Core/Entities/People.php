<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\ModelStatus\HasStatuses;
use App\Models\User;
use Modules\Yeipi\Entities\Customer;
use Modules\Yeipi\Entities\Delivery;
use Modules\Yeipi\Entities\Provider;

class People extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'peoples';

    protected $fillable = [
        'tipo',
        'name',
        'otherName',
        'lastName',
        'otherLastName',
        'birth',
        'country',
        'city',
        'phone',
        'sex',
        'document',
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

    /**
     * Get the deliveries associated with the People
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    /**
     * Get all of the Provider for the People
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provider()
    {
        return $this->hasOne(Provider::class);
    }
}
