<nav class="navbar navbar-expand-md bg-dark sticky-top border-bottom" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand d-md-none" href="/">
            <div class="d-flex align-items-center gap-2" style="width: 40px; height: 40px;">
                <img src="{{ asset('img/PustakaBekas.png') }}" alt=""
                    style="width: 100%; height: 100%; object-fit: cover;">
                <span>PustakaBekas</span>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"
            aria-controls="offcanvas" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasLabel">PustakaBekas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav flex-grow-1 justify-content-between">

                    <li class="nav-item">
                        <div style="width: 40px; height: 40px;">
                            <a class="nav-link {{ Request::is('/') ? 'active' : '' }} p-0" href="/">
                                <img src="{{ asset('img/PustakaBekas.png') }}" alt=""
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="/about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('books*') ? 'active' : '' }}"
                            href="{{ route('books.index') }}">Book</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('genres*') ? 'active' : '' }}"
                            href="{{ route('genres.index') }}">Genre</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('carts*') ? 'active' : '' }}"
                            href="{{ route('carts.index') }}">
                            <svg class="bi" width="24" height="24">
                                <use xlink:href="#cart" />
                            </svg>
                        </a>
                    </li>

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Welcome back, {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item d-flex" href="{{ route('auth.dashboard') }}">
                                        <i class="bi bi-layout-text-sidebar-reverse me-2"></i> My Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex {{ Request::is('users*') ? 'active' : '' }}"
                                        href="{{ route('users.index') }}">
                                        <i class="bi bi-person-circle me-2"></i> Profile
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="/login" class="nav-link d-flex {{ Request::is('login') ? 'active' : '' }}">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Login
                            </a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </div>
</nav>
