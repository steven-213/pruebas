<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../view/assets/adicional/alerta.css">
</head>

<body>
    <div id="alert">
        <div>
            <h1>GRACIAS POR REGISTRARTE</h1>
            <h3>¡Ya puedes iniciar sesión!</h3>
        </div>
        <div>
            <button id="cerrar">Salir</button>
            <button onclick="window.location.href='login.php'">Iniciar sesión</button>
        </div>
        <div>
            <img src="../view/assets/adicional/oso.gif" alt="Oso animado">
        </div>
    </div>
</body>

</html>
<script>
        var alert = document.getElementById("alert");
        function cerrar() {
            alert.style.visibility = "hidden";
        }
        document.getElementById("cerrar").addEventListener("click", cerrar);
        ;
    </script>
</html>