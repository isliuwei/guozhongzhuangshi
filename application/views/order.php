<?php
    $open_id = $this -> session -> userdata('open_id');
    //$nickname = $this -> session -> userdata('nickname');
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
	<link rel="stylesheet" href="css/order.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />

</head>
<body>

	
	<div id="order">
		
		<!-- <span class="return">&lt;返回</span> -->
		<h2 class="order-title">预约上门</h2>
		<div class="order-detail">
			<img src="img/order-bg.png" alt="">
			<h3 class="order-type"><?php echo $content[0] -> service_name;?></h3>
			<span class="order-tip">预约上门</span>
		</div>
		<!-- <div class="order-info">
			<h2 class="order-info-title">预约信息</h2>
			<form action="welcome/save_order" method="post">
				<ul class="order-info-list">
					<li><i class="fa fa-location-arrow fa-fw"></i><input type="text" id="order_address" name="order_address" placeholder="请输入地址"></li>
					<li><i class="fa fa-newspaper-o fa-fw"></i><input type="text" id="order_name" name="order_name" placeholder="请输入您的称呼"></li>
					<li><i class="fa fa-phone fa-fw"></i><input type="number" id="order_tel" name="order_tel" placeholder="请输入您的手机号"></li>
				</ul>
				<p class="order-promise">国众郑重承诺：预约上门服务绝不产生任何费用，并
对您提交的资料严格保密！</p>
				
				
			</form>
			
		</div> -->
		<div class="order-info">
			<h2 class="order-info-title">预约信息</h2>
				<form action="welcome/save_order" method="post" id="form2">
					
					<!-- 设置隐藏输入框，从session中获取用户微信的 open_id -->
					<input id="open_id" name="open_id" type="hidden" value="<?php echo $open_id;?>">
					<!-- <input id="nickname" name="nickname" type="hidden" value="<?php echo $nickname;?>"> -->
					<!-- 设置隐藏输入框，设置订单的默认状态 order_status 为失败 am-disable -->
					<input id="order_color" name="order_color" type="hidden" value="am-active">
					<input id="order_type" name="order_type" type="hidden">
					<ul class="order-info-list"> 
						<li>
			            	<i class="fa fa-phone fa-fw"></i>
			            	<input id="order-tel" name="order_tel" type="text" class="field-text" placeholder="请输入您的手机号码" data-required="true" data-validate="phone" data-describedby="phone-description" autofocus="autofocus">
			                <div id="phone-description"></div>
			            </li>      
			            <li>
			            	<i class="fa fa-newspaper-o fa-fw"></i>
			            	<input id="order-name" name="order_name" type="text" class="field-text" placeholder="请输入您的称呼"  data-descriptions="username" data-describedby="username-description">
			            	<div id="username-description"></div>
			            </li>
			            <li>
			            	<i class="fa fa-location-arrow fa-fw"></i>
			            	<input id="order-address" name="order_address" type="text" class="field-text" placeholder="请输入您的地址"  data-descriptions="address" data-describedby="address-description">
			            	<div id="address-description"></div>
			            </li>

			            <li>
			            	<input id="order-timestamp" name="order_timestamp" type="hidden" value="<?php echo date("Y-m-d H:i:s") ;?>">
			            	<input id="order-microtime" name="order_microtime" type="hidden" value="<?php echo microtime() ;?>">
			            </li>
			            
			            <button class="sub-btn">预约上门</button>
			        </ul>   
		        </form>

		        <p class="order-promise">国众郑重承诺：预约上门服务绝不产生任何费用，并对您提交的资料严格保密！</p>
		
	<script src="js/jquery.js"></script>
	<script src="js/jquery-mvalidate.js"></script>
	<script type="text/javascript">
	   $(function(){
	        var captchaCodeVal;
	        $("#captcha_btn").on("click",function(){
	            var src='php/captcha.php?r=Math.random()';
	            $("#captcha_img").attr("src",src);
	            $.ajax({
	                url:"welcome/save_order",
	                type:"get",
	                success:function(data){
	                    captchaCodeVal=data;
	                }
	            });
	            $("#J_captchaCode").val("").trigger("keyup");

	        }).trigger('click');
	        $.mvalidateExtend({
	            phone:{
	                required : true,   
	                pattern : /^0?1[3|4|5|8][0-9]\d{8}$/,
	                each:function(){  
	                },
	                descriptions:{
	                    required : '<span class="field-invalidmsg">请输入手机号码（必填）</span>',
	                    pattern : '<span class="field-invalidmsg">您输入的手机号码格式不正确</span>',
	                    valid : '<span class="field-validmsg">正确</span>'
	                }
	            }
	        });
	       
	        $("#form2").mvalidate({
	            type:2,
	            onKeyup:true,
	            sendForm:true,
	            firstInvalidFocus:true,
	            descriptions:{
	                address:{
	                    required : '<span class="field-invalidmsg">请输入信息</span>',
	                    valid : '<span class="field-validmsg">选填</span>'
	                },
	                username:{
	                    required : '<span class="field-invalidmsg">请输入信息</span>',
	                    valid : '<span class="field-validmsg">选填</span>'
	                }
	                
	            }
	        });
	   });
</script>
		


		
	</div>

	<script src="js/zepto.min.js"></script>
	<script>


		var $address = $('#order_address');
		var $name = $('#order_name');
		var $tel = $('#order_tel');
		var $submit = $('#submit');
		// $address.on('blur',function(){
		// 	if($(this).val()==""){
		// 		// alert("请填写您的地址！");
		// 		$(this).css('background','#fecb00');
		// 	}else{
		// 		$(this).css('background','#fff');
		// 	}
		// });
		// $name.on('blur',function(){
		// 	if($(this).val()==""){
		// 		// alert("请填写您的称呼！");
		// 		$(this).css('background','#fecb00');
		// 	}else{
		// 		$(this).css('background','#fff');
		// 	}
		// });
		$tel.on('blur',function(){
			if($(this).val()==""){
				// alert("请填写您的联系方式！");
				$(this).css('background','#fecb00');
			}else{
				$(this).css('background','#fff');
			}
		});
		
	</script>


	<script>
	
		$('.sub-btn').on('click',function(){
			var $open_id = $('#open_id');
			var $address = $('#order_address');
			var $name = $('#order_name');
			var $tel = $('#order_tel');
			var $type_val = $('.order-type').html();
			var $type = $('#order_type');

			// console.log($open_id.val());
			//alert($type_val);
        

        //$.post(url, data, callback, type);
        $.post('welcome/save_order',{
	            open_id: $open_id.val(),
	            order_address: $address.val(),
	            order_name: $name.val(),
	            order_tel: $tel.val(),
	            order_type: $type.val($type_val)
	            
        	},function(res){
           		// if(res == 'success' ){
	            //    alert('感谢您的留言!');
	            //    location.reload();
           		// }
        	});
    	});
		
	</script>
	
</body>
</html>