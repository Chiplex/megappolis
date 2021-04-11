<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Order;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'people_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\CustomerFactory::new();
    }

    /**
     * Get the order for the customer.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
