<aside class="main-sidebar">

    <section class="sidebar">
            <!--Menu que muestra las opciones en cuanto a las festividades-->
            <ul class="sidebar-menu">
                <li class="header" style="list-style-type: none;background: #FFA500">FESTIVIDADES</li>

                <?php
                if ($temas) {
                    foreach ($temas as $value) {
                        ?>
                        <li class="treeview" style="list-style-type: none">
                            <?php
                            echo input(array('type' => 'checkbox', 'name' => 'selected_fest[]', 'value' => $value, 'onclick' => '', 'id' => 'festividad')) . $value;
                            ?>
                        </li>
                        <?php
                    }
                }
                ?>

            </ul>
            
            <!--Menu que muestra las opciones en cuanto a las marcas-->
            <ul class="sidebar-menu">
                <li class="header" style="list-style-type: none; background: #FFA500">TEMAS</li>
                <?php
                if ($marcas) {
                    foreach ($marcas as $val) {
                        ?>
                        <li style="list-style-type: none">
                            <?php echo tagcontent('input', ' ', array('type' => 'checkbox', 'name' => 'selected_marcas[]', 'value' => $val->id, 'onclick' => 'get_prods_by_marca()', 'id' => 'marca')) . $val->nombre; ?>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>

            <!--Menu que muestra las opciones en cuanto a las tallas-->
            <ul class="sidebar-menu">
                <li class="header" style="list-style-type: none;background: #FFA500">TALLAS</li>

                <?php
                if ($tallas) {
                    foreach ($tallas as $value2) {
                        echo tagcontent('li', tagcontent('input', '', array('type' => 'checkbox', 'name' => 'selected_tallas[]', 'value' => $value2->talla, 'onclick' => 'get_prods_by_talla()', 'id' => 'talla')) . $value2->talla, array('style' => 'list-style-type: none'));
                    }
                }
                ?>
            </ul>

            <input type="hidden" id="busq_opcion" name="busq_opcion" value="<?php echo $busq_opcion ?>">
            <input type="hidden" id="busq_desde" name="busq_desde" value="<?php echo $busq_desde ?>">

            <ul>
                <li class="header" style="list-style-type: none;background: #FFA500">PRECIOS</li>
                <b>Desde:</b>  <?php echo $precio_min; ?><b> Hasta:</b>  <?php echo $precio_max; ?>
                <input type="text" name="precio_alq" id="precio_alq">
            </ul>
      </section>
</aside>

<script>

    function get_prods_by_fest() {
        
        var url = '../products_filter/get_prods_filter_by_fest';
        var fest = $(this).value;
        var criterio_busq = document.getElementById('busq_opcion');
        var lugar_busq = document.getElementById('busq_desde');

        $ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {fest: fest, url: url, criterio: criterio_busq, lugar: lugar_busq},
            success: function (html) {
                $('#secundaria').html(html);
            },
            error: function () {
                alertaError("Error!! No se pudo alcanzar el archivo de proceso", "Error!!");
            }

        });
    }

    function get_prods_by_marca() {
        alert(document.getElementById('selected_marca').value);
    }

    function get_prods_by_talla() {
        alert(document.getElementById('selected_talla').value);
    }
    function res() {

        var url = '../products_filter/test_script';
        var select_fest = new Array();
        select_fest = document.getElementsByName('selected_fest_val');
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
    contentselect_fest = document.getElementById("fest");
    contentselect_fest.onchange = function () {
        $.ajax({
            type: "POST",
            url: "../products_filter/get_prods_filter",
            dataType: 'json',
            data: {name_fest: document.getElementsByName('selected_fest')},
            success: function (respuesta) {
                alert('Funcion ejecutada correctamente');
            }});
    };

</script>