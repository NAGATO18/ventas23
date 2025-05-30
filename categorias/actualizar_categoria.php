<?php
include '../conexion/conexion.php';

$id_categoria = $_POST['id_categoria'];
$descripcion = $_POST['descripcion'];

$stmt = $pdo->prepare("CALL sp_actualizar_categoria(?, ?)");
$stmt->execute([$id_categoria, $descripcion]);

echo "Categoría actualizada correctamente.";
?>
