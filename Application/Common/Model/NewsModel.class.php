<?php
namespace Common\Model;
use Think\Model;
//use Think\Exception;

/**
* 
*/
class NewsModel extends Model
{
	
	private $_db = '';
	function __construct()
	{
		$this->_db = M('news');
	}

	public function insert($data = array()){
		if (!isset($data) || !is_array($data)) {
			return false;
		}

		$data['create_time'] = time();
		$data['username'] = getUserName();
		return $this->_db->add($data);
	}

	public function save($data = array()){
		//var_dump($data);die;
		if (!isset($data) || !is_array($data)) {
			return false;
		}
		$news_id = $data['news_id'];
		$data['update_time'] = time();
		$data['username'] = getUserName();
		return $this->_db->where('news_id='.$news_id)->save($data);
		//return $this->_db->getLastSql();
	}



	public function getNewsData($data,$page = 1,$pageSize = 5){
		//$condition = $data;

		if(isset($data['title']) && $data['title']){
			$condition['title'] = array('like','%'.$data['title'].'%');
		}

		if (isset($data['catid']) && $data['catid']) {
			$condition['catid'] = $data['catid'];
		}
		$condition['status'] = array('neq','-1');
		$offset = ($page - 1) * $pageSize;
		return $this->_db
		->where($condition)
		->order('listorder desc, news_id desc')
		->limit($offset,$pageSize)
		->select();
	}

	public function getNewsCount($data){
		if(isset($data['title']) && $data['title']){
			$condition['title'] = array('like','%'.$data['title'].'%');
		}

		if (isset($data['catid']) && $data['catid']) {
			$condition['catid'] = $data['catid'];
		}
		$condition['status'] = array('neq','-1');
		return $this->_db->where($condition)->count();
	}

	public function getNewsInfoById($news_id){
		if (!isset($news_id) || !is_numeric($news_id)) {
			return false;
		}
		return $this->_db->where('news_id='.$news_id)->find();
	}

	public function setNewstatus($id,$status){
		$data['status'] = $status;
		return $this->_db->where('news_id='.$id)->save($data);
	}

	public function updateListOrder($id,$listorder){
		$data['listorder'] = $listorder;
		return $this->_db->where('news_id='.$id)->save($data);
	}

	public function getNewsByIdIn($idList){
		if (!is_array($idList)) {
			throw_exception('参数不合法！');
		}
		$data = array(
			'news_id'=>array('in',implode(',', $idList))
		);
		return $this->_db->where($data)->select();
	}

	public function rankList(){
		$condition = array(
			'status'=>'1'
		);
		return $this->_db->where($condition)->order('count desc,listorder desc')->select();
	}

	public function updateCount($id,$count){
		$data['count'] = $count;
		return $this->_db->where('news_id='.$id)->save($data);
	}


}