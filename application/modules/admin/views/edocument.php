<div class="main_content">
	<div class="title-admin">E-document</div>
	<div class="add-button">
		<a href="/admin/admin_edoc_insert/" class="add-edoc" title="เพิ่มสมาชิก"></a>
	</div>
	<div class="colum-admin">
		<table id="rounded-corner" cellpadding="0" cellspacing="0" class="edu">
			<thead>
				<tr>
					<th scope="col" class="rounded-company" style="width: 75px;">กำหนดส่ง</th>
					<th scope="col" style="width: 70px;">ความเร่งด่วน</th>
					<th scope="col" style="width: 45px;">เอกสาร</th>
					<th scope="col" style="width: 220px;">หนังสือ</th>
					<th scope="col" style="width: 190px;">หน่วยงานทั้งหมด</th>
					<th scope="col" style="width: 55px;">ตรวจแล้ว</th>
					<th scope="col" style="width: 45px;">รอตรวจ</th>
					<th scope="col" align="center" class="rounded-q4"></th>
				</tr>
			</thead>
			<tbody>
			    <?php
                $num = count($edocument);
                $group = $this->config->item('group');
                $fileLevel = $this->config->item('file_level');
                foreach ($edocument as $key => $val) {
                ?>
				<tr>
					<td <?php if($num==$key+1){ echo 'class="rounded-foot-left"'; }?>><?php echo $val['edoc_requiredate'];?></td>
					<td class="red"><?php echo $fileLevel[$val['edoc_type']];?></td>
					<td>
                        <?php $type = str_replace('.', '', strtolower(substr($val['edoc_file_original'], -4)));?>
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
                        <img src="<?php echo base_url();?>static/images/<?php echo $showFileType;?>" width="32" height="47" alt="" />
					</td>
					<td><?php echo $val['edoc_title'];?></td>
					<td>
					    <?php $filePending = 0;?>
					    <?php $fileApprove = 0;?>
                        <?php foreach ($val['edoc_log'] as $key_log => $val_log){ ?>
                        - <?php echo $group[$val_log['edoc_group_id']];?> <br>
                        <?php if($val_log['edoc_verify']==1){ $filePending++; } ?>
                        <?php if($val_log['edoc_verify']==3 || $val_log['edoc_verify']==4){ $fileApprove++; } ?>
                        <?php } ?>
					</td>
					<td><?php echo $fileApprove; ?></td>
					<td><?php echo $filePending; ?></td>
					<td <?php if($num==$key+1){ echo 'class="rounded-foot-right"'; }?>>
						<a href="/admin/admin_edoc_edit/<?php echo $val['edoc_id'];?>">แก้ไข</a> |
						<a href="/admin/admin_edoc_verify/<?php echo $val['edoc_id'];?>" target="_blank">จัดการ</a> |
					    <a href="/admin/admin_edoc_delete/<?php echo $val['edoc_id'];?>">ลบ</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="clear"></div>
</div>