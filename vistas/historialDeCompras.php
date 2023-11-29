<?php
session_start();
if (isset($_SESSION["id_usuario"] )) {
    //header('location: vistas2.php');
    // You may want to remove this echo statement unless it's for debugging purposes
    // echo "sesion" . $_SESSION['id_usuario'];
} else {
    //echo "Sesión no iniciada";
    header('location: Login.php');

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="mostrarBarra"></div>
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



    <script>
        function cargarBarraDeNavegacion() {
            $.ajax({
                url: '../controller/pdf/ctrlPDF.php?opc=1',
                type: 'GET',
                success: function (response) {
                    $('#barra-navegacion-container').html(response);
                },
                error: function () {
                    // Maneja errores si la solicitud AJAX falla
                    $('#barra-navegacion-container').html('Error al cargar la barra de navegación');
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
                    $('#contador').html('Error al cargar la barra de navegación');
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
                    $('#mostrarBarra').html('Error al cargar la barra de navegación');
                }
            });
        }



        function imprimir() {
            // Agrega al carrito
            $.ajax({
                type: "POST",
                url: "../controller/pdf/ctrlPDF.php?opc=2",
                data: {},
                success: function (data) {
                    $('#compra').html(data); // Actualiza la tabla del carrito
                },
            });
        }
    </script>
</head>

<body>
    <div id="barra-navegacion-container"></div>
    <div id=""></div>
</body>

</html>


<script>
    $(document).ready(function () {
        carritoContador();
        // Realiza una solicitud AJAX para obtener el valor de id_rol desde PHP
        cargarBarraDeNavegacion();
        barra();
        carritoContador();



    });
</script>