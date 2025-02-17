<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Показ всех постов в админке
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(6);
        $recentBlogs = Blog::latest()->limit(5)->get();
        return view('pages.blog', compact('blogs', 'recentBlogs'));
    }

    /**
     * Показ формы для создания поста
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    public function blogList()
    {
        $blogs = Blog::where('status', 1)->orderBy('published_at', 'desc')->paginate(10);
        $recentBlogs = Blog::where('status', 1)->orderBy('published_at', 'desc')->limit(5)->get();

        return view('pages.blog', compact('blogs', 'recentBlogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
    
        // Получаем последние опубликованные блоги
        $recentBlogs = Blog::where('status', 1)
            ->where('id', '!=', $blog->id) // Исключаем текущий блог
            ->latest()
            ->limit(5)
            ->get();

        return view('pages.blog-details', compact('blog', 'recentBlogs'));
    }

    /**
     * Сохранение нового поста
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'published_at' => now(),
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
    }


    /**
     * Удаление блога
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully!');
    }
}
