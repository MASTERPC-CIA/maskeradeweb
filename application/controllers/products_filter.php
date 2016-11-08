<?php

/**
 * Description of products_filter
 *
 * @author MARIUXI
 */
class products_filter extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

//    public function get_prods_filter_by_fest($prods=null, $fest='') {
    public function get_prods_filter_by_fest($prods, $fest) {
        $new_prods = array();
        if ($prods) {
            foreach ($prods as $value) {
                if ($prods->festiv1 == $fest || $prods->festiv2 == $fest || $prods->festiv3 == $fest) {
                    array_push($new_prods, $value);
                }
            }
        }
        return $new_prods;
    }

    public function get_prods_filter_by_marca($prods, $marca_id) {
        $new_prods = array();
        if ($prods) {
            foreach ($prods as $value) {
                if ($value->marca_id == $marca_id) {
                    array_push($new_prods, $value);
                }
            }
        }
        return $new_prods;
    }

    public function get_prods_filter_by_talla($prods, $talla) {
        $new_prods = array();
        if ($prods) {
            foreach ($prods as $value) {
                if ($value->talla = $talla) {
                    array_push($new_prods, $value);
                }
            }
        }
        return $new_prods;
    }

    public function get_prods_filter_by_precio($prods, $precio) {
        $new_prods = array();
        if ($prods) {
            foreach ($prods as $value) {
                if (($value->pvppromo >= $precio && $value->pvppromo <= $precio) || ($value->finpvppromo >= $precio && $value->finpvppromo <= $precio)) {
                    array_push($new_prods, $value);
                }
            }
        }
        return $new_prods;
    }

    function get_canton() {
        if (isset($_POST['cod'])) {
            $where_data = array('p.codigoProv' => $_POST['cod']);
            $join_cluase = array(
                '0' => array('table' => 'bill_provincia p', 'condition' => 'c.bill_provincia_idProvincia = p.idProvincia')
            );
            $res1 = $this->generic_model->get_join('bill_canton c', $where_data, $join_cluase, $fields = '*');
            echo json_encode($res1);
        }
    }

}
