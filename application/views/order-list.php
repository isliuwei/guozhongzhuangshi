<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>国众装饰 -- 您身边的装饰专家</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<base href="<?php echo site_url(); ?>">
	<!-- css style -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style1.css">
	<link rel="stylesheet" href="css/order-list.css">

	<!-- 引入 WeUI -->
	<link rel="stylesheet" href="css/weui.css">


	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
</head>
<body>
	<div id="order-list">
		<h2 class="order-list-title">您的订单</h2>
	
	<?php 
		function orderStatus($order_color){

		switch ($order_color)
			{
			 case 'am-disabled':
			  echo "问题单";
			  break;
			 case 'am-active':
			  echo "已接单";
			  break;
			  case 'am-warming':
			  echo "施工中";
			  break;
			  case 'am-success':
			  echo "完成";
			  break;
			}

		}
		foreach($orders as $order){
	?>
		<ul>

			<span id="order-state">
				状态：<?php  echo orderStatus($order->order_color);  ?>
			</span>
			<li><span class="order-timestamp"><?php  echo $order->order_timestamp;  ?></span></li>
			<li><span>服务类型：</span><?php  echo $order->order_type;  ?></li>
			<li>
				<span>服务地址:</span>
				<span class="address"><?php  echo $order->order_address;  ?></span>
			</li>

			<div class="order-img">
				<img src="img/order1.png" alt="">
				<img src="img/order2.png" alt="">
				<img src="img/order3.png" alt="">
			</div>
			<div class="space"></div>
			<li class="order-infor"><span>&nbsp;联系人：</span><?php  echo $order->order_name;  ?></span></li>
			<li class="order-infor"><span>&nbsp;手机号：</span><?php  echo $order->order_tel;  ?></span></li>
			<li class="order-infor"><span>订单编号：<?php  echo $order->order_no;  ?></span></li>

			<form id="pay-form" action="http://www.isliuwei.com/wxpay/jsapi.php" method="post">
				<input name="order_no" type="hidden" value="<?php  echo $order->order_no;  ?>">
				<label for="money">订单金额</label>
				<input id="money" name="order_money" class="pay-money" type="number" placeholder="请输入支付金额">
				<br />
				<label for="tel">联系方式</label>
				<input name="order_tel" class="pay-money" type="number" placeholder="请输入手机号码">
				<br />
				<input class="pay-btn" type="submit" value="我要支付" name="pay_btn">
			</form>
		</ul>
	<?php
		}
	?>
	</div>
</body>
</html>
