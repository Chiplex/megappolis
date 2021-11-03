<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Product;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Detail;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'yeipi_stocks';

    protected $fillable = [
        'id',
        'product_id',
        'shop_id',
        'precio',
        'stock',
        'medida'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\StockFactory::new();
    }

    /**
     * Get the product that owns the Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the shop that owns the Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the details that owns the Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}
