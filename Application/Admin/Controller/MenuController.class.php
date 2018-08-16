<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Page;

/**
* 
*/
class MenuController extends CommonController
{
	
	public function add(){
		if ($_POST) {
			if (!isset($_POST['name']) || !$_POST['name']) {
				show('error','菜单名不能为空！');
			}
			if (!isset($_POST['m']) || !$_POST['m']) {
				show('error','模块名不能为空！');
			}
			if (!isset($_POST['c']) || !$_POST['c']) {
				show('error','控制器名不能为空！');
			}
			if (!isset($_POST['f']) || !$_POST['f']) {
				show('error','方法名不能为空！');
			}

			if ($_POST['menu_id']) {
				$this->save($_POST);
				return;
			}
			$menuId = D('Menu')->insert($_POST);
			if ($menuId) {
				show('success','新增成功！');
			}else{
				show('error','新增失败！');
			}
		}else{
			$this->display();
		}
		
	}

	public function index(){
		$data = array();
		$type = $_REQUEST['type'];
		if (isset($type) && in_array($type, array('0','1'))) {
			$data['type'] = $type;
			$this->assign('type',$type);
		}else{
			$this->assign('type','-1');
		}
		$page = $_REQUEST['p'] ? $_REQUEST['p'] : '1';
		$pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : '5';
		$menus = D('Menu')->getMenus($data,$page,$pageSize);
		$menusCount = D('Menu')->getMenusCount($data);
		$res = new Page($menusCount,$pageSize);
		$pageRes = $res->show();
		$this->assign('pageRes',$pageRes);
		$this->assign('menus',$menus);
		$this->display();
	}

	public function edit(){

		$menu_id = I('get.id');
		if (!$menu_id) {
			return flase;
		}
		$data['menu_id'] = $menu_id;
		$result = D('Menu')->find($data);
		$this->assign('menuInfo',$result);
		$this->display();
	}

	public function save($data){
		$menu_id = $data['menu_id'];
		unset($data['menu_id']);
		

		try{
			$result = D('Menu')->updateMenuById($menu_id,$data);
			if ($result === false) {
				return show('error','更新失败！');
			}
			return show('success','更新成功！');
		}catch(Exception $e){
			return show('error',$e->getMessage());
		}

	}

	public function setStatus(){
		$menu_id = $_POST['menu_id'];
		$status = $_POST['status'];
		if (!$menu_id || !is_numeric($menu_id)) {
			show('error','参数错误');
		}
		$result = D('Menu')->setMenustatus($menu_id,$status);
		if ($result) {
			show('success','删除成功');
		}else{
			show('error','删除失败');
		}
	}

	public function listorder(){
		//dump($_POST);
		$listorder = $_POST['listorder'];
		$error = array();
		$url = $_SERVER['HTTP_REFERER'];
		foreach ($listorder as $key => $value) {
			//var_dump($key);
			$res = D('Menu')->updateListorderById($key,$value);
			if ($res===false) {
				$error[] = $key;
			}
		}
		if ($error) {
			show('error','排序出错，出错id为'.implode(',', $error));
		}else{
			show('success','排序成功',array('jump_url'=>$url));
		}
	}
}