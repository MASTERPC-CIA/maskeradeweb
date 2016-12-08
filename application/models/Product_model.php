<?php

class Product_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function autosugest_by_name($param) {
        $parambuscaprod = explode('%20', $param);
        $where = '';
        $and = '';
        foreach ($parambuscaprod as $resultado) {
            $healthy = array("%C3%B1", "%C3%91", "%C3%81", "%C3%89", "%C3%8D", "%C3%93", "%C3%9A", "%C3%A1", "%C3%A9", "%C3%AD", "%C3%B3", "%C3%BA");
            $yummy = array("ñ", "Ñ", "Á", "É", "Í", "Ó", "Ú", "á", "é", "í", "ó", "ú");
            $val = str_replace($healthy, $yummy, $resultado);

            $where .= $and . '(UPPER(nombreUnico) COLLATE UTF8_GENERAL_CI LIKE "%' . strtoupper($val) . '%" )';
            $and = ' AND ';
        }
        $this->db->where($where, null, false);
        $this->db->select('p.codigo ci, nombreUnico value');
        $this->db->limit(10);
        $this->db->from('billing_producto p');
        $query = $this->db->get();
        return $query->result();
    }

}
