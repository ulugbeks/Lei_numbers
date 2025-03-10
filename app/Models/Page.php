<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sections',
        'status'
    ];

    protected $casts = [
        'sections' => 'array',
        'status' => 'boolean'
    ];
}