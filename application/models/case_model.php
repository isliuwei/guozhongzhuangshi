<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Case_model extends CI_Model
{


	// public function save_order($open_id,$name,$address,$tel,$type){
	// 	$this -> db -> insert('t_order',array(
	// 		'open_id' => $open_id,
	// 		'order_name' => $name,
	// 		'order_address' => $address,
	// 		'order_tel' => $tel,
	// 		'order_type' => $type
	// 		));
	// }

	public function get_all(){
		$this -> db -> select("*");
        $this -> db -> from('t_case');
        $this -> db -> order_by('case_time','asc');
        return $this -> db -> get() -> result();
	}



	public function save_ad($case_user,$case_desc,$case_add,$photo_url){

		$this -> db -> insert('t_case',array(
			'case_user' => $case_user,
			'case_desc' => $case_desc,
			'case_img1' => $photo_url,
			'case_add' => $case_add
			));

		return $this -> db-> affected_rows();

	}


	public function delete_by_id($case_id){

		$this->db->delete('t_case', array('case_id' => $case_id));

		return $this -> db-> affected_rows();

	}

	public function get_case_by_id($case_id){
		$query = $this->db->get_where('t_case', array('case_id' => $case_id));

		return $query -> row();

		
        
	}


	public function update_case($case_id,$case_user,$case_desc,$photo_url,$case_add){
        $data = array(
            'case_user' => $case_user,
            'case_desc' => $case_desc,
            'case_img1' => $photo_url,
            'case_add' => $case_add

        );

        $this->db->where('case_id', $case_id);
        $this->db->update('t_case', $data);

    }


	



}