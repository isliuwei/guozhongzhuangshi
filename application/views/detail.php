<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
	<head>
		<meta charset="utf-8">
		<title>国众装饰 -- 你身边的装饰专家</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <base href="<?php echo site_url(); ?>">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/detail.css" />
		 
	</head>
	<body>
		
			<div id="header">
				<img src="img/detail-header.jpg" alt="">
				<div>国众装饰</div>
			</div>

 
			<div class="liroduct">
				<p class="common">选择服务</p>
				<div class="segment"></div>
				<ul id="pro-model">
					<?php
						foreach ($contents as $content) {
					?>
					<li class="option" data-price="<?php echo $content->product_price ;?>"><?php echo $content->product_texture ;?></li>
					<?php
						}
					?>
					

				</ul>
			</div>
			
		<div class="space"></div>
		<div class="detail-order">
				<p class="common">预约流程</p>
				<div class="segment"></div>
				<img src="img/detail-order.png" alt="">
		</div>
		<div id="detail-case">
				<p class="common">客户案例</p>
				<div class="segment"></div>
				<ul class="user-case">
					<?php 
						foreach($cases as $case){ 
					?>
						<li>
							<p class="user-name">
								<?php echo  $case -> case_user ;?>
							</p>
							<p class="user-comment">
								<?php echo  $case -> case_desc ;?>
							</p>
							<img class="case1" src="<?php echo  $case -> case_img1 ;?>" alt="">
							<img class="case2" src="<?php echo  $case -> case_img2 ;?>" alt="">
							<p class="user-address">地点:<?php echo  $case -> case_add ;?></p>
						</li>

					<?php
					 	}
					 ?>


					<!-- <li>
						<p class="user-name">
							李先生
						</p>
						<p class="user-comment">
							装修的非常好，孩子特别喜欢，房间一点味道都没有。很舒适，很喜欢。
						</p>
						<img class="case1" src="img/room1.png" alt="">
						<img class="case2" src="
						img/room2.png" alt="">
						<p class="user-address">地点:南岗区学府路100号</p>
					</li>

					<li>
						<p class="user-name">
							李先生
						</p>
						<p class="user-comment">
							装修的非常好，孩子特别喜欢，房间一点味道都没有。很舒适，很喜欢。
						</p>
						<img class="case1" src="img/room1.png" alt="">
						<img class="case2" src="
						img/room2.png" alt="">
						<p class="user-address">地点:南岗区学府路100号</p>
					</li> -->
				</ul>
		</div>
		<div class="space"></div>

		<div id="detail-free">
			<span class="detail-item">
				服务内容
			</span>

			<span class="detail-submit">
				<a href="welcome/order">免费预约</a>
			</span>
			<span class="detail-price">
				<strong class="price">268</strong>&nbsp;元起&nbsp;
			</span>
		</div>
		<script src="js/jquery.js"></script>
		<script>

			$(function(){
				 
				$option = $('#pro-model li'); 
				$price = $('.price');
				$item = $('.detail-item');

				$option.on('click',function(){

					$price.html($(this).data('price'));
					$item.html($(this).html());
					$(this).addClass("detail-selected").siblings().removeClass("detail-selected");
					
				});










			});








		</script>
		<script src="js/detail.js"></script>
	</body>
</html>