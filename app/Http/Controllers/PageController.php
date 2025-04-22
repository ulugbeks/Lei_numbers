<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    /**
     * Display the homepage
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $page = Page::where('slug', 'home')->where('status', true)->firstOrFail();
        $content = json_decode($page->content, true) ?: [];
        
        return view('index', compact('page', 'content'));
    }

    /**
     * Display specific named pages
     * 
     * @param string $pageName
     * @return \Illuminate\View\View 
     */
    public function showNamedPage($pageName)
    {
        $page = Page::where('slug', $pageName)
                   ->where('status', true)
                   ->firstOrFail();
        
        $content = json_decode($page->content, true) ?: [];
        
        // Determine the view template based on the slug
        $viewTemplate = 'pages.' . $pageName;
        
        return view($viewTemplate, compact('page', 'content'));
    }
    
    /**
     * Show the about page
     * 
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return $this->showNamedPage('about');
    }
    /**
     * Show the about page
     * 
     * @return \Illuminate\View\View
     */
    public function cookies()
    {
        return $this->showNamedPage('cookies');
    }

    /**
     * Show the about page
     * 
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return $this->showNamedPage('privacy-policy');
    }

    /**
     * Show the about page
     * 
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return $this->showNamedPage('terms-and-conditions');
    }
    
    /**
     * Show the contact page
     * 
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return $this->showNamedPage('contact');
    }
    
    /**
     * Show the about LEI page
     * 
     * @return \Illuminate\View\View
     */
    public function aboutLei()
    {
        return $this->showNamedPage('about-lei');
    }
    
    /**
     * Show the LEI registration page
     * 
     * @return \Illuminate\View\View
     */
    public function registrationLei()
    {
        return $this->showNamedPage('registration-lei');
    }
    
    /**
     * Display any other page by its slug
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug = null)
    {
        // If no slug provided, check the current path
        if ($slug === null) {
            $slug = request()->path();
            $slug = $slug === '/' ? 'home' : $slug;
        }
        
        // Find the page by slug
        $page = Page::where('slug', $slug)->where('status', true)->first();
        
        // If no page found, 404
        if (!$page) {
            abort(404);
        }
        
        $content = json_decode($page->content, true) ?: [];
        
        // Determine which view to use based on slug
        $view = 'pages.' . $page->slug;
        
        // Check if the view exists, fall back to a generic page view if not
        if (!View::exists($view)) {
            $view = 'pages.default';
        }
        
        return view($view, compact('page', 'content'));
    }
}