@extends('layouts.admin')

@section('page_title', 'Edit Expired Subscription')

@section('content')
<div class="container mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0">📝 Edit Expired Subscription #{{ $expiredSubscription->id }}</h4>
        <a href="{{ route('admin.expired_subscriptions.index') }}" 
           class="btn btn-outline-secondary rounded-3 shadow-sm">
           ← Back
        </a>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.expired_subscriptions.update', $expiredSubscription->id) }}" method="POST" 
          class="card border-0 shadow-sm rounded-3 p-4 bg-white">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- User -->
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">User</label>
                <select name="user_id" class="form-select" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" 
                            {{ $expiredSubscription->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->username ?? $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Plan -->
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Plan</label>
                <select name="plan_id" class="form-select">
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" 
                            {{ $expiredSubscription->plan_id == $plan->id ? 'selected' : '' }}>
                            {{ $plan->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Amount -->
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Amount</label>
                <input type="number" step="0.01" name="amount" 
                       class="form-control" value="{{ $expiredSubscription->amount }}">
            </div>

            <!-- Currency -->
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Currency</label>
                <input type="text" name="currency" class="form-control" 
                       value="{{ $expiredSubscription->currency }}">
            </div>

            <!-- Status -->
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Status</label>
                <select name="status" class="form-select">
                    @foreach(['expired','cancelled','grace_period','renewal_failed','archived'] as $status)
                        <option value="{{ $status }}" 
                            {{ $expiredSubscription->status == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_',' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Renewal Type -->
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Renewal Type</label>
                <select name="renewal_type" class="form-select">
                    <option value="auto" {{ $expiredSubscription->renewal_type == 'auto' ? 'selected' : '' }}>Auto</option>
                    <option value="manual" {{ $expiredSubscription->renewal_type == 'manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>

            <!-- Expiry Reason -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-secondary">Expiry Reason</label>
                <textarea name="expiry_reason" class="form-control" rows="2">{{ $expiredSubscription->expiry_reason }}</textarea>
            </div>

            <!-- Admin Notes -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-secondary">Admin Notes</label>
                <textarea name="admin_notes" class="form-control" rows="2">{{ $expiredSubscription->admin_notes }}</textarea>
            </div>

            <!-- Expired At -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-secondary">Expired At</label>
                <input type="datetime-local" name="expired_at" class="form-control"
                       value="{{ $expiredSubscription->expired_at ? $expiredSubscription->expired_at->format('Y-m-d\TH:i') : '' }}">
            </div>

            <!-- Expires At -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-secondary">Expires At</label>
                <input type="datetime-local" name="expires_at" class="form-control"
                       value="{{ $expiredSubscription->expires_at ? $expiredSubscription->expires_at->format('Y-m-d\TH:i') : '' }}">
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.expired_subscriptions.index') }}" 
               class="btn btn-outline-secondary shadow-sm rounded-3">Cancel</a>
            <button type="submit" class="btn btn-success shadow-sm rounded-3 px-4">💾 Update Record</button>
        </div>
    </form>
</div>
@endsection
