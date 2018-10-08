<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $send['app']                  = 'appMaskerade';
        $send['angularjs']            = $this->load_angularjs();
        $send['title'] = 'Inicio';
        $this->load->view('templates/dashboard', $send);
    }

    public function load_angularjs()
    {
        return array(
            base_url('assets/angularjs/code/app.js'),
            base_url('assets/angularjs/code/controller.js'),
        );
    }

    public function load_main() {
        $this->load->view('pages/home');
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
        $res['view'] = $this->load->view('pages/servicios', '', TRUE);
        $res['title'] = 'Servicios';
        $this->load->view('templates/dashboard', $res);
    }
    public function load_view_contactos() {
        $res['view'] = $this->load->view('pages/contactos', '', TRUE);
        $res['title'] = 'Contactos';
        $this->load->view('templates/dashboard', $res);
    }
}