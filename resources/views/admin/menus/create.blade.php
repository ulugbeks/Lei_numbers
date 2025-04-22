@extends('layouts.admin')

@section('title', 'Create Menu')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Menu</h3>
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back to Menus
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.menus.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Menu Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">A unique name to identify this menu</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="location">Menu Location</label>
                            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Where this menu will be displayed (e.g., header, footer, sidebar)</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', '1') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="active">Active</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Menu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection