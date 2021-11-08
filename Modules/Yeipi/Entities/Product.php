<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Stock;
use Modules\Yeipi\Entities\Shop;

class Product extends Model
{
    use HasFactory;

    protected $table = "yeipi_products";

    protected $fillable = [
        'id',
        'descripcion',
        'marca',
    ];

    protected $appends = [
        'descripcion_marca',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\ProductFactory::new();
    }

    /**
     * Get all of the stock for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * The shops that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shops()
    {
        return $this->belongsToMany(Shop::class, Stock::class);
    }

    /**
     * Get the Description and the Brand of the Product as attributes
     *
     * @return string
     */
    public function getDescripcionMarcaAttribute()
    {
        return $this->descripcion . ' - ' . $this->marca;
    }
}
