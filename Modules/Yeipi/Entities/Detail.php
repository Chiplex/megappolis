<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Order;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'descripcion',
        'cantidad',
        'precio',
        'fechaPreparacion'
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
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
