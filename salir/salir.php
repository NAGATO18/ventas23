<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Sesión cerrada</title>

  <!-- Redirección después de 3 segundos -->
  <meta http-equiv="refresh" content="3;url=../login/iniciar_sesion.html" />

  <!-- Estilos de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .mensaje {
      text-align: center;
      padding: 2rem;
      border-radius: 0.5rem;
      background-color: #ffffff;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <div class="mensaje">
    <h3 class="text-success">
      <i class="bi bi-check-circle-fill"></i> Sesión cerrada correctamente
    </h3>
    <p class="text-muted">Serás redirigido al inicio de sesión en unos segundos...</p>
    <div class="spinner-border text-primary mt-3" role="status">
      <span class="visually-hidden">Redirigiendo...</span>
    </div>
  </div>

  <!-- JS de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
