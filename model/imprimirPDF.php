<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Autoloader;

require_once "../../vendor/autoload.php";
require_once '../../model/historialCompra.php';
ob_start();

class imprimirPDF
{
    private $userId; // Asegúrate de obtener este ID de alguna manera
    private $db;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $con = new Conexion();
        $this->db = $con->conectar();
    }

    public function crearPDF($user, $fecha)
    {
        $mostrarVenta = new historialCompras();

        $venta = $mostrarVenta->MostrarICompras($user, $fecha);
        $dompdf = new Dompdf();
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Comprobante de Compras</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                .comprobante {
                    border: 1px solid #ccc;
                    padding: 20px;
                    max-width: 600px;
                    margin: 0 auto;
                }
                .titulo {
                    font-size: 24px;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 20px;
                }
                .info {
                    margin-bottom: 10px;
                }
                .detalles-compra {
                    border-collapse: collapse;
                    width: 100%;
                    margin-top: 20px;
                }
                .detalles-compra th, .detalles-compra td {
                    border: 1px solid #ccc;
                    padding: 8px;
                    text-align: left;
                }
                .detalles-compra th {
                    background-color: #f2f2f2;
                }
            </style>
        </head>
        <body>
        <div class="comprobante">
        <div class="titulo">Comprobante de Compras</div>
                ';

        foreach ($venta as $curso) {
            $html .= '

            <div class="info">
            <strong>Fecha:</strong>' . $curso['fecha'] . '
        </div>

        <div class="info">
            <strong>Nombre del Cliente:</strong> ' . $curso['nombre'] . ' ' . $curso['primer_apellido'] . '
        </div>

        <div class="info">
            <strong>Dirección de Envío:</strong> Calle 123, Ciudad, Estado
        </div>


        <table class="detalles-compra">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>' . $curso['nombre_producto'] . '</td>
            <td>' . $curso['cantidad'] . '</td>
            <td>$' . $curso['precio'] . '</td>
            <td>$' . $curso['subtotal'] . '</td>
            </tr>
            </tbody>
            </table>



      ';
        }

        $html .= '
            </div>
        </body>
        </html>';

        $dompdf->loadHtml($html);
        $dompdf->render();

        // Especifica el nombre del archivo y permite mostrarlo en el navegador
        $dompdf->stream("documento.'.$fecha.'.pdf", array('Attachment' => '0'));
        ob_end_flush();
        exit; // Importante para evitar la salida adicional que puede afectar al PDF

    }
}
