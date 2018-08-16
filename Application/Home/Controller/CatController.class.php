<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;




class CatController extends CommonController {
    public function index(){
    	
        $catId = $_GET['id'];
        if (!$catId || !is_numeric($catId)) {
           return $this->error('ID不存在！');
        }

        $condition['menu_id'] = $catId;
        $cat = D('Menu')->find($condition);
        if (!$cat || ($cat['status'] != 1)) {
            return $this->error('栏目不存在或栏目不正常！');
        }
        $data = array(
            'catid' => $catId
        );
        $rankList = D('News')->rankList();
        $newsList = D('News')->getNewsData($data);
        $page = $_GET['p'] ? $_GET['p'] : 1;
        $pageSize = 5;
        $count = D('News')->getNewsCount();
        $myPage = new Page($count,$pageSize);
        $pageRes = $myPage->show();
        $result = array(
            'newsList'  => $newsList,
            'pageRes'   => $pageRes,
            'rankList'  => $rankList,
            'catId' => $catId
        );

    	
    	$this->assign('result',$result);
        $this->display();
    }
}