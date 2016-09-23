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

}
