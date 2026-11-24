<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Listas compartidas')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fuente e iconos (CDN, igual que el theme) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap y estilos del theme -->
    <link href="{{ asset('themes/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/admin/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">

        <!-- Sidebar -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="{{ route('listas.index') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-tasks me-2"></i>LISTAS</h3>
                </a>

                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ Auth::user()->nombre }}</h6>
                        <span>Mis listas</span>
                    </div>
                </div>

                <div class="navbar-nav w-100">
                    <a href="{{ route('listas.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('listas.index') ? 'active' : '' }}">
                        <i class="fa fa-list me-2"></i>Mis listas
                    </a>
                    <a href="{{ route('listas.create') }}"
                        class="nav-item nav-link {{ request()->routeIs('listas.create') ? 'active' : '' }}">
                        <i class="fa fa-plus me-2"></i>Nueva lista
                    </a>
                </div>
            </nav>
        </div>

        <!-- Contenido -->
        <div class="content">
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->nombre }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid pt-4 px-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar el sidebar (lo único que ocupamos de main.js)
        $('.sidebar-toggler').on('click', function () {
            $('.sidebar, .content').toggleClass('open');
            return false;
        });
    </script>
    @stack('scripts')
</body>

</html>