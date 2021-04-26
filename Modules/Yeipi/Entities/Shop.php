<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Delivery;
use Modules\Yeipi\Entities\Contract;
use Modules\Yeipi\Entities\Provider;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Stock;
use Modules\Yeipi\Entities\Product;
use Modules\Yeipi\Entities\Detail;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'latitud',
        'longitud',
        'abre',
        'cierra',
        'provider_id'
    ];
    
    protected $table = 'yeipi_shops';

    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\ShopFactory::new();
    }

    /**
     * Get the provider that owns the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Get all of the stocks for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * The products that belong to the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, Stock::class)->withPivot('precio', 'stock', 'medida');
    }

    /**
     * Get all of the sales for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function sales()
    {
        return $this->hasManyThrough(Detail::class, Stock::class);
    }
}
