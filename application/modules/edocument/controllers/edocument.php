<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Edocument extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('path');
    }

    public function index() {
        $cookie = $this->input->cookie('member');
        if (empty($cookie)) {
            $data = array();
            if (isset($_GET['auth']) && $_GET['auth'] == 0) {
                $data['error_msg'] = 1;
            }
            $title = "E-document";
            $this->load->view(
                    'header',
                    array(
                        'edocument' => true, 'title' => $title
                    ));
            $this->load->view('edocument', $data);
            $this->load->view('footer', array(
                'site' => 'edocument'
            ));
        } else {
            redirect('/edocument/edoc_view/');
        }
    }

    function edoc_member_login() {
        $query = "SELECT * FROM member WHERE username='" . $_POST['username'] . "' AND password='" . md5(
                $this->config->item('encryption_key') . $_POST['password']) . "' AND group_id!='99'";
        $result = $this->dbr->getRow($query);
        if (!empty($result)) {
            $dataUpdate = array();
            $dataUpdate['last_login'] = date("Y-m-d H:i:s");
            $this->dbr->AutoExecute(
                    "member", $dataUpdate, "UPDATE", "member_id=" . $result['member_id']);
            $dataCookie = array();
            $dataCookie['email'] = $result['email'];
            $dataCookie['username'] = $result['username'];
            $dataCookie['group_id'] = $result['group_id'];
            $this->input->set_cookie('member', json_encode($dataCookie), time() + (3600 * 24 * 365));
            redirect('/edocument/edoc_view/');
        } else {
            redirect('/edocument/?auth=0');
        }
    }

    function member_logout() {
        delete_cookie("member");
        redirect('/edocument/');
    }

    function edoc_view($year = null, $month = null) {
        $cookie = $this->input->cookie('member');
        if (!empty($cookie)) {
            $dataMember = json_decode($cookie);
            $title = "E-document >> ระบบจัดการเอกสารในเครือข่ายออนไลน์";
            $this->load->view(
                    'header',
                    array(
                        'edocument' => true, 'title' => $title
                    ));
            $edocument = $this->dbr->getAll(
                    "SELECT e.edoc_id,e.edoc_title,e.edoc_file_original,e.edoc_type,DATE_FORMAT(e.edoc_requiredate, '%Y-%m-%d') AS edoc_requiredate,
                    DATE_FORMAT(e.edoc_create_date, '%Y-%m-%d') AS edoc_create_date
                    FROM Edocument AS e LEFT JOIN Edocument_log AS e_log ON e.edoc_id = e_log.edoc_id
                    WHERE e.edoc_status='Y' AND e_log.edoc_group_id=" . $dataMember->group_id);
            $data = array();
            $data['edocument'] = $edocument;
            if (!empty($edocument)) {
                foreach ($edocument as $key => $val) {
                    $data['edocument'][$key]['edoc_log'] = $this->dbr->getAll(
                            "SELECT * FROM Edocument_log WHERE edoc_id=" . $val['edoc_id']);
                }
            }
            $this->load->view('edoc_view', $data);
            $this->load->view(
                    'footer',
                    array(
                        'year' => $year, 'month' => $month, 'site' => 'edocument/edoc_view'
                    ));
        } else {
            redirect('/edocument/');
        }
    }

    function edoc_manage($edoc_id = null, $download = 0, $year = null, $month = null) {
        $cookie = $this->input->cookie('member');
        if (!empty($cookie)) {
            $data = array();
            $dataMember = json_decode($cookie);
            $data['dataMember'] = $dataMember;
            $title = "E-document >> จัดการเอกสาร";
            $this->load->view(
                    'header',
                    array(
                        'edocument' => true, 'title' => $title
                    ));
            $edocument = $this->dbr->getRow(
                    "SELECT edoc_id,edoc_title,edoc_file_original,edoc_type,DATE_FORMAT(edoc_requiredate, '%Y-%m-%d') AS edoc_requiredate,DATE_FORMAT(edoc_create_date, '%Y-%m-%d') AS edoc_create_date FROM Edocument WHERE edoc_status='Y' AND edoc_id = " . $edoc_id);
            $data['edocument'] = $edocument;
            $result_log = $this->dbr->getAll(
                    "SELECT * FROM Edocument_log WHERE edoc_id=" . $edoc_id);
            $edoc_log = array();
            foreach ($result_log as $key => $val) {
                $edoc_log[$val['edoc_group_id']] = $val;
            }
            $data['edocument']['edoc_log'] = $edoc_log;
            if (!empty($download)) {
                if (file_exists(
                        set_realpath("static/upload/edocument") . $edocument["edoc_file_original"])) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header(
                            'Content-Disposition: attachment; filename=' . basename(
                                    set_realpath("static/upload/edocument") . $edocument["edoc_file_original"]));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header(
                            'Content-Length: ' . filesize(
                                    set_realpath("static/upload/edocument") . $edocument["edoc_file_original"]));
                    readfile(
                            set_realpath("static/upload/edocument") . $edocument["edoc_file_original"]);

                    $filesUpdate = array();
                    $filesUpdate['edoc_download_count'] = $data['edocument']['edoc_log'][$dataMember->group_id]['edoc_download_count'] + 1;
                    $this->dbr->AutoExecute(
                            "Edocument_log", $filesUpdate, "UPDATE",
                            "edoc_log_id=" . $data['edocument']['edoc_log'][$dataMember->group_id]['edoc_log_id']);
                }
            } else {
                $this->load->view('edoc_manage', $data);
            }
            $this->load->view(
                    'footer',
                    array(
                        'year' => $year, 'month' => $month,
                        'site' => 'edocument/edoc_manage/' . $edoc_id . '/' . $download
                    ));
        } else {
            redirect('/edocument/');
        }
    }

    function outputJSON($msg = '', $status = 'error') {
        $type = strtolower(substr($_FILES['edoc_file_sent']['name'], -4));
        $imgEdocName = $_POST['edoc_id'] . '_' . $_POST['edoc_log_id'] . $type;
        if ($_FILES['edoc_file_sent']['error'] > 0) {
            $msg = 'An error ocurred when uploading.';
        }
        // Check if the file exists
        if (file_exists(set_realpath("static/upload/edocument_user") . $imgEdocName)) {
            // $msg = 'File with that name already exists.';
            unlink(set_realpath("static/upload/edocument_user") . $imgEdocName);
        }
        // Upload file
        if (!move_uploaded_file(
                $_FILES["edoc_file_sent"]["tmp_name"],
                set_realpath("static/upload/edocument_user") . $imgEdocName)) {
            $msg = 'Error uploading file - check destination is writeable.';
        }
        if ($msg == '') {
            // Success!
            $msg = 'File uploaded successfully';
            $status = 'success';
            $filesUpdate = array();
            $filesUpdate['edoc_file_sent'] = $imgEdocName;
            $filesUpdate['edoc_verify'] = 1;
            $this->dbr->AutoExecute(
                    "Edocument_log", $filesUpdate, "UPDATE", "edoc_log_id=" . $_POST['edoc_log_id']);
        }
        header('Content-Type: application/json');
        die(json_encode(array(
            'data' => $msg, 'status' => $status
        )));
    }

}