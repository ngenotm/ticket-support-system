@extends('layouts.admin')

@section('page_title', 'Expired Subscriptions')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold text-secondary mb-0">
            <i class="bi bi-clock-history text-primary me-2"></i> Expired Subscriptions
        </h2>
        <a href="{{ route('admin.expired_subscriptions.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Expired Subscription
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Card Wrapper -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-muted small text-uppercase">
                        <th>ID</th>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Expires At</th>
                        <th>Expired At</th>
                        <th>Reason</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expiredSubscriptions as $item)
                        @php
                            $statusColors = [
                                'expired' => 'danger',
                                'cancelled' => 'secondary',
                                'grace_period' => 'warning',
                                'renewal_failed' => 'info',
                                'archived' => 'dark',
                            ];
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $item->id }}</td>
                            <td>{{ optional($item->user)->username ?? optional($item->user)->email ?? 'N/A' }}</td>
                            <td>{{ $item->plan_title ?? optional($item->plan)->title ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $statusColors[$item->status] ?? 'secondary' }}">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                            <td>{{ $item->amount }} {{ $item->currency }}</td>
                            <td>{{ $item->expires_at ? $item->expires_at->format('Y-m-d') : '—' }}</td>
                            <td>{{ $item->expired_at ? $item->expired_at->format('Y-m-d') : '—' }}</td>
                            <td title="{{ $item->expiry_reason }}">
                                {{ Str::limit($item->expiry_reason, 25, '...') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.expired_subscriptions.edit', $item->id) }}" 
                                   class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1 shadow-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.expired_subscriptions.destroy', $item->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm"
                                            onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-inbox text-secondary fs-4 d-block mb-2"></i>
                                No expired subscriptions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        {{ $expiredSubscriptions->links() }}
    </div>
</div>
@endsection
