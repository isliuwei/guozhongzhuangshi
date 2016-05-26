<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>国众装饰 -- 您身边的装饰专家</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<base href="<?php echo site_url(); ?>">
	<link rel="stylesheet" href="css/style1.css">
	<link rel="stylesheet" href="css/sevice.css">
</head>
<body>
	<!-- <ul id="nav">
		<li class="selected">家&nbsp;&nbsp;庭</li>
		<li>宾&nbsp;&nbsp;馆</li>
		<li id="end">中小型企业</li>
	</ul> -->
	<div class="space"></div>
	<div id="container">
		<ul class="item selected">
			<?php foreach($items as $item){ ?>

			<li><a href="welcome/detail/<?php echo $item->service_id;?>">				
				<img src="<?php echo $item->service_img ;?>">
				<div class="right">
					<div class="detail">
						<span class="title"><?php echo $item->service_name ;?></span>
					</div>
				
					<h4><?php echo $item->service_desc ;?></h4>
				</div></a>
			</li>
			<?php
				}
			?>
			<li><a href="welcome/other">				
				<img src="img/service-bg1.jpg">
				<div class="right">
					<div class="detail">
						<span class="title">其他服务</span>
					</div>
				
					<h4>欢迎提供</h4>
				</div></a>
			</li>
		</ul>
		
	</div>
	<div id="footer">
			<h2 class="footer-title">服务与门店</h2>
			<ul class="info clearfix">
				<li><a href="#"><img src="img/iflow.png" alt=""></a></li>
				<li><a href="#"><img src="img/iaddress.png" alt=""></a></li>
			</ul>


		</div>
		<div class="footer-span"></div>
		<div class="copyright">&copy;2016-2017 国众装饰 版权所有</div>
	<script src="js/service.js"></script>
</body>
</html>