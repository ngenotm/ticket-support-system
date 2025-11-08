@extends('layouts.admin')

@section('page_title', 'Edit Service–User Link')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h4 class="fw-semibold text-dark mb-0">🔧 Edit Service–User Link</h4>
        <a href="{{ route('admin.ticket_service_user.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>

    <!-- Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.ticket_service_user.update', $link->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <!-- Service -->
                <div class="mb-4">
                    <label for="service_id" class="form-label fw-semibold text-secondary">Select Service</label>
                    <select name="service_id" id="service_id" class="form-select" required>
                        <option value="">-- Select Service --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $link->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- User -->
                <div class="mb-4">
                    <label for="user_id" class="form-label fw-semibold text-secondary">Select User</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Select User --</option>
                        @foreach($siteUsers as $user)
                            <option value="{{ $user->id }}" {{ $link->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->username }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Update Link</button>
                    <a href="{{ route('admin.ticket_service_user.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Inline Styles (Professional Zoho Look) -->
<style>
    .card {
        border-radius: 6px;
        background-color: #fff;
    }

    .form-label {
        font-size: 0.9rem;
    }

    .form-select, .form-control {
        border-radius: 4px;
        border: 1px solid #ced4da;
        font-size: 0.95rem;
        padding: 0.55rem 0.75rem;
        box-shadow: none !important;
        background-color: #fff;
    }

    .form-select:focus, .form-control:focus {
        border-color: #0066cc;
        outline: 0;
        box-shadow: 0 0 0 2px rgba(0, 102, 204, 0.15);
    }

    .btn {
        border-radius: 4px !important;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .btn-primary {
        background-color: #0066cc;
        border-color: #0066cc;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    .border-bottom {
        border-color: #e0e0e0 !important;
    }
</style>
@endsection
