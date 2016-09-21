<?php

/**
 * Description of products
 *
 * @author MARIUXI
 */
class products extends CI_Controller {

    private $list_fest_by_sexo;

    public function __construct() {
        parent::__construct();
        $this->load->model('productos_model');
        $this->list_fest_by_sexo = array();
    }

    public function product_detail() {

        $cod2 = $this->input->get('codigo2');
        $data['producto'] = $this->generic_model->get('billing_producto', array('codigo2' => $cod2), array('codigo', 'codigo2', 'nombreUnico', 'descripcion', 'stockactual', 'productogrupo_codigo', 'pvppromo', 'finpvppromo'), null, 1);

        if (sizeof($data['producto']) > 0) {

            $cod = $data['producto']->codigo;
            $join_cluase['0'] = array('table' => 'bill_impuestotarifa it', 'condition' => 'it.id=pt.impuestotarifa_id');
            $imp = $this->generic_model->get_join('bill_productoimpuestotarifa pt', array('pt.producto_id' => $cod), $join_cluase, 'it.tarporcent', 1, null);

            $precio_alquiler1 = $data['producto']->pvppromo + ($data['producto']->pvppromo * ($imp->tarporcent / 100));
            $precio_alquiler2 = $data['producto']->finpvppromo + ($data['producto']->finpvppromo * ($imp->tarporcent / 100));

            $data['preciol1'] = $precio_alquiler1;
            $data['preciol2'] = $precio_alquiler2;

            $bodegas_stock = $this->generic_model->get_data('billing_stockbodega', array('producto_codigo' => $cod));
            $bodegas_id = '';
            $bodegas = array();

            foreach ($bodegas_stock as $key => $bodega) {

                $nombre_bodega = $this->generic_model->get('billing_bodega', array('id' => $bodega->bodega_id, 'vistaweb' => 1), 'id,nombre', null, 1);
                if (!empty($nombre_bodega->id)) {
                    $bodegas_id[$key] = $nombre_bodega->id;
                    $nombre_bodega->stock_bodega = $bodega->stock;
                    array_push($bodegas, $nombre_bodega);
                }
            }
            $data['stock_total'] = $this->productos_model->stock_disponoble_view($bodegas_id, $cod);
            $data['bodegas_prod'] = $bodegas;
        }
        $res['view'] = $this->load->view('products/product_detail', $data, TRUE);
        $res['title'] = 'Detalle Disfraz';
        $this->load->view('templates/dashboard', $res);
    }

    public function get_festividades($opc) {
        $fields1 = 'DISTINCT(festiv1) festiv1';
        $fields2 = 'DISTINCT(festiv2) festiv2';
        $fields3 = 'DISTINCT(festiv3) festiv3';
        $where = array('esSuperproducto' => 1, 'estado' => 1, 'sexo1 like' => $opc);
        $or_where = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $result1 = $this->generic_model->get('billing_producto', $where, $fields1, null, 0, null, null, null, $or_where);
        $result2 = $this->generic_model->get('billing_producto', $where, $fields2, null, 0, null, null, null, $or_where);
        $result3 = $this->generic_model->get('billing_producto', $where, $fields3, null, 0, null, null, null, $or_where);

        if ($result1) {
            foreach ($result1 as $value) {
                if (!$this->existe_festividad($value->festiv1)) {
                    array_push($this->list_fest_by_sexo, $value->festiv1);
                }
            }
        }
        if ($result2) {
            foreach ($result2 as $value) {
                if (!$this->existe_festividad($value->festiv2)) {
                    array_push($this->list_fest_by_sexo, $value->festiv2);
                }
            }
        }
        if ($result3) {
            foreach ($result3 as $value) {
                if (!$this->existe_festividad($value->festiv3)) {
                    array_push($this->list_fest_by_sexo, $value->festiv3);
                }
            }
        }

        return $this->get_fest_subcategorias();
    }

    public function get_fest_subcategorias() {
        $list_fest = array();
        if ($this->list_fest_by_sexo) {
            $cont_fest = 0;
            foreach ($this->list_fest_by_sexo as $key => $value) {
                $list_fest[$cont_fest] = (Object) array('festividad' => $value, 'lista_marcas' => $this->get_subcategoria_by_fest($value));
                $cont_fest++;
            }
        }
        return $list_fest;
        
    }

    public function get_subcategoria_by_fest($fest) {
        $fields = array('DISTINCT(marca_id) id_marca');
        $where = array('festiv1' => $fest);
        $or_where = array('festiv2' => $fest, 'festiv3' => $fest);
        $sub_categ = $this->generic_model->get('billing_producto', $where, $fields, null, 0, null, null, null, $or_where);
        if ($sub_categ) {
            foreach ($sub_categ as $value) {
                $value->nombre_marca = $this->generic_model->get_val_where('billing_marca', array('id' => $value->id_marca), 'nombre', null, -1);
            }
        }
        return $sub_categ;
    }

    public function existe_festividad($fest) {
        $existe = false;
        $cont_fest = 0;
        while (!$existe && $cont_fest < sizeof($this->list_fest_by_sexo)) {
            if ($fest == $this->list_fest_by_sexo[$cont_fest]) {
                $existe = true;
            }
            $cont_fest++;
        }
        return $existe;
    }

    public function load_productos($opc) {

        $datac['temas'] = $this->get_festividades($opc);
        $datac['tallas'] = $this->get_tallas_prods($opc);
        $datac['precios_l1'] = $this->get_max_min_precio_local1($opc);
        $datac['precios_l2'] = $this->get_max_min_precio_local2($opc);

        /* consulta de todos los productos */
        $where_data = array('esSuperproducto' => 1, 'estado' => 1, 'sexo1 like' => $opc);
        $fields = 'codigo, codigo2, nombreUnico, stockactual, pvppromo, finpvppromo';
        $or_where = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $all_product = $this->generic_model->get(
                'billing_producto', $where_data, $fields, null, 0, null, null, null, $or_where
        );
        if ($all_product) {
            foreach ($all_product as $value) {
                $join_cluase['0'] = array('table' => 'bill_impuestotarifa it', 'condition' => 'it.id=pt.impuestotarifa_id');
                $imp = $this->generic_model->get_join('bill_productoimpuestotarifa pt', array('pt.producto_id' => $value->codigo), $join_cluase, 'it.tarporcent', 1, null);

                $value->precio_alq1 = $value->pvppromo + ($value->pvppromo * ($imp->tarporcent / 100));
                $value->precio_alq2 = $value->finpvppromo + ($value->finpvppromo * ($imp->tarporcent / 100));
            }
        }
        $datac['total_disf'] = sizeof($all_product);
        $datac['num_ini'] = 12; //Para iniciar con un valor al momento de presentar los trajes
        $datac['num_fin'] = 40; //Numero máximo de productos que se pueden presentar por página
        /* productos que se veran segun la cantidad configurada por paginacion */
        $productos = $this->productos_model->get_productos('', get_settings('NUM_PAG_WEBMASK'), $this->uri->segment(4), '');

        /* productos que se veran en el portal */
        /* total de productos que se cargaran para hacer la paginacion */

//        $this->productos_model->paginacion(count($all_product), 'index/', 4);
        //detalle de los productos que se mostraran en la pagina
//        if ($productos) {
//            $prod_view = $this->products_in_bod($productos);
//        } else {
//            $prod_view = array();
//        }

        $datac["productos"] = $all_product;
//        $datac["productos"] = $prod_view;
        $datac['producto_nombre'] = array();
        $datac["idgrupo"] = '';
        $datac['name_prod'] = '';

//        $res_slidebar['grupos_producto'] = $this->generic_model->get_data(
//                'billing_productogrupo', array('vista_web' => 1, 'activo' => 1), 'codigo, nombre, descripcion, meses_garantia', array('nombre' => 'asc')
//        );


        $res['view'] = $this->load->view('products/content', $datac, TRUE);
        $res['title'] = 'Disfraces '; //Dependiendo de la opción seleccionada del menú poner el titulo
        $this->load->view('templates/dashboard', $res);
    }

    private function products_in_bod($productos) {
        $prod = '';

        foreach ($productos as $key => $value) {
            $bodegas_stock = $this->generic_model->get_data(
                    'billing_stockbodega', array('producto_codigo' => $value->codigo), 'bodega_id,producto_codigo,stock'
            );
            $bodegas_ids = $this->array_prod_bodegas($bodegas_stock);

            $stock = $this->productos_model->stock_disponoble_view($bodegas_ids, $value->codigo);
            if (!empty($this->user->id)) {
                $precios = $this->product->get_precio_prod($value->codigo, $tipocliente->default_price);
                $desc = $tipocliente->descuento;
            } else {
                $desc = 20.00;
                $precios = $this->product->get_precio_prod($value->codigo, 'pB');
            }
            $preciosN = $this->product->get_precio_prod($value->codigo, 'pA');
            $precioNI = $preciosN['price_iva'];
            $couta = ($precioNI * 1.24) / 18;
            $precioOferta_sin_iva = $precios['price'];
            $precioOferta_con_iva = $precios['price_iva'];
            ///descuento
            $descuento = $precioOferta_con_iva * $desc / 100;
            $total_des = $precioOferta_con_iva - $descuento;
            if ($stock > 0) {
                $prod[$key] = (object) array(
                            'codigo' => $value->codigo,
                            'nombreUnico' => $value->nombreUnico,
                            'stockactual' => $value->stockactual,
                            'costopromediokardex' => $value->costopromediokardex,
                            'stock_bodega' => $stock,
                            'precioOferta_sin_iva' => $precioOferta_sin_iva,
                            'precioOferta_con_iva' => $precioOferta_con_iva,
                            'precioNormal_con_iva' => $precioNI,
                            'cuota' => $couta,
                            'total_desc' => $total_des
                );
            }
        }

        return $prod;
    }

    private function array_prod_bodegas($prod_bod_stock) {
        $bodegas_id = '';
        foreach ($prod_bod_stock as $key => $bodega) {
//                                        $nombre_bodega = $this->generic_model->get_by_id('billing_bodega', $bodega->bodega_id, 'id,nombre', 'id');
            $nombre_bodega = $this->generic_model->get(
                    'billing_bodega', array('id' => $bodega->bodega_id, 'vistaweb' => 1), 'id,nombre'
            );
            if (!empty($nombre_bodega[0]->id)) {
                $bodegas_id[$key] = $nombre_bodega[0]->id;
            }
        }
        return $bodegas_id;
    }

    public function get_marcas_prods() {
        $fields = 'DISTINCT(bg.nombre) tema';
        $where_data = array('esSuperproducto' => '1');
        $join['0'] = array('table' => 'billing_productogrupo bg', 'condition' => 'bg.codigo=bp.productogrupo_codigo');
        $res = $this->generic_model->get_join('billing_producto bp', $where_data, $join, $fields);
        return $res;
    }

    public function get_tallas_prods($opc) {
        $fields = 'DISTINCT(bp.talla) talla';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'sexo1 like' => $opc);
        $or_where = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 0, null, null, null, $or_where);
        return $res;
    }

    public function get_max_min_precio_local1($opc) {
        $fields = 'MAX(pvppromo) max_l1, MIN(pvppromo) min_l1';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'sexo1 like' => $opc);
        $or_where = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 0, null, null, null, $or_where);
        $send = array();
        if ($res) {
            $send['max1'] = number_decimal($res[0]->max_l1 + ($res[0]->max_l1 * (get_settings('IVA') / 100)));
            $send['min1'] = number_decimal($res[0]->min_l1 + ($res[0]->min_l1 * (get_settings('IVA') / 100)));
        }

        return $send;
    }

    public function get_max_min_precio_local2($opc) {
        $fields = 'MAX(finpvppromo) max_l2, MIN(finpvppromo) min_l2';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'sexo1 like' => $opc);
        $or_where = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $res = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 0, null, null, null, $or_where);
        $send = array();
        if ($res) {
            $send['max2'] = $res[0]->max_l2 + ($res[0]->max_l2 * (get_settings('IVA') / 100));
            $send['min2'] = $res[0]->min_l2 + ($res[0]->min_l2 * (get_settings('IVA') / 100));
        }

        return $send;
    }

    function get_product_by_name() {
        $this->load->model('product_model');
        $param = $this->input->post('product_name_autosug');
        $res = $this->product_model->autosugest_by_name($param);
        if (!empty($res)) {
            echo json_encode($res);
        } else {
            echo '{"id":"--","name":"No se encontraron resultados para ' . $param . '"}';
        }
    }

}
