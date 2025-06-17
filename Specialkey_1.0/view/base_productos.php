
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
                | <a href="base de datos.php">usuarios</a> |
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
    <th>IMAGEN</th>
    <th>DESCRIPCION</th>
    <th>PRECIO</th>
    <th>ID_CATEGORIA</th>
    <th>ACTIVO</th>
    <th>MODIFICAR</th>
    <th>ELIMINAR</th>
</thead> 
<?php if(!isset($_SESSION['user_name'])){?>
    <button  id="button" onclick="window.location.href='../index.php'">regresar</button><?php } 

$tabla=new TablaControlador;
$tabla->productos_controller();
?>
</table>
<div>
<button onclick="window.location.href='crear_producto.php'" >crear</button>
<button  id="button" onclick="window.location.href='../index.php'">regresar</button>
</div>
<?php include "../view/assets/adicional/footer.php"?>
</body>
</html>