<?php
echo Open('div', array('id' => 'terciaria', 'class' => 'col-md-12'));
if (!empty($producto)) {

    echo Open('div', array('class' => 'col-md-4 form-group'));
        echo Open('div', array('class' => 'input-group'));
            $imagen = "http://186.5.31.52/maskarade/".$producto[0]->cod_sup.".jpg";
            echo "<img src='$imagen' width='100%'  onerror='myFunction(this)'><br>"; 
        echo Close('div');
    echo Close('div');

    /* Stock disponible para alquiler/venta */
    echo Open('div', array('class' => 'col-md-8'));
    echo Open('table', array('class' => 'table table-condensed', 'style' => "font-size:16px;"), array('class' => 'text-right'));
    echo Open('tr class="info"');
        $pal = explode(" ", $producto[0]->nombre_view);
        echo tagcontent('td COLSPAN=6', $pal[0], array('class' => 'text-center'));
    echo Close('tr');
    echo Open('tr class="info"');
        echo tagcontent('td COLSPAN=6', '<strong>Descripci&oacute;n: </strong>'.$producto[0]->descripcion, array('class' => 'text-center'));
    echo Close('tr');
    echo Open('tr class="warning"');
    echo tagcontent('td COLSPAN=6', 'Stock disponible para alquiler/venta', array('class' => 'text-center'));
    echo Close('tr');
    echo Open('tr');
    echo tagcontent('td', '');
    echo tagcontent('td COLSPAN=2', 'LOCAL 1', array('class' => 'text-center'));
    echo tagcontent('td COLSPAN=2', 'LOCAL 2', array('class' => 'text-center'));
    echo tagcontent('td', '');
    echo Close('tr');
    echo Open('tr');
    echo tagcontent('td', 'Talla', array('class' => 'text-center'));
    echo tagcontent('td', 'Stock', array('class' => 'text-center'));
    echo tagcontent('td', 'P. Alquiler', array('class' => 'text-center'));
    echo tagcontent('td', 'Stock', array('class' => 'text-center'));
    echo tagcontent('td', 'P. Alquiler', array('class' => 'text-center'));
    echo tagcontent('td', 'P. Venta', array('class' => 'text-center'));
    echo Close('tr');
    $suma_l1 = 0;
    $suma_l2 = 0; 
    $cont = 0;
    foreach ($producto as $prod) {
        echo Open('tr');
        echo tagcontent('td', $prod->talla, array('class' => 'text-center'));
        if ($stock1[$cont] == 0) {
            echo tagcontent('td', '<font color="red">“No disponible”</font>', array('class' => 'text-center'));
        } else {
            echo tagcontent('td', $stock1[$cont], array('class' => 'text-center'));
        }
        echo tagcontent('td', number_decimal($prod->alq_l1), array('class' => 'text-center'));
        if ($stock2[$cont] == 0) {
            echo tagcontent('td', '<font color="red">“No disponible”</font>', array('class' => 'text-center'));
        } else {
           echo tagcontent('td', $stock2[$cont], array('class' => 'text-center'));
        }
        echo tagcontent('td', number_decimal($prod->alq_l2), array('class' => 'text-center'));
        echo tagcontent('td', number_decimal($prod->pvp), array('class' => 'text-center'));
        $suma_l1 = $suma_l1 + $stock1[$cont];
        $suma_l2 = $suma_l2 + $stock2[$cont];
        echo Close('tr');
        $cont++;
    }
    echo Open('tr class="success"');
    echo tagcontent('td', '<strong>TOTAL</strong>', array('class' => 'text-center'));
    if ($suma_l1 == 0) {
        echo tagcontent('td', '<strong><font color="red">“No hay stock”</font></strong>', array('class' => 'text-center'));
    } else {
        echo tagcontent('td', '<strong>' . $suma_l1 . '</strong>', array('class' => 'text-center'));
    }
    echo tagcontent('td', '');
    if ($suma_l2 == 0) {
        echo tagcontent('td', '<strong><font color="red">“No hay stock”</font></strong>', array('class' => 'text-center'));
    } else {
        echo tagcontent('td', '<strong>' . $suma_l2 . '</strong>', array('class' => 'text-center'));
    }
    echo tagcontent('td COLSPAN=2', '', array('class' => 'text-center'));
    echo Close('tr');

    echo Close('table');
    echo Close('div');

} else {
    echo Open('div', array('class' => 'col-sm-12 form-group'));
        echo Open('div', array('class' => 'input-group'));
            echo tagcontent('span', 'NO POSEE CODIGO COMÚN EL PRODUCTO!!', array('class' => 'input-group-addon'));
        echo Close('div');
    echo Close('div');
}
echo Close('div');
?>
<script>
 
function myFunction(image) {
    //alert('The image could not be loaded.');
    image.onerror = "";
    image.src =  "http://186.5.31.52/maskarade/no_disponible.jpg";
    return true;
}
</script>