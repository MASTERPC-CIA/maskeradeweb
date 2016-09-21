<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of main
 *
 * @author MARIUXI
 */
class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $res['view'] = $this->load->view('pages/home', '', TRUE);
        $res['title'] = 'Inicio';
        $this->load->view('templates/dashboard', $res);
    }

    public function load_view_dhombres() {
        $this->load->view('dhombres');
    }

    public function load_view_dmujeres() {
        $this->load->view('dmujeres');
    }

    public function load_view_dinfantilesh() {
        $this->load->view('dinfantilesh');
    }

    public function load_view_dinfantilesm() {
        $this->load->view('dinfantilesm');
    }

    public function load_view_dunisex() {
        $this->load->view('dunisex');
    }

    public function load_view_servicios() {
        $this->load->view('pages/servicios');
    }

    public function load_view_contactos() {
        $this->load->view('pages/contactos');
    }

    public function show_result() {
        $res_sec['temas'] = $this->get_marcas_prods();
        $res_sec['tallas'] = $this->get_tallas_prods();
        $res_sec['precios_l1'] = $this->get_max_min_precio_local1();
        $res_sec['precios_l2'] = $this->get_max_min_precio_local2();
        $res['view'] = $this->load->view('pages/secundaria', $res_sec, TRUE);
        $res['title'] = 'Disfraces '; //Dependiendo de la opción seleccionada del menú poner el titulo
        $this->load->view('templates/dashboard', $res);
    }

}
