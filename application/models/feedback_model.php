<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Feedback_model extends CI_Model
{


	// public function save_feedback($content){
	// 	$this -> db -> insert('t_feedback',array('feedback_content' => $content));
	// }
	public function save_feedback($content,$open_id){
		$this -> db -> insert('t_feedback',array('feedback_content' => $content,'weixin_id' => $open_id));
	}




	public function get_all(){
		$this -> db -> select("*");
        $this -> db -> from('t_feedback');
        $this -> db -> order_by('feedback_time','desc');
        return $this -> db -> get() -> result();
	}
	public function get_feedback_count(){
		return $this->db->count_all('t_feedback');
	}

	public function get_feedback_by_page($limit,$offset){
		$this -> db -> order_by('feedback_time','desc');
		return $this->db->get('t_feedback',$limit,$offset)->result();
	}

	public function delete_by_ids($feedbackIds){
		$this -> db -> query('delete from t_feedback where feedback_id in('.$feedbackIds.')');
		if($this -> db -> affected_rows() > 0){
            return TRUE;
        }
            return FALSE;
	}




}