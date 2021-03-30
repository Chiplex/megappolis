<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\Role;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'page_id', 'name'];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\PermissionFactory::new();
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
