<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url('assets/estilos_menu/style_menu.css')?>" rel="stylesheet">

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="nav-side-menu">
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
            <div class="menu-list">
                <ul id="menu-content" class="menu-content collapse out">
                        <li data-toggle="collapse" data-target="#service" class="collapsed">
                          <a href=""><i class="fa fa-globe fa-lg"></i> FESTIVIDADES <span class="arrow"></span></a>
                        </li>  
                        <ul class="sub-menu collapse" id="service">
                            <li ng-repeat='f in festividades'><?php 
                                echo input(array('type'=>'checkbox', 'ng-change'=>'filtrar_festividades(f.festividad, festividad_value)', 'ng-model'=>"festividad_value")) . '  {{f.festividad}}' ;
                            ?></li>
                        </ul>
                        <li data-toggle="collapse" data-target="#marca" class="collapsed">
                          <a href=""><i class="fa fa-globe fa-lg"></i> MARCAS <span class="arrow"></span></a>
                        </li>  
                        <ul class="sub-menu collapse" id="marca">
                            <li ng-repeat='m in marcas'><?php 
                                echo input(array('type'=>'checkbox', 'ng-change'=>'filtrar_marca(m.id, marca)', 'ng-model'=>"marca_value")) . '  {{m.marca}}' ;
                            ?></li>
                        </ul>
                        <li data-toggle="collapse" data-target="#new" class="collapsed">
                          <a href=""><i class="fa fa-car fa-lg"></i> TALLAS<span class="arrow"></span></a>
                        </li>
                        <ul class="sub-menu collapse" id="new">
                            <li ng-repeat='t in tallas'><?php
                                echo input(array('type'=> 'checkbox', 'ng-change'=>'filtrar_talla(t.talla, talla_value)', 'ng-model'=>"talla_value")) . '  {{t.talla}}' ;
                            ?></li>
                        </ul>
                    </ul>
             </div>
        </div>
    </section>
</aside>