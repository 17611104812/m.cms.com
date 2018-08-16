<?php
namespace Admin\Controller;

use Think\Controller;

/**
* 
*/
class IndexController extends CommonController
{
	function __construct(){
		parent::__construct();
		if(session('adminUser') == ''){
			redirect('/admin/login/index');
		}
	}

	public function index(){
		$this->display();
	}
}