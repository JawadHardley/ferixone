<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.1.1/dist/css/tabler.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/mystyle.css') }}">

    <title>Ferixone</title>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>

    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-sm" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark p-5 fs-1">
                    <a href="#">
                        <i class="fa fa-train-subway me-1"></i> Ferix
                    </a>
                </h1>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link" href="./">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fa fa-house"></i>
                                </span>
                                <span class="nav-link-title"> Home </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fa fa-cogs"></i>
                                </span>
                                <span class="nav-link-title"> Coming soon ... </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <div class="page-wrapper">
            <div class="page-header px-5">
                <div class="row align-items-center">
                    @php
                    $imageUrl = asset('storage/images/jawad.jpg');
                    @endphp
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="false">
                            <span class="avatar avatar-lg" style="background-image: url('{{ $imageUrl }}')"> </span>
                            <div class="d-none d-xl-block ps-2">
                                <h1 class="fs-2 pb-0 mb-0">{{ Auth::user()->name}}</h1>
                                <div class="mt-1 small text-secondary">Administrator</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu- dropdown-menu-arrow">
                            <a href="#" class="dropdown-item" id="themeToggle">
                                <i class="fa fa-moon" id="themeIcon"></i> Theme
                            </a>
                            <a href="./profile.html" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Feedback</a>
                            <div class="dropdown-divider"></div>
                            <a href="./settings.html" class="dropdown-item">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="route('logout')" class="dropdown-item"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="page-body m-0">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


    <div class="container">
    </div>
    <script src="{{ asset('js/mystyle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.1.1/dist/js/tabler.min.js"></script>
</body>

</html>