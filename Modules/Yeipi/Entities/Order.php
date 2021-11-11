<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Customer;
use Modules\Yeipi\Entities\Contract;
use Modules\Yeipi\Entities\Detail;
use Modules\Yeipi\Entities\Stock;

class Order extends Model
{
    use HasFactory;

    protected $table = 'yeipi_orders';

    protected $fillable = [
        'customer_id',
        'delivery_id',
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
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
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

    /**
     * The Stock that belong to the Order.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stocks()
    {
        return $this->belongsToMany(Stock::class, Detail::class);
    }
    
    /**
     * Scope a query to only include last orders.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastest()
    {
        return $this->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to only include unsolicited orders 
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnsolicited()
    {
        return $this->where('fechaSolicitud', null);
    }

    /**
     * Scope a query to only include orders not received
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotReceived()
    {
        return $this->where('fechaRecepcion', null);
    }

    /**
     * Scope a query to only include non-exit orders 
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonExit()
    {
        return $this->where('fechaSalida', null);
    }

    /**
     * Scope a query to only include undelivered orders
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUndelivered()
    {
        return $this->where('fechaEntrega', null);
    }

    /**
     * Scope a query to only include delivered orders
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDelivered()
    {
        return $this->where('fechaEntrega', '!=', null);
    }
}
