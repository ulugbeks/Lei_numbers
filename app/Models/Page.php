<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sections',
        'status',
        'meta_title',
        'meta_description',
        'og_title',       // Open Graph title
        'og_description', // Open Graph description
        'og_image',       // Open Graph image path
        'og_type',        // Open Graph type
        'twitter_card',   // Twitter card type
        'canonical_url',  // Custom canonical URL
        'no_index',       // No-index flag for search engines
        'no_follow',      // No-follow flag for search engines
        'structured_data', // JSON-LD structured data
    ];

    protected $casts = [
        'sections' => 'array',
        'status' => 'boolean',
        'no_index' => 'boolean',
        'no_follow' => 'boolean',
        'structured_data' => 'array'
    ];
    
    /**
     * Get fully qualified canonical URL
     * 
     * @return string
     */
    public function getCanonicalUrl()
    {
        if (!empty($this->canonical_url)) {
            return $this->canonical_url;
        }
        
        return url($this->slug === 'home' ? '/' : '/' . $this->slug);
    }
    
    /**
     * Get robots meta tag content
     * 
     * @return string|null
     */
    public function getRobotsContent()
    {
        $directives = [];
        
        if ($this->no_index) {
            $directives[] = 'noindex';
        } else {
            $directives[] = 'index';
        }
        
        if ($this->no_follow) {
            $directives[] = 'nofollow';
        } else {
            $directives[] = 'follow';
        }
        
        return !empty($directives) ? implode(', ', $directives) : null;
    }
}