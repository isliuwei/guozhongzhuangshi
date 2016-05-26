<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('wechat');	
		//$this->load->library('weixin');	
			

	}

	//index首页
	public function index()
	{
		//当用户通过微信浏览首页时，获取用户的微信的openid并将其存入session

		//$open_id = $this -> wechat -> get_openid();
		//$this -> session -> set_userdata('open_id', $open_id);
		// $nickname = $this -> wechat -> get_nickname();
		// $data = array(
  //           'nickname' => $nickname
  //           );
		// $this -> session -> set_userdata($data);

		//解决跳转页面时无法获取session的问题
		if($this -> session -> userdata('open_id')!=""){
            $open_id = $this -> session -> userdata('open_id');
        }else{
            $open_id = $this -> wechat -> get_openid();
            // $nickname = $this -> wechat -> get_nickname();
            $this -> session -> set_userdata('open_id', $open_id);
            // $this -> session -> set_userdata('nickname', $nickname);
        }


		//从数据库查服务类别信息
		$this -> load -> model('service_model');
        $result = $this -> service_model -> get_all();

        $data = array(
            'services' => $result
            );

        //将服务信息传至index页面
		$this->load->view('index',$data);
		
	}


	//服务项目页面
	public function service(){
        $service_id = $this -> uri -> segment(3);  
        
        $this -> load -> model('service_model');

        $items = $this -> service_model -> get_items_by_id($service_id);
        $data = array(
            'items' => $items
            );
        $this -> load -> view('service',$data); 
    }


    //服务详情页面
	public function detail(){
        $service_id = $this -> uri -> segment(3);  
        //将$service_id存入session中，方便后续页面访问该值
        $array = array(
            'service_id' => $service_id
            );
        $this -> session -> set_userdata($array);

       //获取服务内容
        $this -> load -> model('service_model');
        $contents = $this -> service_model -> get_contents_by_id($service_id);

        //获取案例
        $this -> load -> model('case_model');
        $cases = $this -> case_model -> get_all();
        
        $data = array(
            'contents' => $contents,
            'cases' => $cases
            );
        
        $this -> load -> view('detail',$data); 
    }

    //产品列表页面
    public function product_list()
	{

		$this -> load -> model('ad_model');
        $ad = $this -> ad_model -> get_all();

        $this -> load -> model('product_model');
		$category = $this -> product_model -> get_pro_cate();


		$data = array(
			'ads' => $ad,
			'category' => $category
			);

		$this->load->view('product-list',$data);
	}


	//产品列表页面

	public function product()
	{


		//接收产品类别id
		$pro_cate_id = $this -> uri -> segment(3);

		$this -> load -> model('product_model');

		$brands = $this -> product_model -> get_brands($pro_cate_id);

		$productId = array();
		foreach( $brands as $value){
			array_push($productId, $value -> brand_id);
		}
		$productId = join(',', $productId);
		// print_r($productId);
		// die();
		


		
		$product = $this -> product_model -> get_product_by_brands($productId);
		// echo "<pre>";

		// var_dump($product);
		// echo "</pre>";
		// die();
		//$product = $this -> product_model -> get_product_by_brands();


		




		$data = array(
			'brands' => $brands,
			'products' => $product
			);


		// echo "<pre>";

		// var_dump($data);
		// echo "</pre>";
		// die();





		// $result

		

		// echo "<pre>";

		// var_dump($data);
		// echo "</pre>";
		// die();

		


		$this->load->view('product',$data);
	}

	public function contact()
	{
		$this->load->view('contact');
	}

	public function order()
	{
		//从session中获取$service_id查询服务名称
		$service_id = $this->session->userdata('service_id');
		$this -> load -> model('service_model');


		$content = $this -> service_model -> get_content_by_id($service_id);
        $data = array(
            'content' => $content
            );

		$this->load->view('order',$data);
	}

	
	
	public function order_detail()
	{
		$this->load->view('order-detail');
	}
	public function valid()
	{
		$this->load->view('valid');
	}
	public function order_none()
	{
		$this->load->view('order-none');
	}

	public function order_list()
	{
		$this->load->view('order-list');
	}



    public function save_feedback(){
        $feedback_content = $this->input->post('feedback');
        $open_id = $this ->input->post('open_id');

        
        $this->load->model('feedback_model');

        $this->feedback_model->save_feedback($feedback_content,$open_id);
        redirect('welcome/contact');

    }

    //生成唯一订单编号函数
	public function trade_no($time) {
        list($usec, $sec) = explode(" ", $time);
        $usec = substr(str_replace('0.', '', $usec), 0 ,4);
        $str  = rand(10,99);
        return date("YmdHis").$usec.$str;
    }
    public function save_order(){

    	$open_id = $this->input->post('open_id');
    	// $nickname = $this->input->post('nickname');
    	// var_dump($nickname);
    	// die();

    	$order_address = $this->input->post('order_address');
    	$order_color = $this->input->post('order_color');
    	$order_name = $this->input->post('order_name');
    	$order_tel = $this->input->post('order_tel');
    	$order_type = $this->input->post('order_type');
    	$order_timestamp = $this->input->post('order_timestamp');
    	$order_microtime = $this->input->post('order_microtime');

    	//$order_no 生成的唯一订单编号
    	$order_no = $this->trade_no($order_microtime);
    	// echo $order_no;
    	// die();

        $this->load->model('order_model');
        $row = $this->order_model->save_order($open_id,$order_name,$order_address,$order_color,$order_tel,$order_type,$order_timestamp,$order_no);
        // redirect('welcome/order_detail');
        $data = array(
        	'add' => $order_address,
        	'tel' => $order_tel,
        	'type' => $order_type,
        	'name' => $order_name,
        	'color'=> $order_color,
        	'time'=> $order_timestamp,
        	'no'=> $order_no

        	);
        if($row>0){
        	$this -> load -> view('order-detail',$data);


        	$open_id = 'oWWVWw8MYx_4kB3HYX5U3HlaJeew';
        	$content = 'You have a new order, please deal with it in time!Phone:'.$order_tel.',Address:'.$order_address.',Name:'.$order_name;
        	$msg_data = array(
            	'touser' => $open_id,
            	'msgtype' => 'text',
            	'text' => array(
                'content' => $content
           	 	)
        	);
        
        	$this -> wechat -> push_message($msg_data);
           
    	}


    }


    public function db1()
	{
		$this -> load -> model('service_model');
		$result = $this -> service_model -> get_all();
		$data = array(
			'info' => $result
			);
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
		die();
		$this -> load -> view('testDB',$data);
	}

	
	public function other(){
		$this -> load ->view('other');
	}
	public function design(){
		$this -> load ->view('design');
	}


	public function product1()
	{


		//接收产品类别id
		$pro_cate_id = $this -> uri -> segment(3);

		$this -> load -> model('product_model');

		$brands = $this -> product_model -> get_brands($pro_cate_id);
		// $products = object{
		// 	'brands' -> $brands;
		// }
		foreach( $brands as $k => $v){
			//$product = $this -> product_model -> get_product_by_brand($v);
			echo $v;
			
		}
		die();
		echo "<pre>";

		var_dump($product);
		echo "</pre>";
		die();
		
		$productId = array();
		foreach( $brands as $value){
			array_push($productId, $value -> brand_id);
		}
		$productId = join(',', $productId);
		// print_r($productId);
		// die();
		


		
		$product = $this -> product_model -> get_product_by_brands($productId);
		// echo "<pre>";

		// var_dump($product);
		// echo "</pre>";
		// die();
		//$product = $this -> product_model -> get_product_by_brands();


		




		$data = array(
			'brands' => $brands,
			'products' => $product
			);


		// echo "<pre>";

		// var_dump($data);
		// echo "</pre>";
		// die();





		// $result

		

		// echo "<pre>";

		// var_dump($data);
		// echo "</pre>";
		// die();

		


		$this->load->view('product',$data);
	}


	public function pay_success()
	{
		$this->load->view('pay_success');
	}

	public function redirect_index(){
		redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx8bdd74650fd816e3&redirect_uri=http://www.isliuwei.com&response_type=code&scope=snsapi_base&state=1#wechat_redirect");
	}



	//回复微信消息
    public function reply_order_message(){
        $open_id = 'oWWVWw8MYx_4kB3HYX5U3HlaJeew';
        $content = 'You have a new order, please deal with it in time!';
        $msg_data = array(
            'touser' => $open_id,
            'msgtype' => 'text',
            'text' => array(
                'content' => $content
            )
        );
        // var_dump($msg_data);
        // die();
        
        $this -> wechat -> push_message($msg_data);
           
    }
    public function page(){
        $this -> load -> view('admin/page-index');
    }


    

     



    

    
	
}

