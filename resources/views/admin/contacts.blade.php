@extends('layouts.admin')

@section('title', 'Contacts')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Contact Requests</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.contacts.export.csv') }}" class="btn btn-success">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
            <a href="{{ route('admin.contacts.export.xlsx') }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Contacts</h6>
                            <h3 class="mb-0">{{ $contacts->count() }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Paid</h6>
                            <h3 class="mb-0 text-success">{{ $contacts->where('payment_status', 'paid')->count() }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending</h6>
                            <h3 class="mb-0 text-warning">{{ $contacts->where('payment_status', 'pending')->count() }}</h3>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-clock fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Revenue</h6>
                            <h3 class="mb-0">${{ number_format($contacts->where('payment_status', 'paid')->sum('amount'), 2) }}</h3>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 text-center" style="width: 60px;">ID</th>
                            <th class="border-0" style="min-width: 80px;">Country</th>
                            <th class="border-0" style="min-width: 150px;">Contact</th>
                            <th class="border-0" style="min-width: 200px;">Company</th>
                            <th class="border-0" style="min-width: 180px;">Registration ID</th>
                            <th class="border-0" style="min-width: 100px;">Plan</th>
                            <th class="border-0 text-end" style="min-width: 100px;">Amount</th>
                            <th class="border-0 text-center" style="min-width: 100px;">Documents</th>
                            <th class="border-0 text-center" style="min-width: 100px;">Status</th>
                            <th class="border-0" style="min-width: 100px;">Date</th>
                            <th class="border-0 text-center" style="min-width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr>
                            <td class="text-center align-middle">
                                <span class="text-muted">#{{ $contact->id }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="https://flagcdn.com/24x18/{{ strtolower($contact->country) }}.png" 
                                         class="me-2" 
                                         alt="{{ $contact->country }}"
                                         onerror="this.style.display='none'">
                                    <span>{{ $contact->country }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div>
                                    <div class="fw-semibold">{{ $contact->full_name }}</div>
                                    <div class="small text-muted">
                                        <i class="fas fa-envelope fa-xs"></i> {{ $contact->email }}
                                    </div>
                                    <div class="small text-muted">
                                        <i class="fas fa-phone fa-xs"></i> {{ $contact->phone }}
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $contact->legal_entity_name ?: $contact->company_name }}">
                                    {{ $contact->legal_entity_name ?: $contact->company_name }}
                                </div>
                                @if($contact->registration_id)
                                    <div class="small text-muted">ID: {{ $contact->registration_id }}</div>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="small">
                                    <div><i class="fas fa-map-marker-alt fa-xs text-muted"></i> {{ $contact->address }}</div>
                                    <div>{{ $contact->city }}, {{ $contact->zip_code }}</div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-secondary">{{ $contact->selected_plan }}</span>
                            </td>
                            <td class="align-middle text-end">
                                <span class="fw-semibold">${{ number_format($contact->amount, 2) }}</span>
                            </td>
                            <td class="align-middle text-center">
                                @php
                                    $documentCount = 0;
                                    if($contact->company_excerpt_path) $documentCount++;
                                    if($contact->user_id_document_path) $documentCount++;
                                    if($contact->document_path) $documentCount++;
                                @endphp
                                
                                @if($documentCount > 0)
                                    <span class="badge bg-info">
                                        <i class="fas fa-paperclip"></i> {{ $documentCount }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($contact->payment_status == 'paid')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Paid
                                    </span>
                                @elseif($contact->payment_status == 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        {{ ucfirst($contact->payment_status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="small text-muted">
                                    {{ $contact->created_at->format('Y-m-d') }}
                                    <br>
                                    <span class="text-xs">{{ $contact->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.contact.show', $contact->id) }}" 
                                       class="btn btn-outline-info" 
                                       data-bs-toggle="tooltip" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contact.destroy', $contact->id) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                No contacts found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styles for the contacts page */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table {
    min-width: 1200px;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem;
    white-space: nowrap;
}

.table td {
    padding: 0.75rem 1rem;
    vertical-align: middle;
}

.table tbody tr {
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.15s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.opacity-50 {
    opacity: 0.5;
}

.text-xs {
    font-size: 0.75rem;
}

/* Scrollbar styling */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Card shadow on hover */
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Status badge animations */
.badge {
    transition: transform 0.2s ease;
}

.badge:hover {
    transform: scale(1.05);
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .table {
        font-size: 0.875rem;
    }
    
    .table th, .table td {
        padding: 0.5rem;
    }
}
</style>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection