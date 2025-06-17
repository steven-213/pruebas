<?php
require_once 'view/assets/TCPDF-main/tcpdf.php';
include_once 'controller/usuario_controller.php';


// Crear instancia del controlador
$controlador = new UsuarioControlador();
$recibo = $controlador->controller_recibo();
$subtotal=$controlador->controller_total();
$total=$subtotal+15;  // Obtén los datos del recibo

// Crear un nuevo documento PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer la información del documento
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Special Keychain');
$pdf->setTitle('Compra');
$pdf->setSubject('Recibo de compra');
$pdf->setKeywords('TCPDF, PDF, ejemplo, prueba, guía');

// Cambiar la imagen del encabezado
$logo = 'view/imagenes/logo.png';  // Ruta de la imagen
$logo_width = 30; // Ancho de la imagen
$title = 'Special Keychain';
$string = 'Gracias por tu compra :)';
$comprador=$_SESSION['user_name'];

// Agregar la imagen directamente en el encabezado
$pdf->AddPage();  // Agregar una página
$pdf->Image($logo, 15, 10, $logo_width);  // Agregar la imagen en las coordenadas (15, 10) con el ancho especificado
$pdf->SetFont('times', '', 16);  // Establecer la fuente

// Establecer el título y el texto del encabezado
$pdf->SetXY(75, 15);  // Establecer la posición del texto del título
$pdf->Cell(0, 10, $title, 0, 1, 'L');  // Agregar el título
$pdf->SetXY(75, 25);  // Establecer la posición del texto del mensaje
$pdf->Cell(0, 10, $string, 0, 1, 'L');  // Agregar el mensaje
$pdf->Ln(10);
$pdf->Cell(0, 10, $comprador, 0, 1, 'L'); 

// Agregar los productos del carrito
foreach ($recibo as $producto) {
    $pdf->Ln(10);  // Salto de línea
    $pdf->Cell(0, 10, 'Producto: ' . $producto['nombre_producto'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Precio: ' . $producto['precio'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Cantidad: ' . $producto['cantidad'], 0, 1, 'L');
}
$pdf->Ln(10);
$pdf->Cell(0, 10, 'sumbtotal: ' .$subtotal , 0, 1, 'L');
$pdf->Cell(0, 10, 'impuestos: ' ."5.000", 0, 1, 'L');
$pdf->Cell(0, 10, 'envio:' . "10.000", 0, 1, 'L');
$pdf->Cell(0, 10, 'total:' . "$total.000", 0, 1, 'L');

// Cerrar y generar el documento PDF
$pdf->Output('recibo.pdf', 'D');

