<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class App extends Model
{
    use HasFactory;

    protected $fillable = [];
        
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
}
