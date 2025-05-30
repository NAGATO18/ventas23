<?php
include '../conexion/conexion.php';

$stmt = $pdo->query("CALL sp_listar_categorias()");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($categorias);
?>
