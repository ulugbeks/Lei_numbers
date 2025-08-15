@extends('layouts.admin')

@section('content')
<div class="container" style="max-width: 100%!important; margin-top: 10px;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Page: {{ $page->name }}</h5>
            <div>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-secondary me-2">
                    Back
                </a>
                <a href="{{ url($page->slug === 'home' ? '/' : '/'.$page->slug) }}" target="_blank" class="btn btn-sm btn-info">
                    View Page
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Tabbed interface -->
                <ul class="nav nav-tabs mb-3" id="pageEditTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content-info" type="button" role="tab">
                            Content
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo-info" type="button" role="tab">
                            SEO
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pageEditTabContent">
                    <!-- Content Tab -->
                    <div class="tab-pane fade show active" id="content-info" role="tabpanel">
                        <div class="card border-top-0 rounded-top-0">
                            <div class="card-body">
                                <!-- Page Title -->
                                <div class="form-group mb-4">
                                    <label for="title" class="form-label fw-bold">Page Title</label>
                                    <input type="text" name="title" id="title" class="form-control form-control-lg" 
                                          value="{{ old('title', $page->title) }}" required>
                                    <div class="form-text text-muted">
                                        This title will appear in breadcrumbs, browser tabs, and throughout the site.
                                    </div>
                                </div>

                                <!-- Page Slug -->
                                <div class="form-group mb-4">
                                    <label for="slug" class="form-label fw-bold">URL Slug</label>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted">{{ url('/') }}/</span>
                                        <input type="text" name="slug" id="slug" class="form-control" 
                                              value="{{ old('slug', $page->slug) }}" {{ $page->slug === 'home' ? 'readonly' : '' }}>
                                    </div>
                                    <div class="form-text text-muted">
                                        The unique URL path for this page.
                                        @if($page->slug !== 'home')
                                            <span class="text-warning">
                                                Warning: Changing the slug will break existing links to this page.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Page Status -->
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold d-block">Page Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status" name="status" 
                                              value="1" {{ old('status', $page->status) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">
                                            <span class="text-success">Active</span>/<span class="text-danger">Inactive</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Page Content - Hidden for Home Page -->
                                @if($page->slug !== 'home')
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Page Content</label>
                                        <textarea name="main_content" id="main_content" class="tinymce form-control" rows="15">
                                            {{ $content['main_content'] ?? '' }}
                                        </textarea>
                                    </div>
                                @else
                                    <!-- Hidden input to preserve any existing main content for home page -->
                                    <input type="hidden" name="main_content" value="{{ $content['main_content'] ?? '' }}">
                                @endif
                                
                                <!-- Home Page Specific Sections - Text-only Editing -->
                                @if($page->slug === 'home')
                                    <!-- Banner Section for Home Page -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Banner Section</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Banner Title</label>
                                                <input type="text" name="banner_title" class="form-control" 
                                                      value="{{ $content['banner']['title'] ?? 'Apply for an LEI number' }}">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Banner Description</label>
                                                <textarea name="banner_description" class="form-control tinymce" rows="3">{{ $content['banner']['description'] ?? '' }}</textarea>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Button Text</label>
                                                    <input type="text" name="banner_button_text" class="form-control" 
                                                         value="{{ $content['banner']['button_text'] ?? 'What is LEI' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Button URL</label>
                                                    <input type="text" name="banner_button_url" class="form-control" 
                                                         value="{{ $content['banner']['button_url'] ?? '/about-lei' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Features Section -->
                                    <div class="card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Features Section</h5>
                                            <button type="button" id="add-feature-btn" class="btn btn-sm btn-primary">Add Feature</button>
                                        </div>
                                        <div class="card-body">
                                            <div id="features-container">
                                                @if(!empty($content['features']))
                                                    @foreach($content['features'] as $index => $feature)
                                                        <div class="card mb-3 feature-item">
                                                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-0">Feature #{{ $index + 1 }}</h6>
                                                                @if($index > 2)
                                                                    <button type="button" class="btn btn-sm btn-danger remove-feature">Remove</button>
                                                                @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Feature Title</label>
                                                                    <input type="text" name="feature_title[]" class="form-control" 
                                                                          value="{{ $feature['title'] ?? '' }}">
                                                                </div>
                                                                <input type="hidden" name="feature_icon[]" value="{{ $feature['icon'] ?? '' }}">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Feature Description</label>
                                                                    <textarea name="feature_description[]" class="form-control tinymce-mini" rows="2">{{ $feature['description'] ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    @for($i = 0; $i < 3; $i++)
                                                        <div class="card mb-3 feature-item">
                                                            <div class="card-header bg-light">
                                                                <h6 class="mb-0">Feature #{{ $i + 1 }}</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Feature Title</label>
                                                                    <input type="text" name="feature_title[]" class="form-control">
                                                                </div>
                                                                <input type="hidden" name="feature_icon[]" value="">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Feature Description</label>
                                                                    <textarea name="feature_description[]" class="form-control tinymce-mini" rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- About Section -->
                                    <div class="card mb-4">
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
                                                <textarea name="about_description" class="form-control tinymce" rows="4">{{ $content['about']['description'] ?? 'Borem ipsum dolor sit amet, consectetur adipiscing elita floraipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt ut labore et dolore magna aliqua Quis suspendisse ultri ces gravida.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Request/Consultation Section -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Request/Consultation Section</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="request_title" class="form-control" 
                                                      value="{{ $content['request']['title'] ?? 'Let\'s request a schedule For free consultation' }}">
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Phone Label</label>
                                                    <input type="text" name="request_phone_label" class="form-control" 
                                                         value="{{ $content['request']['phone_label'] ?? 'Hotline 24/7' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Phone Number</label>
                                                    <input type="text" name="request_phone_number" class="form-control" 
                                                         value="{{ $content['request']['phone_number'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Button Text</label>
                                                    <input type="text" name="request_button_text" class="form-control" 
                                                         value="{{ $content['request']['button_text'] ?? 'Request a schedule' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Button URL</label>
                                                    <input type="text" name="request_button_url" class="form-control" 
                                                         value="{{ $content['request']['button_url'] ?? '/contact' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- Registration-LEI Page Specific Sections -->
                                @if($page->slug === 'registration-lei')
                                    <!-- Service Header Section -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Service Header Section</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="service_title" class="form-control" 
                                                      value="{{ $content['service_header']['title'] ?? 'LEI Register Services' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="service_description" class="form-control" rows="2">{{ $content['service_header']['description'] ?? 'Secure your Legal Entity Identifier with our trusted registration service' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Plans Section -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Plans Section</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Section Title</label>
                                                <input type="text" name="plans_title" class="form-control" 
                                                      value="{{ $content['plans']['title'] ?? 'Select a plan' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Section Description</label>
                                                <textarea name="plans_description" class="form-control" rows="2">{{ $content['plans']['description'] ?? 'Save money on each annual renewal based on multi-year plans.' }}</textarea>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0">1 Year Plan</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Price (€)</label>
                                                                <input type="text" name="plan_1_price" class="form-control" 
                                                                      value="{{ $content['plans']['plans'][0]['price'] ?? '75' }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Total (€)</label>
                                                                <input type="text" name="plan_1_total" class="form-control" 
                                                                      value="{{ $content['plans']['plans'][0]['total'] ?? '75' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0">3 Years Plan</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Price (€)</label>
                                                                <input type="text" name="plan_3_price" class="form-control" 
                                                                      value="{{ $content['plans']['plans'][1]['price'] ?? '55' }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Total (€)</label>
                                                                <input type="text" name="plan_3_total" class="form-control" 
                                                                      value="{{ $content['plans']['plans'][1]['total'] ?? '165' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0">5 Years Plan</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Price (€)</label>
                                                                <input type="text" name="plan_5_price" class="form-control" 
                                                                      value="{{ $content['plans']['plans'][2]['price'] ?? '50' }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Total (€)</label>
                                                                <input type="text" name="plan_5_total" class="form-control" 
                                                                      value="{{ $content['plans']['plans'][2]['total'] ?? '250' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Form Section -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Form Section</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Form Title</label>
                                                <input type="text" name="form_title" class="form-control" 
                                                      value="{{ $content['form']['title'] ?? 'Complete the form' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Form Description</label>
                                                <textarea name="form_description" class="form-control" rows="2">{{ $content['form']['description'] ?? 'Start typing, and let us fill all the relevant details for you.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tabs Section -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Tabs Section</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Register Tab Title</label>
                                                    <input type="text" name="tab_register_title" class="form-control" 
                                                          value="{{ $content['tabs']['register_title'] ?? 'REGISTER' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Renew Tab Title</label>
                                                    <input type="text" name="tab_renew_title" class="form-control" 
                                                          value="{{ $content['tabs']['renew_title'] ?? 'RENEW' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Transfer Tab Title</label>
                                                    <input type="text" name="tab_transfer_title" class="form-control" 
                                                          value="{{ $content['tabs']['transfer_title'] ?? 'TRANSFER' }}">
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Renew Tab Description</label>
                                                <textarea name="tab_renew_description" class="form-control" rows="2">{{ $content['tabs']['renew_description'] ?? 'Enter your LEI code or company name to quickly renew your registration.' }}</textarea>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Transfer Tab Description</label>
                                                <textarea name="tab_transfer_description" class="form-control" rows="2">{{ $content['tabs']['transfer_description'] ?? 'Transfer your existing LEI to our service for better rates and support.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- About Page Content Editor -->
                                @if($page->slug === 'about')
                                    <!-- FAQ Section -->
                                    <div class="card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">About Page FAQs</h5>
                                            <button type="button" id="add-about-faq-btn" class="btn btn-sm btn-primary">Add FAQ Item</button>
                                        </div>
                                        <div class="card-body">
                                            <div id="about-faq-container">
                                                @if(!empty($content['faqs']))
                                                    @foreach($content['faqs'] as $index => $faq)
                                                        <div class="card mb-3 faq-item">
                                                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-0">FAQ Item #{{ $index + 1 }}</h6>
                                                                <button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Question</label>
                                                                    <input type="text" name="faq_question[]" class="form-control" value="{{ $faq['question'] ?? '' }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Answer</label>
                                                                    <textarea name="faq_answer[]" class="form-control faq-editor" rows="3" id="about-faq-answer-{{ $index }}">{{ $faq['answer'] ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="card mb-3 faq-item">
                                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0">FAQ Item #1</h6>
                                                            <button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Question</label>
                                                                <input type="text" name="faq_question[]" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Answer</label>
                                                                <textarea name="faq_answer[]" class="form-control faq-editor" rows="3" id="about-faq-answer-0"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- About LEI Page Content Editor -->
                                @if($page->slug === 'about-lei')
                                    <!-- FAQ Section -->
                                    <div class="card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">LEI FAQs</h5>
                                            
                                        </div>
                                        <div class="card-body">
                                            <div id="aboutlei-faq-container">
                                                @if(!empty($content['faqs']))
                                                    @foreach($content['faqs'] as $index => $faq)
                                                        <div class="card mb-3 faq-item">
                                                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-0">FAQ Item #{{ $index + 1 }}</h6>
                                                                <button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Question</label>
                                                                    <input type="text" name="aboutlei_faq_question[]" class="form-control" value="{{ $faq['question'] ?? '' }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Answer</label>
                                                                    <textarea name="aboutlei_faq_answer[]" class="form-control faq-editor" rows="3" id="lei-faq-answer-{{ $index }}">{{ $faq['answer'] ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="card mb-3 faq-item">
                                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0">FAQ Item #1</h6>
                                                            <button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Question</label>
                                                                <input type="text" name="aboutlei_faq_question[]" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Answer</label>
                                                                <textarea name="aboutlei_faq_answer[]" class="form-control faq-editor" rows="3" id="lei-faq-answer-0"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <button type="button" id="add-lei-faq-btn" class="btn btn-sm btn-primary">Add FAQ Item</button>
                                    </div>
                                @endif

                                <!-- Contact Page Specific Sections -->
                                @if($page->slug === 'contact')
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Contact Section</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="contact_title" class="form-control" 
                                                      value="{{ $content['contact_section']['title'] ?? 'Contact Us' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Subtitle</label>
                                                <input type="text" name="contact_subtitle" class="form-control" 
                                                      value="{{ $content['contact_section']['subtitle'] ?? 'Get in touch with our team' }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Contact Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" name="contact_address" class="form-control" 
                                                      value="{{ $content['contact_details']['address'] ?? '123 Business Street, City, Country' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="contact_email" class="form-control" 
                                                      value="{{ $content['contact_details']['email'] ?? 'info@leiregister.com' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Phone</label>
                                                <input type="text" name="contact_phone" class="form-control" 
                                                      value="{{ $content['contact_details']['phone'] ?? '+1 234 567 890' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Working Hours</label>
                                                <input type="text" name="contact_hours" class="form-control" 
                                                      value="{{ $content['contact_details']['hours'] ?? 'Monday-Friday: 9am-5pm' }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                            
                                </div>
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div class="tab-pane fade" id="seo-info" role="tabpanel">
                        <div class="card border-top-0 rounded-top-0">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label for="meta_title" class="form-label fw-bold">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                              value="{{ old('meta_title', $page->meta_title) }}" maxlength="60">
                                        <div class="d-flex justify-content-between">
                                            <div class="form-text text-muted">Recommended: 50-60 characters</div>
                                            <div class="form-text" id="metaTitleCounter">
                                                <span id="metaTitleLength">0</span>/60
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" class="form-control" 
                                                 rows="3" maxlength="160">{{ old('meta_description', $page->meta_description) }}</textarea>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-text text-muted">Recommended: 150-160 characters</div>
                                            <div class="form-text" id="metaDescCounter">
                                                <span id="metaDescLength">0</span>/160
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Advanced SEO Options -->
                                <div class="card border mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            Advanced SEO Options
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                                <input type="url" name="canonical_url" id="canonical_url" class="form-control" 
                                                     value="{{ old('canonical_url', $page->canonical_url ?? '') }}">
                                                <div class="form-text text-muted">Leave empty to use the default URL</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label d-block">Indexing Options</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="no_index" name="no_index" 
                                                         value="1" {{ old('no_index', $page->no_index ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="no_index">Hide from search engines</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label d-block">Link Following</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="no_follow" name="no_follow" 
                                                         value="1" {{ old('no_follow', $page->no_follow ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="no_follow">Don't follow links on this page</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Preview -->
                                <div class="card border bg-white">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            Search Result Preview
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="seoPreviewTitle" class="text-primary mb-1" style="font-size: 18px; font-weight: bold; text-decoration: underline;">
                                            {{ $page->meta_title ?: $page->title ?: 'Page Title' }}
                                        </div>
                                        <div id="seoPreviewUrl" class="text-success" style="font-size: 14px;">
                                            {{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}
                                        </div>
                                        <div id="seoPreviewDescription" class="mt-1" style="font-size: 14px; color: #4d5156; line-height: 1.58;">
                                            {{ $page->meta_description ?: 'Add a meta description to improve how this page appears in search results.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.tiny.cloud/1/cutdqhmzvugvtosmcaietdon22xvmds3rwygoa51cvknvrwx/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE for main content
    // Initialize TinyMCE for main content with custom configuration
    tinymce.init({
        selector: '.tinymce',
        height: 450,
        forced_root_block: 'p',
        forced_root_block_attrs: {
            'data-mce-empty': '1'  // Custom attribute to identify empty paragraphs
        },
        plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: `undo redo | blocks | bold italic underline strikethrough | 
                forecolor backcolor | alignleft aligncenter alignright alignjustify | 
                bullist numlist outdent indent | removeformat | link anchor | 
                table | code fullscreen preview | help`,
        font_family_formats: 
        'System UI=system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif;' +
        'Arial=arial,helvetica,sans-serif;' +
        'Arial Black=arial black,avant garde;' +
        'Courier New=courier new,courier;' +
        'Georgia=georgia,palatino;' +
        'Helvetica=helvetica;' +
        'Impact=impact,chicago;' +
        'Tahoma=tahoma,arial,helvetica,sans-serif;' +
        'Terminal=terminal,monaco;' +
        'Times New Roman=times new roman,times;' +
        'Trebuchet MS=trebuchet ms,geneva;' +
        'Verdana=verdana,geneva;',
        images_upload_url: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}",
        // Custom format options
        formats: {
            // Override default paragraph format
            p: { block: 'p', remove: 'all' }
        },
        // Set valid elements to control which tags are allowed
        valid_elements: '*[*]', // Allow all elements and attributes initially
        entity_encoding: 'raw', // Don't convert entities
        convert_newlines_to_brs: false, // Don't convert newlines
        remove_linebreaks: false, // Preserve linebreaks
        // Additional handlers for content
        setup: function(editor) {
            // Process content before it's set in the editor
            editor.on('BeforeSetContent', function(e) {
                // You can manipulate content here before it's set in the editor
                console.log('Setting content in editor', editor.id);
            });
            
            // Process content when it's retrieved from the editor
            editor.on('GetContent', function(e) {
                // You can manipulate the output here
                console.log('Getting content from editor', editor.id);
            });
        }
    });
    
    // Initialize existing FAQ editors
    document.querySelectorAll('.faq-editor').forEach(function(textarea, index) {
        if (!textarea.id) {
            textarea.id = 'existing-faq-' + index;
        }
        
        tinymce.init({
            selector: '#' + textarea.id,
            height: 200,
            forced_root_block: 'p',
            forced_root_block_attrs: {
                'data-mce-empty': '1'  // Custom attribute to identify empty paragraphs
            },
            menubar: false,
            plugins: 'link lists image',
            toolbar: 'undo redo | bold italic | bullist numlist | link image',
            images_upload_url: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}"
        });
    });
    
    // Character counters with color indicators
    const metaTitle = document.getElementById('meta_title');
    const metaDesc = document.getElementById('meta_description');
    const metaTitleLength = document.getElementById('metaTitleLength');
    const metaDescLength = document.getElementById('metaDescLength');
    
    // SEO Preview elements
    const seoPreviewTitle = document.getElementById('seoPreviewTitle');
    const seoPreviewUrl = document.getElementById('seoPreviewUrl');
    const seoPreviewDescription = document.getElementById('seoPreviewDescription');
    
    // Initialize counters and preview
    if (metaTitle && metaTitleLength) {
        metaTitleLength.textContent = metaTitle.value.length;
        updateTitleIndicator(metaTitle.value.length);
        
        metaTitle.addEventListener('input', function() {
            metaTitleLength.textContent = this.value.length;
            updateTitleIndicator(this.value.length);
            seoPreviewTitle.textContent = this.value || titleInput.value || 'Page Title';
        });
    }
    
    if (metaDesc && metaDescLength) {
        metaDescLength.textContent = metaDesc.value.length;
        updateDescIndicator(metaDesc.value.length);
        
        metaDesc.addEventListener('input', function() {
            metaDescLength.textContent = this.value.length;
            updateDescIndicator(this.value.length);
            seoPreviewDescription.textContent = this.value || 'Add a meta description to improve how this page appears in search results.';
        });
    }
    
    // Update URL in SEO preview when slug changes
    const slugInput = document.getElementById('slug');
    if (slugInput && seoPreviewUrl) {
        slugInput.addEventListener('input', function() {
            if (this.value === 'home') {
                seoPreviewUrl.textContent = "{{ url('/') }}";
            } else {
                seoPreviewUrl.textContent = "{{ url('/') }}/" + this.value;
            }
        });
    }
    
    // Title to slug conversion
    const titleInput = document.getElementById('title');
    
    // Only enable automatic slug creation if slug is empty or if slug field is not the homepage
    if (titleInput && slugInput && slugInput.value !== 'home' && slugInput.value === '') {
        titleInput.addEventListener('input', function() {
            // Create slug from title (lowercase, replace spaces with dashes, remove special chars)
            slugInput.value = this.value.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-')     // Replace spaces with dashes
                .replace(/-+/g, '-');     // Remove consecutive dashes
        });
    }
    
    // Update title indicator color based on length
    function updateTitleIndicator(length) {
        if (length === 0) {
            metaTitleLength.className = 'text-muted';
        } else if (length < 30) {
            metaTitleLength.className = 'text-danger'; // Too short
        } else if (length > 60) {
            metaTitleLength.className = 'text-danger'; // Too long
        } else {
            metaTitleLength.className = 'text-success'; // Just right
        }
    }
    
    // Update description indicator color based on length
    function updateDescIndicator(length) {
        if (length === 0) {
            metaDescLength.className = 'text-muted';
        } else if (length < 120) {
            metaDescLength.className = 'text-danger'; // Too short
        } else if (length > 160) {
            metaDescLength.className = 'text-danger'; // Too long
        } else {
            metaDescLength.className = 'text-success'; // Just right
        }
    }
    
    // Function to add a new FAQ item
    function addFaqItem(container, fieldNamePrefix) {
        var count = container.querySelectorAll('.faq-item').length + 1;
        var newId = 'new-faq-' + new Date().getTime();
        
        var newItem = document.createElement('div');
        newItem.className = 'card mb-3 faq-item';
        newItem.innerHTML = `
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0">FAQ Item #${count}</h6>
                <button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Question</label>
                    <input type="text" name="${fieldNamePrefix}_question[]" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Answer</label>
                    <textarea id="${newId}" name="${fieldNamePrefix}_answer[]" class="form-control" rows="3"></textarea>
                </div>
            </div>
        `;
        
        container.appendChild(newItem);
        
        // Initialize TinyMCE for the new textarea
        tinymce.init({
            selector: '#' + newId,
            height: 200,
            menubar: false,
            forced_root_block: 'p',
            forced_root_block_attrs: {
                'data-mce-empty': '1'  // Custom attribute to identify empty paragraphs
            },
            plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: `undo redo | blocks | bold italic underline strikethrough | 
                forecolor backcolor | alignleft aligncenter alignright alignjustify | 
                bullist numlist outdent indent | removeformat | link anchor | 
                table | code fullscreen preview | help`,
            font_family_formats: 
            'System UI=system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif;' +
            'Arial=arial,helvetica,sans-serif;' +
            'Arial Black=arial black,avant garde;' +
            'Courier New=courier new,courier;' +
            'Georgia=georgia,palatino;' +
            'Helvetica=helvetica;' +
            'Impact=impact,chicago;' +
            'Tahoma=tahoma,arial,helvetica,sans-serif;' +
            'Terminal=terminal,monaco;' +
            'Times New Roman=times new roman,times;' +
            'Trebuchet MS=trebuchet ms,geneva;' +
            'Verdana=verdana,geneva;',
            images_upload_url: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}",
        });
    }
    
    // Add FAQ button functionality for general FAQs
    var addFaqBtn = document.getElementById('add-faq-btn');
    if (addFaqBtn) {
        addFaqBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('faq-container');
            if (container) {
                addFaqItem(container, 'faq');
            }
        });
    }
    
    // Add LEI FAQ button functionality
    var addLeiFaqBtn = document.getElementById('add-lei-faq-btn');
    if (addLeiFaqBtn) {
        addLeiFaqBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('lei-faq-container');
            if (container) {
                addFaqItem(container, 'aboutlei_faq');
            }
        });
    }
    
    // Add About FAQ button functionality
    var addAboutFaqBtn = document.getElementById('add-about-faq-btn');
    if (addAboutFaqBtn) {
        addAboutFaqBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('about-faq-container');
            if (container) {
                addFaqItem(container, 'faq');
            }
        });
    }
    
    // Add Feature button functionality
    var addFeatureBtn = document.getElementById('add-feature-btn');
    if (addFeatureBtn) {
        addFeatureBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('features-container');
            if (container) {
                var count = container.querySelectorAll('.feature-item').length + 1;
                var newId = 'new-feature-' + new Date().getTime();
                
                var newItem = document.createElement('div');
                newItem.className = 'card mb-3 feature-item';
                newItem.innerHTML = `
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Feature #${count}</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-feature">Remove</button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Feature Title</label>
                            <input type="text" name="feature_title[]" class="form-control">
                        </div>
                        <input type="hidden" name="feature_icon[]" value="">
                        <div class="mb-3">
                            <label class="form-label">Feature Description</label>
                            <textarea id="${newId}" name="feature_description[]" class="form-control tinymce-mini" rows="2"></textarea>
                        </div>
                    </div>
                `;
                
                container.appendChild(newItem);
                
                // Initialize TinyMCE for the new textarea
                tinymce.init({
                    selector: '#' + newId,
                    height: 200,
                    menubar: false,
                    forced_root_block: 'p',
                    forced_root_block_attrs: {
                        'data-mce-empty': '1'
                    },
                    plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                    toolbar: `undo redo | blocks | bold italic underline strikethrough | 
                forecolor backcolor | alignleft aligncenter alignright alignjustify | 
                bullist numlist outdent indent | removeformat | link anchor | 
                table | code fullscreen preview | help`,
                font_family_formats: 
    'System UI=system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif;' +
    'Arial=arial,helvetica,sans-serif;' +
    'Arial Black=arial black,avant garde;' +
    'Courier New=courier new,courier;' +
    'Georgia=georgia,palatino;' +
    'Helvetica=helvetica;' +
    'Impact=impact,chicago;' +
    'Tahoma=tahoma,arial,helvetica,sans-serif;' +
    'Terminal=terminal,monaco;' +
    'Times New Roman=times new roman,times;' +
    'Trebuchet MS=trebuchet ms,geneva;' +
    'Verdana=verdana,geneva;',
                    images_upload_url: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}",
                });
            }
        });
    }
    
    // Remove FAQ item functionality
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-faq')) {
            var faqItem = e.target.closest('.faq-item');
            
            // Find textarea and destroy TinyMCE instance
            var textarea = faqItem.querySelector('textarea');
            if (textarea && textarea.id) {
                var editorInstance = tinymce.get(textarea.id);
                if (editorInstance) {
                    editorInstance.remove();
                }
            }
            
            faqItem.remove();
        }
    });
    
    // Remove Feature item functionality
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-feature')) {
            var featureItem = e.target.closest('.feature-item');
            
            // Find textarea and destroy TinyMCE instance
            var textarea = featureItem.querySelector('textarea');
            if (textarea && textarea.id) {
                var editorInstance = tinymce.get(textarea.id);
                if (editorInstance) {
                    editorInstance.remove();
                }
            }
            
            featureItem.remove();
        }
    });

    // Check if we're on the home page edit screen
    const pageSlug = "{{ $page->slug ?? '' }}";
    
    if (pageSlug === 'home') {
        // Special configuration for home page description fields
        // Target specifically the banner description and other rich text areas on the home page
        const homeDescriptionEditors = [
            'banner_description',
            'about_description',
            'feature_description[]'  // For any feature descriptions
        ];
        
        // Apply special config to these editors
        homeDescriptionEditors.forEach(editorName => {
            const editors = document.getElementsByName(editorName);
            if (editors.length) {
                // For each matching editor, create a custom TinyMCE instance
                editors.forEach(editor => {
                    // If editor already has a TinyMCE instance, remove it first
                    if (editor.id && tinymce.get(editor.id)) {
                        tinymce.remove('#' + editor.id);
                    }
                    
                    // Create custom ID if needed
                    if (!editor.id) {
                        editor.id = 'home-editor-' + Math.random().toString(36).substring(2, 9);
                    }
                    
                    // Initialize with special settings
                    tinymce.init({
                        selector: '#' + editor.id,
                        height: 200,
                        forced_root_block: '',
                        plugins: 'link lists image',
                        toolbar: 'undo redo | bold italic | bullist numlist | link image',
                        images_upload_url: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}"
                    });
                });
            }
        });
    }
});

</script>
@if(session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>

    <script>
        // Make success message disappear after 3 seconds
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                // Fade out effect
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                
                // Remove from DOM after fade completes
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }
        }, 3000);
    </script>
@endif
@endsection