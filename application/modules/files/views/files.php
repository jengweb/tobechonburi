<div class="main_content">
	<div class="colum1">
		<div>
			<img src="<?php echo base_url();?>static/images/title-service.jpg" width="100" height="44" alt="" />
			<ul class="files download">
                <?php
                    $count = 0;
                    $group = $this->config->item('group');
                    foreach ($files as $key => $val) {
                ?>
				<li <?php if($count%2==0){ echo 'class="right15"'; }?>>
				    <img src="<?php echo base_url();?>static/upload/thumb/<?php echo $val['file_thumbnail'];?>" width="110" height="110" alt="" />
					<div class="download-s">
						<a href="/files/<?php echo $val['file_id']?>">
						    <span class="text-overflow-file"><?php echo $val['file_title'];?></span>
						    <br>
    						<span>
    						    <?php $type = str_replace('.', '', strtolower(substr($val['file_name'], -4)));?>
    						    <?php switch ($type) {
                                      case 'pdf':
                                        $showFileType = 'download_pdf.jpg';
                                        break;
                                      case 'xls':
                                      case 'xlsx':
                                        $showFileType = 'download_pdf.jpg';
                                        break;
                                      case 'doc':
                                      case 'docx':
                                        $showFileType = 'download_word.jpg';
                                        break;
                                      case 'txt':
                                        $showFileType = 'download_text.png';
                                        break;
                                      default:
                                        $showFileType = 'download_text.png';
                                    }
                                ?>
    						    <img src="<?php echo base_url();?>static/images/<?php echo $showFileType;?>" width="30" height="45" alt="" />
    						    <?php echo date('Y/m/d',strtotime($val['file_create_date']));?> Download <?php echo (!empty($val['file_count'])) ? number_format($val['file_count']) : '0';?> ครั้ง<br> ขนาดไฟล์ <?php echo (!empty($val['file_sizes'])) ? round($val['file_sizes']/1048576,2) : '0';?> MB
                            </span>
                        </a>
                    </div>
                </li>
                <?php $count++;?>
                <?php } ?>
			</ul>
			<div class="clear"></div>
			<!-- div class="pagination clearfix">
				<a href="#">First</a> &nbsp;<a href="#">«</a> <a href="#">1</a> <strong>2</strong>
				<a href="#">3</a> <a href="#">»</a> &nbsp;<a href="#">Last</a>
			</div>
			<div class="clear"></div-->
		</div>
	</div>