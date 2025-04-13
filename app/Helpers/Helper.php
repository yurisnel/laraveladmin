<?php

namespace App\Helpers;

class Helper
{
      public static function getBrowser()
      {
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                  $userAgent = $_SERVER['HTTP_USER_AGENT'];
                  $browserPattern = '/(Firefox|Chrome|Safari|Opera)[\/\s](\d+(\.\d+)*)/';

                  if (preg_match($browserPattern, $userAgent, $matches)) {
                        return $matches[1];
                  }
            }

            return 'unknown';
      }

      public static function getSO()
      {
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                  $userAgent = $_SERVER['HTTP_USER_AGENT'];

                  $soPattern = '/(Windows NT|Windows|Macintosh|Linux|iPhone|iPad|Android)/';

                  if (preg_match($soPattern, $userAgent, $matches)) {
                        return $matches[1];
                  }
            }
            return 'unknown';
      }

      public static function accessibleRoute($name, $parameters = [], $absolute = true)
      {
            if (auth()->check() && !auth()->user()->hasPermissionRouteName($name)) {
                  return '#';
            }

            return route($name, $parameters, $absolute);
      }
}
