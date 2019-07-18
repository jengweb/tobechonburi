<div class="main_content">
	<div class="title-admin">
		สวัสดีค่ะ, <span style="font-size: 30px;">
		<?php
        $useradmin = json_decode($_COOKIE['admin'], true);
        echo $useradmin['username'];
        ?>
		</span>
	</div>
	<div class="add-button">
		<a href="/admin/admin_logout/" class="btn-logout"></a>
	</div>
	<div class="colum1">
		<div>
			<h3>
				<img src="<?php echo base_url();?>static/images/title_news.png" width="130" height="24" alt="" />
			</h3>
			<ul class="news">
				<?php $count = 0;?>
				<?php foreach ($informations as $key => $val) { ?>
				<li <?php if($count%2==0){ echo 'class="right15"'; }?>>
				   <a href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
				       <?php    if(empty($val['img']['image_name'])){
				                    $picture = base_url() . 'static/images/nopic.jpg';
				                }else{
                                    $picture = base_url() . 'static/upload/informations/' . $val['img']['image_name'];
                                }
                       ?>
					   <span class="img-fix"><img src="<?php echo $picture;?>" width="322" alt="<?php echo $val['info_title'];?>" /></span>
					</a>
					<a href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
					   <?php echo $val['info_title'];?>
					</a>
				</li>
				<?php $count++;?>
				<?php } ?>
			</ul>

			<div style="display: block; max-width: 100px; height: 58.8px; margin: 0 auto; font-size: 14px; line-height: 1.4; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" href="#">กลุ่มงานส่งเสริมสุขภาพ สำนักงานสาธารณสุข จังหวัดชลบุรี 29/9 หมู่ 4 ตำบลบ้านสวน อำเภอเมืองชลบุรี จังหวัดชลบุรี  กลุ่มงานส่งเสริมสุขภาพ สำนักงานสาธารณสุข จังหวัดชลบุรี 29/9 หมู่ 4 ตำบลบ้านสวน อำเภอเมืองชลบุรี จังหวัดชลบุรี  กลุ่มงานส่งเสริมสุขภาพ สำนักงานสาธารณสุข จังหวัดชลบุรี 29/9 หมู่ 4 ตำบลบ้านสวน อำเภอเมืองชลบุรี จังหวัดชลบุรี  กลุ่มงานส่งเสริมสุขภาพ สำนักงานสาธารณสุข จังหวัดชลบุรี 29/9 หมู่ 4 ตำบลบ้านสวน อำเภอเมืองชลบุรี จังหวัดชลบุรี </div>
		</div>
	</div>
	<div class="colum2">
		<div class="box_s">
			<div class="cal">
                <?php echo $calendars;?>
            </div>
		</div>
	</div>
	<div class="clear"></div>
</div>
