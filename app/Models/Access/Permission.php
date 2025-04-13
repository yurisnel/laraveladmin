<?php

namespace App\Models\Access;

use App\Models\Access\Role;
use App\Models\Access\Route;
use App\Traits\ModelCommon;
use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes, ModelEventLogger, ModelCommon;
    //protected static $recordEvents = ['created'];

    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'state',
    ];

    public $appends = [
        'creator_full_name', 'to_string'
    ];

    public function __toString()
    {
        return sprintf("el permiso %s ", $this->name);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id', 'id')->where('state', 1);
    }

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    public static function assignToRole($permissionName, $roleName)
    {
        $roleSuperAdmin = Role::where('name', $roleName)->first();
        if ($roleSuperAdmin) {
            $permissions = Permission::where('name', 'like', "%$permissionName%")->get();
            foreach ($permissions as $permission) {
                $roleSuperAdmin->permissions()->attach($permission);
            }
        }
    }
}
