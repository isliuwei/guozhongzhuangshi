<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Product_model extends CI_Model
{


	
	

	//获取商品分类
	public function get_pro_cate(){
		
		$query = $this->db->get_where('t_product_cate');
        return $query -> result();
        
	}

	public function get_pro_cate_by_id($cate_id){

		$query = $this->db->get_where('t_product_cate', array('pro_cate_id' => $cate_id));

		return $query -> row();

	}



	//获取商品品牌
	public function get_brands($pro_cate_id){
		$query = $this -> db -> query("select * from t_product_brand where t_product_brand.pro_cate_id =".$pro_cate_id);
		return $query -> result();

	}

	//获取所有商品
	public function get_all_products_by_brand_id($pro_cate_id){
		$query = $this -> db -> query("select * from t_product_brand where t_product_brand.pro_cate_id =".$pro_cate_id);
		return $query -> result();

	}


	// public function get_product_by_brands($productId){
	// 	//select * from t_product where brand_id in (1,2,3,4,5)
	// 	//$this->db->where_in();
	// 	//$query = $this -> db -> query('select * from t_product where brand_id = in ('.$productId.')');
	// 	$query = $this -> db -> query('select * from t_product where brand_id = in (1,2,3,4,5)');
	// 	return $query -> result();

	// }
	public function get_product_by_brands($productId){
		//select * from t_product where brand_id in (1,2,3,4,5)
		//$this->db->where_in();
		//$query = $this -> db -> query('select * from t_product where brand_id  in ('.$productId.') limit 0,'.$limit);
		$query = $this -> db -> query('select * from t_product where brand_id  in ('.$productId.')');
		// $query = $this->db->get_where('t_product', array('brand_id' => $x));
		// return $query -> result();
		//$query = $this -> db -> query('select * from t_product where brand_id in (1,2,3,4,5)');
		return $query -> result();
		
	}



	public function save_pro_cate($procate_name){
		
		$data = array(
			'pro_cate_name' => $procate_name
		);

		$this -> db ->insert('t_product_cate',$data);

		return $this -> db -> affected_rows();
	}


	// public function save_pro_cate($procate_name){
		
	// 	$data = array(
	// 		'pro_cate_name' => $procate_name
	// 	);

	// 	$this -> db ->insert('t_product_cate',$data);

	// 	return $this -> db -> affected_rows();
	// }

	public function save_brand_by_pro_id($brand_name,$procate_id){

		$data = array(
			'brand_name' => $brand_name,
			'pro_cate_id' => $procate_id
		);

		$this -> db -> insert('t_product_brand',$data);

		return $this -> db -> affected_rows();

	}

	public function save_pro($product_brand_id,$product_name,$product_price,$product_business,$product_add,$product_phone,$photo_url){

		$this -> db -> insert('t_product',array(
			'brand_id' => $product_brand_id,
			'product_name' => $product_name,
			'product_price' => $product_price,
			'product_business' => $product_business,
			'business_address' => $product_add,
			'business_phone' => $product_phone,
			'product_img' => $photo_url
			));

		return $this -> db -> affected_rows();

	}

	public function get_product_by_id($pro_id){

		$query = $this->db->get_where('t_product', array('product_id' => $pro_id));

		return $query -> row();

	}
	public function update_pro($pro_id,$pro_name,$pro_price,$pro_business,$business_add,$business_phone,$photo_url){
		$data = array(
            'product_id' => $pro_id,
			'product_name' => $pro_name,
			'product_price' => $pro_price,
			'product_business' => $pro_business,
			'business_address' => $business_add,
			'business_phone' => $business_phone,
			'product_img' => $photo_url

        );

        $this->db->where('product_id', $pro_id);
        $this->db->update('t_product', $data);
        return $this -> db -> affected_rows();
	}


	public function delete_by_id($pro_id){

		$this -> db -> delete('t_product', array('product_id' => $pro_id));

		return $this -> db -> affected_rows();

	}
	public function delete_pro_cate_by_id($pro_cate_id){
		$this -> db -> delete('t_product_cate', array('pro_cate_id' => $pro_cate_id));
		return $this -> db -> affected_rows();
	}

	

    public function update_cate($cate_id,$cate_name){

    	$data = array(
            'pro_cate_name' => $cate_name
        );

        $this->db->where('pro_cate_id', $cate_id);
        $this->db->update('t_product_cate', $data);
        return $this -> db -> affected_rows();

    }
	public function update_brand($brand_id,$brand_name){

		$data = array(
            'brand_name' => $brand_name
        );

        $this->db->where('brand_id', $brand_id);
        $this->db->update('t_product_brand', $data);
        return $this -> db -> affected_rows();

	}


	

	public function get_product_by_brand($brand_id){
		$query = $this -> db -> query("select * from t_product where t_product.brand_id =".$brand_id);
		return $query -> result();

	}

	
	

	






}