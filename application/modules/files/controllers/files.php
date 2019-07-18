<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Files extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->helper('url');
        $this->load->helper('path');
    }

    public function index($file_id = 0, $year = null, $month = null) {
		$title = "บริการข้อมูล";
        $this->load->view('header', array(
            'files' => true, 'title' => $title
        ));
        if (!empty($file_id)) {
            $rs = $this->dbr->getRow("SELECT * FROM FileDownload WHERE file_id=" . $file_id);
            if (file_exists(set_realpath("static/upload/files") . $rs["file_name"])) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header(
                        'Content-Disposition: attachment; filename=' . basename(
                                set_realpath("static/upload/files") . $rs["file_name"]));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header(
                        'Content-Length: ' . filesize(
                                set_realpath("static/upload/files") . $rs["file_name"]));
                readfile(set_realpath("static/upload/files") . $rs["file_name"]);

                $filesUpdate = array();
                $filesUpdate['file_count'] = $rs['file_count'] + 1;
                $this->dbr->AutoExecute(
                        "FileDownload", $filesUpdate, "UPDATE", "file_id=" . $file_id);
            }
        } else {
            $data['files'] = $this->dbr->getAll(
                    "SELECT * FROM FileDownload WHERE file_status='Y' ORDER BY file_create_date DESC");
            $this->load->view('files', $data);
        }
        $this->load->view(
                'footer',
                array(
                    'year' => $year, 'month' => $month, 'site' => 'files/' . $file_id
                ));
    }

}