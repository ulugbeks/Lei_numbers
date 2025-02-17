@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Blog</h1>
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
        
        <label>Content</label>
        <textarea name="content" id="editor" class="form-control"></textarea>
        
        <label>Image</label>
        <input type="file" name="image" class="form-control">

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>

        <button type="submit" class="btn btn-success mt-3">Save</button>
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
