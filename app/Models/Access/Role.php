<?php

namespace App\Models\Access;

use App\Models\Access\Permission;
use App\Models\Access\User;
use App\Traits\ModelCommon;
use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes, ModelEventLogger, ModelCommon;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    //protected $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'state',
    ];

    public $appends = [
        'creator_full_name', 'to_string'
    ];
    
    public function __toString()
    {
        return sprintf("el role %s ", $this->name);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
