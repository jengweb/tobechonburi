<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->library('encrypt');
        $this->load->helper('url');
        $this->load->helper('path');
        $this->load->helper('cookie');
    }

    public function index() {
        $cookie = $this->input->cookie('admin');
        if (empty($cookie)) {
            $this->load->view('header_admin', array(
                'index' => true
            ));
            $this->load->view('login');
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/dashboard/');
        }
    }

    function admin_login() {
        $query = "SELECT * FROM member WHERE username='" . $_POST['username'] . "' AND password='" . md5(
                $this->config->item('encryption_key') . $_POST['password']) . "' AND group_id='99'";
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
            $this->input->set_cookie('admin', json_encode($dataCookie), time() + (3600 * 24 * 365));
            redirect('/admin/dashboard/');
        } else {
            redirect('/admin/');
        }
    }

    function admin_logout() {
        delete_cookie("admin");
        redirect('/admin/');
    }

    function dashboard($year = null, $month = null) {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            // Start Calendar

            if (!empty($year) && !empty($month)) {
                $condition = "DATE_FORMAT(event_date, '%Y%m') = '" . $year . $month . "'";
                $linkTocal = "/admin/admin_calendars/" . $year . "/" . $month;
            } else {
                $condition = "DATE_FORMAT(event_date, '%Y%m') = '" . date('Ym') . "'";
                $linkTocal = "/admin/admin_calendars/";
            }
            $queryCal = "SELECT *,DATE_FORMAT(event_date, '%d') AS event_date FROM Calendar WHERE " . $condition;
            $resultCal = $this->dbr->GetArray($queryCal);
            $dataWork = array();
            if (!empty($resultCal)) {
                foreach ($resultCal as $key => $val) {
                    $dataWork[intval($val['event_date'])] = '';
                }
            }
            $prefs = array(
                'show_next_prev' => TRUE, 'next_prev_url' => base_url() . "admin/dashboard"
            );
            $prefs['template'] = '{table_open}<table class="cal-table">{/table_open}
                    {heading_row_start}<caption class="cal-caption">{/heading_row_start}
                        {heading_previous_cell}<a href="{previous_url}" class="prev">&#8249;</a>{/heading_previous_cell}
                        {heading_next_cell}<a href="{next_url}" class="next">&#8250;</a>{/heading_next_cell}
                        {heading_title_cell}<span class="calen"> {heading}</span>{/heading_title_cell}
                    {heading_row_end}</caption><tbody class="cal-body">{/heading_row_end}
                        {week_row_start}<tr class="day">{/week_row_start}
                        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
                        {week_row_end}</tr>{/week_row_end}

                        {cal_row_start}<tr>{/cal_row_start}
                        {cal_cell_start}<td>{/cal_cell_start}

                        {cal_cell_content}<div class="cal-check"><a href="' . $linkTocal . '">{day}<br />{content}</a></div>{/cal_cell_content}
                        {cal_cell_content_today}<div class="cal-check cal-selected"><a href="' . $linkTocal . '">{day}<br />{content}</a></div>{/cal_cell_content_today}

                        {cal_cell_no_content}<a href="javascript:void(0);">{day}</a>{/cal_cell_no_content}
                        {cal_cell_no_content_today}<div class="cal-selected"><a href="javascript:void(0);">{day}</a></div>{/cal_cell_no_content_today}

                        {cal_cell_blank}&nbsp;{/cal_cell_blank}

                        {cal_cell_end}</td>{/cal_cell_end}
                        {cal_row_end}</tr>{/cal_row_end}
                    {table_close}</tbody></table>{/table_close}';
            $this->load->library('calendar', $prefs);
            $data['calendars'] = $this->calendar->generate($year, $month, $dataWork, 'short');
            $this->load->view(
                    'header_admin',
                    array(
                        'index' => true
                    ));
            // End Calendar
            $queryInfo = "SELECT * FROM Information ORDER BY info_createdate DESC LIMIT 0,8";
            $data['informations'] = $this->dbr->GetArray($queryInfo);
            foreach ($data['informations'] as $key => $val) {
                $queryImgInfo = "SELECT * FROM Info_Image WHERE info_id=" . $val['info_id'] . " ORDER BY image_id ASC";
                $data['informations'][$key]['img'] = $this->dbr->GetRow($queryImgInfo);
            }
            $this->load->view('dashboard', $data);
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_member() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view(
                    'header_admin',
                    array(
                        'member' => true
                    ));
            $data['member'] = $this->dbr->getAll(
                    "SELECT member_id,email,username,group_id,note,DATE_FORMAT(create_date, '%Y-%m-%d') AS create_date,DATE_FORMAT(last_login, '%Y-%m-%d') AS last_login FROM member WHERE group_id!='99'");
            $this->load->view('member', $data);
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_member_insert() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view(
                    'header_admin',
                    array(
                        'member' => true
                    ));
            $this->load->view('member_manage');
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_member_edit($member_id = 0) {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            if (!empty($member_id)) {
                $this->load->view(
                        'header_admin',
                        array(
                            'member' => true
                        ));
                $data['member'] = $this->dbr->getRow(
                        "SELECT * FROM member WHERE member_id=" . $member_id);
                $this->load->view('member_manage', $data);
                $this->load->view('footer_admin');
            } else {
                redirect('/admin/admin_member/');
            }
        } else {
            redirect('/admin/');
        }
    }

    function admin_member_insert_update() {
        $dataMember = array();
        $member_id = $this->input->post('member_id');
        $dataMember['email'] = $this->input->post('email');
        $dataMember['username'] = $this->input->post('username');
        $dataMember['group_id'] = $this->input->post('group_id');
        $dataMember['note'] = $this->input->post('note');
        if (!empty($member_id)) {
            if (isset($_POST['change_pass'])) {
                $dataMember['password'] = md5(
                        $this->config->item('encryption_key') . $this->input->post('password'));
            }
            $this->dbr->AutoExecute("member", $dataMember, "UPDATE", "member_id=" . $member_id);
        } else {
            $dataMember['password'] = md5(
                    $this->config->item('encryption_key') . $this->input->post('password'));
            $dataMember['create_date'] = date("Y-m-d H:i:s");
            $this->dbr->AutoExecute("member", $dataMember, "INSERT");
        }
        redirect('/admin/admin_member/');
    }

    function admin_member_delete($member_id = 0) {
        if (!empty($member_id)) {
            $this->dbr->Execute("DELETE FROM member WHERE member_id=" . $member_id);
        }
        redirect('/admin/admin_member/');
    }

    function admin_calendars($year = null, $month = null) {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $prefs = array(
                'show_next_prev' => TRUE, 'next_prev_url' => base_url() . "admin/admin_calendars"
            );
            $prefs['template'] = '{table_open}<table class="cal-table">{/table_open}
                    {heading_row_start}<caption class="cal-caption">{/heading_row_start}
                        {heading_previous_cell}<a href="{previous_url}" class="prev">&#8249;</a>{/heading_previous_cell}
                        {heading_next_cell}<a href="{next_url}" class="next">&#8250;</a>{/heading_next_cell}
                        {heading_title_cell}<span class="calen"> {heading}</span>{/heading_title_cell}
                    {heading_row_end}</caption><tbody class="cal-body">{/heading_row_end}
                        {week_row_start}<tr class="day">{/week_row_start}
                        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
                        {week_row_end}</tr>{/week_row_end}

                        {cal_row_start}<tr>{/cal_row_start}
                        {cal_cell_start}<td>{/cal_cell_start}

                        {cal_cell_content}<div class="cal-check"><a class="fancybox" href="#{day}">{day}<br />{content}</a></div>{/cal_cell_content}
                        {cal_cell_content_today}<div class="cal-check cal-selected"><a class="fancybox" href="#{day}">{day}<br />{content}</a></div>{/cal_cell_content_today}

                        {cal_cell_no_content}<a href="javascript:void(0);">{day}</a>{/cal_cell_no_content}
                        {cal_cell_no_content_today}<div class="cal-selected"><a href="javascript:void(0);">{day}</a></div>{/cal_cell_no_content_today}

                        {cal_cell_blank}&nbsp;{/cal_cell_blank}

                        {cal_cell_end}</td>{/cal_cell_end}
                        {cal_row_end}</tr>{/cal_row_end}
                    {table_close}</tbody></table>{/table_close}';
            $this->load->library('calendar', $prefs);
            if (!empty($year) && !empty($month)) {
                $condition = "DATE_FORMAT(event_date, '%Y%m') = '" . $year . $month . "'";
            } else {
                $condition = "DATE_FORMAT(event_date, '%Y%m') = '" . date('Ym') . "'";
            }
            $queryCal = "SELECT *,DATE_FORMAT(event_date, '%d') AS event_date FROM Calendar WHERE " . $condition;
            $resultCal = $this->dbr->GetArray($queryCal);
            $dataWork = array();
            $dataEvent = array();
            if (!empty($resultCal)) {
                foreach ($resultCal as $key => $val) {
                    if (!isset($dataWork[$val['event_date']])) {
                        $dataWork[intval($val['event_date'])] = "- " . $val['event_detail'];
                        $dataEvent[intval($val['event_date'])] = '<li><p><a href="javascript:void(0)" onclick="if(confirm(\'ยืนยันการลบ\')) {  window.location=\'/admin/admin_calendars_delete/' . $val['event_id'] . '\' } ">[ลบ] </a> - ' . $val['event_detail'] . '</p></li>';
                    } else {
                        $dataWork[intval($val['event_date'])] .= "<br/>- " . $val['event_detail'];
                        $dataEvent[intval($val['event_date'])] .= '<li><p><a href="javascript:void(0)" onclick="if(confirm(\'ยืนยันการลบ\')) {  window.location=\'/admin/admin_calendars_delete/' . $val['event_id'] . '\' } ">[ลบ] </a> - ' . $val['event_detail'] . '</p></li>';
                    }
                }
            }
            $data['calendars_event'] = $dataEvent;
            $data['calendars'] = $this->calendar->generate($year, $month, $dataWork);
            $this->load->view(
                    'header_admin',
                    array(
                        'calendars' => true,
                        'css' => array(
                            'source/helpers/jquery.fancybox-buttons.css?v=1.0.5',
                            'source/helpers/jquery.fancybox-thumbs.css?v=1.0.7'
                        ),
                        'js' => array(
                            'lib/jquery-1.10.1.min.js', 'lib/jquery.mousewheel-3.0.6.pack.js',
                            'source/jquery.fancybox.js?v=2.1.5',
                            'source/helpers/jquery.fancybox-buttons.js?v=1.0.5',
                            'source/helpers/jquery.fancybox-thumbs.js?v=1.0.7',
                            'source/helpers/jquery.fancybox-media.js?v=1.0.6'
                        )
                    ));
            $this->load->view('calendars', $data);
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_calendars_delete($event_id = 0) {
        if (!empty($event_id)) {
            $this->dbr->Execute("DELETE FROM Calendar WHERE event_id=" . $event_id);
        }
        redirect('/admin/admin_calendars/');
    }

    function admin_calendars_manage() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view(
                    'header_admin',
                    array(
                        'calendars' => true
                    ));
            $this->load->view('calendars_manage');
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function calendars_manage() {
        $dataCalendar = array();
        $dataCalendar['event_date'] = $this->input->post('event_date');
        $dataCalendar['event_detail'] = $this->input->post('event_detail');
        if (!empty($dataCalendar)) {
            $this->dbr->AutoExecute("Calendar", $dataCalendar, "INSERT");
        }
        redirect('/admin/admin_calendars/');
    }

    function admin_files() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view('header_admin', array(
                'files' => true
            ));
            $condition = '';
            if (!empty($_POST['keyword'])) {
                $condition = "AND file_title LIKE '%" . $_POST['keyword'] . "%' OR file_detail LIKE '%" . $_POST['keyword'] . "%'";
            }
            $data['files'] = $this->dbr->getAll("SELECT * FROM FileDownload WHERE file_status='Y' " . $condition);
            $this->load->view('files', $data);
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_files_insert() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view('header_admin', array(
                'files' => true
            ));
            $this->load->view('files_manage', array());
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_files_edit($file_id = 0) {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            if (!empty($file_id)) {
                $this->load->view(
                        'header_admin',
                        array(
                            'files' => true
                        ));
                $data['files'] = $this->dbr->getRow(
                        "SELECT * FROM FileDownload WHERE file_id=" . $file_id);
                $this->load->view('files_manage', $data);
                $this->load->view('footer_admin');
            } else {
                redirect('/admin/');
            }
        } else {
            redirect('/admin/');
        }
    }

    function admin_files_delete($file_id = 0) {
        if (!empty($file_id)) {
            $files = $this->dbr->getRow("SELECT * FROM FileDownload WHERE file_id=" . $file_id);
            unlink(set_realpath("static/upload/files") . $files['file_name']);
            unlink(set_realpath("static/upload/thumb") . $files['file_thumbnail']);
            $filesUpdate = array();
            $filesUpdate['file_status'] = 'N';
            $this->dbr->AutoExecute("FileDownload", $filesUpdate, "UPDATE", "file_id=" . $file_id);
            //$this->dbr->Execute("DELETE FROM FileDownload WHERE file_id=" . $file_id);
        }
        redirect('/admin/admin_files/');
    }

    function files_manage() {
        $file_id = $this->input->post('file_id');
        if (!empty($_FILES)) {
            if ($_FILES["file_thumbnail"]["error"] > 0 || $_FILES["file_name"]["error"] > 0) {
                redirect('/admin/');
            } else {
                if (file_exists(
                        set_realpath("static/upload/thumb") . $_FILES["file_thumbnail"]["name"]) || file_exists(
                        set_realpath("static/upload/files") . $_FILES["file_name"]["name"])) {
                    echo "  <!doctype html>
                                <html>
                                    <head>
                                        <META charset=\"UTF-8\">
                                    </head>
                                    <body>
                                        <script>
                                            alert('ชื่อไฟล์ซ้ำ ไม่สามารถอัพโหลดไฟล์ได้ค่ะ');
                                            location.href = '/admin/admin_files/'
                                        </script>
                                    </body>
                                </html>";
                    exit();
                } else {
                    $filesInsert = array();
                    $filesInsert['file_title'] = $this->input->post('file_title');
                    $filesInsert['file_detail'] = $this->input->post('file_detail');
                    $filesInsert['file_create_date'] = date("Y-m-d H:i:s");
                    $filesInsert['file_thumbnail'] = $_FILES["file_thumbnail"]["name"];
                    $filesInsert['file_name'] = $_FILES["file_name"]["name"];
                    $filesInsert['file_sizes'] = $_FILES["file_name"]["size"];
                    $this->dbr->AutoExecute("FileDownload", $filesInsert, "INSERT");
                    move_uploaded_file(
                            $_FILES["file_thumbnail"]["tmp_name"],
                            set_realpath("static/upload/thumb") . $_FILES["file_thumbnail"]["name"]);
                    move_uploaded_file(
                            $_FILES["file_name"]["tmp_name"],
                            set_realpath("static/upload/files") . $_FILES["file_name"]["name"]);
                }
                redirect('/admin/admin_files/');
            }
        } elseif (!empty($file_id)) {
            $filesUpdate = array();
            $filesUpdate['file_title'] = $this->input->post('file_title');
            $filesUpdate['file_detail'] = $this->input->post('file_detail');
            $this->dbr->AutoExecute("FileDownload", $filesUpdate, "UPDATE", "file_id=" . $file_id);
            redirect('/admin/admin_files/');
        } else {
            redirect('/admin/');
        }
    }

    function admin_informations() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view(
                    'header_admin',
                    array(
                        'informations' => true
                    ));
            $condition = '';
            if (!empty($_POST['keyword'])) {
                $condition = " WHERE (info_title LIKE '%" . $_POST['keyword'] . "%' OR info_detail LIKE '%" . $_POST['keyword'] . "%')";
            }
            if (!empty($_POST['info_type'])) {
                if (!empty($condition)) {
                    $condition .= " OR info_type=" . $_POST['info_type'];
                } else {
                    $condition = " WHERE info_type=" . $_POST['info_type'];
                }
            }
            $sql = "SELECT info_id,info_title,info_detail,info_type,DATE_FORMAT(info_createdate,'%Y-%m-%d') AS info_createdate,DATE_FORMAT(info_editdate,'%Y-%m-%d') AS info_editdate,info_view_count FROM Information" . $condition . " ORDER BY info_createdate";
            $data['informations'] = $this->dbr->getAll($sql);
            $this->load->view('informations', $data);
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_informations_insert() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view(
                    'header_admin',
                    array(
                        'informations' => true
                    ));
            $this->load->view('informations_manage');
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_informations_edit($info_id = 0) {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            if (!empty($info_id)) {
                $this->load->view(
                        'header_admin',
                        array(
                            'member' => true
                        ));
                $data['informations'] = $this->dbr->getRow(
                        "SELECT * FROM Information WHERE info_id=" . $info_id);
                $data['informations_img'] = $this->dbr->getAll(
                        "SELECT * FROM Info_Image WHERE info_id=" . $info_id);
                $this->load->view('informations_manage', $data);
                $this->load->view('footer_admin');
            } else {
                redirect('/admin/admin_member/');
            }
        } else {
            redirect('/admin/');
        }
    }

    function admin_informations_delete($info_id = 0) {
        if (!empty($info_id)) {
            $infoImage = $this->dbr->getArray("SELECT * FROM Info_Image WHERE info_id=" . $info_id);
            if (!empty($infoImage)) {
                foreach ($infoImage as $key => $val) {
                    unlink(set_realpath("static/upload/informations") . $val['image_name']);
                }
            }
            $this->dbr->Execute("DELETE FROM Information WHERE info_id=" . $info_id);
            $this->dbr->Execute("DELETE FROM Info_Image WHERE info_id=" . $info_id);
        }
        redirect('/admin/admin_informations/');
    }

    function informations_manage() {
        $filePost = $this->reArrayFiles($_FILES['Info_Image']);
        $info_id = $this->input->post('info_id');
        if (!empty($info_id)) {
            if ($filePost[0]['error'] <= 0) {
                foreach ($_POST['image_id_del'] as $key => $val) {
                    if (!empty($val)) {
                        $imgInfoName = $this->dbr->getOne(
                                "SELECT image_name FROM Info_Image WHERE image_id=" . $val);
                        unlink(set_realpath("static/upload/informations") . $imgInfoName);
                        $this->dbr->Execute("DELETE FROM Info_Image WHERE image_id=" . $val);
                    }
                }
                foreach ($filePost as $key => $val) {
                    if ($val['error'] <= 0) {
                        $type = strtolower(substr($val['name'], -4));
                        $imgInfoName = md5($info_id . microtime()) . $type;
                        move_uploaded_file(
                                $val["tmp_name"],
                                set_realpath("static/upload/informations") . $imgInfoName);
                        $infoImage = array();
                        $infoImage['image_name'] = $imgInfoName;
                        $infoImage['info_id'] = $info_id;
                        $this->dbr->AutoExecute("Info_Image", $infoImage, "INSERT");
                    }
                }
                $infoUpdate = array();
                $infoUpdate['info_title'] = $this->input->post('info_title');
                $infoUpdate['info_detail'] = $this->input->post('info_detail');
                $infoUpdate['info_type'] = $this->input->post('info_type');
                $infoUpdate['info_editdate'] = date("Y-m-d H:i:s");
                $this->dbr->AutoExecute("Information", $infoUpdate, "UPDATE", "info_id=" . $info_id);
                redirect('/admin/admin_informations/');
            } else {
                redirect('/admin/');
            }
        } else {
            if (!empty($filePost)) {
                $infoInsert = array();
                $infoInsert['info_title'] = $this->input->post('info_title');
                $infoInsert['info_detail'] = $this->input->post('info_detail');
                $infoInsert['info_type'] = $this->input->post('info_type');
                $infoInsert['info_createdate'] = date("Y-m-d H:i:s");
                $this->dbr->AutoExecute("Information", $infoInsert, "INSERT");
                $newInfoId = $this->dbr->insert_id();
                foreach ($filePost as $key => $val) {
                    if ($val['error'] <= 0) {
                        $type = strtolower(substr($val['name'], -4));
                        $imgInfoName = md5($newInfoId . microtime()) . $type;
                        move_uploaded_file(
                                $val["tmp_name"],
                                set_realpath("static/upload/informations") . $imgInfoName);
                        $infoImage = array();
                        $infoImage['image_name'] = $imgInfoName;
                        $infoImage['info_id'] = $newInfoId;
                        $this->dbr->AutoExecute("Info_Image", $infoImage, "INSERT");
                    }
                }
                redirect('/admin/admin_informations/');
            } else {
                redirect('/admin/');
            }
        }
    }

    function reArrayFiles(&$file_post) {
        $file_array = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_array[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_array;
    }

    function admin_edoc() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view(
                    'header_admin',
                    array(
                        'edocument' => true
                    ));
            $edocument = $this->dbr->getAll(
                    "SELECT edoc_id,edoc_title,edoc_file_original,edoc_type,DATE_FORMAT(edoc_requiredate, '%Y-%m-%d') AS edoc_requiredate,DATE_FORMAT(edoc_create_date, '%Y-%m-%d') AS edoc_create_date FROM Edocument WHERE edoc_status='Y'");
            $data = array();
            $data['edocument'] = $edocument;
            if (!empty($edocument)) {
                foreach ($edocument as $key => $val) {
                    $data['edocument'][$key]['edoc_log'] = $this->dbr->getAll(
                            "SELECT * FROM Edocument_log WHERE edoc_id=" . $val['edoc_id']);
                }
            }
            $this->load->view('edocument', $data);
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_edoc_verify($edoc_id = null, $download = 0, $adminLoad = 0) {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view(
                    'header_admin',
                    array(
                        'edocument' => true
                    ));
            $edocument = $this->dbr->getRow(
                    "SELECT edoc_id,edoc_title,edoc_file_original,edoc_type,DATE_FORMAT(edoc_requiredate, '%Y-%m-%d') AS edoc_requiredate,DATE_FORMAT(edoc_create_date, '%Y-%m-%d') AS edoc_create_date FROM Edocument WHERE edoc_status='Y' AND edoc_id = " . $edoc_id);
            $data = array();
            $data['edocument'] = $edocument;
            $result_log = $this->dbr->getAll(
                    "SELECT * FROM Edocument_log WHERE edoc_id=" . $edoc_id);
            $edoc_log = array();
            foreach ($result_log as $key => $val) {
                $edoc_log[$val['edoc_group_id']] = $val;
            }
            $data['edocument']['edoc_log'] = $edoc_log;
            if ($download == 1) {
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
                }
            } elseif ($download == 2 && !empty($adminLoad)) {
                if (file_exists(
                        set_realpath("static/upload/edocument_user") . $data['edocument']['edoc_log'][$adminLoad]["edoc_file_sent"])) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header(
                            'Content-Disposition: attachment; filename=' . basename(
                                    set_realpath("static/upload/edocument_user") . $data['edocument']['edoc_log'][$adminLoad]["edoc_file_sent"]));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header(
                            'Content-Length: ' . filesize(
                                    set_realpath("static/upload/edocument_user") . $data['edocument']['edoc_log'][$adminLoad]["edoc_file_sent"]));
                    readfile(
                            set_realpath("static/upload/edocument_user") . $data['edocument']['edoc_log'][$adminLoad]["edoc_file_sent"]);
                    if ($data['edocument']['edoc_log'][$adminLoad]["edoc_verify"] == 1) {
                        $edocLogUpdate = array();
                        $edocLogUpdate['edoc_verify'] = 2;
                        $this->dbr->AutoExecute(
                                "Edocument_log", $edocLogUpdate, "UPDATE",
                                "edoc_log_id=" . $data['edocument']['edoc_log'][$adminLoad]["edoc_log_id"]);
                    }
                }
            } else {
                $this->load->view('edoc_manage', $data);
            }
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_edoc_insert() {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            $this->load->view(
                    'header_admin',
                    array(
                        'edocument' => true
                    ));
            $this->load->view('edocument_manage');
            $this->load->view('footer_admin');
        } else {
            redirect('/admin/');
        }
    }

    function admin_edoc_edit($edoc_id = 0) {
        $cookie = $this->input->cookie('admin');
        if (!empty($cookie)) {
            if (!empty($edoc_id)) {
                $this->load->view(
                        'header_admin',
                        array(
                            'edocument' => true
                        ));
                $edocument = $this->dbr->getRow(
                        "SELECT *,DATE_FORMAT(edoc_requiredate, '%Y-%m-%d') AS edoc_requiredate FROM Edocument WHERE edoc_id=" . $edoc_id);
                $data = array();
                $data['edocument'] = $edocument;
                $data['edocument']['edoc_log'] = $this->dbr->getAll(
                        "SELECT * FROM Edocument_log WHERE edoc_id=" . $edocument['edoc_id']);
                $this->load->view('edocument_manage', $data);
                $this->load->view('footer_admin');
            } else {
                redirect('/admin/');
            }
        } else {
            redirect('/admin/');
        }
    }

    function admin_edoc_delete($edoc_id = 0) {
        if (!empty($edoc_id)) {
            $this->dbr->AutoExecute(
                    "Edocument",
                    array(
                        'edoc_status' => 'N'
                    ), "UPDATE", "edoc_id=" . $edoc_id);
        }
        redirect('/admin/admin_edoc/');
    }

    function admin_edoc_update_verify() {
        if (!empty($_POST['edoc_log_id'])) {
            $this->dbr->AutoExecute(
                    "Edocument_log",
                    array(
                        'edoc_verify' => $_POST['edoc_verify']
                    ), "UPDATE", "edoc_log_id=" . $_POST['edoc_log_id']);
        }
    }

    function admin_edoc_manage() {
        $edoc_id = $this->input->post('edoc_id');
        $group_id = $this->input->post('group_id');
        if (!empty($edoc_id)) {
            $edocUpdate = array();
            $edocUpdate['edoc_title'] = $this->input->post('edoc_title');
            $edocUpdate['edoc_requiredate'] = $this->input->post('edoc_requiredate');
            $edocUpdate['edoc_type'] = $this->input->post('edoc_type');
            $this->dbr->AutoExecute("Edocument", $edocUpdate, "UPDATE", "edoc_id=" . $edoc_id);
            redirect('/admin/admin_edoc/');
        } else {
            if ($_FILES['edoc_file_original']['error'] <= 0 && !empty($group_id)) {
                if (file_exists(
                        set_realpath("static/upload/edocument") . $_FILES['edoc_file_original']["name"])) {
                    echo "  <!doctype html>
                                <html>
                                    <head>
                                        <META charset=\"UTF-8\">
                                    </head>
                                    <body>
                                        <script>
                                            alert('ชื่อไฟล์ซ้ำ ไม่สามารถอัพโหลดไฟล์ได้ค่ะ');
                                            location.href = '/admin/admin_edoc/'
                                        </script>
                                    </body>
                                </html>";
                    exit();
                } else {
                    $edocInsert = array();
                    $edocInsert['edoc_title'] = $this->input->post('edoc_title');
                    $edocInsert['edoc_requiredate'] = $this->input->post('edoc_requiredate');
                    $edocInsert['edoc_type'] = $this->input->post('edoc_type');
                    $edocInsert['edoc_create_date'] = date("Y-m-d H:i:s");
                    $edocInsert['edoc_file_original'] = $_FILES["edoc_file_original"]["name"];
                    $this->dbr->AutoExecute("Edocument", $edocInsert, "INSERT");
                    $newEdocId = $this->dbr->insert_id();
                    foreach ($group_id as $key => $val) {
                        $elogInsert = array();
                        $elogInsert['edoc_id'] = $newEdocId;
                        $elogInsert['edoc_group_id'] = $val;
                        $elogInsert['edoc_verify'] = 0;
                        $this->dbr->AutoExecute("Edocument_log", $elogInsert, "INSERT");
                    }
                    move_uploaded_file(
                            $_FILES["edoc_file_original"]["tmp_name"],
                            set_realpath("static/upload/edocument") . $_FILES["edoc_file_original"]["name"]);
                }
                redirect('/admin/admin_edoc/');
            } else {
                redirect('/admin/');
            }
        }
    }

}