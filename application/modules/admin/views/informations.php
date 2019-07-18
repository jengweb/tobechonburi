<div class="main_content">
	<div class="title-admin">ข่าวประชาสัมพันธ์ทั้งหมด</div>
	<div class="add-button">
		<a href="/admin/admin_informations_insert/" class="add-information" title="เพิ่มข่าวประชาสัมพันธ์"></a>
	</div>
	<div class="colum-admin" id="search-area">
		<form action="/admin/admin_informations/" method="post">
			<table width="950px" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" style="padding: 10px 0 10px 0; border: 1px dotted;">
                        <label style="font-family: 'wdb_bangnaregular', 'Tahoma', serif; font-weight: bold; font-size: 14px;">คำค้น</label>
						<input type="text" name="keyword" id="keyword-search" style="width: 200px">
						<label style="font-family: 'wdb_bangnaregular', 'Tahoma', serif; font-weight: bold; font-size: 14px; padding: 0 0 0 10px;">ประเภทข่าว</label>
						<select id="type-search" name="info_type">
							<option value="">กรุณาเลือก</option>
							<?php $type_new = $this->config->item('type_new'); ?>
                            <?php foreach ($type_new as $key => $val){ ?>
                            <option value="<?php echo $key;?>"><?php echo $val;?></option>
                            <?php } ?>
                        </select>
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
					<th style="width: 150px;"scope="col" class="rounded-company">หัวข้อ</th>
					<th style="width: 350px;" scope="col">รายละเอียด</th>
					<th scope="col">ประเภทข่าว</th>
					<th style="width: 75px;" scope="col">วันที่เพิ่มข้อมูล</th>
					<th style="width: 85px;" scope="col">วันที่แก้ไขข้อมูล</th>
					<th style="width: 45px;"scope="col">ผู้เข้าชม</th>
					<th scope="col"></th>
					<th scope="col" class="rounded-q4"></th>
				</tr>
			</thead>
			<tbody>
			    <?php
                    $num = count($informations);
                    $type_new = $this->config->item('type_new');
                    foreach ($informations as $key => $val) {
                ?>
				<tr>
					<td <?php if($num==$key+1){ echo 'class="rounded-foot-left"'; }?>>
                        <a href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>" target="new">
                            <div class="text-overflow"><?php echo $val['info_title'];?></div>
                        </a>
					</td>
					<td><div class="text-overflow"><?php echo $val['info_detail'];?></div></td>
					<td><?php echo $type_new[$val['info_type']];?></td>
					<td><?php echo $val['info_createdate'];?></td>
					<td><?php echo (!empty($val['info_editdate'])) ? $val['info_editdate'] : '-';?></td>
					<td>
					   <?php echo (!empty($val['info_view_count'])) ? $val['info_view_count'] : '0';?>
				    </td>
					<td>
						<a href="/admin/admin_informations_edit/<?php echo $val['info_id'];?>">แก้ไข</a>
					</td>
					<td <?php if($num==$key+1){ echo 'class="rounded-foot-right"'; }?>>
						<a href="javascript:void(0)" onclick="if(confirm('ยืนยันการลบ')) {  window.location='/admin/admin_informations_delete/<?php echo $val['info_id'];?>' }">ลบ</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="clear"></div>
</div>