<?php

if (!function_exists('accessibleRoute')) {
      function accessibleRoute($name, $parameters = [], $absolute = true)
      {
            if (auth()->check() && !auth()->user()->hasPermissionRouteName($name)) {
                  return '#';
            }

            return route($name, $parameters, $absolute);
      }
}
