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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Carga de Producto</title>
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
        padding: 20px;
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
    }

    .container {
        max-width: 1200px;
        margin: 20px auto;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
    }

    input[type="submit"] {
        background-color: #DAA520;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #B8860B;
    }
    </style>
</head>

<body>
    <header>
        <h1>Formulario de Carga de Producto</h1>
    </header>

<div id="mostrarBarra" ></div>

    <div class="container">
        <form action="../controladores/ctrlSubirProductos.php" method="post" enctype="multipart/form-data">
            <label for="nombre_producto">Nombre del Producto:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <label for="imagen">Imagen del Producto:</label>
            <input type="file" id="imagen" name="foto" accept="image/*" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <input type="submit" value="Agregar Producto">
        </form>
    </div>
    <script>
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
    </script>
    <script>
    $(document).ready(function() {
        carritoContador();
        barra();
        carritoContador();



    });
    </script>
</body>

</html>