<?php
echo tagcontent('span','', array('us-spinner'=>"{radius:50, width:10, length: 100}"));
echo tagcontent('toaster-container', '' , array('toaster-options'=>"{'time-out': 3000}"));

echo Open('div', array('class' => 'col-md-12 tab-content', 'id' => 'secundaria'));

    echo Open('div' , array('class'=>'form-group col-md-8 pull-right'));
        echo Open('div', array('class'=>'input-group has-default'));
          echo input(array('type'=>"text",'class'=>"form-control input-md", 'ng-model'=>'cadena', 'placeholder'=>"Escriba lo que busca. Ejem: pirata, princesa, payaso, etc."));
          $button = tagcontent('button', '<span class="glyphicon glyphicon-search"></span>', array('class'=>"btn btn-sm btn-success", 'ng-click'=>"buscar(cadena)"));
          echo tagcontent('span', $button, array('class'=>"input-group-btn"));
        echo Close('div');
    echo Close('div');

    echo Open('div', array('class' => 'col-sm-12', 'align' => 'right'));
        echo tagcontent('dir-pagination-controls', '', array('max-size' => 'totalProductos', 'direction-links' => 'true', 'boundary-links' => 'true', 'on-page-change'=>"pageChanged(newPageNumber)"));
    echo Close('div');

    echo Open('div', array('id'=>'sec_bq_sidebar', 'class'=>'col-md-3'));
        $this->load->view('pages/slidebar');
    echo Close('div');

    echo Open('div', array('class'=>'col-md-9'));
        echo Open('div', array('dir-paginate' => 'p in productos|filter:search|itemsPerPage: productosPerPage" total-items="totalProductos" current-page="pagination.current"'));

            $imagenbloc = tagcontent('img', '', array('src' => '{{p.img}}', 'alt' => '', 'style' => 'height:140px;width:140px;margin: auto;', 'class' => 'thumbnail'));
            echo Open('div', array('class' => 'col-md-3 pull-left', 'style' => 'min-height:200px;overflow:hidden'));
                echo Open('div', array('class' => 'thumbnail text-center'));
                    echo tagcontent('a', $imagenbloc, array('href' => '{{p.img}}'));
                echo Open('div', array('class' => 'caption', 'style' => 'text-align:center;'));
                    echo tagcontent('p', 'COD:{{p.codigo}} - {{p.nombreUnico}}', array('style' => 'font-size:7pt'));
                echo Close('div');
            echo Close('div');
        echo Close('div'); 
    echo Close('div');

echo Close('div');