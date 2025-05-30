<?php
include '../conexion/conexion.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("CALL sp_eliminar_producto(?)");
$stmt->execute([$id]);

echo "Producto eliminado correctamente.";
?>
