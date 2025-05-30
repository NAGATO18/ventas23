<?php
include '../conexion/conexion.php';

$descripcion = $_POST['descripcion'];

// Validar que la descripción solo contenga letras y espacios
if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $descripcion)) {
    echo "Error: No se pueden guardar números en la descripción de la categoría.";
    exit;
}

$stmt = $pdo->prepare("CALL sp_insertar_categoria(?)");
$stmt->execute([$descripcion]);

echo "Categoría creada correctamente.";
?>
