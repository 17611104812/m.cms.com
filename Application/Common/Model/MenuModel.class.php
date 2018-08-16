<?php
namespace Common\Model;
use Think\Model;
use Think\Exception;

/**
* 
*/
class MenuModel extends Model
{
	
	private $_db = '';

	function __construct(){
		$this->_db = M('Menu');
	}

	public function insert($data){
		if (!$data || !is_array($data)) {
			return false;
		}
		return 	$this->_db->add($data);
	}

	public function getMenus($data = '',$page,$pageSize){
		$data['status'] = array('neq',-1);
		$offset = ($page - 1) * $pageSize;
		return $this->_db->where($data)->order('listorder desc,menu_id desc')->limit($offset,$pageSize)->select();
		//var_dump($this->_db->getLastSql());die;
	}

	public function getMenusCount($data = ''){
		$data['status'] = array('neq',-1);
		return $this->_db->where($data)->count();
	}

	public function find($data){
		return $this->_db->where($data)->find();
	}

	public function updateMenuById($id,$data){
		if (!$id || !is_numeric($id)) {
			throw_exception('id错误');
		}
		if (!$data || !is_array($data)) {
			throw_exception('参数错误');
		}

		 return $this->_db->where('menu_id ='. $id)->save($data);
		 //var_dump($this->_db->getLastSql());die;
	}

	public function setMenustatus($id,$status){
		$data['status'] = $status;
		 return $this->_db->where('menu_id='.$id)->save($data);
		 //return $this->_db->getLastSql();
	}

	public function updateListorderById($id,$orderlist){
		$data = array('listorder'=>$orderlist);
		return $this->_db->where('menu_id='.$id)->save($data);
	}

	public function getAdminMenus(){
		$data = array(
			'status'=>array('neq','-1'),
			'type' => '1'
		);
		return $this->_db->where($data)->order('listorder desc, menu_id desc')->select();
	}

	public function getBarMenus(){
		$data = array(
			'status' => array('neq','-1'),
			'type'	 => '0'
		);
		return $this->_db
		->where($data)
		->order('listorder desc, menu_id desc')
		->select();
	}
}