@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Page: {{ $page->name }}</h5>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @if($page->slug === 'home')
                    <!-- Tabs для разных секций -->
                    <ul class="nav nav-tabs mb-4" id="pageTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="banner-tab" data-bs-toggle="tab" data-bs-target="#banner" type="button" role="tab">Banner</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab">About</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab">Features</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="pageTabContent">
                        <!-- Banner Section -->
                        <div class="tab-pane fade show active" id="banner" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Banner Section</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="banner_title" class="form-control" 
                                               value="{{ $content['banner']['title'] ?? '' }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="banner_description" class="form-control" rows="3">{{ $content['banner']['description'] ?? '' }}</textarea>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Button Text</label>
                                            <input type="text" name="banner_button_text" class="form-control" 
                                                   value="{{ $content['banner']['button_text'] ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Button URL</label>
                                            <input type="text" name="banner_button_url" class="form-control" 
                                                   value="{{ $content['banner']['button_url'] ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Background Image</label>
                                            @if(isset($content['banner']['background_image']))
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $content['banner']['background_image']) }}" 
                                                         alt="Background" class="img-thumbnail" style="max-height: 150px">
                                                </div>
                                            @endif
                                            <input type="file" name="banner_background_image" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Main Image</label>
                                            @if(isset($content['banner']['main_image']))
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $content['banner']['main_image']) }}" 
                                                         alt="Main Image" class="img-thumbnail" style="max-height: 150px">
                                                </div>
                                            @endif
                                            <input type="file" name="banner_main_image" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- About Section -->
                        <div class="tab-pane fade" id="about" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">About Section</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Subtitle</label>
                                        <input type="text" name="about_subtitle" class="form-control" 
                                               value="{{ $content['about']['subtitle'] ?? 'What We are Doing' }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="about_title" class="form-control" 
                                               value="{{ $content['about']['title'] ?? 'Changing The Way To Do Best Business Solutions' }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="about_description" class="form-control" rows="4">{{ $content['about']['description'] ?? 'Borem ipsum dolor sit amet, consectetur adipiscing elita floraipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt ut labore et dolore magna aliqua Quis suspendisse ultri ces gravida.' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Features Section -->
                        <div class="tab-pane fade" id="features" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Features Section</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Feature 1 -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Feature 1</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="feature1_title" class="form-control" 
                                                       value="{{ $content['features']['feature1']['title'] ?? 'Regsiter LEI' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="feature1_description" class="form-control" rows="2">{{ $content['features']['feature1']['description'] ?? 'Register LEI on our portal in a few seconds' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Feature 2 -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Feature 2</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="feature2_title" class="form-control" 
                                                       value="{{ $content['features']['feature2']['title'] ?? 'Easy LEI application' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="feature2_description" class="form-control" rows="2">{{ $content['features']['feature2']['description'] ?? 'Through the connection to more than 20 national commercial registers, your company data can be imported directly' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Feature 3 -->
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Feature 3</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="feature3_title" class="form-control" 
                                                       value="{{ $content['features']['feature3']['title'] ?? 'Allocation within 2 hours' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="feature3_description" class="form-control" rows="2">{{ $content['features']['feature3']['description'] ?? 'LEI verification by our staff and transmission to the central GLEIF database' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Контент для других страниц -->
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea id="editor" name="content" class="form-control">
                            {{ $page->content ?? '' }}
                        </textarea>
                    </div>
                @endif
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($page->slug !== 'home')
    {{-- Подключение CKEditor 4 --}}
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor', {
            height: 400,
            filebrowserUploadUrl: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endif
@endsection