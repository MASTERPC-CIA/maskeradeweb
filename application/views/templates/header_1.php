<!DOCTYPE html>
<html lang="es">
    <head>
        <title>MASKERADE</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/page/stylemain.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/page/carousel.css')?>" rel="stylesheet">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="<?= base_url()?>assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="<?php echo base_url()?>assets/js/ie-emulation-modes-warning.js"></script>
      
    </head>
    <body>
        <div id="bq_logo">
            <img src="<?php echo base_url('img/banner1.png') ?>" alt="banner">
        </div>
        <div class="col-lg-12" id="bq_search">
            <div class="col-lg-5  pull-right">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" placeholder="Escriba lo que busca. Ejem: pirata, princesa, payaso, etc." callback='refresh_cart_insert_prod' id='product_name_autosug' data-url="<?= base_url('common/autosuggest/get_product_by_name/%QUERY') ?>">
                  <span class="input-group-btn">
                    
                      <?php
                        echo tagcontent('button', '<span class="glyphicon glyphicon-search"></span>', array('data-url'=>base_url('ventas/product/searchview/time/'.time()),'class'=>'btn btn-sm','data-target'=>'cotizacionescart','id'=>'search_products'));          
                      ?>
                  </span>
                </div><!-- /input-group -->
            </div>
        </div>
        <br>
        <div class="navbar-wrapper" id="bq_menu">
            <div class="container">
                <nav class="navbar navbar-default navbar-static-top">
                    <div class="container">
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo base_url('main/show_result/1') ?>">Disfraces Hombres</a></li>
                                <li><a href="#about">Disfraces Mujeres</a></li>
                                <li><a href="#contact">Disfraces Niño</a></li>
                                <li><a href="#contact">Disfraces Niña</a></li>
                                <li><a href="#contact">Disfraces Unisex</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>