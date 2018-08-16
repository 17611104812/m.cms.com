<?php
namespace Common\Model;
use Think\Model;

/**
* 
*/
class Position_contentModel extends Model
{
	private $_db = '';
	function __construct()
	{
		$this->_db = M('Position_content');
	}

	public function insert($data){
		//var_dump($data);die;
		if (!$data || !is_array($data)) {
			return false;
		}
		return $this->_db->add($data);
	}

	public function getPositionContent($condition){
		return $this->_db->where($condition)->select();
	}

	public function getPicNews($condition,$limit){

		return $this->_db->where($condition)->order('id desc')->limit($limit)->select();
	}
}