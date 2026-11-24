<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista no encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm p-4 text-center" style="max-width: 420px; width: 100%;">
            <h1 class="display-4 text-danger mb-2">404</h1>
            <h4 class="mb-2">Lista no encontrada</h4>
            <p class="text-muted mb-4">
                El enlace que usaste no es válido o la lista ya fue eliminada.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary w-100">Ir al inicio</a>
        </div>
    </div>
</body>

</html>