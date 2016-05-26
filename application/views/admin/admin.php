<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('wechat');
       

        $this -> load -> model('admin_model');
        $this -> load -> model('feedback_model');
       

    }

   


    

    public function index(){
        
        $this -> load -> view('admin/admin-index');
    }



   


    

    


    public function login(){
        $this -> load -> view('admin/login');
    }

    public function logout(){
        $this -> session -> unset_userdata('admin');
        redirect('admin/login');
    }

    // public function admin_reply(){
    //     $this -> load -> view('admin/admin-reply');
    // }




    //检查用户
    public function check_login(){
        //1. 接收数据
        $admin_name = $this -> input -> post('admin_name');
        $admin_pwd = $this -> input -> post('admin_pwd');

        //2. 连接数据库  查数据
        $this -> load -> model('admin_model');
        $row = $this -> admin_model -> get_by_name_pwd($admin_name, $admin_pwd);
        $data = array(
            'admin' => $row,
        );



        //3. 跳转
        if($row){
            $this -> session -> set_userdata($data);
            $this -> load -> view('admin/admin-index');

        }else{
            $this -> load -> view('admin/login');
        }
    }


    public function check_delete(){
        $admin_pwd = $this -> input -> get('pwd');
        $admin = $this -> session -> userdata('admin');
        $admin_name = $admin -> admin_name;
        $this -> load -> model('admin_model');
        $row = $this -> admin_model -> get_by_name_pwd($admin_name, $admin_pwd);
        if($row){
            echo "true";

        }else{
            echo "false";
        }
        
    }


    //新增管理
    // public function admin_add_mgr(){
    //     $this -> load -> view('admin/admin-add-mgr');
    // }


    /****  管理员信息  ****/


    //新增用户
    public function add_admin(){
        
        $this -> load -> view('admin/admin-add');
    }

    public function check_name(){
        $admin_name = $this -> input -> get('admin_name');


        $this -> load -> model('admin_model');

        $result = $this -> admin_model -> get_by_name($admin_name);



        if($result){
            echo 'success';
        }else{
            echo 'fail';
        }


    }

    
    //用户管理
    public function admin_mgr(){
        $this -> load -> model('admin_model');
        $result = $this -> admin_model -> get_all();
        if($result){
            $data = array(
              'admins' => $result
            );
            $this -> load -> view('admin/admin-mgr',$data);
        }
    }


    //新增用户
    public function save_admin(){
        $name = $this -> input -> post('name');
        $pwd = $this -> input -> post('pwd');


        //图片上传配置 !! 2016-01-23  by liuwei
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '3072';
        $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

        //图片上传操作
        $this -> load -> library('upload', $config);
        $this -> upload -> do_upload('photo');
        $upload_data = $this -> upload -> data();

        if ( $upload_data['file_size'] > 0 ) {
            //数据库中存photo的路径
            $photo_url = 'uploads/'.$upload_data['file_name'];
        }else{
            //如果不上传图片,则使用默认图片
            $photo_url = 'img/avatar.png';
        }
        $rows = $this -> admin_model -> save_admin_by_name_pwd_photo($name,$pwd, $photo_url);
        if($rows > 0){
            //echo "<script>alert('提交成功!')</script>";
            redirect('admin/admin_mgr');
        }
    }

    public function admin_updata_mgr(){
        $this -> load -> view('admin/admin-updata-mgr');
    }


    
    public function get_admin(){
        $admin_id = $this -> input -> get('admin_id');
        $this -> load -> model('admin_model');
        $result = $this -> admin_model -> get_admin_by_id($admin_id);

        if($result){
            $data = array(
                'admin' => $result
            );
            $this -> load -> view('admin/admin-updata-mgr',$data);
        }

    }


        public function updata_admin(){
            $admin_id = $this -> input -> post('admin_id');
            $name = $this -> input -> post('admin_name');
            $pwd = $this -> input -> post('admin_pwd');

            //获取当前图像的url $photo_old_url
            //如果不更改上传的图片,则使用当前图片
            //2016-01-24
            $photo_old_url = $this -> input -> post('photo_old_url');



            //图片上传配置 !! 2016-01-24 09:45  by liuwei
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '3072';
            $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

            //图片上传操作
            $this -> load -> library('upload', $config);
            $this -> upload -> do_upload('photo');
            $upload_data = $this -> upload -> data();




            if ( $upload_data['file_size'] > 0 ) {
                //数据库中存photo的路径
                $photo_url = 'uploads/'.$upload_data['file_name'];
            }else{
                //如果不更改上传的图片,则使用当前图片
                //!! 如何获取当前图片的地址!! 2016-01-24
                $photo_url = $photo_old_url;
            }

            $this -> load -> model('admin_model');
            $this -> admin_model -> updata_admin($admin_id,$name,$pwd,$photo_url);
            echo "<script>alert('提交成功!')</script>";
            redirect('admin/admin_mgr');

    }




    //删除用户
    public function delete_admin(){
        $admin_id = $this -> input -> get('admin_id');
        $this -> load -> model('admin_model');
        $this -> admin_model -> delete($admin_id);
        //$this -> admin_mgr();
        redirect('admin/admin_mgr');
    }

    public function admin_reply(){
        $this -> load -> view('admin/admin-reply');
    }


    public function reply_message(){
        $open_id = $this -> input -> post('openId');
        $content = $this -> input -> post('replyContent');
        $msg_data = array(
            'touser' => $open_id,
            'msgtype' => 'text',
            'text' => array(
                'content' => $content
            )
        );
        $this -> wechat -> push_message($msg_data);
        
        
    }


    

    //微信消息管理
    public function admin_message_mgr(){
        
        $this -> load -> model('message_model');
        $result = $this -> message_model -> get_all();
        
        if($result){
            $data = array(
                'messages' => $result
            );
        }
        $this -> load -> view('admin/admin-message-mgr',$data);
    }


    //用户订单管理
    public function admin_order_mgr(){
        
        $this -> load -> model('order_model');
        $result = $this -> order_model -> get_all();
        
        if($result){
            $data = array(
                'orders' => $result
            );
        }
        
        $this -> load -> view('admin/admin-order-mgr',$data);
    }

    //用户反馈信息管理
    public function admin_feedback_mgr(){
        
        $this -> load -> model('feedback_model');
        $result = $this -> feedback_model -> get_all();
        
        if($result){
            $data = array(
                'feedbacks' => $result
            );
        }
        
        $this -> load -> view('admin/admin-feedback-mgr',$data);
    }



    public function search_order(){
        //必须手机号和open_id同时验证成功才能，查看订单
        $open_id = $this -> input -> post('open_id');
        $order_tel = $this -> input -> post('order_tel');

        $this -> load -> model('order_model');
        $result = $this -> order_model -> get_by_tel_id($open_id,$order_tel);
        if($result){
            //验证成功，跳转至订单详情页面
            $data = array(
                'orders' => $result
                );
            $this -> load -> view('order-list',$data);
        }else{
            //验证失败，跳转至提示无订单页面
            $this -> load -> view('order-none');
        }
    } 


    // public function feedback(){
        
    //     $this -> load -> view('admin/admin-feedback-mgr');
    // }
















    //新增管理
    // public function admin_order_mgr(){
    //     $this -> load -> view('admin/admin-order-mgr');
    // }




    //广告管理
    public function admin_ad_mgr(){
        $this -> load -> model('ad_model');
        $result = $this -> ad_model -> get_all();
        if($result){
            $data = array(
              'ads' => $result
            );
            
            $this -> load -> view('admin/admin-ad-mgr',$data);
        }
    }


    //广告管理
    public function admin_add_ad(){

            
        $this -> load -> view('admin/admin-add-ad');
        
    }

    //新增广告
    public function save_ad(){
         //接收数据
        $ad_title = $this -> input -> post('ad_title');
        $ad_desc = $this -> input -> post('ad_desc');



        //图片上传配置 !! 2016-01-23  by liuwei
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '3072';
        $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

        //图片上传操作
        $this -> load -> library('upload', $config);
        $this -> upload -> do_upload('ad_img');
        $upload_data = $this -> upload -> data();


        if ( $upload_data['file_size'] > 0 ) {
            //数据库中存photo的路径
            $photo_url = 'uploads/'.$upload_data['file_name'];
        }else{
            //如果不上传图片,则使用默认图片
            $photo_url = 'img/avatar.png';
        }


        $this ->load -> model('ad_model');
        $row = $this -> ad_model -> save_ad($ad_title,$ad_desc,$photo_url);

        if($row > 0){
            redirect('admin/admin_ad_mgr');
        }
        
    }

    

    //删除广告
    public function delete_ad(){

        $ad_id = $this -> uri -> segment(3);

        $this -> load -> model('ad_model');

        $row = $this -> ad_model -> delete_by_id($ad_id);

        if($row>0){
            redirect('admin/admin_ad_mgr');
        }
    }


    public function get_ad(){

        $ad_id = $this -> uri -> segment(3);

        $this -> load -> model('ad_model');

        $result = $this -> ad_model -> get_ad_by_id($ad_id);

        $data = array(
            'ad' => $result
            );
        

        $this -> load -> view('admin/admin-get-ad',$data);

        
    }

    public function update_ad(){


            $ad_id = $this -> input -> post('ad_id');
            $ad_title = $this -> input -> post('ad_title');
            $ad_desc = $this -> input -> post('ad_desc');

            //获取当前图像的url $photo_old_url
            //如果不更改上传的图片,则使用当前图片
            //2016-01-24
            $photo_old_url = $this -> input -> post('photo_old_url');



            //图片上传配置 !! 2016-01-24 09:45  by liuwei
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '3072';
            $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

            //图片上传操作
            $this -> load -> library('upload', $config);
            $this -> upload -> do_upload('ad_img');
            $upload_data = $this -> upload -> data();




            if ( $upload_data['file_size'] > 0 ) {
                //数据库中存photo的路径
                $photo_url = 'uploads/'.$upload_data['file_name'];
            }else{
                //如果不更改上传的图片,则使用当前图片
                //!! 如何获取当前图片的地址!! 2016-01-24
                $photo_url = $photo_old_url;
            }


            // var_dump($ad_id.",".$ad_title.",".$ad_desc.",".$photo_url);
            // die();

            $this -> load -> model('ad_model');
            $this -> ad_model -> updata_ad($ad_id,$ad_title,$ad_desc,$photo_url);
            echo "<script>alert('提交成功!')</script>";
            // redirect('admin/admin_ad_mgr');
            $this -> admin_ad_mgr();

    }

    

    //案例管理
    public function admin_case_mgr(){
        $this -> load -> model('case_model');
        $result = $this -> case_model -> get_all();
        if($result){
            $data = array(
              'cases' => $result
            );
            
            $this -> load -> view('admin/admin-case-mgr',$data);
        }
    }


    //案例管理
    public function admin_add_case(){

            
        $this -> load -> view('admin/admin-add-case');
        
    }


    //新增案例
    public function save_case(){
         //接收数据
        $case_user = $this -> input -> post('case_user');
        $case_desc = $this -> input -> post('case_desc');
        $case_add = $this -> input -> post('case_add');



        //图片上传配置 !! 2016-01-23  by liuwei
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '3072';
        $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

        //图片上传操作
        $this -> load -> library('upload', $config);
        $this -> upload -> do_upload('case_img');
        $upload_data = $this -> upload -> data();


        if ( $upload_data['file_size'] > 0 ) {
            //数据库中存photo的路径
            $photo_url = 'uploads/'.$upload_data['file_name'];
        }else{
            //如果不上传图片,则使用默认图片
            $photo_url = 'img/avatar.png';
        }


        $this ->load -> model('case_model');
        $row = $this -> case_model -> save_ad($case_user,$case_desc,$case_add,$photo_url);

        if($row > 0){
            redirect('admin/admin_case_mgr');
        }
        
    }


    public function get_case(){

        $case_id = $this -> uri -> segment(3);

        $this -> load -> model('case_model');

        $result = $this -> case_model -> get_case_by_id($case_id);

        $data = array(
            'case' => $result
            );
        

        $this -> load -> view('admin/admin-get-case',$data);

        
    }

    public function update_case(){


            $case_id = $this -> input -> post('case_id');
            $case_user = $this -> input -> post('case_user');
            $case_desc = $this -> input -> post('case_desc');
            $case_add = $this -> input -> post('case_add');

            //获取当前图像的url $photo_old_url
            //如果不更改上传的图片,则使用当前图片
            //2016-01-24
            $photo_old_url = $this -> input -> post('photo_old_url');



            //图片上传配置 !! 2016-01-24 09:45  by liuwei
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '3072';
            $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

            //图片上传操作
            $this -> load -> library('upload', $config);
            $this -> upload -> do_upload('case_img1');
            $upload_data = $this -> upload -> data();




            if ( $upload_data['file_size'] > 0 ) {
                //数据库中存photo的路径
                $photo_url = 'uploads/'.$upload_data['file_name'];
            }else{
                //如果不更改上传的图片,则使用当前图片
                //!! 如何获取当前图片的地址!! 2016-01-24
                $photo_url = $photo_old_url;
            }


            // var_dump($ad_id.",".$ad_title.",".$ad_desc.",".$photo_url);
            // die();

            $this -> load -> model('case_model');
            $this -> case_model -> update_case($case_id,$case_user,$case_desc,$photo_url,$case_add);
            echo "<script>alert('提交成功!')</script>";
            // redirect('admin/admin_case_mgr');
            $this -> admin_case_mgr();

    }


    

    

    //删除广告
    public function delete_case(){

        $case_id = $this -> uri -> segment(3);

        $this -> load -> model('case_model');

        $row = $this -> case_model -> delete_by_id($case_id);

        if($row>0){
            redirect('admin/admin_case_mgr');
        }
    }



    

    



    //回复消息
    public function reply(){
        
         $this -> load -> model('order_model');
        $result = $this -> order_model -> get_all();
        
        if($result){
            $data = array(
                'orders' => $result
            );
        }
        
        $this -> load -> view('admin/reply',$data);
    }




    //获取服务分类
    public function write_service(){
        $this -> load -> model('service_model');
        $result = $this -> service_model -> get_all();
        $data = array(
            'services' => $result
            );
        
        $this -> load -> view('admin/service-name',$data);  
    }

    

    public function write_item(){
        $service_id = $this -> uri -> segment(3);

        

        //将$service_id存入session中，方便后续页面访问该值
        $array = array(
            'service_id' => $service_id
            );
        $this -> session -> set_userdata($array);
        
        // $service_id = $this -> input -> get('service_id');
        
        $this -> load -> model('service_model');

        $items = $this -> service_model -> get_items_by_id($service_id);

        //获取第一个服务项目的ID
        $items_id = $items[0]->service_id;
        // echo "<pre>";
        // var_dump($items[0]->service_id);
        // echo "</pre>";
        // die();

        $contents = $this -> service_model -> get_contents_by_id($items_id);

    
        $data = array(
            'items' => $items,
            'contents' => $contents,
            'item1_id'=> $items_id
            );
        
        $this -> load -> view('admin/service-item',$data); 
    }


     

    public function get_contents(){
        
        $items_id = $this -> input -> get('items_id');

         $array = array(
            'items_id' => $items_id
            );
        $this -> session -> set_userdata($array);
        
        $service_id = $this -> input -> get('service_id');
        $this -> load -> model('service_model');
        $items = $this -> service_model -> get_items_by_id($service_id);
        $contents = $this -> service_model -> get_contents_by_id($items_id);
        $data = array(
            'items' => $items,
            'contents' => $contents
            );
        
        $this -> load -> view('admin/service-item',$data); 

    }

   

    //更新服务项目
    public function date_item(){
        //先根据id查出数据
        $service_id = $this -> input -> get('service_id');
        $this -> load -> model('service_model');
        $row = $this -> service_model -> get_content_by_id($service_id);
        $data = array(
            'content' => $row
            );

        $this->load->view('admin/item-date',$data);
    }

    //更新服务项目
    public function update_service(){

        $service_id = $this -> input -> post('service_id');
        $product_type = $this -> input -> post('product_type');
        $product_texture = $this -> input -> post('product_texture');
        $product_price = $this -> input -> post('product_price');

        $this -> load -> model('service_model');
        $row = $this -> service_model -> update_service($service_id,$product_type,$product_texture,$product_price);
        if($row>0){
            redirect('admin/write_item');
        }else{
            echo "<script>alert('更新失败！')</script>";

        }
       

       
    }




    
    public function date_product(){
        $this->load->view('admin/product-date');
    }
    public function write_case(){
        $this->load->view('admin/case');
    }



    
    //增加服务
    public function save_service(){

        $this -> load -> model('service_model');
        $result = $this -> service_model -> get_all();

        $data = array(
            'services' => $result
            );
        $this->load->view('admin/service-save',$data);
    }
    //增加服务场所
    public function save_service_mgr(){
        $service_category = $this ->input ->post('service_category');
        $service_en_category = $this ->input ->post('service_en_category');

        //图片上传配置 !! 2016-01-23  by liuwei
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '3072';
        $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

        //图片上传操作
        $this -> load -> library('upload', $config);
        $this -> upload -> do_upload('photo');
        $upload_data = $this -> upload -> data();


        if ( $upload_data['file_size'] > 0 ) {
            //数据库中存photo的路径
            $photo_url = 'uploads/'.$upload_data['file_name'];
        }else{
            //如果不上传图片,则使用默认图片
            $photo_url = 'img/avatar.png';
        }


        $this ->load -> model('service_model');
        $row = $this ->service_model ->save_service_category($service_category,$service_en_category,$photo_url);

        if($row>0){
            redirect('admin/write_service');
            // $this -> write_service();
        }

    }
    //增加服务项目
    public function save_service_item(){
        $service_id = $this ->input ->post('service_id');
        $service_item = $this ->input ->post('service_item');
        $item_desc = $this ->input ->post('item_desc');


        //图片上传配置 !! 2016-01-23  by liuwei
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '3072';
        $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

        //图片上传操作
        $this -> load -> library('upload', $config);
        $this -> upload -> do_upload('photo');
        $upload_data = $this -> upload -> data();


        if ( $upload_data['file_size'] > 0 ) {
            //数据库中存photo的路径
            $photo_url = 'uploads/'.$upload_data['file_name'];
        }else{
            //如果不上传图片,则使用默认图片
            $photo_url = 'img/avatar.png';
        }
        $this -> load-> model('service_model');
        $this ->service_model ->save_item($service_id,$service_item,$item_desc,$photo_url);
    }

	//新增服务材质
    public function save_service_texture(){
        $service_texture = $this ->input ->post('service_texture');
        $texture_price = $this ->input ->post('texture_price');
        $item_id = $this ->input ->post('item_id');
        $this -> load ->model('service_model');
        $this ->service_model ->save_service_texture($service_texture,$texture_price,$item_id);
        // redirect ('admin/write_item');
       /*  $this -> write_item();*/
    }

    //编辑服务
    public function update_service_mgr(){
		$service_id = $this ->input ->get('service_id');
        $this ->load ->model('service_model');
        $row = $this ->service_model ->get_content_by_id($service_id);
		$items = $this ->service_model -> get_items_by_id($service_id);
		$data =array(
			'service_category' => $row,
            'service_id' => $service_id,
			'service_items'=>$items
		) ;
		
        $this -> load ->view('admin/service-update',$data);
    }
      //编辑服务场所
    public function update_service_category(){
        $service_category = $this ->input ->post('service_category');
        $service_en_category = $this ->input ->post('service_en_category');
		$service_id = $this ->input ->post('service_id');
       

            //获取当前图像的url $photo_old_url
            //如果不更改上传的图片,则使用当前图片
            //2016-01-24
             $service_old_url = $this ->input ->post('photo_old_url');



            //图片上传配置 !! 2016-01-24 09:45  by liuwei
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '3072';
            $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

            //图片上传操作
            $this -> load -> library('upload', $config);
            $this -> upload -> do_upload('pro_img');
            $upload_data = $this -> upload -> data();




            if ( $upload_data['file_size'] > 0 ) {
                //数据库中存photo的路径
                $photo_url = 'uploads/'.$upload_data['file_name'];
            }else{
                //如果不更改上传的图片,则使用当前图片
                //!! 如何获取当前图片的地址!! 2016-01-24
                $photo_url = $service_old_url;
            }


         $this ->load -> model('service_model');
         $this ->service_model ->update_service_category($service_id,$service_category,$service_en_category,$photo_url);
    }
    //编辑服务项目
    public function update_service_item(){
        $service_item = $this ->input ->post('service_item');
        $item_desc = $this ->input ->post ('item_desc');
    }


    
    //增加产品
    public function save_product(){

        $this -> load -> model('product_model');
        $result = $this -> product_model -> get_pro_cate();

        $data = array(
            'cates' => $result
            );
        $this->load->view('admin/product-save',$data);
    }


    //增加产品类别
    public function save_procate_mgr(){
        

        $procate_name = $this -> input -> post('procate_name');


        $this -> load -> model('product_model');
        $row = $this -> product_model -> save_pro_cate($procate_name);

        if($row>0){
            redirect('admin/index');
        }

    }


    //增加产品品牌
    public function save_procate_brand(){
        

        $brand_name = $this -> input -> post('brand_name');
        $procate_id = $this -> input -> post('pro_cate_id');



        $this -> load -> model('product_model');
        $row = $this -> product_model -> save_brand_by_pro_id($brand_name,$procate_id);

        if($row>0){
            redirect('admin/index');
        }

    }

    //产品类别编辑
    public function write_product(){
        $this -> load -> model('product_model');
        $result = $this -> product_model -> get_pro_cate();
        $data = array(
            'cates' => $result
            );
        
        $this->load->view('admin/product-name',$data);
    }

    //产品类别编辑
    public function edit_cate(){

        $cate_id = $this -> uri -> segment(3);
        $this -> load -> model('product_model');

        $brands = $this -> product_model -> get_brands($cate_id);
        $productId = array();

        foreach( $brands as $value){
            array_push($productId, $value -> brand_id);
        }

        $limit = count($productId)*2;
        
        $productId = join(',', $productId);

        $result = $this -> product_model -> get_product_by_brands($productId,$limit);

        $data = array(
            'products' => $result
            );

        $this -> load -> view('admin/admin_pro_mgr',$data);

    }


    //产品管理
    public function admin_add_pro(){
        $pro_cate_id = $this -> uri -> segment(3);

        $this -> load -> model('product_model');

        $result = $this -> product_model -> get_brands($pro_cate_id);

        $data = array(
            'brands' => $result
            );


        

            
        $this -> load -> view('admin/admin-add-pro',$data);
        
    }


    //新增案例
    public function save_pro(){
         //接收数据
        $product_brand_id = $this -> input -> post('pro_brand');
        $product_name = $this -> input -> post('pro_name');
        $product_price = $this -> input -> post('pro_price');
        $product_business = $this -> input -> post('pro_business');
        $product_add = $this -> input -> post('pro_add');
        $product_phone = $this -> input -> post('pro_phone');




        //图片上传配置 !! 2016-01-23  by liuwei
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '3072';
        $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

        //图片上传操作
        $this -> load -> library('upload', $config);
        $this -> upload -> do_upload('pro_img');
        $upload_data = $this -> upload -> data();


        if ( $upload_data['file_size'] > 0 ) {
            //数据库中存photo的路径
            $photo_url = 'uploads/'.$upload_data['file_name'];
        }else{
            //如果不上传图片,则使用默认图片
            $photo_url = 'img/avatar.png';
        }


        $this ->load -> model('product_model');
        $row = $this -> product_model -> save_pro( $product_brand_id,$product_name,$product_price,$product_business,$product_add,$product_phone,$photo_url);

        if($row > 0){
            redirect('admin/admin_pro_mgr');
        }
        
    }


    //编辑产品
    public function get_pro(){

        $pro_id = $this -> uri -> segment(3);

        $this -> load -> model('product_model');

        $result = $this -> product_model -> get_product_by_id($pro_id);

        $data = array(
            'pro' => $result
            );
        

        $this -> load -> view('admin/admin-get-pro',$data);

        
    }

    public function update_pro(){


            $pro_id = $this -> input -> post('pro_id');
            $pro_name = $this -> input -> post('pro_name');
            $pro_price = $this -> input -> post('pro_price');
            $pro_business = $this -> input -> post('pro_business');
            $business_add = $this -> input -> post('business_add');
            $business_phone = $this -> input -> post('business_phone');
            
            

            //获取当前图像的url $photo_old_url
            //如果不更改上传的图片,则使用当前图片
            //2016-01-24
            $photo_old_url = $this -> input -> post('photo_old_url');



            //图片上传配置 !! 2016-01-24 09:45  by liuwei
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '3072';
            $config['file_name'] = date("YmdHis") . '_' . rand(10000, 99999);

            //图片上传操作
            $this -> load -> library('upload', $config);
            $this -> upload -> do_upload('pro_img');
            $upload_data = $this -> upload -> data();




            if ( $upload_data['file_size'] > 0 ) {
                //数据库中存photo的路径
                $photo_url = 'uploads/'.$upload_data['file_name'];
            }else{
                //如果不更改上传的图片,则使用当前图片
                //!! 如何获取当前图片的地址!! 2016-01-24
                $photo_url = $photo_old_url;
            }


            // var_dump($ad_id.",".$ad_title.",".$ad_desc.",".$photo_url);
            // die();

            $this -> load -> model('product_model');
            $this -> product_model -> update_pro($pro_id,$pro_name,$pro_price,$pro_business,$business_add,$business_phone,$photo_url);
            echo "<script>alert('提交成功!')</script>";
            redirect('admin/edit_cate');
            //$this -> edit_cate();

    }



    //删除产品
    public function delete_pro(){

        $pro_id = $this -> uri -> segment(3);

        $this -> load -> model('product_model');

        $row = $this -> product_model -> delete_by_id($pro_id);

        if($row>0){
            echo "<script>alert('删除成功!')</script>";
            redirect('admin/edit_cate');
        }
    }

     //编辑产品
    public function edit_product(){

        $cate_id = $this -> uri -> segment(3);
        $this -> load -> model('product_model');
        
        $cate = $this -> product_model -> get_pro_cate_by_id($cate_id);
        $brands = $this -> product_model -> get_brands($cate_id);

        
        


        $data = array(
            'cate' => $cate,
            'brands' => $brands
            );
        $this->load->view('admin/product-edit',$data);
    }

    public function update_pro_cate(){
        $cate_id = $this -> input -> post('procate_id');
        $cate_name = $this -> input -> post('procate_name');

        $this -> load -> model('product_model');
        $this -> product_model -> update_cate($cate_id,$cate_name);


    }

    public function update_brand(){

        $brand_id = $this -> input -> post('brand_id');
        $brand_name = $this -> input -> post('brand_name');

        $this -> load -> model('product_model');
        $this -> product_model -> update_brand($brand_id,$brand_name);
        
    }

   

    

    







}