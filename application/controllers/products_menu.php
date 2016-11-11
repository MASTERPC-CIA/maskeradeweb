<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of products
 *
 * @author MARIUXI
 */
class Products_menu extends CI_Controller {

    private $list_fest_by_menu;
    private $list_marcas_by_menu;

    public function __construct() {
        parent::__construct();

        $this->load->model('productos_model');
        $this->load->library('superproducto');

        $this->list_fest_by_menu = array();
        $this->list_marcas_by_menu = array();
    }

    public function load_productos($opc) {

        if ($opc == 'Ninia') {
            $opc = 'Niña';
        }

        if ($opc == 'Ninio') {
            $opc = 'Niño';
        }

        /* consulta de todos los productos */
       
        $where_data = array('esSuperproducto' => 1, 'estado' => 1, '(sexo1 ="' . $opc . '" or sexo2 ="' . $opc. '" or sexo3="' . $opc. '")' => NULL);
        
        $fields = '*, SUBSTRING(codigo2,(1),LENGTH(codigo2) - 2) AS cod_sup';

        $order_by = array('codigo' => 'DESC');
        $group_by = 'SUBSTRING(codigo2,(1),LENGTH(codigo2)-2)';

        $all_product = $this->generic_model->get('billing_producto', $where_data, $fields, $order_by, 0, null, null, $group_by);

        /* productos que se veran segun la cantidad configurada por paginacion */
        $prods_pag = $this->productos_model->get_productos_by_menu($opc, get_settings('SHOPPING_CART_PAG'), $this->uri->segment(4), '');
        /* total de productos que se cargaran para hacer la paginacion */
        $this->productos_model->paginacion_by_menu(count($all_product), 'load_productos/'.$opc, 4);
        
//        detalle de los productos que se mostraran en la pagina
        if ($prods_pag) {
            $prod_view = $this->products_in_bod($prods_pag);
        } else {
            $prod_view = array();
        }

        $datac['total_art'] = sizeof($all_product); /* Almacena el total de articulos */
        $datac['temas'] = $this->get_festividades_by_menu($all_product);
        $datac['marcas'] = $this->get_marcas_by_menu($all_product);
        $datac['tallas'] = $this->get_tallas_prods($opc);

        $datac['busq_opcion'] = $opc; //permite guardar el criterio de busqueda
        $datac['busq_desde'] = 'MENU'; //permite identificar el lugar desde el que se esta haciendo la busqueda

        $val_precio_min = $this->get_min_precio_local1($opc);
        $val_precio_max = $this->get_max_precio_local2($opc);

        if ($val_precio_min) {
            $datac['precio_min'] = number_decimal($val_precio_min->min_l1 + ($val_precio_min->min_l1 * get_settings('IVA') / 100));
        } else {
            $datac['precio_min'] = 0;
        }

        if ($val_precio_max) {
            $datac['precio_max'] = number_decimal($val_precio_max->max_l2 + ($val_precio_max->max_l2 * get_settings('IVA') / 100));
        } else {
            $datac['precio_max'] = 0;
        }

        $datac["productos"] = $prod_view;
        $datac['producto_nombre'] = array();
        $datac["idgrupo"] = '';
        $datac['name_prod'] = '';

        $res['view'] = $this->load->view('products/content', $datac, TRUE);
        $res['title'] = 'Disfraces';
        $this->load->view('templates/dashboard', $res);
    }

    public function get_tallas_prods($opc) {
        $fields = 'DISTINCT(bp.talla) talla';
        $where_data = array('talla <>' => null, 'esSuperproducto' => '1', 'estado' => '1', 'sexo1 like' => $opc);
        $or_where = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 0, null, null, null, $or_where);
        return $res;
    }

    public function get_festividades_by_menu($products) {

        foreach ($products as $value) {

            if (!$this->existe_festividad_busc($value->festiv1) && !empty($value->festiv1)) {
                array_push($this->list_fest_by_menu, $value->festiv1);
            }

            if (!$this->existe_festividad_busc($value->festiv2) && !empty($value->festiv2)) {
                array_push($this->list_fest_by_menu, $value->festiv2);
            }

            if (!$this->existe_festividad_busc($value->festiv3) && !empty($value->festiv3)) {
                array_push($this->list_fest_by_menu, $value->festiv3);
            }
        }

        return $this->list_fest_by_menu;
    }

    public function get_marcas_by_menu($products) {
        foreach ($products as $value) {
            if (!$this->existe_marca_busc($value->marca_id)) {
                $marca = $this->generic_model->get('billing_marca', array('id' => $value->marca_id), '', null, 1);
                array_push($this->list_marcas_by_menu, $marca);
            }
        }

        return $this->list_marcas_by_menu;
    }

    public function get_min_precio_local1($opc) {
        $fields = 'MIN(pvppromo) min_l1';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'sexo1 like' => $opc);
        $or_where = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 1, null, null, null, $or_where);
        return $res;
    }

    public function get_max_precio_local2($opc) {
        $fields = 'MAX(finpvppromo) max_l2';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'sexo1 like' => $opc);
        $or_where = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 1, null, null, null, $or_where);
        return $res;
    }

    public function existe_festividad_busc($fest) {
        $existe = false;
        $cont_fest = 0;
        while (!$existe && $cont_fest < sizeof($this->list_fest_by_menu)) {
            if ($fest == $this->list_fest_by_menu[$cont_fest]) {
                $existe = true;
            }
            $cont_fest++;
        }
        return $existe;
    }

    public function existe_marca_busc($marca) {
        $existe = false;
        $cont_marca = 0;
        while (!$existe && $cont_marca < sizeof($this->list_marcas_by_menu)) {
            if ($marca == $this->list_marcas_by_menu[$cont_marca]->id) {
                $existe = true;
            }
            $cont_marca++;
        }
        return $existe;
    }

    private function products_in_bod($productos) {
        $prod = '';
        foreach ($productos as $key => $value) {
            $prod[$key] = (object) array(
                        'codigo' => $value->codigo,
                        'codigo2' => $value->codigo2,
                        'nombreUnico' => $value->nombreUnico,
                        'stockactual' => $value->stockactual,
                        'costopromediokardex' => $value->costopromediokardex,
                        'cod_sup' => $value->cod_sup
            );
        }
        return $prod;
    }

}
