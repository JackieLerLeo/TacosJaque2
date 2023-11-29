<?php
require_once '../model/usuario.php';
require_once '../model/conexion.php';

// Comprobar si se recibió una solicitud POST para iniciar sesión
echo $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
    <link rel="icon" href="../assets/imagenes/Tacos.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
       <link rel="stylesheet" href="../assets/css/headerMenu.css">
    <link rel="stylesheet" href="../assets/css/iniciousuario.css">
    <link rel="stylesheet" href="../assets/js/styles.css">


</head>
<a href="../controller/Admin/g.html">graficas en admin</a>
<a href="../vistas/vistas2.html">aaa</a>
<body>


    <!-- En tu HTML -->

    <div id="mostrarBarra">
        <!---mostrar la barra-->
    </div>

    <div id="mostrar"></div>

    <!--SECCION DE TACOS-->
    <div id="mostrarProductos"></div>


    <section class="nosotros">
        <img class="bg-2" src="../assets/imagenes/bg.svg" alt="">
        <div class="nosotros-info container">
            <div class="nosotros-img">
                <img src="../assets/imagenes/image18.png" alt="">
            </div>
            <div class="nosotros-txt">
                <h2>Haz tu pedido</h2>
                <p>En nuestra página web podrás realizar pedidos en línea y disfrutar de nuestros tacos de guisado recién preparados en la comodidad de tu hogar o lugar de trabajo. Además, encontrarás información detallada sobre nuestros productos y servicios, así como las últimas promociones y novedades.</p>
                <a href="../vistas/carrito.php" class="btn-1">Realizar pedido aquí</a>
            </div>
        </div>
    </section>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../assets/js/styles.js"></script>
<script>
    $(document).ready(function() {
        ctrlMostrarP();
        carritoContador();
        barra();
        carritoContador();
    });

    function ctrlMostrarP() {
        $.ajax({
            url: '../controller/user/ctrlUser.php?opc=1',
            type: 'GET',
            success: function(response) {
                $('#mostrarProductos').html(response);
            },
            error: function() {
                // Maneja errores si la solicitud AJAX falla
                $('#mostrar').html('Error al cargar la barra de navegación');
            }
        });
    }

    function carritoContador() {
        $.ajax({
            url: '../controller/user/ctrlUser.php?opc=8',
            type: 'GET',
            success: function(response) {
                $('#contador-value').html(response);
            },
            error: function() {
                // Maneja errores si la solicitud AJAX falla
                $('#contador').html('Error al cargar la barra de navegación');
            }
        });
    }

    function barra() {
        $.ajax({
            url: '../controller/user/ctrlUser.php?opc=6',
            type: 'GET',
            success: function(response) {
                $('#mostrarBarra').html(response);
            },
            error: function() {
                // Maneja errores si la solicitud AJAX falla
                $('#mostrarBarra').html('Error al cargar la barra de navegación');
            }
        });
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
            success: function(response) {
                $('#mostrar').html(response);
                contador = 0;
                mostrarNotificacion('¡se agrego a carrito con éxito!', 'success');
            },
            error: function() {
                // Maneja errores si la solicitud AJAX falla
                $('#mostrar').html('Error al cargar la barra de navegación');
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

</html>