<div class="main_content">
	<div class="title-admin">ปฏิทินกิจกรรม</div>
	<div class="add-button">
		<a href="/admin/admin_calendars_manage/" class="add-calendar" title="เพิ่มกิจกรรม"></a>
	</div>
	<div class="cal inside-calendar"><?php echo $calendars;?></div>
	<div class="clear"></div>
</div>
<?php
if (!empty($calendars_event)) {
    foreach ($calendars_event as $key => $val) {
?>
<div id="<?php echo $key;?>" class="calendar-detail" style="display: none">
	<h3>
		<img src="<?php echo base_url();?>static/images/title-calendar-detail.jpg" width="119" height="27" alt="" />
	</h3>
	<ul><?php echo $val;?></ul>
</div>
<?php } } ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
	
	
</script>