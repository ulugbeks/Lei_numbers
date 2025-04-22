<?php

namespace App\Helpers;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class MenuHelper
{
    /**
     * Render a menu by name or location
     *
     * @param string $identifier Menu name or location
     * @param string $view View template to use for rendering
     * @return string|null
     */
    public static function render($identifier, $view = 'partials.menu')
    {
        // Try to find menu by name first
        $menu = Menu::where('name', $identifier)
            ->where('active', true)
            ->first();
            
        // If not found by name, try by location
        if (!$menu) {
            $menu = Menu::where('location', $identifier)
                ->where('active', true)
                ->first();
        }
        
        if (!$menu) {
            return null;
        }
        
        // Cache menu items for performance
        $cacheKey = "menu_{$menu->id}_items";
        $menuItems = Cache::remember($cacheKey, now()->addHour(), function () use ($menu) {
            return $menu->rootItems()
                ->with(['children' => function ($query) {
                    $query->where('active', true)->orderBy('order');
                }])
                ->where('active', true)
                ->get();
        });
        
        return view($view, compact('menu', 'menuItems'))->render();
    }
    
    /**
     * Clear menu cache
     *
     * @param int|null $menuId
     * @return void
     */
    public static function clearCache($menuId = null)
    {
        if ($menuId) {
            Cache::forget("menu_{$menuId}_items");
        } else {
            // Get all menu IDs and clear their caches
            $menuIds = Menu::pluck('id')->toArray();
            foreach ($menuIds as $id) {
                Cache::forget("menu_{$id}_items");
            }
        }
    }
}