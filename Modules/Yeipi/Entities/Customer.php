<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Order;
use Modules\Core\Entities\People;
use Modules\Yeipi\Entities\Contract;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'yeipi_customers';

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
    
    /**
     * Get the People that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function people()
    {
        return $this->belongsTo(People::class);
    }

    /**
     * Get the contract that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
