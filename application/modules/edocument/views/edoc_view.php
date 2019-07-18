<div class="main_content">
	<div class="colum1">
		<div class="edu">
			<p style="height:50px;">
				<img src="<?php echo base_url();?>static/images/title-manag.jpg" width="168" height="39" alt="" />
				<a href="/edocument/member_logout/">
					<img src="<?php echo base_url();?>static/images/e-duc-detail_21.jpg" width="160" height="42" alt="" style="float:right;"/>
				</a>
			</p>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th width="15%">
					    <img src="<?php echo base_url();?>static/images/e-duc_01.jpg" width="67" height="38" alt="" />
                    </th>
					<th width="10%">
					    <img src="<?php echo base_url();?>static/images/e-duc_02.jpg" width="71" height="39" alt="" />
					</th>
					<th width="10%">
					    <img src="<?php echo base_url();?>static/images/e-duc_03.jpg" width="40" height="38" alt="" />
					</th>
					<th width="35%">
					    <img src="<?php echo base_url();?>static/images/e-duc_04.jpg" width="48" height="39" alt="" />
					</th>
					<th width="30%">
					    <img src="<?php echo base_url();?>static/images/e-duc_05.jpg" width="57" height="38" alt="" />
					</th>
				</tr>
				<?php if (!empty($edocument)) {
				$group = $this->config->item('group');
                $fileLevel = $this->config->item('file_level');
                ?>
				<?php foreach ($edocument as $key => $val) { ?>
				<tr class="<?php if($key%2==0){ echo 'style1'; }else{ echo 'style2'; }?>">
					<td><?php echo $val['edoc_requiredate'];?></td>
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
                        <a href="/edocument/edoc_manage/<?php echo $val['edoc_id']; ?>">
                            <img src="<?php echo base_url();?>static/images/<?php echo $showFileType;?>" width="32" height="47" alt="" />
                        </a>
                    </td>
					<td class="left">
                        <a href="/edocument/edoc_manage/<?php echo $val['edoc_id']; ?>"><?php echo $val['edoc_title'];?></a>
                    </td>
					<td class="left">
					    <?php $filePending = 0;?>
					    <?php $fileApprove = 0;?>
                        <?php foreach ($val['edoc_log'] as $key_log => $val_log){ ?>
                        - <?php echo $group[$val_log['edoc_group_id']]?> <br>
                        <?php if($val_log['edoc_verify']==0){ $filePending++; } ?>
                        <?php if($val_log['edoc_verify']==3){ $fileApprove++; } ?>
                        <?php } ?>
					</td>
				</tr>
				<?php } ?>
				<?php } ?>
            </table>
			<div class="clear"></div>
		</div>
	</div>