<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('wechat');
        $this -> load -> model('admin_model');
        $this -> load -> model('feedback_model');
       

    }
    // public function index(){
        
    //     $this -> load -> view('admin/admin-index');
    // }


    //微信消息管理
    public function index(){
        
        $this -> load -> model('message_model');
        $message_count = $this -> message_model -> get_message_count();
        $offset = $this->uri->segment(3)==NULL?0 : $this -> uri ->segment(3);
        //分页
        $this->load->library('pagination');
        //$config['uri_segment'] = 3;
        $config['base_url'] = 'admin/index';
        $config['total_rows'] = $message_count;
        $config['per_page'] = 2; 
        $config['last_link'] = FALSE;
        $config['prev_link'] = '«';//上一页
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';//下一页
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';//每个数字页
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="am-active"><a href="'.$config['base_url'].'">';//当前页
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config); 

        $result = $this -> message_model -> get_message_by_page($config['per_page'],$offset);

        $this -> load -> model('order_model');
        $orderInfo = $this -> order_model -> get_order_group_by_color();
        $order_count = $this -> order_model -> get_order_count();
        $order_total_moeny = $this -> order_model -> get_total_money();
        $this -> load -> model('offorder_model');
        $offOrder_count = $this -> offorder_model -> get_offOrder_count();

        //将$order_count存入session中，传到admin-header中
        $array = array(
            'currentOrderTotal' => $order_count
            );
        $this -> session -> set_userdata($array);


        
        if($result){
            $data = array(
                'messages' => $result,
                'message_count'=>$message_count,
                'orderInfo' => $orderInfo,
                'orderTotal' => $order_count,
                'orderTotalMoney' => $order_total_moeny,
                'offOrderTotal' => $offOrder_count

            );
        }
        
        $this -> load -> view('admin/admin-index',$data);
    }


     public function login(){
        $this -> load -> view('admin/login');
    }

    public function logout(){
        $this -> session -> unset_userdata('admin');
        redirect('admin/login');
    }


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
            //$this -> load -> view('admin/admin-index');
            redirect('admin/index');

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

    //回复微信消息
    public function reply_message(){
        $open_id = $this -> input -> post('openId');
        $content = $this -> input -> post('replyContent');
        // var_dump(json_encode($content));
        // die();
        //$content = json_encode($content);
        $msg_data = array(
            'touser' => $open_id,
            'msgtype' => 'text',
            'text' => array(
                'content' => $content
            )
        );
        
        $this -> wechat -> push_message($msg_data);
        redirect('admin/admin_message_mgr');
        
        
    }




    

    //微信消息管理
    public function admin_message_mgr(){
        
        $this -> load -> model('message_model');

        $message_count = $this -> message_model -> get_message_count();

        $offset = $this->uri->segment(3)==NULL?0 : $this -> uri ->segment(3);

        //分页
        $this->load->library('pagination');
        //$config['uri_segment'] = 3;

        $config['base_url'] = 'admin/admin_message_mgr';
        $config['total_rows'] = $message_count;
        $config['per_page'] = 15; 

        $config['last_link'] = FALSE;
        $config['prev_link'] = '«';//上一页
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';//下一页
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';//每个数字页
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="am-active"><a href="'.$config['base_url'].'">';//当前页
        $config['cur_tag_close'] = '</a></li>';


        $this->pagination->initialize($config); 

        $result = $this -> message_model -> get_message_by_page($config['per_page'],$offset);
        
        if($result){
            $data = array(
                'messages' => $result,
                'message_count'=>$message_count
            );
        }
        $this -> load -> view('admin/admin-message-mgr',$data);
    }


    //删除单个微信消息

    public function delete_message(){

        $message_id = $this -> input -> get('message_id');

        $this -> load -> model('message_model');

        $row = $this -> message_model -> delete_message_by_id($message_id);

        if($row>0){
            //echo "<script>alert('删除成功!')</script>";
            redirect('admin/admin_message_mgr');
        } 

    }


    public function delete_msg(){
        $message_id = $this -> uri -> segment(3);

        $this -> load -> model('message_model');

        $row = $this -> message_model -> delete_message_by_id($message_id);

        if($row>0){
            //echo "<script>alert('删除成功!')</script>";
            redirect('admin/index');
        } 

    }


    //回复微信消息
    public function reply_msg(){
        $open_id = $this -> input -> get('openId');
        $content = $this -> input -> get('replyContent');
        
        $msg_data = array(
            'touser' => $open_id,
            'msgtype' => 'text',
            'text' => array(
                'content' => $content
            )
        );
        
        $this -> wechat -> push_message($msg_data);
        echo "success";
        
        
        
    }


    //用户订单管理
    public function admin_order_mgr(){
        
        $this -> load -> model('order_model');
        
        $order_count = $this -> order_model -> get_order_count();
        $offset = $this->uri->segment(3)==NULL?0 : $this -> uri ->segment(3);

        //分页
        $this->load->library('pagination');
        //$config['uri_segment'] = 3;

        $config['base_url'] = 'admin/admin_order_mgr';
        $config['total_rows'] = $order_count;
        $config['per_page'] = 10; 

        $config['last_link'] = FALSE;
        $config['prev_link'] = '«';//上一页
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';//下一页
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';//每个数字页
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="am-active"><a href="'.$config['base_url'].'">';//当前页
        $config['cur_tag_close'] = '</a></li>';


        $this->pagination->initialize($config); 

        $result = $this -> order_model -> get_order_by_page($config['per_page'],$offset);
        
        if($result){
            $data = array(
                'orders' => $result,
                'order_count'=>$order_count
            );
        }
        
        $this -> load -> view('admin/admin-order-mgr',$data);
    }

    public function update_remark(){
        $order_id = $this -> input -> post('order_id');
        $remark_content = $this -> input -> post('remark_content');

        $this -> load -> model('order_model');
        $row = $this -> order_model -> update_remark($order_id,$remark_content);
        if($row>0){
            redirect('admin/admin_order_mgr');
        }



    }
    public function redirect_order_mgr(){
        redirect('admin/admin_order_mgr');
    }


    
    //用户订单搜索
    public function admin_order_search(){
        $this -> load -> model('order_model');
        $order_search_key = trim($this ->input ->post('order_search_key'));
        // $sql = "select * from t_order"; 
        // $keyword = "where order_tel like "."'%".$order_search_key."%'" ; 
        // $query = $sql." ".$keyword;
        // echo $query;
        // die();

        $key = "'".$order_search_key."'";
        $result = $this -> order_model -> get_by_search_key($order_search_key);
        $result_count = count($result);


        //搜索
        

        







        if($result){
            $data = array(
                'order' => $result,
                'result_count'=> $result_count
            );
            $this -> load -> view('admin/admin-order-search',$data);
        }else{
            
            echo "查询无结果！1s后返回订单管理页面!";
            echo "<script>setTimeout(function(){location.href='admin_order_mgr'},1000)</script>";
        }
        
    
    }

    public function delete_order(){
        $order_id = $this -> uri -> segment(3);

        $this -> load -> model('order_model');

        $row = $this -> order_model -> delete_order_by_id($order_id);

        if($row>0){
            redirect('admin/admin_order_mgr');
        }




    }








    //用户反馈信息管理
    public function admin_feedback_mgr(){
        
        $this -> load -> model('feedback_model');
        $result = $this -> feedback_model -> get_all();
        $feedback_count = $this -> feedback_model -> get_feedback_count();
        $offset = $this->uri->segment(3)==NULL?0 : $this -> uri ->segment(3);

        //分页
        $this->load->library('pagination');
        //$config['uri_segment'] = 3;

        $config['base_url'] = 'admin/admin_feedback_mgr';
        $config['total_rows'] = $feedback_count;
        $config['per_page'] = 10; 

        $config['last_link'] = FALSE;
        $config['prev_link'] = '«';//上一页
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';//下一页
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';//每个数字页
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="am-active"><a href="'.$config['base_url'].'">';//当前页
        $config['cur_tag_close'] = '</a></li>';


        $this->pagination->initialize($config); 

        $result = $this -> feedback_model -> get_feedback_by_page($config['per_page'],$offset);
        
        if($result){
            $data = array(
                'feedbacks' => $result,
                'feedback_count'=>$feedback_count
            );
        }
        
        $this -> load -> view('admin/admin-feedback-mgr',$data);
    }
    //用户反馈信息批量删除
    public function delete_checked_feedback(){
        $feedbackIds = $this ->input ->get('Ids');

        $this -> load -> model('feedback_model'); 

        $result = $this -> feedback_model -> delete_by_ids($feedbackIds);

        if($result){
            echo 'success';
        }else{
            echo 'fail';
        }

    
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
    //支付成功后跳转 查看订单详情 界面
        public function order_list1(){
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
            $this -> load -> view('order-list1',$data);
        }else{
            //验证失败，跳转至提示无订单页面
            $this -> load -> view('order-none');
        }
    } 





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

   
    /**
        @批量删除
        @author: liuwei
        @time: 2016-05-13
    */
    //批量删除
    public function remove_checked_messages(){

        $messageIds = $this -> input -> get('Ids');

        $this -> load -> model('message_model'); 

        $result = $this -> message_model -> delete_by_ids($messageIds);

        if($result){
            echo 'success';
        }else{
            echo 'fail';
        }

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

        // echo "<pre>";
        // var_dump($items);
        // echo "</pre>";
        // die();
        //$items = $items==null?'':$items;
        if($items==null){
            echo "没有可编辑项目！1s后返回！";
            echo "<script>setTimeout(function(){location.href='save_service'},1000)</script>";

        }else{
            //获取第一个服务项目的ID
            $items_id = $items[0]->service_id;
            $contents = $this -> service_model -> get_contents_by_id($items_id);

    
            $data = array(
                'items' => $items,
                'contents' => $contents,
                'item1_id'=> $items_id
                );

        
        
            $this -> load -> view('admin/service-item',$data); 
        }
        
        

        // echo "<pre>";
        // var_dump($items_id);
        // echo "</pre>";
        // die();

        
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
            //$this -> write_service();
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
        $row = $this ->service_model ->save_item($service_id,$service_item,$item_desc,$photo_url);
        if($row>0){
            redirect('admin/write_service');
        }
    }

	//新增服务材质
    public function save_service_texture(){
        $service_texture = $this ->input ->post('service_texture');
        $texture_price = $this ->input ->post('texture_price');
        $item_id = $this ->input ->post('item_id');
        $service_id = $this ->input ->post('service_id');

        $this -> load ->model('service_model');
        $row = $this ->service_model ->save_service_texture($service_texture,$texture_price,$item_id);
        if($row>0){
            redirect ('admin/get_contents?items_id='.$item_id.'&service_id='.$service_id);
        }
        
       /*  $this -> write_item();*/
    }


    //编辑服务
    public function update_service_mgr(){
		$service_id = $this -> uri -> segment(3);
        $this ->load ->model('service_model');
        $row = $this ->service_model ->get_content_by_id($service_id);//获取此service_id的服务场所
		$items = $this ->service_model -> get_items_by_id($service_id);//获取此service_id的服务场所下的所有服务项目
        if($items){
            $item1_id = $items[0]->service_id;//获取第一个服务项目的ID
            $item1 = $this ->service_model ->get_content_by_id($item1_id);
            $data =array(
                'service_category' => $row,
                'service_id' => $service_id,
                'service_items'=>$items,
                'item1' =>$item1
            );
        }
        else{
            $data =array(
                'service_category' => $row,
                'service_id' => $service_id,
                'service_items'=>null,
                'item1' => null
            );
        }
        // echo "<pre>";
        // var_dump($data['item1']);
        // echo "</pre>";
        // die();


		
        $this -> load ->view('admin/service-update',$data);
    }


    public function update_service_mgr2(){
        $service_id = $this -> input -> get('service_id');
        $item_id = $this -> input -> get('item_id');
        $this ->load ->model('service_model');
        $row = $this ->service_model -> get_content_by_id($service_id);//获取此service_id的服务场所
        $service_items = $this ->service_model -> get_items_by_id($service_id);///获取此service_id的服务场所下的所有服务项目
        $item = $this ->service_model -> get_content_by_id($item_id);//获取选中的item
		
        $data =array(
            'service_category' => $row,
            'service_id' => $service_id,
            'service_items'=>$service_items,
            'item'=>$item
        ) ;

        
        $this -> load ->view('admin/service-update2',$data);
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
            $this -> upload -> do_upload('photo');
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
        $item_id = $this ->input ->post('service_id');
        $this ->load ->model('service_model');
        $service_name = $this ->input ->post('service_name');
        $item_desc = $this ->input ->post ('item_desc');

        //获取当前图像的url $photo_old_url
            //如果不更改上传的图片,则使用当前图片
            //2016-01-24
             $item_old_url = $this ->input ->post('photo_old_url');



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
                $photo_url = $item_old_url;
            }
    
         $this ->load -> model('service_model');
         $this ->service_model ->update_service_item($item_id,$service_name,$item_desc,$photo_url);
        
    }

    //删除服务场所
    public function delete_service_category(){
        $service_id = $this -> uri -> segment(3);
        $this ->load ->model('service_model');
        $row = $this -> service_model -> delete_service_category($service_id);
        if($row>0){
            redirect('admin/write_service');
        }

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
            redirect('admin/write_product');
        }

    }


    //增加产品品牌
    public function save_procate_brand(){
        

        $brand_name = $this -> input -> post('brand_name');
        $procate_id = $this -> input -> post('pro_cate_id');



        $this -> load -> model('product_model');
        $row = $this -> product_model -> save_brand_by_pro_id($brand_name,$procate_id);

        if($row>0){
            redirect('admin/write_product');
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
    public function delete_pro_cate(){
        $pro_cate_id = $this -> input -> get('pro_cate_id');
        
        $this -> load -> view('product_model');

        $row = $this -> product_model -> delete_pro_cate_by_id($pro_cate_id);
        if($row>0){
            echo "success";
        }else{
            echo "fail";
        }
    }


    //新增案例
    public function save_pro(){

        
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

    public function update_order_status(){
        $order_id = $this -> input -> get('order_id');
        $order_color = $this -> input -> get('order_color');

        $this -> load -> model('order_model');

        $row = $this -> order_model -> update_order_status($order_id,$order_color);

        if($row>0){
            $this -> load -> model('order_model');
            $result = $this -> order_model -> get_all();
            $data = array(
                'orders' => $result
            );
            $this -> load -> view('admin/admin-order-mgr',$data);
        }



    }


    public function update_order_status1(){
        $order_id = $this -> input -> get('order_id');
        $order_color = $this -> input -> get('order_color');

        $this -> load -> model('order_model');

        $row = $this -> order_model -> update_order_status($order_id,$order_color);

        if($row>0){
            $this -> load -> model('order_model');
            $result = $this -> order_model -> get_order_by_id($order_id);
            $json = array(
                'data' => $result  
            );
            echo json_encode($json);
        }


    }


    //更新订单备注
    public function update_order_remark(){
        $order_id = $this->input->get('order_id');
        $order_remark = $this->input->get('order_remark');
        $this->load->model('order_model');
        $row = $this -> order_model -> update_remark_by_id($order_id,$order_remark);
        if($row>0){
            echo "success";
        }
        else{
            echo "fail";
        }

    }

    /**
        线下订单管理
        
    **/

    //
    public function admin_offline_order_mgr(){

        $this -> load -> model('offorder_model');
        
        $offOrder_count = $this -> offorder_model -> get_offOrder_count();

        $offset = $this -> uri -> segment(3)==NULL?0 : $this -> uri -> segment(3);

        //分页
        $this->load->library('pagination');
        //$config['uri_segment'] = 3;

        $config['base_url'] = 'admin/admin_offline_order_mgr';
        $config['total_rows'] = $offOrder_count;
        $config['per_page'] = 10; 

        $config['last_link'] = FALSE;
        $config['prev_link'] = '«';//上一页
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';//下一页
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';//每个数字页
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="am-active"><a href="'.$config['base_url'].'">';//当前页
        $config['cur_tag_close'] = '</a></li>';


        $this->pagination->initialize($config); 

        $result = $this -> offorder_model -> get_offOrder_by_page($config['per_page'],$offset);
        
        if($result){
            $data = array(
                'offOrders' => $result,
                'offOrder_count'=>$offOrder_count
            );
        }
        
        
        $this -> load -> view('admin/admin-offline-order-mgr',$data);
    }

    public function admin_add_order(){
         $this -> load -> view('admin/admin-add-order');
    }

    public function save_order(){

        $offOrder_user = $this -> input -> post('offOrder_user');
        $offOrder_type = $this -> input -> post('offOrder_type');
        $offOrder_address = $this -> input -> post('offOrder_address');
        $offOrder_tel = $this -> input -> post('offOrder_tel');
        $offOrder_status = $this -> input -> post('offOrder_status');
        $offOrder_desc = $this -> input -> post('offOrder_desc');

        
        $this -> load -> model('offorder_model');

        $row = $this -> offorder_model -> save_offOrder($offOrder_user,$offOrder_type,$offOrder_address,$offOrder_tel,$offOrder_status,$offOrder_desc);

        if($row>0){
            redirect('admin/admin_offline_order_mgr');
        }


        
    }


    public function admin_offOrder_search(){

        $keyword = trim($this -> input -> get('keyword'));

        $this -> load -> model('offorder_model');

        $result = $this -> offorder_model -> get_by_search_key($keyword);
        $count = count($result);
        $json = array(
                'data' => $result,
                'count' =>  $count
            );

        echo json_encode($json);

    }


    public function update_offOrder_status(){

        $offOrder_id = $this -> input -> get('offOrder_id');
        $offOrder_color = $this -> input -> get('offOrder_color');

        $this -> load -> model('offorder_model');

        $row = $this -> offorder_model -> update_offOrder_status($offOrder_id,$offOrder_color);

        if($row>0){
            $this -> load -> model('offorder_model');
            $result = $this -> offorder_model -> get_offOrder_by_id($offOrder_id);
            $json = array(
                'data' => $result  
            );
            echo json_encode($json);
        }

    }

    //更新线下订单备注
    public function update_offOrder_remark(){

        $offOrder_id = $this -> input -> get('offOrder_id');
        $offOrder_remark = $this -> input -> get('offOrder_remark');

        $this->load->model('offorder_model');
        $row = $this -> offorder_model -> update_remark_by_id($offOrder_id,$offOrder_remark);
        if($row>0){
            echo "success";
        }
        else{
            echo "fail";
        }

    }

    //删除线下订单
    public function admin_delete_offOrder(){
        $offOrder_id = $this -> input -> get('offOrder_id');

        $this -> load -> model('offorder_model');

        $row = $this -> offorder_model -> delete_offOrder_by_id($offOrder_id);
        

        if($row>0){
            echo "success";
        }else{
            echo "fail";
        }


    }

    public function redirect_offOrder(){
        redirect('admin/admin_offline_order_mgr');
    }



    public function get_order_group_by_color(){



        $this -> load -> model('order_model');

        $result = $this -> order_model -> get_order_group_by_color();

        $data = array(
            'orderInfo' => $result
            );
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();

    }


    //ajax长轮询
    // public function admin_header(){

    //     //连接数据库，查询当前订单总数
    //     $this -> load -> model('order_model');
    //     $result = $this -> order_model -> get_order_count();

    //     $data = array(
    //         'currentOrderTotal' => $result
    //         ); 
    //     echo "<pre>";
    //     var_dump($data);
    //     echo "</pre>";
    //     die();

        

    //     //将订单数量保存在admin-header页面中
    //     $this -> load -> view('admin/admin-header',$data);

    // }

    public function find_new_order(){

        $currentOrderTotal = $this -> input -> get('currentOrderTotal');

        $this -> load -> model('order_model');

        $nowOrderTotal = $this -> order_model -> get_order_count();

        if($nowOrderTotal>$currentOrderTotal){
            echo "success";
            //$this -> reply_order_message();
        }else{
            echo "fail";
        }
    
    }
//回复微信消息
    public function reply_order_message(){
        //$open_id = 'oewxTwnzSf4TXTZBRTzxiLIJiynw';
        $open_id =  'oWWVWw8MYx_4kB3HYX5U3HlaJeew';
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