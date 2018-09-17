<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Route;

class Permission
{
    public static function  all()
    {
        $results = [];

        foreach (Route::getRoutes() as $route) {
            $temp = self::filterRoute($route);
            if ($temp and !in_array($temp, $results)) {
                $results[] = $temp;
            }
        }

        return $results;
    }

    public static function getKeyRoute($name)
    {
        if (strpos($name, '.') !== FALSE) {
            $routeKey = explode('.', $name);
            $meaning = config('routeMeaning');
            if (in_array($routeKey[0], array_keys($meaning))) {
                return $routeKey[0];
            }
        }
        return null;
    }

    protected static function filterRoute($route)
    {
        if (! in_array('acl', array_values($route->middleware()))) {
            return;
        }

        if (!self::getKeyRoute($route->getName())) {
            return;
        }
        $result = [
            'uri'    => $route->uri(),
            'name'   => self::getKeyRoute($route->getName()),
            'action' => $route->getActionName(),
        ];

        if ($result['action'] == 'Closure' || is_null($result['name'])) {
            return;
        }

        return $result['name'];
    }
}