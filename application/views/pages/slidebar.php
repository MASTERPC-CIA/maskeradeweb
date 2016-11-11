<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url('assets/estilos_menu/style_menu.css')?>" rel="stylesheet">
<aside class="main-sidebar">

    <section class="sidebar">
<div class="nav-side-menu">

    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">

                <li  data-toggle="collapse" data-target="#products" class="collapsed">
                  <a href="#"><i class="fa fa-gift fa-lg"></i> FESTIVIDADES <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products">
                <?php
                    if ($temas) {
                        foreach ($temas as $value) {
                            ?>
                        <li>
                                <?php
                                echo input(array('type' => 'checkbox', 'name' => 'selected_fest[]', 'value' => $value, 'onclick' => '', 'id' => 'festividad')) . $value;
                                ?>
                        </li>
                            <?php
                        }
                    }
                ?>
                </ul>


                <li data-toggle="collapse" data-target="#service" class="collapsed">
                  <a href="#"><i class="fa fa-globe fa-lg"></i> SUB-CATEGORIAS <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse" id="service">
                    <?php
                        if ($marcas) {
                            foreach ($marcas as $val) {
                                ?>
                                <li>
                                    <?php echo tagcontent('input', ' ', array('type' => 'checkbox', 'name' => 'selected_marcas[]', 'value' => $val->id, 'onclick' => 'get_prods_by_marca()', 'id' => 'marca')) . $val->nombre; ?>
                                </li>
                                <?php
                            }
                        }
                    ?>
                </ul>


                <li data-toggle="collapse" data-target="#new" class="collapsed">
                  <a href="#"><i class="fa fa-car fa-lg"></i> TALLAS<span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="new">
                    <?php
                        if ($tallas) {
                            foreach ($tallas as $value2) {
                                echo tagcontent('li', tagcontent('input', '', array('type' => 'checkbox', 'name' => 'selected_tallas[]', 'value' => $value2->talla, 'onclick' => 'get_prods_by_talla()', 'id' => 'talla')) . $value2->talla, array('style' => 'list-style-type: none'));
                            }
                        }
                    ?>
                </ul>

                <li>
                    <a href="#">
                        <i class="fa fa-user fa-lg"></i> PRECIOS
                    </a>
                </li>
            </ul>
     </div>
</div>
      </section>
</aside>