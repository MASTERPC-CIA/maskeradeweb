<?php

/**
 * Description of products_search
 *
 * @author MARIUXI
 */
class products_search extends CI_Controller {

    private $list_fest_by_sexo;
    private $list_fest_by_search;

    public function __construct() {
        parent::__construct();
        $this->load->model('productos_model');
        $this->load->library('superproducto');
        $this->list_fest_by_sexo = array();
        $this->list_fest_by_search = array();
    }

    public function get_product_by_name() {

        $texto = trim($this->input->post('product_name_autosug'));
        if (!empty($texto)) {
            $texto = strtoupper($texto);
            $fields = array('codigo', 'codigo2', 'nombreUnico', 'descripcion', 'stockactual', 'productogrupo_codigo', 'pvppromo', 'finpvppromo', 'marca_id');
            $where_data = array('nombreUnico like ' => "%" . $texto . "%", 'esSuperproducto' => '1');
            $all_product = $this->generic_model->get('billing_producto', $where_data, $fields);

            $datac['temas'] = $this->get_festividades_busc($texto);
            $datac['tallas'] = $this->get_tallas_prods_busc($texto);
            $datac['precios_l1'] = $this->get_max_min_precio_local1_busc($texto);
            $datac['precios_l2'] = $this->get_max_min_precio_local2_busc($texto);

            if ($all_product) {
                foreach ($all_product as $value) {
                    $join_cluase['0'] = array('table' => 'bill_impuestotarifa it', 'condition' => 'it.id=pt.impuestotarifa_id');
                    $imp = $this->generic_model->get_join('bill_productoimpuestotarifa pt', array('pt.producto_id' => $value->codigo), $join_cluase, 'it.tarporcent', 1, null);

                    $value->precio_alq1 = $value->pvppromo + ($value->pvppromo * ($imp->tarporcent / 100));
                    $value->precio_alq2 = $value->finpvppromo + ($value->finpvppromo * ($imp->tarporcent / 100));
                }
            }

            $datac['total_art'] = sizeof($all_product); /* Almacena el total de articulos */
            $datac["productos"] = $all_product;
            $datac['producto_nombre'] = array();
            $datac["idgrupo"] = '';
            $datac['name_prod'] = '';

            $res['view'] = $this->load->view('products/content', $datac, TRUE);
            $res['title'] = 'Disfraces ';
            $this->load->view('templates/dashboard', $res);
        } else {
            echo info_msg('Debe escribir el nombre o parte del mismo para proceder a realizar la busqueda.', '18px');
        }
    }

    /* Se busca el precio màximo y minimo de alquiler del local 1, pero en base al nombre del producto */

    public function get_max_min_precio_local1_busc($name_text) {
        $fields = 'MAX(pvppromo) max_l1, MIN(pvppromo) min_l1';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'nombreUnico like ' => '%' . $name_text . '%');
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields);
        $send = array();
        if ($res) {
            $send['max1'] = number_decimal($res[0]->max_l1 + ($res[0]->max_l1 * (get_settings('IVA') / 100)));
            $send['min1'] = number_decimal($res[0]->min_l1 + ($res[0]->min_l1 * (get_settings('IVA') / 100)));
        }

        return $send;
    }

    /* Se busca el precio màximo y minimo de alquiler del local 2, pero en base al nombre del producto */

    public function get_max_min_precio_local2_busc($name_text) {
        $fields = 'MAX(finpvppromo) max_l2, MIN(finpvppromo) min_l2';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'nombreUnico like' => $name_text);

        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields);
        $send = array();
        if ($res) {
            $send['max2'] = $res[0]->max_l2 + ($res[0]->max_l2 * (get_settings('IVA') / 100));
            $send['min2'] = $res[0]->min_l2 + ($res[0]->min_l2 * (get_settings('IVA') / 100));
        }

        return $send;
    }

    /* Se utiliza para encontrar las tallas de los productos que cumplan con la condición del nombre del producto */

    public function get_tallas_prods_busc($name_text) {
        $fields = 'DISTINCT(bp.talla) talla';
        $where_data = array('talla <>' => null, 'esSuperproducto' => '1', 'estado' => '1', 'nombreUnico like' => '%' . $name_text . '%');
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields);
        return $res;
    }

    public function get_festividades_busc($name_text) {
        $fields1 = 'DISTINCT(festiv1) festiv1';
        $fields2 = 'DISTINCT(festiv2) festiv2';
        $fields3 = 'DISTINCT(festiv3) festiv3';
        $where = array('esSuperproducto' => 1, 'estado' => 1, 'nombreUnico like' => '%' . $name_text . '%');

        $result1 = $this->generic_model->get('billing_producto', $where, $fields1);
        $result2 = $this->generic_model->get('billing_producto', $where, $fields2);
        $result3 = $this->generic_model->get('billing_producto', $where, $fields3);

        if ($result1) {
            foreach ($result1 as $value) {
                if (!$this->existe_festividad_busc($value->festiv1) && !empty($value->festiv1)) {
                    array_push($this->list_fest_by_search, $value->festiv1);
                }
            }
        }
        if ($result2) {
            foreach ($result2 as $value) {
                if (!$this->existe_festividad_busc($value->festiv2) && !empty($value->festiv2)) {
                    array_push($this->list_fest_by_search, $value->festiv2);
                }
            }
        }
        if ($result3) {
            foreach ($result3 as $value) {
                if (!$this->existe_festividad_busc($value->festiv3) && !empty($value->festiv3)) {
                    array_push($this->list_fest_by_search, $value->festiv3);
                }
            }
        }

        return $this->get_fest_subcategorias_busc();
    }

    public function get_fest_subcategorias_busc() {
        $list_fest = array();
        if ($this->list_fest_by_search) {
            $cont_fest = 0;
            foreach ($this->list_fest_by_search as $key => $value) {
                $list_fest[$cont_fest] = (Object) array('festividad' => $value, 'lista_marcas' => $this->get_subcategoria_by_fest($value));
                $cont_fest++;
            }
        }
        return $list_fest;
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

}
