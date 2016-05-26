<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Weixinpay extends CI_Controller { 
    public function __construct() { 
        parent::__construct(); 
        //$this->load->model('wxpay_model'); 
        //$this->load->model('wxpay'); 
         
    } 
  
    


    public function index(){
        //$this->load->model('publist');//获取订单信息
        //$pub = $this->publist->GetList(array('id' => $_SESSION['orderid']));
        //微信支付配置的参数配置读取
        $this->load->config('wxpay_config');
        $wxconfig['appid']=$this->config->item('appid');
        $wxconfig['mch_id']=$this->config->item('mch_id');
        $wxconfig['apikey']=$this->config->item('apikey');
        $wxconfig['appsecret']=$this->config->item('appsecret');
        $wxconfig['sslcertPath']=$this->config->item('sslcertPath');
        $wxconfig['sslkeyPath']=$this->config->item('sslkeyPath');
        $this->load->library('Wechatpay',$wxconfig);
        //商户交易单号
        //$out_trade_no = $pub->listno;
        //$total_fee=$pub->fee;
        //$openid=$_SESSION['openid'];
        $param['body']="黑人牙膏";
        //$param['attach']=$pub->id;
        //$param['detail']="黑人牙膏-".$out_trade_no;
        //$param['out_trade_no']=$out_trade_no;
        //$param['total_fee']=$total_fee*100;
        $param["spbill_create_ip"] =$_SERVER['REMOTE_ADDR'];
        $param["time_start"] = date("YmdHis");
        $param["time_expire"] =date("YmdHis", time() + 600);
        $param["goods_tag"] = "黑人牙膏";
        $param["notify_url"] = base_url()."index.php/home/notify";
        $param["trade_type"] = "JSAPI";
        //$param["openid"] = $openid;
         
        //统一下单，获取结果，结果是为了构造jsapi调用微信支付组件所需参数
        $result=$this->wechatpay->unifiedOrder($param);
         
        //如果结果是成功的我们才能构造所需参数，首要判断预支付id
         
        if (isset($result["prepay_id"]) && !empty($result["prepay_id"])) {
            //调用支付类里的get_package方法，得到构造的参数
            //$data['parameters']=json_encode($this->wechatpay->get_package($result['prepay_id']));
            $data['notifyurl']=$param["notify_url"];
            //$data['fee']=$total_fee;
            //$data['pubid']=$_SESSION['orderid'];
         
            //$this->load->view('home/header');
            //要有个页面将以上数据传递过去并展示给用户
            $this->load->view('pay', $data);
            $this->load->view('footer');

            }

    
    } 
    public function pay_success(){
        $this -> load -> view('pay_success');
    }

    // public function pay_jsapi(){
        
    //     $this -> load -> view('pay_success');
    // }

 
} 
 