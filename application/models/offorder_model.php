<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Offorder_model extends CI_Model
{


	//新增线下订单信息
	public function save_offOrder($user,$type,$address,$tel,$status,$desc)
	{
		$this -> db -> insert('t_offOrder',array(
			'offOrder_name' => $user,
			'offOrder_type' => $type,
			'offOrder_address' => $address,
			'offOrder_tel' => $tel,
			'offOrder_color' => $status,
			'offOrder_remark' => $desc
			));
		return $this -> db -> affected_rows();
	}


	/****获取订单信息 分页****/
	//获取订单总数
	public function get_offOrder_count()
	{
		return $this->db->count_all('t_offOrder');
	}


	//按照时间降序排列线下订单信息
	public function get_offOrder_by_page($limit,$offset)
	{
		$this -> db -> order_by('offOrder_time','desc');
		$query = $this -> db -> get('t_offOrder',$limit,$offset);
		return $query->result();
	}


	//按照订单的手机号搜索线下订单
	public function get_by_search_key($keyword)
	{
		
		$sql = "select * from t_offOrder where offOrder_tel like '%".$this->db->escape_like_str($keyword)."%'";
		$query = $this -> db -> query($sql);
		return $query -> result();

	}

	

	//获取所有线下订单
	public function get_all()
	{
		$this -> db -> select("*");
        $this -> db -> from('t_offOrder');
        $this -> db -> order_by('offOrder_time','desc');
        return $this -> db -> get() -> result();
	}

	//更新线下订单状态
	public function update_offOrder_status($offOrder_id,$offOrder_color)
	{

		$data = array(
            'offOrder_color' => $offOrder_color
        );

        $this->db->where('offOrder_id', $offOrder_id);
        $this->db->update('t_offOrder', $data);

        return $this -> db -> affected_rows();
	}

	//根据线下ID获取订单信息
	public function get_offOrder_by_id($offOrder_id)
	{

		$query = $this->db->get_where('t_offOrder', array(
			'offOrder_id' => $offOrder_id
			));
		return $query -> result();

	}

	//更新线下订单备注信息
    public function update_remark_by_id($offOrder_id,$offOrder_remark)
    {

    	$data = array(
    		'offOrder_remark' => $offOrder_remark
    	);

    	$this -> db -> where('offOrder_id', $offOrder_id);
        $this -> db -> update('t_offOrder', $data);
        
        return $this -> db -> affected_rows();

    }

    //删除线下订单备注信息
    public function delete_offOrder_by_id($offOrder_id)
    {
    	$this -> db -> delete('t_offOrder', array('offOrder_id' => $offOrder_id));
    	return $this -> db -> affected_rows();

    }




}