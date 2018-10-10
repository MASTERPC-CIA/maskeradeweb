<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url('assets/estilos_menu/style_menu.css')?>" rel="stylesheet">

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="nav-side-menu">
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
            <div class="menu-list">
                <ul id="menu-content" class="menu-content collapse out">
                        <li data-toggle="collapse" data-target="#service" class="collapsed">
                          <a href=""><i class="fa fa-globe fa-lg"></i> SUB-CATEGORIAS <span class="arrow"></span></a>
                        </li>  
                        <ul class="sub-menu collapse" id="service">
                            <li ng-repeat='m in marcas'><?php 
                                echo input(array('type'=>'checkbox', 'ng-click'=>'filtrar(t.festividad)')) . '  {{m.marca}}' ;
                            ?></li>
                        </ul>


                        <li data-toggle="collapse" data-target="#new" class="collapsed">
                          <a href=""><i class="fa fa-car fa-lg"></i> TALLAS<span class="arrow"></span></a>
                        </li>
                        <ul class="sub-menu collapse" id="new">
                            <li ng-repeat='t in tallas'><?php
                                echo input(array('type'=> 'checkbox', 'ng-click'=>'filtrar(t.talla)')) . '  {{t.talla}}' ;
                            ?></li>
                        </ul>
                        <!-- <li>
                            <a href="">
                                <i class="fa fa-user fa-lg"></i> PRECIOS
                            </a>
                        </li> -->
                    </ul>
             </div>
        </div>
    </section>
</aside>