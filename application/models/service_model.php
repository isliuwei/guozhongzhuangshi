<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Service_model extends CI_Model
{


	
	//获取服务种类
	public function get_all(){
		$query = $this -> db -> query('select * from t_service where superclass_id = 0');
        return $query -> result();
	}

	//获取第一类服务的服务项目
	public function get_items_by_id($service_id){
		//$query = $this -> db -> query('select * from t_service where superclass_id ='.$service_id);
		$query = $this->db->get_where('t_service', array('superclass_id' => $service_id));
        return $query -> result();
	}

	public function get_contents_by_id($items_id){
		//$query = $this -> db -> query('select * from t_service where superclass_id ='.$items_id);
		$query = $this->db->get_where('t_service', array('superclass_id' => $items_id));
        return $query -> result();
	}

	public function get_content_by_id($service_id){
		//$query = $this -> db -> query('select * from t_service where service_id ='.$service_id);
		$query = $this->db->get_where('t_service', array('service_id' => $service_id));
        return $query -> result();
	}

	public function update_service($service_id,$product_type,$product_texture,$product_price){

		$data = array(
               'product_type' => $product_type,
               'product_texture' => $product_texture,
               'product_price' => $product_price
            );

		$this->db->where('service_id', $service_id);
		$this->db->update('t_service', $data); 
		return $this->db->affected_rows();
	}


	// public function get_product_by_brands($productId){
	// 	//select * from t_product where brand_id in (1,2,3,4,5)
	// 	//$this->db->where_in();
	// 	//$query = $this -> db -> query('select * from t_product where brand_id = in ('.$productId.')');
	// 	$query = $this -> db -> query('select * from t_product where brand_id = in (1,2,3,4,5)');
	// 	return $query -> result();

	// }
	public function get_product_by_brands($x){
		//select * from t_product where brand_id in (1,2,3,4,5)
		//$this->db->where_in();
		//$query = $this -> db -> query('select * from t_product where brand_id = in ('.$productId.')');
		$query = $this->db->get_where('t_product', array('brand_id' => $x));
		return $query -> result();
		// $query = $this -> db -> query('select * from t_product where brand_id in (1,2,3,4,5)');
		// return $query -> result();
		
	}
	//新增服务
	//新增服务场所
	public function save_service_category($service_category,$service_en_category,$photo_url){
		
		$data = array(
			'service_name' => $service_category,
			'service_en_name'=>$service_en_category,
			'service_img'=>$photo_url,
			'superclass_id' => '0'
		);
		$this ->db ->insert('t_service',$data);
		return $this->db->affected_rows();
	}
	//新增服务项目
	public function save_item($service_id,$service_item,$item_desc,$photo_url){
		$data = array(
			'service_name'=>$service_item,
			'service_desc'=>$item_desc,
			'superclass_id'=>$service_id,
			'service_img'=>$photo_url,
		);
		$this ->db ->insert('t_service',$data);
		return $this->db->affected_rows();
	}
	//新增服务材质
	public function save_service_texture( $service_texture,$texture_price, $item_id){
		$data = array(
			'product_texture'=>$service_texture,
			'product_price'=>$texture_price,
			'superclass_id'=>$item_id
		);
		$this ->db ->insert('t_service',$data);
		return $this->db->affected_rows();
	}
	//编辑服务场所
	public function update_service_category($service_id,$service_category,$service_en_category,$photo_url){
		
		$data = array(
			'service_name' => $service_category,
			'service_en_name'=>$service_en_category,
			'service_img'=>$photo_url
		);
		$this->db->where('service_id', $service_id);
		$this->db->update('t_service', $data); 
	}
	//编辑服务项目
	public function update_service_item($item_id,$service_name,$item_desc,$photo_url){
		
		$data = array(
			'service_name' => $service_name,
			'service_desc'=>$item_desc,
			'service_img'=>$photo_url
		);
		$this->db->where('service_id', $item_id);
		$this->db->update('t_service', $data); 
		return $this->db->affected_rows();
	}
	//删除服务场所
	public function delete_service_category($service_id){
		$this->db->where('service_id',$service_id);
		$this->db->delete('t_service');
		return $this->db->affected_rows();
	}


































}