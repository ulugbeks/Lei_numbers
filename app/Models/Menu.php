<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'description',
        'active',
    ];

    /**
     * Get all menu items for this menu
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }

    /**
     * Get only the root level menu items
     */
    public function rootItems()
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->orderBy('order');
    }
}