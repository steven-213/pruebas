<?php
require "../controller/tabla_controller.php";

// Obtener el ID del usuario desde la URL
$id = $_GET['id'];

// Instancia del controlador
$tabla_controlador = new TablaControlador();

// Si se ha enviado el formulario, actualizar los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos enviados por el formulario
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['clave'];
    $rol=$_POST['Rol_host'];

    // Llamar al controlador para actualizar
    $tabla_controlador->Actualizar_controlador($id, $nombre,$rol, $contraseña);
} else {
    // Si no se ha enviado el formulario, obtener los datos del usuario para editarlos
    $dato = $tabla_controlador->Editar_controlador($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Datos</title>
    <link rel="stylesheet" href="style/style_modificar.css">
</head>
<body>
    <h1>Modificar Datos</h1>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo ($dato['NOMBRE']); ?>" maxlength="12" required><br>

        <label>Elige Rol</label>
            <select name="Rol_host">
            <option value="rol_usuario">Usuario</option>
              <option value="rol_admin">Admin</option>
            </select>
        <label for="clave">Contraseña:</label>
        <input type="text" id="clave" name="clave" value="<?php echo ($dato['CLAVE']); ?>" maxlength="12" required><br>
        
        <button type="submit">Actualizar</button>
    <?php include "../view/assets/adicional/footer.php"; ?>
</body>
</html>
