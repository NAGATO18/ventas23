<?php
include '../conexion/conexion.php';

$stmt = $pdo->query("CALL sp_listar_productos()");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Importante: para procedimientos almacenados con CALL, liberar el cursor (opcional pero recomendado)
$stmt->closeCursor();

echo json_encode($productos);
?>
