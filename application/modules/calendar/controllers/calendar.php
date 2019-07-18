<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->adodb_loader->load('read');
        $this->load->helper('url');
    }

    public function index($year = null, $month = null) {
		$title = "ปฏิทินกิจกรรม";
        $this->load->view(
                'header',
                array(
                    'calendar' => true,
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
                    ),
					'title' => $title
                ));
        $prefs = array(
            'show_next_prev' => TRUE, 'next_prev_url' => base_url() . "calendar"
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
                        {cal_cell_content_today}<div class="cal-check cal-selected"><a href="javascript:void(0);">{day}<br />{content}</a></div>{/cal_cell_content_today}

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
                    $dataEvent[intval($val['event_date'])] = '<li><p> - '.$val['event_detail'].'</p></li>';
                } else {
                    $dataWork[intval($val['event_date'])] .= "<br/>- " . $val['event_detail'];
                    $dataEvent[intval($val['event_date'])] .= '<li><p> - '.$val['event_detail'].'</p></li>';
                }
            }
        }
        $data['calendars_event'] = $dataEvent;
        $data['calendars'] = $this->calendar->generate($year, $month, $dataWork);
        $this->load->view('calendar', $data);
        $this->load->view('footer', array(
            'site' => 'calendar'
        ));
    }

}