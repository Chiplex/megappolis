<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\App;

class Page extends Model
{
    use HasFactory;

    protected $table = "pages";

    protected $fillable = [
        'app_id',
        'controller',
        'action',
        'name',
        'type',
        'icon',
        'page_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\PageFactory::new();
    }

    /**
     * Get the app that owns the page.
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }

    /**
     * Get all of the pages for the Page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
    
    /**
     * Get the page that owns the Page
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function buildView()
    {
        return $this->app->name.'::'.$this->controller.'\\'.$this->action;
    }

    public function buildTitle()
    {
        return strtoupper($this->app->name).'-'.$this->name;
    }

    public function buildUrl()
    {
        return $this->app->name.'/'.$this->controller.'/'.$this->action;
    }
    
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
