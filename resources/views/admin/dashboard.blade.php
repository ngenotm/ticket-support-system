@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="row mb-4">
        <!-- Tickets Card -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm rounded-2 border-0">
                <div class="card-body">
                    <h6 class="text-secondary fw-semibold mb-2">Tickets</h6>
                    <p class="h5 mb-0">{{ $ticketCount }} Total</p>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm rounded-2 border-0">
                <div class="card-body">
                    <h6 class="text-secondary fw-semibold mb-2">Users</h6>
                    <p class="h5 mb-0">{{ $siteUUserCount }} Total</p>
                </div>
            </div>
        </div>

        <!-- Open Tickets Card -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm rounded-2 border-0">
                <div class="card-body">
                    <h6 class="text-secondary fw-semibold mb-2">Open Tickets</h6>
                    <p class="h5 mb-0">{{ $ticketCount - $closedTickets }}</p>
                </div>
            </div>
        </div>

        <!-- Closed Tickets Card -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm rounded-2 border-0">
                <div class="card-body">
                    <h6 class="text-secondary fw-semibold mb-2">Closed Tickets</h6>
                    <p class="h5 mb-0">{{ $closedTickets }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm rounded-2 border-0">
                <div class="card-header bg-white border-bottom fw-semibold text-secondary">
                    Recent Users
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold text-secondary">ID</th>
                                <th class="fw-semibold text-secondary">Username</th>
                                <th class="fw-semibold text-secondary">Status</th>
                                <th class="fw-semibold text-secondary">Tickets</th>
                                <th class="fw-semibold text-secondary">Replies</th>
                                <th class="fw-semibold text-secondary">Last Login</th>
                                <th class="fw-semibold text-secondary">Last Reply</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siteUser as $users)
                                @php
                                    $borderColor = $users->activeSubscription?->currentPlan?->border_color
                                        ?? $users->currentPlan?->border_color
                                        ?? '#ddd';
                                    $planTitle = $users->activeSubscription?->currentPlan?->title
                                        ?? $users->currentPlan?->title
                                        ?? 'No active plan';
                                @endphp
                                <tr>
                                    <td>{{ $users->id }}</td>

                                    <td class="d-flex align-items-center gap-2">
                                        {{-- Profile Image with Plan Border --}}
                                        @if ($users->photo_url)
                                            <img src="{{ asset($users->photo_url) }}" title="{{ $planTitle }}" alt="User" width="40"
                                                height="40" class="rounded-circle"
                                                style="border: 2px solid {{ $borderColor }}; padding: 1px;">
                                        @else
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; border: 2px solid {{ $borderColor }}; background: #f8f9fa;">
                                                <i class="fa fa-user text-muted"></i>
                                            </div>
                                        @endif

                                        {{-- Username with Modal Trigger --}}
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary viewAdminUserBtn"
                                            data-id="{{ $users->id }}">
                                            <i class="fa fa-eye me-1"></i> {{ $users->username }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-success fw-semibold">{{ $users->status }}</span>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-info fw-semibold">{{ $users->tickets_count }}</span>
                                    </td>

                                    <td>
                                        <span
                                            class="badge bg-light text-warning fw-semibold">{{ $users->ticket_replies_count }}</span>
                                    </td>

                                    <td class="text-secondary">
                                        {{ $users->last_login_at ? $users->last_login_at->format('d M Y, h:i A') : '—' }}
                                    </td>

                                    <td class="text-secondary">
                                        {{ $users->ticket_replies_max_created_at ? \Carbon\Carbon::parse($users->ticket_replies_max_created_at)->format('d M Y, h:i A') : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="adminUserViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content shadow-sm rounded-2 border-0">
                <!-- Modal Header -->
                <div class="modal-header bg-white border-bottom">
                    <h5 class="modal-title text-secondary fw-semibold">👤 User & Ticket Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <!-- SECTION 1: User Info -->
                    <div id="admin-user-info-section" class="mb-4">
                        <!-- Dynamic user info content -->
                    </div>

                    <hr class="my-4">

                    <!-- SECTION 2: Tickets & Replies -->
                    <div id="admin-user-tickets-section">
                        <!-- Dynamic tickets & replies content -->
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <!-- Latest Ticket Replies -->
        <div class="col-md-6">
            <div class="card shadow-sm rounded-2 border-0">
                <div class="card-header bg-white fw-semibold text-secondary border-bottom">
                    💬 Latest Ticket Replies
                </div>
                <div class="card-body p-3" style="height: 600px; overflow-y: auto;" id="liveChatBox">
                    @forelse ($ticketReplies as $reply)
                        <div class="mb-3 p-3 border rounded-2 shadow-sm bg-white">
                            <p class="mb-1"><strong>From:</strong>
                                @if($reply->isFromAdmin())
                                    {{ $reply->appUser?->name ?? 'Admin User' }}
                                @elseif($reply->isFromClient())
                                    {{ $reply->siteUser?->username ?? 'Client User' }}
                                @else
                                    Unknown
                                @endif
                            </p>
                            <p class="mb-1"><strong>To:</strong>
                                @if($reply->isFromAdmin())
                                    {{ $reply->siteUser?->username ?? 'Client' }}
                                @elseif($reply->isFromClient())
                                    {{ $reply->appUser?->name ?? 'Admin' }}
                                @else
                                    Unknown
                                @endif
                            </p>
                            <p class="mb-1"><strong>Message:</strong> {{ $reply->reply_body }}</p>
                            <p class="mb-1"><strong>Status:</strong> {{ $reply->ticket?->status ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Read:</strong>
                                @if($reply->is_read)
                                    ✅ Yes (at {{ optional($reply->read_at)->format('d M Y, h:i A') }})
                                @else
                                    ❌ No
                                @endif
                            </p>
                            <small class="text-muted">Sent: {{ $reply->created_at->format('d M Y, h:i A') }}</small>
                            <div class="mt-2 text-end">
                                <a href="{{ route('admin.tickets.show', $reply->ticket_id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye me-1"></i> View Conversation
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No recent chats found.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Live Chat Preview -->
        <div class="col-md-6">
            <div class="card shadow-sm rounded-2 border-0">
                <div class="card-header bg-white fw-semibold text-secondary border-bottom">
                    🟢 Live Chat (Demo)
                </div>
                <div class="card-body p-3" style="height: 600px; overflow-y: auto; background-color: #f9fafb;">
                    <div class="chat-message mb-3">
                        <div class="p-2 bg-light border rounded-2 w-75">
                            <strong>Client (Priyanka):</strong><br>
                            Hi, I’m facing an issue with my printer. It keeps showing “Paper Jam”.
                            <br>
                            <small class="text-muted">10:32 AM</small>
                        </div>
                    </div>

                    <div class="chat-message text-end mb-3">
                        <div class="p-2 bg-primary text-white rounded-2 w-75 d-inline-block">
                            <strong>Admin (TechSupport):</strong><br>
                            Hello Priyanka! Please check if there’s any paper stuck in the rear tray.
                            <br>
                            <small>10:33 AM</small>
                        </div>
                    </div>

                    <div class="chat-message mb-3">
                        <div class="p-2 bg-light border rounded-2 w-75">
                            <strong>Client (Priyanka):</strong><br>
                            I checked. There’s nothing stuck, but the error remains.
                            <br>
                            <small class="text-muted">10:34 AM</small>
                        </div>
                    </div>

                    <div class="chat-message text-end mb-3">
                        <div class="p-2 bg-primary text-white rounded-2 w-75 d-inline-block">
                            <strong>Admin (TechSupport):</strong><br>
                            Try turning the printer off for 30 seconds and power it back on.
                            <br>
                            <small>10:35 AM</small>
                        </div>
                    </div>

                    <div class="chat-message mb-3">
                        <div class="p-2 bg-light border rounded-2 w-75">
                            <strong>Client (Priyanka):</strong><br>
                            That worked! Thank you. 😊
                            <br>
                            <small class="text-muted">10:36 AM</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top-0 bg-white text-end">
                    <button class="btn btn-outline-primary" disabled>Send (Demo)</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const chatForm = document.getElementById('chatForm');
        const chatBox = document.getElementById('liveChatBox');

        if (chatForm) {
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const msg = document.getElementById('chatMessage').value;
                if (msg.trim() !== '') {
                    const div = document.createElement('div');
                    div.innerHTML = `<strong>Admin:</strong> ${msg}`;
                    chatBox.appendChild(div);
                    chatBox.scrollTop = chatBox.scrollHeight;
                    chatForm.reset();
                }
            });
        }
    </script>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).on('click', '.viewAdminUserBtn', function () {
            const userId = $(this).data('id');
            $('#adminUserViewModal').modal('show');

            $('#admin-user-info-section').html('<p>Loading user details...</p>');
            $('#admin-user-tickets-section').empty();

            $.ajax({
                url: "{{ route('admin.user.details') }}",
                type: 'GET',
                data: { id: userId },
                success: function (response) {
                    $('#admin-user-info-section').html(response.user_html);
                    $('#admin-user-tickets-section').html(response.tickets_html);
                },
                error: function () {
                    $('#admin-user-info-section').html('<div class="text-danger">Error loading user details.</div>');
                }
            });
        });
    </script>
@endpush