<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\Permission;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'user_id'];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\RoleFactory::new();
    }

    /**
     * The roles that belong to the pages.
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class, Permission::class);
    }

    /**
     * Get the permissions for the role.
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
