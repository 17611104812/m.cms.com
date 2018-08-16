<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;




class DetailController extends CommonController {
    public function index(){
    	
        $detailId = $_GET['id'];
        if (!$detailId || !is_numeric($detailId)) {
           return $this->error('ID不存在！');
        }

        $newsInfo = D('News')->getNewsInfoById($detailId);
        if (!$newsInfo || ($newsInfo['status'] != 1)) {
            return $this->error('文章不存在或文章不正常！');
        }

        $count = intval($newsInfo['count']) + 1;

        D('News')->updateCount($detailId,$count);

        $newsContent = D('News_content')->getContentById($newsInfo['news_id']);
        $newsInfo['content'] = htmlspecialchars_decode($newsContent['content']);
        $rankList = D('News')->rankList();
        $result = array(
            'rankList'  => $rankList,
            'catId' => $newsInfo['catid'],
            'newsInfo' => $newsInfo
        );
       
    	
    	$this->assign('result',$result);
        $this->display('Detail/index');
    }

    public function view(){
        if (!getUserName()) {
            return $this->error('没有权限执行此操作！');
        }
        $this->index();

    }
}