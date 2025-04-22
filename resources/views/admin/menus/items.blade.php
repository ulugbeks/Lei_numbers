@extends('layouts.admin')

@section('title', 'Manage Menu Items')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Menu Items: {{ $menu->name }}</h3>
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back to Menus
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Menu Items List -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    Current Menu Items
                                </div>
                                <div class="card-body">
                                    <div id="menu-items-container">
                                        @if($menuItems->isEmpty())
                                            <p class="text-center">No menu items found. Add your first item using the form.</p>
                                        @else
                                            <ul class="list-group menu-items-sortable">
                                                @foreach($menuItems as $item)
                                                    @include('admin.menus.partials.menu-item', ['item' => $item])
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Add/Edit Menu Item Form -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    Add New Menu Item
                                </div>
                                <div class="card-body">
                                    <form id="menuItemForm" action="{{ route('admin.menus.items.store', $menu) }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="_method" id="formMethod" value="POST">

                                        <input type="hidden" id="menuItemId" name="menu_item_id">
                                        
                                        <div class="form-group">
                                            <label for="title">Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="url">URL</label>
                                            <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror">
                                            @error('url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Leave empty if using route name</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="route_name">Route Name</label>
                                            <input type="text" name="route_name" id="route_name" class="form-control @error('route_name') is-invalid @enderror">
                                            @error('route_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Leave empty if using direct URL</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="icon">Icon Class</label>
                                            <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror">
                                            @error('icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">FontAwesome class (e.g., fas fa-home)</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="target">Target</label>
                                            <select name="target" id="target" class="form-control @error('target') is-invalid @enderror">
                                                <option value="_self">Same Window (_self)</option>
                                                <option value="_blank">New Window (_blank)</option>
                                            </select>
                                            @error('target')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="parent_id">Parent Item</label>
                                            <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                                <option value="">None (Root Item)</option>
                                                @foreach($allMenuItems as $menuItem)
                                                    <option value="{{ $menuItem->id }}">{{ $menuItem->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="order">Order</label>
                                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" min="0" value="0">
                                            @error('order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                                                <label class="custom-control-label" for="active">Active</label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Add Item</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('edit-item') || 
            (e.target.parentElement && e.target.parentElement.classList.contains('edit-item'))) {
            
            const btn = e.target.classList.contains('edit-item') ? e.target : e.target.parentElement;
            const data = btn.dataset;
            
            // Get the form and update its action and method
            const form = document.getElementById('menuItemForm');
            form.action = "{{ route('admin.menus.items.update', '') }}/" + data.id;
            
            // IMPORTANT: Set the method field to PUT
            document.getElementById('formMethod').value = 'PUT';
            
            // Fill in the form data
            document.getElementById('menuItemId').value = data.id;
            document.getElementById('title').value = data.title;
            document.getElementById('url').value = data.url || '';
            document.getElementById('route_name').value = data.route || '';
            document.getElementById('icon').value = data.icon || '';
            document.getElementById('target').value = data.target;
            document.getElementById('parent_id').value = data.parent || '';
            document.getElementById('order').value = data.order;
            document.getElementById('active').checked = data.active === '1';
            
            // Update the UI to show we're in edit mode
            document.querySelector('.card-header.bg-success').textContent = 'Edit Menu Item';
            
            // Change the button text to "Update Item"
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.textContent = 'Update Item';
            submitBtn.classList.remove('btn-success');
            submitBtn.classList.add('btn-primary');
            
            // Add a cancel button if it doesn't exist
            let cancelBtn = document.getElementById('cancelEditBtn');
            if (!cancelBtn) {
                cancelBtn = document.createElement('button');
                cancelBtn.id = 'cancelEditBtn';
                cancelBtn.className = 'btn btn-secondary ml-2';
                cancelBtn.type = 'button';
                cancelBtn.textContent = 'Cancel';
                submitBtn.after(cancelBtn);
                
                cancelBtn.addEventListener('click', resetForm);
            }
            cancelBtn.style.display = 'inline-block';
        }
    });
    
    // Reset form
    function resetForm() {
        const form = document.getElementById('menuItemForm');
        form.reset();
        form.action = "{{ route('admin.menus.items.store', $menu) }}";
        
        // Reset method to POST for adding new items
        document.getElementById('formMethod').value = 'POST';
        
        // Reset form fields and UI
        document.getElementById('menuItemId').value = '';
        document.querySelector('.card-header.bg-success').textContent = 'Add New Menu Item';
        
        // Reset the submit button
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.textContent = 'Add Item';
        submitBtn.classList.remove('btn-primary');
        submitBtn.classList.add('btn-success');
        
        // Hide cancel button
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
        document.querySelectorAll('.menu-items-sortable > li').forEach(function(item, index) {
            processItem(item, null, index);
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
                childContainer.querySelectorAll(':scope > li').forEach(function(child, index) {
                    processItem(child, id, index);
                });
            }
        }
    }
});
</script>
@endsection
