@extends('layouts.admin')

@section('title', 'Edit Document')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Document: {{ $document->title }}</h5>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Documents
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" id="documentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                            General Information
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab">
                            SEO Settings
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="documentTabContent">
                    <!-- General Tab -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Document Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $document->title) }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3">{{ old('description', $document->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Current File Info -->
                                <div class="alert alert-info">
                                    <h6><i class="{{ $document->file_icon }}"></i> Current File:</h6>
                                    <ul class="mb-0">
                                        <li>Name: <strong>{{ $document->file_name }}</strong></li>
                                        <li>Size: {{ $document->formatted_file_size }}</li>
                                        <li>Type: {{ $document->file_type }}</li>
                                        <li>Downloads: {{ $document->download_count }}</li>
                                        <li>Uploaded: {{ $document->created_at->format('Y-m-d H:i') }}</li>
                                    </ul>
                                    <a href="{{ asset('storage/' . $document->file_path) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-eye"></i> Preview Current File
                                    </a>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="document_file" class="form-label">Replace File (Optional)</label>
                                    <input type="file" 
                                           class="form-control @error('document_file') is-invalid @enderror" 
                                           id="document_file" 
                                           name="document_file"
                                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar,.jpg,.jpeg,.png,.gif">
                                    @error('document_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        Leave empty to keep the current file<br>
                                        Allowed formats: PDF, Word, Excel, PowerPoint, Text, Archive (ZIP/RAR), Images<br>
                                        Maximum file size: 20MB
                                    </small>
                                </div>
                                
                                <div class="alert alert-warning" id="file-info" style="display: none;">
                                    <h6>New File Information:</h6>
                                    <ul class="mb-0">
                                        <li>Name: <span id="file-name"></span></li>
                                        <li>Size: <span id="file-size"></span></li>
                                        <li>Type: <span id="file-type"></span></li>
                                    </ul>
                                    <small class="text-danger">This will replace the current file!</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Settings</h6>
                                        
                                        <div class="mb-3">
                                            <label for="order" class="form-label">Display Order</label>
                                            <input type="number" 
                                                   class="form-control @error('order') is-invalid @enderror" 
                                                   id="order" 
                                                   name="order" 
                                                   value="{{ old('order', $document->order) }}"
                                                   min="0">
                                            @error('order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Lower numbers appear first</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="status" 
                                                       name="status" 
                                                       value="1" 
                                                       {{ old('status', $document->status) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status">
                                                    Active
                                                </label>
                                            </div>
                                            <small class="text-muted">Only active documents are visible on the website</small>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="mb-0">
                                            <h6>Statistics</h6>
                                            <ul class="list-unstyled mb-0">
                                                <li><small>Downloads: <strong>{{ $document->download_count }}</strong></small></li>
                                                <li><small>Created: {{ $document->created_at->format('Y-m-d H:i') }}</small></li>
                                                <li><small>Updated: {{ $document->updated_at->format('Y-m-d H:i') }}</small></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SEO Tab -->
                    <div class="tab-pane fade" id="seo" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" 
                                           class="form-control @error('meta_title') is-invalid @enderror" 
                                           id="meta_title" 
                                           name="meta_title" 
                                           value="{{ old('meta_title', $document->meta_title) }}"
                                           maxlength="255">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Leave empty to use document title</small>
                                        <small class="text-muted"><span id="meta_title_count">0</span>/255</small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                              id="meta_description" 
                                              name="meta_description" 
                                              rows="3"
                                              maxlength="500">{{ old('meta_description', $document->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Brief description for search engines</small>
                                        <small class="text-muted"><span id="meta_description_count">0</span>/500</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Document
                    </button>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File input change handler
    const fileInput = document.getElementById('document_file');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const fileType = document.getElementById('file-type');
    
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Display file info
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileType.textContent = file.type || 'Unknown';
            fileInfo.style.display = 'block';
            
            // Check file size (20MB limit)
            if (file.size > 20 * 1024 * 1024) {
                alert('File size exceeds 20MB limit');
                this.value = '';
                fileInfo.style.display = 'none';
            }
        } else {
            fileInfo.style.display = 'none';
        }
    });
    
    // Format file size
    function formatFileSize(bytes) {
        if (bytes >= 1073741824) {
            return (bytes / 1073741824).toFixed(2) + ' GB';
        } else if (bytes >= 1048576) {
            return (bytes / 1048576).toFixed(2) + ' MB';
        } else if (bytes >= 1024) {
            return (bytes / 1024).toFixed(2) + ' KB';
        } else {
            return bytes + ' bytes';
        }
    }
    
    // Character counters
    const metaTitle = document.getElementById('meta_title');
    const metaTitleCount = document.getElementById('meta_title_count');
    const metaDescription = document.getElementById('meta_description');
    const metaDescriptionCount = document.getElementById('meta_description_count');
    
    if (metaTitle) {
        metaTitleCount.textContent = metaTitle.value.length;
        metaTitle.addEventListener('input', function() {
            metaTitleCount.textContent = this.value.length;
        });
    }
    
    if (metaDescription) {
        metaDescriptionCount.textContent = metaDescription.value.length;
        metaDescription.addEventListener('input', function() {
            metaDescriptionCount.textContent = this.value.length;
        });
    }
});
</script>
@endsection