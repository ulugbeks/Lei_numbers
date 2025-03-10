<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'image', 'published_at', 'author_name', 'author_link', 'status'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getFormattedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M, Y') : 'Not Published';
    }

    // Автоматически создаем slug из title, если не передан
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }
}

