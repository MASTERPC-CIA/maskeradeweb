<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Menu extends CI_Controller
{

    private $list_fest_by_menu;
    private $list_marcas_by_menu;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('productos_model');
        $this->load->library('superproducto');

        $this->list_fest_by_menu   = array();
        $this->list_marcas_by_menu = array();
    }

    public function load_productos_view()
    {
        $this->load->view('Products/content');
    }

    public function get_productos_x_tipo()
    {
        $data = json_decode(file_get_contents("php://input"));

        switch ($data->tipo) {
            case '1':
                $opc = 'Hombre';
                break;
            case '2':
                $opc = 'Mujer';
                break;
            case '3':
                $opc = 'Niño';
                break;
            case '4':
                $opc = 'Niño';
                break;
            case '5':
                $opc = 'Bebe';
                break;
        }
        
        $where_data = array(
            'esSuperproducto' => 1, 
            'estado' => 1, 
            '(UPPER(sexo1) ="' . strtoupper($opc) . 
            '" or UPPER(sexo2) ="' . strtoupper($opc) . 
            '" or UPPER(sexo3) ="' . strtoupper($opc) . '")' => null
        );

        if(isset($data->cadena)){
            $where_data['UPPER(nombreUnico) like '] = '%'.strtoupper($data->cadena).'%';
        }

        if(isset($data->festividad)){
            $where_data['UPPER(festiv1) like '] = '%'.strtoupper($data->festividad).'%';
        }

        $fields = 'codigo, SUBSTRING(nombreUnico,1,10) nombreUnico, img';

        $order_by = array('codigo' => 'ASC');

        $limit = $data->pageNumber * $data->productosPerPage;

        $all_product_inicio = $this->generic_model->get('billing_producto', $where_data, $fields, $order_by, $limit);
        
        if($all_product_inicio){
            $index = ($limit - $data->productosPerPage);
            $hasta = $all_product_inicio[$index]->codigo;

            $where_data['codigo >='] = $hasta;

            $all_product = $this->generic_model->get('billing_producto', $where_data, $fields, $order_by, $data->productosPerPage);

            foreach ($all_product as $prod) {
                $url = get_settings('DOWNLOAD_FACT_XML').$prod->codigo.'.png';
                if($this->is_url_exist($url)){
                    $prod->img = $url;
                }else{
                    $prod->img = get_settings('DOWNLOAD_FACT_XML').'no_disponible.png';
                }
            }

            $datac["productos"]       = $all_product;
        }else{
            $datac["productos"]       = null;
        }

        echo json_encode($datac);
    }

    private function is_url_exist($url){
        $ch = curl_init($url);    
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            $status = true;
        }else{
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    public function get_all_productos()
    {
        $data = json_decode(file_get_contents("php://input"));

        switch ($data->tipo) {
            case '1':
                $opc = 'Hombre';
                break;
            case '2':
                $opc = 'Mujer';
                break;
            case '3':
                $opc = 'Niño';
                break;
            case '4':
                $opc = 'Niño';
                break;
            case '5':
                $opc = 'Bebe';
                break;
        }

        $where_data = array(
            'esSuperproducto' => 1, 
            'estado' => 1, 
            '(UPPER(sexo1) ="' . strtoupper($opc) . 
            '" or UPPER(sexo2) ="' . strtoupper($opc) . 
            '" or UPPER(sexo3) ="' . strtoupper($opc) . '")' => null
        );

        $fields = 'COUNT(*) total';

        $all_product = $this->generic_model->get('billing_producto', $where_data, $fields, $order_by = null, $rows = 1)->total;

        $datac['temas']     = $this->get_festividades_by_menu();
        $datac['marcas']    = $this->get_marcas_by_menu();
        $datac['tallas']    = $this->get_tallas_prods();
        $datac["product_count"]   = $all_product;

        echo json_encode($datac);
    }

    public function get_tallas_prods()
    {
        $fields     = 'DISTINCT(p.talla) talla';
        $where_data = array(
            '!ISNULL(p.talla) and p.talla !='=>'',
            'esSuperproducto' => '1', 
            'estado' => '1'
        );
        $order_by = array('p.talla'=>'ASC');
        $data        = $this->generic_model->get('billing_producto p', $where_data, $fields, $order_by);
        return $data;
    }

    public function get_festividades_by_menu()
    {

        $fields     = 'DISTINCT(UPPER(p.festiv1)) festividad';
        $where_festiv1 = array(
            'p.esSuperproducto' => '1', 
            'p.estado' => '1',
            '!ISNULL(p.festiv1) and p.festiv1 !='=>''
        );
        $festiv1        = $this->generic_model->get('billing_producto p', $where_festiv1, $fields);

        $where_festiv2 = array(
            'p.esSuperproducto' => '1', 
            'p.estado' => '1',
            '!ISNULL(p.festiv2) and p.festiv2 !='=>''
        );

        $fields     = 'DISTINCT(UPPER(p.festiv2)) festividad';
        $festiv2        = $this->generic_model->get('billing_producto p', $where_festiv2, $fields);

        $where_festiv3 = array(
            'p.esSuperproducto' => '1', 
            'p.estado' => '1',
            '!ISNULL(p.festiv3) and p.festiv3 !='=>''
        );

        $fields     = 'DISTINCT(UPPER(p.festiv3)) festividad';
        $festiv3        = $this->generic_model->get('billing_producto p', $where_festiv3, $fields);

        $send = array_merge((array)$festiv1, (array)$festiv2, (array)$festiv3);
        return $send;
    }

    public function get_marcas_by_menu()
    {
        $where = array(
            '!ISNULL(m.nombre) and m.nombre !='=>''
        );

        $fields     = 'DISTINCT(UPPER(m.nombre)) marca, m.id';
        $order_by = array('m.nombre'=>'ASC');
        $data        = $this->generic_model->get('billing_marca m', $where, $fields, $order_by);

        return $data;
    }

    public function get_min_precio_local1($opc)
    {
        $fields     = 'MIN(pvppromo) min_l1';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'sexo1 like' => $opc);
        $or_where   = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $res        = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 1, null, null, null, $or_where);
        return $res;
    }

    public function get_max_precio_local2($opc)
    {
        $fields     = 'MAX(finpvppromo) max_l2';
        $where_data = array('esSuperproducto' => '1', 'estado' => '1', 'sexo1 like' => $opc);
        $or_where   = array('sexo2 like' => $opc, 'sexo3 like' => $opc);
        $res        = $this->generic_model->get('billing_producto bp', $where_data, $fields, null, 1, null, null, null, $or_where);
        return $res;
    }

    public function existe_festividad_busc($fest)
    {
        $existe    = false;
        $cont_fest = 0;
        while (!$existe && $cont_fest < sizeof($this->list_fest_by_menu)) {
            if ($fest == $this->list_fest_by_menu[$cont_fest]) {
                $existe = true;
            }
            $cont_fest++;
        }
        return $existe;
    }

    public function existe_marca_busc($marca)
    {
        $existe     = false;
        $cont_marca = 0;
        while (!$existe && $cont_marca < sizeof($this->list_marcas_by_menu)) {
            if ($marca == $this->list_marcas_by_menu[$cont_marca]->id) {
                $existe = true;
            }
            $cont_marca++;
        }
        return $existe;
    }

    private function products_in_bod($productos)
    {
        $prod = '';
        foreach ($productos as $key => $value) {
            $prod[$key] = (object) array(
                'codigo'              => $value->codigo,
                'codigo2'             => $value->codigo2,
                'nombreUnico'         => $value->nombreUnico,
                'stockactual'         => $value->stockactual,
                'costopromediokardex' => $value->costopromediokardex,
                'cod_sup'             => $value->cod_sup,
            );
        }
        return $prod;
    }

    public function get_cant()
    {

        $cant_art[0] = array('cod_cant' => '12', 'name_cant' => '12');
        $cant_art[1] = array('cod_cant' => '24', 'name_cant' => '24');
        $cant_art[2] = array('cod_cant' => '36', 'name_cant' => '36');
        $cant_art[3] = array('cod_cant' => '48', 'name_cant' => '48');

        return $cant_art;
    }

    public function get_ordenar()
    {
        $ordenar_por = array(
            '0' => array('id_orden' => '1', 'crit_orden' => 'Nombre'),
            '1' => array('id_orden' => '2', 'crit_orden' => 'Precio'),
        );

        return $ordenar_por;
    }
}
