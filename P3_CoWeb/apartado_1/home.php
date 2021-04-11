<!-- GET : pide al servidor una pagina o datos.Si el pedido tiene parámetros, ellos se envían por medio del URL
    como un string query

    POST : envía los datos a un web server y recupera la respuesta del servidor
    Si el pedido tiene parámetros, ellos se incluyen en el paquete
    HTTP pedido, y no en el URL -->

<!-- Inicio html -->
<!DOCTYPE html>
<!-- Le decimos al navegador como debe interpretar el documento -->
<html lang="en">
<!-- Lenguaje -->

<!-- Inicio head. Aqui situamos la mayoria de instrucciones para el navegador -->

<head>
    <meta charset="utf-8">
    <!-- codificacion de caracteres. Importante para prevenir UTF-7 XSS Cheat Sheet (vulnerabilidad) -->
    <!-- https://cybmeta.com/meta-charset-como-y-por-que-utilizarlo-siempre -->
    <title>The Poké-Booking Service | Hey trainer, where do you wanna go?</title>
    <!-- Mi proyecto se basa en una web para reservar hotel en las principales ciudades de la region de Kanto (Region ficticia de la franquicia de videojuegos Pokemon) -->
    <link rel="stylesheet" href="bootstrap-4.3.1_v2/css/bootstrap.min.css" type="text/css">
    <link href="fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">

    <!-- Revisar -->
    <script src="bootstrap-4.3.1_v2/js/jquery.min.js"></script>
    <script src="bootstrap-4.3.1_v2/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1_v2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/style_apartado2.css" type="text/css">
    <link rel="shortcut icon" href="images/pokeball.png">
    <!-- Utilizaremos nuestra propia hoja de estilo en cascada/css -->

    <script src="scriptaculous-js-1.9.0/lib/prototype.js" type="text/javascript"></script>
    <script src="scriptaculous-js-1.9.0/src/scriptaculous.js" type="text/javascript"></script>
    <script src="formcontrol.js" type="text/javascript"></script>
</head>
<!-- Final head -->

<!-- Inicio body -->

<body>

    <!-- Inicio navbar -->
    <nav class="navbar">

        <!-- envoltorio del titulo -->
        <div class="titlebox">
            <a href="#">
                <h1 class="navbartextlight">The <b>Poké-B<img src="images/pokeball_small.png"><img src="images/pokeball_small.png">king</b> Service</h1>
                <h5 class="navbartextlight">Book hotels around the Poké-globe</h5>
            </a>
        </div>

        <!-- botones del navbar -->
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="First group">
                <button type="button" class="btn"><i class="fa fa-question-circle" style="color: white;"></i>
                    <h7 class="navbartextlight"> Need help?</h7>
                </button>
            </div>
            <div class="btn-group mr-2" role="group" aria-label="Second group">
                <a type="button" class="btn btn-info" href="signup.php"><i class="fas fa-user-plus" style="color: white;"></i>
                    <h7 class="navbartext"> Sign Up</h7>
                </a>
            </div>
            <div class="btn-group mr-2" role="group" aria-label="Third group">
                <button type="button" class="btn btn-info"><i class="fas fa-sign-in-alt" style="color: white;"></i>
                    <h7 class="navbartext"> Sign In</h7>
                </button>
            </div>
            <div class="btn-group mr-2" role="group" aria-label="Third group">
                <button type="button" class="btn"><i class="fab fa-github" style="color: white;"></i>
                    <h7 class="navbartextlight"> <a href="https://github.com/marcosPlaza" target="_blank" style="color: white;">About me</a></h7>
                </button>
            </div>
        </div>
    </nav>
    <!-- Fin navbar -->

    <!-- Inicio alert -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 0px;">
        <div class="alerttext">
            <i class="fas fa-meh"></i> Hey trainer! Take care of your Pokémon and before traveling, check the situation of the pandemic. For more <strong>Pokérus</strong> support <a href="https://www.serebii.net/games/pokerus.shtml">click here</a>.
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- Fin alert -->

    <!-- Inicio contenido principal -->
    <div class="container-fluid wrapper">
        <div class="row">
            <div class="col-12">
                <!-- caja de busqueda -->
                <div class="searchboxtitle">
                    <h5 class="contenttitles">Explore the <strong>Pokémon</strong> world! Find deals on hotels, homes, and much more...</h5>
                    <h7 style="color: #00022e; font-weight: normal;">From cozy country homes to funky city apartments
                    </h7>
                </div>
                <div class="searchbox">
                    <div class="formwrapper">
                        <form id="searchbox" class="form-inline needs-validation" novalidate action="#" method=#>
                            <div class="form-group mb-2">
                                <h7 class="navbartextlight">Place to visit</h7>
                                <input id="cityfield" name="city" type="text" size="18" style="margin-left: 10px;" class="form-control" placeholder="City name here..." oninvalid="this.setCustomValidity('Please enter a valid Name')" required>
                            </div>
                            <div class="form-group mb-2">
                                <h7 class="navbartextlight" style="margin-left: 33px;">Check In-Out</h7>
                                <input id="checkinfield" name="trip_start" maxlenght="10" type="date" size="14" class="form-control" id="start" value="2021-01-01" min="2021-01-01" max="2050-12-31" style="margin-left: 10px;" required>
                            </div>
                            <div class="form-group mb-2">
                                <h7 class="navbartext" style="margin-left: 10px;">→</h7>
                                <input id="checkoutfield" name="trip_end" maxlength="10" type="date" size="14" class="form-control" id="end" value="2021-01-02" min="2021-01-01" max="2050-12-31" style="margin-left: 10px;" required>
                            </div>
                            <div class="form-group mb-2">
                                <h7 class="navbartextlight" style="margin-left: 33px; margin-right: 10px;">People?</h7>
                                <input id="numpeoplefield" name="num_people" type="text" class="form-control" placeholder="2" style="margin-right: 20px; width: 100px;" required>
                            </div>
                            <button type="submit" class="btn btn-info mb-2" style="margin-left: 50px;"><i class="fas fa-search" style="color: white;"></i>
                                <h7 id="searchbtn" class="navbartext"> Search now</h7>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <!-- Explorar las regiones -->
                <div class="box">
                    <div class="content">
                        <h5 class="contenttitles">So many regions to visit...</h5>
                        <dl>
                            <hr>
                            <dt><a href="https://www.serebii.net/pokearth/kanto/">
                                    <h5 class="contenttitleslight">Kanto</h5>
                                </a>
                            </dt>
                            <hr>
                            <dt><a href="https://www.serebii.net/pokearth/johto/">
                                    <h5 class="contenttitleslight">Johto</h5>
                                </a>
                            </dt>
                            <hr>
                            <dt><a href="https://www.serebii.net/pokearth/hoenn/">
                                    <h5 class="contenttitleslight">Hoenn</h5>
                                </a>
                            </dt>
                            <hr>
                            <dt><a href="https://www.serebii.net/pokearth/sinnoh/">
                                    <h5 class="contenttitleslight">Sinnoh</h5>
                                </a>
                            </dt>
                            <hr>
                            <dt><a href="https://www.serebii.net/pokearth/unova/">
                                    <h5 class="contenttitleslight">Unova</h5>
                                </a>
                            </dt>
                            <hr>
                            <dt><a href="https://www.serebii.net/pokearth/kalos/">
                                    <h5 class="contenttitleslight">Kalos</h5>
                                </a>
                            </dt>
                            <hr>
                            <dt><a href="https://www.serebii.net/pokearth/alola/">
                                    <h5 class="contenttitleslight">Alola</h5>
                                </a>
                            </dt>
                            <hr>
                            <dt><a href="https://www.serebii.net/pokearth/galar/">
                                    <h5 class="contenttitleslight">Galar</h5>
                                </a>
                            </dt>
                        </dl>
                    </div>
                </div>

                <!-- hoteles por ranking -->
                <div class="box" style="margin-top: 50px;">
                    <div class="content">
                        <h5 class="contenttitles">Hotels by ranking</h5>
                        <ol style="text-align: left; margin-top: 30px;">
                            <li>
                                <h5 class="contenttitleslight">Bellchime Trail Hotel<span class="badge badge-secondary" style="margin-left: 10px;">9,8</span></h5>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </li>
                            <li style="padding-top: 20px;">
                                <h5 class="contenttitleslight">Silph Co. Hotel<span class="badge badge-secondary" style="margin-left: 10px;">9,5</span></h5>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </li>
                            <li style="padding-top: 20px;">
                                <h5 class="contenttitleslight">Estival Avenue Hostel<span class="badge badge-secondary" style="margin-left: 10px;">9,4</span></h5>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </li>
                            <li style="padding-top: 20px;">
                                <h5 class="contenttitleslight">Water Gym Complex<span class="badge badge-secondary" style="margin-left: 10px;">9,4</span></h5>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </li>
                            <li style="padding-top: 20px;">
                                <h5 class="contenttitleslight">Mauville Game Corner Complex<span class="badge badge-secondary" style="margin-left: 10px;">8,7</span></h5>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>

                            </li>
                            <li style="padding-top: 20px;">
                                <h5 class="contenttitleslight">Jubilife Corner<span class="badge badge-secondary" style="margin-left: 10px;">7,9</span></h5>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Formulario busqueda de tu pokemon favorito (busqueda en google) -->
                <!-- Puede ser util recoger estadisticas sobre los pokemon favoritos de los visitantes. En cada region y en cada zona existen pokemon diferentes.-->
                <!-- De esta manera recomendamos los hoteles cercanos a los pokemon mas buscados por los entrenadores. -->
                <div class="boxblue" style="margin-top: 50px;">
                    <div class="content">
                        <h6 class="navbartextlight">Hey trainer, what is your favourite <strong>Pokémon</strong>?</h5>
                            <div class="container">
                                <form class="form-group" action="http://www.google.com/search">
                                    <input type="text" name="q" class="form-control" placeholder="Mine is bulbasaur..." style="margin-top: 20px;">
                                    <button type="submit" class="btn btn-info" style="margin-top: 30px;"><i class="fas fa-search" style="color: white;"></i>
                                        <h7 class="navbartext"> Search now</h7>
                                    </button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <!-- visual de la informacion general de los hoteles -->
                <div class="box">
                    <div class="content">
                        <h3 class="contenttitles">Look what's new today</h3>
                        <hr>
                        <div class="container-fluid wrapper">
                            <h4 class="contenttitleslight">Bellchime Trail Hotel on <a href="https://pokemon.fandom.com/wiki/Ecruteak_City ">Ecruteak City</a><span class="badge badge-secondary" style="margin-left: 10px;">9,8</span></h4>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <a href="# ">
                                <h5><small>View location on map</small></h3>
                            </a>
                            <img src="images/irisset.png " class="img-fluid rounded" style="width:85%"></img>
                            <p class="textitem">Tower belonging to an old Japanese temple where the legendary pokémon Ho-oh is usually worshiped. It has amazing views at all times of the year, as well as facilities of the highest luxury. It is ideal for couples as the legend
                                says that those who manage to see the seven-colored bird will enjoy eternal bliss.</p>
                            <p class="textitemlittle">* The facilities are made of a special fireproof wood. However, many of the furniture is made of oak wood, therefore please avoid that the fire-type pokémon roam freely.</p>
                            <table class="table table-striped" style="margin-top: 10px;">
                                <caption style="caption-side: top; text-align: center;">
                                    <h7>General information of the available rooms</h5>
                                </caption>
                                <tr>
                                    <th>Room type</th>
                                    <th>Sleeps</th>
                                    <th>Price for 1 night</th>
                                </tr>
                                <tr>
                                    <td>Luxury room <a href="#">(Book here)</a></td>
                                    <td>1 queen bed (2 people) <a href="#">(More information)</a></td>
                                    <td>170000₽</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Basic room <a href="#">(Book here)</a></td>
                                    <td>2 twin beds (2 people) <a href="#">(More information)</a></td>
                                    <td>30000₽</td>
                                </tr>
                                <tr>
                                    <td>Onsen room <a href="#">(Book here)</a></td>
                                    <td>2 twin beds (2 people) <a href="#">(More information)</a></td>
                                    <td>100000₽</td>
                                </tr>
                            </table>

                        </div>
                        <hr>
                        <div class="container-fluid wrapper">
                            <h4 class="contenttitleslight">Estival Avenue Hostel on <a href="https://pokemon.fandom.com/wiki/Lumiose_City ">Lumiose City</a><span class="badge badge-secondary" style="margin-left: 10px;">9,4</span></h4>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <a href="# ">
                                <h5><small>View location on map</small></h3>
                            </a>
                            <img src="images/lumiose.png " class="img-fluid rounded" style="width:85%"></img>
                            <p class="textitem">Hostel located in one of the four main avenues of this city. It has refined luxury facilities ideal for all types of guests. Food is undoubtedly one of the strong points of this place, as it has the best trio of chefs in the
                                world, Cilian, Chili and Kress.</p>
                            <table class="table table-striped" style="margin-top: 10px;">
                                <caption style="caption-side: top; text-align: center;">
                                    <h7>General information of the available rooms</h7>
                                </caption>
                                <tr>
                                    <th>Room type</th>
                                    <th>Sleeps</th>
                                    <th>Price for 1 night</th>
                                </tr>
                                <tr>
                                    <td>Luxury room <a href="#">(Book here)</a></td>
                                    <td>1 queen bed (2 people) <a href="#">(More information)</a></td>
                                    <td>170000₽</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Basic room <a href="#">(Book here)</a></td>
                                    <td>2 twin beds (2 people) <a href="#">(More information)</a></td>
                                    <td>30000₽</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Paginador -->
                <nav aria-label="Page navigation example ">
                    <ul class="pagination justify-content-center ">
                        <li class="page-item disabled ">
                            <a class="page-link " href="# " aria-label="Previous">
                                <span aria-hidden="true ">&laquo;</span>
                                <span class="sr-only ">Previous</span>
                            </a>
                        </li>
                        <li class="page-item "><a class="page-link " href="# ">1</a></li>
                        <li class="page-item "><a class="page-link " href="# ">2</a></li>
                        <li class="page-item "><a class="page-link " href="# ">3</a></li>
                        <li class="page-item ">
                            <a class="page-link " href="# " aria-label="Next">
                                <span aria-hidden="true ">&raquo;</span>
                                <span class="sr-only ">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Final contenido principal -->

    <!-- Inicio footer -->
    <footer class="fixed-bottom ">
        <h7 class="navbartextlight ">Marcos Plaza González. Computació Orientada al web. Pràctica 2, apartat 2.</h7>
    </footer>
    <!-- Final footer -->

</body>
<!-- Final body -->

</html>
<!-- Final html -->