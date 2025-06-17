<?php

include_once 'controller/usuario_controller.php';


$controlador = new UsuarioControlador();
$usuarioRegistrado = $controlador->usuario_conectado1();
$resultado = $controlador->productos();
$resultado0 = $controlador->items_carrito();
$subtotal=$controlador->controller_total();
$total=$subtotal+15;

$estilosAlerta = "visibility: hidden;"; // Al principio está oculta
$alerta = "";

// Si el usuario no está registrado y se ha enviado un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['user_name'])) {
    $estilosAlerta =
        "visibility: visible;
    display: flex;
    justify-content: center;
    background-color: red;
    visibility: visible;
    }";  // Hacer visible la alerta
    $alerta = "Por favor regístrate para comprar";  // El mensaje de la alerta
    // Evitamos redirigir inmediatamente
    $mostrarAlerta = true;
}

// si el usuario está registrado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_name'])) {
    if (isset($_POST['producto_id'])) {
        // Si el producto fue comprado
        $productoId = $_POST['producto_id'];
        $usuarioControlador = new UsuarioControlador();
        $usuarioControlador->carrito($productoId);
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['nombre_producto'])) {
        // Si el carrito fue actualizado
        $controlador->controller_sumar($_POST['nombre_producto']);
        header("Location: index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>especialitos</title>
    <link rel="stylesheet" href="view/style/style_index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script>
        // para cuando se actualice la pagina el scroll siga en el mismo lado que antes de actualizarla 
        window.addEventListener("beforeunload", function() {
            localStorage.setItem("scrollPosition", window.scrollY);
        });

        window.addEventListener("load", function() {
            if (localStorage.getItem("scrollPosition") !== null) {
                window.scrollTo(0, parseInt(localStorage.getItem("scrollPosition"), 10));
            }
        });
    </script>
</head>

<body>
    <header>
        <ul>
            <li id="tienda">
                <a>| <a href="view/comunicate con nosotros.php">Contactanos</a> | <a href="view/nosotros.php">Nosotros</a>
            </li>
            <li id="speciallogo">
                <img src="view/imagenes/logo.png">
                <h2>Special keychein</h2>
            </li>
            <li id="login">
                <div>
                    <button id="button1" type="button"><img src="view/imagenes/carrito.png"></button>
                </div>
                <div>
                    <?php if ($usuarioRegistrado) { ?>
                        <a href="view/usuario.php"><img src="view/imagenes/login.png">
                            <div class="user"><?php echo $_SESSION['user_name']; ?></div>
                        </a>
                    <?php } else { ?>
                        <a href="view/login.php"><img src="view/imagenes/login.png"></a>
                    <?php } ?>
                </div>
            </li>
        </ul>
    </header>

    <div id="alerta" style="<?= $estilosAlerta ?>">
        <?php if (isset($alerta)) {
            echo $alerta;
        } ?>
    </div>

    <article>
        <!-- contenedor de el carrito de compras -->
        <div id="contenedor-alert">
            <?php if ($usuarioRegistrado) { ?>
                <section class="titulo">tus compras</section>
                <?php foreach ($resultado0 as $datos) {
                    $id = $datos['id']; ?>
                    <section id="contenedor">
                        <img src="mostrar_imagen_carrito.php?id=<?php echo $id; ?>">
                        <p><?php echo $datos['producto']; ?></p>
                        <div class="pay">
                            <p><?php echo $datos['precio']; ?></p>
                            <p><?php echo $datos['cantidad']; ?></p>
                        </div>
                        <!-- form oculto para SUMAR PRODUCTO -->
                        <form method="POST">
                            <input type="hidden" name="nombre_producto" value="<?php echo $datos['producto']; ?>">
                            <p>
                                <!--  para SUMAR PRODUCTO -->
                                <button type="submit" name="accion" value="incrementar">+</button>
                                <!-- para RESTAR PRODUCTO -->
                                <button type="submit" name="accion" value="restar">-</button>
                            </p>
                        </form>
                    </section>
                <?php } ?>
                <div>
                    <p><div class="datos_compra">subtotal: </div><?php echo $subtotal?></p>
                    <p><div class="datos_compra">impuestos: </div>5.000</p>
                    <p><div class="datos_compra">envio: </div>10.000</p>
                    <p><div class="datos_compra">total: </div><?php echo "$total.000"?></p>
                </div>

                <button id="button3" onclick="location.href='recibopdf.php'">Comprar</button>
                <button id="button2">cerrar</button>
            <?php } else { ?>
                <section id="error_carrito">Por favor inicie sesión</section>
                <div>
                    <img src="view/assets/adicional/esperar.gif" alt="esperar animado">
                </div>
                <button id="button2">cerrar</button>
            <?php } ?>
        </div>

        <!-- contenido de la pagina -->
        <?php foreach ($resultado as $datos) {
            $id = $datos['id']; ?>
            <section>
                <img src="mostrar_imagen.php?id=<?php echo $id; ?>">
                <p><?php echo $datos['nombre']; ?></p>
                <div class="content"><?php echo $datos['descripcion']; ?></div>
                <div class="pay">
                    <p><?php echo $datos['precio']; ?></p>
                    <form method="post" action="">
                        <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                        <button type="submit" name="comprar">Comprar</button>
                    </form>
                </div>
            </section>
        <?php } ?>
    </article>

    <script src="view/js/carrito.js"></script>
    <?php include "view/assets/adicional/footer.php"; ?>
</body>

</html>