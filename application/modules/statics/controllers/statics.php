<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Statics extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->helper('url');
    }

    public function index() {
        // $this->load->library(
        //         'gapi',
        //         array(
        //             'email' => 'tobechonburi@gmail.com', 'password' => 'tobenumberonechonburi2014',
        //             'token' => null
        //         ));
        $this->load->library(
            'gapi', 
            array(
                'client_email' => '51190476601-rqfb4oqcu2feqd3ejribqko174isc5f1@developer.gserviceaccount.com',
                'key_file' => 'tobe_key.p12'
                )
            );

        $month = date('m');
        $year = date('Y');
        $toStartYear = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $toEndYear = date('Y-m-d', mktime(0, 0, 0, $month, 31, $year));
        $this->gapi->requestReportData(
            89977050, 
            array('browser', 'browserVersion'), 
            array('pageviews', 'visits'), 
            $sort_metric = null, $filter = null, 
            $toStartYear, $toEndYear, 
            $start_index = 1, $max_results = 30);
        $visitMonth = $this->gapi->getVisits();
        $pageViewMonth = $this->gapi->getPageviews();

        $toStartYear = date('Y-m-d', mktime(0, 0, 0, 1, 1, $year));
        $toEndYear = date('Y-m-d', mktime(0, 0, 0, 12, 31, $year));
        $this->gapi->requestReportData(
            89977050, 
            array('browser', 'browserVersion'), 
            array('pageviews', 'visits'), 
            $sort_metric = null, $filter = null, 
            $toStartYear, $toEndYear, 
            $start_index = 1, $max_results = 30);
        $visitYear = $this->gapi->getVisits();
        $pageViewYear = $this->gapi->getPageviews();
        
        $this->gapi->requestReportData(
            89977050, 
            array('browser', 'browserVersion'), 
            array('pageviews', 'visits'));
        $visitAll = $this->gapi->getVisits();
        $pageViewAll = $this->gapi->getPageviews();
        
        echo '<li><span style="color: black; font-weight: bold; text-align: left; width: 120px;">ผู้ใช้งาน</span></li>
              <li><span class="s">รายเดือน</span><span>' . $visitMonth . '</span></li>
        	  <li><span class="s">รายปี</span><span>' . $visitYear . '</span></li>
        	  <li><span class="s">ทั้งหมด</span><span>' . $visitAll . '</span></li>
              <li><span style="color: black; font-weight: bold; text-align: left; width: 120px;">จำนวนหน้าที่มีการเปิด</span></li>
        	  <li><span class="s">รายเดือน</span><span>' . $pageViewMonth . '</span></li>
              <li><span class="s">รายปี</span><span>' . $pageViewYear . '</span></li>
        	  <li><span class="s">ทั้งหมด</span><span>' . $pageViewAll . '</span></li>';
        exit();
    }

}
