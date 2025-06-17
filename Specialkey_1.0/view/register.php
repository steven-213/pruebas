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
  <title>Registro de Cuenta</title>
  <link rel="stylesheet" href="./style/style_register.css">
  <script>
    function ver() {
      var ver = document.getElementById('password');
      var button = document.getElementById('mostrar');
      if (ver.type === 'password') {
        ver.type = "text";
        button.textContent = "Ocultar";
      } else {
        ver.type = "password";
        button.textContent = "Mostrar";
      }
    }
  </script>
</head>
<body>
<header>
      <ul>
        <li id="tienda"><a href="../index.php">Tienda </a> | <a href="nosotros.php">Nosotros</a></li>
        <li id="speciallogo"><img src="imagenes/logo.png">
        <h2>Special keychein</h2></li>
        <li id="login"><img src="imagenes/login.png" ></a></li>
      </ul>
    </header>

  <section class="login-container">
    <div class="form-container">
      <h1>Crear una cuenta</h1>
      <form method="post">
      <input type="hidden" name="crear_usuario" value="register">
        <div class="input-group">
          <label for="usuario_log">Nombre:</label>
          <input type="text" id="usuario_log" name="usuario_log" required>
          <?php if (isset($ins_login->usuario_error)) { echo $ins_login->usuario_error; } ?>
        </div>

        <div class="input-group">
          <label for="correo_host">Correo electrónico:</label>
          <input type="email" id="correo_host" name="correo_host" required>
          <?php if (isset($ins_login->correo_error)) { echo $ins_login->correo_error; } ?>
        </div>

        <div class="input-group">
          <label for="documento_host">Tipo de Documento:</label>
          <select id="documento_host" name="documento_host">
            <option value="Cédula">Cédula</option>
            <option value="Cédula Extranjera">Cédula Extranjera</option>
            <option value="NIT">NIT</option>
            <option value="Registro Civil">Registro Civil</option>
            <option value="Tarjeta Identidad">Tarjeta Identidad</option>
          </select>
        </div>

        <div class="input-group">
          <label for="id_host">Nº de Documento:</label>
          <input name="id_host" type="text" minlength="7" maxlength="10" required>
          <?php if (isset($ins_login->cc_error)) { echo $ins_login->cc_error; } ?>
        </div>

        <div class="input-group">
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="clave_log" maxlength="20" required>
          <button id="mostrar" type="button" onclick="ver()">Mostrar</button>
        </div>

        <div class="button-group">
          <button type="submit">Registrarme</button>
          <button type="button" onclick="window.location.href='login.php'">Ya tengo cuenta</button>
        </div>
      </form>
    </div>
  </section>

  <?php include "../view/assets/adicional/footer.php" ?>
</body>
</html>