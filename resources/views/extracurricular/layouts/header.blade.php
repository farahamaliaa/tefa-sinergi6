<header class="app-header bg-white">
    <nav class="navbar navbar-expand-lg navbar-light px-3 d-flex justify-content-between">

        <div class="d-flex align-items-center">
            <a class="nav-link p-0 me-2 sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2 fs-4 text-muted"></i>
            </a>
        </div>

        <div class="dropdown">
            <a class="d-flex align-items-center gap-2 text-decoration-none" href="#" id="profileDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">

                <img src="{{ (Auth::user()->image && Storage::exists(Auth::user()->image)) ? asset('storage/' . Auth::user()->image) : ((Auth::user()->employee && Auth::user()->employee->image && Storage::exists(Auth::user()->employee->image)) ? asset('storage/' . Auth::user()->employee->image) : asset('assets/images/default-user.jpeg')) }}"
                    class="rounded-circle" width="38" height="38" style="object-fit: cover" />

                <div class="d-flex flex-column text-start">
                    <span class="fw-semibold text-dark lh-1 fs-6">{{ auth()->user()->name }}</span>
                    <span class="text-muted fs-3 lh-1">{{ auth()->user()->email }}</span>
                </div>

                <i class="ti ti-chevron-down fs-4 text-primary ms-1"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                <li>
                    <a href="{{ route('extracurricular.profile') }}" class="dropdown-item d-flex align-items-center gap-2">
                        <i class="ti ti-user fs-4"></i> Profile
                    </a>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger fw-semibold">Log Out</button>
                    </form>
                </li>
            </ul>
        </div>

    </nav>
</header>
