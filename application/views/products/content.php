<?php

echo tagcontent('div', '', array('id' => 'res_info', 'class' => 'col-md-12'));

echo Open('div', array('class' => 'col-md-12 tab-content', 'id' => 'secundaria'));

    echo Open('div', array('id'=>'sec_bq_sidebar', 'class'=>'col-md-3'));
        $this->load->view('pages/slidebar');
    echo Close('div');
    
    echo Open('div', array('class'=>'col-md-9'));//Div col-md-9
    
//        echo Open('div', '', array('class'=>'col-md-12'));
            $this->load->view('pages/pagination');
//        echo Close('div');

    //==========================block view

        echo Open('div', array('class' => 'tab-pane active', 'id' => 'blockView'));
            echo Open('ul', array('class' => 'thumbnails'), '');

                if (!empty($productos)) {

                    $arreglo = $productos;

                    foreach ($arreglo as $prod) {
                        $imagencargar = 'http://186.5.31.52/maskarade/' . $prod->cod_sup . '.jpg';

                        $imagenbloc = tagcontent('img', '', array('src' => $imagencargar, 'alt' => '', 'style' => 'height:140px;width:140px;margin: auto;', 'class' => 'thumbnail'));
                        echo Open('div', array('class' => 'col-md-3 pull-left', 'style' => 'min-height:200px;overflow:hidden'));
                        echo Open('div', array('class' => 'thumbnail text-center'));
                        echo tagcontent('a', $imagenbloc, array('href' => base_url('product_detail/open_traje/' . $prod->codigo2)));
                        echo Open('div', array('class' => 'caption', 'style' => 'text-align:center;'));
                        echo tagcontent('p', strstr($prod->nombreUnico, ' ', true), array('style' => 'font-size:7pt'));

                        echo Close('div');
                        echo Close('div');

                        echo Close('div');
                    }//end foreach
                } 
            echo Close('ul');
        echo Close('div'); 
       
    //==========================Close block view

        echo lineBreak2(1, array('class' => 'clr'));
//        echo tagcontent('div', '', array('class'=>'col-md-12'));
//        echo Open('div', '', array('class'=>'col-md-12'));
            $this->load->view('pages/pagination');
//        echo Close('div');
        
    echo Close('div'); //Close div col-md-9
echo Close('div'); //close div tab-content
    
//=====================================================
    
