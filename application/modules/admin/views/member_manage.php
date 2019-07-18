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
		<form id="memberdata" name="memberdata" method="post" action="/admin/admin_member_insert_update/">
            <input type="hidden" name="member_id" value="<?php if(!empty($member['member_id'])){ echo $member['member_id']; } ?>">
			<div class='Form-div'>
				<div class='title-insert'>
					<div>
					<?php if(!empty($member['member_id'])){ echo "แก้ไขสมาชิก  ".$member['username'] ; } else{ echo "เพิ่มสมาชิก "; } ?>
					<hr /></div>
				</div>
				<!-- Email -->
				<div id="mailBG" style="">
					<label>อีเมล์</label><br>
					<input style="width: 300px;" type="email" name="email" id="member-mail" onclick="ActiveField('mailBG');" onblur="InactiveField('mailBG');" value="<?php if(!empty($member['email'])){ echo $member['email']; } ?>">
				</div>

				<!-- Name -->
				<div id="nameBG">
					<label>Username/ชื่อสมาชิก (ใช้สำหรับ Log-in)</label><br>
					<input style="width: 300px;" type="text" name="username" id="member-name" onclick="ActiveField('nameBG');" onblur="InactiveField('nameBG');" value="<?php if(!empty($member['username'])){ echo $member['username']; } ?>">
				</div>
				<?php if(!empty($member['member_id'])){ ?>
				<div id="changpassBG">
					<label>เปลี่ยนรหัสผ่าน</label><br>
					<input type="checkbox" id="change_pass" name="change_pass" onclick="fadeInOut();"><br >
					<input type="text" name="password" id="member-pwd" style="display:none; width: 300px;">
				</div>
				<?php }else{ ?>
				<!-- Password -->
				<div id="pwdBG">
					<label>รหัสผ่าน (ใช้สำหรับ Log-in)</label><br>
					<input style="width: 300px;" type="text" name="password" id="member-pwd" onclick="ActiveField('pwdBG');" onblur="InactiveField('pwdBG');">
				</div>
				<?php } ?>
				<!-- Group -->
				<div id="groupBG">
					<label>หน่วยงาน</label><br>
					<select style="width: 300px;" name="group_id" id="member-group" onclick="ActiveField('groupBG');" onblur="InactiveField('groupBG');">
						<?php $group = $this->config->item('group'); ?>
						<?php foreach ($group as $key=>$val){?>
				        <option value="<?php echo $key;?>" <?php if(!empty($member['member_id']) && $key==$member['group_id']){ echo 'selected="selected"'; } ?>><?php echo $val;?></option>
				    <?php } ?>
					</select>
				</div>

				<!-- Note -->
				<div id="groupBG">
					<label> หมายเหตุ</label><br>
					<textarea name="note" rows="4" cols="50"><?php if(!empty($member['note'])){ echo $member['note']; } ?></textarea>
				</div>
				<div style="margin-top: 10px;">
					<!--Button submit-->
					<input type="submit" id="btn-insert" class="btn-insert" onclick="this.style.display='none'; btn-reset.style.display='none';" value="บันทึก" />
                    <?php if(empty($member['member_id'])){ ?>
					<!--Button reset-->
					<input type="reset" id="btn-reset" class="btn-reset" onclick="var link = window.location.href.split('#'); customWindowOpen(link[0],'_self'); return false;" value='Reset' style="background-color: #20B2AA; padding: 3px 10px" />
					<?php } ?>
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>