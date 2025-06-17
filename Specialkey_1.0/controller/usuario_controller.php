<?php

require_once dirname(__DIR__) . '/model/main_model.php';

session_start();
class UsuarioControlador extends mainModel
{
	

	public function productos()
	{
		$db = self::conectar();
		$sql = $db->prepare("SELECT * FROM productos  where activo = 1");
		$sql->execute();
		$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);



		return $resultado;
	}

	///////////// cuando el usuario este registrado , lo va a mandar a usuario.php envez de a register.php///////////////
	public function usuario_conectado1()
	{

		if (isset($_SESSION['user_name'])) {
			return true;
		} else {
			return false;
		}
	}

	//agragar a base de datos los items que el usuario elige //////////////
	public function carrito($id)
	{
		$resultado = self::productos();

		foreach ($resultado as $dato) {
			if ($dato['id'] == $id) {
				$datos = [
					'producto' => $dato['nombre'],
					'precio' => $dato['precio'],
					'comprador' => $_SESSION['user_name'],
				];

				self::agregar_carrito($datos);
			}
		}
	}

	// agregar a carrito los items que el usuarios elige //////////////


	public function controller_itemCarrito($nombre_producto)
	{
		if (self::usuario_conectado1()) {
			self::items_carrito();
			self::agregar_item_carrito($nombre_producto);
		}
	}
	//para sumar o restar el producto dependiendo de la peticion del cliente 
	public function controller_sumar($nombre_producto)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
			$accion = $_POST['accion'];
			$nombre_producto = $_POST['nombre_producto'];
			if ($accion == 'incrementar') {
				self::sumar($nombre_producto);
			}
			if ($accion == 'restar') {
				self::restar($nombre_producto);
			}
		}
	}

	//calcular el valor total de los productos de el carrito 


	public function controller_total()
	{
		$total = self::total();
		return $total;

	}
	// para agregar al pdf recibo 
	public function controller_recibo() {
		// Obtener los productos del carrito
		$productos = self::items_carrito();
		
		foreach ($productos as $producto) {
			$datos[] = [
				'nombre_producto' => $producto['producto'],  
				'precio' => $producto['precio'],              
				'cantidad' => $producto['cantidad']           
			];
		}
	
		return $datos;  // Devuelve los datos listados
	}
	

	 }











