<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Order_model extends CI_Model
{


	public function save_order($open_id,$name,$address,$color,$tel,$type,$timestamp,$order_no){
		$this -> db -> insert('t_order',array(
			'open_id' => $open_id,
			'order_name' => $name,
			'order_address' => $address,
			'order_color' => $color,
			'order_tel' => $tel,
			'order_type' => $type,
			'order_timestamp' => $timestamp,
			'order_no' => $order_no
			));
		return $this -> db -> affected_rows();
	}



	public function get_all(){
		$this -> db -> select("*");
        $this -> db -> from('t_order');
        $this -> db -> order_by('order_time','desc');
        return $this -> db -> get() -> result();
	}

	//获取支付订单的总金额
	public function get_total_money(){
		$query = $this -> db -> query('SELECT sum(order_money) as total FROM t_order');
		return $query -> result();
	}


	public function get_by_tel_id($open_id,$order_tel){
		// select * from t_order where order_tel =15755555555 and open_id = "oewxTwnzSf4TXTZBRTzxiLIJiynw"
		// 'select * from t_order where order_tel ='.$order_tel.' and open_id = '"oewxTwnzSf4TXTZBRTzxiLIJiynw"
		
		//$query = $this -> db -> query('select * from t_order where order_tel =15755555555');
		$this -> db -> order_by('order_time','desc');
		$query = $this->db->get_where('t_order', array(
			'open_id' => $open_id,
			'order_tel' => $order_tel
			));
		
		return $query -> result();

		
	}

	public function update_order_status($order_id,$order_color){


        $data = array(
            'order_color' => $order_color
        );

        $this->db->where('order_id', $order_id);
        $this->db->update('t_order', $data);

        return $this -> db -> affected_rows();

    

	}

	public function update_remark($order_id,$remark_content){

		$data = array(
            'order_remark' => $remark_content
        );

        $this->db->where('order_id', $order_id);
        $this->db->update('t_order', $data);

        return $this -> db -> affected_rows();

	}

	//订单搜索
	public function get_by_search_key($order_search_key){
		//$query = $this -> db -> query('select * from t_order where order_tel like '%15765505994%'');
		// $sql = $this->db->like('order_tel',$order_search_key);
		// echo "<pre>";
		// var_dump($sql);
		// echo "</pre>"; 
		// die();

// $search = "{$order_search_key}";
		$sql = "select * from t_order where order_tel like '%".$this->db->escape_like_str($order_search_key)."%'";
		$query = $this -> db -> query($sql);

		return $query -> result();
	}

	public function get_order_count(){
		return $this->db->count_all('t_order');
	}
	public function get_order_by_page($limit,$offset){
		$this -> db -> order_by('order_time','desc');
		return $this->db->get('t_order',$limit,$offset)->result();
	}
	// public function get_search_by_page($limit,$offset){

	// }


	public function get_order_by_id($order_id){
		$query = $this->db->get_where('t_order', array(
			'order_id' => $order_id
			));
		return $query -> result();
	}
    //更新订单备注
    public function update_remark_by_id($order_id,$order_remark){
    	$data = array(
    		'order_remark'=>$order_remark
    	);
    	$this->db->where('order_id', $order_id);
        $this->db->update('t_order', $data);
        
        return $this -> db -> affected_rows();

    }




    //删除线下订单备注信息
    public function delete_order_by_id($order_id)
    {
    	$this -> db -> delete('t_order', array('order_id' => $order_id));
    	return $this -> db -> affected_rows();

    }


    //删除线下订单备注信息
    public function get_order_group_by_color()
    {
    	//$query = $this -> db -> query('SELECT t_order.order_color,COUNT(*)  FROM   t_order GROUP BY order_color');
    	$query = $this -> db -> query('SELECT t_order.order_color,COUNT(*) as num  FROM   t_order GROUP BY order_color');
    	
    	return $query -> result(); 


    }






















}