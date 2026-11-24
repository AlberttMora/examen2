<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | Listas compartidas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('themes/admin/css/style.css') }}" rel="stylesheet">
</head>

<body class="login-page">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="login-card text-center">

            <div class="icon-container">
                <i class="fa-solid fa-list-check"></i>
            </div>

            <h3 class="login-title mb-2">Listas compartidas</h3>

            <p class="login-description mb-4">
                Organiza tus tareas, administra tus listas y compartelas con quien quieras.
            </p>

            <a href="{{ route('google') }}" class="btn google-btn w-100">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
                Continuar con Google
            </a>

            <div class="mt-4">
                <p class="footer-text mb-0">
                    <i class="fa-solid fa-lock me-1"></i>
                    Acceso seguro mediante Google
                </p>
            </div>

        </div>

    </div>

</body>

</html>