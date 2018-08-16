<?php

function show($status,$msg = '',$data = ''){
	$result = array(
		'status' => $status,
		'msg' => $msg,
		'data' => $data
	);
	header('Content-Type:application/json; charset=utf-8');
	exit(json_encode($result));
}

function kindeShow($status,$data){
	header('Content-Type:application/json; charset=utf-8');
	if ($status == 0) {
		exit(json_encode(array('error'=>0,'url'=>$data)));
	}
	exit(json_encode(array('error'=>1,'message'=>'上传失败！')));
}

function getMd5Password($password){
	return md5($password.C('MD5_PRE'));
}

function getMenuType($type){
	return $type == '1' ? '后台菜单' : '前端导航';
}

function getMenuStatus($status){
	if ($status == '1') {
		$str = '正常';
	}elseif($status == '0'){
		$str = '关闭';
	}elseif($status == '-1'){
		$str = '删除';
	}
	return $str;
}

function getAdminUrl($nav){
	return '/'.$nav['m'].'/'.$nav['c'].'/'.$nav['f'];
}

function getActive($nav){
	if ($nav == strtolower(CONTROLLER_NAME)) {
		return "class='active'";
	}

}

function getUserName(){
	return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username'] : '';
}

function getLoginUsername() {
    return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username']: '';
}

function getCatName($barMenus,$catid){
	foreach ($barMenus as $key => $value) {
		if ($value['menu_id'] == $catid) {
			return $value['name'];
		}
	}
}

function getCopyFrom($from){
	return C('COPY_FROM')[$from] ? C('COPY_FROM')[$from] : '';
}

