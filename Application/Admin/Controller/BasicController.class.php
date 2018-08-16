<?php
namespace Admin\Controller;
use Think\Controller;

/**
* 
*/
class BasicController extends CommonController
{
	
	public function index(){
		$basicInfo = D('Basic')->select();
		$this->assign('basicInfo',$basicInfo);
		$this->assign('type','1');
		$this->display();
	}

	public function add(){
		if($_POST) {
			if(!$_POST['title']) {
				return show('error', '站点信息不能为空');
			}
			if(!$_POST['keywords']) {
				return show('error', '站点关键词');
			}
			if(!$_POST['description']) {
				return show('error', '站点描述');
			}

			D("Basic")->save($_POST);
			return show('success', '配置成功');
		}else {
			return show('error', '没有提交的数据');
		}
	}

	public function cache(){
		$this->assign('type','2');
		$this->display();
	}
}