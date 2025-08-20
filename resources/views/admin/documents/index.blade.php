@extends('layouts.admin')

@section('title', 'Documents')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Documents</h5>
            <div>
                @php
                    $documentsPage = \App\Models\Page::where('slug', 'documents')->first();
                @endphp
                @if($documentsPage)
                    <a href="{{ route('admin.pages.edit', $documentsPage->id) }}" class="btn btn-info me-2">
                        <i class="fas fa-cog"></i> Page SEO Settings
                    </a>
                @endif
                <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Upload New Document
                </a>
            </div>
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

            <!-- Info Alert about SEO Settings -->
            @if(!$documentsPage)
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>SEO Settings Missing:</strong> 
                    The Documents page is not found in the database. Please create it in 
                    <a href="{{ route('admin.pages.index') }}" class="alert-link">Pages management</a> 
                    with slug "documents" to manage SEO settings.
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped sortable-table">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">Order</th>
                            <th width="60" class="text-center">Icon</th>
                            <th>Title</th>
                            <th>File Name</th>
                            <th width="100">Size</th>
                            <th width="100" class="text-center">Downloads</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="200" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-documents">
                        @forelse($documents as $document)
                        <tr data-id="{{ $document->id }}">
                            <td class="text-center drag-handle">
                                <i class="fas fa-grip-vertical text-muted"></i>
                                <input type="hidden" class="order-input" value="{{ $document->order }}">
                            </td>
                            <td class="text-center">
                                <i class="{{ $document->file_icon }} fa-2x"></i>
                            </td>
                            <td>
                                <strong>{{ $document->title }}</strong>
                                @if($document->description)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($document->description, 100) }}</small>
                                @endif
                            </td>
                            <td>
                                <small>{{ $document->file_name }}</small>
                            </td>
                            <td>
                                <small>{{ $document->formatted_file_size }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $document->download_count }}</span>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input document-status-toggle" 
                                           type="checkbox" 
                                           data-id="{{ $document->id }}"
                                           {{ $document->status ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ asset('storage/' . $document->file_path) }}" 
                                       target="_blank"
                                       class="btn btn-info"
                                       title="Preview">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.documents.edit', $document) }}" 
                                       class="btn btn-primary"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger"
                                            onclick="if(confirm('Are you sure you want to delete this document?')) { 
                                                document.getElementById('delete-form-{{ $document->id }}').submit(); 
                                            }"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $document->id }}" 
                                      action="{{ route('admin.documents.destroy', $document) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <p class="mb-0">No documents found.</p>
                                <a href="{{ route('admin.documents.create') }}" class="btn btn-primary mt-2">
                                    Upload First Document
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable
    const sortableTable = document.getElementById('sortable-documents');
    if (sortableTable) {
        new Sortable(sortableTable, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function(evt) {
                updateOrder();
            }
        });
    }
    
    // Update order function
    function updateOrder() {
        const documents = [];
        document.querySelectorAll('#sortable-documents tr').forEach(function(row, index) {
            documents.push({
                id: row.dataset.id,
                order: index
            });
        });
        
        // Send AJAX request to update order
        fetch('{{ route("admin.documents.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ documents: documents })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Order updated successfully');
            }
        })
        .catch(error => {
            console.error('Error updating order:', error);
        });
    }
    
    // Handle status toggle
    document.querySelectorAll('.document-status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const documentId = this.dataset.id;
            const isChecked = this.checked;
            
            fetch(`/backend/documents/${documentId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Revert the toggle if failed
                    this.checked = !isChecked;
                    alert('Error updating document status');
                }
            })
            .catch(error => {
                // Revert the toggle if error
                this.checked = !isChecked;
                alert('Error updating document status');
            });
        });
    });
});
</script>

<style>
.drag-handle {
    cursor: move;
}

.sortable-ghost {
    opacity: 0.5;
    background: #f8f9fa;
}

.table tbody tr {
    transition: background-color 0.3s;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
@endsection