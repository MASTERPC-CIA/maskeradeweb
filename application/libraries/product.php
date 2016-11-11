<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contaasientocontable
 *
 * @author estebanch
 */
class Product {

    private $ci;

    function __construct() {
        $this->ci = & get_instance();
    }

    /* El stock total del producto se encuentra directamente en la tabla billing_producto */

    public function get_stock($product_id) {
        $res = $this->ci->generic_model->get_val_where('billing_producto', array('codigo' => $product_id), 'stockactual', null, 0);
        return $res;
    }

    /* El stock dentro de la bodega */

    public function get_stock_disp_bodega($product_id) {
        $sum = 0;
        $res = $this->ci->generic_model->get_data('billing_stockbodega', array('producto_codigo' => $product_id), 'stock', null, 0);
        foreach ($res as $value) {
            $sum = $sum + $value->stock;
        }
        return $sum;
    }

    /* Obtiene el stock */

    public function get_stock_bodega($product_id) {
        $stock = $this->get_stock_disp_bodega($product_id);

        return $stock;
    }

    /* Obtiene el stock, restando las reservas */

    public function get_stock_disponible($product_id) {
        $stock = $this->get_stock($product_id);
        $reserva = $this->get_reserva($product_id);

        $stock_disp = $stock - $reserva;
        return $stock_disp;
    }

    /* obtenemos el stock total en reserva */

    public function get_reserva($product_id) {
        $tot_reservas = $this->ci->generic_model->sum_table_field('billing_stockbodega', 'reserva', array('producto_codigo' => $product_id));
        return $tot_reservas;
    }

    public function update_stock($product_id, $new_stock) {
//        echo 'codigo:'.$product_id, ' new_stock: '.$new_stock ;
        $res = $this->ci->generic_model->update(
                'billing_producto', array('stockactual' => $new_stock, 'fechaultactualizacion' => date('Y-m-d', time())), array('codigo' => $product_id)
        );
        return $res;
    }

    /* Obtenemos los costos : promedio */

    public function get_costo_promedio($product_id) {
        $res = $this->ci->generic_model->get_val_where('billing_producto', array('codigo' => $product_id), 'costopromediokardex', null, 0);
        return $res;
    }

    /* Obtenemos los costos : ultimo */

    public function get_costo_ultimo($product_id) {
        $res = $this->ci->generic_model->get_val_where('billing_producto', array('codigo' => $product_id), 'costoultimokardex', null, 0);
        return $res;
    }

    /*
     *      Actualizamos los costos a partir de los cuales se calcula el pvp
     */

    public function update_costos($product_id, $costo_prom, $costo_ult) {
        $res = $this->ci->generic_model->update(
                'billing_producto', array(
            'costopromediokardex' => $costo_prom,
            'costoultimokardex' => $costo_ult,
            'fechaultactualizacion' => date('Y-m-d', time())
                ), array('codigo' => $product_id)
        );
        return $res;
    }

    /* Obtenemos el costo de inventario por producto */

    public function get_costo_inventario($product_id) {
        $res = $this->ci->generic_model->get_val_where('billing_producto', array('codigo' => $product_id), 'costo_inventario', null, 0);
        return $res;
    }

    /* El total del costo de lo que tenemos invertido por producto */

    public function update_costo_inventario($product_id, $new_costo_inventario) {
        $res = $this->ci->generic_model->update(
                'billing_producto', array(
            'costo_inventario' => $new_costo_inventario,
            'fechaultactualizacion' => date('Y-m-d', time())
                ), array('codigo' => $product_id)
        );
        return $res;
    }

    /* funcion para cragar los precios desde el inventario */

    public function get_precio_prod($item_id, $price_tipo, $iva = 1) {
        $fields = 'p.codigo, p.stockactual, p.costopromediokardex, p.costoultimokardex, p.ajuste1, p.ajuste2, p.productogrupo_codigo grupo_id, p.descmaxporcent descmaxporcent, gp.utilidad utilidad, p.pvppromo,p.finpvppromo,pit.impuestotarifa_id impuesto';
        $join_cluase = array(
            '0' => array('table' => 'bill_grupoprecio gp', 'condition' => 'gp.productogrupo_id = p.productogrupo_codigo AND gp.tiposprecio_id = "' . $price_tipo . '"', 'type' => 'left'),
            '1' => array('table' => 'bill_productoimpuestotarifa pit', 'condition' => 'pit.producto_id = p.codigo'),
        );
        $where_data = array('p.codigo' => $item_id);
        $p = $this->ci->generic_model->get_join('billing_producto p', $where_data, $join_cluase, $fields, 1, null, null);

        $utilidadventaprod = get_settings('DEFAULT_UTILIDAD');
        if (!empty($p->utilidad)) {
            $utilidadventaprod = $p->utilidad;
        }
        $precioprod = 0;
        $tipospvp = $this->ci->generic_model->get('producto_precio', array('id_producto' => $item_id), 'id_precio,valor,id_tipo');
        if($tipospvp){
            $precioprod = $this->cargar_tipos_pvp($price_tipo,$tipospvp);
        }
        if($precioprod == 0){
            if ($p->pvppromo > 0 and $price_tipo == 'pA') {
                $precioprod = $p->pvppromo;
            } elseif ($p->finpvppromo > 0 and $price_tipo == 'pB') {
                $precioprod = $p->finpvppromo;
            } else {
                $precioprod = $p->costopromediokardex + $p->ajuste1 + $p->ajuste2 + ( ($p->costopromediokardex + $p->ajuste1 + $p->ajuste2) * $utilidadventaprod ) / 100;
            }
        }
        if ($iva == 1 and $p->impuesto == 2) {
            $iva_porcent = get_settings('IVA');
        } else {
            $iva_porcent = 0;
        }
        $precioprod_iva = $precioprod + ( $precioprod * $iva_porcent ) / 100;

        $fconv = $this->ci->generic_model->get_val_where('billing_productogrupo', array('codigo' => $p->grupo_id), 'prodgp_factor_conv', null, 1);
        if (get_settings("HM_CUENCA") == 1 OR get_settings("HOSPITAL_MILITAR") == 1) {
            $precio_minimo = $precioprod * $fconv;
        } else {
            $precio_minimo = $precioprod;
        }

        if ($p->descmaxporcent > 0) {
            $val_division_desc = ($p->descmaxporcent / 100) + 1;
            $desc_prod = $precioprod - ($precioprod / $val_division_desc);
            $precio_minimo = $precioprod - $desc_prod;
        }
        $precios_prod = array('price' => $precioprod, 'price_min' => $precio_minimo, 'price_iva' => $precioprod_iva);

        return $precios_prod;
    }

    public function get_product_data($product_id) {
        $fields = 'codigo, costopromediokardex, costoultimokardex, esServicio';
        $product_data = $this->ci->generic_model->get_data(
                'billing_producto', array('codigo' => $product_id), $fields, null, 1
        );
        return $product_data;
    }

    public function get_precio_prod_change($item_id, $price_tipo) {
        $fields = 'p.codigo, p.stockactual, p.costopromediokardex, p.costoultimokardex, p.ajuste1, p.ajuste2, p.productogrupo_codigo grupo_id, p.descmaxporcent descmaxporcent, gp.utilidad utilidad';
        $join_cluase = array(
            '0' => array('table' => 'bill_grupoprecio gp', 'condition' => 'gp.productogrupo_id = p.productogrupo_codigo AND gp.tiposprecio_id = "' . $price_tipo . '"', 'type' => 'left')
        );
        $where_data = array('p.codigo' => $item_id);
        $p = $this->ci->generic_model->get_join('billing_producto p', $where_data, $join_cluase, $fields, 1, null, null);

        return $p;
    }

    /* funcio para cargar tipos de precios desde ventas */

    public function get_precio_prod_venta($item_id, $price_tipo, $iva = 1, $bodega_id = '', $comprob = '01') {
        $fields = 'p.codigo, p.stockactual, p.costopromediokardex, p.costoultimokardex, p.ajuste1, p.ajuste2, p.productogrupo_codigo grupo_id, p.descmaxporcent descmaxporcent, gp.utilidad utilidad, p.pvppromo,p.finpvppromo';
        $join_cluase = array(
            '0' => array('table' => 'bill_grupoprecio gp', 'condition' => 'gp.productogrupo_id = p.productogrupo_codigo AND gp.tiposprecio_id = "' . $price_tipo . '"', 'type' => 'left')
        );
        $where_data = array('p.codigo' => $item_id);
        $p = $this->ci->generic_model->get_join('billing_producto p', $where_data, $join_cluase, $fields, 1, null, null);
        /* El codigo siguiente es para controlar que algun producto lo podamos cargar dependiendo de la bodega seleccionada */
        //$bodega_id = $this->ci->session->userdata('bodega_id');
        $bodega2 = $this->ci->generic_model->get_data('billing_bodega', array('id' => $bodega_id), 'id,nombre', $order_by = null, 1);
        $utilidadventaprod = get_settings('DEFAULT_UTILIDAD');
        if (!empty($p->utilidad)) {
            $utilidadventaprod = $p->utilidad;
        }
        /* Control provisional para la bodega de maskerade que debe cargar otro tipo de preecio */
        if (get_settings('FORMATO_FACT_MASKERADE') == 1) {
            if ($comprob == 01) {
                $precioprod = $p->costopromediokardex + $p->ajuste1 + $p->ajuste2 + ( ($p->costopromediokardex + $p->ajuste1 + $p->ajuste2) * $utilidadventaprod ) / 100;
            } elseif ($p->pvppromo > 0 and $price_tipo == 'pA' and trim($bodega2->nombre, ' ') != trim(get_settings('BODEGA_EXTRA'), ' ')) {
                $precioprod = $p->pvppromo;
            } elseif ($p->finpvppromo > 0 and trim($bodega2->nombre, ' ') == trim(get_settings('BODEGA_EXTRA'), ' ')) {
                $precioprod = $p->finpvppromo;
            } else {
                $precioprod = $p->costopromediokardex + $p->ajuste1 + $p->ajuste2 + ( ($p->costopromediokardex + $p->ajuste1 + $p->ajuste2) * $utilidadventaprod ) / 100;
            }
        } else {
            $precioprod = 0;
            $tipospvp = $this->ci->generic_model->get('producto_precio', array('id_producto' => $item_id), 'id_precio,valor,id_tipo');
            if($tipospvp){
                $precioprod = $this->cargar_tipos_pvp($price_tipo,$tipospvp);
            }
            if($precioprod == 0){
                if ($p->pvppromo > 0 and $price_tipo == 'pA') {
                    $precioprod = $p->pvppromo;
                } elseif ($p->finpvppromo > 0 and $price_tipo == 'pB') {
                    $precioprod = $p->finpvppromo;
                } else {
                    $precioprod = $p->costopromediokardex + $p->ajuste1 + $p->ajuste2 + ( ($p->costopromediokardex + $p->ajuste1 + $p->ajuste2) * $utilidadventaprod ) / 100;
                }
            } 
        }
        if ($iva > 0) {
            $iva_porcent = get_settings('IVA');
        } else {
            $iva_porcent = 0;
        }
        $precioprod_iva = $precioprod + ( $precioprod * $iva_porcent ) / 100;

        $precio_minimo = $precioprod;
        if ($p->descmaxporcent > 0) {
            $val_division_desc = ($p->descmaxporcent / 100) + 1;
            $desc_prod = $precioprod - ($precioprod / $val_division_desc);
            $precio_minimo = $precioprod - $desc_prod;
        }
        $precios_prod = array('price' => $precioprod, 'price_min' => $precio_minimo, 'price_iva' => $precioprod_iva);

        return $precios_prod;
    }
    
    private function cargar_tipos_pvp($tipo_seleccionado,$tipos) {
        $precio = 0;
        foreach ($tipos as $value) {
            if($value->id_tipo == $tipo_seleccionado){
                $precio = $value->valor;
                break;
            }
        }
        return $precio;
    }

}
