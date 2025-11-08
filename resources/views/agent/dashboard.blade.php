@extends('layouts.staff')

@section('staff')
<!-- Dashboard Cards -->
<div class="row mb-4 g-3">
    <div class="col-md-3">
        <div class="dashboard-card bg-primary text-white rounded-2 shadow-sm p-3 text-center">
            <h6 class="fw-semibold">Assigned Tickets</h6>
            <p class="fs-4 mb-0">{{ $assingnedTickets }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card bg-success text-white rounded-2 shadow-sm p-3 text-center">
            <h6 class="fw-semibold">Open Tickets</h6>
            <p class="fs-4 mb-0">{{ $activeTickets }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card bg-danger text-white rounded-2 shadow-sm p-3 text-center">
            <h6 class="fw-semibold">Closed Tickets</h6>
            <p class="fs-4 mb-0">{{ $closedTickets }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card bg-warning text-dark rounded-2 shadow-sm p-3 text-center">
            <h6 class="fw-semibold">Total Users</h6>
            <p class="fs-4 mb-0">{{ $totalUsers }}</p>
        </div>
    </div>
</div>

<!-- Assigned Tickets Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm rounded-2 border-0">
            <div class="card-header bg-light fw-semibold">Assigned Tickets</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Ticket</th>
                                <th>Priority</th>
                                <th>Plan</th>
                                <th>Last Reply</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignedSiteUsers as $user)
                                @foreach($user->tickets as $ticket)
                                    @php
                                        $borderColor = $user->activeSubscription?->currentPlan?->border_color
                                                      ?? $user->currentPlan?->border_color ?? '#ddd';
                                        $planTitle = $user->activeSubscription?->currentPlan?->title
                                                   ?? $user->currentPlan?->title ?? 'No active plan';
                                        $statusClass = $ticket->status === 'closed' ? 'bg-secondary' : ($ticket->status === 'pending' ? 'bg-warning text-dark' : 'bg-info');
                                        $priorityClass = $ticket->priority === 'high' ? 'bg-danger' : ($ticket->priority === 'medium' ? 'bg-warning text-dark' : 'bg-success');
                                        $lastReply = $ticket->replies->max('created_at');
                                    @endphp
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td class="d-flex align-items-center">
                                            @if($user->photo_url)
                                                <img src="{{ asset($user->photo_url) }}" width="40" height="40" class="rounded-circle me-2" style="border:3px solid {{ $borderColor }}; padding:2px;" title="{{ $planTitle }}">
                                            @else
                                                <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:40px;height:40px;border:3px solid {{ $borderColor }};background:#f8f9fa;">
                                                    <i class="fa fa-user text-muted"></i>
                                                </div>
                                            @endif
                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-2 viewUserBtn" style="border-color: {{ $borderColor }};" data-id="{{ $user->id }}">
                                                <i class="fa fa-eye"></i> {{ $user->username }}
                                            </a>
                                        </td>
                                        <td class="text-secondary">{{ $user->email }}</td>
                                        <td>
                                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>#{{ $ticket->ticket_track_id }}</strong><br>
                                            <small>{{ $ticket->title }}</small><br>
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($ticket->status) }}</span>
                                        </td>
                                        <td><span class="badge {{ $priorityClass }}">{{ ucfirst($ticket->priority ?? 'Normal') }}</span></td>
                                        <td><span class="badge" style="background-color: {{ $borderColor }}; color:#fff;">{{ $planTitle }}</span></td>
                                        <td class="text-secondary">{{ $lastReply ? \Carbon\Carbon::parse($lastReply)->format('d M Y, h:i A') : '—' }}</td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No tickets assigned to you.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ticket Details Modal -->
<div class="modal fade" id="ticketViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content shadow-sm rounded-2 border-0">
            <div class="modal-header bg-light border-bottom-0 fw-semibold">
                <h5 class="modal-title">🎫 Ticket Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="ticket-info-section" class="py-2"></div>
                <hr>
                <div id="ticket-replies-section" class="py-2"></div>
            </div>
        </div>
    </div>
</div>

<!-- Ticket Replies & Chat -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm rounded-2 border-0">
            <div class="card-header d-flex justify-content-between align-items-center fw-semibold">
                Ticket Replies
                <button id="refreshReplies" class="btn btn-sm btn-outline-primary">🔄 Refresh</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>User</th>
                            <th>Last Reply</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ticketReplies as $reply)
                        <tr>
                            <td>{{ $reply->ticket->ticket_track_id ?? 'N/A' }}</td>
                            <td>{{ $reply->user->username ?? 'Anonymous' }}</td>
                            <td>{{ Str::limit($reply->reply_body, 40) }}</td>
                            <td>
                                <a href="{{ route('agent.tickets.show', $reply->ticket->id) }}" class="btn btn-sm btn-info py-0 px-2 rounded-2">
                                    <i class="fa fa-eye"></i> Reply
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No replies yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm rounded-2 border-0">
            <div class="card-header fw-semibold">Live Chat</div>
            <div class="card-body" id="chatBody" style="height: 300px; overflow-y:auto;">
                <div class="chat-message"><strong>User:</strong> Hello, any update?</div>
                <div class="chat-message text-end text-success"><strong>Agent:</strong> We're checking your issue.</div>
            </div>
            <div class="card-footer d-flex gap-2">
                <input type="text" id="chatInput" class="form-control form-control-sm rounded-2" placeholder="Type a message...">
                <button class="btn btn-primary btn-sm" id="sendMessageBtn">Send</button>
            </div>
        </div>
    </div>
</div>
@endsection



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userInfoModal = document.getElementById('userInfoModal');
            userInfoModal.addEventListener('show.bs.modal', function (event) {
                const link = event.relatedTarget;
                document.getElementById('modalUsername').textContent = link.getAttribute('data-username');
                document.getElementById('modalEmail').textContent = link.getAttribute('data-email');
                document.getElementById('modalPhone').textContent = link.getAttribute('data-phone');
                document.getElementById('modalJoined').textContent = link.getAttribute('data-joined');
            });
        });
    </script>

    <script>setInterval(() => {
            fetch('/agent/replies/refresh')
                .then(res => res.text())
                .then(html => document.getElementById('ticketReplies').innerHTML = html);
        }, 10000);
    </script>
        <script>
                function openChat(ticketId) {
                    const modal = new bootstrap.Modal(document.getElementById('chatModal'));
                    document.getElementById('chatModalLabel').textContent = "Ticket Chat #" + ticketId;
                    modal.show();
                }

                // Dummy send message
                document.getElementById('sendMessageBtn').addEventListener('click', function () {
                    let input = document.getElementById('chatInput');
                    if (input.value.trim() !== '') {
                        let msg = `<div class="chat-message text-end text-primary"><strong>You:</strong> ${input.value}</div>`;
                        document.getElementById('chatBody').insertAdjacentHTML('beforeend', msg);
                        input.value = '';
                    }
                });
            </script>
@endpush


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).on('click', '.viewUserBtn', function () {
            const userId = $(this).data('id');
            $('#ticketViewModal').modal('show');

            $('#ticket-info-section').html('<p>Loading user details...</p>');
            $('#ticket-replies-section').empty();

            $.ajax({
                url: "{{ route('agent.user.details') }}",
                type: 'GET',
                data: { id: userId },
                success: function (response) {

                    $('#ticket-info-section').html(response.user_html);
                    $('#ticket-replies-section').html(response.tickets_html);
                },
                error: function () {
                    $('#ticket-info-section').html('<div class="text-danger">Error loading user details.</div>');
                }
            });
        });
    </script>

@endpush