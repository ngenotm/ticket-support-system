@extends('layouts.admin')

@section('page_title', 'Add Site User')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-semibold text-secondary">
                <i class="bi bi-person-plus me-2 text-success"></i> Add New Site User
            </h5>
            <a href="{{ url('admin/site_user') }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger rounded-3 shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Please correct the following errors:</strong>
                    <ul class="mt-2 mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('admin/site_user/store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <!-- Personal Info -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold required">First Name</label>
                        <input type="text" name="first_name" class="form-control rounded-3" value="{{ old('first_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Last Name</label>
                        <input type="text" name="last_name" class="form-control rounded-3" value="{{ old('last_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold required">Username</label>
                        <input type="text" name="username" class="form-control rounded-3" value="{{ old('username') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold required">Email</label>
                        <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold required">Password</label>
                        <input type="password" name="password" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date of Birth</label>
                        <input type="date" name="dob" class="form-control rounded-3" value="{{ old('dob') }}">
                    </div>

                    <!-- Profile Info -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Gender</label>
                        <select name="gender" class="form-select rounded-3">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold required">Status</label>
                        <select name="status" class="form-select rounded-3" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Locked">Locked</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold required">User Type</label>
                        <select name="user_type" class="form-select rounded-3" required>
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                            <option value="Guest">Guest</option>
                        </select>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Country</label>
                        <input type="text" name="country" class="form-control rounded-3" value="{{ old('country') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Region</label>
                        <input type="text" name="region" class="form-control rounded-3" value="{{ old('region') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City</label>
                        <input type="text" name="city" class="form-control rounded-3" value="{{ old('city') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">ZIP</label>
                        <input type="text" name="zip" class="form-control rounded-3" value="{{ old('zip') }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control rounded-3" rows="2">{{ old('address') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Photo</label>
                        <input type="file" name="photo_url" class="form-control rounded-3" accept=".jpg,.jpeg,.png,.webp,.gif">
                        <small class="text-muted">Accepted formats: JPG, PNG, WEBP, GIF</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ url('admin/site_user') }}" class="btn btn-outline-secondary rounded-3">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success rounded-3">
                        <i class="bi bi-check-circle me-1"></i> Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: red;
        font-weight: bold;
    }
</style>
@endpush
