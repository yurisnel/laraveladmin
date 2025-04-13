<?php

namespace App\Traits;

use App\Models\Logs\LogEvent;
use Illuminate\Database\Eloquent\Model;


trait ModelEventLogger
{

      public static function bootModelEventLogger()
      {

            foreach (static::getRecordActivityEvents() as $eventName) {

                  static::$eventName(function (Model $model) use ($eventName) {
                        $user = auth()->user();
                        if ($user) {
                              //$reflect = new \ReflectionClass($model);
                              $data = [
                                    //'loggable_id'   => $model->id,
                                    // 'loggable_type' => $reflect->getShortName()/*get_class($model)*/,
                                    'event_name'     => $eventName,
                                    'description' => ucfirst(__($eventName)) . "  " . $model->__toString() /*$reflect->getShortName()*/,
                                    'data'     => json_encode($model->getDirty())
                              ];
                              if ($eventName == 'updated') {
                                    $original = array_intersect_key($model->getOriginal(), $model->getDirty());
                                    //unset($original['updated_at']);
                                    $data['original'] = json_encode($original);
                              }
                              //LogEvent::create($data);
                              $log = new LogEvent($data);
                              $model->logs()->save($log);
                        }
                  });
            }
      }

      protected static function getRecordActivityEvents()
      {
            if (isset(static::$recordEvents)) {
                  return static::$recordEvents;
            }

            return [
                  'created',
                  'updated',
                  'deleted',
            ];
      }


      public function logs()
      {
            return $this->morphMany(LogEvent::class, 'loggable')->orderBy('created_at', 'desc');
      }
}
