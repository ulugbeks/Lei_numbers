@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Blog</h1>
    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ $blog->title }}" required>
        
        <label>Content</label>
        <textarea name="content" id="editor" class="form-control" required>{{ $blog->content }}</textarea>
        
        <label>Image</label>
        <input type="file" name="image" class="form-control">
        <img src="{{ asset('storage/' . $blog->image) }}" width="100">

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ $blog->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$blog->status ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>

{{-- Подключение TinyMCE --}}
<script src="https://cdn.tiny.cloud/1/cutdqhmzvugvtosmcaietdon22xvmds3rwygoa51cvknvrwx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview anchor',
        toolbar: 'bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        menubar: false,
        branding: false
    });
</script>

@endsection
