<?php

$cant_art_inc = '';
$cant_art_inc .= tagcontent('option', '12', array('value' => '12'));
$cant_art_inc .= tagcontent('option', '24', array('value' => '24'));
$cant_art_inc .= tagcontent('option', '36', array('value' => '36'));
$cant_art_inc .= tagcontent('option', '48', array('value' => '48'));

$ordenar_por='';
$ordenar_por.=tagcontent('option', 'Nombre', array('value'=>'1'));
$ordenar_por.=tagcontent('option', 'Precio', array('value'=>'2'));
    
echo Open('div', array('class'=>'col-md-12'));

    echo Open('form', array('id' => 'guardar', 'method' => 'post', 'action' => base_url() . ''));
    
        echo Open('div', array('class' => 'container'));
        
            echo Open('div', array('class' => 'col-md-2 form-group'));
                echo Open('div', array('class' => 'input-group has-success'));
                    echo tagcontent('span', $total_art.' art&iacute;culos', array('class' => 'input-group-addon'));
                echo Close('div');
            echo Close('div');

            echo Open('div', array('class' => 'col-md-2 form-group'));
                echo Open('div', array('class' => 'input-group has-success'));
                    echo tagcontent('span', 'Mostrar: ', array('class' => 'input-group-addon'));
                     echo tagcontent('select',$cant_art_inc,array('class' => 'form-control input-sm', 'name' => 'cant_prod', 'id' => 'cant_prod'), true);
                echo Close('div');
            echo Close('div');

            echo Open('div', array('class' => 'col-md-8 form-group'));
                echo Open('div', array('class' => 'input-group has-success'));
                    echo Open('nav', array('class' => 'text-center'));
                        echo tagcontent('ul', $this->pagination->create_links(), array('class' => 'pagination pagination-centered'));
                    echo Close('nav');
                echo Close('div');
            echo Close('div');
            
        echo Close('div');
        
    echo Close('form');
    
echo Close('div');?>
<script>
 /*$("#cant_prod").change(function ({
     
     
 }));*/
</script>