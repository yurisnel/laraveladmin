<?php

namespace App\Models\Logs;



class LogEvent extends Log
{
      //use TransformableTrait;

      public $appends = [
            'table_name', 'creator_full_name', 'to_string',
      ];

      protected $fillable = [
            'loggable_type',
            'loggable_id',
            'created_user_id',
            'event_name',
            'description',
            'data',
            'original',
            'ip',
            'browser',
            'so'
      ];


      public function loggable()
      {
            return $this->morphTo();
      }

      public function getTableNameAttribute()
      {
            $pos = strrpos($this->loggable_type, "\\");
            return __(substr($this->loggable_type, $pos + 1));
      }
}
