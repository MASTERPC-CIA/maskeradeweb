<aside class="main-sidebar">
    
    <section class="sidebar">
        
        <!--Menu que muestra las opciones en cuanto a las festividades-->
        <ul class="sidebar-menu">
            <li class="header" style="list-style-type: none;background: #32CD32">FESTIVIDADES</li>
            
                <?php
                if ($temas) {
                    foreach ($temas as $value) {
                        ?>
                        <li class="treeview" style="list-style-type: none">
                            <i class="fa fa-dashboard "></i> <span><?php echo tagcontent('input', ' ', array('type' => 'checkbox', 'name' => 'selected_fest[]', 'id' => 'selected_fest', 'value' => $value, 'onclick' => 'res()')) . $value; ?></span> <i class="fa fa-angle-left pull-right"></i>
                        </li>
                        <?php
                    }
                }
                ?>
            
        </ul>
        
        <!--Menu que muestra las opciones en cuanto a las marcas-->
        <ul class="sidebar-menu">
            <li class="header" style="list-style-type: none; background: #32CD32">TEMAS</li>
            <?php
            if ($marcas) {
                foreach ($marcas as $val){
                    ?>
                    <li style="list-style-type: none">
                        <?php echo tagcontent('input', ' ', array('type' => 'checkbox', 'name' => 'selected_sub[]', 'id' => 'selected_sub', 'value' => $val->id)) . $val->nombre; ?>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        
        <!--Menu que muestra las opciones en cuanto a las tallas-->
        <ul class="sidebar-menu">
            <li class="header" style="list-style-type: none;background: #32CD32">TALLAS</li>
            
                    <?php
                    if ($tallas) {
                        foreach ($tallas as $value2) {
                            echo tagcontent('li', tagcontent('input', '', array('type' => 'checkbox', 'name' => 'selected_talla[]', 'value' => $value2->talla)) . $value2->talla, array('style' => 'list-style-type: none'));
                        }
                    }
                    ?>
         </ul>
        
        <ul>
            <li class="header" style="list-style-type: none;background: #32CD32">PRECIOS</li>
            <li style="list-style-type: none"><b>Desde:</b>  <?php echo $precio_min; ?></li>
            <li style="list-style-type: none"><b>Hasta:</b>  <?php echo $precio_max; ?></li>
        </ul>
    </section>
</aside>

<script>

    function res() {
        var url = '../../products/test_script';
        var select_fest = new Array();
        select_fest = document.getElementById('selected_fest[]').value;
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {select_fest: select_fest},
            success: function (html) {
                $('#sec_bq_result_search').html(html);
            },
            error: function () {
                alertaError("Error!! No se pudo alcanzar el archivo de proceso", "Error!!");
            }
        });

    }

</script>