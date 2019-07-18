<script>
    var upload = function(){
        if(document.getElementById('_file').files.length === 0){
            return;
        }
        document.getElementById('progressbox').style.display = '';
        var data = new FormData();
        data.append('edoc_file_sent', document.getElementById('_file').files[0]);
        data.append('edoc_id', '<?php echo $edocument['edoc_id'];?>');
        data.append('edoc_log_id', '<?php echo $edocument['edoc_log'][$dataMember->group_id]['edoc_log_id'];?>');
        var request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if(request.readyState == 4){
                try {
                    var resp = JSON.parse(request.response);
                } catch (e){
                    var resp = {
                        status: 'error',
                        data: 'Unknown error occurred: [' + request.responseText + ']'
                    };
                }
                console.log(resp.status + ': ' + resp.data);
                if(resp.status=='error'){
                	alert(resp.data);
                }else{
                	alert(resp.data);
                	window.location.href = window.location.href;
                }
            }
        };
        request.upload.addEventListener('progress', function(e){
            var percent_upload = (e.loaded/e.total) * 100;
        	document.getElementById('_progress').style.width = percent_upload + '%';
        }, false);
        request.open('POST', '/edocument/outputJSON/');
        request.send(data);
    }
</script>
<div class="main_content">
	<div class="colum1">
		<div class="edu-detail">
			<p>
				<img src="<?php echo base_url();?>static/images/title-manag.jpg" width="168" height="39" alt="" /><br>
			</p>
			<table width="730px" border="0" cellpadding="0" cellspacing="0" class="edu">
				<tr>
					<td width="30%" class="style2">
					    <img src="<?php echo base_url();?>static/images/e-duc-detail_03.jpg" width="105" height="23" alt="" />
					</td>
					<td class="style1"><?php echo $edocument['edoc_requiredate'];?></td>
				</tr>
				<tr>
					<td class="style2">
					    <img src="<?php echo base_url();?>static/images/e-duc-detail_08.jpg" width="105" height="23" alt="" />
					</td>
					<td class="style1 red"><?php $file_level = $this->config->item('file_level'); echo $file_level[$edocument['edoc_type']];?></td>
				</tr>
				<tr>
					<td class="style2">
					    <img src="<?php echo base_url();?>static/images/e-duc-detail_10.jpg" width="105" height="23" alt="" />
					</td>
					<td class="style1"><a href="/edocument/edoc_manage/<?php echo $edocument['edoc_id'];?>/1"><?php echo $edocument['edoc_title'];?></a></td>
				</tr>
				<tr>
					<td class="style2">
					    <img src="<?php echo base_url();?>static/images/e-duc-detail_12.jpg" width="105" height="23" alt="" />
					</td>
					<td class="style1">
					    <a href="/edocument/edoc_manage/<?php echo $edocument['edoc_id'];?>/1">
					        <?php $type = str_replace('.', '', strtolower(substr($edocument['edoc_file_original'], -4)));?>
    					    <?php  switch ($type) {
                                        case 'pdf' :
                                            $showFileType = 'download_pdf.jpg';
                                            break;
                                        case 'xls' :
                                        case 'xlsx' :
                                            $showFileType = 'download_pdf.jpg';
                                            break;
                                        case 'doc' :
                                        case 'docx' :
                                            $showFileType = 'download_word.jpg';
                                            break;
                                        case 'txt' :
                                            $showFileType = 'download_text.png';
                                            break;
                                        default :
                                            $showFileType = 'download_text.png';
                                    }
                            ?>
					        <img src="<?php echo base_url();?>static/images/<?php echo $showFileType;?>" width="30" height="45" alt="" />
					    </a>
					</td>
				</tr>
				<tr>
					<td class="style2">
					    <img src="<?php echo base_url();?>static/images/e-duc-detail_14.jpg" width="105" height="23" alt="" />
					</td>
					<td class="style1">
					<?php $group = $this->config->item('group');?>
					<?php foreach ($edocument['edoc_log'] as $key_log => $val_log){ ?>
					           <?php echo '- ' . $group[$val_log['edoc_group_id']] . '<br >';?>
					<?php } ?>
					</td>
				</tr>
			</table>
			<p class="btn">
				<a href="/edocument/edoc_view">
				    <img src="<?php echo base_url();?>static/images/e-duc-detail_17.jpg" width="160" height="42" alt="" />
				</a>
				<?php if(in_array($edocument['edoc_log'][$dataMember->group_id]['edoc_verify'],array(0,1,4))){ ?>
				<a href="javascript:void(0);">
				    <input type='file' id='_file' class="file_upload" onchange="upload();">
				    <img src="<?php echo base_url();?>static/images/e-duc-detail_19.jpg" width="160" height="42" alt="" />
				</a>
				<?php } ?>
			</p>
			<br >
			<div id="progressbox" class='progress_outer' style="display: none">
    			<div id='_progress' class='progress'></div>
    		</div>
			<p>
				<br> <img src="<?php echo base_url();?>static/images/title-send-rec.jpg" width="142" height="27" alt="" />
			</p>
			<div class="edu">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th width="35%">
						    <img src="<?php echo base_url();?>static/images/e-duc-detail_37.jpg" width="45" height="39" alt="" />
						</th>
						<th width="15%">
						    <img src="<?php echo base_url();?>static/images/e-duc-detail_27.jpg" width="34" height="39" alt="" />
						</th>
						<th width="15%">
						    <img src="<?php echo base_url();?>static/images/e-duc-detail_30.jpg" width="72" height="39" alt="" />
						</th>
						<th width="15%">
						    <img src="<?php echo base_url();?>static/images/e-duc-detail_34.jpg" width="51" height="39" alt="" />
						</th>
						<th width="20%">
						    <img src="<?php echo base_url();?>static/images/e-duc-detail_36.jpg" width="94" height="39" alt="" />
						</th>
					</tr>
					<?php foreach ($edocument['edoc_log'] as $key => $val){ ?>
					<tr class="style1">
						<td><?php echo $group[$val['edoc_group_id']];?></td>
						<td><?php if(!empty($val['edoc_view_count'])) { echo $val['edoc_view_count']; }else{ echo 0; }?></td>
						<td><?php if(!empty($val['edoc_download_count'])) { echo $val['edoc_download_count']; }else{ echo 0; }?></td>
						<td><?php if(!empty($val['edoc_upload_count'])) { echo $val['edoc_upload_count']; }else{ echo 0; }?></td>
						<td class="left blue">
						    <?php  switch ($val['edoc_verify']) {
                                        case 0 :
                                            $statusType = 'yellow.png';
                                            $text = 'รอดาวน์โหลด';
                                            break;
                                        case 1 :
                                            $statusType = 'yellow.png';
                                            $text = 'รอตรวจ';
                                            break;
                                        case 2 :
                                            $statusType = 'yellow.png';
                                            $text = 'กำลังตรวจ';
                                            break;
                                        case 3 :
                                            $statusType = 'green.png';
                                            $text = 'ผ่าน';
                                            break;
                                        case 4 :
                                            $statusType = 'red.png';
                                            $text = 'ไม่ผ่าน';
                                            break;
                                    }
                            ?>
						    <img src="<?php echo base_url();?>static/images/<?php echo $statusType;?>" width="11" height="11" alt="" /> <?php echo $text;?>
						</td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>