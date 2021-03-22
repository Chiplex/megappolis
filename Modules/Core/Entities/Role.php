<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'user_id'];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\RoleFactory::new();
    }
}
