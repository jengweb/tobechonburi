<div class="main_content">
	<div class="colum1">
		<div>
			<h3>
				<img src="<?php echo base_url();?>static/images/title_news.png" width="130" height="24" alt="" /><br>
		        <?php if(!empty($informations_1)) { ?>
                <img src="<?php echo base_url();?>static/images/information_1.jpg" width="157" height="19" alt="" />
                <a href="<?php echo base_url();?>informations/all/1">
                    <img src="<?php echo base_url();?>static/images/information_09.jpg" width="56" height="19" alt="" />
                </a>
			</h3>
			<ul class="news">
			    <?php $count = 0;?>
			    <?php foreach ($informations_1 as $key => $val) { ?>
				<li <?php if($count%2==0){ echo 'class="right15"'; }?>>
				    <a href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
    					<span class="img-fix">
    					<?php   if(empty($val['img']['image_name'])){
    			                    $picture = base_url() . 'static/images/nopic.jpg';
    			                }else{
                                    $picture = base_url() . 'static/upload/informations/' . $val['img']['image_name'];
                                }
                        ?>
    					<img src="<?php echo $picture;?>" width="322" alt="<?php echo $val['info_title'];?>" />
    				    </span>
			         </a>
			         <a href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
				        <span class="text-overflow"><?php echo $val['info_title'];?></span>
                     </a>
                </li>
                <?php $count++;?>
                <?php } ?>
				<?php } ?>
			</ul>
			<div class="clear"></div>
			<h3>
                <?php if(!empty($informations_2)) { ?>
                <img src="<?php echo base_url();?>static/images/information_2.jpg" width="369" height="19" alt="" />
                <a href="<?php echo base_url();?>informations/all/2">
                    <img src="<?php echo base_url();?>static/images/information_09.jpg" width="56" height="19" alt="" />
                </a>
			</h3>
			<ul class="news">
                <?php $count = 0;?>
                <?php foreach ($informations_2 as $key => $val) { ?>
                <li <?php if($count%2==0){ echo 'class="right15"'; }?>>
                    <a href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
                        <span class="img-fix">
    					<?php   if(empty($val['img']['image_name'])){
    			                    $picture = base_url() . 'static/images/nopic.jpg';
    			                }else{
                                    $picture = base_url() . 'static/upload/informations/' . $val['img']['image_name'];
                                }
                        ?>
    					<img src="<?php echo $picture;?>" width="322" alt="<?php echo $val['info_title'];?>" />
    					</span>
			        </a>
			        <a href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
                        <span class="text-overflow"><?php echo $val['info_title'];?></span>
                    </a>
                </li>
				<?php $count++;?>
				<?php } ?>
				<?php } ?>
			</ul>
			<div class="clear"></div>
			<h3>
		<?php if(!empty($informations_3)) { ?>
		<img src="<?php echo base_url();?>static/images/information_3.jpg"
					width="106" height="18" alt="" /> <a
					href="<?php echo base_url();?>informations/all/3"><img
					src="<?php echo base_url();?>static/images/information_09.jpg"
					width="56" height="19" alt="" /></a>
			</h3>
			<ul class="news">
				  <?php $count = 0;?>
							<?php foreach ($informations_3 as $key => $val) { ?>
							<li <?php if($count%2==0){ echo 'class="right15"'; }?>><a
					href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
						<span class="img-fix">
						<?php   if(empty($val['img']['image_name'])){
				                    $picture = base_url() . 'static/images/nopic.jpg';
				                }else{
                                    $picture = base_url() . 'static/upload/informations/' . $val['img']['image_name'];
                                }
                        ?>
						<img src="<?php echo $picture;?>" width="322" alt="<?php echo $val['info_title'];?>" />
						</span>
				</a> <a
					href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
								   <span class="text-overflow"><?php echo $val['info_title'];?></span>
								</a></li>
							<?php $count++;?>
							<?php } ?>
							<?php } ?>
				</ul>
			<div class="clear"></div>
			<h3>
		<?php if(!empty($informations_4)) {?>
		<img src="<?php echo base_url();?>static/images/information_4.jpg"
					width="108" height="17" alt="" /> <a
					href="<?php echo base_url();?>informations/all/4"><img
					src="<?php echo base_url();?>static/images/information_09.jpg"
					width="56" height="19" alt="" /></a>
			</h3>
			<ul class="news">
				  <?php $count = 0;?>
							<?php foreach ($informations_4 as $key => $val) { ?>
							<li <?php if($count%2==0){ echo 'class="right15"'; }?>><a
					href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
						<span class="img-fix">
						<?php   if(empty($val['img']['image_name'])){
				                    $picture = base_url() . 'static/images/nopic.jpg';
				                }else{
                                    $picture = base_url() . 'static/upload/informations/' . $val['img']['image_name'];
                                }
                        ?>
						<img src="<?php echo $picture;?>" width="322" alt="<?php echo $val['info_title'];?>" />
					    </span>
				</a> <a
					href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
								   <span class="text-overflow"><?php echo $val['info_title'];?></span>
								</a></li>
							<?php $count++;?>
							<?php } ?>
							<?php } ?>
				</ul>
			<div class="clear"></div>
			<h3>
		<?php if(!empty($informations_5)) {?>
		<img src="<?php echo base_url();?>static/images/information_5.jpg"
					width="54" height="19" alt="" /> <a
					href="<?php echo base_url();?>informations/all/5"><img
					src="<?php echo base_url();?>static/images/information_09.jpg"
					width="56" height="19" alt="" /></a>
			</h3>
			<ul class="news">
				  <?php $count = 0;?>
							<?php foreach ($informations_5 as $key => $val) { ?>
							<li <?php if($count%2==0){ echo 'class="right15"'; }?>><a
					href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
						<span class="img-fix"><img
							src="<?php echo base_url();?>static/upload/informations/<?php echo $val['img']['image_name'];?>"
							width="322" alt="<?php echo $val['info_title'];?>" /></span>
				</a> <a
					href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>">
								   <span class="text-overflow"><?php echo $val['info_title'];?></span>
								</a></li>
							<?php $count++;?>
							<?php } ?>
							<?php } ?>
				</ul>
			<div class="clear"></div>
		</div>
	</div>