@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit User</h1>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

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
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit User Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-muted mb-3">Personal Information</h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" 
                                           value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" 
                                           value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Company Information Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-muted mb-3">Company Information</h6>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                           id="company_name" name="company_name" 
                                           value="{{ old('company_name', $user->company_name) }}" required>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" 
                                           value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Password Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-muted mb-3">Change Password</h6>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="change_password" name="change_password" value="1">
                                        <label class="form-check-label" for="change_password">
                                            Change user's password
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="password-fields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" minlength="8">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Minimum 8 characters</small>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <button type="button" class="btn btn-sm btn-secondary" id="generatePassword">
                                            <i class="fas fa-key"></i> Generate Random Password
                                        </button>
                                        <span id="generatedPasswordDisplay" class="ms-2" style="display: none;">
                                            <code id="generatedPasswordText"></code>
                                            <button type="button" class="btn btn-sm btn-link" id="copyPassword">
                                                <i class="fas fa-copy"></i> Copy
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> The user will need to use this new password on their next login.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Account Status Section -->
                        <div class="form-section mb-4">
                            <h6 class="text-muted mb-3">Account Status</h6>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Account Active
                                        </label>
                                    </div>
                                    <small class="text-muted">Inactive accounts cannot log in to the system.</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- User Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> User Summary</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">User ID:</dt>
                        <dd class="col-sm-7">#{{ $user->id }}</dd>
                        
                        <dt class="col-sm-5">Username:</dt>
                        <dd class="col-sm-7">{{ $user->username ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-5">Registered:</dt>
                        <dd class="col-sm-7">{{ $user->created_at->format('d M Y') }}</dd>
                        
                        <dt class="col-sm-5">Last Updated:</dt>
                        <dd class="col-sm-7">{{ $user->updated_at->format('d M Y H:i') }}</dd>
                        
                        <dt class="col-sm-5">Email Verified:</dt>
                        <dd class="col-sm-7">
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-warning">No</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-5">Role:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-primary">{{ ucfirst($user->role ?? 'user') }}</span>
                        </dd>
                    </dl>
                </div>
            </div>
            
            <!-- LEI Statistics Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> LEI Statistics</h5>
                </div>
                <div class="card-body">
                    @php
                        $leiCount = $user->leiRegistrations()->count();
                        $activeLei = $user->leiRegistrations()->where('payment_status', 'paid')->count();
                        $pendingLei = $user->leiRegistrations()->where('payment_status', 'pending')->count();
                    @endphp
                    
                    <dl class="row mb-0">
                        <dt class="col-sm-7">Total LEIs:</dt>
                        <dd class="col-sm-5 text-end">{{ $leiCount }}</dd>
                        
                        <dt class="col-sm-7">Active LEIs:</dt>
                        <dd class="col-sm-5 text-end"><span class="text-success">{{ $activeLei }}</span></dd>
                        
                        <dt class="col-sm-7">Pending LEIs:</dt>
                        <dd class="col-sm-5 text-end"><span class="text-warning">{{ $pendingLei }}</span></dd>
                    </dl>
                    
                    <hr>
                    
                    <div class="d-grid">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i> View Full Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-section {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.form-section:last-of-type {
    border-bottom: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password fields visibility
    const changePasswordCheckbox = document.getElementById('change_password');
    const passwordFields = document.getElementById('password-fields');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    
    if (changePasswordCheckbox) {
        changePasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.style.display = 'block';
                passwordInput.setAttribute('required', 'required');
                passwordConfirmInput.setAttribute('required', 'required');
            } else {
                passwordFields.style.display = 'none';
                passwordInput.removeAttribute('required');
                passwordConfirmInput.removeAttribute('required');
                // Clear password fields when hiding
                passwordInput.value = '';
                passwordConfirmInput.value = '';
            }
        });
    }
    
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    // Generate random password
    document.getElementById('generatePassword').addEventListener('click', function() {
        const length = 12;
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        let password = "";
        
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        
        // Set the generated password
        document.getElementById('password').value = password;
        document.getElementById('password_confirmation').value = password;
        
        // Display the generated password
        document.getElementById('generatedPasswordText').textContent = password;
        document.getElementById('generatedPasswordDisplay').style.display = 'inline';
    });
    
    // Copy password to clipboard
    document.getElementById('copyPassword').addEventListener('click', function() {
        const passwordText = document.getElementById('generatedPasswordText').textContent;
        navigator.clipboard.writeText(passwordText).then(function() {
            // Change button text temporarily
            const btn = document.getElementById('copyPassword');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
            btn.classList.add('text-success');
            
            setTimeout(function() {
                btn.innerHTML = originalHTML;
                btn.classList.remove('text-success');
            }, 2000);
        });
    });
    
    // Show password fields if there are validation errors
    @if($errors->has('password'))
        changePasswordCheckbox.checked = true;
        passwordFields.style.display = 'block';
        passwordInput.setAttribute('required', 'required');
        passwordConfirmInput.setAttribute('required', 'required');
    @endif
});
</script>
@endsection