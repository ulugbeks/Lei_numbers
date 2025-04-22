<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Page;

class Seo extends Component
{
    /**
     * Page instance
     * 
     * @var Page|null
     */
    public $page;
    
    /**
     * Page title
     * 
     * @var string
     */
    public $title;
    
    /**
     * Page description
     * 
     * @var string|null
     */
    public $description;
    
    /**
     * OG Image URL
     * 
     * @var string
     */
    public $ogImage;
    
    /**
     * Canonical URL
     * 
     * @var string
     */
    public $canonicalUrl;
    
    /**
     * No Index flag
     * 
     * @var bool
     */
    public $noIndex;
    
    /**
     * No Follow flag
     * 
     * @var bool
     */
    public $noFollow;

    /**
     * Create a new component instance.
     *
     * @param  Page|null  $page
     * @param  string|null  $title
     * @param  string|null  $description
     * @param  string|null  $ogImage
     * @param  string|null  $canonicalUrl
     * @param  bool  $noIndex
     * @param  bool  $noFollow
     * @return void
     */
    public function __construct(
        $page = null,
        $title = null,
        $description = null,
        $ogImage = null,
        $canonicalUrl = null,
        $noIndex = false,
        $noFollow = false
    ) {
        $this->page = $page;
        
        // Always ensure title has a value
        $this->title = $title ?? ($page && $page->meta_title ? $page->meta_title : config('app.name', 'Laravel'));
        
        $this->description = $description ?? ($page && $page->meta_description ? $page->meta_description : null);
        
        // Ensure og_image has a default
        $defaultOgImage = asset('assets/img/default-og-image.jpg');
        $this->ogImage = $ogImage ?? ($page && $page->og_image ? asset('storage/' . $page->og_image) : $defaultOgImage);
        
        $this->canonicalUrl = $canonicalUrl ?? ($page && method_exists($page, 'getCanonicalUrl') ? $page->getCanonicalUrl() : url()->current());
        $this->noIndex = $noIndex || ($page && isset($page->no_index) && $page->no_index);
        $this->noFollow = $noFollow || ($page && isset($page->no_follow) && $page->no_follow);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.seo');
    }
}