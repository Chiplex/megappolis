<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\Page;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'page_id', 'name'];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\PermissionFactory::new();
    }

    public function pages()
    {
        return $this->belongsTo(Page::class);
    }
}
