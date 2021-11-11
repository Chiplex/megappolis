<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\App;
use Modules\Core\Entities\Permission;
use Modules\Core\Entities\Role;

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

    /**
     * Get the persmisions that owns the Page
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Get the roles that owns the Page
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Build the View
     * 
     * @return string
     */
    public function buildView()
    {
        return $this->app->name.'::'.$this->controller.'\\'.$this->action;
    }

    /**
     * Build the title of the page
     * 
     * @return string
     */
    public function buildTitle()
    {
        return $this->name;
    }

    /**
     * Build the url of the page
     * 
     * @return string
     */
    public function buildUrl()
    {
        return $this->app->name.'/'.$this->controller.'/'.$this->action;
    }

    /**
     * Build the breadcrumbs as tree of the page and return it as an array
     * 
     * @return array
     */
    public function buildBreadcrumbs($currentPage)
    {
        // $breadcrumbs = [];
        // if($currentPage->type == 'page'){
        //     $breadcrumbs[] = [
        //         'name' => $currentPage->name,
        //         'url' => "#",
        //         'active' => false
        //     ];
        // }
        // else{
        //     $breadcrumbs[] = [
        //         'url' => $this->buildUrl(),
        //         'name' => $this->name,
        //         'active' => $currentPage->id == $this->id
        //     ];
        // }
        
        // if ($currentPage->id != null) {
        //     $page = Page::firstWhere('page_id', $this->page_id);
        //     if ($page != null) {
        //         $breadcrumbs = array_merge($breadcrumbs, $this->buildBreadcrumbs($page));
        //     }
        // }

        // return $breadcrumbs;

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => ucfirst($this->app->name),
            'url' => '/yeipi',
            'active' => false
        ];
        $breadcrumbs[] = [
            'name' => $this->name,
            'url' => $this->buildUrl(),
            'active' => true
        ];
        return $breadcrumbs;
    }
    
    /**
     * Scope a query to only include pages of a given type.
     * 
     * @return string
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
