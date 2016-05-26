<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>国众装饰 -- 您身边的装饰专家</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<base href="<?php echo site_url(); ?>">
	<!-- css style -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/order-detail.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
</head>
<body>
	<div id="orderInfo">
		<!-- <span class="return">&lt;返回</span> -->
		<h2 class="orderInfo-title">预约成功</h2>
	</div>
	<div id="order-detail">
		<div class="order-detail-title">
			<span class="order-num">订单编号：<?php echo $no ;?></span>
			<span class="order-time">下单时间：<?php echo $time ;?></span>
		</div>
		
		<ul class="order-info">
			<li><span>服务类型：</span><?php echo $type; ?></li>
			<li><span>地址：</span><?php echo $add; ?></li>
			<li><span>手机号：</span><?php echo $tel; ?></li>	
		</ul>
	</div>
	<div id="order-tip">
		<span><i class="fa fa-check fa-fw"></i></span>
		<h2 class="order-tip-title">预约成功</h2>
		<p class="order-tip-content"><?php echo $name; ?>先生，您的预约已经成功提交！<br/>我们将第一时间与你联系！</p>
		<!-- <a class="return-index" href="welcome/index">返回首页</a> -->
	</div>


	<script src="js/zepto.min.js"></script>
	
	
</body>
</html>