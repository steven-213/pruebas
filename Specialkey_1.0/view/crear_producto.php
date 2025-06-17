<?php

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require "../controller/register_controller.php";
    $ins_login = new RegisterControlador();
    $ins_login->register_productos_controller();
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crear usuario</title>
    <link rel="stylesheet" href="style/style_modificar.css">
    
</head>
<body>
    <h1>Modificar Datos</h1>
    <form method="post" enctype="multipart/form-data" ><!--atributo necesario para enviar archivos correctamente-->
          <div>
            Nombre: 
            <input type="text" name="nombre_producto" required>
            <?php if (isset($ins_login->usuario_error)) {
              echo $ins_login->usuario_error;
            } ?>
          </div>
          <div>
            imagen:
            <input type="file" name="imagen" accept="image/*" ><!--acepta solo archivos formato imagen-->
          </div>
          <div>
            <label>descripcion</label>
             <input type="text" name="descripcion">
          </div>
          <div>
            precio:
            <input name="precio" type="number" step="0.001"  id="precio" minlength="2" maxlength="8" required>
            <?php if (isset($ins_login->cc_error)) {
              echo $ins_login-> cc_error;
            } ?>
          </div>
          <div>
            <label>id_categoria</label>
            <select name="categoria">
            <option value="1">1</option>
              <option value="0">0</option>
        
            </select>
          
          </div>
     <div>
            <label>activo</label>
            <select name="activo">
            <option value="1">1</option>
              <option value="0">0</option>
        
            </select>
          
        
        <button type="submit">crear</button>
    <?php include "../view/assets/adicional/footer.php"; ?>
</body>
</html>
