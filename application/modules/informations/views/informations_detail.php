<div class="main_content">
	<div class="colum1">
		<div>
			<h3>
				<a href="/informations/">
				    <img src="<?php echo base_url();?>static/images/title_news.png" width="130" height="24" alt="" />
				</a>
				<img src="<?php echo base_url();?>static/images/info-arrow.jpg" width="13" height="17" alt="" />
				<a href="<?php echo base_url();?>informations/all/<?php echo $info_detail['info_type']; ?>">
					<img src="<?php echo base_url();?>static/images/information_<?php echo $info_detail['info_type']; ?>.jpg" alt="" />
				</a>
			</h3>
			<div class="title_news">[หัวข้อข่าว] <?php echo $info_detail['info_title']; ?> </div>
			<div class="img-info">
				<span style="display: block; overflow: hidden;">
				    <?php   if(empty($info_detail['img'][0]['image_name'])){
			                    $picture = base_url() . 'static/images/nopic.jpg';
			                }else{
                                $picture = base_url() . 'static/upload/informations/' . $info_detail['img'][0]['image_name'];
                            }
                    ?>
				    <img src="<?php echo $picture; ?>" width="699" alt="" />
				</span>
			</div>
			<div class="gallery">
				<img src="<?php echo base_url();?>static/images/information-detail_03.jpg" width="53" height="23" alt="" /><br>
				<ul>
                    <?php   if(!empty($info_detail['img'])){
                                foreach ($info_detail['img'] as $key => $val) { ?>
			        <li>
			            <?php   if(empty($val['image_name'])){
    			                    $picture = base_url() . 'static/images/nopic.jpg';
    			                }else{
                                    $picture = base_url() . 'static/upload/informations/' . $val['image_name'];
                                }
                        ?>
                        <span style="height: 55px; display: block; overflow: hidden;">
                            <a href="<?php echo $picture;?>" data-lightbox="roadtrip">
                                <img src="<?php echo $picture;?>" width="75" alt="" />
                            </a>
					    </span>
				    </li>
			        <?php        } ?>
			        <?php    }else{ ?>
			        <li>
                        <span style="height: 55px; display: block; overflow: hidden;">
                            <a href="<?php echo base_url();?>static/images/nopic.jpg" data-lightbox="roadtrip">
                                <img src="<?php echo base_url();?>static/images/nopic.jpg" width="75" alt="" />
                            </a>
					    </span>
				    </li>
			        <?php    } ?>
                </ul>
				<div class="clear"></div>
			</div>
			<div class="conten-info">
				<ul>
					<li class="celen">ข่าววันที่ <?php echo date('d/m/Y', strtotime($info_detail['info_createdate'])); ?></li>
					<li class="info">วันที่แก้ไข  <?php echo date('d/m/Y', strtotime($info_detail['info_editdate'])); ?></li>
					<li class="user">จำนวนผู้เข้าชม <?php echo $info_detail['info_view_count']; ?> ครั้ง</li>
				</ul>
			</div>
			<div class="clear"></div>
			<div class="content-info">
			<?php echo nl2br($info_detail['info_detail']); ?>
		</div>
		</div>
	</div>