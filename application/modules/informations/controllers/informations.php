<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Informations extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->helper('url');
    }

    public function index($infotype = null, $info_id = 0, $year = null, $month = null) {
        if ($infotype == "all") {
            // START See more page
            if (in_array($info_id, array(
                1, 2, 3, 4, 5
            ))) {
                $data['type'] = $info_id;
                $queryInfo = "SELECT * FROM Information WHERE info_type='" . $info_id . "' ORDER BY info_createdate DESC LIMIT 0,8";
                $data['informations'] = $this->dbr->GetArray($queryInfo);
                foreach ($data['informations'] as $key => $val) {
                    $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $val['info_id'] . " ORDER BY image_id ASC";
                    $data['informations'][$key]['img'] = $this->dbr->GetRow($queryImgInfo);
                }
                $type_new = $this->config->item('type_new');
                $title = "ข่าวประชาสัมพันธ์ ประเภท" . $type_new[$info_id];
                $this->load->view(
                        'header',
                        array(
                            'informations' => true, 'title' => $title
                        ));
                $this->load->view('informations_more', $data);
            } else {
                redirect("/informations/");
            }
            // END see more page
        } elseif ($infotype == "detail") {
            // START detail page
            $queryInfo = "SELECT * FROM Information WHERE info_id='" . $info_id . "'";
            $data['info_detail'] = $this->dbr->GetRow($queryInfo);
            if (!empty($data['info_detail'])) {
                $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $info_id . " ORDER BY image_id ASC";
                $data['info_detail']['img'] = $this->dbr->GetAll($queryImgInfo);
                // page count
                $viewUpdate = array();
                $viewUpdate['info_view_count'] = $data['info_detail']['info_view_count'] + 1;
                $this->dbr->AutoExecute("Information", $viewUpdate, "UPDATE", "info_id=" . $info_id);

                $title = "ข่าวประชาสัมพันธ์ " . $data['info_detail']['info_title'];
                $this->load->view(
                        'header',
                        array(
                            'informations' => true,
                            'css' => array(
                                'css/lightbox.css'
                            ),
                            'js' => array(
                                'js/jquery-1.11.0.min.js', 'js/lightbox.min.js'
                            ), 'title' => $title
                        ));
                $this->load->view('informations_detail', $data);
            } else {
                redirect("/informations/");
            }

            // END detail page
        } elseif ($infotype == 0) {
            $title = "ข่าวประชาสัมพันธ์";
            $this->load->view(
                    'header',
                    array(
                        'informations' => true, 'title' => $title
                    ));
            // START index page
            $queryInfo = "SELECT * FROM Information WHERE info_type='1' ORDER BY info_createdate DESC LIMIT 0,2";
            $data['informations_1'] = $this->dbr->GetArray($queryInfo);
            foreach ($data['informations_1'] as $key => $val) {
                $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $val['info_id'] . " ORDER BY image_id ASC";
                $data['informations_1'][$key]['img'] = $this->dbr->GetRow($queryImgInfo);
            }

            $queryInfo = "SELECT * FROM Information WHERE info_type='2' ORDER BY info_createdate DESC LIMIT 0,2";
            $data['informations_2'] = $this->dbr->GetArray($queryInfo);
            foreach ($data['informations_2'] as $key => $val) {
                $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $val['info_id'] . " ORDER BY image_id ASC";
                $data['informations_2'][$key]['img'] = $this->dbr->GetRow($queryImgInfo);
            }

            $queryInfo = "SELECT * FROM Information WHERE info_type='3' ORDER BY info_createdate DESC LIMIT 0,2";
            $data['informations_3'] = $this->dbr->GetArray($queryInfo);
            foreach ($data['informations_3'] as $key => $val) {
                $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $val['info_id'] . " ORDER BY image_id ASC";
                $data['informations_3'][$key]['img'] = $this->dbr->GetRow($queryImgInfo);
            }

            $queryInfo = "SELECT * FROM Information WHERE info_type='4' ORDER BY info_createdate DESC LIMIT 0,2";
            $data['informations_4'] = $this->dbr->GetArray($queryInfo);
            foreach ($data['informations_4'] as $key => $val) {
                $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $val['info_id'] . " ORDER BY image_id ASC";
                $data['informations_4'][$key]['img'] = $this->dbr->GetRow($queryImgInfo);
            }

            $queryInfo = "SELECT * FROM Information WHERE info_type='5' ORDER BY info_createdate DESC LIMIT 0,2";
            $data['informations_5'] = $this->dbr->GetArray($queryInfo);
            foreach ($data['informations_5'] as $key => $val) {
                $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $val['info_id'] . " ORDER BY image_id ASC";
                $data['informations_5'][$key]['img'] = $this->dbr->GetRow($queryImgInfo);
            }
            $this->load->view('informations', $data);
            // END index page
        }
        $this->load->view(
                'footer',
                array(
                    'year' => $year, 'month' => $month,
                    'site' => 'informations/' . $infotype . "/" . $info_id
                ));
    }

}