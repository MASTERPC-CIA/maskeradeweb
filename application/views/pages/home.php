 <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="<?php echo base_url('img/navidad.jpg') ?>" alt="navidad">
        </div>
        <div class="item">
          <img class="second-slide" src="<?php echo base_url('img/halloween.jpg') ?>" alt="halloween">
          
        </div>
        <div class="item">
          <img class="third-slide" src="<?php echo base_url('img/animados.jpg') ?>" alt="animados">
<!--          <div class="container">
            <div class="carousel-caption">
              <h1>One more for good measure.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
            </div>
          </div>-->
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
      </a>
    </div><!-- /.carousel -->
    <hr id="separador1">
    <div id="texto_intermedio">
        <h1>DISFRACES Y ACCESORIOS ESPECTACULARES, DISPONEMOS DE MILES DE OPCIONES, VISÍTANOS. </h1>
        <br><br>
    </div>
      <!-- Three columns of text below the carousel -->
    <div class="row" id="home_sec2">
        <div class="col-lg-4">
            <center><img class="img-circle" src="<?php echo base_url('img/img_11.jpg') ?>" alt="servicios" width="140" height="140"></center>
            <center><h2>SERVICIOS</h2></center>
            <p>CONFECCIÓN, ALQUILER, VENTA, IMPORTACIÓN Y EXPORTACIÓN DE DISFRACES Y ACCESORIOS.</p>
            <p style="text-align: center"><a class="btn btn-danger" href="<?php echo base_url('main/load_view_servicios') ?>" role="button">Leer m&aacute;s &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <center><img class="img-circle" src="<?php echo base_url('img/img_12.jpg')?>" alt="disfraces" width="140" height="140"></center>
            <center><h2>DISFRACES</h2></center>
            <p>PARA LA REUNIÓN CON FAMILIA O AMIGOS UN GRAN STOCK PARA GRANDES Y PEQUEÑOS.</p>
            <p style="text-align: center"><a class="btn btn-success" href="#" role="button">Ver &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <center><img class="img-circle" src="<?php echo base_url('img/img_13.jpg') ?>" alt="contactos" width="140" height="140"></center>
            <center><h2>CONTACTOS</h2></center>
            <p>NUESTRA WEB Y REDES SOCIALES ESTÁN A TU DISPOSICIÓN, BÚSCANOS EN FACEBOOK Y PINTEREST.</p>
            <p style="text-align: center"><a class="btn btn-warning" href="<?php echo base_url('main/load_view_contactos')?>" role="button">Leer m&aacute;s &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->

<?php
echo tagcontent('div', '', array('content_result_out'));
