<?php
include '../conexion/conexion.php';

$nombres   = trim($_POST['nombres']);
$apellidos = trim($_POST['apellidos']);
$direccion = trim($_POST['direccion']);
$telefono  = trim($_POST['telefono']);

// Validación: nombres y apellidos solo letras y espacios
if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombres)) {
    http_response_code(400);
    echo "El campo 'nombres' solo debe contener letras y espacios.";
    exit;
}

if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellidos)) {
    http_response_code(400);
    echo "El campo 'apellidos' solo debe contener letras y espacios.";
    exit;
}

// Validación: dirección no vacía y máximo 100 caracteres
if (empty($direccion) || strlen($direccion) > 100) {
    http_response_code(400);
    echo "La dirección es obligatoria y no debe superar los 100 caracteres.";
    exit;
}

// Validación: teléfono solo dígitos, 7 a 9 cifras típicamente
if (!preg_match('/^\d{1,9}$/', $telefono)) {
    http_response_code(400);
    echo "El número de teléfono debe contener solo dígitos (9 cifras).";
    exit;
}

try {
    $stmt = $pdo->prepare("CALL sp_insertar_cliente(?, ?, ?, ?)");
    $stmt->execute([$nombres, $apellidos, $direccion, $telefono]);
    echo "Cliente creado correctamente.";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error al insertar cliente: " . $e->getMessage();
}
?>
