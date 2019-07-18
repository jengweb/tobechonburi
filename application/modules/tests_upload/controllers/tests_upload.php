<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tests_upload extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->library('encrypt');
        $this->load->helper('url');
        $this->load->helper('path');
    }

    public function index() {
        $this->load->view('tests_upload');
    }

    function outputJSON($msg, $status = 'error') {
        // Check for errors
        if ($_FILES['SelectedFile']['error'] > 0) {
            $msg = 'An error ocurred when uploading.';
        }

        if (!getimagesize($_FILES['SelectedFile']['tmp_name'])) {
            $msg = 'Please ensure you are uploading an image.';
        }
        /*
         * // Check filetype if ($_FILES['SelectedFile']['type'] != 'image/png') { $msg = 'Unsupported filetype uploaded.'; } // Check filesize if ($_FILES['SelectedFile']['size'] > 500000) { $msg = 'File uploaded exceeds maximum upload size.'; }
         */
        // Check if the file exists
        if (file_exists(
                set_realpath("static/upload/edocument_user") . $_FILES['SelectedFile']['name'])) {
            $msg = 'File with that name already exists.';
        }

        // Upload file
        if (!move_uploaded_file(
                $_FILES["SelectedFile"]["tmp_name"],
                set_realpath("static/upload/edocument_user") . $_FILES["SelectedFile"]["name"])) {
            $msg = 'Error uploading file - check destination is writeable.';
        }

        // Success!
        $msg = 'File uploaded successfully to "' . 'static/upload/edocument_user/' . $_FILES['SelectedFile']['name'] . '".';
        $status = 'success';
        header('Content-Type: application/json');
        die(json_encode(array(
            'data' => $msg, 'status' => $status
        )));
    }

}