@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Article</h1>
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Title *</label>
        <input type="text" name="title" class="form-control" required>
        
        <!-- Новые поля -->
        <div class="row mt-3">
            <div class="col-md-6">
                <label>Author Name</label>
                <input type="text" name="author_name" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Author Link</label>
                <input type="url" name="author_link" class="form-control" placeholder="https://">
            </div>
        </div>

        <div class="mt-3">
            <label>Publication Date</label>
            <input type="datetime-local" name="published_at" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
        </div>
        
        <label class="mt-3">Content *</label>
        <textarea name="content" id="editor" class="form-control"></textarea>
        
        <label class="mt-3">Image *</label>
        <input type="file" name="image" class="form-control">

        <label class="mt-3">Status</label>
        <select name="status" class="form-control">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>

        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
</div>

{{-- Подключение CKEditor 4 --}}
<script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 400,
        toolbarGroups: [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            { name: 'forms', groups: [ 'forms' ] },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },
            { name: 'insert', groups: [ 'insert' ] },
            '/',
            { name: 'styles', groups: [ 'styles' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'tools', groups: [ 'tools' ] },
            { name: 'others', groups: [ 'others' ] },
            { name: 'about', groups: [ 'about' ] }
        ],
        removeButtons: 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,Subscript,Superscript,CopyFormatting,RemoveFormat,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Maximize,ShowBlocks,About',
        filebrowserUploadUrl: "{{ route('admin.blogs.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form'
    });
</script>

@endsection