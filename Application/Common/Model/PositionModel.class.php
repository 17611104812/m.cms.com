<?php
namespace Common\Model;
use Think\Model;

/**
* 
*/
class PositionModel extends Model
{
	private $_db = '';
	function __construct()
	{
		$this->_db = M('Position');
	}

	public function getPositionList(){
		return $this->_db->where('status=1')->order('id desc')->select();
	}
}