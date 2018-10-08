<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_detail extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('superproducto');
    }

    public function get_detalle_product() {

        $cod2 = $this->input->get('codigo2');
        $data['producto'] = $this->generic_model->get('billing_producto', array('codigo2' => $cod2), array('codigo', 'codigo2', 'nombreUnico', 'descripcion', 'stockactual', 'productogrupo_codigo', 'pvppromo', 'finpvppromo'), null, 1);

        if ($data['producto']) {

            $cod = $data['producto']->codigo;
            $join_cluase['0'] = array('table' => 'bill_impuestotarifa it', 'condition' => 'it.id=pt.impuestotarifa_id');
            $imp = $this->generic_model->get_join('bill_productoimpuestotarifa pt', array('pt.producto_id' => $cod), $join_cluase, 'it.tarporcent', 1, null);

            $precio_alquiler1 = $data['producto']->pvppromo + ($data['producto']->pvppromo * ($imp->tarporcent / 100));
            $precio_alquiler2 = $data['producto']->finpvppromo + ($data['producto']->finpvppromo * ($imp->tarporcent / 100));
            //Para los precios del local 1 y 2
            $data['preciol1'] = $precio_alquiler1;
            $data['preciol2'] = $precio_alquiler2;

            $bodegas_stock = $this->generic_model->get_data('billing_stockbodega', array('producto_codigo' => $cod));
            $bodegas_id = '';
            $bodegas = array();
            $tot_stock = 0;
            foreach ($bodegas_stock as $key => $bodega) {
                $nombre_bodega = $this->generic_model->get('billing_bodega', array('id' => $bodega->bodega_id, 'vistaweb' => 1), 'id,nombre', null, 1);
                if (!empty($nombre_bodega->id)) {
                    $bodegas_id[$key] = $nombre_bodega->id;

                    $nombre_bodega->stock_bodega = $this->superproducto->get_stock_superprod_bodega($cod, $nombre_bodega->id);
                    array_push($bodegas, $nombre_bodega);
                    $tot_stock+=$nombre_bodega->stock_bodega;
                }
            }
            $data['stock_total'] = $tot_stock;
            $data['bodegas_prod'] = $bodegas;
        }
        $res['view'] = $this->load->view('products/product_detail', $data, TRUE);
        $res['title'] = 'Detalle Disfraz';
        $this->load->view('templates/dashboard', $res);
    }

    public function open_traje($codigo2) {

        $rest = substr($codigo2, 0, -2);
        $where_data = array('SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2) - 2) =' => $rest);
        $join_cluase = array(
            '0' => array('table' => 'bill_productoimpuestotarifa pit', 'condition' => 'pit.producto_id = p.codigo', 'type' => 'LEFT'),
            '1' => array('table' => 'bill_impuestotarifa it', 'condition' => 'it.id = pit.impuestotarifa_id', 'type' => 'LEFT'),
            '2' => array('table' => 'billing_stockbodega sb', 'condition' => 'sb.producto_codigo = p.codigo AND (p.esSuperproducto = 1 )')
        );
        $fields = 'SUBSTRING(p.nombreUnico,1,20) nombre_view,p.*,it.tarporcent, SUBSTRING(p.codigo2,(1),LENGTH(p.codigo2) - 2) AS cod_sup';
        $group_by = 'p.codigo2';

        $fact['producto'] = [];
        $producto = $this->generic_model->get_join('billing_producto p', $where_data, $join_cluase, $fields, $rows_num = 0, '', $group_by);
        $fact['producto'] = $producto;

        foreach ($producto as $key => $value) {
            $fact['stock1'][] = $this->get_stock_superprod_bodega($value->codigo, "11");
            $fact['stock2'][]= $this->get_stock_superprod_bodega($value->codigo, "12");
            $value->alq_l1= $value->pvppromo + ($value->pvppromo * $value->tarporcent/100);
            $value->alq_l2 = $value->finpvppromo + ($value->finpvppromo * $value->tarporcent/100);
            $value->pvp = $value->costopromediokardex+($value->costopromediokardex * $value->tarporcent/100);
        }
        $res['view'] = $this->load->view('products/view_traje', $fact, true);
        $res['title'] = 'Detalle Disfraz';
        $this->load->view('templates/dashboard', $res);
        
    }

    public function get_stock_superprod_bodega($id_superproducto, $bodega_id) {
        $id_ajuSalida = $this->generic_model->get_val_where('bill_ajustesalida', array('ajs_idSuperProd' => $id_superproducto), 'id', null, -1);
        $stock = 0;
        if ($id_ajuSalida) {
            $join_cluase = array(
                '0' => array('table' => 'billing_producto', 'condition' => 'billing_producto.codigo=bill_ajustesalidadet.Producto_codigo AND pieza = 1'));
            $fields = array(
                'billing_producto.codigo');
            $detalle_ajSalida = $this->generic_model->get_join('bill_ajustesalidadet', array('ajustesalida_id' => $id_ajuSalida), $join_cluase, $fields, 0, null, null);
            if ($detalle_ajSalida) {
                $stock = $this->generic_model->get_val_where('billing_stockbodega', array('bodega_id' => $bodega_id, 'producto_codigo' => $detalle_ajSalida[0]->codigo), 'stock', null, -1);
            }
        } else {
            echo info_msg('No se encuentra productos.....');
        }

        return $stock;
    }
}