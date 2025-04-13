<?php

namespace App\Models\Access;

use App\Models\Access\Route;
use App\Traits\ModelCommon;
use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes, ModelEventLogger, ModelCommon;

    protected $fillable = [
        'name',
        'parent_id',
        'icon',
        'url',
        'route_id',
        'state',
    ];

    public $appends = [
        'href', 'full_name', 'to_string'
    ];

    public function __toString()
    {
        return sprintf("el menu %s ", $this->name);
    }

    public function getHrefAttribute()
    {
        $route = $this->route()->first();
        if ($route) {
            return route($route->route);
        }
        if ($this->url) {
            return url($this->url);
        }
        return "#";
    }

    public function getFullNameAttribute()
    {
        $name = $this->name;
        return $this->parent ? './' . $this->parent->name . '/' . $name : './' . $name;
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->where('state', 1)->orderBy('position', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
