<?php

Class Productos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('generic_model');
        $this->load->library(array("product", 'stockbodega'));
    }

    function filas($cuantos = 5) {
        $consulta = $this->generic_model->get('billing_producto', array('codigo >' => '0'), 'codigo,nombreUnico', array('codigo' => 'desc')
                , $cuantos);

        return $consulta->num_rows();
    }

    function get_productos_by_menu($opc_sexo, $pagination, $segment) {
        $fields = '*, SUBSTRING(codigo2,(1),LENGTH(codigo2) - 2) AS cod_sup';

        $where = "esSuperproducto=1 AND estado=1 AND (sexo1='" . $opc_sexo . "' OR sexo2='" . $opc_sexo . "' OR sexo3='" . $opc_sexo . "')";
        $this->db->select($fields);
        $this->db->where($where);
        $this->db->order_by('codigo', 'desc');
        $this->db->group_by('SUBSTRING(codigo2,(1),LENGTH(codigo2)-2)');

        $this->db->limit($pagination, $segment);
        $query = $this->db->get('billing_producto');
        return $query->result();
    }

    function get_productos_by_name($name, $pagination, $segment) {
        
        $fields = '*, SUBSTRING(codigo2,(1),LENGTH(codigo2) - 2) AS cod_sup';

        $where = "esSuperproducto=1 AND estado=1 AND nombreUnico like '%" . $name . "%'";
        $this->db->select($fields);
        $this->db->where($where);
        $this->db->order_by('codigo', 'desc');
        $this->db->group_by('SUBSTRING(codigo2,(1),LENGTH(codigo2)-2)');

        $this->db->limit($pagination, $segment);
        $query = $this->db->get('billing_producto');
        return $query->result();
    }

    function paginacion_by_name($rows, $b_url, $uri_segment) {

        $pages = get_settings('SHOPPING_CART_PAG'); //Número de registros mostrados por páginas
        $config['base_url'] = base_url() . '/products_search/' . $b_url; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php

        $config['total_rows'] = $rows;
        $config['uri_segment'] = $uri_segment;
        $config['per_page'] = $pages;
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';
        $config['last_link'] = '&Uacute;ltima';
        $config['next_link'] = '>>';
        $config['prev_link'] = '<<';
        $this->pagination->initialize($config);
    }

    function paginacion_by_menu($rows, $b_url, $uri_segment) {

        $pages = get_settings('SHOPPING_CART_PAG'); //Número de registros mostrados por páginas
        $config['base_url'] = base_url() . '/products_menu/' . $b_url; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php

        $config['total_rows'] = $rows;
        $config['uri_segment'] = $uri_segment;
        $config['per_page'] = $pages;
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';
        $config['last_link'] = '&Uacute;ltima';
        $config['next_link'] = '>>';
        $config['prev_link'] = '<<';
        $this->pagination->initialize($config);
    }

    function change_name_image($oldname, $newname) {
        //---cambiar nombre a los archivos de las imagenes
        set_time_limit(0);
        $files = glob('C:\Users\Usuario\Pictures\prod_images\*');
        //print_r($files);
        foreach ($files as $newfiles) {

            $change = str_replace($oldname, $newname, $newfiles);
            rename($newfiles, $change);
            //echo $newfiles;
        }
    }

    function stock_disponoble_view($bodegas, $product_id) {
        $stock_bodega = 0;
        if (!empty($bodegas)) {
            foreach ($bodegas as $value) {
                $stock_bodega += $this->stockbodega->get_stock_bod_disponibe($value, $product_id);
            }
            if ($stock_bodega > 0) {
                return $stock_bodega;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

}
