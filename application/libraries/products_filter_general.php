<?php

/**
 * Description of products_filter_general
 *
 * @author MARIUXI
 */
class products_filter_general {

    private $ci;

    public function __construct() {
        $this->ci= & get_instance();
        $this->ci->load->library('');
    }
    
    public function get_prods_by_all_filter($fest, $marcas, $talla, $precio, $precio2){
        if($fest){
            $prods_by_fest = $this->products_filter->verificar_pert_festi($prod_fest, $festivs);
        }
    }

}
