<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Panel Control</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      min-height: 100vh;
      margin: 0;
      padding: 0;
      background-image: url(https://www.departamentodemarketing.net/wp-content/uploads/2022/06/claves-del-punto-de-venta.jpg);
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      color: #fff;
      font-family: Arial, sans-serif;
    }

    .fondo-bienvenida {
      height: calc(100vh - 56px); /* Altura total menos navbar */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente para mejorar legibilidad */
      text-align: center;
      padding: 1rem;
    }
  </style>
</head>
<body>

  <!-- Barra de navegación -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="principal_admin.php">Admin WEB-Minimarket</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarAdmin">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="../productos/productos.html">
              <i class="bi bi-box-seam"></i> Productos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../categorias/categoria.html">
              <i class="bi bi-tags"></i> Categorías
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../proveedores/proveedores.html">
              <i class="bi bi-truck"></i> Proveedores
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../clientes/listar.html">
              <i class="bi bi-people"></i> Clientes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="../salir/salir.php">
              <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Sección de bienvenida con imagen de fondo -->
  <div class="container-fluid fondo-bienvenida">
    <h1 class="display-5 fw-semibold">Bienvenido al Panel de Control</h1>
    <p class="lead">Usa la barra de navegación para gestionar la información.</p>
  </div>

  <!-- Bootstrap JS Bundle (incluye Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
