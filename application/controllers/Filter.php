<?php

/**
 * Description of products_filter
 *
 * @author MARIUXI
 */
class Filter extends CI_Controller {

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

    public function get_productos_get_fest() {
        $opc_busq = $this->input->post('busq_opcion');
        $desde_busq = $this->input->post('busq_desde');
        $festividades = $this->input->post('selected_fest');
        if ($desde_busq == 'BUSCADOR') {
            $this->buscar_por_nombre($opc_busq, $festividades);
        } elseif ($desde_busq == 'MENU') {
            $this->buscar_por_genero($opc_busq, $festividades);
        }
    }

    public function buscar_por_nombre($opc_busq, $festividades) {

        $fields = '*, SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2) - 2) AS cod_sup';
        $order_by = array('p.codigo' => 'DESC');
        $group_by = 'SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2)-2)';
        $nuevos_productos = array();
        if (sizeof($festividades) == 1) {
            $where_data = array('nombreUnico like ' => '%' . $opc_busq . '%', 'esSuperproducto' => 1, '(festiv1 ="' . $festividades[0] . '" or festiv2 ="' . $festividades[0] . '" or festiv3="' . $festividades[0] . '")' => NULL);
            $products = $this->generic_model->get('billing_producto p', $where_data, $fields, $order_by, 0, null, null, $group_by);
            $nuevos_productos = $products;
        } else {
            $cont = 1;
            foreach ($festividades as $value) {
                $where_data = array('nombreUnico like ' => '%' . $opc_busq . '%', 'esSuperproducto' => 1, '(festiv1 ="' . $festividades[0] . '" or festiv2 ="' . $festividades[0] . '" or festiv3="' . $festividades[0] . '")' => NULL);
                $products = $this->generic_model->get('billing_producto p', $where_data, $fields, $order_by, 0, null, null, $group_by);
                if ($products) {
                    foreach ($products as $val) {
                        array_push($nuevos_productos, $val);
                    }
                }
                $cont++;
            }
        }
        $data['productos'] = $nuevos_productos;
        $data['total_art'] = sizeof($nuevos_productos);
        return $data;
    }

    public function buscar_por_genero($opc_busq, $festividades) {

        $fields = '*, SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2) - 2) AS cod_sup';
        $order_by = array('p.codigo' => 'DESC');
        $group_by = 'SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2)-2)';
        $nuevos_productos = array();
        if (sizeof($festividades) == 1) {
            $where_data = array('esSuperproducto' => 1, '(sexo1 ="' . $opc_busq . '" or sexo2 ="' . $opc_busq . '" or sexo3="' . $opc_busq . '")' => NULL, '(festiv1 ="' . $festividades[0] . '" or festiv2 ="' . $festividades[0] . '" or festiv3="' . $festividades[0] . '")' => NULL);
            $products = $this->generic_model->get('billing_producto p', $where_data, $fields, $order_by, 0, null, null, $group_by);
            $nuevos_productos = $products;
        } else {
            foreach ($festividades as $value) {
                $where_data = array('esSuperproducto' => 1, '(sexo1 ="' . $opc_busq . '" or sexo2 ="' . $opc_busq . '" or sexo3="' . $opc_busq . '")' => NULL, '(festiv1 ="' . $value . '" or festiv2 ="' . $value . '" or festiv3="' . $value . '")' => NULL);
                $products = $this->generic_model->get('billing_producto p', $where_data, $fields, $order_by, 0, null, null, $group_by);
                if ($products) {
                    foreach ($products as $val) {
                        array_push($nuevos_productos, $val);
                    }
                }
            }
        }
        $data['productos'] = $nuevos_productos;
        $data['total_art'] = sizeof($nuevos_productos);
        return $data;
    }

    public function get_productos_all_filter() {

        $opc_busq = $this->input->post('busq_opcion');
        $desde_busq = $this->input->post('busq_desde');
        $festiv = $this->input->post('selected_fest');
        $marcas = $this->input->post('selected_marcas');
        $tallas = $this->input->post('selected_tallas');
        $precio = $this->input->post('precio_alq');
        $cant_prod= $this->input->post('cant_art');
        $orden_por= $this->input->post('ordenar_por');
        $tipo_orden = $this->input->post('tipo_orden');

        if ($desde_busq == 'BUSCADOR') {
            $products = $this->get_productos_all_filter_by_name($opc_busq);
        } elseif ($desde_busq == 'MENU') {
            $products = $this->get_productos_all_filter_by_sexo($opc_busq);
        }

        if ($festiv) {
            $products = $this->get_prods_all_filter_by_fest($products, $festiv);
        }

        if ($marcas) {
            $products = $this->get_prods_all_filter_by_marca($products, $marcas);
        }

        if ($tallas) {
            $products = $this->get_prods_all_filter_by_talla($products, $tallas);
        }

        if (!empty($precio)) {
            $products = $this->get_prods_all_filter_by_precio($products, $precio);
        }
        
        $data['productos'] = $products;
        $data['total_art'] = sizeof($products);

        echo 'Cantidad de productos ' . sizeof($products).' ';
        print_r($products);
    }

    public function get_productos_all_filter_by_name($opc_busq) {

        $fields = '*, SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2) - 2) AS cod_sup';
        $order_by = array('p.codigo' => 'DESC');
        $group_by = 'SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2)-2)';

        $where_data = array('nombreUnico like ' => '%' . $opc_busq . '%', 'esSuperproducto' => 1);
        $products = $this->generic_model->get('billing_producto p', $where_data, $fields, $order_by, 0, null, null, $group_by);
        return $products;
    }

    public function get_productos_all_filter_by_sexo($opc_busq) {

        $fields = '*, SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2) - 2) AS cod_sup';
        $order_by = array('p.codigo' => 'DESC');
        $group_by = 'SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2)-2)';

        $where_data = array('esSuperproducto' => 1, '(sexo1 ="' . $opc_busq . '" or sexo2 ="' . $opc_busq . '" or sexo3="' . $opc_busq . '")' => NULL);
        $products = $this->generic_model->get('billing_producto p', $where_data, $fields, $order_by, 0, null, null, $group_by);
        return $products;
    }

    public function get_prods_all_filter_by_fest($products, $festiv) {

        $new_products = array();

        foreach ($products as $value) {
            $cont = 0;
            $pertenece_fest = false;
            while ($cont < sizeof($festiv) && $pertenece_fest == false) {
                if ($value->festiv1 == $festiv[$cont] || $value->festiv2 == $festiv[$cont] || $value->festiv3 == $festiv[$cont]) {
                    array_push($new_products, $value);
                    $pertenece_fest = true;
                }
                $cont++;
            }
        }
        return $new_products;
    }

    public function get_prods_all_filter_by_marca($products, $marcas) {
        $new_products = array();

        foreach ($products as $value) {
            $cont = 0;
            $pertenece_marca = false;
            while ($cont < sizeof($marcas) && $pertenece_marca == false) {
                if ($value->marca_id == $marcas[$cont]) {
                    array_push($new_products, $value);
                    $pertenece_marca = true;
                }
                $cont++;
            }
        }
        return $new_products;
    }

    public function get_prods_all_filter_by_talla($products, $tallas) {
        $new_products = array();

        foreach ($products as $value) {
            $cont = 0;
            $pertenece_talla = false;
            while ($cont < sizeof($tallas) && $pertenece_talla == false) {
                if ($value->talla == $tallas[$cont]) {
                    array_push($new_products, $value);
                    $pertenece_talla = true;
                }
                $cont++;
            }
        }
        return $new_products;
    }

    public function get_prods_all_filter_by_precio($products, $precio) {
        $new_products = array();
        foreach ($products as $value) {
            if (($value->pvppromo >= $precio && $value->pvppromo <= $precio) || ($value->finpvppromo >= $precio && $value->finpvppromo <= $precio)) {
                array_push($new_products, $value);
            }
        }
        return $new_products;
    }

}
