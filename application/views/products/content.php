<?php

echo tagcontent('div', '', array('id'=>'res_info','class'=>'col-md-12'));

echo Open('div', array('class'=>'col-md-12', 'id'=>'secundaria'));
    
    echo Open('div', array('id'=>'sec_bq_sidebar', 'class'=>'col-md-3'));
        $this->load->view('pages/slidebar');
    echo Close('div');

    echo Open('div', array('id'=>'sec_bq_result_search','class'=>'col-md-9'));
        $this->load->view('pages/pagination');
        echo Open('div',array('class'=>'col-md-12 tab-content', 'id'=>'view_catalog'));
        
    //==========================block view
            echo Open('div',array('class'=>'tab-pane active','id'=>'blockView'));
                echo Open('ul',array('class'=>'thumbnails'),'');

                if(!empty($productos /* || $producto_nombre*/)){
    //                if(empty($productos)){
    //                    $arreglo = $producto_nombre;
    //                }else{
                        $arreglo = $productos;
    //                }
                    foreach ($arreglo as $prod){
                        //$imagencargar = '';
                        $imagencargar = 'https://googledrive.com/host/0B3RoUpwSItgLfkU3bzRPS005MzhqU0dEaTdFNlJ6eWdaTXE4RGVqbUNGc1YwcnE4U2MxOUU/'.$prod->codigo2.'.jpg'; 
                            $imagenbloc = tagcontent('img', '', array('src' => $imagencargar, 'alt' => $prod->codigo2, 'style' => 'height:140px;width:140px;margin: auto;','class'=>'thumbnail'));
                            echo Open('div',array('class'=>'col-md-3 pull-left', 'style'=>'min-height:200px;overflow:hidden'));
                                echo Open('div',array('class'=>'thumbnail text-center'));
                                    echo tagcontent('a',$imagenbloc ,array('href'=>  base_url('product_detail/get_detalle_product?codigo2='.$prod->codigo2)));
                                    echo Open('div',array('class'=>'caption','style'=>'text-align:center;'));
                                        echo tagcontent('p',$prod->codigo2.' - '.get_short_string($prod->nombreUnico , 50 , false),array('style'=>'font-size:7pt'));
                                        echo tagcontent('div','P. Alq. Local 1: $'.number_decimal($prod->precio_alq1),array('style'=>'font-size:9pt','id'=>'precio','alt'=>  number_decimal($prod->precio_alq1)));
                                        echo tagcontent('div','P. Alq. Local 2: $'.number_decimal($prod->precio_alq2),array('style'=>'font-size:9pt','id'=>'precio','alt'=>  number_decimal($prod->precio_alq2)));                                
                                    echo Close('div');
                                echo Close('div');
                        //    $lipro = tagcontent('li',$divtub);
                            echo Close('div');
    //                    }//fin if precios
                    }//end foreach
                }else{
    //                $msj = ' con el nombre: '.$nombre_no_encontrado;
    //                echo no_results_msg($msj);
                }
                echo Close('ul');
            echo Close('div');//close div bloc-view
    //        //---------------------------------
            echo lineBreak2(1, array('class'=>'clr'));
           
        echo Close('div');//close div tab-content
        $this->load->view('pages/pagination');

        //=====================================================
    echo Close('div');
echo Close('div');