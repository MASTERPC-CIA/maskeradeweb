<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * By Esteban Chamba J. , estyom.1@gmail.com , @estyom_1, (593)0997442533
 * 
 */

    function get_item_f1($num_items, $url, $title, $description='Mas Detalles', $icon='glyphicon glyphicon-certificate', $panel_class='small-box bg-aqua',$item_class='col-lg-3 col-xs-6') {
        echo '<div class="'.$item_class.'">';
          echo '<div class="'.$panel_class.'">';
            echo '<div class="inner">';
              echo '<h3>'.$num_items.'</h3>';
              echo '<p>'.$title.'</p>';
            echo '</div>';
            echo '<div class="icon">';
              echo '<i class="'.$icon.'"></i>';
            echo '</div>';
            echo '<a href="'.$url.'" class="small-box-footer">'.$description.'<i class="fa fa-arrow-circle-right"></i></a>';
          echo '</div>';
        echo '</div>';
    }

function get_item_view($num_items, $url, $title, $description='Ver Detalles', $icon='glyphicon glyphicon-certificate fa-5x', $panel_class='panel panel-primary',$item_class='col-lg-3 col-md-6') {
    $output = '';
    $output .= Open('div', array('class'=>$item_class));
        $output .= Open('div', array('class'=>$panel_class));
            $output .= Open('div', array('class'=>'panel-heading'));
                $output .= Open('div', array('class'=>'row'));
                    $output .= tagcontent('div', '<i class="'.$icon.'"></i>', array('class'=>'col-xs-3'));
                    $output .= tagcontent('div', '<div class="huge">'.$num_items.'</div><div>'.$title.'</div>', array('class'=>'col-xs-9 text-right'));
                $output .= Close('div');
            $output .= Close('div');
            
            $output .= Open('a', array('href'=>$url));
                $output .= Open('div', array('class'=>'panel-footer'));
                    $output .= tagcontent('span', $description, array('class'=>'pull-left'));
                    $output .= tagcontent('span', '<i class="fa fa-arrow-circle-right"></i>', array('class'=>'pull-right'));
                    $output .= tagcontent('div', '', array('class'=>'clearfix'));
                $output .= Close('div');
            $output .= Close('a');
        $output .= Close('div');
    $output .= Close('div');
    
    return $output;
}

function get_combo_group($label, $combo, $class = 'col-md-2 form-group'){
    $output = '';
    $output .= Open('div',array('class'=>$class));
        $output .= Open('div',array('class'=>'input-group'));
          $output .= tagcontent('span', $label, array('class'=>'input-group-addon'));
          $output .= $combo;
        $output .= Close('div');
    $output .= Close('div');    
    return $output;
}

function get_check_group($label_array, $checkbox_data, $label_attr){
    $output = '';
    $output .= Open('div',array('class'=>'btn-group','data-toggle'=>"buttons"));
        $cont = 0;
        foreach ($checkbox_data as $key => $value) {
            $input = input($value);
            $output .= tagcontent('label', $input.' '.$label_array[$cont], $label_attr[$cont]);
            $cont++;
        }
    $output .= Close('div');
    return $output;
}

function get_field_group($label, $text_inputs, $class = 'col-md-2 form-group') {
    $output = '';
        $output .= Open('div',array('class'=>$class));
            $output .= Open('div',array('class'=>'input-group'));
              $output .= tagcontent('span', $label, array('class'=>'input-group-addon'));
                foreach ($text_inputs as $attr_input) {
                  $output .= input($attr_input);                  
                }
            $output .= Close('div');
        $output .= Close('div');
    return $output; 
}

/*
 * Ejm de uso:
    $radio_attr = array(
        '0' => array('label'=>'Devulucion', "type"=>"radio", 'name'=>'tipo_ndc', 'active'=>'true'),
        '1' => array('label'=>'Descuento', "type"=>"radio", 'name'=>'tipo_ndc'),
    );
    echo get_radio_group($radio_attr);
 */
 
function get_radio_group($radio_attr){
    $output = '';
        $output .= '<div class="btn-group" data-toggle="buttons">';
            foreach ($radio_attr as $attr) {
                $active = '';
                if(!empty($attr['active'])){
                    $active = 'active';
                }
                $output .= '<label class="btn btn-primary btn-sm '.$active.'">';                
                    $output .= input($attr).$attr['label'];
                $output .= '</label>';                    
            }
        $output .= '</div>';
    return $output;
}