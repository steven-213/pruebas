<?php
require "../controller/login_controller.php";
$ins_login = new loginControlador();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $ins_login->iniciar_sesion_controlador();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/style_login.css">
</head>

<body>
    <header>
        <header>
            <ul>
                <li id="tienda"><a href="../index.php">Tienda </a> | <a href="nosotros.php">Nosotros</a></li>
                <li id="speciallogo"><img src="imagenes/logo.png">
                    <h2>Special keychein</h2>
                </li>
                <li id="login"><img src="imagenes/login.png"></a></li>
            </ul>
        </header>
    </header>
    <article class="login">

        <div id="login2">
            <p class="titulo1">Login</p>
            <form action="" method="POST" autocomplete="off">
                <div class="form-group">
                    <label> Usuario</label>
                    <input type="text" class="form-control" name="usuario_log" pattern="[a-zA-Z0-9]{1,35}" maxlength="12" required>
                    <?php if (isset($ins_login->usuario_error)) {
                        echo $ins_login->usuario_error;
                    } ?>
                </div>
                <div>
                    <label>&nbsp; Contraseña</label>
                    <input type="password" name="clave_log" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="12" required>
                    <?php if (isset($ins_login->contraseña_error)) {
                        echo $ins_login->contraseña_error;
                    } ?>
                </div>
                <div class="button">
                    <button type="submit">Iniciar Sesion</button>
                    <button onclick="window.location.href='register.php'">Registrarme</button>
                </div>
            </form>
        </div>
        </div>
    </article>
    <?php include "../view/assets/adicional/footer.php" ?>
</body>

</html>