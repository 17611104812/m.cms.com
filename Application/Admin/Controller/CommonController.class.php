<?php

namespace Admin\Controller;
use Think\Controller;
/**
* 
*/
class CommonController extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->_init();
	}

	private function _init(){
		$isLogin = $this->is_login();
		if (!$isLogin) {
			$this->redirect('/admin/login/index');
		}
	}

	public function getUserInfo(){
		return session('adminUser');
	}

	public function is_login(){
		$user = $this->getUserInfo();
		if ($user && is_array($user)) {
			return true;
		}else{
			return false;
		}
	}
}