@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create New Page</h5>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-secondary">
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf

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
                                <!-- Page Name (Admin Label) -->
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label fw-bold">Page Name (Admin Label)</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg" 
                                           value="{{ old('name') }}" required>
                                    <div class="form-text text-muted">
                                        This name is used for administrative purposes in the admin panel.
                                    </div>
                                </div>
                            
                                <!-- Page Title -->
                                <div class="form-group mb-4">
                                    <label for="title" class="form-label fw-bold">Page Title</label>
                                    <input type="text" name="title" id="title" class="form-control form-control-lg" 
                                           value="{{ old('title') }}" required>
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
                                               value="{{ old('slug') }}" required>
                                    </div>
                                    <div class="form-text text-muted">
                                        The unique URL path for this page. Use lowercase letters, numbers, and hyphens only.
                                    </div>
                                </div>

                                <!-- Page Status -->
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold d-block">Page Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status" name="status" 
                                               value="1" {{ old('status', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">
                                            <span class="text-success">Active</span>/<span class="text-danger">Inactive</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Page Content -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Page Content</label>
                                    <textarea name="main_content" id="main_content" class="tinymce form-control" rows="15">{{ old('main_content') }}</textarea>
                                </div>
                                
                                <!-- Hidden fields for page type specific content -->
                                <div id="home-page-fields" style="display: none;">
                                    <input type="hidden" name="banner_title" value="{{ old('banner_title', 'Apply for an LEI number') }}">
                                    <input type="hidden" name="banner_description" value="{{ old('banner_description') }}">
                                    <input type="hidden" name="banner_button_text" value="{{ old('banner_button_text', 'What is LEI') }}">
                                    <input type="hidden" name="banner_button_url" value="{{ old('banner_button_url', '/about-lei') }}">
                                    
                                    <!-- Feature 1 -->
                                    <input type="hidden" name="feature_title[]" value="{{ old('feature_title.0', 'Register LEI') }}">
                                    <input type="hidden" name="feature_icon[]" value="{{ old('feature_icon.0', 'flaticon-puzzle-piece') }}">
                                    <input type="hidden" name="feature_description[]" value="{{ old('feature_description.0', 'Register LEI on our portal in a few seconds') }}">
                                    
                                    <!-- Feature 2 -->
                                    <input type="hidden" name="feature_title[]" value="{{ old('feature_title.1', 'Easy LEI application') }}">
                                    <input type="hidden" name="feature_icon[]" value="{{ old('feature_icon.1', 'flaticon-inspiration') }}">
                                    <input type="hidden" name="feature_description[]" value="{{ old('feature_description.1', 'Through the connection to more than 20 national commercial registers, your company data can be imported directly') }}">
                                    
                                    <!-- Feature 3 -->
                                    <input type="hidden" name="feature_title[]" value="{{ old('feature_title.2', 'Allocation within 2 hours') }}">
                                    <input type="hidden" name="feature_icon[]" value="{{ old('feature_icon.2', 'flaticon-profit') }}">
                                    <input type="hidden" name="feature_description[]" value="{{ old('feature_description.2', 'LEI verification by our staff and transmission to the central GLEIF database') }}">
                                    
                                    <!-- About Section -->
                                    <input type="hidden" name="about_subtitle" value="{{ old('about_subtitle', 'What We are Doing') }}">
                                    <input type="hidden" name="about_title" value="{{ old('about_title', 'Changing The Way To Do Best Business Solutions') }}">
                                    <input type="hidden" name="about_description" value="{{ old('about_description', 'Borem ipsum dolor sit amet, consectetur adipiscing elita floraipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt ut labore et dolore magna aliqua Quis suspendisse ultri ces gravida.') }}">
                                    
                                    <!-- Request Section -->
                                    <input type="hidden" name="request_title" value="{{ old('request_title', 'Let\'s request a schedule For free consultation') }}">
                                    <input type="hidden" name="request_phone_label" value="{{ old('request_phone_label', 'Hotline 24/7') }}">
                                    <input type="hidden" name="request_phone_number" value="{{ old('request_phone_number', '+123 8989 444') }}">
                                    <input type="hidden" name="request_button_text" value="{{ old('request_button_text', 'Request a schedule') }}">
                                    <input type="hidden" name="request_button_url" value="{{ old('request_button_url', '/contact') }}">
                                </div>
                                
                                <!-- Registration-LEI page default values -->
                                <div id="registration-lei-page-fields" style="display: none;">
                                    <input type="hidden" name="service_title" value="{{ old('service_title', 'LEI Register Services') }}">
                                    <input type="hidden" name="service_description" value="{{ old('service_description', 'Secure your Legal Entity Identifier with our trusted registration service') }}">
                                    
                                    <input type="hidden" name="plans_title" value="{{ old('plans_title', 'Select a plan') }}">
                                    <input type="hidden" name="plans_description" value="{{ old('plans_description', 'Save money on each annual renewal based on multi-year plans.') }}">
                                    
                                    <input type="hidden" name="plan_1_price" value="{{ old('plan_1_price', '75') }}">
                                    <input type="hidden" name="plan_1_total" value="{{ old('plan_1_total', '75') }}">
                                    <input type="hidden" name="plan_3_price" value="{{ old('plan_3_price', '55') }}">
                                    <input type="hidden" name="plan_3_total" value="{{ old('plan_3_total', '165') }}">
                                    <input type="hidden" name="plan_5_price" value="{{ old('plan_5_price', '50') }}">
                                    <input type="hidden" name="plan_5_total" value="{{ old('plan_5_total', '250') }}">
                                    
                                    <input type="hidden" name="form_title" value="{{ old('form_title', 'Complete the form') }}">
                                    <input type="hidden" name="form_description" value="{{ old('form_description', 'Start typing, and let us fill all the relevant details for you.') }}">
                                    
                                    <input type="hidden" name="tab_register_title" value="{{ old('tab_register_title', 'REGISTER') }}">
                                    <input type="hidden" name="tab_renew_title" value="{{ old('tab_renew_title', 'RENEW') }}">
                                    <input type="hidden" name="tab_transfer_title" value="{{ old('tab_transfer_title', 'TRANSFER') }}">
                                    <input type="hidden" name="tab_renew_description" value="{{ old('tab_renew_description', 'Enter your LEI code or company name to quickly renew your registration.') }}">
                                    <input type="hidden" name="tab_transfer_description" value="{{ old('tab_transfer_description', 'Transfer your existing LEI to our service for better rates and support.') }}">
                                </div>
                                
                                <!-- FAQ Section -->
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">FAQ Section</h5>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="include_faq" name="include_faq" 
                                                value="1" {{ old('include_faq') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="include_faq">Include FAQ Section</label>
                                        </div>
                                    </div>
                                    <div class="card-body" id="faq-section" style="display: {{ old('include_faq') ? 'block' : 'none' }};">
                                        <div id="faq-container">
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
                                                        <textarea name="faq_answer[]" class="form-control faq-editor" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="add-faq-btn" class="btn btn-primary">Add FAQ Item</button>
                                    </div>
                                </div>
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
                                               value="{{ old('meta_title') }}" maxlength="60">
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
                                                  rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
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
                                                     value="{{ old('canonical_url') }}">
                                                <div class="form-text text-muted">Leave empty to use the default URL</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label d-block">Indexing Options</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="no_index" name="no_index" 
                                                         value="1" {{ old('no_index') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="no_index">Hide from search engines</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label d-block">Link Following</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="no_follow" name="no_follow" 
                                                         value="1" {{ old('no_follow') ? 'checked' : '' }}>
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
                                            Page Title
                                        </div>
                                        <div id="seoPreviewUrl" class="text-success" style="font-size: 14px;">
                                            {{ url('/') }}/page-slug
                                        </div>
                                        <div id="seoPreviewDescription" class="mt-1" style="font-size: 14px; color: #4d5156; line-height: 1.58;">
                                            Add a meta description to improve how this page appears in search results.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Create Page
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.tiny.cloud/1/cutdqhmzvugvtosmcaietdon22xvmds3rwygoa51cvknvrwx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE for main content
    tinymce.init({
        selector: '.tinymce',
        height: 450,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        images_upload_url: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}",
    });
    
    // Initialize existing FAQ editors
    document.querySelectorAll('.faq-editor').forEach(function(textarea, index) {
        if (!textarea.id) {
            textarea.id = 'existing-faq-' + index;
        }
        
        tinymce.init({
            selector: '#' + textarea.id,
            height: 200,
            menubar: false,
            plugins: 'link lists image',
            toolbar: 'undo redo | bold italic | bullist numlist | link image',
            images_upload_url: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}"
        });
    });
    
    // Toggle FAQ section visibility
    const includeFaqCheckbox = document.getElementById('include_faq');
    const faqSection = document.getElementById('faq-section');
    
    if (includeFaqCheckbox && faqSection) {
        includeFaqCheckbox.addEventListener('change', function() {
            faqSection.style.display = this.checked ? 'block' : 'none';
        });
    }
    
    // Get elements
    const slugInput = document.getElementById('slug');
    const homePageFields = document.getElementById('home-page-fields');
    const registrationLeiPageFields = document.getElementById('registration-lei-page-fields');
    
    // Function to toggle fields based on slug
    function togglePageFields() {
        if (slugInput.value === 'home') {
            homePageFields.style.display = 'none'; // Hidden inputs are still active
            registrationLeiPageFields.style.display = 'none';
        } else if (slugInput.value === 'registration-lei') {
            homePageFields.style.display = 'none';
            registrationLeiPageFields.style.display = 'none'; // Hidden inputs are still active
        } else {
            homePageFields.style.display = 'none';
            registrationLeiPageFields.style.display = 'none';
        }
    }
    
    // Initial toggle
    togglePageFields();
    
    // Add event listener to slug input
    slugInput.addEventListener('input', togglePageFields);
    
    // Title to slug conversion
    const nameInput = document.getElementById('name');
    const titleInput = document.getElementById('title');
    
    // Auto-populate title from name if title is empty
    if (nameInput && titleInput && titleInput.value === '') {
        nameInput.addEventListener('input', function() {
            if (titleInput.value === '') {
                titleInput.value = this.value;
                // Trigger the title input event to update slug if needed
                titleInput.dispatchEvent(new Event('input'));
            }
        });
    }
    
    // Auto-generate slug from title
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            // Create slug from title (lowercase, replace spaces with dashes, remove special chars)
            slugInput.value = this.value.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-')     // Replace spaces with dashes
                .replace(/-+/g, '-');     // Remove consecutive dashes
            
            // After changing slug, check if we need to show/hide specific fields
            togglePageFields();
        });
    }
    
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
    
    // Update title preview when title input changes
    if (titleInput && seoPreviewTitle) {
        titleInput.addEventListener('input', function() {
            if (!metaTitle || !metaTitle.value) {
                seoPreviewTitle.textContent = this.value || 'Page Title';
            }
        });
    }
    
    // Update URL in SEO preview when slug changes
    if (slugInput && seoPreviewUrl) {
        slugInput.addEventListener('input', function() {
            seoPreviewUrl.textContent = "{{ url('/') }}/" + this.value;
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
    function addFaqItem(container) {
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
                    <input type="text" name="faq_question[]" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Answer</label>
                    <textarea id="${newId}" name="faq_answer[]" class="form-control" rows="3"></textarea>
                </div>
            </div>
        `;
        
        container.appendChild(newItem);
        
        // Initialize TinyMCE for the new textarea
        tinymce.init({
            selector: '#' + newId,
            height: 200,
            menubar: false,
            plugins: 'link lists image',
            toolbar: 'undo redo | bold italic | bullist numlist | link image',
            images_upload_url: "{{ route('admin.pages.upload-image', ['_token' => csrf_token()]) }}"
        });
    }
    
    // Add FAQ button functionality
    var addFaqBtn = document.getElementById('add-faq-btn');
    if (addFaqBtn) {
        addFaqBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('faq-container');
            if (container) {
                addFaqItem(container);
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
});
</script>
@endsection