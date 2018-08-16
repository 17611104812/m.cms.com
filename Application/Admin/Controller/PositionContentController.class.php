<?php
namespace Admin\Controller;
use Think\Controller;

/**
* 
*/
class PositionContentController extends CommonController
{
	
	public function index(){
		$positionId = $_GET['position_id'];
		$title = $_GET['title'];
		if ($positionId) {
			$condition['position_id'] = $positionId;
		}
		if ($title) {
			$condition['title'] = $title;
		}
		$positionList = D('Position')->getPositionList();
		$positionContent = D('Position_content')->getPositionContent($condition);
		//var_dump($positionContent);die;
		$this->assign('positionList',$positionList);
		$this->assign('positionContent',$positionContent);
		$this->display();
	}
}