
    <div id="bq_logo">
        <img src="<?php echo base_url('img/banner1.png') ?>" alt="banner">
    </div>

    <div class="col-lg-12" id="bq_search">
        <div class="col-lg-5  pull-right">
            <div class="input-group">
                <input type="text" class="form-control input-sm" placeholder="Escriba lo que busca. Ejem: pirata, princesa, payaso, etc." id='product_name_autosug' name="product_name_autosug">
              <span class="input-group-btn">
                <?php
                    echo tagcontent('button', '<span class="glyphicon glyphicon-search"></span>', array('data-url'=>base_url('main/get_product_by_name'),'class'=>'btn btn-sm','data-target'=>'content_result_out','id'=>'search_products'));          
                ?>
              </span>
            </div>
        </div>
    </div>

    <br>
    <div class="navbar-wrapper" id="bq_menu">
        <div class="container">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="<?php echo base_url('products/load_productos/Hombre') ?>">Disfraces Hombres</a></li>
                            <li><a href="<?php echo base_url('products/load_productos/Mujer')?>">Disfraces Mujeres</a></li>
                            <li><a href="<?php echo base_url('products/load_productos/Ninio')?>">Disfraces Niño</a></li>
                            <li><a href="<?php echo base_url('products/load_productos/Ninia')?>">Disfraces Niña</a></li>
                            <li><a href="<?php echo base_url('products/load_productos/Unisex')?>">Disfraces Unisex</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
