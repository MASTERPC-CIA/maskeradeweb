<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of products_search
 *
 * @author MARIUXI
 */
class Products_search extends CI_Controller {

    private $list_fest_by_search;
    private $list_marcas_by_search;

    public function __construct() {

        parent::__construct();
        $this->load->model('productos_model');
        $this->load->library('superproducto');

        $this->list_fest_by_search = array();
        $this->list_marcas_by_search = array();
    }

    public function get_all_products_by_name() {

        $texto = trim($this->input->post('product_name_autosug'));

        if (!empty($texto)) {

            $texto = strtoupper($texto);

            $where_data = array('nombreUnico like ' => "%" . $texto . "%", 'esSuperproducto' => '1');

            //Desde existencias, para obtener los productos agrupados por código común

            $fields = '*, SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2) - 2) AS cod_sup';

            $join_cluase = array(
                '0' => array('table' => 'billing_productogrupo pg', 'condition' => 'p.productogrupo_codigo = pg.codigo and (p.esSuperproducto = 1)'),
            );

            $order_by = array('p.codigo' => 'DESC');
            $group_by = 'SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2)-2)';

            $all_product = $this->generic_model->get_join('billing_producto p', $where_data, $join_cluase, $fields, 0, $order_by, $group_by);

            $datac['total_art'] = sizeof($all_product); /* Almacena el total de articulos */
            $datac['temas'] = $this->get_festividades_busc($all_product);
            $datac['marcas'] = $this->get_marcas_busc($all_product);
            $datac['tallas'] = $this->get_tallas_prods_busc($texto);

            $datac['busq_opcion'] = $texto; //permite guardar el criterio de busqueda
            $datac['busq_desde'] = 'BUSCADOR'; //permite identificar el lugar desde el que se esta haciendo la busqueda

            $val_precio_min = $this->get_precio_min_local1_busc($texto);
            $val_precio_max = $this->get_precio_max_local2_busc($texto);

            if ($val_precio_min) {
                $datac['precio_min'] = number_decimal($val_precio_min->precio_min + ($val_precio_min->precio_min * get_settings('IVA') / 100));
            } else {
                $datac['precio_min'] = 0;
            }

            if ($val_precio_max) {
                $datac['precio_max'] = number_decimal($val_precio_max->precio_max + ($val_precio_max->precio_max * get_settings('IVA') / 100));
            } else {
                $datac['precio_max'] = 0;
            }
//            $new_text = $this->input->post('busq_opcion');
            /* productos que se veran segun la cantidad configurada por paginacion */
            $prods_pag = $this->productos_model->get_productos_by_name($texto, get_settings('SHOPPING_CART_PAG'), $this->uri->segment(4), '');
            /* total de productos que se cargaran para hacer la paginacion */
            $this->productos_model->paginacion_by_name(count($all_product), 'get_all_products_by_name/' . $texto, 4);

            //        detalle de los productos que se mostraran en la pagina
            if ($prods_pag) {
                $prod_view = $this->products_in_bod($prods_pag);
            } else {
                $prod_view = array();
            }

            $datac["productos"] = $prod_view;
            $datac['producto_nombre'] = array();
            $datac["idgrupo"] = '';
            $datac['name_prod'] = '';
            $datac['texto_name'] = $texto;

            $res['view'] = $this->load->view('products/content', $datac, TRUE);
            $res['title'] = 'Disfraces';
            $this->load->view('templates/dashboard', $res);
        } else {
            echo info_msg('Debe escribir el nombre o parte del mismo para proceder a realizar la busqueda.', '18px');
        }
    }

    /* Se utiliza para encontrar las tallas de los productos que cumplan con la condición del nombre del producto */

    public function get_tallas_prods_busc($name_text) {
        $fields = 'DISTINCT(bp.talla) talla';
        $where_data = array('talla <>' => null, 'esSuperproducto' => '1', 'estado' => '1', 'nombreUnico like' => '%' . $name_text . '%');
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields);
        return $res;
    }

    public function get_festividades_busc($products) {

        foreach ($products as $value) {

            if (!$this->existe_festividad_busc($value->festiv1) && !empty($value->festiv1)) {
                array_push($this->list_fest_by_search, $value->festiv1);
            }

            if (!$this->existe_festividad_busc($value->festiv2) && !empty($value->festiv2)) {
                array_push($this->list_fest_by_search, $value->festiv2);
            }

            if (!$this->existe_festividad_busc($value->festiv3) && !empty($value->festiv3)) {
                array_push($this->list_fest_by_search, $value->festiv3);
            }
        }

        return $this->list_fest_by_search;
    }

    public function get_marcas_busc($products) {

        foreach ($products as $value) {

            if (!$this->existe_marca_busc($value->marca_id)) {
                $marca = $this->generic_model->get('billing_marca', array('id' => $value->marca_id), '', null, 1);
                array_push($this->list_marcas_by_search, $marca);
            }
        }

        return $this->list_marcas_by_search;
    }

    public function existe_festividad_busc($fest) {
        $existe = false;
        $cont_fest = 0;
        while (!$existe && $cont_fest < sizeof($this->list_fest_by_search)) {
            if ($fest == $this->list_fest_by_search[$cont_fest]) {
                $existe = true;
            }
            $cont_fest++;
        }
        return $existe;
    }

    public function existe_marca_busc($marca) {
        $existe = false;
        $cont_marca = 0;
        while (!$existe && $cont_marca < sizeof($this->list_marcas_by_search)) {
            if ($marca == $this->list_marcas_by_search[$cont_marca]->id) {
                $existe = true;
            }
            $cont_marca++;
        }
        return $existe;
    }

//Obtiene el precio minimo, se toma como referencia el precio del local 1 ya que por lo general son precios menores
    public function get_precio_min_local1_busc($name_text) {

        $fields = 'MIN(pvppromo) precio_min';
        $where_data = array('esSuperproducto' => '1', 'nombreUnico like ' => '%' . $name_text . '%');
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 1);

        return $res;
    }

    public function get_precio_max_local2_busc($name_text) {
        $fields = 'MAX(finpvppromo) precio_max';
        $where_data = array('esSuperproducto' => '1', 'nombreUnico like' => '%' . $name_text . '%');

        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 1);
        return $res;
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
