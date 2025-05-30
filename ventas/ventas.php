<?php
session_start();
include '../conexion/conexion.php';

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Guardar cliente seleccionado en sesión si se envía (solo si no hay carrito)
if (isset($_POST['id_cliente']) && empty($_SESSION['carrito'])) {
    $_SESSION['id_cliente'] = $_POST['id_cliente'];
}

// Eliminar producto del carrito
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $index = (int)$_GET['eliminar'];
    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
    if (empty($_SESSION['carrito'])) {
        unset($_SESSION['id_cliente']);
    }
    header("Location: ventas.php");
    exit;
}

// Obtener productos
$stmt_productos = $pdo->query("CALL sp_obtener_productos_venta()");
$productos = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);
$stmt_productos->closeCursor();

// Obtener clientes
$stmt_clientes = $pdo->query("CALL sp_obtener_clientes_venta()");
$clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);
$stmt_clientes->closeCursor();

// Agregar producto al carrito
if (isset($_POST['agregar_producto'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    if (!is_numeric($cantidad) || $cantidad <= 0) {
        header("Location: ventas.php");
        exit;
    }

    $stmt = $pdo->prepare("CALL sp_obtener_producto_por_id(:id_producto)");
    $stmt->execute([':id_producto' => $id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    if ($producto) {
        $encontrado = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id_producto'] == $id_producto) {
                $item['cantidad'] += $cantidad;
                $encontrado = true;
                break;
            }
        }
        unset($item);
        if (!$encontrado) {
            $_SESSION['carrito'][] = [
                'id_producto' => $id_producto,
                'descripcion' => $producto['descripcion'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad
            ];
        }
    }
    header("Location: ventas.php");
    exit;
}

// Obtener ventas realizadas
$stmt_ventas = $pdo->query("CALL sp_obtener_ventas()");
$ventas = $stmt_ventas->fetchAll(PDO::FETCH_ASSOC);
$stmt_ventas->closeCursor();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="../vistas/principal_usuario.php">WEB-Minimarket</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUsuario" aria-controls="navbarUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarUsuario">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php">
                        <i class="bi bi-cash-register"></i> Ventas
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

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-cash-coin"></i> Registrar Nueva Venta</h2>

    <form method="POST" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Cliente</label>
            <select name="id_cliente" class="form-select" required <?= !empty($_SESSION['carrito']) ? 'disabled' : '' ?>>
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id_cliente'] ?>"
                        <?= (isset($_SESSION['id_cliente']) && $_SESSION['id_cliente'] == $cliente['id_cliente']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cliente['nombre_cliente']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Producto</label>
            <select name="id_producto" class="form-select" required>
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto['id_producto'] ?>">
                        <?= htmlspecialchars($producto['descripcion']) ?> - S/ <?= number_format($producto['precio'], 2) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" min="1" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" name="agregar_producto" class="btn btn-primary w-100">
                <i class="bi bi-cart-plus"></i> Agregar
            </button>
        </div>
    </form>

    <?php if (!empty($_SESSION['carrito'])): ?>
        <h4 class="mt-5">Carrito de Venta</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['carrito'] as $i => $item):
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['descripcion']) ?></td>
                        <td>S/ <?= number_format($item['precio'], 2) ?></td>
                        <td><?= (int)$item['cantidad'] ?></td>
                        <td>S/ <?= number_format($subtotal, 2) ?></td>
                        <td>
                            <a href="ventas.php?eliminar=<?= $i ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este producto del carrito?')">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2"><strong>S/ <?= number_format($total, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <form method="POST" action="registrar_venta.php" class="d-flex gap-2 align-items-center mt-3">
            <input type="hidden" name="id_cliente" value="<?= $_SESSION['id_cliente'] ?>">
            <button type="submit" name="registrar_venta" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Registrar Venta
            </button>
            <a href="generar_boleta.php" class="btn btn-outline-secondary" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
            </a>
        </form>
    <?php endif; ?>

    <h4 class="mt-5">Ventas Realizadas</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>ID Cliente</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?= $venta['id_venta'] ?></td>
                    <td><?= $venta['fecha'] ?></td>
                    <td><?= $venta['id_cliente'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'registrada'): ?>
        <div class="alert alert-success">Venta registrada exitosamente.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
