@extends('layouts.admin')
@section('page_title', 'All Plans')

@section('content')
<div class="card shadow-sm rounded-4 border-0">
    <div class="card-header bg-primary bg-opacity-75 text-white d-flex align-items-center justify-content-between rounded-top-4">
        <div>
            <i class="bi bi-card-list me-2"></i> <strong>All Plans</strong>
        </div>
        <a href="{{ route('admin.plans.create') }}" class="btn btn-light btn-sm text-primary fw-semibold border">
            <i class="bi bi-plus-circle me-1"></i> Add New Plan
        </a>
    </div>

    <div class="card-body bg-light rounded-bottom-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Cycle</th>
                        <th>Trial</th>
                        <th>Users</th>
                        <th>Storage</th>
                        <th>Projects</th>
                        <th>Renewal</th>
                        <th>Featured</th>
                        <th>Badge</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($plans as $plan)
                        <tr>
                            <td class="fw-semibold">{{ $loop->iteration }}</td>
                            <td>
                                <span style="color: {{ $plan->title_color }}">{{ $plan->title }}</span>
                            </td>
                            <td class="text-muted">{{ $plan->slug }}</td>
                            <td>
                                <span class="fw-semibold text-success">{{ $plan->formatted_price }}</span>
                            </td>
                            <td>{{ $plan->duration_days }} days</td>
                            <td>{{ ucfirst($plan->billing_cycle) }}</td>
                            <td>{{ $plan->trial_days }}</td>
                            <td>{{ $plan->max_users ?? '-' }}</td>
                            <td>{{ $plan->max_storage_gb ?? '-' }}</td>
                            <td>{{ $plan->max_projects ?? '-' }}</td>
                            <td>{{ ucfirst($plan->renewal_type) }}</td>

                            <td>
                                @if($plan->is_featured)
                                    <span class="badge bg-info bg-opacity-75">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>

                            <td>
                                @if($plan->badge_label)
                                    <span class="badge" style="background-color: {{ $plan->border_color }}; color: #fff;">
                                        {{ $plan->badge_label }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                @if($plan->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-sm btn-warning rounded-3 shadow-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger rounded-3 shadow-sm"
                                            onclick="return confirm('Are you sure you want to delete this plan?')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-muted py-4">
                                <i class="bi bi-emoji-frown"></i> No plans found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
