var button1 = document.getElementById("button1");
var button2_1 = document.getElementById("button2");
var contenedorAlert1 = document.getElementById("contenedor-alert");

// Mostrar el carrito
if (button1) {
  button1.addEventListener("click", function () {
    if (contenedorAlert1) {
      contenedorAlert1.style.visibility = "visible"; // Mostrar el contenedor del carrito
    }
  });
}

// Cerrar el carrito
if (button2_1) {
  button2_1.addEventListener("click", function () {
    if (contenedorAlert1) {
      contenedorAlert1.style.visibility = "hidden"; // Ocultar el contenedor del carrito
    }
  });
}

