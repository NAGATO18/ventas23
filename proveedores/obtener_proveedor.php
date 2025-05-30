<?php
include '../conexion/conexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("CALL sp_obtener_proveedor(?)");
$stmt->execute([$id]);
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($proveedor);
?>
