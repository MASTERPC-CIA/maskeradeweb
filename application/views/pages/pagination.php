<?php

echo Open('nav', array('class' => 'col-md-12')); //open div paginacion
    echo tagcontent('div', $total_art.' art&iacute;culos',array('class'=>'col-md-1'));
    $cant_art_inc = '';
    $cant_art_inc .= tagcontent('option', '12', array('value' => '12'));
    $cant_art_inc .= tagcontent('option', '20', array('value' => '20'));
    $cant_art_inc .= tagcontent('option', '28', array('value' => '28'));
    $cant_art_inc .= tagcontent('option', '36', array('value' => '36'));
    $cant_art_inc .= tagcontent('option', '44', array('value' => '44'));
    
    echo Open('div', array('class' => 'col-md-3 form-group')); //Cantidad de productos por pagina
        $input = tagcontent('select', $cant_art_inc, array('class' => 'form-control input-sm', 'name' => 'cant_art_by_pag', 'id' => 'cant_art_by_pag'));
        echo tagcontent('div', 'Mostrar '. $input.' articulos', array('class' => 'form-group col-md-10'));
    echo Close('div'); //Fin cantidad de productos por pagina
    
    $ordenar_por='';
    $ordenar_por.=tagcontent('option', 'Nombre', array('value'=>'1'));
    $ordenar_por.=tagcontent('option', 'Precio', array('value'=>'2'));
    
    echo Open('div', array('class' => 'col-md-4 form-group'));//Opciones de ordenamiento
        $input = tagcontent('select', $ordenar_por, array('class' => 'form-control input-sm', 'name' => 'ordenar_por', 'id' => 'ordenar_por'));
        echo tagcontent('div', 'Ordenar por '. $input, array('class' => 'form-group col-md-10'));
        echo input(array('type'=>'hidden', 'name'=>'tipo_orden', 'id'=>'tipo_orden', 'value'=>'Asc'));
        echo tagcontent('button', 'A',array('class'=>'btn btn-success','type'=>'button','id'=>'orden_asc', 'name'=>'orden_asc', 'onclick'=>'mostrar_boton_asc()', 'value'=>'', 'style'=>'display:block'));
        echo tagcontent('button', 'D',array('class'=>'btn btn-success','type'=>'button','id'=>'orden_desc', 'name'=>'orden_desc', 'onclick'=>'mostrar_boton_desc()', 'value'=>'', 'style'=>'display:none'));
    echo Close('div'); //Fin Opciones de ordenamiento
    
    
    echo Open('nav', array('class' => 'text-center')); //open div paginacion
        echo tagcontent('ul', $this->pagination->create_links(), array('class' => 'pagination pagination-centered'));
    echo Close('nav'); //close div paginacion 
echo Close('nav'); 
?>
<script>
    function mostrar_boton_desc(){
        document.getElementById('orden_asc').style.display ='block';
        document.getElementById('orden_desc').style.display='none';
        document.getElementById('tipo_orden').value='Desc';
    }
    function mostrar_boton_asc(){
        document.getElementById('orden_asc').style.display='none';
        document.getElementById('orden_desc').style.display='block';
        document.getElementById('tipo_orden').value='Asc';
    }
//    $(document.getElementById('cant_art_by_pag')).change({
//        var url = 'products_menu/load_productos';
//        var cant_prod =document.getElementById('cant_art_by_pag').value;
//        
//       
//    });
</script>
