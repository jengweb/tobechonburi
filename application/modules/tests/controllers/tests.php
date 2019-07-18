<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tests extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->helper('url');
        // $this->load->helper('path');
        // $this->load->library('session');
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

        /*
        $this->load->library(
                'gapi',
                array(
                    'email' => 'tobechonburi@gmail.com', 'password' => 'tobenumberonechonburi2014',
                    'token' => null
                ));

        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        $this->gapi->requestReportData(
                89977050, array(
                    'browser', 'browserVersion'
                ), array(
                    'pageviews', 'visits'
                ), $sort_metric = null, $filter = null, $today, $today, $start_index = 1,
                $max_results = 30);
        echo '<p>Total pageviews: ' . $this->gapi->getPageviews() . ' total visits: ' . $this->gapi->getVisits() . '</p>';

        $toStartYear = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $toEndYear = date('Y-m-d', mktime(0, 0, 0, $month, 31, $year));
        $this->gapi->requestReportData(
                89977050, array(
                    'browser', 'browserVersion'
                ), array(
                    'pageviews', 'visits'
                ), $sort_metric = null, $filter = null, $toStartYear, $toEndYear, $start_index = 1,
                $max_results = 30);
        echo '<p>Total pageviews: ' . $this->gapi->getPageviews() . ' total visits: ' . $this->gapi->getVisits() . '</p>';

        $year = date('Y');
        $toStartYear = date('Y-m-d', mktime(0, 0, 0, 1, 1, $year));
        $toEndYear = date('Y-m-d', mktime(0, 0, 0, 12, 31, $year));
        $this->gapi->requestReportData(
                89977050, array(
                    'browser', 'browserVersion'
                ), array(
                    'pageviews', 'visits'
                ), $sort_metric = null, $filter = null, $toStartYear, $toEndYear, $start_index = 1,
                $max_results = 30);
        echo '<p>Total pageviews: ' . $this->gapi->getPageviews() . ' total visits: ' . $this->gapi->getVisits() . '</p>';
        */
    }

}