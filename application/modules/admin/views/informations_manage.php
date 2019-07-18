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
		<form action="/admin/informations_manage/" method="post" enctype="multipart/form-data">
			<input type="hidden" name="info_id" value="<?php if(!empty($informations['info_id'])){ echo $informations['info_id']; } ?>">
			<div class='Form-div'>
				<div class='title-insert'>
					<div>
						<?php if(!empty($informations['info_title'])){ echo "แก้ไขข่าวประชาสัมพันธ์"; } else{ echo "เพิ่มข่าวประชาสัมพันธ์"; } ?>
						<hr />
					</div>
				</div>
				<!-- Title -->
				<div id="titleBG" style="">
					<label>หัวข้อ</label><br>
					<input type="text" name="info_title" onclick="ActiveField('titleBG');" onblur="InactiveField('titleBG');" style="width: 500px;" value="<?php if(!empty($informations['info_title'])){ echo $informations['info_title']; } ?>">
				</div>
				<!-- Note -->
				<div id="detailBG">
					<label> รายละเอียด</label><br>
					<textarea rows="4" cols="50" name="info_detail" style="width:500px; height:150px;" onclick="ActiveField('detailBG');" onblur="InactiveField('detailBG');"><?php if(!empty($informations['info_detail'])){ echo $informations['info_detail']; } ?></textarea>
				</div>
				<!-- Group -->
				<div id="typeBG">
					<label>ประเภทข่าว</label><br>
					<select id="info_type" name="info_type" onclick="ActiveField('typeBG');" onblur="InactiveField('typeBG');">
						<option value="0">กรุณาเลือก</option>
						<?php $type_new = $this->config->item('type_new'); ?>
						<?php foreach ($type_new as $key => $val){ ?>
                        <option value="<?php echo $key;?>" <?php if(!empty($informations['info_id']) && $key==$informations['info_type']){ echo 'selected="selected"'; } ?>><?php echo $val;?></option>
                        <?php } ?>
					</select>
				</div>
				<div>
				<?php if(!empty($informations['info_id'])){ ?>
				<?php foreach ($informations_img as $key => $val) { ?>
				<div id="img_<?php echo $val['image_id'];?>" class="div-img">
				    <img alt="" src="<?php echo base_url();?>static/upload/informations/<?php echo $val['image_name'];?>" width="100" height="100">
				    <a class="btn-del-img" href="javascript:del_img(<?php echo $val['image_id'];?>);"></a>
				</div>
				<input type="hidden" name="image_id_del[]" id="image_id_del_<?php echo $val['image_id'];?>" value="">
				<?php } ?>
				<?php } ?>
				</div>
				<div class="clear"></div>
				<!-- Images -->
				<div id="thumbBG">
					<label> รูปประกอบ (ถ้าต้องการเลือกหลายรูป ให้กด ctrl ค้างพร้อมเลือกรูปภาพแต่ละรูปจนเสร็จ แล้วจึงคลิก open/เปิด)</label><br>
					<input multiple type="file" name="Info_Image[]" onclick="ActiveField('thumbBG');" onblur="InactiveField('thumbBG');">
					</textarea>
				</div>
				<div style="margin-top: 10px;">
					<!--Button submit-->
					<input type="submit" id="btn-insert" class="btn-insert" onclick="this.style.display='none'; btn-reset.style.display='none';" value="บันทึก" />
					<!--Button reset-->
					<input type="reset" id="btn-reset" class="btn-reset" onclick="var link = window.location.href.split('#'); customWindowOpen(link[0],'_self'); return false;" value='Reset' style="background-color: #20B2AA; padding: 3px 10px" />
				</div>
				<script>
    			    function del_img(img_id){
    			    	if (confirm('ยืนยันลบรูปภาพนี้')) {
    			    		document.getElementById("img_"+img_id).remove();
    			    		document.getElementById("image_id_del_"+img_id).value = img_id;
    			    	}
    			    }
				</script>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>