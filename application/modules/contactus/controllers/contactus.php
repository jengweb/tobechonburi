<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contactus extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->helper('url');
    }

    public function index($year = null, $month = null) {
		$title = "ติดต่อหน่วยงาน";
        $this->load->view('header', array(
            'contactus' => true, 'title' => $title
        ));
        $this->load->view('contactus');
        $this->load->view(
                'footer',
                array(
                    'year' => $year, 'month' => $month, 'site' => 'contactus'
                ));
    }

}