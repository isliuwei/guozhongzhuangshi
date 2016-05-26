
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>国众装饰 -- 您身边的装饰专家</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<base href="<?php echo site_url(); ?>">
	<!-- css style -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/slider.css">
	
<script src="js/pace.js"></script>
  	<link href="css/pace-theme-barber-shop.css" rel="external nofollow"  rel="stylesheet" />

	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<style>
		.loading{
			width: 100%;
			height: 100%;
			line-height: 100%;
			background: rgba(204,204,204,1);
			position: fixed;
			z-index: 999;
		}
	</style>
	




</head>
<body>

	<div class="loading"></div>
	


	<!-- header -->
	<div id="header">
		<!-- <div class="carousel-img">
			<img class="active" src="img/iheader-bg1.png" alt="主页图片">
			<img src="img/iheader-bg2.png" alt="主页图片">
			<img src="img/iheader-bg3.png" alt="主页图片">
		</div>
		<ul class="carousel-num">
			<li class="active"></li>
			<li></li>
			<li></li>
		</ul> -->
		<div class="slider">
		  <ul>
		    <li><img src="img/iheader-bg1.png" alt="主页图片"></a></li>
			<li><img src="img/iheader-bg2.png" alt="主页图片"></a></li>
			<li><img src="img/iheader-bg3.png" alt="主页图片"></a></li>
		  </ul>
		</div>

		
	</div>
	<!-- end header -->
	<div id="search-box">
		<!-- <span><i class="fa fa-search fa-fw"></i></span> -->
		<form action="#">
			<input class="search" name="keyword" type="text" placeholder="搜索地板、家具...">
		</form>
		
		
	</div>
	<div id="service-list">
		<h2 class="service-title">服务列表</h2>
		<ul class="service-items">
			<?php 
				foreach( $services as $service ){ 
			?>
			<li>
				<a href="welcome/service/<?php echo $service -> service_id ;?>"><img src="<?php echo $service -> service_img  ;?>" alt=""></a>
				<h3 class="item-zhtitle"><?php echo $service -> service_name ;?></h3>
				<h5 class="item-entitle"><?php echo $service -> service_en_name ;?></h5>
			</li>
			<?php 
				}
			?>
			<li>
				<a href="welcome/design"><img src="img/design1.png" alt=""></a>
				<h3 class="item-zhtitle">精品软装设计布置</h3>
				<h5 class="item-entitle">Confection Softloading Design</h5>
			</li>
		</ul>
	</div>
	<div id="footer">
		<h2 class="footer-title">服务与门店</h2>
		<ul class="info .clearfix">
			<li><a href="#"><img src="img/iflow.png" alt=""></a></li>
			<li><a href="welcome/contact"><img src="img/iaddress.png" alt=""></a></li>
		</ul>


	</div>
	<div class="footer-span"></div>
	<div class="copyright">&copy;2016-2017 国众装饰 版权所有</div>





	
	<script src="js/zepto.min.js"></script>
	<script src="js/index.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/yxMobileSlider.js"></script>
	<script>
		window.onload=function(){
                $(".loading").hide();
            }
        $(".slider").yxMobileSlider({width:640,height:320,during:3000});

        

	</script>

	

	
</body>
</html>