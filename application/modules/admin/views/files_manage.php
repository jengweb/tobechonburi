<div class="main_content">
	<div class="colum-admin">
		<script type="text/javascript">
            function ActiveField(Fieldname) {
               document.getElementById(Fieldname).style.background = '#FEF1C1';
            }
            function InactiveField(Fieldname) {
              document.getElementById(Fieldname).style.background ='#FFF'
            }
        </script>
		<form action="/admin/files_manage/" method="post" enctype="multipart/form-data">
			<input type="hidden" name="file_id" value="<?php if(!empty($files['file_id'])){ echo $files['file_id']; } ?>">
			<div class='Form-div'>
				<div class='title-insert'>
					<div>
						เพิ่มไฟล์บริการ
						<hr />
					</div>
				</div>
				<!-- Title -->
				<div id="titleBG" style="">
					<label>หัวข้อ</label><br>
					<input type="text" name="file_title" onclick="ActiveField('titleBG');" style="width: 500px;" onblur="InactiveField('titleBG');" value="<?php if(!empty($files['file_title'])){ echo $files['file_title']; } ?>">
				</div>
				<!-- Note -->
				<div id="detailBG">
					<label> รายละเอียด</label><br>
					<textarea rows="4" cols="50" name="file_detail" style="width:500px; height:150px;" onclick="ActiveField('detailBG');" onblur="InactiveField('detailBG');"><?php if(!empty($files['file_detail'])){ echo $files['file_detail']; } ?></textarea>
				</div>
				<?php if(empty($files['file_id'])){ ?>
				<!-- Thumbnail -->
				<div id="thumbBG">
					<label> รูปประกอบ (1 รูป)</label><br>
					<input type="file" name="file_thumbnail" onclick="ActiveField('thumbBG');" onblur="InactiveField('thumbBG');">
				</div>
				<!-- File -->
				<div id="fileBG">
					<label> ไฟล์ (1 ไฟล์)</label><br>
					<input type="file" name="file_name" onclick="ActiveField('fileBG');" onblur="InactiveField('fileBG');">
				</div>
				<?php } ?>
				<div style="margin-top: 10px;">
					<!--Button submit-->
					<input type="submit" id="btn-insert" class="btn-insert" onclick="this.style.display='none'; btn-reset.style.display='none';" value="บันทึก" />

					<!--Button reset-->
					<input type="reset" id="btn-reset" class="btn-reset" onclick="var link = window.location.href.split('#'); customWindowOpen(link[0],'_self'); return false;" value='Reset' style="background-color: #20B2AA; padding: 3px 10px" />
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>