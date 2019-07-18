<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->library('encrypt');
        $this->load->helper('url');
    }

    public function index($year = null, $month = null) {
        $data = array();
        $title = "หน้าแรกเว็บไซต์ TO BE NUMBER ONE จังหวัดชลบุรี ";
        $this->load->view('header', array(
            'index' => true, 'title' => $title
        ));

        $queryInfo = "SELECT * FROM Information ORDER BY info_createdate DESC LIMIT 0,8";
        $data['informations'] = $this->dbr->GetArray($queryInfo);
        foreach ($data['informations'] as $key => $val) {
            $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $val['info_id'] . " ORDER BY image_id ASC";
            $data['informations'][$key]['img'] = $this->dbr->GetRow($queryImgInfo);
        }

        $this->load->view('welcome', $data);
        $this->load->view(
                'footer',
                array(
                    'year' => $year, 'month' => $month, 'site' => 'welcome'
                ));
    }

}