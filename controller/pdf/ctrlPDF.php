<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Autoloader;

require_once '../../model/historialCompra.php';
require_once("../../vendor/autoload.php");
require_once '../../adodb5/adodb.inc.php';
require_once '../../model/imprimirPDF.php';
require_once '../../model/conexion.php';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$imprimir = new imprimirPDF($_SESSION["id_usuario"]);

$dompdf = new Dompdf($options);
// Devuelve el contenido como respuesta
//echo $content;
$mostrarVenta = new historialCompras();

if (isset($_GET['opc'])) {
    $opc = $_GET['opc'];
    //echo ($opc);
    switch ($opc) {
        case '1': ///mostrar historial de compras
            if (isset($_SESSION["id_usuario"])) {
                $venta = $mostrarVenta->MostrarCompras($_SESSION["id_usuario"]);
        
                echo '
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
        
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }
        
                        th, td {
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
                    </style>
        
                    <div class="container">
                        <h2>Historial de Compras</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Folio</th>
                                    <th>Usuario</th>
                                    <th>Enlace al PDF</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($venta as $curso) {
                    echo '
                                <tr>
                                    <td>' . $curso['fecha'] . '</td>
                                    <td>' . $curso['id_venta'] . '</td>
                                    <td>' . $curso['nombre'] . ' ' . $curso['primer_apellido'] . ' ' . $curso['segundo_apellido'] . '</td>
                                    <td><a href="../controller/pdf/ctrlPDF.php?opc=2&id_venta=' . $curso['id_venta'] . '&fecha=' . $curso['fecha'] . '" target="_blank">PDF</a></td>
                                </tr>';
                }
                echo '
                            </tbody>
                        </table>
                    </div>';
            } else {
                echo "El usuario no está definido";
            }
            break;
        
        case '2': //imprimir pdf
            $id_venta = isset($_GET['id_venta']) && isset($_GET['fecha']) ? $_GET['id_venta'] : NULL;
            $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : NULL;

            $fecha = $_GET['fecha'];
            echo $fecha . "  " . $_SESSION["id_usuario"] . " " . $id_venta;

            $imprimir->crearPDF($_SESSION["id_usuario"], $fecha);
            exit;
    }
}