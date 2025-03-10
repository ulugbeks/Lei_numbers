@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Blog</h1>
    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Title *</label>
        <input type="text" name="title" class="form-control" value="{{ $blog->title }}" required>
        
        <!-- Новые поля -->
        <div class="row mt-3">
            <div class="col-md-6">
                <label>Author Name</label>
                <input type="text" name="author_name" class="form-control" value="{{ $blog->author_name }}">
            </div>
            <div class="col-md-6">
                <label>Author Link</label>
                <input type="url" name="author_link" class="form-control" placeholder="https://" value="{{ $blog->author_link }}">
            </div>
        </div>

        <div class="mt-3">
            <label>Publication Date</label>
            <input type="datetime-local" name="published_at" class="form-control" 
                   value="{{ $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i') }}">
        </div>
        
        <label class="mt-3">Content *</label>
        <textarea name="content" id="editor" class="form-control" required>{{ $blog->content }}</textarea>
        
        <label class="mt-3">Image</label>
        <input type="file" name="image" class="form-control">
        <img src="{{ asset('storage/' . $blog->image) }}" width="100" class="mt-2">

        <label class="mt-3">Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ $blog->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$blog->status ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>

{{-- Подключение CKEditor 4 --}}
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        filebrowserUploadUrl: "{{ route('admin.blogs.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form'
    });
</script>

<style>
        .cke_notifications_area { display: none; }
    </style>

@endsection