<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

		

//初始化日志
$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//通过get的方式获取在Wxpay.JsApiPay.php页面存的$state的值，也就是支付页面存的值
$state = $_GET['state'];
$orderInfo = explode("|", $state);
$orderNo = $orderInfo[0];
$orderMoney = $orderInfo[1]*100;
$orderTel = $orderInfo[2];

$payInfo = $orderNo."|".$orderTel;


  
/*session_start();  
$orderNo=$_POST['order_no']; 
$orderMoney=$_POST['order_money'];
$orderTel=$_POST['order_tel']; 
*/
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("装修服务费");
//$input->SetAttach($orderNo);
$input->SetAttach($payInfo);
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($orderMoney);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://isliuwei.com/wxpay/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
// echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
// printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
// $editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */



?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <title>微信支付-确认支付</title>
    <!-- 引入 WeUI -->
	<link rel="stylesheet" href="http://isliuwei.com/css/weui.css">
    <input type="hidden" value="<?php  echo $openId; ?>" id="openId">
    <script type="text/javascript">
	//调用微信JS api 支付
	var $a = document.getElementById('#openId');
	var $openId = $a.value;
	
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				  
				  if(res.err_msg=="get_brand_wcpay_request:ok"){
				  	//location.href = 'http://isliuwei.com/welcome/pay_success?openId='+$openId ;
				  	location.href = 'http://isliuwei.com/welcome/pay_success' ;
				  }else{
				  	alert('支付失败!');


				  }

				 
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
</head>
<body>
	<div class="weui_msg">
    <div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
    <div class="weui_text_area">
        <h2 class="weui_msg_title">确认支付</h2>
        <p class="weui_msg_desc">为保障您的权益，请您在支付前再次核对支付金额</p>
        <font color="#9ACD32"></p><b><span style="color:#f00;font-size:50px"><?php echo $orderMoney/100 ;?>元</span></b></font><br/><br/>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="javascript:;" class="weui_btn weui_btn_primary" onclick="callpay()">立即支付</a>
            <!-- <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button> -->	  	
		    <a href="javascript:;" id='show-alert' class="weui_btn weui_btn_default">取消</a>
        </p>
    </div>
    
    



	
</div>



<script src="http://isliuwei.com/js/jquery.js"></script>
<script src="http://isliuwei.com/js/jquery-weui.js"></script>
 <script>
      $(document).on("click", "#show-alert", function() {
        $.alert("2s后将返回订单详情页面!");
        setInterval(function(){
        	location.href="http://isliuwei.com/welcome/valid";
        },2000);	
      });
      
    </script>
	

</body>
</html>

















