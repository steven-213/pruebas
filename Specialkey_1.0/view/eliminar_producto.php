<?php
require "../controller/tabla_controller.php";
$id = $_GET['id'];
    // Crear una instancia del controlador
    $controlador = new TablaControlador();

// Obtener el ID del usuario desde la 
    // Llamar al método de eliminación
    $controlador-> Eliminar_producto_controlador($id);
    header('Location:base_productos.php');
     

?>
