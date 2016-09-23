<?php


Class Productos_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->library(array("product",'stockbodega'));
    }

    function paginacion($rows,$b_url,$uri_segment) {
        $pages = get_settings('NUM_PAG_WEBMASK'); //Número de registros mostrados por páginas
        $config['base_url'] = base_url() . 'products/'.$b_url; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        
        $config['total_rows'] = $rows;
        $config['uri_segment'] = $uri_segment;
        $config['per_page'] = $pages;
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';
        $config['last_link'] = '&Uacute;ltima';
        $config['next_link'] = 'Siguiente';
        $config['prev_link'] = 'Anterior';
//        $this->pagination->initialize($config);
    }
    
    function filas($cuantos = 5) {
        $consulta = $this->generic_model->get('billing_producto',
                                            array('codigo >' => '0'),
                                            'codigo,nombreUnico',
                                            array('codigo' => 'desc')
                                            , $cuantos);
       
        return $consulta->num_rows();
    }
    
    function get_productos($cod_group, $pagination, $segment) {

        $grupoprod = $this->generic_model->get_data( 
                'billing_productogrupo', 
                array('codigo'=>$cod_group,'vista_web'=>1,'activo'=>1), 
                'codigo,nombre', 
                array('nombre'=>'asc')
            );
        $this->db->select('codigo,nombreUnico,stockactual,costopromediokardex');
        
        if (!empty($grupoprod)) {
            $this->db->where('productogrupo_codigo =', $grupoprod[0]->codigo );
        }else{
            $this->db->where('productogrupo_codigo !=', $cod_group );
        }
        
        $this->db->where('costopromediokardex !=', 0.0 );
        $this->db->where('stockactual !=', 0 );
        $this->db->where('esServicio =', 0 );
//        $this->db->order_by('codigo', 'asc');
        $this -> db -> order_by('codigo', 'desc');
        $this -> db -> order_by('stockactual', 'desc');
        
        $this->db->limit($pagination, $segment);
        $query = $this->db->get('billing_producto');
        return $query->result();
    }

    function change_name_image($oldname ,$newname){
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
    
    function stock_disponoble_view($bodegas,$product_id){
        $stock_bodega = 0;
        if(!empty($bodegas)){
            foreach ($bodegas as $value) {
                $stock_bodega += $this->stockbodega->get_stock_bod_disponibe($value, $product_id);
            }
            if($stock_bodega > 0){
                return $stock_bodega;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        
            
    }
}
