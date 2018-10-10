<?php

/**
 * Description of superproducto
 *
 * @author MARIUXI
 */
class Superproducto {

    private $ci;

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->library("stockbodega"); //load library
    }

    public function get_subproductos_super($id_superProd) {
        $id_ajuSalida = $this->ci->generic_model->get_val_where('bill_ajustesalida', array('ajs_idSuperProd' => $id_superProd), 'id', null, -1);
        $list_subproductos = array();
        if ($id_ajuSalida) {
            $list_subproductos = $this->ci->generic_model->get('bill_ajustesalidadet', array('ajustesalida_id' => $id_ajuSalida), 'Producto_codigo codigo', null, 0, null, null, null, null);
        }
        return $list_subproductos;
    }

    public function get_stock_subproductos($id_superProd) {
        $id_ajuSalida = $this->ci->generic_model->get_val_where('bill_ajustesalida', array('ajs_idSuperProd' => $id_superProd), 'id');
        $list_subproductos = array();
        if ($id_ajuSalida) {
            $where_data = array('ajustesalida_id' => $id_ajuSalida);
            $fields = 'bp.codigo, bp.stockactual';
            $join_cluase = array(
                '0' => array('table' => 'billing_producto bp', 'condition' => 'bp.codigo=Producto_codigo')
            );
            $list_subproductos = $this->ci->generic_model->get_join('bill_ajustesalidadet', $where_data, $join_cluase, $fields);
        }
        return $list_subproductos;
    }

    public function get_stock_minimo($id_superProd) {
        $productos = $this->get_stock_subproductos($id_superProd);
        $menor = 0;
        if ($productos) {
            $menor = $productos[0]->stockactual;
            foreach ($productos as $value) {
                if ($value->stockactual < $menor) {
                    $menor = $value->stockactual;
                }
            }
        }
        return $menor;
    }

    public function get_subproductos_super_det($id_superProd) {
        $id_ajuSalida = $this->ci->generic_model->get_val_where('bill_ajustesalida', array('ajs_idSuperProd' => $id_superProd), 'id', null, -1);
        $list_subproductos = array();
        if ($id_ajuSalida) {
            $join_cluase = array(
                '0' => array('table' => 'billing_producto bp', 'condition' => 'bp.codigo = Producto_codigo')
            );
            $fields = 'Producto_codigo codigo,itemcantidad cant, bp.nombreUnico, bp.costopromediokardex, bp.esServicio, bp.stockactual';
            $list_subproductos = $this->ci->generic_model->get_join('bill_ajustesalidadet', array('ajustesalida_id' => $id_ajuSalida), $join_cluase, $fields);
        }
        return $list_subproductos;
    }

    public function validar_stock_subproductos_factura($data_subproductos, $cant_superProd, $bodega_id) {
        $cantSubprod = sizeof($data_subproductos);
        $cont = 0;
        $hay_stock = true;
        while ($cont < $cantSubprod && $hay_stock == true) {
            if ($data_subproductos[$cont]->esServicio == 0) {
                $stock_disponible = $this->ci->stockbodega->get_stock_bod_disponibe($bodega_id, $data_subproductos[$cont]->codigo);
                if ($stock_disponible < ($data_subproductos[$cont]->cant * $cant_superProd)) {
                    $hay_stock = false;
                    //echo info_msg(' El stock se ha agotado para el sub producto ' . $data_subproductos[$cont]->codigo . ' en la bodega seleccionada.');
                }
            }
            $cont++;
        }
        return $hay_stock;
    }

    public function get_stock_minimo_by_bodega($id_superProd, $id_bodega) {
        $productos = $this->get_stock_subproductos_by_bodega($id_superProd, $id_bodega);
        $menor = 0;
        if ($productos) {
            $menor = $productos[0]->stockactual;
            foreach ($productos as $value) {
                if ($value->stockactual < $menor) {
                    $menor = $value->stockactual;
                }
            }
        }
        return $menor;
    }

    public function get_stock_subproductos_by_bodega($id_superProd, $id_bodega) {
        $id_ajuSalida = $this->ci->generic_model->get_val_where('bill_ajustesalida', array('ajs_idSuperProd' => $id_superProd), 'id');
        $list_subproductos = array();
        if ($id_ajuSalida) {
            $where_data = array('ajustesalida_id' => $id_ajuSalida);
            $fields = 'sb.stock stockactual';
            $join_cluase = array(
                '0' => array('table' => 'billing_producto bp', 'condition' => 'bp.codigo=Producto_codigo'),
                '1' => array('table' => 'billing_stockbodega sb', 'condition' => 'sb.producto_codigo=bp.codigo and sb.bodega_id = ' . $id_bodega),
            );
            $list_subproductos = $this->ci->generic_model->get_join('bill_ajustesalidadet', $where_data, $join_cluase, $fields);
        }
        return $list_subproductos;
    }
    /*Función creada para poder determinar el stock del supeproducto de acuerdo a la pieza clave del traje*/
    public function get_stock_superprod_bodega($id_superproducto, $bodega_id) {
        $id_ajuSalida = $this->ci->generic_model->get_val_where('bill_ajustesalida', array('ajs_idSuperProd' => $id_superproducto), 'id', null, -1);
        $detalle_ajSalida = -1;
        if ($id_ajuSalida) {
            $join_cluase = array(
                '0' => array('table' => 'billing_producto', 'condition' => 'billing_producto.codigo=bill_ajustesalidadet.Producto_codigo AND pieza = 1'));
            $fields = array(
                'billing_producto.codigo');
            $detalle_ajSalida = $this->ci->generic_model->get_join('bill_ajustesalidadet', array('ajustesalida_id' => $id_ajuSalida), $join_cluase, $fields, 0, null, null)[0];
        } else {
            echo info_msg('No se encuentra productos.....');
        }
        $stock = $this->ci->generic_model->get_val_where('billing_stockbodega', array('bodega_id' => $bodega_id, 'producto_codigo' => $detalle_ajSalida->codigo), 'stock', null, -1);
        return $stock;
    }

}
