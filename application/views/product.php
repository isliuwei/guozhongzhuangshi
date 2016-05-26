<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>国众装饰 -- 您身边的装饰专家</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<base href="<?php echo site_url(); ?>">
	<link rel="stylesheet" href="css/style1.css">
	<link rel="stylesheet" href="css/product.css">
</head>
<body>
	<div id="header">
		<!-- <a href="#">&lt;返回</a> -->
		<h3 class="title">油漆荟萃</h3>
	</div>
	<div class="space"></div>
	<ul class="product">
		<?php $index = $brands[0] -> brand_id; foreach($brands as $brand){  ?>
			<h3 class="product-model"><?php echo $brand -> brand_name ;?></h3>
			<?php 
				
				foreach($products as $product){ 
				
					
				if( $product->brand_id == $index){
				?>
				<li>
					<img src="<?php echo $product -> product_img ;?>" alt="">
					<div class="product-infor">
							<span class="title"><?php echo $product -> product_name ;?></span>
							<div class="top">
								<span class="price"><?php echo $product -> product_price ;?></span>
								元/桶
							</div>
								<p><?php echo $product -> product_business ;?><br/>
								地址：<?php echo $product -> business_address ;?></br/>
								联系方式：<?php echo $product -> business_phone ;?><br/>
								</p>
					</div>
				</li>
				<?php }?>
			<?php } $index++; ?>
		<?php } ?>
		
		
		


		<!-- <div class="space product-space"></div>
		<li>
			<img src="img/product-bg1.png" alt="">
			<div class="product-infor">
					<span class="title">立邦净味120</span>
					<div class="top">
						<span class="price">150</span>
						元/桶
					</div>
						<p>德邦建材学府店<br/>
						地址：哈尔滨市南岗区学府路90号</br/>
						联系方式：13019259473<br/>
						</p>

			</div>
		</li>
	</ul>
	<div class="space"></div>
	<ul class="product">
		<h3 class="product-model">多乐士Dulux</h3>
		<li>
			<img src="img/Dulux.png" alt="">
			<div class="product-infor">
					<span class="title">立邦净味120</span>
					<div class="top">
						<span class="price">150</span>
						元/桶
					</div>
						<p>德邦建材学府店<br/>
						地址：哈尔滨市南岗区学府路90号</br/>
						联系方式：13019259473<br/>
						</p>

			</div>
		</li>

		<div class="space product-space"></div>
		<li>
			<img src="img/product-bg2.png" alt="">
			<div class="product-infor">
					<span class="title">立邦净味120</span>
					<div class="top">
						<span class="price">150</span>
						元/桶
					</div>
						<p>德邦建材学府店<br/>
						地址：哈尔滨市南岗区学府路90号</br/>
						联系方式：13019259473<br/>
						</p>

			</div>
		</li>
	</ul>
	<div class="space"></div>
	<ul class="product">
		<h3 class="product-model">嘉宝莉Carpoly</h3>
		<li>
			<img src="img/Carpoly.png" alt="">
			<div class="product-infor">
					<span class="title">立邦净味120</span>
					<div class="top">
						<span class="price">150</span>
						元/桶
					</div>
						<p>德邦建材学府店<br/>
						地址：哈尔滨市南岗区学府路90号</br/>
						联系方式：13019259473<br/>
						</p>

			</div>
		</li>

		<div class="space product-space"></div>
		<li>
			<img src="img/product-bg3.png" alt="">
			<div class="product-infor">
					<span class="title">立邦净味120</span>
					<div class="top">
						<span class="price">150</span>
						元/桶
					</div>
						<p>德邦建材学府店<br/>
						地址：哈尔滨市南岗区学府路90号</br/>
						联系方式：13019259473<br/>
						</p>

			</div>
		</li>
	</ul>
	<div class="space"></div>

		<div id="footer">
			<h2 class="footer-title">服务与门店</h2>
			<ul class="info clearfix">
				<li><a href="#"><img src="img/iflow.png" alt=""></a></li>
				<li><a href="#"><img src="img/iaddress.png" alt=""></a></li>
			</ul>


		</div>
		<div class="footer-span"></div> -->
	
</body>
</html>