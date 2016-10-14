<?php

/**
 * Description of product_detail
 *
 * @author MARIUXI
 */
class product_detail extends CI_Controller {

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

}
