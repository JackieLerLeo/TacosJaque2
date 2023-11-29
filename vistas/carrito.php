<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    //  header('location: vistas2.php');
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
    <div id="mostrar"></div>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Incluye SweetAlert2 CSS y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
    }

    .cart {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 15px;
        text-align: left;
    }

    th {
        background-color: #DAA520;
        /* Color mostaza */
        color: white;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    button {
        background-color: #DAA520;
        /* Color mostaza */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
    }

    .cart-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div id="tbMensajes"></div>
    <div id="mostrarBarra"></div>
    <main class="products container">
        <h2></h2>
        <h2>Producto</h2>

        <div class="box">

        </div>

        <h2>Tacos</h2>
        <div id="mostrarCarro"></div>

    </main>
    <div id="total"></div>
    <div id="compra"></div>
    <script>
    $(document).ready(function() {
        recargarPagina();
        barra();
    });


    function barra() {
        $.ajax({
            url: '../controller/user/ctrlUser.php?opc=10',
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



    function recargarPagina() {
        $.ajax({
            type: "GET",
            url: "../controller/user/ctrlUser.php?opc=3",
            data: {},
            success: function(data) {
                $('#mostrarCarro').html(data);
            }
        });
    }

    function mostrarTotal() {
        $.ajax({
            type: "GET",
            url: "../controller/user/ctrlUser.php?opc=3",
            data: {},
            success: function(data) {
                $('#total').html(data);
            }
        });
    }

    function borrarDeCarrito(id_producto) {
        $.ajax({
            type: "POST",
            url: "../controller/user/ctrlUser.php?opc=4",
            data: {
                id_producto: id_producto
            },
            success: function(data) {
                $('#tbMensajes').html(data); // Actualiza la tabla del carrito
                mostrarNotificacion('elemento eliminado', 'success');

            }
        });
        recargarPagina();

    }

    function comprarCarrito() {
    // Muestra la alerta de "Por favor, espere..."
    mostrarAlertaEspera();

    // Agrega al carrito
    $.ajax({
        type: "POST",
        url: "../controller/user/ctrlUser.php?opc=5",
        data: {},
        success: function(data) {
            // Actualiza la tabla del carrito
            $('#sas').html(data);
            
            // Cierra la alerta de espera y muestra la alerta de éxito
            cerrarAlertaEspera();
            mostrarAlertaExito();
        },
        error: function() {
            // En caso de error, cierra la alerta de espera y muestra una alerta de error
            cerrarAlertaEspera();
            mostrarAlertaError();
        }
    });
}

function mostrarAlertaEspera() {
    Swal.fire({
        title: 'Por favor, espere...',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });
}

function cerrarAlertaEspera() {
    Swal.close();
}

function mostrarAlertaExito() {
    Swal.fire({
        icon: 'success',
        title: '¡Compra completada!',
        text: 'Gracias por tu compra',
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        // Puedes agregar más lógica aquí después de que el usuario hace clic en Aceptar
        if (result.isConfirmed) {
            recargarPagina();
        }
    });
}

function mostrarAlertaError() {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Hubo un problema al realizar la compra. Por favor, inténtalo nuevamente.',
        confirmButtonText: 'Aceptar'
    });
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

</body>

</html>