<?php
session_start();
class verificar_user{function __construct()
    {
        
        if (!isset($_SESSION['user_name'])) {
            echo "Acceso denegado. Por favor, inicie sesión.";
            exit(); 
        }
    }}
$verificar=new verificar_user();
include_once '../model/main_model.php';


// Crear datos necesarios para la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Special_Keychain";
$con=new mainModel();
$datos=['Usuario' =>$_SESSION['user_name']];
$con= mainModel::iniciar_sesion_modelo($datos);
$con=$con->fetch(PDO::FETCH_ASSOC);

if ($con['rol']=='rol_admin'){
    $administrador=true;
}
else{
    $administrador=false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
session_destroy(); 
header("Location: ../index.php"); 
exit();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>especialitos</title>
    <link rel="stylesheet" href="style/style_index.css">
    <link rel="stylesheet" href="style/style_usuario.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <ul>
            <li id="tienda">
                <a href="../index.php">Tienda</a> |<?php if($administrador) { ?><a href="base de datos.php">base de datos</a>| <?php } ?><a href="comunicate con nosotros.php">Contactanos</a> | <a href="nosotros.php">Nosotros</a>
                </li>
    </header>
    <div>
        <h1> bienvenido</h1>

        <img src="imagenes/login.png" alt="Login">
        <h3><?php echo $_SESSION['user_name'] ?></h3>
       <form method="POST"><button type="submit">salir de cuenta </button></form> 
        <h2></h2>
    </div>
    <?php include "../view/assets/adicional/footer.php"; ?>
</body>

</html>