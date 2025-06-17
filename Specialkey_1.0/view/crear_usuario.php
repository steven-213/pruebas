<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require "../controller/register_controller.php";
    $ins_login = new RegisterControlador();
    $ins_login->Register_controlador();
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crear usuario</title>
    <link rel="stylesheet" href="style/style_base de datos.css">
    <link rel="stylesheet" href="style/style_modificar.css">

</head>
<body>
<header>
        <ul>
            <li id="tienda">
                | <a href="base_productos.php">compras</a> |
            </li>
            <li id="speciallogo">
                <img src="imagenes/logo.png">
                <h2>Special keychein</h2>
            </li>
            <li id="login">
                <div>
                        <a href="usuario.php"><img src="imagenes/login.png"></a>
                </div>
            </li>
        </ul>
    </header>
    <h1>Modificar Datos</h1>
    <div class="container">
    <form method="post">
    <input type="hidden" name="crear_usuario" value="crear_user">
          <div>
            Nombre:
            <input type="text" name="usuario_log" required>
            <?php if (isset($ins_login->usuario_error)) {
              echo $ins_login->usuario_error;
            } ?>
          </div>
          <div>
            Correo electrónico:
            <input type="email" name="correo_host" required>
            <?php if (isset($ins_login->correo_error)) {
              echo $ins_login->correo_error;
            }
            ?>
          </div>
          <div>
            <label>Tipo de Documento:</label>
            <select name="documento_host">
              <option value="Cédula">Cédula</option>
              <option value="Cédula Extranjera">Cédula Extranjera</option>
              <option value="NIT">NIT</option>
              <option value="Registro Civil">Registro Civil</option>
              <option value="Tarjeta Identidad">Tarjeta Identidad</option>

            </select>
          </div>
          <div>
            Nº de Documento:
            <input name="id_host" type="text" minlength="7" maxlength="10" required>
            <?php if (isset($ins_login->cc_error)) {
              echo $ins_login-> cc_error;
            } ?>
          </div>
          <div>
            Contraseña:
            <input type="text" name="clave_log" id="password" maxlength="20" required>
          </div>
     <div>
            <label>Elige Rol</label>
            <select name="Rol_host">
            <option value="rol_usuario">Usuario</option>
              <option value="rol_admin">Admin</option>
        
            </select>
          </div>
          <button type="submit">crear</button>
          </div>

    <?php include "../view/assets/adicional/footer.php"; ?>
</body>
</html>
