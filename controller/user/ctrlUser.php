<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../model/productos_model.php';
require_once '../../model/conexion.php';
require_once '../../model/carrito.php';
require_once '../../model/enviarCorreo.php';
require_once '../../adodb5/adodb.inc.php';
require_once '../../model/cerrarSesion.php';


$cerrarSesion = new cerrarSesion;
$mostrar = new mostrar();
$agregar = new  carrito();

if (isset($_GET['opc'])) {
    $opc = $_GET['opc'];


    switch ($opc) {
        case '1': //mostrar Todos los productos
            {
                // echo 'el usuario' . $_SESSION['id_usuario'];
                if (isset($_SESSION["id_usuario"])) {
                    $productos = $mostrar->mostrarTodosProductos();
                    echo '<main class="products container">
                <h2>Tacos</h2>
                <div class="product-info">';
                    foreach ($productos as $producto) {
                        echo  ' 
                     <div class="product">
                    <div class="box">
                    <img src="../assets/img/' . $producto['foto'] . '" alt="">
                    <h3>' . $producto['nombre_producto'] . '</h3>
                    <p>Stock:' . $producto['stock'] . '</p>
                    <input type="button" class="btn btn-danger" value="AGREGAR" onclick="actualizarCarrito(' . $producto['id_producto'] . ')">
                    <div id="contador-' . $producto['id_producto'] . '">0</div>
                    <button onclick="aumentarContador(' . $producto['id_producto'] . ')">+</button>
                    <button onclick="disminuirContador(' . $producto['id_producto'] . ')">-</button>
                    <span>$' . $producto['precio'] . '</span>
                    </div>
                    </div>
                    ';
                    }

                    echo '</div>
                    </main>';
                } else {
                    echo " no entra a opc 1 por falta de inicio de sesuon";
                }
            }
            break;

        case 2: //agregar a carrito

            // Verifica si se ha enviado el contador a través de GET

            $contador = $_GET['contador'];
            $id_p = $_GET['id_producto'];
            $contador = intval($contador);
            $id_p = intval($id_p);
            echo "El valor del contador es: " . $contador . "  producto=" . $id_p;
            $agregar->agregarCarrito($_SESSION['id_usuario'], $id_p, $contador);

            break;
        case 3: //mostrar carro
            $productos = $agregar->obtenerCarrito($_SESSION['id_usuario']);


            echo '
                <div class="container">
                <div class="cart">
                    <h2>Carrito de Compras</h2>
        
                    <table>
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        ';
            foreach ($productos as $producto) {
                echo '
                        <tbody>
                            <!-- Aquí van los elementos del carrito -->
                            <tr>
                                <td>' . $producto['nombre_producto'] . '</td>
                                <td>$' . $producto['precio'] . '</td>
                                <td>' . $producto['cantidad'] . '</td>
                                <td>$' . $producto['subtotal'] . '</td>
                                <td><input type="button" class="btn btn-danger" value="ELIMINAR" onclick="borrarDeCarrito(' . $producto['id_producto'] . ')">                                </td>
                            </tr>
                            <!-- Agrega más filas según sea necesario -->
                        </tbody>';
            }
            echo ' </table>';
            $total = $mostrar->mostrarTotal($_SESSION['id_usuario']);
            foreach ($total as $t) {
                echo '
                    <div class="cart-summary">
                        <p>Total:$' . $t['total'] . '</p>';
            }
            echo  ' <input type="button" class="btn btn-danger" value="Comprar" onclick="comprarCarrito()">';

            echo '
                    </div>
                </div>
            </div>
';
            break;



        case 4: //borrar de carrito

            if (isset($_SESSION["id_usuario"])) {
                $producto = $_POST['id_producto'];
                $idUser = $_SESSION["id_usuario"];
                $agregar->eliminarElementoDelCarrito($idUser, $producto);
            } else {
                echo "El usuario no está definido";
            }
            break;
        case 5: ////comprar carrito
            if (isset($_SESSION["id_usuario"])) {
                $ticket = '';
                $ultimoUsuario = '';
                $productos = $agregar->obtenerCarrito($_SESSION['id_usuario']);

                $ticket .= '<html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                        }
                
                        #ticket {
                            width: 300px;
                            margin: 20px auto;
                            padding: 10px;
                            border: 1px solid #ccc;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                
                        h1 {
                            text-align: center;
                            color: #333;
                        }
                
                        .product-info {
                            border-bottom: 1px solid #ccc;
                            padding: 10px 0;
                            margin-bottom: 10px;
                        }
                
                        .product {
                            display: flex;
                            align-items: center;
                            margin-bottom: 10px;
                        }
                
                        .product img {
                            width: 50px;
                            height: 50px;
                            margin-right: 10px;
                        }
                
                        .box {
                            flex: 1;
                        }
                
                        p {
                            margin: 5px 0;
                        }
                
                        #total {
                            text-align: right;
                            font-size: 18px;
                            font-weight: bold;
                            margin-top: 10px;
                        }
                    </style>
                </head>
                <body>
                    <div id="ticket">
                        <h1>RECIBO DE COMPRA</h1>';

                foreach ($productos as $producto) {
                    $ultimoUsuario = $producto['correo'];
                    $ticket .= '
                        <div class="product-info">
                            <div class="product">
                                <img src="../assets/img/' . $producto['foto'] . '" alt="">
                                <div class="box">
                                    <h3>' . $producto['nombre_producto'] . '</h3>
                                    <p>PRECIO $' . $producto['precio'] . '</p>
                                    <p>SUBTOTAL $' . $producto['subtotal'] . '</p>
                                    <p>CANTIDAD ' . $producto['cantidad'] . '</p>
                                </div>
                            </div>
                        </div>';
                }

                $total = $mostrar->mostrarTotal($_SESSION['id_usuario']);
                foreach ($total as $t) {
                    $ticket .= '<div id="total">TOTAL $' . $t['total'] . '</div>';
                }

                $ticket .= '</div>
                </body>
                </html>';


                $correo = new MailerService();
                ///envia correo
                $correo->sendMailTicket($ultimoUsuario, $ticket);
                //comprar carro 
                $agregar->comprarCarrito($_SESSION["id_usuario"]);
            } else {
                echo "inicia sesion";
            }
        case 6: //barra de tareas
            if ($_SESSION["id_rol"] == 1) {
                echo ' 
            barra de administrador
            
            <header class="header">
            <img class="bg" src="../assets/imagenes/bg.svg" alt="">
            <div class="menu container">
                <a class="logo"><img src="../assets/imagenes/Tacos.jpg" alt="Logo"></a>
                <input type="checkbox" id="menu">
                <nav class="nav">
                    <div class="flex">
                        <nav class="navbar">
                            <ul>
                                <li><a href="menu.php">Inicio</a></li>
                                <li><a href="./contactus.html">Contacto</a></li>
                                <li><a href="editarproductos.php">EDITAR PRODUCTOS</a></li>
                                <li><a href="subirproductos.php">SUBIR PRODUCTOS</a></li>
                                <li><a href="g.html">GRAFICA</a></li>

                                <li><a href="../controller/user/ctrlUser.php?opc=7"><img src="../assets/img/cerrar_sesion.png" alt="" height="30"></a></li>
                                <div class="icons">
                                <a class="nav-link" href="carrito.php" id="contador">
                                <div class="carrito-container">
                                    <img src="../assets/img/verificar.png" alt="" height="30">
                                    <!--el contador value se usa mas que nada el value para obtener los valores del id que se llama contador-->
                                    <span id="contador-value"></span>
                                </div>
                            </a>
                            </div>
                                <div class="user-box">
                                    <form method="post" action="../controller/user/ctrlUser.php?opc=7" >
                                        <button type="submit" name="logout" class="logout-btn">CERRAR SESION</button>
                                    </form>
                                </div>
                                <div>
                              
                                        <img src="../assets/img/carrito.png" alt="" width="25px" height="auto">
                                        <div class="carrito-container">
                                    
                                        </div>
                                    </a>
                                </div>
                            </ul>
                        </nav>
                    </div>
                </nav>
            </div>
            <div class="header-content container">
                <div class="header-info">
                    <div class="header-txt">
                        <h1>Disfruta de nuestros mejores productos</h1>
                        <p>
                            Nuestros productos de menú son el resultado de una cuidadosa selección de ingredientes frescos y
                            de alta calidad, combinados con sabores auténticos y recetas tradicionales para ofrecer una
                            un sabor único e inolvidable.
                        </p>
                    </div>
                    <div class="header-img">
                        <img src="../assets/imagenes/NiñaTacosMenu.jpg" alt="">
                    </div>
                </div>
            </div>
        </header>
    ';
            } else  if ($_SESSION["id_rol"] == 2) {
                echo ' 
                barra de usuario
                <header class="header">
                <img class="bg" src="../assets/imagenes/bg.svg" alt="">
                <div class="menu container">
                    <a class="logo"><img src="../assets/imagenes/Tacos.jpg" alt="Logo"></a>
                    <input type="checkbox" id="menu">
                    <nav class="nav">
                        <div class="flex">
                            <nav class="navbar">
                                <ul>
                                    <li><a href="menu.php">Inicio</a></li>
                                    <li><a href="./contactus.html">Contacto</a></li>
                                    <li><a href="./historialDeCompras.html">Historial de compra</a></li>
                                    <li><a href="../controller/user/ctrlUser.php?opc=7"><img src="../assets/img/cerrar_sesion.png" alt="" height="30"></a></li>

                                    <div class="icons">
                                        <a class="nav-link" href="carrito.php" id="contador">
                                        <div class="carrito-container">
                                            <img src="../assets/img/verificar.png" alt="" height="30">
                                            <!--el contador value se usa mas que nada el value para obtener los valores del id que se llama contador-->
                                            <span id="contador-value"></span>
                                        </div>
                                    </a>
                                    </div>
                                    <div class="user-box">
                                        <form method="post">
                                            <button type="submit" name="logout" class="logout-btn">Log Out</button>
                                        </form>
                                    </div>
                                        </a>
                                    </div>
                                </ul>
                            </nav>
                        </div>
                    </nav>
                </div>
                <div class="header-content container">
                    <div class="header-info">
                        <div class="header-txt">
                            <h1>Disfruta de nuestros mejores productos</h1>
                            <p>
                                Nuestros productos de menú son el resultado de una cuidadosa selección de ingredientes frescos y
                                de alta calidad, combinados con sabores auténticos y recetas tradicionales para ofrecer una
                                un sabor único e inolvidable.
                            </p>
                        </div>
                        <div class="header-img">
                            <img src="../assets/imagenes/NiñaTacosMenu.jpg" alt="">
                        </div>
                    </div>
                </div>
            </header>
        ';
            }
            break;
        case "7":
            $cerrarSesion->logoutUserById($_SESSION['id_usuario']);
            header('Location: ../../index.php');
            break;
        case "8":
            $contador = $agregar->carritosContador($_SESSION['id_usuario']);
            echo $contador;
            break;
        case "9": //muestra lkos valoeres en el vistas
            if (isset($_SESSION['id_usuario'])) {
                if (isset($_SESSION['id_usuario'])) {
                    $productos = $mostrar->mostrarTodosProductos();
                    echo ' <div class="container">';
                    foreach ($productos as $producto) {
                        echo ' <div class="product-card">
                        <img class="product-image" src="../assets/img/' . $producto['foto'] . '" alt="Producto">
                        <h2>' . $producto['nombre_producto'] . '</h2>
                            <p>Stock:' . $producto['stock'] . '</p>
                            <span>$' . $producto['precio'] . '</span>
                        <div class="stock">
                           
                            <button onclick="aumentarContador(' . $producto['id_producto'] . ')">+</button>
                            <div id="contador-' . $producto['id_producto'] . '">0</div>
                            <button onclick="disminuirContador(' . $producto['id_producto'] . ')">-</button>
                        </div>
                        <input type="button" class="btn-danger" value="AGREGAR" onclick="actualizarCarrito(' . $producto['id_producto'] . ')">

                    </div>';
                    }
                    echo '</div>';
                } else {
                    echo 'inicia sesion';
                }
            } else {
                echo 'inicia sesion porfa';
            }
            break;
        case "10":
            if ($_SESSION["id_rol"] == 1) {
                echo '
                <nav>
                <img src="../assets/imagenes/Tacos.jpg" alt="Logo"> <!-- Ajusta la ruta según sea necesario -->
                <a href="../vistas/vistas2.php">Productos</a>
                <a href="./contactus.html">Contacto</a>
                <a href="editarproductos.php">EDITAR PRODUCTOS</a>
                <a href="subirproductos.php">SUBIR PRODUCTOS</a>
                <a href="g.php">GRAFICA</a>
                <a href="./historialDeCompras.php">Historial de compra</a>
        
                <div class="icons">
                    <div class="icons">
        
                        <a class="nav-link" href="carrito.php" id="contador">
                            <div class="carrito-container">
                                <img src="../assets/img/verificar.png" alt="" height="30">
                                <!--el contador value se usa mas que nada el value para obtener los valores del id que se llama contador-->
                                <span id="contador-value"></span>
                            </div>
                        </a> <!-- Agrega más enlaces según sea necesario -->
                    </div>
                </div>
                <a href="../controller/user/ctrlUser.php?opc=7"><img src="../assets/img/cerrar_sesion.png" alt=""
                        height="30"></a>
        
            </nav>
         ';
            } else if ($_SESSION["id_rol"] == 2) {
                echo '
                
                <nav>
                <img src="../assets/imagenes/Tacos.jpg" alt="Logo"> <!-- Ajusta la ruta según sea necesario -->
                <a href="../vistas/vistas2.php">Productos</a>
                <a href="./contactus.html">Contacto</a>
                <a href="./historialDeCompras.php">Historial de compra</a>
                <div class="icons">
                    <div class="icons">
                        <a class="nav-link" href="carrito.php" id="contador">
                            <div class="carrito-container">
                                <img src="../assets/img/verificar.png" alt="" height="30">
                                <!--el contador value se usa mas que nada el value para obtener los valores del id que se llama contador-->
                                <span id="contador-value"></span>
                            </div>
                        </a> <!-- Agrega más enlaces según sea necesario -->
                    </div>
                </div>
                <a href="../controller/user/ctrlUser.php?opc=7"><img src="../assets/img/cerrar_sesion.png" alt=""
                        height="30"></a>
        
            </nav>
        
                ';
            }else {
            echo "el rol no esta definido";
            //header('Location: ../../index.php');
        }
            break;
    }
} else {
}