<?php

echo Open('nav', array('class' => 'col-md-12')); //open div paginacion
    echo tagcontent('div', $total_art.' art&iacute;culos',array('class'=>'col-md-2'));
    $cant_art_inc = '';
    $cant_art_inc .= tagcontent('option', '12', array('value' => '12'));
    $cant_art_inc .= tagcontent('option', '20', array('value' => '20'));
    $cant_art_inc .= tagcontent('option', '28', array('value' => '28'));
    $cant_art_inc .= tagcontent('option', '36', array('value' => '36'));
    $cant_art_inc .= tagcontent('option', '44', array('value' => '44'));
    
    echo Open('div', array('class' => 'col-md-3 form-group'));
    $input = tagcontent('select', $cant_art_inc, array('class' => 'form-control input-sm', 'name' => '', 'id' => ''));
    echo tagcontent('div', 'Mostrar '. $input.' articulos', array('class' => 'form-group col-md-12'));
    echo Close('div');
    
    $ordenar_por='';
    $ordenar_por.=tagcontent('option', 'Nombre', array('value'=>'1'));
    $ordenar_por.=tagcontent('option', 'Precio', array('value'=>'2'));
    
    echo Open('div', array('class' => 'col-md-3 form-group'));
    $input = tagcontent('select', $ordenar_por, array('class' => 'form-control input-sm', 'name' => '', 'id' => ''));
    echo tagcontent('div', 'Ordenar por '. $input, array('class' => 'form-group col-md-12'));
    echo Close('div');

    echo Open('nav',array('class'=>'text-center')); //open div paginacion
    ?>
<!--    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li>
          <a href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li>
          <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>-->
    <?php
        echo tagcontent('ul', $this->pagination->create_links(),array('class'=>'pagination pagination-centered'));
    echo Close('nav'); //close div paginacion 

echo Close('nav'); 

