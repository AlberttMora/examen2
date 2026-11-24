<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm p-4 text-center" style="max-width: 400px; width: 100%;">
            <h3 class="mb-2">Listas compartidas</h3>
            <p class="text-muted mb-4">Iniciá sesión para gestionar tus listas</p>

            <a href="{{ route('google') }}" class="btn btn-danger w-100">
                Continuar con Google
            </a>
        </div>
    </div>
</body>

</html>