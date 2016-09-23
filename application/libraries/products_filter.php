<?php

/**
 * Description of products_filter
 *
 * @author MARIUXI
 */
class products_filter {

    private $ci;

    public function __construct() {
        $this->ci = & get_instance();
    }

    //Permite obtener la lista de los trajes que cumplen con el filtro de busqueda por  festividad
    public function get_trajes_opc_fest($products, $festivs) {
        $res_prod_by_festiv = array();
        if ($products && $festivs) {
            foreach ($products as $prod) {
                if ($this->verificar_pert_festi($prod, $festivs)) {
                    array_push($res_prod_by_festiv, $prod);
                }
            }
        }
        return $res_prod_by_festiv;
    }

    public function verificar_pert_festi($prod_fest, $festivs) {
        $es_fest = false;
        $cont_fest = 0;
        while ($cont_fest < sizeof($festivs) && $es_fest == false) {
            if ($prod_fest == $festivs[$cont_fest] || $prod_fest == $festivs[$cont_fest] || $prod_fest == $festivs[$cont_fest]) {
                $es_fest = true;
            }
            $cont_fest++;
        }
        return $es_fest;
    }

    //Permite obtener la lista de los trajes que cumplen con el filtro de busqueda por subcategoria
    public function get_trajes_opc_subcateg($products, $sub_categs) {
        //Para filtrar por subcategorias
        $res_prods_by_subcateg = array();
        if ($products && $sub_categs) {
            foreach ($products as $prod) {
                if ($this->verificar_pert_marca($prod, $sub_categs)) {
                    array_push($res_prods_by_subcateg, $prod);
                }
            }
        }
    }

    public function verificar_pert_marca($prod_sub, $subcategs) {
        $es_sub = false;
        $cont_sub = 0;
        while ($cont_sub < sizeof($subcategs) && $es_sub == false) {
            if ($prod_sub->marca_id == $subcategs[$cont_sub]) {
                $es_sub = true;
            }
            $cont_sub++;
        }
        return $es_sub;
    }

    //Para obtener todos los productos que cumplen con la condicion de la talla en los productos
    public function get_prods_by_talla($products, $tallas) {
        //Para filtrar por tallas los productos
        $res_prods_by_talla = array();
        if ($products && $tallas) {
            foreach ($products as $prod) {
                if ($this->verificar_pert_talla($prod, $tallas)) {
                    array_push($res_prods_by_talla, $prod);
                }
            }
        }
    }

    public function verificar_pert_talla($prod_talla, $tallas) {
        $es_talla = false;
        $cont_talla = 0;
        while ($cont_talla < sizeof($tallas) && $es_talla == false) {
            if ($prod_talla->marca_id == $tallas[$cont_talla]) {
                $es_talla = true;
            }
            $cont_talla++;
        }
        return $es_talla;
    }

    //Para obtener todos lo productos que cumplen con la conicion del precio en los productos
    public function get_prods_by_precio($products, $precio_max_l1, $precio_min_l1, $precio_max_l2, $precio_min_l2) {
        $res_prods_by_precio = array();
        if ($products) {
            foreach ($products as $prod) {
                if (($prod->pvppromo >= $precio_min_l1 && $prod->pvppromo <= $precio_max_l1) || ($prod->finpvppromo >= $precio_min_l2 && $prod->finpvppromo <= $precio_max_l2)) {
                    array_push($res_prods_by_precio, $prod);
                }
            }
        }
        return $res_prods_by_precio;
    }

}
