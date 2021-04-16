<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Customer;
use Modules\Yeipi\Entities\Contract;
use Modules\Yeipi\Entities\Detail;

class Order extends Model
{
    use HasFactory;

    protected $table = 'yeipi_orders';

    protected $fillable = [
        'customer_id',
        'contract_id',
        'fechaSolicitud',
        'fechaRecepcion',
        'fechaSalida',
        'fechaEntrega',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\OrderFactory::new();
    }

    /**
     * Get the customer that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the contract that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Get all of the details for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function scopeLastest()
    {
        return $this->orderBy('created_at', 'desc');
    }

    public function scopeNoDeliveries()
    {
        return $this->whereNull('fechaEntrega');
    }
}
