<?php
namespace Admin\Controller;
use Think\Controller;

/**
* 
*/
class PositionController extends CommonController
{
	
	public function index(){
		$positionList = D('Position')->getPositionList();
		//var_dump($positionList);die;
		$this->display();
	}

	public function add(){
		if ($_POST) {
			var_dump($_POST);die;
		}else{
			$this->display();
		}
		
	}
}