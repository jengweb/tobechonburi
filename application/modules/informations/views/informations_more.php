<div class="main_content">
	<div class="colum1">
		<div>
			<h3>
				<a href="/informations/">
				    <img src="<?php echo base_url();?>static/images/title_news.png" width="130" height="24" alt="" />
				</a>
				<img src="<?php echo base_url();?>static/images/info-arrow.jpg" width="13" height="17" alt="" />
				<img src="<?php echo base_url();?>static/images/information_<?php echo $type;?>.jpg" alt="" /> </br></br>
			</h3>
			<ul class="news">
			    <?php $count = 0;?>
			    <?php foreach ($informations as $key => $val) { ?>
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
                        <?php echo $val['info_title'];?>
                    </a>
                </li>
                <?php $count++;?>
                <?php } ?>
			</ul>
		</div>
	</div>