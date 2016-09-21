<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//comprobar las peticiones ajax para evitar accesos
    function peticion_ajax() {
        
        //si no es una petición ajax mostramos un error 404
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            echo 'hola';
            //en otro caso procesamos la petición
            
        }
        
    }
    
    function get_settings($id){
        $ci =& get_instance();
        $val = $ci->generic_model->get_val('bill_settings', $id, 'valor', 'variable');
        return $val;
    }
    
    function get_info($id){
        $ci =& get_instance();
        $val = $ci->generic_model->get_val('bill_empre_info', $id, 'content', 'variable');
        return $val;
    }
    
    /* Reemplaza los caracteres no permitidos por un espacio */
    function clear_string($arreglo)
    {
        $caracteres_prohibidos = array("'","/","<",">",";",'\"');    
        return str_replace($caracteres_prohibidos," ",$arreglo);
    }    
    
    
    /* acortar frase o palabra*/
    function get_short_string($palabra , $cantidadDeseada , $porDelante = false)
    {
            $sufijo = "...";
            if(strlen($palabra)>$cantidadDeseada)
            {
                    if($porDelante)
                    {
                            return $sufijo.substr($palabra,strlen($palabra)-$cantidadDeseada,strlen($palabra)-1);
                    }
                    else
                    {
                            return substr($palabra,0,$cantidadDeseada-strlen($sufijo)).$sufijo;
                    }
            }
            else
            {
                    return $palabra;
            }
    }
    
    function get_relative_time($timestamp)
    {
            $diferencia = time() - $timestamp;
            if($diferencia > 0)
            {
                    $periodo = array("seg", "min", "hora", "dia", "semana", "mes" , "año", "decada");
                    $longitud = array(    "60" ,"60"  , "24" ,  "7"  , "4.35",   "12" , "10" );

                    for($j = 0; $diferencia >= $longitud[$j]; $j++)
                            $diferencia /= $longitud[$j];

                    $diferencia = round($diferencia);

                    if($diferencia != 1)
                    {
                            if($periodo[$j] == "mes")
                                    $periodo[$j].= "es";
                            else
                                    $periodo[$j].= "s";
                    }

                    return "Hace ".$diferencia." ".$periodo[$j];
            }
            else
            {
                    return "Ahora mismo";
            }
    }
    
    function count_words($string) 
    {
        $word_count = 0; 
        $string = eregi_replace(" +", " ", $string); 
        $string = eregi_replace("\n+", " ", $string); 
        $string = eregi_replace(" +", " ", $string); 
        $string = explode(" ", $string); 
     
        while (list(, $word) = each ($string)) { 
            if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $word)) { 
                $word_count++; 
            } 
        } 
         
        return $word_count; 
         
    } // end func am_countWords   
    
    function redondear_hora($hora){
        $sep = explode(':', $hora);
        $minutos=$sep[1];
        $hora1=$sep[0];
        if($minutos>0){
            $hora = $hora1.':15:00';  // sin minutos
        }
        if($minutos>15){
            $hora = $hora1.':30:00';  // sin minutos
        }
        if($minutos>30){
            $hora = $hora1.':45:00';  // sin minutos
        }
        if($minutos > 45){
            $hora1 = $hora1+1;
            $hora = $hora1.':00:00';  // sin minutos
        }
        return $hora;  // sin minutos
    } 
    
    function get_parte_hora( $hora ){
        $horaSplit = explode(":", $hora);
            if( count($horaSplit) < 3 ){
                $horaSplit[2] = 0;
            }
        return $horaSplit;
    }


    function sumar_horas( $time1, $time2 ){
        list($hour1, $min1, $sec1) = parteHora($time1);
        list($hour2, $min2, $sec2) = parteHora($time2);
        return date('H:i:s', mktime( $hour1 + $hour2, $min1 + $min2, $sec1 + $sec2));
    }
    
    /* Formato de decimales a usar */
    function number_decimal($number){
        $number = (double)$number;
        return number_format($number, get_settings('NUM_DECIMALES'), '.', '');
    }
    
    /* Obtene el valor de una celda de excel */
    function get_value_xls($PHPExcel,$col,$row){
        $res = $PHPExcel->getActiveSheet()->getCellByColumnAndRow($col,$row)->getCalculatedValue();
        return $res;
    }
    
    function sum_array($array_val) {
        $tot_sum = 0;
            if( $array_val ){
                foreach ( $array_val as $val ) {
                    if( $val <= 0 ){ continue; }
                    $tot_sum += $val;
                }            
            }
        return number_decimal($tot_sum);
    }