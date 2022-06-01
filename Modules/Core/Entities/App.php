<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\Transactions;

class App extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'user_id',
        'description',
        'url',
    ];

    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\AppFactory::new();
    }

    /**
     * Get the modules for the app.
     */
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Get the app that owns the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the app.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'transaction_id');
    }
}
