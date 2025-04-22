<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'title',
        'url',
        'route_name',
        'icon',
        'target',
        'parent_id',
        'order',
        'active',
    ];

    /**
     * Get the menu that this item belongs to
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the parent menu item
     */
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get the child menu items
     */
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    /**
     * Check if the menu item has children
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get the URL for this menu item
     */
    public function getUrlAttribute($value)
    {
        if ($this->route_name) {
            return route($this->route_name);
        }
        
        return $value ?: '#';
    }

    /**
     * Active menu items
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}