<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Shop;
use Modules\Yeipi\Entities\Contract;
use Modules\Core\Entities\People;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'people_id',
        'puntuacion',
        'valoracion'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\DeliveryFactory::new();
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }

    public function contract()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the People that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function people()
    {
        return $this->belongsTo(People::class);
    }
}
