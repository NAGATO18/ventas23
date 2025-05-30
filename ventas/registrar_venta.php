<?php
session_start();
include '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_cliente']) || empty($_SESSION['carrito'])) {
        header("Location: ventas.php?mensaje=error");
        exit;
    }

    $id_cliente = $_POST['id_cliente'];
    $carrito = $_SESSION['carrito'];

    // Construir JSON de productos para pasar al procedimiento almacenado
    $productos = [];
    foreach ($carrito as $item) {
        $productos[] = [
            'id_producto' => (int)$item['id_producto'],
            'cantidad' => (int)$item['cantidad']
        ];
    }
    $productos_json = json_encode($productos);

    try {
        // Llamar al procedimiento almacenado para registrar la venta
        $stmt = $pdo->prepare("CALL sp_registrar_venta(:id_cliente, :productos_json)");
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':productos_json', $productos_json, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();

        // Limpiar sesión carrito y cliente
        unset($_SESSION['carrito']);
        unset($_SESSION['id_cliente']);

        header("Location: ventas.php?mensaje=registrada");
        exit;
    } catch (PDOException $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
        exit;
    }
} else {
    header("Location: ventas.php");
    exit;
}
