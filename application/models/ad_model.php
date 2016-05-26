<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Ad_model extends CI_Model
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
        $this -> db -> from('t_advertisement');
        $this -> db -> order_by('ad_time','asc');
        return $this -> db -> get() -> result();
	}



	public function save_ad($ad_title,$ad_desc,$photo_url){

		$this -> db -> insert('t_advertisement',array(
			'ad_title' => $ad_title,
			'ad_desc' => $ad_desc,
			'ad_img' => $photo_url
			));

		return $this -> db-> affected_rows();

	}


	public function delete_by_id($ad_id){

		$this->db->delete('t_advertisement', array('ad_id' => $ad_id));

		return $this -> db-> affected_rows();

	}

	public function get_ad_by_id($ad_id){
		$query = $this->db->get_where('t_advertisement', array('ad_id' => $ad_id));

		return $query -> row();

		
        
	}


	public function updata_ad($ad_id,$ad_title,$ad_desc,$photo_url){
        $data = array(
            'ad_title' => $ad_title,
            'ad_desc' => $ad_desc,
            'ad_img' => $photo_url
        );

        $this->db->where('ad_id', $ad_id);
        $this->db->update('t_advertisement', $data);

    }


	



}