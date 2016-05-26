<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta charset="UTF-8">
	<title>国众装饰 -- 您身边的装饰专家</title>
	<base href="<?php echo site_url(); ?>">
	<link rel="stylesheet" href="css/style1.css">
	<link rel="stylesheet" href="css/product-list.css">
	
</head>
<body>
	<div class="space"></div>

	<div id="wrap">
		<ul id="nav">
			<?php 
				foreach($category as $cate){
			?>
			<li style="background:<?php echo $cate -> bgcolor;?>"><a href="welcome/product/<?php echo $cate -> pro_cate_id ;?>"><?php echo $cate -> pro_cate_name;?></a></li>
			<?php
				}
			?>
			
		</ul>	
	</div>
	<div class="space"></div>
	<div id="container">
		
		
		<div class="photosDemo">
			<?php 
				foreach($ads as $ad){
			?>
				<div class="product-item">
					<img layer-src="<?php echo $ad -> ad_img;?>" layer-pid="" src="<?php echo $ad -> ad_img;?>" alt="<?php echo $ad -> ad_desc;?>">
					<h3><?php echo $ad -> ad_title;?></h3>
				</div>
			<?php
				}
			?>
		</div>

		
		 
		


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
	<script src="js/jquery.js"></script>
	<script src="js/layer/layer.js"></script>
	
	<script>
		

		//加载扩展模块
		layer.config({
		    extend: 'extend/layer.ext.js'
		});

		//页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
		layer.ready(function(){ 
		    
		    layer.photos({
		        photos: '.photosDemo'
		    });
		});
	
    </script>
	
</body>

</html>