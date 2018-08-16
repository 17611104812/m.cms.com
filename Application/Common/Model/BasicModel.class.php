<?php
namespace Common\Model;
use Think\Model;

/**
* 
*/
class BasicModel{


	public function save($data){
		if (!$data) {
			return false;
		}
		$id = F('basic_web_config',$data);
		return $id;
	}

	public function select(){
		return F('basic_web_config');
	}
}