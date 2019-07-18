<div class="main_content">
	<div class="title-admin">ไฟล์ทั้งหมด</div>
	<div class="add-button">
		<a href="/admin/admin_files_insert/" class="add-file" title="เพิ่มไฟล์บริการ"></a>
	</div>
	<div class="colum-admin" id="search-area">
		<form action="/admin/admin_files/" method="post">
			<table width="950px" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" style="padding: 10px 0 10px 0; border: 1px dotted;">
					   <label style="font-family: 'wdb_bangnaregular', 'Tahoma', serif; font-weight: bold; font-size: 14px;">คำค้น</label>
					   <input type="text" name="keyword" id="keyword-search" style="width: 200px">
                       <span style="padding: 0 0 0 10px">
                            <input type="submit" id="btn-search" class="btn-insert" onclick="this.style.display='none'; btn-reset.style.display='none';" value="ค้นหา" />
					   </span>
				    </td>
				</tr>
			</table>
		</form>
	</div>
	<div class="colum-admin">
		<table id="rounded-corner" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th scope="col" class="rounded-company" style="width: 200px;">หัวข้อ</th>
					<th scope="col" style="width: 300px;">รายละเอียดไฟล์</th>
					<th scope="col"style="width: 80px;">รูปประกอบ</th>
					<th scope="col">ชื่อไฟล์</th>
					<th scope="col" colspan="2" class="rounded-q4" style="width: 85px;">จัดการ</th>
				</tr>
			</thead>
			<tbody>
			    <?php
                    $num = count($files);
                    $group = $this->config->item('group');
                    foreach ($files as $key => $val) {
                ?>
				<tr>
					<td <?php if($num==$key+1){ echo 'class="rounded-foot-left"'; }?>><?php echo $val['file_title'];?></td>
					<td><?php echo $val['file_detail'];?></td>
					<td><img src="<?php echo base_url();?>static/upload/thumb/<?php echo $val['file_thumbnail'];?>" width="80" height="80" alt="" /></td>
					<td><?php echo $val['file_name'];?></td>
					<td>
					   <a href="/admin/admin_files_edit/<?php echo $val['file_id'];?>">แก้ไข</a>
				    </td>
					<td <?php if($num==$key+1){ echo 'class="rounded-foot-right"'; }?>><a href="javascript:void(0)" onclick="if(confirm('ยืนยันการลบ')) {  window.location='/admin/admin_files_delete/<?php echo $val['file_id'];?>' } ">ลบไฟล์</a></td>
				</tr>

				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="clear"></div>
</div>