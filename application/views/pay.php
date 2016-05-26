<?php
    $open_id = $this -> session -> userdata('open_id');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>国众装饰 -- 您身边的装饰专家</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<base href="<?php echo site_url(); ?>">
	<!-- css style -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/pay.css">


	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
</head>
<body>
	<div id="pay">
		<h2 class="pay-title">微信支付</h2>
		<form action="admin/wxpay" method="post">
			<input name="pay_money" class="pay-money" type="number" placeholder="请输入支付金额">
			<br />
			<input name="pay_tel" class="pay-money" type="number" placeholder="请输入手机号码">
			<br />
			<input class="pay-btn" type="submit" value="微信支付">
		</form>
		<p class="tip">为了保障您的权益，我们将及时与您取得联系，第一时间告知您支付结果。谢谢您对国众装饰的支持！</p>
	</div>
</body>
</html>