<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header" style="list-style-type: none">FESTIVIDADES</li>
            <li class="treeview" style="list-style-type: none">
                <?php
                if ($temas) {
                    foreach ($temas as $value) {
                        ?>

                        <i class="fa fa-dashboard "></i> <span><?php echo tagcontent('input', ' ', array('type' => 'checkbox', 'name' => 'selected_fest[]','id' => 'selected_fest' ,'value' => $value->festividad, 'onclick'=>'res()')) . $value->festividad; ?></span> <i class="fa fa-angle-left pull-right"></i>

                        <ul class="treeview-menu">
                            <?php
                            foreach ($value->lista_marcas as $val) {
                                ?>
                                <li style="list-style-type: none">
                                <?php echo tagcontent('input', ' ', array('type' => 'checkbox', 'name' => 'selected_sub[]', 'id' => 'selected_sub','value' => $val->id_marca)) . $val->nombre_marca; ?>
                                </li>
                                    <?php
                                }
                                ?>
                        </ul>   
                            <?php
                        }
                    }
                    ?>

            </li>

        </ul>


        <ul class="sidebar-menu">
            <li class="treeview" style="list-style-type: none">

                <i class="fa fa-dashboard "></i> <span>TALLA</span> <i class="fa fa-angle-left pull-right"></i>

                <ul class="treeview-menu">
<?php
if ($tallas) {
    foreach ($tallas as $value2) {
        echo tagcontent('li', tagcontent('input', '', array('type' => 'checkbox', 'name' => 'selected_talla[]', 'value' => $value2->talla)) . $value2->talla, array('style' => 'list-style-type: none'));
    }
}
?>

                </ul>
            </li>
            <li class="treeview" style="list-style-type: none">
                <i class="fa fa-dashboard "></i> <span>PRECIO</span> <i class="fa fa-angle-left pull-right"></i>
                <ul class="treeview-menu">
                    <li style="list-style-type: none">Local 1</li>
                    <li style="list-style-type: none">Local 2</li>
                </ul>
            </li>
        </ul>
    </section>
</aside>

<script>
    
    function res(){
        var url = '../../products/test_script';
        var select_fest = new Array();
        select_fest = document.getElementById('selected_fest[]').value;
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json', 
                data:{select_fest: select_fest},
                
                success: function(html){
                    $('#sec_bq_result_search').html(html);  
                },
                error: function(){
                    alertaError("Error!! No se pudo alcanzar el archivo de proceso", "Error!!");
                }              
            });  

    }
  
</script>