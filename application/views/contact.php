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
	<link rel="stylesheet" href="css/contact.css">



</head>
<body>
	<div id="contact">
		<!-- <span class="return"><a href="welcome/index">&lt;返回</a></span>
 -->		<h2 class="contact-title">联系我们</h2>
		<img src="img/contact-bg.png" alt="">
		<ul class="contact-info">
			<li class="address">地址:哈尔滨市南岗区沿河路12号3单元3层301室</li>
			<li>客服电话：<a href="tel:10086">0451-57788167</a></li>
			<li>预约电话：<a href="tel:10086">13796237654</a></li>
			
		</ul>
		<div class="feedback">
			<h2 class="feedback-title">意见反馈</h2>
			
				<form action="welcome/save_feedback" method="post">
					<input type="hidden" name="open_id" value="<?php echo $open_id;?>">
					<textarea name="feedback" id="fed-con" cols="30" rows="10">国众致力于给您提供优质、高效的居家换新服务，欢迎您提供宝贵的意见和建议~</textarea>
					<input class="sub-btn" name="sub" type="submit" value="提交反馈">
				</form>
				
			</div>
			
				
				
			
			
				
				

			
			
		</div>
	</div>
	<script>
		var oFeed = document.getElementById('fed-con');
		oFeed.onfocus=function(){
			this.value="";
		}
	</script>
</body>
</html>