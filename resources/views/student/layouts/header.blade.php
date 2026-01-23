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

                <img src="{{ Auth::user()->student->image && Storage::disk('public')->exists(Auth::user()->student->image)
                    ? asset('storage/' . Auth::user()->student->image)
                    : asset('assets/images/default-user.jpeg') }}"
                    class="rounded-circle" width="38" height="38" style="object-fit: cover" />

                <div class="d-flex flex-column text-start">
                    <span class="fw-semibold text-dark lh-1 fs-6">{{ auth()->user()->name }}</span>
                    <span class="text-muted fs-3 lh-1">{{ auth()->user()->email }}</span>
                </div>

                <i class="ti ti-chevron-down fs-4 text-primary ms-1"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                {{-- <li class="px-3 py-2">
                    <div class="d-flex align-items-center">
                        <img src="{{ Auth::user()->student->image && Storage::exists('public/' . Auth::user()->student->image) 
                            ? asset('storage/' . Auth::user()->student->image) 
                            : asset('assets/images/default-user.jpeg') }}" 
                            class="rounded-circle" width="55" height="55" style="object-fit: cover">
                        <div class="ms-3">
                            <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                    </div>
                </li> --}}
                {{-- <li><hr class="dropdown-divider"></li> --}}
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
