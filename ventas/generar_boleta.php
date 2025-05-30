<?php
session_start();
require('../fpdf/fpdf.php');
include '../conexion/conexion.php'; // conexión a la base de datos

// Verificar que haya productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die("No hay productos en el carrito para generar la boleta.");
}

// Verificar que haya un cliente seleccionado
if (!isset($_SESSION['id_cliente'])) {
    die("No hay cliente seleccionado.");
}

// Configurar zona horaria de Perú
date_default_timezone_set('America/Lima');

// Obtener datos del cliente usando procedimiento almacenado
$id_cliente = $_SESSION['id_cliente'];
$stmt = $pdo->prepare("CALL sp_obtener_nombre_cliente(:id_cliente)");
$stmt->execute([':id_cliente' => $id_cliente]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
$nombre_cliente = $cliente ? $cliente['nombre_completo'] : "Desconocido";

// Obtener fecha y hora actual en formato 12h con AM/PM
$fechaHora = date('d/m/Y h:i:s A');

// Definir clase personalizada de FPDF
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Boleta de Venta WEB-Minimarket',0,1,'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo(),0,0,'C');
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Mostrar información del cliente y fecha
$pdf->Cell(0,8, "Cliente ID: $id_cliente", 0, 1);
$pdf->Cell(0,8, "Nombre: $nombre_cliente", 0, 1);
$pdf->Cell(0,8, "Fecha y Hora: $fechaHora", 0, 1);
$pdf->Ln(5);

// Tabla de productos
$pdf->SetFont('Arial','B',12);
$pdf->Cell(80,10,'Producto',1);
$pdf->Cell(30,10,'Precio Unit.',1,0,'R');
$pdf->Cell(30,10,'Cantidad',1,0,'R');
$pdf->Cell(40,10,'Subtotal',1,1,'R');

$pdf->SetFont('Arial','',12);
$total = 0;

foreach ($_SESSION['carrito'] as $item) {
    $descripcion = utf8_decode($item['descripcion']);
    $precio = $item['precio'];
    $cantidad = $item['cantidad'];
    $subtotal = $precio * $cantidad;
    $total += $subtotal;

    $pdf->Cell(80,10,$descripcion,1);
    $pdf->Cell(30,10,number_format($precio, 2),1,0,'R');
    $pdf->Cell(30,10,$cantidad,1,0,'R');
    $pdf->Cell(40,10,number_format($subtotal, 2),1,1,'R');
}

// Total
$pdf->SetFont('Arial','B',12);
$pdf->Cell(140,10,'Total',1);
$pdf->Cell(40,10,'S/ '.number_format($total, 2),1,1,'R');

// Salida del PDF
$pdf->Output('I', 'boleta_venta.pdf');
?>
