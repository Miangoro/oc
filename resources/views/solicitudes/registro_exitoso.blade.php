<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro Exitoso</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Roboto', Arial, sans-serif;
    }
    .success-card {
        max-width: 800px;
        margin: auto;
        padding: 40px;
        border-radius: 20px;
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        text-align: center;
        animation: fadeIn 0.5s ease-in-out;
    }
    .success-img {
        max-width: 280px;
        margin-bottom: -30px;
    }
    .success-title {
        font-size: 2.8rem;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 15px;
    }
    .success-text {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 30px;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="success-card">
        <img src="{{ asset('assets/img/registro_exitoso.png') }}" alt="Registro Exitoso" class="success-img">
        <h1 class="success-title">¡Registro exitoso!</h1>
        <p class="success-text">
            Su solicitud se ha registrado correctamente.
            Nos pondremos en contacto con usted lo más pronto posible para dar seguimiento a su proceso de certificación de mezcal.
        </p>
        <a href="{{ route('login') }}" class="btn btn-success btn-lg px-4">Ir al inicio de sesión</a>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
