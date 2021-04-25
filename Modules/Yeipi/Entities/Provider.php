<?php

namespace Modules\Yeipi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Yeipi\Entities\Shop;
use Modules\Core\Entities\People;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'people_id'
    ];

    protected $table = 'yeipi_provider';
    
    protected static function newFactory()
    {
        return \Modules\Yeipi\Database\factories\ProviderFactory::new();
    }

    /**
     * Get all of the shops for the Provider
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    /**
     * Get the people that owns the Provider
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function people()
    {
        return $this->belongsTo(People::class);
    }
}
