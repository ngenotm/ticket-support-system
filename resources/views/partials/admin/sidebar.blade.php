<div class="sidebar d-flex flex-column p-3 bg-white shadow-sm rounded-2" id="sidebar" style="width: 250px; height: 100vh;">
    <!-- Sidebar Header -->
    <h4 class="text-center py-3 fw-semibold text-secondary">Ticket Admin</h4>

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 p-2 mb-1 rounded-2 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-secondary' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    {{-- User Settings --}}
    @php
        $AppUserMenuOpen = request()->routeIs('admin.app_user.*') || request()->routeIs('admin.roles.*');
    @endphp
    <a class="d-flex align-items-center gap-2 p-2 mb-1 rounded-2 text-secondary" data-bs-toggle="collapse" href="#app_user_menu" role="button" aria-expanded="{{ $AppUserMenuOpen ? 'true' : 'false' }}">
        <i class="bi bi-person-gear"></i> User Settings
    </a>
    <div class="collapse submenu {{ $AppUserMenuOpen ? 'show' : '' }}" id="app_user_menu">
        <a href="{{ route('admin.roles.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.roles.*') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="fas fa-user-tag"></i> Role List
        </a>
        <a href="{{ route('admin.app_user.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.app_user.*') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="bi bi-person-workspace"></i> All User List
        </a>
    </div>

    {{-- Clients --}}
    @php
        $AppSiteMenuOpen = request()->routeIs('admin.site_user.*');
    @endphp
    <a class="d-flex align-items-center gap-2 p-2 mb-1 rounded-2 text-secondary" data-bs-toggle="collapse" href="#site_user_menu" role="button" aria-expanded="{{ $AppSiteMenuOpen ? 'true' : 'false' }}">
        <i class="bi bi-people"></i> Clients
    </a>
    <div class="collapse submenu {{ $AppSiteMenuOpen ? 'show' : '' }}" id="site_user_menu">
        <a href="{{ route('admin.site_user.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.site_user.*') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="bi bi-person-check"></i> Site User List
        </a>
    </div>

    {{-- Subscriptions --}}
    @php
        $subsMenuOpen = request()->routeIs('admin.plans.*') || request()->routeIs('admin.subscriptions.*') || request()->routeIs('admin.subscription_payments.*');
    @endphp
    <a class="d-flex align-items-center gap-2 p-2 mb-1 rounded-2 text-secondary" data-bs-toggle="collapse" href="#subscriptionsMenu" role="button" aria-expanded="{{ $subsMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-gift"></i> Subscriptions
    </a>
    <div class="collapse submenu {{ $subsMenuOpen ? 'show' : '' }}" id="subscriptionsMenu">
        <a href="{{ route('admin.plans.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.plans.*') ? 'bg-primary text-white' : 'text-secondary' }}">All Plans</a>
        <a href="{{ route('admin.subscriptions.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.subscriptions.*') ? 'bg-primary text-white' : 'text-secondary' }}">All Subscriptions</a>
        <a href="{{ route('admin.subscription_payments.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.subscription_payments.*') ? 'bg-primary text-white' : 'text-secondary' }}">Pending Payments</a>
        <a href="{{ route('admin.expired_subscriptions.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.expired_subscriptions.*') ? 'bg-primary text-white' : 'text-secondary' }}">Expired Subscriptions</a>
    </div>

    {{-- Tickets --}}
    @php
        $ticketMenuOpen = request()->is('admin/ticket*');
    @endphp
    <a class="d-flex align-items-center gap-2 p-2 mb-1 rounded-2 text-secondary" data-bs-toggle="collapse" href="#ticketsMenu" role="button" aria-expanded="{{ $ticketMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-ticket-alt"></i> Tickets
    </a>
    <div class="collapse submenu {{ $ticketMenuOpen ? 'show' : '' }}" id="ticketsMenu">
        <a href="{{ route('admin.ticket_main_categories.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.ticket_main_categories.*') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="bi bi-record-circle-fill"></i> Ticket Categories
        </a>
        <a href="{{ route('admin.ticket_subcategories.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.ticket_subcategories.*') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="bi bi-record-circle-fill"></i> Ticket Sub-Categories
        </a>
        <a href="{{ route('admin.ticket_services.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.ticket_services.*') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="bi bi-record-circle-fill"></i> Services
        </a>
        <a href="{{ route('admin.ticket_service_user.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.ticket_service_user.*') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="bi bi-record-circle-fill"></i> User Services
        </a>
        <a href="{{ route('admin.tickets.create') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->is('admin/tickets/create') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="bi bi-record-circle-fill"></i> Create Ticket
        </a>
        <a href="{{ route('admin.tickets.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-2 {{ request()->routeIs('admin.tickets.*') ? 'bg-primary text-white' : 'text-secondary' }}">
            <i class="bi bi-record-circle-fill"></i> All Tickets
        </a>
    </div>

    {{-- Payments --}}
    @php $paymentsMenuOpen = request()->is('admin/payments*'); @endphp
    <a class="d-flex align-items-center gap-2 p-2 mb-1 rounded-2 text-secondary" data-bs-toggle="collapse" href="#paymentsMenu" role="button" aria-expanded="{{ $paymentsMenuOpen ? 'true' : 'false' }}">
        <i class="fas fa-credit-card"></i> Payments
    </a>
    <div class="collapse submenu {{ $paymentsMenuOpen ? 'show' : '' }}" id="paymentsMenu">
        <a href="#" class="d-flex align-items-center gap-2 p-2 rounded-2 text-secondary">All Payments</a>
        <a href="#" class="d-flex align-items-center gap-2 p-2 rounded-2 text-secondary">Pending Payments</a>
        <a href="#" class="d-flex align-items-center gap-2 p-2 rounded-2 text-secondary">Revenue Reports</a>
    </div>

    {{-- Logout --}}
    <form action="{{ route('logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-2 mt-3">
            <i class="fa fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>
