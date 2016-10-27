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

//    public function load_angularjs() {
//        return array(
//            base_url('resources/angularjs/pagina_web/app.js'),
//            base_url('resources/angularjs/pagina_web/data.js'),
//            base_url('resources/angularjs/pagina_web/directives.js'),
//            base_url('resources/angularjs/pagina_web/controller.js'),
//            base_url('resources/angularjs/pagina_web/ngCart.js'),
//            base_url('resources/angularjs/toaster.js'),
//            base_url('resources/angularjs/angular-file-upload.min.js'),
//            base_url('resources/angularjs/angucomplete-alt.js'),
//        );
//    }
//
//    public function load_css() {
//        return array(
//            base_url('resources/angularjs/pagina_web/css/custom.css'),
//            base_url('resources/angularjs/css/toaster.css'),
//            base_url('resources/angularjs/css/angucomplete-alt.css')
//        );
//    }

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
