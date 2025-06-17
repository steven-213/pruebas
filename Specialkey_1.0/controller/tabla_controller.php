<?php
require "../model/main_model.php";


session_start();
class TablaControlador extends mainModel
{

    public function __construct()
    {
        
        if (!isset($_SESSION['user_name'])) {
            echo "Acceso denegado. Por favor, inicie sesión.";
            exit(); 
        }
    }


    public function Register_controlador()
    {
        $resultado = self::tabla();
        foreach ($resultado as $dato) {

                    echo '<tr data-id="' . $dato['ID'] . '">' .
                    '<th>' . $dato['ID'] . '</th>' .
                    '<th>' . $dato['NOMBRE'] . '</th>' .
                    '<th>' . $dato['ROL'] . '</th>' .
                    '<th>' . $dato['CLAVE'] . '</th>';
                    if($dato['NOMBRE']!=='steven'){
                        echo
                    '<th><button class="button" onclick="location.href=\'modificar.php?id=' . $dato['ID'] . '\'">MODIFICAR</button></th>' .
                    '<th id="eliminar"><button onclick="location.href=\'eliminar.php?id=' . $dato['ID'] . '\'">X</button></th>' .
                '</tr>';
                }
                else{
                    echo '<th> no disponible</th>';
                    echo '<th> no disponible</th></tr>';
                }
            }
        }
    
    
    
    

    public function Editar_controlador($id)
    {
        // Obtener los datos del usuario que se va a editar
        $dato = self::editarTabla($id);
        return $dato;
    }

    // Controlador para actualizar usuario
    public function Actualizar_controlador($id, $nombre,$rol, $clave)
    {
        // Obtener los datos actuales del usuario
        $usuario_actual = self::editarTabla($id);
    
        // Si la contraseña está vacía, conserva la existente
        if (empty($clave)) {
            $clave = $usuario_actual['CLAVE'];

        }
        // Llama al método para actualizar los datos
        if (self::actualizarTabla($nombre, $clave, $id,$rol)) {
            echo "Datos actualizados exitosamente.";
        } else {
            echo "Error al actualizar los datos.";
        }
        // Redirigir para evitar resubmissions del formulario
        header("Location: base de datos.php");
        exit();
        
    
}


public function Eliminar_controlador($id) {
    return self::eliminarTabla($id); // Llama al método en el modelo
}


public function Eliminar_producto_controlador($id) {
    return self::eliminarTabla_producto($id); // Llama al método en el modelo
}


public function productos_controller(){
    $resultado = self::tabla_productos();
        foreach ($resultado as $dato) {
            echo  '<tr data-id="'. $dato['ID'] . '">'.
            '<th>' . $dato['ID'] . '</th>
        <th>' . $dato['NOMBRE'] . '</th>
        <th>'; 
        if (!empty($dato['imagen'])) {
            // Mostrar la imagen desde la base de datos
            echo '<img class="imagen_producto" src="data:image/jpeg;base64,' . base64_encode($dato['imagen']) . '" alt="Imagen del producto" />';
        } else {
            // Mostrar imagen por defecto
            echo '<img class="imagen_producto" src="view/imagenes/error.png" alt="Imagen por defecto" />';
        }
         echo '</th>
        <th>' . $dato['descripcion'] . '</th>
        <th>' . $dato['precio'] . '</th>
        <th>' . $dato['id_categoria'] . '</th>
        <th>' . $dato['activo'] . '</th>
        <th><button class="button" onclick="location.href=\'modificar.php?id=' . $dato['ID'] . '\'">MODIFICAR</button></th>
        <th id="eliminar"><button onclick="location.href=\'eliminar_producto.php?id='.$dato['ID'].'\'">X</button></th>
    </tr>';
    
        }
    }
    

}
?>