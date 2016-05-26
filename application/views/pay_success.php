
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>支付成功</title>
	<base href="<?php echo site_url(); ?>">
    <!-- 引入 WeUI -->
	<link rel="stylesheet" href="css/weui.css">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
	<div class="weui_msg">
    <div class="weui_icon_area"><i class="weui_icon_safe_success weui_icon_msg"></i></div>
    <div class="weui_text_area">
        <h2 class="weui_msg_title">支付成功</h2>
        <p class="weui_msg_desc">感谢您对国众装饰的支持与厚爱</p>
        <p class="weui_msg_desc">3s后将返回主页，点击下方按钮立即返回</p>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <!-- <a href="admin/order_list1" class="weui_btn weui_btn_primary">查看详情</a> -->
            <a href="http://www.isliuwei.com/" class="weui_btn weui_btn_primary">返回主页</a>
            
        </p>
    </div>
</div>
</body>
<script>
    setInterval(function(){
        location.href = "http://www.isliuwei.com/";
    },3000);
</script>
</html>