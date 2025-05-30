<?php
include '../conexion/conexion.php';

$stmt = $pdo->query("CALL sp_listar_proveedores()");
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($proveedores);
?>
