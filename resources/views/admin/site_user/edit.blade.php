@extends('layouts.admin')

@section('page_title', 'Edit Site User')

@section('content')
<div class="card shadow-sm rounded-3 border-0">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
        <h5 class="mb-0 text-secondary">
            <i class="bi bi-person-lines-fill me-2 text-warning"></i>
            Edit Site User — <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
        </h5>
        <a href="{{ url('admin/site_user') }}" class="btn btn-outline-secondary btn-sm rounded-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger rounded-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Fix the errors below</strong>
                <ul class="mt-2 mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('admin/site_user/update/' . $user->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Basic Info -->
                <div class="col-md-6">
                    <label class="form-label text-secondary required">First Name</label>
                    <input type="text" name="first_name" class="form-control rounded-3"
                           value="{{ old('first_name', $user->first_name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Last Name</label>
                    <input type="text" name="last_name" class="form-control rounded-3"
                           value="{{ old('last_name', $user->last_name) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary required">Username</label>
                    <input type="text" name="username" class="form-control rounded-3"
                           value="{{ old('username', $user->username) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary required">Email</label>
                    <input type="email" name="email" class="form-control rounded-3"
                           value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">New Password</label>
                    <input type="password" name="password" class="form-control rounded-3">
                    <small class="text-muted">Leave blank to keep current password.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Date of Birth</label>
                    <input type="date" name="dob"
                           value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}"
                           class="form-control rounded-3">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Gender</label>
                    <select name="gender" class="form-select rounded-3">
                        <option value="">Select</option>
                        @foreach(['Male', 'Female', 'Other'] as $g)
                            <option value="{{ $g }}" {{ old('gender', $user->gender) == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Phone</label>
                    <input type="text" name="phone" class="form-control rounded-3"
                           value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Country</label>
                    <input type="text" name="country" class="form-control rounded-3"
                           value="{{ old('country', $user->country) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Region</label>
                    <input type="text" name="region" class="form-control rounded-3"
                           value="{{ old('region', $user->region) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">City</label>
                    <input type="text" name="city" class="form-control rounded-3"
                           value="{{ old('city', $user->city) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">ZIP</label>
                    <input type="text" name="zip" class="form-control rounded-3"
                           value="{{ old('zip', $user->zip) }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label text-secondary">Address</label>
                    <textarea name="address" class="form-control rounded-3" rows="2">{{ old('address', $user->address) }}</textarea>
                </div>

                <!-- Account Info -->
                <div class="col-md-6">
                    <label class="form-label text-secondary required">Status</label>
                    <select name="status" class="form-select rounded-3" required>
                        @foreach(['Active', 'Inactive', 'Locked', 'Suspended'] as $s)
                            <option value="{{ $s }}" {{ old('status', $user->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary required">User Type</label>
                    <select name="user_type" class="form-select rounded-3" required>
                        @foreach(['User', 'Admin', 'Guest'] as $t)
                            <option value="{{ $t }}" {{ old('user_type', $user->user_type) == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Photo -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Photo</label>
                    <input type="file" name="photo_url" class="form-control rounded-3" accept=".jpg,.jpeg,.png,.webp,.gif">
                    @if($user->photo_url)
                        <img src="{{ asset($user->photo_url) }}" width="60" class="mt-2 rounded border">
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ url('admin/site_user') }}" class="btn btn-outline-secondary rounded-3">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn btn-warning text-white rounded-3 px-4">
                    <i class="bi bi-check-circle"></i> Update User
                </button>
            </div>
        </form>
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
    label.form-label {
        font-weight: 500;
        font-size: 0.9rem;
    }
    .form-control, .form-select {
        border-radius: 10px !important;
        border-color: #e3e6ea;
    }
    .card {
        background-color: #fff;
    }
</style>
@endpush
