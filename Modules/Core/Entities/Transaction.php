<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'user_id',
        'date',
        'value',
        'type',
        'transaction_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\TransactionFactory::new();
    }
}
