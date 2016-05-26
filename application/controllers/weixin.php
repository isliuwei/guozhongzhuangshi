<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//
// 接收用户消息
// 微信公众账号接收到用户的消息类型判断
//
// class Weixin extends CI_Controller
// {

// }
define("TOKEN", "weixin");
define("APPID", "wx8bdd74650fd816e3");
// define("APPID", "wxef1e6d0a562373c8");
define("APPSECRET", "1363298f77bfc489f6935e44508e9747");
// define("APPSECRET", "f44562e1b40a00e8d19ffabd18ba131e");


class Weixin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();


        if (isset($_GET['echostr'])) {
            $this->valid();
        }else{
            $this->responseMsg();
        }
    }
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            $fromUsername = $postObj['FromUserName'];
            $toUsername = $postObj['ToUserName'];
            $keyword = trim($postObj['Content']);
            $time = time();
            $msgType = trim($postObj['MsgType']);

            //用户发送的消息类型判断
            if(!empty($keyword)){
                switch ($msgType)
                {
                    case "text":    //文本消息
                        /*$contentStr = date("Y-m-d H:i:s",time());
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;*/
                        // $open_id = $this -> get_openid();
                        $contentStr = "欢迎访问国众装饰，我们将竭诚为你服务！请您稍等片刻，我们客服人员将第一时间联系您！";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                        $this -> load -> model('message_model');
                        $this -> message_model -> save($keyword, $fromUsername);
                        break;
                    case "image":   //图片消息
                        break;

                    case "voice":   //语音消息
                        break;
                    case "video":   //视频消息
                        break;
                    case "location"://位置消息
                        break;
                    case "link":    //链接消息
                        break;
                    default:
                        break;
                }
            }
            
            echo $result;
        }else {
            echo "";
            exit;
        }
    }



























}
?>