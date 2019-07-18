<?php
//$cookie = $this->input->cookie('admin');
//if (empty($cookie)) {
//    exit();
//}
?>
<!doctype html>
<html>
    <head>
        <META charset="UTF-8">
        <?php   if(!empty($css)){
                    echo '<link rel="stylesheet" href="' . base_url() . 'static/source/jquery.fancybox.css?v=2.1.5" media="screen"/>';
                    foreach ($css as $val){
                        echo '<link rel="stylesheet" href="' . base_url() . 'static/'.$val.'" />';
                    }
                }
                if(!empty($js)){
                    foreach ($js as $val){
                        echo '<script type="text/javascript" src="' . base_url() . 'static/'.$val.'"></script>';
                    }
                }
        ?>
        <link rel="stylesheet" media="screen" href="<?php echo base_url();?>static/css/style.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>static/css/layerslider.css" type="text/css">
        <title>To Be No.1 Chonburi : <?php echo $title; ?></title>
        <META NAME="description" CONTENT="<?php echo $title; ?> เว็บไซต์ของโครงการ TO BE NUMBER ONE จังหวัดชลบุรี ศูนย์ประสานงานโครงการ TO BE NUMBER ONE จังหวัดชลบุรี">
        <META NAME="keywords" CONTENT="TO BE NUMBER ONE, ชลบุรี, ยาเสพติด, งานส่งเสริมสุขภาพ, ศูนย์ประสานงานโครงการTO BE NUMBER ONE, แก้ไขปัญหา, บำบัด, ทูบีนัมเบอร์วัน, <?php echo $title; ?>">
        <META NAME="robots" CONTENT="index, follow">
        <META NAME="GOOGLEBOT" CONTENT="INDEX, FOLLOW">
    </head>
<body>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  ga('create', 'UA-53890296-1', 'auto');
	  ga('send', 'pageview');
	</script>
	<header>
		<h1>
			<a href="index.html">โครงการรณรงค์ป้องกันและแก้ปไขปัญหายาเสพติด จังหวัดชลบุรี</a>
		</h1>
		<h2>TO BE NUMBER ONE Chonburi</h2>
	</header>
	<nav>
		<ul>
			<li><a href="/" class="menu1 <?php if(isset($index)){ echo 'active'; }?>">หน้าแรก</a></li>
			<li><a href="/files/" class="menu2 <?php if(isset($files)){ echo 'active'; }?>">บริการข้อมูล</a></li>
			<li><a href="/informations" class="menu3 <?php if(isset($informations)){ echo 'active'; }?>">ข่าวประชาสัมพันธ์</a></li>
			<li><a href="/edocument" class="menu4 <?php if(isset($edocument)){ echo 'active'; }?>">ระบบจัดการเอกสาร</a></li>
			<li><a href="/calendar" class="menu5 <?php if(isset($calendar)){ echo 'active'; }?>">ปฏิทินกิจกรรม</a></li>
			<li><a href="/contactus" class="menu6 <?php if(isset($contactus)){ echo 'active'; }?>">ติดต่อหน่วยงาน</a></li>
		</ul>
	</nav>
	<div class="content">