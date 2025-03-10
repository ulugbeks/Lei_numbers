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
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_name' => 'nullable|string|max:255',
            'author_link' => 'nullable|url',
            'published_at' => 'required|date'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'author_name' => $request->author_name,
            'author_link' => $request->author_link,
            'status' => $request->status ?? 0,
            'published_at' => $request->published_at
        ]);

        return back()->with('success', 'Blog created successfully');
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_name' => 'nullable|string|max:255',
            'author_link' => 'nullable|url',
            'published_at' => 'required|date'
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'author_name' => $request->author_name,
            'author_link' => $request->author_link,
            'status' => $request->status ?? 0,
            'published_at' => $request->published_at
        ];

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            Storage::disk('public')->delete($blog->image);
            // Сохраняем новое
            $data['image'] = $request->file('image')->store('blog_images', 'public');
        }

        $blog->update($data);

        return back()->with('success', 'Blog updated successfully');
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

        return back()->with('success', 'Blog post deleted successfully!');
    }
}
