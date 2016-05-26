<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

class Access_token_model extends CI_Model
{


	public function save($AT){
		$this -> db -> insert('t_access_token',array('access_token' => $AT));
	}




}