@extends('layouts.app')

@section('title', $page->meta_title ?? 'Documents')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('assets/img/bg/breadcrumb_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">{{ $page->title ?? 'Documents' }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Documents</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-shape-wrap">
            <img src="{{ asset('assets/img/images/breadcrumb_shape01.png') }}" alt="">
            <img src="{{ asset('assets/img/images/breadcrumb_shape02.png') }}" alt="">
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- documents-area -->
    <section class="documents-area section-py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if($page && $page->content)
                        @php
                            $content = json_decode($page->content, true) ?: [];
                        @endphp
                        @if(!empty($content['main_content']))
                            <div class="documents-intro mb-5">
                                {!! $content['main_content'] !!}
                            </div>
                        @endif
                    @endif
                    
                    <div class="documents-list">
                        @forelse($documents as $document)
                            <div class="document-item">
                                <div class="document-card">
                                    <div class="row align-items-center">
                                        <div class="col-md-1 text-center">
                                            <div class="document-icon">
                                                <i class="{{ $document->file_icon }} fa-3x"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="document-info">
                                                <h4 class="document-title">{{ $document->title }}</h4>
                                                @if($document->description)
                                                    <p class="document-description">{{ $document->description }}</p>
                                                @endif
                                                <div class="document-meta">
                                                    <span class="meta-item">
                                                        <i class="fas fa-file"></i> {{ $document->file_name }}
                                                    </span>
                                                    <span class="meta-item">
                                                        <i class="fas fa-weight"></i> {{ $document->formatted_file_size }}
                                                    </span>
                                                    <span class="meta-item">
                                                        <i class="fas fa-download"></i> {{ $document->download_count }} downloads
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <div class="document-actions">
                                                @php
                                                    $extension = strtolower(pathinfo($document->file_name, PATHINFO_EXTENSION));
                                                    $previewable = in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']);
                                                @endphp
                                                
                                                @if($previewable)
                                                    <a href="{{ route('documents.preview', $document) }}" 
                                                       target="_blank" 
                                                       class="btn btn-outline-primary btn-sm mb-2">
                                                        <i class="fas fa-eye"></i> Preview
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('documents.download', $document) }}" 
                                                   class="btn btn-primary btn-sm mb-2">
                                                    <i class="fas fa-download"></i> <span>Download</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle fa-3x mb-3"></i>
                                <h4>No Documents Available</h4>
                                <p>There are currently no documents available for download. Please check back later.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    @if($documents->hasPages())
                        <div class="pagination-wrap mt-50">
                            {{ $documents->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- documents-area-end -->

</main>
<!-- main-area-end -->

@include('partials.footer')

<style>
.documents-area {
    padding: 80px 0;
}

.document-item {
    margin-bottom: 20px;
}

.document-card {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.document-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.document-icon {
    padding: 15px;
}

.document-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}

.document-description {
    color: #666;
    margin-bottom: 10px;
    font-size: 14px;
}

.document-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    font-size: 13px;
    color: #999;
}

.meta-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.meta-item i {
    font-size: 12px;
}

.document-actions .btn {
    min-width: 120px;
    display: block;
    width: 100%;
    text-align: left;
}

.document-actions .btn span {
    margin-left: 50px;
}

.document-actions .btn i {
    position: absolute;
    right: 20px;
}

.btn::after {
    display: none;
}

@media (max-width: 768px) {
    .document-card {
        padding: 15px;
    }
    
    .document-title {
        font-size: 18px;
    }
    
    .document-meta {
        font-size: 12px;
        gap: 10px;
    }
    
    .document-icon {
        margin-bottom: 15px;
    }
    
    .document-actions {
        margin-top: 15px;
        display: flex;
        justify-content: center;
    }
    
    .document-actions .btn {
        display: inline-block;
        width: 200px;
        margin-right: 10px;
    }
    .document-actions .btn span {
        margin-left: 0!important;
    }
}

/* File type icon colors */
.fa-file-pdf { color: #dc3545; }
.fa-file-word { color: #0066cc; }
.fa-file-excel { color: #28a745; }
.fa-file-powerpoint { color: #ffc107; }
.fa-file-archive { color: #6c757d; }
.fa-file-image { color: #17a2b8; }
.fa-file-alt { color: #007bff; }
.fa-file { color: #6c757d; }
</style>

@endsection