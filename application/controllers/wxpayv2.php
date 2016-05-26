<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Wxpay extends MY_Controller { 
    public function __construct() { 
        parent::__construct(); 
        $this->load->model('wxpay_model'); 
        //$this->load->model('wxpay'); 
         
    } 
  
    public function index() { 
        //微信支付 
        $this->smarty['wxPayUrl'] = $this->wxpay_model->retWxPayUrl(); 
        $this->displayView('wxpay/index.tpl'); 
    } 
 
    /** 
     * 手机端微信支付，此处是授权获取到code时的回调地址 
     * @param  [type] $orderId 订单编号id 
     * @return [type]          [description] 
     */  
    public function confirm($orderId) { 
        //先确认用户是否登录 
        $this->ensureLogin(); 
        //通过订单编号获取订单数据 
        $order = $this->wxpay_model->get($orderId); 
        //验证订单是否是当前用户 
        $this->_verifyUser($order); 
 
        //取得支付所需要的订单数据 
        $orderData = $this->returnOrderData[$orderId]; 
        //取得jsApi所需要的数据 
        $wxJsApiData = $this->wxpay_model->wxPayJsApi($orderData); 
        //将数据分配到模板去，在js里使用 
        $this->smartyData['wxJsApiData'] = json_encode($wxJsApiData, JSON_UNESCAPED_UNICODE); 
        $this->smartyData['order'] = $orderData; 
        $this->displayView('wxpay/confirm.tpl'); 
         
    } 
    /** 
     * 支付回调接口 
     * @return [type] [description] 
     */ 
    public function pay_callback() { 
        $postData = ''; 
        if (file_get_contents("php://input")) { 
            $postData = file_get_contents("php://input"); 
        } else { 
            return; 
        } 
        $payInfo = array(); 
        $notify = $this->wxpay_model->wxPayNotify($postData); 
 
        if ($notify->checkSign == TRUE) { 
            if ($notify->data['return_code'] == 'FAIL') { 
                $payInfo['status'] = FALSE; 
                $payInfo['msg'] = '通信出错'; 
            } elseif ($notify->data['result_code'] == 'FAIL') { 
                $payInfo['status'] = FALSE; 
                $payInfo['msg'] = '业务出错'; 
            } else { 
                $payInfo['status'] = TRUE; 
                $payInfo['msg'] = '支付成功'; 
                $payInfo['sn']=substr($notify->data['out_trade_no'],8); 
                $payInfo['order_no'] = $notify->data['out_trade_no']; 
                $payInfo['platform_no']=$notify->data['transaction_id']; 
                $payInfo['attach']=$notify->data['attach']; 
                $payInfo['fee']=$notify->data['cash_fee']; 
                $payInfo['currency']=$notify->data['fee_type']; 
                $payInfo['user_sign']=$notify->data['openid']; 
            } 
        } 
        $returnXml = $notify->returnXml(); 
 
        echo $returnXml; 
 
        $this->load->library('RedisCache'); 
        if($payInfo['status']){ 
           //这里要记录到日志处理（略） 
            $this->model->order->onPaySuccess($payInfo['sn'], $payInfo['order_no'], $payInfo['platform_no'],'', $payInfo['user_sign'], $payInfo); 
            $this->redis->RedisCache->set('order:payNo:'.$payInfo['order_no'],'OK',5000); 
        }else{ 
           //这里要记录到日志处理（略） 
            $this->model->order->onPayFailure($payInfo['sn'], $payInfo['order_no'], $payInfo['platform_no'],'', $payInfo['user_sign'], $payInfo, '订单支付失败 ['.$payInfo['msg'].']'); 
        } 
    } 
 
    /** 
     * 返回支付所需要的数据 
     * @param  [type] $orderId 订单号 
     * @param  string $data    订单数据，当$data数据存在时刷新$orderData缓存，因为订单号不唯一 
     * @return [type]          [description] 
     */ 
    public function returnOrderData($orderId, $data = '') { 
        //获取订单数据 
        $order = $this->wxpay_model->get($orderId); 
        if (0 === count($order)) return false; 
        if (emptyempty($data)) { 
            $this->load->library('RedisCache'); 
            //取得缓存在redis的订单数据 
            $orderData = $this->rediscache->getJson("order:orderData:".$orderId); 
            if (emptyempty($orderData)) { 
                //如果redis里没有，则直接读数据库取 
                $this->load->model('order_model'); 
                $order = $this->order_model->get($orderId); 
                if (0 === count($order)) { 
                    return false; 
                } 
                $data = $order; 
            } else { 
                //如果redis里面有的话，直接返回数据 
                return $orderData; 
            } 
        } 
  
        //支付前缓存所需要的数据 
        $orderData['id'] = $data['id']; 
        $orderData['fee'] = $data['fee']; 
 
        //支付平台需要的数据 
        $orderData['user_id'] = $data['user_id']; 
        $orderData['sn'] = $data['cn']; 
        //这是唯一编号 
        $orderData['order_no'] = substr(md5($data['sn'].$data['fee']), 8, 8).$data['sn']; 
        $orderData['fee'] = $data['fee']; 
        $orderData['time'] = $data['time']; 
        $orderData['goods_name'] = $data['goods_name']; 
        $orderData['attach'] = $data['attach']; 
 
        //将数据缓存到redis里面 
        $this->rediscache->set("order:orderData:".$orderId, $orderData, 3600*24); 
        //做个标识缓存到redis，用以判断该订单是否已经支付了 
        $this->rediscache->set("order:payNo:".$orderData['order_no'], "NO", 3600*24); 
 
        return $orderData; 
    } 
 
    private function _verifyUser($order) { 
        if (emptyempty($order)) show_404(); 
        if (0 === count($order)) show_404(); 
        //判断订单表里的用户id是否是当前登录者的id 
        if ($order['user_id'] == $this->uid) return; 
        show_error('只能查看自己的订单'); 
    } 
 
} 
 