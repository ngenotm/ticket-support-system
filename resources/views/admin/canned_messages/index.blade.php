@extends('layouts.admin')
@section('page_title', 'Canned Messages')

@section('content')
<div class="container mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0">💬 Canned Messages</h4>
        <a href="{{ route('admin.canned_messages.create') }}" class="btn btn-success shadow-sm rounded-3">
            ➕ Add New
        </a>
    </div>

    <!-- Flash message -->
    @if(session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
    @endif

    <!-- Table Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Service</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Global</th>
                        <th>Created At</th>
                        <th class="text-center" width="130">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cannedMessages as $msg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-medium">{{ $msg->title }}</td>
                            <td>{{ $msg->subject ?? '-' }}</td>
                            <td>{{ $msg->category->name ?? '-' }}</td>
                            <td>{{ $msg->subcategory->name ?? '-' }}</td>
                            <td>{{ $msg->service->name ?? '-' }}</td>
                            <td><span class="badge bg-info-subtle text-info">{{ ucfirst($msg->type) }}</span></td>
                            <td>
                                <span class="badge {{ $msg->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-muted' }}">
                                    {{ ucfirst($msg->status) }}
                                </span>
                            </td>
                            <td>{{ $msg->createdBy->user ?? 'N/A' }}</td>
                            <td>{!! $msg->is_global ? '<span class="badge bg-primary-subtle text-primary">Yes</span>' : '<span class="text-muted">No</span>' !!}</td>
                            <td>{{ $msg->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.canned_messages.edit', $msg->id) }}"
                                   class="btn btn-sm btn-outline-warning border-0 shadow-sm px-2 py-1">✏️</a>
                                <form action="{{ route('admin.canned_messages.delete', $msg->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-outline-danger border-0 shadow-sm px-2 py-1"
                                        onclick="return confirm('Delete this message?')">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-4">
                                No canned messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $cannedMessages->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
