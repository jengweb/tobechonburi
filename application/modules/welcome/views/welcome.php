<div class="main_content">
	<div class="colum1">
		<div id="slidePan">
			<div id="dim">
				<div id="layerslider">
					<?php $count = 0;?>
					<?php foreach ($informations as $key => $val) { ?>
					<div class="ls-layer" style="slidedelay: 3000 <?php if($count==2){ echo '; slidedirection: top'; }?>">
					    <?php   if(empty($val['img']['image_name'])){
				                    $picture = base_url() . 'static/images/nopic.jpg';
				                }else{
                                    $picture = base_url() . 'static/upload/informations/' . $val['img']['image_name'];
                                }
                        ?>
						<img class="ls-bg" width="711" src="<?php echo $picture;?>" alt="layer">
						<span class="ls-s2" alt="sublayer" style="durationin: 2000; easingin: easeOutElastic; padding: 10px; background-color: rgba(255, 255, 255, 0.7); width: 711px; height: 50px; font-family: 'wdb_bangnaregular', 'Tahoma', serif; font-weight: bold; font-size: 14px;">
						    <a href="<?php echo base_url();?>informations/detail/<?php echo $val['info_id'];?>" target="new"><?php echo $val['info_title'];?></a>
						</span>
					</div>
					<?php $count++;?>
					<?php if($count==3) { break; } ?>
					<?php } ?>
				</div>
			</div>
			<script src="<?php echo base_url();?>static/layerslider/jQuery/jquery-1.6.2.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url();?>static/layerslider/jQuery/jquery-easing-1.3.js" type="text/javascript"></script>
			<script src="<?php echo base_url();?>static/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
			<script type="text/javascript">
    			$(document).ready(function(){
    				$('#layerslider').layerSlider({
    					skinsPath : 'static/layerslider/skins/'
    				});
    			});
    		</script>
		</div>
		<div class="inside">
			<h3>
				<img src="<?php echo base_url();?>static/images/title_news.png" width="130" height="24" alt="" />
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
				   <span class="text-overflow"><?php echo $val['info_title'];?></span>
				</a>
			</li>
			<?php $count++;?>
			<?php } ?>
		</ul>
		</div>
	</div>