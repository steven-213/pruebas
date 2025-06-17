<?php
require_once './model/main_model.php';

// Conexión a la base de datos
$db = mainModel::conectar();

// Capturar el parámetro 'id' desde la URL usando $_GET

    $id = $_GET['id'];

    // Preparar la consulta con el ID capturado
    $sql = $db->prepare("SELECT imagen FROM carrito WHERE id = :id");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);

    // Verificar si se obtuvo una imagen
    if (!empty($resultado['imagen'])) {
        // Enviar la cabecera adecuada para el tipo de imagen
        header("Content-Type: image/jpeg");
        echo $resultado['imagen'];
    } else {
        // Mostrar una imagen por defecto si no hay imagen en la base de datos
        header("Content-Type: image/png");
        echo file_get_contents('view/imagenes/error.png');
    }

?>
