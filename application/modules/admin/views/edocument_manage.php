<div class="main_content">
	<div class="colum-admin">
		<script type="text/javascript">
            function ActiveField(Fieldname) {
               document.getElementById(Fieldname).style.background = '#FEF1C1';
            }
            function InactiveField(Fieldname) {
              document.getElementById(Fieldname).style.background ='#FFF'
            }
            function fadeInOut() {
                if(document.getElementById("change_pass").checked == true){
                	document.getElementById("member-pwd").style.display="";
                }else{
                	document.getElementById("member-pwd").style.display="none";
                }
            }
        </script>
		<form id="edoccument" name="edoccument" method="post" action="/admin/admin_edoc_manage/" enctype="multipart/form-data">
			<input type="hidden" name="edoc_id" value="<?php if(!empty($edocument['edoc_id'])){ echo $edocument['edoc_id']; } ?>">
			<div class='Form-div'>
				<div class='title-insert'>
					<div>
					<?php if(!empty($edocument['edoc_id'])){ echo "แก้ไขข้อมูลเอกสารเลขที่  ".$edocument['edoc_id'] ; } else{ echo "เพิ่มเอกสาร "; } ?>
					<hr />
					</div>
				</div>
				<!-- Title -->
				<div id="titleBG" style="">
					<label>หัวข้อ/ชื่อหนังสือ</label><br>
					<input type="text" name="edoc_title" onclick="ActiveField('titleBG');" style="width: 500px;" onblur="InactiveField('titleBG');" value="<?php if(!empty($edocument['edoc_title'])){ echo $edocument['edoc_title']; } ?>">
				</div>
				<!-- Date -->
				<div id="dateBG" style="">
					<label>กำหนดส่ง</label><br>
					<input type="date" name="edoc_requiredate" onclick="ActiveField('dateBG');" onblur="InactiveField('dateBG');" value="<?php if(!empty($edocument['edoc_requiredate'])){ echo $edocument['edoc_requiredate']; } ?>">
				</div>
                <?php if(empty($edocument['edoc_id'])){ ?>
				<!-- File -->
				<div id="fileBG">
					<label> ไฟล์ (1 ไฟล์)</label><br>
					<input type="file" name="edoc_file_original" onclick="ActiveField('fileBG');" onblur="InactiveField('fileBG');">
				</div>
                <?php } ?>
				<!-- Type -->
				<div id="typeBG">
					<label>ความเร่งด่วน</label><br>
					<?php $group = $this->config->item('file_level'); ?>
					<?php foreach ($group as $key=>$val){ ?>
					<label class="edoc-label">
                        <input type="radio" name="edoc_type" value="<?php echo $key;?>" <?php if($edocument['edoc_type']==$key){ echo 'checked'; } ?>> <?php echo $val;?>
                    </label>
					<?php } ?>
				</div>
				<!-- Group -->
				<div id="groupBG">
					<label>หน่วยงาน</label><br>
					<?php $group = $this->config->item('group'); ?>
					<?php if(empty($edocument['edoc_id'])){ ?>
					<ul class="edoc-checkbox">
						<?php $count = 0;?>
						<?php foreach ($group as $key=>$val){ ?>
						<li <?php if($count%2==0){ echo 'class="right15"'; } ?>>
                            <label class="edoc-label">
                                <input type="checkbox" name="group_id[]" id="group_<?php echo $key;?>" value="<?php echo $key;?>"> <?php echo $val;?>
                            </label>
						</li>
                    <?php $count++;?>
                    <?php } ?>
                    <?php }else{
                              foreach ($edocument['edoc_log'] as $key => $val){
                                 echo '- ' . $group[$val['edoc_group_id']] . '<br>';
                              }
                          } ?>
				</div>
				<div class="clear"></div>
				<div style="margin-top: 10px;">
					<!--Button submit-->
					<input type="submit" id="btn-insert" class="btn-insert"
						onclick="this.style.display='none'; btn-reset.style.display='none';"
						value="บันทึก" />
                    <?php if(empty($edocument['edoc_id'])){ ?>
					<!--Button reset-->
					<input type="reset" id="btn-reset" class="btn-reset"
						onclick="var link = window.location.href.split('#'); customWindowOpen(link[0],'_self'); return false;"
						value='Reset' style="background-color: #20B2AA; padding: 3px 10px" />
					<?php } ?>
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>