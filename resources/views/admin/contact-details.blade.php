@extends('layouts.admin')

@section('title', 'Contact Details')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Contact Details</h1>
                <a href="{{ route('admin.contacts') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contact Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Contact Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Full Name:</th>
                            <td>{{ $contact->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $contact->phone }}</td>
                        </tr>
                        <tr>
                            <th>Country:</th>
                            <td>
                                <img src="https://flagcdn.com/24x18/{{ strtolower($contact->country) }}.png" 
                                     class="me-2" 
                                     alt="{{ $contact->country }}"
                                     onerror="this.style.display='none'">
                                {{ $contact->country }}
                            </td>
                        </tr>
                        <tr>
                            <th>Submission Date:</th>
                            <td>{{ $contact->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Company Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-building"></i> Company Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Legal Entity Name:</th>
                            <td>{{ $contact->legal_entity_name }}</td>
                        </tr>
                        <tr>
                            <th>Registration ID:</th>
                            <td>{{ $contact->registration_id ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $contact->address }}</td>
                        </tr>
                        <tr>
                            <th>City:</th>
                            <td>{{ $contact->city }}</td>
                        </tr>
                        <tr>
                            <th>ZIP Code:</th>
                            <td>{{ $contact->zip_code }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Registration Details Card -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Registration Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Selected Plan:</th>
                            <td><span class="badge bg-secondary">{{ $contact->selected_plan }}</span></td>
                        </tr>
                        <tr>
                            <th>Amount:</th>
                            <td class="h5">${{ number_format($contact->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Payment Status:</th>
                            <td>
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
                        </tr>
                        <tr>
                            <th>Same Address:</th>
                            <td>
                                @if($contact->same_address)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Private Controlled:</th>
                            <td>
                                @if($contact->private_controlled)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Uploaded Documents Card -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-file-alt"></i> Uploaded Documents</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Company Excerpt:</th>
                            <td>
                                @if($contact->company_excerpt_path)
                                    <a href="{{ asset('storage/' . $contact->company_excerpt_path) }}" 
                                       class="btn btn-sm btn-primary" 
                                       target="_blank">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <small class="text-muted d-block mt-1">
                                        {{ basename($contact->company_excerpt_path) }}
                                    </small>
                                @else
                                    <span class="text-muted">Not uploaded</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>ID Document:</th>
                            <td>
                                @if($contact->user_id_document_path)
                                    <a href="{{ asset('storage/' . $contact->user_id_document_path) }}" 
                                       class="btn btn-sm btn-primary" 
                                       target="_blank">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <small class="text-muted d-block mt-1">
                                        {{ basename($contact->user_id_document_path) }}
                                    </small>
                                @else
                                    <span class="text-muted">Not uploaded</span>
                                @endif
                            </td>
                        </tr>
                        @if($contact->document_path)
                        <tr>
                            <th>Other Document:</th>
                            <td>
                                <a href="{{ asset('storage/' . $contact->document_path) }}" 
                                   class="btn btn-sm btn-primary" 
                                   target="_blank">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <small class="text-muted d-block mt-1">
                                    {{ basename($contact->document_path) }}
                                </small>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.contacts') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <form action="{{ route('admin.contact.destroy', $contact->id) }}" 
                              method="POST" 
                              class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this contact?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Contact
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection