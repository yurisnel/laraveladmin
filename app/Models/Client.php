<?php

namespace App\Models;

use App\Traits\ModelCommon;
use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Client extends Model
{
    use HasFactory, SoftDeletes, ModelEventLogger, ModelCommon;

    protected $fillable = [
        'dni',
        'business_name',      
        'email',
        'telephone',
        'giro',
        'contact_name',
        'contact_telephone',
        'address',
        'description',
        'type',
        'state',
    ];

    public $appends = [
        'to_string'
    ];
    
    public function __toString()
    {
        return sprintf("la empresa %s ", $this->business_name);
    }

    public function users()
    {
        //return $this->belongsToMany(User::class, 'client_users');
    }
}
