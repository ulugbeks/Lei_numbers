@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>News</h1>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">Add New Article</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
            <tr>
                <td>{{ $blog->title }}</td>
                <td><img src="{{ asset('storage/' . $blog->image) }}" width="100"></td>
                <td>
                    <button class="btn btn-{{ $blog->status ? 'success' : 'warning' }}" 
                            onclick="toggleStatus({{ $blog->id }})">
                        {{ $blog->status ? 'Active' : 'Inactive' }}
                    </button>
                </td>
                <td>
                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-info">Edit</a>
                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function toggleStatus(id) {
    fetch(`/backend/blogs/status/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => location.reload());
}
</script>
@endsection
