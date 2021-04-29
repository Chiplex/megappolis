<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Order;

class Detail extends Model
{
    use HasFactory;

    protected $table = 'yeipi_details';
    
    protected $fillable = [
        'order_id',
        'descripcion',
        'cantidad',
        'precio',
        'fechaPreparacion',
        'fechaConseguido',
        'fechaNoConseguido',
        'stock_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\DetailFactory::new();
    }

    /**
     * Get the order that owns the Detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeOrdersDelivered()
    {
        return $this->order()->delivered();
    }

    public function scopeOrdersNoDelivered()
    {
        return $this->order()->noDelivered();
    }

    public function scopePreparando()
    {
        return $this->whereNull(['fechaConseguido', 'fechaNoConseguido']);
    }
}
