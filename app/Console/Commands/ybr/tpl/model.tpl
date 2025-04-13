<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelCommon;
use App\Traits\ModelEventLogger;

class NAME_MODEL extends Model
{
   use HasFactory, SoftDeletes, ModelEventLogger, ModelCommon;
   
   protected $fillable = array(FILLABLE);

   public $appends = [
      'to_string'
   ];
   
   public function __toString()
   {
      return sprintf("el NAME_MODEL %s", $this->name);
   }
}
