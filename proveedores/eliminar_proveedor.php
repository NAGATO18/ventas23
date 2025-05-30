<?php
include '../conexion/conexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("CALL sp_eliminar_proveedor(?)");
$stmt->execute([$id]);

echo "Proveedor eliminado correctamente.";
?>
