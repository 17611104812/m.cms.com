<?php
namespace Admin\Controller;

use Think\Controller;

/**
* 
*/
class LoginController extends Controller
{

	public function index(){
		if (session('adminUser')) {
			$this->redirect('admin/index/index');
		}
		$this->display();
	}

	public function check(){

		$username = I('post.username');
		$password = I('post.password');
		if (!$username || !$password) {
			show('error','用户名和密码不能为空！');
		}

		$result = D('Admin')->getAdminByUsername($username);
		if (!$result) {
			return show('error','该用户不存在！');
		}
		if ($result['password'] != getMd5Password($password)) {
			return show('error','密码错误！');
		}
		session('adminUser',$result);
		return show('success','登录成功');
	}

	public function logOut(){
		session('adminUser',null);
		$this->redirect('/admin/login/index');
	}
}