<?php
echo Open('div', array('id' => 'terciaria', 'class' => 'col-md-12'));

    if ($producto) {

        echo Open('div', array('class' => 'col-md-4', 'id' => 'gallery')); //open div span3
            $imagencargar = 'https://googledrive.com/host/0B3RoUpwSItgLfkU3bzRPS005MzhqU0dEaTdFNlJ6eWdaTXE4RGVqbUNGc1YwcnE4U2MxOUU/' . $producto->codigo2 . '.jpg';
            echo tagcontent('img', '', array('src' => $imagencargar, 'alt' => $producto->codigo2, 'class' => 'img-thumbnail'));
        echo Close('div'); //close div col-md-4

        echo Open('div', array('class' => 'col-md-6')); //open div span6

        
        echo tagcontent('h3', $producto->nombreUnico);
        echo lineBreak2(1, array('clr' => 'clr'));
        echo tagcontent('h4', 'DESCRIPCION'); //Versión 2.0 del software
        echo tagcontent('p', $producto->descripcion); 
        echo lineBreak2(1, array('clr' => 'clr'));
        echo tagcontent('h4', 'DISPONIBILIDAD Y PRECIO');
        echo lineBreak2(1, array('clr' => 'clr'));

        echo Open('table', array('class'=>'table table-bordered'));
        
            echo Open('tr', array('class'=>'danger'));
                echo tagcontent('th', 'Local');
                echo tagcontent('th', 'Stock');
                echo tagcontent('th', 'Precio ($)');
            echo Close('tr');

            foreach ($bodegas_prod as $value) {
                echo Open('tr');
                    echo tagcontent('td', $value->nombre);
                    echo tagcontent('td', $value->stock_bodega);
                    if($value->id==11){
                        echo tagcontent('td', number_decimal($preciol1), array('style'=>'text-align:right'));
                    }else{
                        echo tagcontent('td', number_decimal($preciol2), array('style'=>'text-align:right'));
                    }
                echo Close('tr');
            }
            echo Open('tr');
                echo tagcontent('td', '<strong>STOCK TOTAL</strong>');
                echo tagcontent('td', $stock_total, array('colspan'=>'2'));
            echo Close('tr');
        echo Close('table');
        
        echo tagcontent('hr', '', array('class' => 'soft'));

        if ($stock_total <= 0) {
            echo tagcontent('strong', 'NO TIENE STOCK EL PRODUCTO!!');
        } else {
            echo tagcontent('strong', 'PRODUCTO DISPONIBLE!!');
        }

            echo tagcontent('hr', '', array('class' => 'soft'));
        echo Close('div'); //close div col-md-6
    } else {
        echo error_info_msg('No existe un producto con el código ' . $cod2 . ' ingresado.');
    }
echo Close('div');
