<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function load_productos_view()
    {
        $this->load->view('Products/content');
    }

    public function get_productos_x_tipo()
    {
        $data = json_decode(file_get_contents("php://input"));

        $where_data = array(
            'esSuperproducto' => 1, 
            'estado' => 1
        );
        if(isset($data->tipo)){
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
                '(UPPER(sexo1) ="' . strtoupper($opc) . 
                '" or UPPER(sexo2) ="' . strtoupper($opc) . 
                '" or UPPER(sexo3) ="' . strtoupper($opc) . '")' => null
            );
        }

        if(isset($data->cadena)){
            $where_data['UPPER(nombreUnico) like '] = '%'.strtoupper($data->cadena).'%';
        }
        
        if(isset($data->festividad)){
            $where_data['(UPPER(festiv1) like "%'.strtoupper($data->festividad).'%" OR UPPER(festiv2) like "%'.strtoupper($data->festividad).'%" OR UPPER(festiv3) like "%'.strtoupper($data->festividad).'%")'] = null;
        }

        if(isset($data->marca)){
            $where_data['marca_id'] = $data->marca;
        }

        if(isset($data->talla)){
            $where_data['UPPER(talla) like '] = '%'.strtoupper($data->talla).'%';
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
                $url = get_settings('DOWNLOAD_FACT_XML').$prod->codigo.'.jpg';
                if($this->is_url_exist($url)){
                    $prod->img = $url;
                }else{
                    $prod->img = get_settings('DOWNLOAD_FACT_XML').'no_disponible.jpg';
                }
            }

            $datac["productos"]       = $all_product;
        }else{
            $datac["productos"]       = [];
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

        $where_data = array(
            'esSuperproducto' => 1, 
            'estado' => 1
        );

        if(isset($data->tipo)){
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
                '(UPPER(sexo1) ="' . strtoupper($opc) . 
                '" or UPPER(sexo2) ="' . strtoupper($opc) . 
                '" or UPPER(sexo3) ="' . strtoupper($opc) . '")' => null
            );
        }

        if(isset($data->cadena)){
            $where_data['UPPER(nombreUnico) like '] = '%'.strtoupper($data->cadena).'%';
        }
        
        if(isset($data->festividad)){
            $where_data['(UPPER(festiv1) like "%'.strtoupper($data->festividad).'%" OR UPPER(festiv2) like "%'.strtoupper($data->festividad).'%" OR UPPER(festiv3) like "%'.strtoupper($data->festividad).'%")'] = null;
        }

        if(isset($data->marca)){
            $where_data['marca_id'] = $data->marca;
        }

        if(isset($data->talla)){
            $where_data['UPPER(talla) like '] = '%'.strtoupper($data->talla).'%';
        }

        $fields = 'COUNT(*) total';

        $all_product = $this->generic_model->get('billing_producto', $where_data, $fields, $order_by = null, $rows = 1)->total;

        $datac['festividades']     = $this->get_festividades_by_menu();
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

        $fields     = 'UPPER(m.nombre) marca, m.id';
        $order_by = array('m.nombre'=>'ASC');
        $data        = $this->generic_model->get('billing_marca m', $where, $fields, $order_by);

        return $data;
    }
}