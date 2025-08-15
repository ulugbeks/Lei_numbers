<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.contacts') }}"><i class="fas fa-envelope"></i> Contacts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.pages.index') }}">
                        <i class="fas fa-file-lines"></i> Pages
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.documents.index') }}">
                        <i class="fas fa-file-alt"></i> Documents
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.blogs.index') }}">
                        <i class="fas fa-newspaper"></i> News
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.menus.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-bars"></i> Menus
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.payments') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        Payment Report
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <span class="brand-text font-weight-light">Admin Panel</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contacts') }}" class="nav-link">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Contacts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-lines"></i>
                                <p>Pages</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{ route('admin.documents.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Documents</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="{{ route('admin.blogs.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>News</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.menus.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>Menus</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.payments') }}" class="nav-link">
                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>Payment Report</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="display: none;">х</button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- AdminLTE JS -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Replace CKEditor with TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/cutdqhmzvugvtosmcaietdon22xvmds3rwygoa51cvknvrwx/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - Initializing TinyMCE');
    
    // Initialize TinyMCE for main content
    if (document.getElementById('main_content')) {
        tinymce.init({
            selector: '#main_content',
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
        });
    }
    
    // Initialize existing FAQ editors
    document.querySelectorAll('.faq-editor, .ckeditor-faq').forEach(function(textarea, index) {
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
    
    // Function to add a new FAQ item
    function addFaqItem(container, fieldNamePrefix) {
        console.log('Adding FAQ item to container: ' + container.id);
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
        console.log('Added new FAQ item with ID: ' + newId);
        
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
    
    // Find all Add FAQ buttons
    document.querySelectorAll('button').forEach(function(btn) {
        if (btn.innerText.trim() === 'Add FAQ Item') {
            console.log('Found Add FAQ Item button: ' + (btn.id || 'no-id'));
            
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Find the closest container
                var container;
                if (this.closest('#faq-content')) {
                    container = document.getElementById('faq-container');
                } else if (document.getElementById('aboutlei-faq-container') && 
                            this.closest('form').contains(document.getElementById('aboutlei-faq-container'))) {
                    container = document.getElementById('aboutlei-faq-container');
                } else {
                    console.error('Could not find a FAQ container');
                    return;
                }
                
                // Determine prefix based on container
                var prefix = container.id === 'aboutlei-faq-container' ? 'aboutlei_faq' : 'faq';
                addFaqItem(container, prefix);
            });
        }
    });
    
    // Direct targeting for specific buttons (if they have IDs)
    var addFaqBtn = document.getElementById('add-faq-btn');
    if (addFaqBtn) {
        console.log('Found add-faq-btn via ID');
        addFaqBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('faq-container');
            if (container) {
                addFaqItem(container, 'faq');
            } else {
                console.error('Could not find faq-container');
            }
        });
    }
    
    // Add About LEI FAQ button functionality
    var addAboutLeiFaqBtn = document.getElementById('add-aboutlei-faq-btn');
    if (addAboutLeiFaqBtn) {
        console.log('Found add-aboutlei-faq-btn via ID');
        addAboutLeiFaqBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var container = document.getElementById('aboutlei-faq-container');
            if (container) {
                addFaqItem(container, 'aboutlei_faq');
            } else {
                console.error('Could not find aboutlei-faq-container');
            }
        });
    }
    
    // Remove FAQ item functionality
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-faq')) {
            console.log('Remove FAQ button clicked');
            var faqItem = e.target.closest('.faq-item');
            
            // Find textarea and destroy TinyMCE instance
            var textarea = faqItem.querySelector('textarea');
            if (textarea && textarea.id) {
                var editorInstance = tinymce.get(textarea.id);
                if (editorInstance) {
                    editorInstance.remove();
                    console.log('Removed TinyMCE instance: ' + textarea.id);
                }
            }
            
            faqItem.remove();
            console.log('FAQ item removed');
        }
    });
});
</script>

<script>
    // Add this to your edit.blade.php file in a script tag at the bottom
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE for all relevant textareas
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '.tinymce',
            height: 300,
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
        });
        
        // Smaller editor for feature descriptions
        tinymce.init({
            selector: '.tinymce-mini',
            height: 150,
            menubar: false,
            forced_root_block: 'p',
forced_root_block_attrs: {
    'data-mce-empty': '1'  // Custom attribute to identify empty paragraphs
},
            plugins: 'link lists',
            toolbar: 'undo redo | bold italic | bullist numlist | link',
        });
    }
    
    // Add feature button functionality
    var addFeatureBtn = document.getElementById('add-feature-btn');
    if (addFeatureBtn) {
        addFeatureBtn.addEventListener('click', function() {
            var container = document.getElementById('features-container');
            if (container) {
                var count = container.querySelectorAll('.feature-item').length + 1;
                var newId = 'feature-desc-' + count;
                
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
                            <textarea id="${newId}" name="feature_description[]" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                `;
                
                container.appendChild(newItem);
                
                // Initialize TinyMCE for the new textarea
                if (typeof tinymce !== 'undefined') {
                    tinymce.init({
                        selector: '#' + newId,
                        height: 150,
                        menubar: false,
                        plugins: 'link lists',
                        toolbar: 'undo redo | bold italic | bullist numlist | link',
                    });
                }
            }
        });
    }
    
    // Remove feature functionality
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-feature')) {
            if (confirm('Are you sure you want to remove this feature?')) {
                var featureItem = e.target.closest('.feature-item');
                
                // Check if there's a TinyMCE instance for the textarea
                var textarea = featureItem.querySelector('textarea');
                if (textarea && textarea.id && typeof tinymce !== 'undefined') {
                    var editor = tinymce.get(textarea.id);
                    if (editor) {
                        editor.remove();
                    }
                }
                
                featureItem.remove();
            }
        }
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find all success alert messages
        const successAlerts = document.querySelectorAll('.alert-success');
        
        // Apply auto-hide to each alert
        successAlerts.forEach(function(alert) {
            // Set timeout for 3 seconds
            setTimeout(function() {
                // Add fade out transition
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                
                // Remove from DOM after fade completes
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 3000); // 3 seconds before starting fade
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable lists
    const sortableLists = document.querySelectorAll('.menu-items-sortable');
    sortableLists.forEach(function(list) {
        new Sortable(list, {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: function(evt) {
                saveMenuOrder();
            }
        });
    });
    
    // Edit menu item
    const editButtons = document.querySelectorAll('.edit-item');
    editButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const data = this.dataset;
            
            document.getElementById('menuItemForm').action = "{{ route('admin.menus.items.update', '') }}/" + data.id;
            document.getElementById('menuItemForm').method = 'POST';
            
            // Add method override for PUT request
            let methodInput = document.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                document.getElementById('menuItemForm').appendChild(methodInput);
            }
            methodInput.value = 'PUT';
            
            document.getElementById('menuItemId').value = data.id;
            document.getElementById('title').value = data.title;
            document.getElementById('url').value = data.url;
            document.getElementById('route_name').value = data.route;
            document.getElementById('icon').value = data.icon;
            document.getElementById('target').value = data.target;
            document.getElementById('parent_id').value = data.parent;
            document.getElementById('order').value = data.order;
            document.getElementById('active').checked = data.active === '1';
            
            document.querySelector('.card-header.bg-success').innerText = 'Edit Menu Item';
            document.querySelector('button[type="submit"]').innerText = 'Update Item';
            
            // Add a cancel button
            let cancelBtn = document.getElementById('cancelEditBtn');
            if (!cancelBtn) {
                cancelBtn = document.createElement('button');
                cancelBtn.id = 'cancelEditBtn';
                cancelBtn.className = 'btn btn-secondary ml-2';
                cancelBtn.type = 'button';
                cancelBtn.innerText = 'Cancel';
                document.querySelector('button[type="submit"]').after(cancelBtn);
                
                cancelBtn.addEventListener('click', resetForm);
            }
            cancelBtn.style.display = 'inline-block';
        });
    });
    
    // Reset form
    function resetForm() {
         document.getElementById('menuItemForm').reset();
    
        @if(isset($menu))
        document.getElementById('menuItemForm').action = "{{ route('admin.menus.items.store', $menu) }}";
        @else
        document.getElementById('menuItemForm').action = "{{ route('admin.menus.items.store', 1) }}"; // Default value or handle differently
        @endif
        
        document.getElementById('menuItemForm').method = 'POST';
        
        // Remove method override
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
        }
        
        document.getElementById('menuItemId').value = '';
        document.querySelector('.card-header.bg-success').innerText = 'Add New Menu Item';
        document.querySelector('button[type="submit"]').innerText = 'Add Item';
        
        const cancelBtn = document.getElementById('cancelEditBtn');
        if (cancelBtn) {
            cancelBtn.style.display = 'none';
        }
    }
    
    // Save menu order
    function saveMenuOrder() {
        const items = {};
        let order = 0;
        
        // Process all menu items
        document.querySelectorAll('.menu-items-sortable > li').forEach(function(item) {
            processItem(item, null, order++);
        });
        
        // Send the data to the server
        fetch('{{ route('admin.menus.items.reorder') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Menu order saved successfully');
            }
        })
        .catch(error => {
            console.error('Error saving menu order:', error);
        });
        
        // Process nested items
        function processItem(item, parentId, itemOrder) {
            const id = item.dataset.id;
            items[id] = {
                parent_id: parentId,
                order: itemOrder
            };
            
            // Process children
            const childContainer = item.querySelector('ul.menu-items-sortable');
            if (childContainer) {
                let childOrder = 0;
                childContainer.querySelectorAll(':scope > li').forEach(function(child) {
                    processItem(child, id, childOrder++);
                });
            }
        }
    }
});

</script>
</body>
</html>
