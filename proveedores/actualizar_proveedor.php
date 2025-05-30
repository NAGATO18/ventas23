<?php
include '../conexion/conexion.php';

$id_proveedor = $_POST['id_proveedor'];
$razonsocial = $_POST['razonsocial'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

$stmt = $pdo->prepare("CALL sp_actualizar_proveedor(?, ?, ?, ?)");
$stmt->execute([$id_proveedor, $razonsocial, $direccion, $telefono]);

echo "Proveedor actualizado correctamente.";
?>
