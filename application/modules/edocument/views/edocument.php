<div class="main_content">
	<div class="login_page">
		<img src="<?php echo base_url();?>static/images/login_text.png" width="433" height="62" alt="" />
		<div class="login">
			<div class="title_login">login</div>
			<form id="form1" name="form1" method="post" action="/edocument/edoc_member_login/">
				<p>
					<label for="username">ชื่อสมาชิก</label> <input type="text" name="username" id="username">
				</p>
				<p>
					<label for="password">รหัสผ่าน</label> <input type="password" name="password" id="password">
				</p>
				<p class="center">
					<input type="button" id="button" class="btn-login" onclick="form1.submit();">
				</p>
				<div class="clear"></div>
				<div class="red" style="text-align: center; <?php if(!isset($error_msg)){ ?>display: none;<?php } ?>">
                    ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูล หรือ ติดต่อ Admin
				</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>