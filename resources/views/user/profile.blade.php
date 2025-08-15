@extends('layouts.auth-app')

@section('title', 'My Profile - Trusted LEI')

@section('content')

@include('partials.header')

<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('assets/img/bg/breadcrumb_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">My Profile</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
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

    <!-- profile-area -->
    <section class="profile-area section-py-120">
        <div class="container">
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

            <div class="row">
                <!-- Profile Sidebar -->
                <div class="col-lg-3">
                    <div class="profile-sidebar">
                        <div class="profile-info text-center mb-4">
                            <div class="profile-avatar mb-3">
                                <i class="fas fa-user-circle" style="font-size: 100px; color: #ccc;"></i>
                            </div>
                            <h4>{{ $user->full_name }}</h4>
                            <!-- <p class="text-muted">@{{ $user->username }}</p> -->
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                        
                        <ul class="profile-menu">
                            <li class="active">
                                <a href="#profile-info" class="tab-link">
                                    <i class="fas fa-user"></i> Profile Information
                                </a>
                            </li>
                            <li>
                                <a href="#lei-history" class="tab-link">
                                    <i class="fas fa-history"></i> LEI history
                                </a>
                            </li>
                            <li>
                                <a href="#change-password" class="tab-link">
                                    <i class="fas fa-lock"></i> Change Password
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-link">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="col-lg-9">
                    <div class="tab-content" style="display: unset; padding: unset;">
                        <!-- Profile Information Tab -->
                        <div class="tab-pane fade show active" id="profile-info">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Profile Information</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.profile.update') }}" method="POST">
                                        @csrf
                                        
                                        <!-- Personal Information -->
                                        <div class="form-section mb-4">
                                            <h5 class="section-title">Personal Information</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-grp">
                                                        <label for="username">Username</label>
                                                        <input type="text" id="username" name="username" value="{{ $user->username }}" required>
                                                        @error('username')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-grp">
                                                        <label for="email">Email Address</label>
                                                        <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-grp">
                                                        <label for="first_name">First Name</label>
                                                        <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="form-grp">
                                                        <label for="middle_name">Middle Name</label>
                                                        <input type="text" id="middle_name" name="middle_name" value="{{ $user->middle_name }}">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-5">
                                                    <div class="form-grp">
                                                        <label for="last_name">Last Name</label>
                                                        <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="form-grp">
                                                        <label for="suffix">Suffix</label>
                                                        <input type="text" id="suffix" name="suffix" value="{{ $user->suffix }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Company & Contact Information -->
                                        <div class="form-section mb-4">
                                            <h5 class="section-title">Company & Contact Information</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-grp">
                                                        <label for="company_name">Company Name</label>
                                                        <input type="text" id="company_name" name="company_name" value="{{ $user->company_name }}" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-grp">
                                                        <label for="phone_country_code">Country Code</label>
                                                        <select name="phone_country_code" id="phone_country_code" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="+1" {{ $user->phone_country_code == '+1' ? 'selected' : '' }}>+1 (US)</option>
                                                            <option value="+44" {{ $user->phone_country_code == '+44' ? 'selected' : '' }}>+44 (UK)</option>
                                                            <option value="+49" {{ $user->phone_country_code == '+49' ? 'selected' : '' }}>+49 (DE)</option>
                                                            <option value="+33" {{ $user->phone_country_code == '+33' ? 'selected' : '' }}>+33 (FR)</option>
                                                            <option value="+371" {{ $user->phone_country_code == '+371' ? 'selected' : '' }}>+371 (LV)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-9">
                                                    <div class="form-grp">
                                                        <label for="phone">Phone Number</label>
                                                        <input type="tel" id="phone" name="phone" value="{{ $user->phone }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Address Information -->
                                        <div class="form-section mb-4">
                                            <h5 class="section-title">Address Information</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-grp">
                                                        <label for="address_line_1">Address Line 1</label>
                                                        <input type="text" id="address_line_1" name="address_line_1" value="{{ $user->address_line_1 }}" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="form-grp">
                                                        <label for="address_line_2">Address Line 2</label>
                                                        <input type="text" id="address_line_2" name="address_line_2" value="{{ $user->address_line_2 }}">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-grp">
                                                        <label for="city">City</label>
                                                        <input type="text" id="city" name="city" value="{{ $user->city }}" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-grp">
                                                        <label for="state">State</label>
                                                        <input type="text" id="state" name="state" value="{{ $user->state }}">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-grp">
                                                        <label for="country">Country</label>
                                                        <select name="country" id="country" class="form-control select2" required>
                                                            <option value="">Select Country</option>
                                                            @foreach (config('countries') as $code => $name)
                                                                <option value="{{ $code }}" {{ $user->country == $code ? 'selected' : '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-grp">
                                                        <label for="postal_code">Postal Code</label>
                                                        <input type="text" id="postal_code" name="postal_code" value="{{ $user->postal_code }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- LEI History Tab -->
                        <div class="tab-pane fade" id="lei-history">
                            <div class="card">
                                <div class="card-header">
                                    <h4>LEI Registration History</h4>
                                </div>
                                <div class="card-body">
                                    @if($leiRegistrations->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>LEI Code</th>
                                                        <th>Company Name</th>
                                                        <th>Plan</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($leiRegistrations as $lei)
                                                        <tr>
                                                            <td>{{ $lei->registration_id ?: 'Pending' }}</td>
                                                            <td>{{ $lei->legal_entity_name }}</td>
                                                            <td>{{ ucfirst(str_replace('-', ' ', $lei->selected_plan)) }}</td>
                                                            <td>
                                                                @if($lei->payment_status == 'paid')
                                                                    <span class="badge bg-success">Active</span>
                                                                @else
                                                                    <span class="badge bg-warning">{{ ucfirst($lei->payment_status) }}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $lei->created_at->format('d M Y') }}</td>
                                                            <td>
                                                                @if($lei->payment_status == 'paid' && $lei->registration_id)
                                                                    <div class="btn-group">
                                                                        <a href="{{ route('user.lei.renew', $lei->id) }}" 
                                                                           class="btn-sm">
                                                                            <i class="fas fa-sync"></i> Renew
                                                                        </a>
                                                                        <a href="{{ route('user.lei.transfer', $lei->id) }}" 
                                                                           class="btn-sm">
                                                                            <i class="fas fa-exchange-alt"></i> Transfer
                                                                        </a>
                                                                    </div>
                                                                @elseif($lei->payment_status == 'pending')
                                                                    <a href="{{ route('payment.show', $lei->id) }}" 
                                                                       class="btn-warning">
                                                                        Complete Payment
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-folder-open" style="font-size: 60px; color: #ccc;"></i>
                                            <p class="mt-3">No LEI registrations found</p>
                                            <a href="{{ route('registration-lei') }}" class="btn btn-primary mt-2">
                                                Register Your First LEI
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="change-password">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Change Password</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.password.update') }}" method="POST">
                                        @csrf
                                        
                                        <div class="form-grp">
                                            <label for="current_password">Current Password</label>
                                            <input type="password" id="current_password" name="current_password" required>
                                        </div>
                                        
                                        <div class="form-grp">
                                            <label for="new_password">New Password</label>
                                            <input type="password" id="new_password" name="new_password" required>
                                            <small class="form-text text-muted">Must be at least 8 characters long</small>
                                        </div>
                                        
                                        <div class="form-grp">
                                            <label for="new_password_confirmation">Confirm New Password</label>
                                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- profile-area-end -->
</main>

@include('partials.footer')

<style>
.profile-sidebar {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
}

.profile-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.profile-menu li {
    margin-bottom: 10px;
}

.profile-menu li a,
.profile-menu li button {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
}

.profile-menu li.active a,
.profile-menu li a:hover,
.profile-menu li button:hover {
    background: #007bff;
    color: #fff;
}

.profile-menu li i {
    margin-right: 10px;
    width: 20px;
}

.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 20px;
}

.card-header h4 {
    margin: 0;
}

.form-section {
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

.section-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
}

.form-grp {
    margin-bottom: 20px;
}

.form-grp label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

.form-grp input,
.form-grp select {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.btn-link {
    color: #333;
    text-decoration: none;
    cursor: pointer;
}
.fade:not(.show) {
    opacity: 1;
}
</style>

<script>
// Disable Bootstrap tab auto-initialization
document.addEventListener('DOMContentLoaded', function() {
    // Prevent Bootstrap from auto-initializing tabs
    const style = document.createElement('style');
    style.textContent = `
        [data-bs-toggle="tab"] { pointer-events: none; }
        .tab-pane { display: none !important; }
        .tab-pane.active { display: block !important; }
    `;
    document.head.appendChild(style);
    
    // Your custom tab logic
    document.querySelectorAll('.profile-menu a[href^="#"]').forEach(function(link) {
        link.style.pointerEvents = 'auto'; // Re-enable clicks
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = this.getAttribute('href').substring(1);
            
            // Update menu
            document.querySelectorAll('.profile-menu li').forEach(li => li.classList.remove('active'));
            this.closest('li').classList.add('active');
            
            // Switch content
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            document.getElementById(targetId).classList.add('active');
        });
    });
    
    // Show first tab
    document.querySelector('.tab-pane').classList.add('active');
    
    // Check if we should show a specific tab
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab') || sessionStorage.getItem('profileTab');
    
    if (tab) {
        const tabElement = document.getElementById(tab);
        if (tabElement) {
            // Remove active from all tabs
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            document.querySelectorAll('.profile-menu li').forEach(li => li.classList.remove('active'));
            
            // Activate the specific tab
            tabElement.classList.add('active');
            const menuLink = document.querySelector(`.profile-menu a[href="#${tab}"]`);
            if (menuLink) {
                menuLink.closest('li').classList.add('active');
            }
        }
        
        // Clear the session storage
        sessionStorage.removeItem('profileTab');
    }
});
</script>

@endsection