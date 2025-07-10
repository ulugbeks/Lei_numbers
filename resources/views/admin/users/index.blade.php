@extends('layouts.admin')

@section('title', 'Registered Users')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Registered Users</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.users.export.csv') }}" class="btn btn-success">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
            <a href="{{ route('admin.users.export.xlsx') }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Name, Email, Username, Company..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" 
                           value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" 
                           value="{{ request('to_date') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Users</h6>
                            <h3 class="mb-0">{{ \App\Models\User::count() }}</h3>
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
                            <h6 class="text-muted mb-2">Active Users</h6>
                            <h3 class="mb-0 text-success">{{ \App\Models\User::where('is_active', true)->count() }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-user-check fa-2x opacity-50"></i>
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
                            <h6 class="text-muted mb-2">This Month</h6>
                            <h3 class="mb-0 text-info">{{ \App\Models\User::whereMonth('created_at', date('m'))->count() }}</h3>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
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
                            <h6 class="text-muted mb-2">With LEI</h6>
                            <h3 class="mb-0 text-warning">{{ \App\Models\User::has('leiRegistrations')->count() }}</h3>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-id-card fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 text-center" style="width: 60px;">ID</th>
                            <th class="border-0" style="min-width: 150px;">User</th>
                            <th class="border-0" style="min-width: 200px;">Contact</th>
                            <th class="border-0" style="min-width: 200px;">Company</th>
                            <th class="border-0" style="min-width: 150px;">Location</th>
                            <th class="border-0 text-center" style="min-width: 100px;">LEI Count</th>
                            <th class="border-0 text-center" style="min-width: 100px;">Status</th>
                            <th class="border-0" style="min-width: 120px;">Registered</th>
                            <th class="border-0 text-center" style="min-width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="text-center align-middle">
                                <span class="text-muted">#{{ $user->id }}</span>
                            </td>
                            <td class="align-middle">
                                <div>
                                    <div class="fw-semibold">{{ $user->full_name }}</div>
                                    <div class="small text-muted">
                                        <i class="fas fa-at fa-xs"></i> {{ $user->username }}
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div>
                                    <div class="small">
                                        <i class="fas fa-envelope fa-xs text-muted"></i> {{ $user->email }}
                                    </div>
                                    <div class="small">
                                        <i class="fas fa-phone fa-xs text-muted"></i> {{ $user->complete_phone ?: 'N/A' }}
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                {{ $user->company_name }}
                            </td>
                            <td class="align-middle">
                                <div class="small">
                                    @if($user->country)
                                        <img src="https://flagcdn.com/24x18/{{ strtolower($user->country) }}.png" 
                                             class="me-1" 
                                             alt="{{ $user->country }}"
                                             onerror="this.style.display='none'">
                                    @endif
                                    {{ $user->city ?: 'N/A' }}, {{ $user->country ?: 'N/A' }}
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                @php
                                    $leiCount = $user->leiRegistrations()->count();
                                @endphp
                                @if($leiCount > 0)
                                    <span class="badge bg-info">{{ $leiCount }}</span>
                                @else
                                    <span class="text-muted">0</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input user-status-toggle" 
                                           type="checkbox" 
                                           data-user-id="{{ $user->id }}"
                                           {{ ($user->is_active ?? true) ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="small text-muted">
                                    {{ $user->created_at->format('Y-m-d') }}
                                    <br>
                                    <span class="text-xs">{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="btn btn-outline-info" 
                                       data-bs-toggle="tooltip" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn btn-outline-primary" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->leiRegistrations()->count() == 0)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                No users found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
            <div class="card-footer">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Handle status toggle
    document.querySelectorAll('.user-status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const isChecked = this.checked;
            
            fetch(`/backend/users/${userId}/toggle-status`, {
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
                    alert('Error updating user status');
                }
            })
            .catch(error => {
                // Revert the toggle if error
                this.checked = !isChecked;
                alert('Error updating user status');
            });
        });
    });
});
</script>
@endsection