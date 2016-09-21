<aside class="main-sidebar">
    <section class="sidebar">
        
        
        <ul class="sidebar-menu">
            <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard "></i> <span>FESTIVIDADES</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                       <?php
                       
                        if($temas){
                            foreach ($temas as $value) {
                                echo tagcontent('li', tagcontent('input', ' ',array('type' => 'checkbox', 'name'=>'selected_fest[]', 'value'=>$value->festividad)).$value->festividad, array('style'=>'list-style-type: none'));
                                foreach ($value->lista_marcas as $val) {
                                    echo tagcontent('li', tagcontent('input', ' ',array('type' => 'checkbox', 'name'=>'selected_fest_marcas[]', 'value'=>$val->id_marca)).'*'.$val->nombre_marca, array('style'=>'list-style-type: none'));
                                }
                            }
                        }
                       
                       ?>
                       
                    </ul>
            </li>
           
             <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard "></i> <span>TALLA</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php
                        if($tallas){
                            foreach ($tallas as $value2) {
                                echo tagcontent('li', tagcontent('input', '', array('type'=>'checkbox', 'name'=>'selected_talla[]', 'value'=>$value2->talla)).$value2->talla, array('style'=>'list-style-type: none'));
                            }
                        }
                        ?>
                       
                    </ul>
                </li>
                 <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard "></i> <span>PRECIO</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>Local 1</li>
                        <li>Local 2</li>
                       
                    </ul>
                </li>
        </ul>
    </section>
</aside>
 