<?php
namespace Common\Model;
use Think\Model;

/**
* 
*/
class News_contentModel extends Model
{
	
	private $_db = '';
	function __construct()
	{
		$this->_db = M('news_content');
	}

	public function insert($data=array()){
		if (!isset($data) || !$data) {
			return false;
		}

		$data['create_time'] = time();
		$data['content'] = htmlspecialchars($data['content']);
		return $this->_db->add($data);
	}

	public function save($data=array()){
		if (!isset($data) || !$data) {
			return false;
		}
		$news_id = $data['news_id'];
		$data['update_time'] = time();
		$data['content'] = htmlspecialchars($data['content']);
		return $this->_db->where('news_id='.$news_id)->save($data);
	}

	public function getContentById($id){
		if (!isset($id) || !$id) {
			return false;
		}

		return $this->_db->where('news_id='.$id)->find();
	}

	
}