<?php
include '../conexion/conexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("CALL sp_eliminar_categoria(?)");
$stmt->execute([$id]);

echo "Categoría eliminada correctamente.";
?>
