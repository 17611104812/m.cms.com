<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;




class IndexController extends CommonController {
    public function index($type = ''){

    	$bigPicNews = D('Position_content')->getPicNews(array(
    		'position_id' => '1',
    		'status'	  => '1',
    	),'1');
   
    	
    	$smallPicNews = D('Position_content')->getPicNews(array(
    		'position_id' => '2',
    		'status'	  => '1',
    	),'3');
    	$page = $_GET['p'] ? $_GET['p'] : 1;
    	$pageSize = 5;
    	$count = D('News')->getNewsCount();
    	$myPage = new Page($count,$pageSize);
    	$pageRes = $myPage->show();
    	$newsList = D('News')->getNewsData('',$page,$pageSize);
    	$rankList = D('News')->rankList();
    	$result = array(
    		'bigPicNews' => $bigPicNews,
    		'smallPicNews'=> $smallPicNews,
    		'newsList'	=> $newsList,
    		'pageRes'	=> $pageRes,
    		'rankList'	=> $rankList
    	);
    	$this->assign('result',$result);

    	if ($type == 'buildHtml') {
    		$this->buildHtml('index',HTML_PATH,'Index/index');
    	}else{
    		$this->display();
    	}

        
    }

    public function build_html(){
    	$this->index('buildHtml');
    	return show('success','缓存生成成功！');
    }



    public function cron_build(){
    	if (APP_CRONTAB != 1) {
    		exit('error_action');
    	}
    	$this->index('buildHtml');
    }

    public function getCount(){
    	$newsList = $_POST;
    	$newsList = array_unique($newsList);
    	if (!$newsList || !is_array($newsList)) {
    		return show('error','参数错误！');
    	}
    	$res = D('News')->getNewsByIdIn($newsList);
    	$data = array();
    	foreach ($res as $key => $value) {
    		$data[$value['news_id']] = $value['count'];
    	}
    	return show('success','',$data);
    }
}