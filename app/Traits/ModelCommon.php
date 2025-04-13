<?php

namespace App\Traits;

use App\Models\Access\User;

trait ModelCommon
{
     
      public function getToStringAttribute()
      {
            return $this->__toString();
      }

      public function creator()
      {
            return $this->belongsTo(User::class, 'created_user_id', 'id');
      }

      public function getCreatorFullNameAttribute()
      {
            $creator = $this->creator()->first();
            return $creator ? $creator->full_name : "Sistema";
      }
}
