            <?php if($site!='edocument'){ ?>
<div class="colum2">
                <?php if($site!='calendar'){ ?>
            	<div class="box_s">
		<div class="cal">
            			<?php
                    if (!empty($year) && !empty($month)) {
                        $condition = "DATE_FORMAT(event_date, '%Y%m') = '" . $year . $month . "'";
                        $linkTocal = "/calendar/" . $year . "/" . $month;
                    } else {
                        $condition = "DATE_FORMAT(event_date, '%Y%m') = '" . date('Ym') . "'";
                        $linkTocal = "/calendar";
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
                        'show_next_prev' => TRUE, 'next_prev_url' => base_url() . $site
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
                    echo $this->calendar->generate($year, $month, $dataWork, 'short');
                    ?>
            		</div>
	</div>
            	<?php } ?>
            	<div class="box_s link">
		<div class="title_link">link ที่เกี่ยวข้อง</div>
		<ul>
			<li><a href="http://www.tobenumber1.net/">TO BE NUMBER ONE</a></li>
			<li><a href="http://www.dmh.go.th/">กรมสุขภาพจิต</a></li>
			<li><a href="http://www.oncb.go.th/">สำนักงาน ปปส.</a></li>
			<li><a href="http://nctc.oncb.go.th">ศูนย์วิชาการด้านยาเสพติด</a></li>
			<li><a href="http://www.thanyarak.go.th/thai/">สถาบันธัญญารักษ์</a></li>
			<li><a href="http://www.cbo.moph.go.th/">สสจ. ชลบุรี</a></li>
		</ul>
	</div>
    <div class="box_s status">
        <script>
        function showstat() {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    document.getElementById("statics_ga").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","/statics/",true);
            xmlhttp.send();
        }
        window.onload=showstat();
        </script>
		<div class="title_status" >สถิติการใช้</div>
		<ul id="statics_ga">
		    <li><span class="s">Loading.....</span></li>
		</ul>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
</div>
<?php } ?>
<footer>
	<strong>ศูนย์ประสานงานโครงการ TO BE NUMBER ONE จังหวัดชลบุรี</strong> <br>
	กลุ่มงานส่งเสริมสุขภาพ สำนักงานสาธารณสุข จังหวัดชลบุรี 29/9 หมู่ 4
	ตำบลบ้านสวน อำเภอเมืองชลบุรี จังหวัดชลบุรี <br> Tel: 036-932478-79 Fax:
	036-276633 E-mail: <a href="mailto:tobeno1.cbo@gmail.com" target="new">tobeno1.cbo@gmail.com</a>
</footer>
</div>
</body>
</html>