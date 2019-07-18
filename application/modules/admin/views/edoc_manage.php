<div class="main_content">
	<div class="colum-admin">
		<div class="edu-detail">
			<p>
				<img src="<?php echo base_url();?>static/images/title-manag.jpg" width="168" height="39" alt="" /><br>
			</p>
			<table width="950px" border="0" cellpadding="0" cellspacing="0" class="edu">
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
					<td class="style1"><a href="/admin/admin_edoc_verify/<?php echo $edocument['edoc_id'];?>/1"><?php echo $edocument['edoc_title'];?></a></td>
				</tr>
				<tr>
					<td class="style2">
					    <img src="<?php echo base_url();?>static/images/e-duc-detail_12.jpg" width="105" height="23" alt="" />
					</td>
					<td class="style1">
					    <a href="/admin/admin_edoc_verify/<?php echo $edocument['edoc_id'];?>/1">
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
			<p>
				<br>
				<img src="<?php echo base_url();?>static/images/title-send-rec.jpg" width="142" height="27" alt="" />
			</p>
			<div>
				<table id="rounded-corner" cellpadding="0" cellspacing="0" class="edu">
					<thead>
						<tr>
							<th scope="col" class="rounded-company" style="width: 190px;">ถึง</th>
							<th scope="col" style="width: 90px;">อ่าน</th>
							<th scope="col" style="width: 90px;">Download</th>
							<th scope="col" style="width: 90px;">Upload</th>
							<th scope="col" style="width: 90px;">สถานะปัจจุบัน</th>
							<th scope="col" style="width: 90px;"></th>
							<th scope="col" align="center" class="rounded-q4">ตรวจสอบ</th>
						</tr>
					</thead>
					<?php if(!empty($edocument['edoc_log'])){ ?>
                    <?php $file_status = $this->config->item('file_status');?>
                    <?php $group = $this->config->item('group');?>
					<tbody>
					    <?php foreach ($edocument['edoc_log'] as $key_log => $val_log){ ?>
						<tr>
							<td><?php echo $group[$val_log['edoc_group_id']];?></td>
							<td><?php if(!empty($val_log['edoc_view_count'])) { echo $val_log['edoc_view_count']; }else{ echo 0; }?></td>
							<td><?php if(!empty($val_log['edoc_download_count'])) { echo $val_log['edoc_download_count']; }else{ echo 0; }?></td>
							<td><?php if(!empty($val_log['edoc_upload_count'])) { echo $val_log['edoc_upload_count']; }else{ echo 0; }?></td>
							<td><?php echo $file_status[$val_log['edoc_verify']];?></td>
							<td>
							    <?php if(in_array($val_log['edoc_verify'], array(1,2,3,4))){ ?>
                                <a href="/admin/admin_edoc_verify/<?php echo $edocument['edoc_id'];?>/2/<?php echo $val_log['edoc_group_id'];?>">โหลดไฟล์ล่าสุด</a>
                                <?php } ?>
                            </td>
							<td align="right">
							    <?php if($val_log['edoc_verify']==2){ ?>
                                <select id="verify_edoc_<?php echo $val_log['edoc_log_id'];?>">
									<option value="2">เลือกผลการตรวจ</option>
									<option value="3">ผ่าน</option>
									<option value="4">ไม่ผ่าน</option>
                                </select>
                                <a href="javascript:void(0);" onclick="if(confirm('ยืนยันการตรวจ')){ submit_verify('<?php echo $val_log['edoc_log_id'];?>') };">บันทึก</a>
                                <?php } ?>
                            </td>
						</tr>
					    <?php } ?>
					</tbody>
					<?php } ?>
					<script>
				         function submit_verify(edoc_log_id){
				        	 var data = new FormData();
				             data.append('edoc_log_id', edoc_log_id);
				             data.append('edoc_verify', document.getElementById('verify_edoc_'+edoc_log_id).value);
				        	 var xmlhttp;
				        	 if (window.XMLHttpRequest) {
				        		  xmlhttp=new XMLHttpRequest();
				        	 }else{
				        		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				        	 }
				        	 xmlhttp.onreadystatechange=function(){
				        		  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					        		  window.location.href = window.location.href;
				        		  }
				        	 }
				        	 xmlhttp.open("POST","/admin/admin_edoc_update_verify/",true);
				        	 xmlhttp.send(data);
					     }
				    </script>
				</table>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
