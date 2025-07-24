<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class MenuHelper
{
    public static function isActiveMenu($menu)
    {
        $currentRoute = Route::currentRouteName();

        // Si el slug es string
        if (isset($menu->slug) && is_string($menu->slug)) {
            if (strpos($currentRoute, $menu->slug) === 0) {
                return true;
            }
        }

        // Si el slug es array
        if (isset($menu->slug) && is_array($menu->slug)) {
            foreach ($menu->slug as $slug) {
                if (strpos($currentRoute, $slug) === 0) {
                    return true;
                }
            }
        }

        // Revisa si alguno de los submenús está activo
        if (isset($menu->submenu)) {
            foreach ($menu->submenu as $submenu) {
                if (self::isActiveMenu($submenu)) {
                    return true;
                }
            }
        }

        return false;
    }
}
