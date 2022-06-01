<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\Permission;
use Modules\Core\Entities\App;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'type', 'app_id'];

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

    /**
     * The roles that belong to the users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users')->withTimestamps();
    }

    /**
     * Get the app that owns the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
