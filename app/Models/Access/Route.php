<?php

namespace App\Models\Access;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Traits\ModelCommon;
use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use HasFactory, SoftDeletes, ModelEventLogger, ModelCommon;

    protected $fillable = [
        'route',
        'description',
        'permission_id',
        'parent_id',
        'linkable',
        'state',
    ];

    public $appends = [
        'creator_full_name', 'to_string'
    ];

    public function __toString()
    {
        return sprintf("la ruta %s ", $this->route);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function children()
    {
        return $this->hasMany(Route::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Route::class, 'parent_id');
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}
