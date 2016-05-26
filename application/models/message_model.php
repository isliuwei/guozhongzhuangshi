<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Message_model extends CI_Model
{


	public function save($content, $open_id){
	
		$this -> db -> insert('t_message',array('message_content' => $content, 'weixin_id'=>$open_id));
	}


	public function get_all(){
		
		
		$this -> db -> select("*");
        $this -> db -> from('t_message message');
        $this -> db -> order_by('message_time','asc');
        return $this -> db -> get() -> result();
	}

	public function get_message_count(){
		return $this->db->count_all('t_message');
	}
	public function get_message_by_page($limit,$offset){
		$this -> db -> order_by('message_time','desc');
		return $this->db->get('t_message',$limit,$offset)->result();
	}


	public function delete_message_by_id($message_id){
		$this -> db -> delete('t_message',array('message_id' => $message_id));
		return $this -> db -> affected_rows();
	}


	/**
	    @批量删除
	    @author: liuwei
	    @time: 2016-05-13
    */


    /*****批量删除*****/
    public function delete_by_ids($messageIds){//$messageIds = 1,2,3,4,5
        //查找多条 where_in 数组
        //$this -> db -> where_in('message_id',$messageIds);
        //$this -> db -> delete('t_message');
        $this -> db -> query('delete from t_message where message_id in('.$messageIds.')');
        if($this -> db -> affected_rows() > 0){
            return TRUE;
        }
            return FALSE;
    }
    /*****批量删除*****/




}