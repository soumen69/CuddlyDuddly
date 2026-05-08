<header>
    <button class="btn btn-outline-dark d-md-none" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <h5 class="m-0">CuddlyDuddly Admin</h5>

    <div>
        @php
            $admin = Auth::guard('admin')->user();
            $seller = Auth::guard('seller')->user();
            $user = $admin ?? $seller;
        @endphp

        @if ($user)
            <span class="me-3">Hello👋, {{ $user->name }}</span>
        @endif
        <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</header>
