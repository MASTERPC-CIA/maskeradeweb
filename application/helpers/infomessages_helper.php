<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    function error_msg($msg, $fontsize = '16px') {
        $output = tagcontent('div', '<span class="glyphicon glyphicon-remove-sign"></span> Error! No se ha podido completar el proceso'.$msg, array('class'=>'text-danger','style'=>'font-size:'.$fontsize.';font-weight: bold'));
        return $output;
    }
    
    function success_msg($msg, $fontsize = '16px') {
        $output = tagcontent('div', '<span class="glyphicon glyphicon-ok-sign"></span> El proceso se ha completado correctamente'.$msg, array('class'=>'text-success','style'=>'font-size:'.$fontsize.';font-weight: bold'));
        return $output;
    }
    
    function no_results_msg($msg, $fontsize = '16px') {
        $output = tagcontent('div', '<span class="glyphicon glyphicon-ok-sign"></span> No se encontraron resultados'.$msg, array('class'=>'text-warning','style'=>'font-size:'.$fontsize.';font-weight: bold'));
        return $output;
    }
    
    function info_msg($msg, $fontsize = '16px') {
        $output = tagcontent('div', '<span class="glyphicon glyphicon-info-sign"></span><strong>Atenci&oacute;n: </strong>'.$msg, array('class'=>'text-info','style'=>'font-size:'.$fontsize.';font-weight: bold'));
        return $output;
    }
        
    function validation_msg($msg, $fontsize = '16px') {
        $output = tagcontent('div', '<span class="glyphicon glyphicon-info-sign"></span><strong>Atenci&oacute;n: </strong>'.$msg, array('class'=>'text-warning','style'=>'font-size:'.$fontsize.';font-weight: bold'));
        return $output;
    }
    
    function warning_msg($msg, $fontsize = '16px') {
        $output = tagcontent('div', '<span class="glyphicon glyphicon-info-sign"></span><strong>Atenci&oacute;n: </strong>'.$msg, array('class'=>'text-warning','style'=>'font-size:'.$fontsize.';font-weight: bold'));
        return $output;
    }
    
    function error_info_msg($msg, $fontsize = '16px') {
        $output = tagcontent('div', '<span class="glyphicon glyphicon-info-sign"></span><strong>Atenci&oacute;n: </strong>'.$msg, array('class'=>'text-danger','style'=>'font-size:'.$fontsize.';font-weight: bold'));
        return $output;
    }
    
    function success_info_msg($msg, $fontsize) {
        $output = tagcontent('div', '<span class="glyphicon glyphicon-info-sign"></span><strong>Atenci&oacute;n: </strong>'.$msg, array('class'=>'text-success','style'=>'font-size:'.$fontsize.';font-weight: bold'));
        return $output;
    }
    
