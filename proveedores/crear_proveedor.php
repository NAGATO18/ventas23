<?php
include '../conexion/conexion.php';

$razonsocial = $_POST['razonsocial'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

// Validar que telefono contenga solo números
if (!ctype_digit($telefono)) {
    echo "Error: El teléfono debe contener solo números.";
    exit;  // Detiene la ejecución
}

$stmt = $pdo->prepare("CALL sp_insertar_proveedor(?, ?, ?)");
$stmt->execute([$razonsocial, $direccion, $telefono]);

echo "Proveedor creado correctamente.";
?>
