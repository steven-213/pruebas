<?php
session_start();
// Incluye los archivos necesarios de PHPMailer
require '../view/assets/PHPMailer/src/PHPMailer.php';
require '../view/assets/PHPMailer/src/SMTP.php';
require '../view/assets/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP(); 
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true; 
    $mail->Username   = 'specialkey010@gmail.com'; 
    $mail->Password   = 'ygid vrti yiga gjzy'; 
    $mail->SMTPKeepAlive = true; // Mantener la conexión activa
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 587;

    // Remitente del correo
    $mail->setFrom('specialkey010@gmail.com', 'SpecialKeychain');

    $mail->isHTML(true); 

} catch (Exception $e) {
    echo "El correo no se pudo enviar. Error: {$mail->ErrorInfo}";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
    $text= isset($_REQUEST['text']) ? $_REQUEST['text'] : '';

    // Enviar correo al usuario con agradecimiento
    $mail->clearAddresses(); // Limpiar las direcciones anteriores
    $mail->addAddress($email, 'Usuario');
    $mail->Subject = 'Gracias por tu comentario';
    $mail->Body = "Hola,<br><br>Gracias por contactarte con Special Key. Hemos recibido el siguiente mensaje:<br><br>\"$text\"<br><br>Nos pondremos en contacto contigo pronto.<br><br>Saludos,<br>Special Key";
    $mail->AltBody = "Hola,\n\nGracias por contactarte con Special Key. Hemos recibido el siguiente mensaje:\n\n\"$text\"\n\nNos pondremos en contacto contigo pronto.\n\nSaludos,\nSpecial Key";

    $mail->send();

    // Enviar correo a la dirección de Special Key con el contenido del usuario
    $mail->clearAddresses(); // Limpiar las direcciones anteriores
    $mail->addAddress('specialkey010@gmail.com', 'SpecialKeychain');
    $mail->Subject = 'Nuevo comentario de usuario';
    $mail->Body = "Has recibido un nuevo comentario de un usuario:<br><br>Email: $email<br>Mensaje: $text";
    $mail->AltBody = "Has recibido un nuevo comentario de un usuario:\n\nEmail: $email\nMensaje: $text";

    $mail->send();
  
    // Usar JavaScript para mostrar la alerta y luego redirigir
    echo "<script>
        alert('Gracias por tu comentario, nos pondremos en contacto contigo.');
        window.location.href = 'comunicate con nosotros.php';
    </script>";
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
    <link rel="stylesheet" href="style/style_queja.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
  </head>
  <body>
    <header>
      <ul>
        <li id="tienda"><a href="../index.php">Tienda </a> | <a href="nosotros.php">Nosotros</a></li>
        <li id="speciallogo"><img src="imagenes/logo.png">
        <h2>Special keychein</h2></li>
        <li id="login"> <?php if(isset($_SESSION['user_name'])){?><a href="usuario.php"><?php }else{?> <a href="register.php"> <?php } ?><img src="imagenes/login.png" ></a></li>
      </ul>
    </header>
    <section class="Cum">
        <h4>Comunicate Con Nosotros</h4>
        <form method="post">
         <label for="email"></label>
         <input type="email" name="email" placeholder="Tu Correo">
         <label for="text"></label>
         <input type="text" name="text" placeholder="Escribe aqui para lo que nos necesites">
        <button type="submit">Enviar</button>
        </form>
     </section> 
     <?php include "../view/assets/adicional/footer.php"?>
  </body>
</html>
