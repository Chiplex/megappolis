<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Delivery;
use Modules\Yeipi\Entities\Contract;

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
    ];
    
    protected $table = 'yeipi_shops';

    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\ShopFactory::new();
    }

    /**
     * The deliveries that belong to the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class);
    }

    /**
     * Get all of the contracts for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
