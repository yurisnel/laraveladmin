<?php

namespace App\Models\Access;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Access\Role;
use App\Models\Access\Route;
use App\Models\Client;
use Exception;
use App\Exceptions\ExceptionCustom;
use App\Jobs\QueuedSendNotificationsJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Route as RouteLaravel;
use App\Traits\ModelCommon;
use App\Traits\ModelEventLogger;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Response;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelEventLogger, ModelCommon;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fathername',
        'mothername',
        'dni',
        'state',
        'role_id',
        'created_user_id',
    ];
    public $appends = [
        'full_name',
        'role_name',
        'creator_full_name',
        'to_string'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->fathername . ' ' . $this->mothername;
    }

    public function __toString()
    {
        return sprintf("el usuario %s con dni %s ", $this->full_name, $this->dni);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function getRoleNameAttribute()
    {
        return $this->role ? $this->role->name : '';
    }

    public function hasRoleName($role)
    {
        //return $this->roles()->where('name', $role)->exists();      
        return ($this->getRoleNameAttribute() == $role) ? true : false;
    }
    public function hasRoleId($role_id)
    {
        return ($this->role && $this->role->id == $role_id) ? true : false;
    }

    public function hasPermission($permission)
    {
        return $this->role->whereHas('permissions', function ($query) use ($permission) {
            $query->where('role_permission.role_id', $this->role_id);
            $query->where('name', $permission);
        })->exists();
    }

    public function getPermissions()
    {
        return $this->role->permissions()->select(['permissions.id', 'description', 'name'])->get();
    }

    public function hasPermissionRouteName($routeName)
    {
        if ($routeName) {
            $modelRoute = Route::where('route', $routeName)->first();
            if ($modelRoute) {
                return $this->hasPermissionRoute($modelRoute);
            }
        }
        return true;
    }

    public function hasPermissionRouteId($routeId)
    {
        if ($routeId) {
            $modelRoute = Route::find($routeId);
            if ($modelRoute) {
                return $this->hasPermissionRoute($modelRoute);
            }
        }
        return true;
    }

    private function hasPermissionRoute($modelRoute)
    {
        $permissions = $this->role->permissions;
        return $modelRoute->state != 0 &&
            $modelRoute->permission->state != 0 &&
            in_array($modelRoute->permission->id, $permissions->pluck('id')->toArray());
    }


    public function hasPermissionUrl($url)
    {
        try {
            $routes = RouteLaravel::getRoutes();
            $routeCurrent = Request::create($url);
            $route = $routes->match($routeCurrent);

            /*$path = ltrim(parse_url($url, PHP_URL_PATH), '/');
            $exists = collect($routes)->contains(function ($route) use ($path) {
                return $route->uri() === $path;
            });
            return $exists;*/

            if ($route) {
                $routeName = $route->getName();
                return $this->hasPermissionRouteName($routeName);
            }
        } catch (Exception $exception) {
            throw new ExceptionCustom($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }



        return true;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        QueuedSendNotificationsJob::dispatchIfEnableWork($this, new ResetPassword($token));
        //$this->notify(new ResetPasswordQueue($token));
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_users');
    }
}
