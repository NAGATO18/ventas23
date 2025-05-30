<?php
session_start();
include '../conexion/conexion.php';

header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
  echo json_encode(['success' => false, 'message' => 'Correo y contraseña son obligatorios.']);
  exit;
}

try {
  $stmt = $pdo->prepare("CALL obtener_usuario_por_email(?)");
  $stmt->execute([$email]);
  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($usuario) {
    if (password_verify($password, $usuario['contraseña'])) {
      $_SESSION['id_usuario'] = $usuario['id_usuario'];
      $_SESSION['nombre'] = $usuario['nombre'] ?? '';
      $_SESSION['rol'] = $usuario['rol'];

      // Redireccionar según el rol
      if ($usuario['rol'] === 'administrador') {
        echo json_encode(['success' => true, 'redirect' => '../vistas/principal_admin.php']);
      } elseif ($usuario['rol'] === 'usuario') {
        echo json_encode(['success' => true, 'redirect' => '../vistas/principal_usuario.php']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Rol no válido.']);
      }

    } else {
      echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta.']);
    }

  } else {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
  }

} catch (Exception $e) {
  echo json_encode(['success' => false, 'message' => 'Error en el servidor.']);
}
?>
