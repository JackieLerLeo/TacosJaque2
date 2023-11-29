<?php
session_start();
if (isset($_SESSION["id_usuario"] )) {
    header('location: vistas/vistas2.php');
    // You may want to remove this echo statement unless it's for debugging purposes
    // echo "sesion" . $_SESSION['id_usuario'];
} else {
    //echo "Sesión no iniciada";
    //header('location: vistas/login.php');

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tacos Jaque</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!--Carrusel-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="https://raw.githubusercontent.com/daneden/animate.css/master/animate.css" rel="stylesheet">

    <!--Carrusel-->

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link rel="icon" href="../assets/imagenes/Tacos.jpg">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/carrusel.css">
    <link rel="stylesheet" href="./assets/js/carrusel.js">


</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#"><img src="./assets/imagenes/Tacos.jpg" height="100" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="./index.php">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./vistas/aboutus.html">Sobre Nosotros <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <a href="./vistas/Login.php" class="btn btn-outline-success">Iniciar Session</a> 
                    <a href="./vistas/registrarse.php" class="btn btn-outline-success">Registrarse</a> 
                    
                    <!--Se cree un btn para que nos lleve a otra ventana-->
                   
                </form>
            </div>
        </nav>
    </header>

    <section>
        <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="mask flex-center">
                  <div class="container">
                    <div class="row align-items-center">
                      <div class="col-md-7 col-12 order-md-1 order-2">
                        <h4>Los Mejores Tacos <br>
                          </h4>
                        <p>Lorem ipsum dolor sit amet. Reprehenderit, qui blanditiis quidem rerum <br>
                          necessitatibus praesentium voluptatum deleniti atque corrupti.</p>
                        <a href="#"></a> </div>
                      <div class="col-md-5 col-12 order-md-2 order-1"><img src="./assets/imagenes/1.jpg" class="mx-auto" alt="slide"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="mask flex-center">
                  <div class="container">
                    <div class="row align-items-center">
                      <div class="col-md-7 col-12 order-md-1 order-2">
                        <h4>Inigualables <br>
                          </h4>
                        <p>Lorem ipsum dolor sit amet. Reprehenderit, qui blanditiis quidem rerum <br>
                          necessitatibus praesentium voluptatum deleniti atque corrupti.</p>
                        <a href="#"></a> </div>
                      <div class="col-md-5 col-12 order-md-2 order-1"><img src="./assets/imagenes/2.jpg" class="mx-auto" alt="slide"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="mask flex-center">
                  <div class="container">
                    <div class="row align-items-center">
                      <div class="col-md-7 col-12 order-md-1 order-2">
                        <h4>Esquisitos <br>
                          </h4>
                        <p>Lorem ipsum dolor sit amet. Reprehenderit, qui blanditiis quidem rerum <br>
                          necessitatibus praesentium voluptatum deleniti atque corrupti.</p>
                        <a href="#"></a> </div>
                      <div class="col-md-5 col-12 order-md-2 order-1"><img src="./assets/imagenes/3.jpg" class="mx-auto" alt="slide"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
          <!--slide end--> 
    </section>
    <!--Footer-->
    <footer class="kilimanjaro_area">
        <!-- Top Footer Area Start -->
        <div class="foo_top_header_one section_padding_100_70">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="kilimanjaro_part">
                            <h5>Sobre Nuestro Producto</h5>
                            <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione nemo rerum doloremque
                                dolor, illo libero maiores eum veritatis mollitia rem fugit voluptatem illum eos,
                                eligendi aperiam minus ipsum autem itaque! </p>
                            <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi natus explicabo incidunt
                                beatae consequatur, dolorum iste odit in quae cupiditate maxime cum sapiente nemo earum
                                error, reiciendis assumenda soluta. Cumque?</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="kilimanjaro_part m-top-15">
                            <h5>Contactar nos</h5>
                            <ul class="kilimanjaro_social_links">
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a></li>
                                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i> Pinterest</a></li>
                                <li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i> YouTube</a></li>
                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i> Linkedin</a></li>
                                <li><a herf="#" href="./vistas/contactus.html">Contactanos</a></li>
                                <!--Nos manda a la otra-->
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="kilimanjaro_part">
                            <h5>Latest News</h5>
                            <div class="kilimanjaro_blog_area">
                                <div class="kilimanjaro_thumb">
                                    <img class="img-fluid"
                                        src="./assets/imagenes/BuenaAtencion.jpg"
                                        alt="">
                                </div>
                                <a href="#">Buena Attencion</a>
                                <p class="kilimanjaro_date">21 Jan 2018</p>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </div>
                            <div class="kilimanjaro_blog_area">
                                <div class="kilimanjaro_thumb">
                                    <img class="img-fluid"
                                        src="./assets/imagenes/BuenaCalidad.png"
                                        alt="">
                                </div>
                                <a href="#">Excelente Calidad</a>
                                <p class="kilimanjaro_date">21 Jan 2018</p>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </div>
                            <div class="kilimanjaro_blog_area">
                                <div class="kilimanjaro_thumb">
                                    <img class="img-fluid"
                                        src="./assets/imagenes/Ingredientes.jpg"
                                        alt="">
                                </div>
                                <a href="#">Calidad Ingredientes</a>
                                <p class="kilimanjaro_date">21 Jan 2018</p>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="kilimanjaro_part">
                            <h5>Quick Contact</h5>
                            <div class="kilimanjaro_single_contact_info">
                                <h5>Phone:</h5>
                                <p>+52 461 879 3950 <br> +52 461 038 9323</p>
                            </div>
                            <div class="kilimanjaro_single_contact_info">
                                <h5>Email:</h5>
                                <p>support@tacosjaque.com <br> recursoshumanos@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom Area Start -->
        <div class=" kilimanjaro_bottom_header_one section_padding_50 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p>© All Rights Reserved by <a href="#">Webublogoverflow.blogspot -(with all love)<i
                                    class="fa fa-love"></i></a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>