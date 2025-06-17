<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
	require "../model/main_model.php";
    session_start();
	class RegisterControlador extends mainModel {
        

        public $correo_error;
        public $usuario_error;
        public $cc_error;
        

    public function Register_controlador() {
        if (isset($_POST['usuario_log']) && isset($_POST['clave_log'])) {
            // Obtener datos del formulario
            $usuario = $_POST['usuario_log'];
            $clave = $_POST['clave_log'];
			$correo = isset($_REQUEST['correo_host']) ? $_REQUEST['correo_host'] : null;
			$documento = isset($_REQUEST['documento_host']) ? $_REQUEST['documento_host'] : null;
			$id = isset($_REQUEST['id_host']) ? $_REQUEST['id_host'] : null;
			$rol=isset($_REQUEST['Rol_host']) ? $_REQUEST['Rol_host'] : 'rol_usuario';
        

            // Preparar datos para el modelo
            $datos = [
                'Usuario' => $usuario,
                'Clave' => $clave,  //
                'Correo' => $correo,
                'Documento' => $documento,
                'Id' => $id,
                'Rol' => $rol
            ];

            //---------------------
    $resultado = self::validar_usuario_Existente($datos);
    if ((int) $resultado['Correo'] > 0) {

        $this->correo_error = "<a style='color:red'>Correo ya existe</a>";
    }
    elseif ((int) $resultado['Usuario'] > 0){
        $this->usuario_error = "<a style='color:red'>Usuario ya existe</a>";

    }elseif ((int) $resultado['Id'] > 0){
        $this->cc_error = "<a style='color:red'>Documento ya existe</a>";

    }
    else{
        self::register_modelo($datos);
         if(isset($_POST['crear_usuario']) && $_POST['crear_usuario']=='register'){
        include '../view/assets/adicional/alerta.php' ;
    }
    if(isset($_POST['crear_usuario']) && $_POST['crear_usuario']=='crear_user'){
        header('Location: base%20de%20datos.php');
    }
}}}





    public function register_productos_controller() {
        $nombre = $_POST['nombre_producto'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $activo = $_POST['activo'];
       
    
        // Verificar si se envió una imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Obtener información del archivo
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            
         
                // Leer el contenido del archivo como binario
                $imagenBinaria = file_get_contents($fileTmpPath);
                $imagenBase64 = base64_encode($imagenBinaria);
                
                // Verificar el contenido de la imagen
   
        
        $datos = [
            'nombre_producto' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'categoria' => $categoria,
            'activo' => $activo,
            'imagen' => $imagenBase64
        ];
        $resultado = self::validar_producto_existente($datos);
       if ((int) $resultado['nombre'] > 0){
            $this->usuario_error = "<a style='color:red'>Usuario ya existe</a>";
       }
       else {
        self::register_producto_modelo($datos);
    }
    


    }}}
    
?>
