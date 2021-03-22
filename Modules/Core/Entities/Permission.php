<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'page_id', 'name'];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\PermissionFactory::new();
    }
}
