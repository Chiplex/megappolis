<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Order;
use Modules\Yeipi\Entities\Stock;

class Detail extends Model
{
    use HasFactory;

    protected $table = 'yeipi_details';
    
    protected $fillable = [
        'order_id',
        'descripcion',
        'cantidad',
        'precio',
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

    /**
     * Get the stock that owns the Detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Scope a query to only include details that are in preparation 
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInPreparation()
    {
        return $this->whereNull(['fechaConseguido', 'fechaNoConseguido']);
    }
}
