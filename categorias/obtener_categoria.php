<?php
include '../conexion/conexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("CALL sp_obtener_categoria(?)");
$stmt->execute([$id]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($categoria);
?>
