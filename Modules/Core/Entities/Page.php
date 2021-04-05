<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\App;

class Page extends Model
{
    use HasFactory;

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
}
