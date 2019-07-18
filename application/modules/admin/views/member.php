<div class="main_content">
	<div class="title-admin">สมาชิกทั้งหมด</div>
	<div class="add-button">
		<a href="/admin/admin_member_insert/" class="add-memeber" title="เพิ่มสมาชิก"></a>
	</div>
	<div class="colum-admin">
		<table id="rounded-corner" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th style="width: 170px;" scope="col" class="rounded-company">Email</th>
					<th style="width: 120px;" scope="col">Username</th>
					<th style="width: 75px;" scope="col">วันเพิ่มสมาชิก</th>
					<th style="width: 75px;" scope="col">วันที่เข้าระบบล่าสุด</th>
					<th scope="col">กลุ่ม/สังกัด</th>
					<th style="width: 185px;" scope="col">Note</th>
					<th style="width: 140px;" scope="col" colspan="2" class="rounded-q4">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			    <?php
                $num = count($member);
                $group = $this->config->item('group');
                foreach ($member as $key => $val) {
                ?>
				<tr>
					<td <?php if($num==$key+1){ echo 'class="rounded-foot-left"'; }?>><?php echo $val['email'];?></td>
					<td><?php echo $val['username'];?></td>
					<td><?php echo $val['create_date'];?></td>
					<td><?php echo $val['last_login'];?></td>
					<td><?php echo $group[$val['group_id']];?></td>
					<td><?php echo $val['note'];?></td>
					<td><a href="/admin/admin_member_edit/<?php echo $val['member_id'];?>">แก้ไข</a></td>
					<td <?php if($num==$key+1){ echo 'class="rounded-foot-right"'; }?>><a href="javascript:void(0)" onclick="if(confirm('ยืนยันการลบ')) {  window.location='/admin/admin_member_delete/<?php echo $val['member_id'];?>' } ">ลบสมาชิก</a></td>
				</tr>

				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="clear"></div>
</div>