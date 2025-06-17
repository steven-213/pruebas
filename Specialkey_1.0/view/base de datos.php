
<?php require "../controller/tabla_controller.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style_base de datos.css">
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
<table>
     <thead>
    <th>ID</th>
    <th>NOMBRE</th>
    <th>ROL</th>
    <th>CLAVE</th>
    <th>MODIFICAR</th>
    <th>ELIMINAR</th>
</thead> 
<?php if(!isset($_SESSION['user_name'])){?>
    <button  id="button" onclick="window.location.href='../index.php'">regresar</button><?php } 

$tabla=new TablaControlador;
$tabla->Register_controlador();
?>
</table>
<div>
<button onclick="window.location.href='crear_usuario.php'" >crear</button>
<button  id="button" onclick="window.location.href='../index.php'">regresar</button>
</div>
<?php include "../view/assets/adicional/footer.php"?>
</body>
</html>