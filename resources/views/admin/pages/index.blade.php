@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pages</h5>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Create New Page
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>{{ $page->name }}</td>
                            <td>{{ $page->title }}</td>
                            <td>
                                <code>{{ $page->slug }}</code>
                                <a href="{{ url($page->slug === 'home' ? '/' : '/'.$page->slug) }}" target="_blank" class="text-primary ms-1">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </td>
                            <td>
                                @if($page->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @if(!in_array($page->slug, ['home', 'about', 'contact']))
                                    <button type="button" class="btn btn-sm btn-danger" style="display: none;" 
                                            onclick="if(confirm('Are you sure you want to delete this page?')) { 
                                                document.getElementById('delete-form-{{ $page->id }}').submit(); 
                                            }">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <form id="delete-form-{{ $page->id }}" action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection