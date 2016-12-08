
    <div id="bq_logo">
        <img src="<?php echo base_url('img/banner1.png') ?>" alt="banner">
    </div>

    <div class="col-lg-12" id="bq_search">
        <div class="col-lg-5  pull-right">
            <form action="<?php echo base_url('products_search/get_all_products_by_name') ?>" method="post">
                <div class="col-md-12 input-group">
                    <input type="text" class="form-control input-sm" placeholder="Escriba lo que busca. Ejem: pirata, princesa, payaso, etc." id='product_name_autosug' name="product_name_autosug">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-success" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <br>
    <div id="bq_menu">
    <div class="navbar-wrapper">
        <div class="container">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="<?php echo base_url('main/index')?>">Inicio</a></li>
                            <li><a href="<?php echo base_url('products_menu/load_productos/Hombre')?>">Disfraces Hombres</a></li>
                            <li><a href="<?php echo base_url('products_menu/load_productos/Mujer')?>">Disfraces Mujeres</a></li>
                            <li><a href="<?php echo base_url('products_menu/load_productos/Ninio')?>">Disfraces Niño</a></li>
                            <li><a href="<?php echo base_url('products_menu/load_productos/Ninia')?>">Disfraces Niña</a></li>
                            <li><a href="<?php echo base_url('products_menu/load_productos/Bebe')?>">Disfraces Beb&eacute;</a></li>
                            <!--<li><a href="<?php echo base_url('products_menu/load_productos/Unisex')?>">Disfraces Unisex</a></li>-->
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>