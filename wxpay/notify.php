<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'log.php';

//引入数据库连接文件
//include "ConnMySQL.php";

//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);





class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			//此处使用最原始的mysql_connect方式连接数据库进行支付后的数据库操作
			//比如修改t_order表，添加微信支付订单号：transaction_id，
			//商户订单号：out_trade_no，订单金额：total_fee
			//支付时间：time_end，用户标识：openid等信息
			//所有这些信息在$result中，$result是一个数组，使用这样的格式获取其中的数据
			//$result["transaction_id"]
			//订单号
			//@ "transaction_id":"4010152001201605155898674540"



			
			//接收订单支付总金额（单位为分）
			//@ "total_fee":"1"(以分为单位)
			$total_fee = $result["total_fee"]/100;

			//接收附属信息 （包括：订单号、订单联系电话）
			//@ "attach":"20160514153030500874|15765505994"
			$pay_info = $result["attach"];
			$arr = explode("|", $pay_info);
			$order_no = $arr[0];
			$order_tel = $arr[1];

			//接收订单支付完成时间
			//@ "time_end":"20160515232423"
			$timeStr = $result["time_end"];
			
			$year= substr( $timeStr, 0, 4);
			$month= substr( $timeStr, 4, 2);
			$day = substr( $timeStr, 6, 2);
			$hour = substr( $timeStr, 8, 2); 
			$minute = substr( $timeStr, 10, 2);
			$second= substr( $timeStr, 12, 2);

			$pay_time = $year."-".$month."-".$day." ".$hour.":".$minute.":".$minute;





			
			/******  数据库连接  ******/
			//@打开一个到 MySQL 服务器的新的连接
		    $con = mysqli_connect("qdm189698249.my3w.com","qdm189698249","aliyunmysql1991");
		    if (!$con)
		    {
		    	// 检测是否连接成功
		        die("连接MySQL数据库失败! <br/>错误代码: " . mysqli_connect_errno());
		    }else{
		    	echo "连接成功！";
		    }

		    //@更改连接的默认数据库,选择 MySQL 数据库
		    mysqli_select_db($con,"qdm189698249_db");

		    //@设置默认客户端字符集
		    mysqli_set_charset($con,"utf8");

		    /******  数据库连接  ******/

			
			$sql = "update t_order set order_money = '$total_fee' , order_contact = '$order_tel', pay_time = '$pay_time' where order_no = '$order_no'";
			
    		$query = mysqli_query( $con , $sql );

    		mysqli_close($con);
			

			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
