@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">User Details</h1>
                <div>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Personal Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Username:</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Full Name:</th>
                            <td>{{ $user->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $user->complete_phone ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($user->is_active ?? true)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Registered:</th>
                            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Email Verified:</th>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                    <small class="text-muted d-block">{{ $user->email_verified_at->format('Y-m-d H:i') }}</small>
                                @else
                                    <span class="badge bg-warning">Not Verified</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Company Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-building"></i> Company & Address</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Company Name:</th>
                            <td>{{ $user->company_name }}</td>
                        </tr>
                        <tr>
                            <th>Address Line 1:</th>
                            <td>{{ $user->address_line_1 ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address Line 2:</th>
                            <td>{{ $user->address_line_2 ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>City:</th>
                            <td>{{ $user->city ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>State:</th>
                            <td>{{ $user->state ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Country:</th>
                            <td>
                                @if($user->country)
                                    <img src="https://flagcdn.com/24x18/{{ strtolower($user->country) }}.png" 
                                         class="me-2" 
                                         alt="{{ $user->country }}"
                                         onerror="this.style.display='none'">
                                    {{ $user->country }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Postal Code:</th>
                            <td>{{ $user->postal_code ?: 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- LEI Registrations -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> LEI Registrations</h5>
                </div>
                <div class="card-body">
                    @if($user->leiRegistrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>LEI Code</th>
                                        <th>Company Name</th>
                                        <th>Type</th>
                                        <th>Plan</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->leiRegistrations as $lei)
                                        <tr>
                                            <td>{{ $lei->registration_id ?: 'Pending' }}</td>
                                            <td>{{ $lei->legal_entity_name }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ ucfirst($lei->type) }}</span>
                                            </td>
                                            <td>{{ ucfirst(str_replace('-', ' ', $lei->selected_plan)) }}</td>
                                            <td>${{ number_format($lei->amount, 2) }}</td>
                                            <td>
                                                @if($lei->payment_status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <span class="badge bg-warning">{{ ucfirst($lei->payment_status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $lei->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('admin.contact.show', $lei->id) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted py-3">No LEI registrations found for this user.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-shield-alt"></i> Account Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Terms Accepted:</strong> 
                                @if($user->terms_accepted)
                                    <span class="badge bg-success">Yes</span>
                                    @if($user->terms_accepted_at)
                                        <small class="text-muted">on {{ $user->terms_accepted_at->format('Y-m-d H:i') }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Privacy Policy Accepted:</strong> 
                                @if($user->privacy_accepted)
                                    <span class="badge bg-success">Yes</span>
                                    @if($user->privacy_accepted_at)
                                        <small class="text-muted">on {{ $user->privacy_accepted_at->format('Y-m-d H:i') }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection