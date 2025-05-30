<?php
include '../conexion/conexion.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("CALL sp_obtener_producto(?)");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->closeCursor();

echo json_encode($producto);
?>
