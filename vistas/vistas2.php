<?php

session_start();
if (isset($_SESSION["id_usuario"] )) {
    // You may want to remove this echo statement unless it's for debugging purposes
    // echo "sesion" . $_SESSION['id_usuario'];
} else {
    //echo "Sesión no iniciada";
    header('location: Login.php');

}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Página de Productos</title>


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        nav {
            background-color: #DAA520;
            /* Color mostaza */
            padding: 20px;
            /* Doble grosor de la barra de navegación */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        nav img {
            max-height: 40px;
            /* Ajusta la altura del logo según sea necesario */
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product-card {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            transition: transform 0.3s;
            flex: 0 0 calc(30% - 40px);
            box-sizing: border-box;
            position: relative;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-image {
            max-width: 100%;
            height: auto;
        }

        .product-info {
            margin-top: 20px;
        }

        .stock {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .stock button {
            background-color: #DAA520;
            /* Cambiado a color mostaza */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            margin: 0 5px;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .stock button:hover {
            background-color: #B8860B;
            /* Color más oscuro al pasar el ratón */
        }

        .stock span {
            font-size: 18px;
        }

        .stock-label {
            margin-right: 10px;
        }

        .add-to-cart {
            background-color: #DAA520;
            /* Cambiado a color mostaza */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .add-to-cart:hover {
            background-color: #B8860B;
            /* Color más oscuro al pasar el ratón */
        }

        .btn-danger {
            background-color: #DC3545;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            /* Para centrar el botón */
            margin: 0 auto;
            /* Para centrar el botón */
        }

        @media (max-width: 767px) {
            .product-card {
                flex-basis: calc(50% - 40px);
            }

            nav {
                text-align: center;
                flex-direction: column;
            }

            nav a {
                display: block;
                margin: 10px 0;
            }
        }
    </style>




</head>

<body>

    <div id="mostrarBarra"></div>


    <!--SECCION DE TACOS-->
    <div id="mostrarProductos"></div>


    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../assets/js/styles.js"></script>
    <script>
        $(document).ready(function () {
            ctrlMostrarP();
            carritoContador();
            barra();
            carritoContador();
        });

        function ctrlMostrarP() {
            $.ajax({
                url: '../controller/user/ctrlUser.php?opc=9',
                type: 'GET',
                success: function (response) {
                    $('#mostrarProductos').html(response);
                },
                error: function () {
                    // Maneja errores si la solicitud AJAX falla
                    $('#mostrar').html('Error al cargar la barra de navegación');
                }
            });
        }

        function carritoContador() {
            $.ajax({
                url: '../controller/user/ctrlUser.php?opc=8',
                type: 'GET',
                success: function (response) {
                    $('#contador-value').html(response);
                },
                error: function () {
                    // Maneja errores si la solicitud AJAX falla
                    $('#contador').html('Error al Mostrar los productos');
                }
            });
        }

function barra() {
    $.ajax({
        url: '../controller/user/ctrlUser.php?opc=10',
        type: 'GET',
        success: function (response) {
            $('#mostrarBarra').html(response);
        },
        error: function () {
            // Maneja errores si la solicitud AJAX falla
          //  redirigirAVentana("login.html");
        }
    });
}

function redirigirAVentana(url) {
    window.location.href = url;
}

    </script>
    <script>
        // Variable para almacenar el contador
        let contador = 0;

        function aumentarContador(idProducto) {
            var contador = document.getElementById('contador-' + idProducto);
            var valorActual = parseInt(contador.textContent);
            contador.textContent = valorActual + 1;
            actualizarURLCarrito(idProducto, valorActual + 1);
        }

        function disminuirContador(idProducto) {
            var contador = document.getElementById('contador-' + idProducto);
            var valorActual = parseInt(contador.textContent);
            if (valorActual > 0) {
                contador.textContent = valorActual - 1;
                actualizarURLCarrito(idProducto, valorActual - 1);
            }
        }

        function actualizarURLCarrito(idProducto, cantidad) {
            var link = document.getElementById('add-to-cart-link-' + idProducto);
            //  link.href = `../controller/user/ctrlUser.php?opc=2&id=${idProducto}&cantidad=${cantidad}`;
            contador = cantidad;
            console.log("contador= " + contador);

        }

        function actualizarCarrito(id_producto, cantidad) {
            ctrlMostrarP();
            carritoContador();
            cantidad = contador;
            console.log("cantidad".cantidad);
            $.ajax({
                url: `../controller/user/ctrlUser.php?opc=2&id_producto=${id_producto}&contador=${contador}`,
                type: 'GET',
                success: function (response) {
                    $('#mostrar').html(response);
                    contador = 0;
                    mostrarNotificacion('¡se agrego a carrito con éxito!', 'success');
                },
                error: function () {
                    // Maneja errores si la solicitud AJAX falla
                    $('#mostrar').html('Error al actualizar al carrito');
                }
            });
            ctrlMostrarP();
            carritoContador();
        }

        function mostrarNotificacion(mensaje, tipo) {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000, // Duración de la notificación en milisegundos
            };

            if (tipo === 'success') {
                toastr.success(mensaje);
            } else if (tipo === 'error') {
                toastr.error(mensaje);
            } else if (tipo === 'warning') {
                toastr.warning(mensaje);
            } else if (tipo === 'info') {
                toastr.info(mensaje);
            }
        }
    </script>
    <script>
        // Funciones para aumentar o disminuir el stock
        function increaseStock() {
            var stockElement = document.getElementById('stock');
            var currentStock = parseInt(stockElement.innerText);
            stockElement.innerText = currentStock + 1;
        }

        function decreaseStock() {
            var stockElement = document.getElementById('stock');
            var currentStock = parseInt(stockElement.innerText);
            if (currentStock > 0) {
                stockElement.innerText = currentStock - 1;
            }
        }
    </script>
</body>

</html>