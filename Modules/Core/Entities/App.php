<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class App extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'type', 'user_id'];
        
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\AppFactory::new();
    }

    /**
     * Get the pages for the app.
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get the app that owns the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
