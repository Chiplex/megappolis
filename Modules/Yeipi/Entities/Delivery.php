<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\People;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Contract;
use Modules\Yeipi\Entities\Order;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'yeipi_deliveries';

    protected $fillable = [
        'people_id',
        'puntuacion',
        'valoracion',
        'amount'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\DeliveryFactory::new();
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
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
     * The orders that belong to the Delivery
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
