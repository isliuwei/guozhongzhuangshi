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
	<link rel="stylesheet" href="css/valid.css">
	

	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
</head>
<body>
	<div id="valid">
		<form action="admin/search_order" method="post">
			<input name="open_id" type="hidden" value="<?php echo $open_id; ?>">
			<input name="order_tel" class="valid-tel"  placeholder="请输入11位手机号" type="text">
			<input class="valid-btn" type="submit" value="查&nbsp;&nbsp;询">
		</form>
	</div>
</body>
</html>