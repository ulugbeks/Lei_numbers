<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $content = json_decode($page->content, true) ?: [];
        
        return view('admin.pages.edit', compact('page', 'content'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $content = json_decode($page->content, true) ?: [];
        
        // Обработка баннера для главной страницы
        if ($page->slug === 'home') {
            $content['banner'] = [
                'title' => $request->input('banner_title'),
                'description' => $request->input('banner_description'),
                'button_text' => $request->input('banner_button_text'),
                'button_url' => $request->input('banner_button_url')
            ];
            
            // Обработка изображений
            if ($request->hasFile('banner_background_image')) {
                $path = $request->file('banner_background_image')->store('pages/home', 'public');
                $content['banner']['background_image'] = $path;
            }
            
            if ($request->hasFile('banner_main_image')) {
                $path = $request->file('banner_main_image')->store('pages/home', 'public');
                $content['banner']['main_image'] = $path;
            }
        }
        
        $page->content = json_encode($content);
        $page->save();
        
        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully');
    }
    
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('pages/editor', 'public');
            $url = Storage::url($path);
            
            return response()->json([
                'uploaded' => 1,
                'fileName' => basename($path),
                'url' => $url
            ]);
        }
        
        return response()->json(['uploaded' => 0]);
    }
}