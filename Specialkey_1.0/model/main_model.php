<?php

require_once dirname(__DIR__) . '/config/SERVER.php';





/*--------- Funcion login ---------*/




class mainModel
{


	public static function conectar()
	{
		try {
			$conexion = new PDO(SGBD, USER, PASS);
			$conexion->exec("SET CHARACTER SET utf8");
			return $conexion;
		} catch (PDOException $e) {
			die("Error: " . $e->getMessage());
		}
	}

	public static function ejecutar_consulta_simple($consulta)
	{
		$sql = self::conectar()->prepare($consulta);
		$sql->execute();
		return $sql;
	}

	public static function iniciar_sesion_modelo($datos)
	{
		$sql = self::conectar()->prepare("SELECT * FROM usuario WHERE nombre = :Usuario ");
		$sql->bindParam(":Usuario", $datos['Usuario']);
		$sql->execute();
		return $sql;
	}



	/*--------- Funciones registrar usuarios---------*/



	protected static function register_modelo($datos)
	{
		$sql = self::conectar()->prepare("INSERT INTO `usuario` (`ROL`, `NOMBRE`, `TP`, `CC`, `CORREO`, `CLAVE`) VALUES (:Rol, :Usuario, :Documento, :Id, :Correo, :Clave)");
		$sql->bindParam(":Usuario", $datos['Usuario']);
		$sql->bindParam(":Clave", $datos['Clave']);
		$sql->bindParam(":Correo", $datos['Correo']);
		$sql->bindParam(":Documento", $datos['Documento']);
		$sql->bindParam(":Id", $datos['Id']);
		$sql->bindParam(":Rol", $datos['Rol']);
		$sql->execute();
		return $sql;
	}

	protected static function validar_usuario_Existente($datos)
	{
		//verifica correo
		$sql = self::conectar()->prepare('SELECT COUNT(*) as length FROM usuario WHERE CORREO = :Correo');
		$sql->bindParam(":Correo", $datos['Correo']);
		$sql->execute();
		$correo_resultado = $sql->fetch();

		//verificar usuario
		$sql = self::conectar()->prepare('SELECT COUNT(*) as length FROM usuario WHERE NOMBRE = :Usuario');
		$sql->bindParam(":Usuario", $datos['Usuario']);
		$sql->execute();
		$usuario_resultado = $sql->fetch();
		// verificar cc
		$sql = self::conectar()->prepare('SELECT COUNT(*) as length FROM usuario WHERE CC = :Id');
		$sql->bindParam(":Id", $datos['Id']);
		$sql->execute();
		$documento_resultado = $sql->fetch();

		return [
			'Correo' => $correo_resultado['length'],
			'Usuario' => $usuario_resultado['length'],
			'Id' => $documento_resultado['length'],
		];
	}

	/*--------- Funciones registrar productos ---------*/

	public static function register_producto_modelo($datos)
	{
		
			$sql = self::conectar()->prepare("INSERT INTO `productos` (`nombre`, `imagen`, `descripcion`, `precio`, `id_categoria`, `activo`) VALUES (:nombre_producto, :imagen, :descripcion, :precio, :id_categoria, :activo)");
			
			$sql->bindParam(":nombre_producto", $datos['nombre_producto']);
			$sql->bindParam(":imagen", $datos['imagen'], PDO::PARAM_LOB);
			$sql->bindParam(":descripcion", $datos['descripcion']);
			$sql->bindParam(":precio", $datos['precio']);
			$sql->bindParam(":id_categoria", $datos['categoria']);
			$sql->bindParam(":activo", $datos['activo']);
			
		$sql->execute();
	}

	public static function validar_producto_existente($datos)
	{
		//verifica nombre  de producto
		$sql = self::conectar()->prepare('SELECT COUNT(*) as length FROM productos WHERE nombre = :nombre_producto');
		$sql->bindParam(":nombre_producto", $datos['nombre_producto']);
		$sql->execute();
		$nombre_producto = $sql->fetch();


		return [
			'nombre' => $nombre_producto['length'],
		];
	}

	/*--------- Funcion crear tabla de usuarios---------*/

	protected static function tabla()
	{

		//seleccionar los datos de cada usuario
		$sql = self::conectar()->prepare("SELECT ID,NOMBRE,ROL,CLAVE FROM usuario");
		$sql->execute();
		return $sql->fetchAll();
	}

	/*--------- Funcion crear tabla de produtos---------*/

	protected static function tabla_productos()
	{

		//seleccionar los datos de cada produto
		$sql = self::conectar()->prepare("SELECT ID,NOMBRE,imagen,descripcion,precio,id_categoria,activo FROM productos");
		$sql->execute();
		return $sql->fetchAll();
	}



	/*--------- Funcion editar tabla ---------*/

	// Selecciona los datos del usuario a editar
	protected static function editarTabla($id)
	{
		$sql = self::conectar()->prepare("SELECT ID, NOMBRE,ROL,CLAVE FROM usuario WHERE ID = ?");
		$sql->execute([$id]);  // Pasa el ID del usuario a la consulta
		return $sql->fetch();
	}

	// Actualiza los datos del usuario
	protected static function actualizarTabla($nombre, $clave, $id,$rol)
	{
		$actualizacion = self::conectar()->prepare("UPDATE usuario SET NOMBRE = ?,ROL = ? , CLAVE = ? WHERE ID = ?");
		return $actualizacion->execute([$nombre,$rol, $clave, $id]);  // Ejecuta la actualización con los valores
	}

	//eliminar un usuario
	protected static function eliminarTabla($id)
	{
		$eliminacion = self::conectar()->prepare("DELETE FROM usuario WHERE ID = ?");
		return $eliminacion->execute([$id]);
	}
	//eliminar un producto
	protected static function eliminarTabla_producto($id)
	{
		$eliminacion = self::conectar()->prepare("DELETE FROM productos WHERE ID = ?");
		return $eliminacion->execute([$id]);
	}





	/*--------- Funcion para agregar un producto a carrito  ---------*/


	public function agregar_carrito($datos)
	{
		// Verifica si el producto ya existe en el carrito para ese comprador
		$sql = self::conectar()->prepare('SELECT cantidad,precio FROM carrito WHERE producto = :producto AND comprador = :comprador');
		$sql->bindParam(":producto", $datos['producto']);
		$sql->bindParam(":comprador", $datos['comprador']);
		$sql->execute();
		$resultado = $sql->fetch(PDO::FETCH_ASSOC);


		if ($resultado['cantidad']) {
			$cantidad_actual = $resultado['cantidad'];
			$precio_actual = $resultado['precio'];
	
		   
			$precio_unitario = $precio_actual / $cantidad_actual;	
			// Si el producto ya existe, incrementa la cantidad
			$sql = self::conectar()->prepare('UPDATE carrito SET cantidad = cantidad + 1,precio=precio+:precio_unitario WHERE producto = :producto AND comprador = :comprador');
			$sql->bindParam(":precio_unitario", $precio_unitario);
			$sql->bindParam(":producto", $datos['producto']);
			$sql->bindParam(":comprador", $datos['comprador']);
			$sql->execute();
		} else {
			// Si no existe, inserta el producto como nuevo en el carrito
			$sql = self::conectar()->prepare("INSERT INTO `carrito` (`producto`, `precio`, `comprador`, `cantidad`) VALUES (:producto, :precio, :comprador, 1)");
			$sql->bindParam(":producto", $datos['producto']);
			$sql->bindParam(":precio", $datos['precio']);
			$sql->bindParam(":comprador", $datos['comprador']);
			$sql->execute();
		}

		return $sql;
	}



	////////////////////////////////////////////////////////////////////////////////////////////
	public function items_carrito()
	{
		$db = self::conectar();
		if (isset($_SESSION['user_name'])) {
			$user = $_SESSION['user_name'];
			$sql = $db->prepare("SELECT * FROM carrito  where comprador = :user");
			$sql->bindParam(':user', $user, PDO::PARAM_STR);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}
	}
	


	public function agregar_item_carrito($nombre_producto)
{
	if (isset($_SESSION['user_name'])){$user = $_SESSION['user_name'];}
    

    // Comprobar si el producto ya existe en el carrito
    $sql = self::conectar()->prepare("SELECT cantidad, precio FROM carrito WHERE comprador = :user AND producto = :nombre_producto");
    $sql->bindParam(':user', $user, PDO::PARAM_STR);
    $sql->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
    $sql->execute();

    $resultado_producto = $sql->fetch(PDO::FETCH_ASSOC);

    if ($resultado_producto) {
        // Obtener la cantidad y precio actual del producto
        $cantidad_actual = $resultado_producto['cantidad'];
        $precio_actual = $resultado_producto['precio'];

       
        $precio_unitario = $precio_actual / $cantidad_actual;

        // Si el producto ya existe, actualiza la cantidad y el precio
        $sql = self::conectar()->prepare("UPDATE carrito SET cantidad = cantidad + 1, precio = precio + :precio_unitario WHERE comprador = :user AND producto = :nombre_producto");
        $sql->bindParam(':precio_unitario', $precio_unitario, PDO::PARAM_STR);
        $sql->bindParam(':user', $user, PDO::PARAM_STR);
        $sql->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
        $sql->execute();
    } else {
        // Si el producto no existe, inserta un nuevo producto con cantidad 1
        $sql =self::conectar()->prepare("INSERT INTO carrito (comprador, producto, cantidad, precio) VALUES (:user, :nombre_producto, 1, (SELECT precio FROM productos WHERE nombre = :nombre_producto))");
        $sql->bindParam(':user', $user, PDO::PARAM_STR);
        $sql->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
        $sql->execute();
    }
}

public function sumar($nombre_producto)
{
	if (isset($_SESSION['user_name'])){$user = $_SESSION['user_name'];}
    

    // Primero, obtenemos el precio unitario
    $sql = self::conectar()->prepare("SELECT cantidad, precio FROM carrito WHERE comprador = :user AND producto = :nombre_producto");
    $sql->bindParam(':user', $user, PDO::PARAM_STR);
    $sql->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
    $sql->execute();
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $cantidad_actual = $resultado['cantidad'];
        $precio_actual = $resultado['precio'];
        $precio_unitario = $precio_actual / $cantidad_actual;

        // Ahora actualizamos la cantidad y el precio
        $sql = self::conectar()->prepare("UPDATE carrito SET cantidad = cantidad + 1, precio = precio + :precio_unitario WHERE comprador = :user AND producto = :nombre_producto");
        $sql->bindParam(':precio_unitario', $precio_unitario, PDO::PARAM_STR);
        $sql->bindParam(':user', $user, PDO::PARAM_STR);
        $sql->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
        $sql->execute();
    }
}


	public function restar($nombre_producto)
	{
		if (isset($_SESSION['user_name'])){$user = $_SESSION['user_name'];}
		

		// Obtenemos la cantidad actual del producto
		$sql = self::conectar()->prepare("SELECT cantidad,precio FROM carrito WHERE comprador = :user AND producto = :nombre_producto");
		$sql->bindParam(':user', $user, PDO::PARAM_STR);
		$sql->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
		$sql->execute();
		$resultado = $sql->fetch(PDO::FETCH_ASSOC);

		if ($resultado['cantidad']>1) {
			
			$cantidad_actual = $resultado['cantidad'];
            $precio_actual = $resultado['precio'];
            $precio_unitario = $precio_actual / $cantidad_actual;


			// Si la cantidad es mayor a 1, restamos 1
			
				$sql = self::conectar()->prepare("UPDATE carrito SET cantidad = cantidad - 1, precio=precio-:precio_unitario WHERE comprador = :user AND producto = :nombre_producto");
				$sql->bindParam(':precio_unitario', $precio_unitario, PDO::PARAM_STR);
				$sql->bindParam(':user', $user, PDO::PARAM_STR);
				$sql->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
				$sql->execute();
			} else {
				// Si la cantidad llega a 1, eliminamos el producto
				$sql = self::conectar()->prepare("DELETE FROM carrito WHERE comprador = :user AND producto = :nombre_producto");
				$sql->bindParam(':user', $user, PDO::PARAM_STR);
				$sql->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
				$sql->execute();
			}
		}
		//total de el precio de los productos seleccionados
		public function total(){
			if (isset($_SESSION['user_name'])){$user = $_SESSION['user_name'];}
		$sql=self::conectar()->prepare("SELECT SUM(precio) AS total FROM carrito WHERE comprador=:user");
		$sql->bindParam(':user', $user, PDO::PARAM_STR);
		$sql->execute();
		$resultado = $sql->fetch(PDO::FETCH_ASSOC); // Obtiene el resultado como un array asociativo
         return $resultado['total']; // Devuelve el total de la suma
		}
}

