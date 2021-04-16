<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Delivery;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'yeipi_contracts';

    protected $fillable = [
        'shop_id',
        'delivery_id',
        'comienza',
        'acaba'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\ContractFactory::new();
    }

    /**
     * Get the shop that owns the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the delivery that owns the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
