<?php
include("../controladores/ctrlMostrarTodo.php");
include("../controladores/ctrlStatus.php");
session_start();
if (isset($_SESSION["id_usuario"])) {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/editar.css">
    <title>Editar Productos</title>
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
        color: #333;
        /* Color del texto en la barra de navegación */
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
        color: #333;
        /* Color del texto en la tabla */
    }

    th {
        background-color: #DAA520;
        color: #333;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    button {
        background-color: #DAA520;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
    }

    button:hover {
        background-color: #B8860B;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="mostrarBarra"></div>
</head>

<body>
    <header>
        <h1>Editar Productos</h1>
    </header>



    <main class="products container">
        <h2>Editar Productos</h2>
        <?php foreach ($productos as $producto) { ?>
        <form method="post"
            action="../controladores/ctrlmodificarproducto.php?id=<?php echo $producto['id_producto']; ?>"
            enctype="multipart/form-data">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Estatus</th>
                        <th>Nueva Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $producto['id_producto']; ?></td>
                        <td><img src="../assets/img/<?php echo $producto['foto']; ?>"
                                alt="<?php echo $producto['nombre_producto']; ?>"></td>
                        <td><input type="text" name="nombre_producto"
                                value="<?php echo $producto['nombre_producto']; ?>"></td>
                        <td><input type="text" name="stock" value="<?php echo $producto['stock']; ?>"></td>
                        <td><input type="text" name="precio" value="<?php echo $producto['precio']; ?>"></td>
                        <td>
                            <p><?php echo $producto['status']; ?></p>
                            <select name="status" id="status">
                                <?php foreach ($status as $s) : ?>
                                <option value="<?php echo $s['id_status']; ?>"><?php echo $s['status']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="file" name="foto">
                            <?php if (empty($_FILES['foto']['name'])) : ?>
                            <input type="text" value="<?php echo $producto['foto']; ?>" readonly>
                            <?php endif; ?>
                        </td>
                        <td> <button type="submit">Guardar Cambios</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <?php } ?>
    </main>
</body>

</html>
<script>
function cargarBarraDeNavegacion() {
    $.ajax({
        url: '../controller/pdf/ctrlPDF.php?opc=1',
        type: 'GET',
        success: function(response) {
            $('#barra-navegacion-container').html(response);
        },
        error: function() {
            // Maneja errores si la solicitud AJAX falla
            $('#barra-navegacion-container').html('Error al cargar la barra de navegación');
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
    // Realiza una solicitud AJAX para obtener el valor de id_rol desde PHP
    cargarBarraDeNavegacion();
    barra();
    carritoContador();



});
</script>