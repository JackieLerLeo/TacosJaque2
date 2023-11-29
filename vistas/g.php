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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gráfico de Ventas por Período</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="../assets/css/barra.css">
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
    <div id="mostrarBarra">

    </div>
    <nav>
        <span id="menu-icon"></span>

    </nav>

    <form id="fechaForm">
        <label for="fechaInicio">Fecha Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio" required>

        <label for="fechaFinal">Fecha Final:</label>
        <input type="date" id="fechaFinal" name="fechaFinal" required>

        <button type="button" onclick="obtenerDatos()">Generar Gráfico</button>
    </form>

    <div id="columnchart_material"></div>

    <script type="text/javascript">
        function obtenerDatos() {
            var fechaInicio = $('#fechaInicio').val();
            var fechaFinal = $('#fechaFinal').val();

            // Realiza la petición AJAX al controlador
            $.ajax({
                url: '../controller/Admin/ctrlPanel.php?opc=5',
                type: 'POST',
                data: { fechaInicio: fechaInicio, fechaFinal: fechaFinal },
                dataType: 'json',
                success: function (data) {
                    // Llama a la función para dibujar el gráfico con los datos recibidos
                    dibujarGrafico(data);
                },
                error: function (error) {
                    console.error('Error en la petición AJAX:', error);
                }
            });
        }

        function dibujarGrafico(data) {
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(function () {
                var chartData = new google.visualization.DataTable();
                chartData.addColumn('string', 'Fecha');
                chartData.addColumn('number', 'Cantidad');

                for (var i = 0; i < data.length; i++) {
                    chartData.addRow([data[i].fecha, data[i].cantidad]);
                }

                var options = {
                    chart: {
                        title: 'Ventas por Período',
                        subtitle: 'Cantidad de Ventas por Fecha',
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
                chart.draw(chartData, options);
            });
        }

        // Toggle de la barra de navegación en dispositivos móviles
        document.getElementById('menu-icon').addEventListener('click', function () {
            var menuLinks = document.getElementById('menu-links');
            menuLinks.classList.toggle('active');
        });

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
        $(document).ready(function () {
carritoContador();
            barra();
carritoContador();
        });

    </script>


</body>

</html>