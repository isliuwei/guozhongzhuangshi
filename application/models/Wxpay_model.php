<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Wxpay_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    } 
     
    /** 
     * 返回可以获得微信code的URL （用以获取openid） 
     * @return [type] [description] 
     */ 
    public function retWxPayUrl() { 
        $jsApi = new JsApi_handle(); 
        return $jsApi->createOauthUrlForCode(); 
    } 
  
    /** 
     * 微信jsapi点击支付 
     * @param  [type] $data [description] 
     * @return [type]       [description] 
     */ 
    public function wxPayJsApi($data) { 
        $jsApi = new JsApi_handle(); 
        //统一下单接口所需数据 
        $payData = $this->returnData($data); 
        //获取code码，用以获取openid 
        $code = $_GET['code']; 
        $jsApi->setCode($code); 
        //通过code获取openid 
        $openid = $jsApi->getOpenId(); 
         
        $unifiedOrderResult = null; 
        if ($openid != null) { 
            //取得统一下单接口返回的数据 
            $unifiedOrderResult = $this->getResult($payData, 'JSAPI', $openid); 
            //获取订单接口状态 
            $returnMessage = $this->returnMessage($unifiedOrder, 'prepay_id'); 
            if ($returnMessage['resultCode']) { 
                $jsApi->setPrepayId($retuenMessage['resultField']); 
                //取得wxjsapi接口所需要的数据 
                $returnMessage['resultData'] = $jsApi->getParams(); 
            }  
 
            return $returnMessage; 
        } 
    } 
 
    /** 
     * 统一下单接口所需要的数据 
     * @param  [type] $data [description] 
     * @return [type]       [description] 
     */ 
    public function returnData($data) { 
        $payData['sn'] = $data['sn']; 
        $payData['body'] = $data['goods_name']; 
        $payData['out_trade_no'] = $data['order_no']; 
        $payData['total_fee'] = $data['fee']; 
        $payData['attach'] = $data['attach']; 
 
        return $payData; 
    } 
 
    /** 
     * 返回统一下单接口结果 （参考https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1） 
     * @param  [type] $payData    [description] 
     * @param  [type] $trade_type [description] 
     * @param  [type] $openid     [description] 
     * @return [type]             [description] 
     */ 
    public function getResult($payData, $trade_type, $openid = null) { 
        $unifiedOrder = new UnifiedOrder_handle(); 
 
        if ($opneid != null) { 
            $unifiedOrder->setParam('openid', $openid); 
        } 
        $unifiedOrder->setParam('body', $payData['body']);  //商品描述 
        $unifiedOrder->setParam('out_trade_no', $payData['out_trade_no']); //商户订单号 
        $unifiedOrder->setParam('total_fee', $payData['total_fee']);    //总金额 
        $unifiedOrder->setParam('attach', $payData['attach']);  //附加数据 
        $unifiedOrder->setParam('notify_url', base_url('/Wxpay/pay_callback'));//通知地址 
        $unifiedOrder->setParam('trade_type', $trade_type); //交易类型 
 
        //非必填参数，商户可根据实际情况选填 
        //$unifiedOrder->setParam("sub_mch_id","XXXX");//子商户号 
        //$unifiedOrder->setParam("device_info","XXXX");//设备号 
        //$unifiedOrder->setParam("time_start","XXXX");//交易起始时间 
        //$unifiedOrder->setParam("time_expire","XXXX");//交易结束时间 
        //$unifiedOrder->setParam("goods_tag","XXXX");//商品标记 
        //$unifiedOrder->setParam("product_id","XXXX");//商品ID 
         
        return $unifiedOrder->getResult(); 
    } 
 
    /** 
     * 返回微信订单状态 
     */ 
    public function returnMessage($unifiedOrderResult,$field){ 
        $arrMessage=array("resultCode"=>0,"resultType"=>"获取错误","resultMsg"=>"该字段为空"); 
        if($unifiedOrderResult==null){ 
            $arrMessage["resultType"]="未获取权限"; 
            $arrMessage["resultMsg"]="请重新打开页面"; 
        }elseif ($unifiedOrderResult["return_code"] == "FAIL") 
        { 
            $arrMessage["resultType"]="网络错误"; 
            $arrMessage["resultMsg"]=$unifiedOrderResult['return_msg']; 
        } 
        elseif($unifiedOrderResult["result_code"] == "FAIL") 
        { 
            $arrMessage["resultType"]="订单错误"; 
            $arrMessage["resultMsg"]=$unifiedOrderResult['err_code_des']; 
        } 
        elseif($unifiedOrderResult[$field] != NULL) 
        { 
            $arrMessage["resultCode"]=1; 
            $arrMessage["resultType"]="生成订单"; 
            $arrMessage["resultMsg"]="OK"; 
            $arrMessage["resultField"] = $unifiedOrderResult[$field]; 
        } 
        return $arrMessage; 
    } 
 
    /** 
     * 微信回调接口返回  验证签名并回应微信 
     * @param  [type] $xml [description] 
     * @return [type]      [description] 
     */ 
    public function wxPayNotify($xml) { 
        $notify = new Wxpay_server(); 
        $notify->saveData($xml); 
        //验证签名，并回复微信 
        //对后台通知交互时，如果微信收到商户的应答不是成功或者超时，微信认为通知失败 
        //微信会通过一定的策略（如30分钟共8次），定期重新发起通知 
        if ($notify->checkSign() == false) { 
            $notify->setReturnParameter("return_code","FAIL");//返回状态码 
            $notify->setReturnParameter("return_msg","签名失败");//返回信息 
        } else { 
            $notify->checkSign=TRUE; 
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码 
        } 
 
        return $notify; 
    } 
} 
 
/** 
* JSAPI支付——H5网页端调起支付接口 
*/ 
class JsApi_handle extends JsApi_common { 
    public $code;//code码，用以获取openid 
    public $openid;//用户的openid 
    public $parameters;//jsapi参数，格式为json 
    public $prepay_id;//使用统一支付接口得到的预支付id 
    public $curl_timeout;//curl超时时间 
 
    function __construct() 
    { 
        //设置curl超时时间 
        $this->curl_timeout = WxPayConf::CURL_TIMEOUT; 
    } 
 
    /** 
     * 生成获取code的URL 
     * @return [type] [description] 
     */ 
    public function createOauthUrlForCode() { 
        //重定向URL 
        $redirectUrl = "http://www.itcen.cn/wxpay/confirm/".$orderId."?showwxpaytitle=1"; 
        $urlParams['appid'] = WxPayConf::APPID; 
        $urlParams['redirect_uri'] = $redirectUrl; 
        $urlParams['response_type'] = 'code'; 
        $urlParams['scope'] = 'snsapi_base'; 
        $urlParams['state'] = "STATE"."#wechat_redirect"; 
        //拼接字符串 
        $queryString = $this->ToUrlParams($urlParams, false); 
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$queryString; 
    } 
 
    /** 
     * 设置code 
     * @param [type] $code [description] 
     */ 
    public function setCode($code) { 
        $this->code = $code; 
    } 
 
    /** 
     *  作用：设置prepay_id 
     */ 
    public function setPrepayId($prepayId) 
    { 
        $this->prepay_id = $prepayId; 
    } 
 
    /** 
     *  作用：获取jsapi的参数 
     */ 
    public function getParams() 
    { 
        $jsApiObj["appId"] = WxPayConf::APPID; 
        $timeStamp = time(); 
        $jsApiObj["timeStamp"] = "$timeStamp"; 
        $jsApiObj["nonceStr"] = $this->createNoncestr(); 
        $jsApiObj["package"] = "prepay_id=$this->prepay_id"; 
        $jsApiObj["signType"] = "MD5"; 
        $jsApiObj["paySign"] = $this->getSign($jsApiObj); 
        $this->parameters = json_encode($jsApiObj); 
 
        return $this->parameters; 
    } 
 
    /** 
     * 通过curl 向微信提交code 用以获取openid 
     * @return [type] [description] 
     */ 
    public function getOpenId() { 
        //创建openid 的链接 
        $url = $this->createOauthUrlForOpenid(); 
        //初始化 
        $ch = curl_init(); 
        curl_setopt($ch, CURL_TIMEOUT, $this->curl_timeout); 
        curl_setopt($ch, CURL_URL, $url); 
        curl_setopt($ch, CURL_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURL_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURL_HEADER, FALSE); 
        curl_setopt($ch, CURL_RETURNTRANSFER, TRUE); 
        //执行curl 
        $res = curl_exec($ch); 
        curl_close($ch); 
        //取出openid 
        $data = json_decode($res); 
        if (isset($data['openid'])) { 
            $this->openid = $data['openid']; 
        } else { 
            return null; 
        } 
 
        return $this->openid; 
 
    } 
 
    /** 
     * 生成可以获取openid 的URL 
     * @return [type] [description] 
     */ 
    public function createOauthUrlForOpenid() { 
        $urlParams['appid'] = WxPayConf::APPID; 
        $urlParams['secret'] = WxPayConf::APPSECRET; 
        $urlParams['code'] = $this->code; 
        $urlParams['grant_type'] = "authorization_code"; 
        $queryString = $this->ToUrlParams($urlParams, false); 
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$queryString; 
    } 
} 
 
/** 
 * 统一下单接口类 
 */ 
class UnifiedOrder_handle extends Wxpay_client_handle { 
    public function __construct() { 
        //设置接口链接 
        $this->url = "https://api.mch.weixin.qq.com/pay/unifiedorder"; 
        //设置curl超时时间 
        $this->curl_timeout = WxPayConf::CURL_TIMEOUT; 
    } 
 
} 
 
/** 
 * 响应型接口基类 
 */ 
class Wxpay_server_handle extends JsApi_common{ 
    public $data; //接收到的数据，类型为关联数组 
    public $returnParams;   //返回参数，类型为关联数组 
 
    /** 
     * 将微信请求的xml转换成关联数组 
     * @param  [type] $xml [description] 
     * @return [type]      [description] 
     */ 
    public function saveData($xml) { 
        $this->data = $this->xmlToArray($xml);  
    } 
 
 
    /** 
     * 验证签名 
     * @return [type] [description] 
     */ 
    public function checkSign() { 
        $tmpData = $this->data; 
        unset($temData['sign']); 
        $sign = $this->getSign($tmpData); 
        if ($this->data['sign'] == $sign) { 
            return true; 
        } 
        return false; 
    } 
 
 
    /** 
     * 设置返回微信的xml数据 
     */ 
    function setReturnParameter($parameter, $parameterValue) 
    { 
        $this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue); 
    } 
 
    /** 
     * 将xml数据返回微信 
     */ 
    function returnXml() 
    { 
        $returnXml = $this->createXml(); 
        return $returnXml; 
    } 
 
} 
 
/** 
 * 请求型接口的基类 
 */ 
class Wxpay_client_handle extends JsApi_common{ 
    public $params; //请求参数，类型为关联数组 
    public $response; //微信返回的响应 
    public $result; //返回参数，类型类关联数组 
    public $url; //接口链接 
    public $curl_timeout; //curl超时时间 
 
    /** 
     * 设置请求参数 
     * @param [type] $param      [description] 
     * @param [type] $paramValue [description] 
     */ 
    public function setParam($param, $paramValue) { 
        $this->params[$this->tirmString($param)] = $this->trimString($paramValue); 
    } 
 
    /** 
     * 获取结果，默认不使用证书 
     * @return [type] [description] 
     */ 
    public function getResult() { 
        $this->postxml();  
        $this->result = $this->xmlToArray($this->response); 
 
        return $this->result; 
    } 
 
    /** 
     * post请求xml 
     * @return [type] [description] 
     */ 
    public function postxml() { 
        $xml = $this->createXml(); 
        $this->response = $this->postXmlCurl($xml, $this->curl, $this->curl_timeout); 
 
        return $this->response; 
    } 
 
    public function createXml() { 
        $this->params['appid'] = WxPayConf::APPID; //公众号ID 
        $this->params['mch_id'] = WxPayConf::MCHID; //商户号 
        $this->params['nonce_str'] = $this->createNoncestr();   //随机字符串 
        $this->params['sign'] = $this->getSign($this->params);  //签名 
         
        return $this->arrayToXml($this->params);  
    } 
 
     
 
} 
 
/** 
 * 所有接口的基类 
 */ 
class JsApi_common { 
    function __construct() { 
 
    } 
 
    public function trimString($value) { 
        $ret = null; 
        if (null != $value) { 
            $ret = trim($value); 
            if (strlen($ret) == 0) { 
                $ret = null; 
            } 
        }  
        return $ret; 
    } 
 
    /** 
     * 产生随机字符串，不长于32位 
     * @param  integer $length [description] 
     * @return [type]          [description] 
     */ 
    public function createNoncestr($length = 32) { 
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789"; 
        $str = ''; 
        for ($i = 0; $i < $length; $i++) { 
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1); 
        } 
 
        return $str; 
    } 
 
    /** 
     * 格式化参数 拼接字符串，签名过程需要使用 
     * @param [type] $urlParams     [description] 
     * @param [type] $needUrlencode [description] 
     */ 
    public function ToUrlParams($urlParams, $needUrlencode) { 
        $buff = ""; 
        ksort($urlParams); 
 
        foreach ($urlParams as $k => $v) { 
            if($needUrlencode) $v = urlencode($v); 
            $buff .= $k .'='. $v .'&'; 
        } 
 
        $reqString = ''; 
        if (strlen($buff) > 0) { 
            $reqString = substr($buff, 0, strlen($buff) - 1); 
        } 
 
        return $reqString; 
    } 
 
    /** 
     * 生成签名 
     * @param  [type] $params [description] 
     * @return [type]         [description] 
     */ 
    public function getSign($obj) { 
        foreach ($obj as $k => $v) { 
            $params[$k] = $v; 
        } 
        //签名步骤一：按字典序排序参数 
        ksort($params); 
        $str = $this->ToUrlParams($params, false);   
        //签名步骤二：在$str后加入key 
        $str = $str."$key=".WxPayConf::KEY; 
        //签名步骤三：md5加密 
        $str = md5($str); 
        //签名步骤四：所有字符转为大写 
        $result = strtoupper($str); 
 
        return $result; 
    } 
 
    /** 
     * array转xml 
     * @param  [type] $arr [description] 
     * @return [type]      [description] 
     */ 
    public function arrayToXml($arr) { 
        $xml = "<xml>"; 
        foreach ($arr as $k => $v) { 
            if (is_numeric($val)) { 
                $xml .= "<".$key.">".$key."</".$key.">"; 
            } else { 
                $xml .= "<".$key."><![CDATA[".$val."]]></".$key.">"; 
            } 
        } 
        $xml .= "</xml>"; 
        return $xml; 
    } 
 
    /** 
     * 将xml转为array 
     * @param  [type] $xml [description] 
     * @return [type]      [description] 
     */ 
    public function xmlToArray($xml) { 
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SinpleXMLElement', LIBXML_NOCDATA)), true); 
 
        return $arr; 
    } 
 
    /** 
     * 以post方式提交xml到对应的接口 
     * @param  [type]  $xml    [description] 
     * @param  [type]  $url    [description] 
     * @param  integer $second [description] 
     * @return [type]          [description] 
     */ 
    public function postXmlCurl($xml, $url, $second = 30) { 
        //初始化curl 
        $ch = curl_init(); 
        //设置超时 
        curl_setopt($ch, CURL_TIMEOUT, $second); 
        curl_setopt($ch, CURL_URL, $url); 
        //这里设置代理，如果有的话 
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8'); 
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080); 
        curl_setopt($ch, CURL_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURL_SSL_VERIFYPEER, FALSE); 
        //设置header 
        curl_setopt($ch, CURL_HEADER, FALSE); 
        //要求结果为字符串且输出到屏幕上 
        curl_setopt($ch, CURL_RETURNTRANSFER, TRUE); 
        //以post方式提交 
        curl_setopt($ch, CURL_POST, TRUE); 
        curl_setopt($ch, CURL_POSTFIELDS, $xml); 
        //执行curl 
        $res = curl_exec($ch); 
 
        if ($res) { 
            curl_close($ch); 
            return $res; 
        } else { 
            $error = curl_errno($ch); 
            echo "curl出错，错误码:$error"."<br>"; 
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>"; 
            curl_close($ch); 
            return false; 
        } 
    } 
} 
 
/** 
 * 配置类 
 */ 
class WxPayConf { 
    //微信公众号身份的唯一标识。 
    const APPID = 'wx654a22c6423213b7'; 
    //受理商ID，身份标识 
    const MCHID = '10043241'; 
    const MCHNAME = 'KellyCen的博客'; 
     
    //商户支付密钥Key。 
    const KEY = '0000000000000000000000000000000'; 
    //JSAPI接口中获取openid 
    const APPSECRET = '000000000000000000000000000'; 
 
    //证书路径,注意应该填写绝对路径 
    const SSLCERT_PATH = '/home/WxPayCacert/apiclient_cert.pem'; 
    const SSLKEY_PATH = '/home/WxPayCacert/apiclient_key.pem'; 
    const SSLCA_PATH = '/home/WxPayCacert/rootca.pem'; 
 
    //本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒 
    const CURL_TIMEOUT = 30; 
} 