<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_name' => 'nullable|string|max:255',
            'author_link' => 'nullable|url',
            'published_at' => 'nullable|date',
            'status' => 'required|boolean'
        ]);

        $imagePath = $request->file('image')->store('blog_images', 'public');

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'author_name' => $request->author_name,
            'author_link' => $request->author_link,
            'status' => $request->status ?? 0,
            'published_at' => $request->published_at ?? now(),
        ]);

        session()->flash('success', 'Blog successfully created!');

        return back()->with('success', 'Blog created successfully!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_name' => 'nullable|string|max:255',
            'author_link' => 'nullable|url',
            'published_at' => 'nullable|date',
            'status' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($blog->image);
            $imagePath = $request->file('image')->store('blog_images', 'public');
        } else {
            $imagePath = $blog->image;
        }

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'author_name' => $request->author_name,
            'author_link' => $request->author_link,
            'status' => $request->status ?? 0,
            'published_at' => $request->published_at ?? now()
        ]);

        session()->flash('success', 'Blog successfully updated!');

        return back()->with('success', 'Blog updated successfully!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        Storage::disk('public')->delete($blog->image);
        $blog->delete();

        session()->flash('success', 'Blog successfully deleted!');

        return back()->with('success', 'Blog deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = !$blog->status;
        $blog->save();

        session()->flash('success', 'Blog status updated successfully!');

        return response()->json(['success' => 'Status changed successfully.']);
    }
}
