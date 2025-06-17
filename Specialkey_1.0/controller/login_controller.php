<?php
require "../model/main_model.php";

session_start();
class loginControlador extends mainModel {
    public function __construct()
        {
            
            if (isset($_SESSION['user_name'])) {
                echo "Acceso denegado. Ya inició sesión";
                exit(); 
            }
        }
    public $usuario_error;
    public $contraseña_error;

    public function iniciar_sesion_controlador() {
        if (isset($_POST['usuario_log']) && isset($_POST['clave_log'])) {
            // Obtener datos del formulario
            $usuario = $_POST['usuario_log'];
            $clave = $_POST['clave_log'];

            // Preparar datos para el modelo
            $datos = ['Usuario' => $usuario];

            // Consultar la base de datos
            $query = self::iniciar_sesion_modelo($datos);

            if ($query->rowCount() > 0) {
                // Obtener datos del usuario
                $user = $query->fetch(PDO::FETCH_ASSOC);

                // Verificar si la clave ingresada coincide exactamente
                // (según tu modelo de registro, parece que la clave no está hasheada)
                if ($clave === $user['clave']) {

                    $_SESSION['user_name'] = $user['nombre'];

                    // Redirigir según el rol
                    if ($user['rol'] === "rol_admin") {
                        header('Location: ../view/usuario.php');
                        exit();
                    } else if ($user['rol'] === "rol_usuario") {
                        header('Location: ../view/usuario.php');
                        exit();
                    }
                } else {
                    // Clave incorrecta
                    $this->contraseña_error = "<a style='color:red'>Contraseña incorrecta</a>";
                }
            } else {
                // Usuario no encontrado
                $this->usuario_error = "<a style='color:red'>Nombre de usuario no encontrado</a>";
            }
        } else {
            // Campos vacíos
            echo "Por favor, complete todos los campos.";
        }
    }
}
?>
