@extends('layouts.admin')
@section('page_title', 'Subscriptions')

@section('content')
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-secondary fw-semibold">
            <i class="bi bi-credit-card text-primary me-2"></i>Subscriptions
        </h5>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-circle me-1"></i> Add New Subscription
        </a>
    </div>

    <div class="card-body">
        {{-- ✅ Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ❌ Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle table-striped table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Started At</th>
                        <th>Expires At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $subscription)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subscription->siteUser->username ?? 'N/A' }}</td>
                            <td>{{ $subscription->plan->title ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $subscription->status === 'active' ? 'success' : 
                                    ($subscription->status === 'expired' ? 'secondary' : 
                                    ($subscription->status === 'cancelled' ? 'danger' : 'warning'))
                                }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </td>
                            <td>{{ $subscription->currency }} {{ $subscription->amount }}</td>
                            <td>{{ $subscription->started_at?->format('Y-m-d') ?? '-' }}</td>
                            <td>{{ $subscription->expires_at?->format('Y-m-d') ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}"
                                   class="btn btn-sm btn-outline-warning rounded-3 me-1">
                                   <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger rounded-3"
                                            onclick="return confirm('Delete this subscription?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-1"></i>No subscriptions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
