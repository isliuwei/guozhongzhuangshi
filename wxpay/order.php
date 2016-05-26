<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>国众装饰 -- 您身边的装饰专家</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<!-- css style -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/order-list.css">


	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
</head>
<body>
	<div id="order-list">
		<h2 class="order-list-title">您的订单</h2>
		
		<ul>
			<!-- <li>
				<div class="list-title">
					<span class="order-num">订单编号：D201604200001</span>
					<span class="order-time">下单时间：2016-04-20 08:20</span>
				</div>
		
				<ul class="order-info">
					<li><span>服务类型：</span>更换地板</li>
					<li><span>服务地址：</span>黑龙江省哈尔滨市南岗区学府路74号</li>
					<li><span>联系人：</span>奥巴马</li>
					<li><span>手机号：</span>15765505994</li>	
				</ul>
			</li>
			<li>
				<div class="list-title">
					<span class="order-num">订单编号：D201604200001</span>
					<span class="order-time">下单时间：2016-04-20 08:20</span>
				</div>
		
				<ul class="order-info">
					<li><span>服务类型：</span>更换地板</li>
					<li><span>服务地址：</span>黑龙江省哈尔滨市南岗区学府路74号</li>
					<li><span>联系人：</span>奥巴马</li>
					<li><span>手机号：</span>15765505994</li>	
				</ul>
			</li> -->
			
			<ul>

			<li>

		
				<ul class="order-info">
					<form id="pay-form" action="http://isliuwei.com/wxpay/jsapi.php" method="post">
						<input name="order_no" type="hidden" value="<?php  echo $order->order_no;  ?>">
						<label for="money">订单金额</label>
						<input id="money" name="order_money" class="pay-money" type="number" placeholder="请输入支付金额">
						<br />
						<label for="tel">联系方式</label>
						<input name="order_tel" class="pay-money" type="number" placeholder="请输入手机号码">
						<br />
						<input id="pay-btn" class="pay-btn" type="submit" value="我要支付" name="pay_btn">
					</form>
				</ul>
				
				
			</li>
			
		</ul>
			
		</ul>
		

	</div>
	<script src="jquery-1.11.3.min.js"></script>
	
	<script>
		/*$('#pay-btn').on('click', function(){
			$.get('http://isliuwei.com/wxpay/jsapi.php', {
				order_money: $('#money').val()
			}, function(){

			});
		});;*/
	</script>
</body>
</html>




