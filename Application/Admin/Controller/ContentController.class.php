<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
//use Think\Exception;

/**
* 
*/
class ContentController extends CommonController
{
	
	public function index(){
		$conds = array();
		$page = 1;
		$pageSize = 5;
		if (isset($_GET['title']) && $_GET['title']) {
			$conds['title'] = $_GET['title'];
		}

		if (isset($_GET['catid']) && $_GET['catid']) {
			$conds['catid'] = $_GET['catid'];
		}

		if (isset($_GET['p']) && $_GET['p']) {
			$page = $_GET['p'];
		}
		$barMenus = D('Menu')->getBarMenus();
		//var_dump($barMenus);die;
		$newsData = D('News')->getNewsData($conds,$page,$pageSize);
		$count = D('News')->getNewsCount($conds);

		$positionList = D('Position')->getPositionList();
		//var_dump($positionList);die;
		$myPage = new Page($count,$pageSize);
		$pageRes = $myPage->show();

		$this->assign('pageRes',$pageRes);
		$this->assign('barMenus',$barMenus);
		$this->assign('newsData',$newsData);
		$this->assign('positionList',$positionList);
		$this->display();
	}

	public function add(){

		if ($_POST) {
			if (!isset($_POST['title']) || !$_POST['title']) {
				return show('error','请输入文章标题！');
			}
			if (!isset($_POST['small_title']) || !$_POST['small_title']) {
				return show('error','请输入短标题！');
			}
			if (!isset($_POST['content']) || !$_POST['content']) {
				return show('error','请输入文章内容！');
			}
			$news_id = D('News')->insert($_POST);
			if ($news_id) {
				$news_content_data['news_id'] = $news_id;
				$news_content_data['content'] = $_POST['content'];
				$res = D('News_content')->insert($news_content_data);
				if ($res === false) {
					return show('error','主表添加成功，附表添加失败！');
				}
				return show('success','添加成功！');

			}else{
				return show('error','添加失败！');
			}
	
		}else{
			$barMenu = D('Menu')->getBarMenus();
			$titleColor = C('TITLE_FONT_COLOR');
			$copy_from = C('COPY_FROM');
			$this->assign('barMenus',$barMenu);
			$this->assign('titleColor',$titleColor);
			$this->assign('copyFrom',$copy_from);
			$this->display();
		}

		
	}

	public function edit(){

		if ($_POST) {
			if (!isset($_POST['title']) || !$_POST['title']) {
				return show('error','请输入文章标题！');
			}
			if (!isset($_POST['small_title']) || !$_POST['small_title']) {
				return show('error','请输入短标题！');
			}
			if (!isset($_POST['content']) || !$_POST['content']) {
				return show('error','请输入文章内容！');
			}
			if (!isset($_POST['news_id']) || !$_POST['news_id']) {
				return show('error','系统异常！');
			}

			$news_id = D('News')->save($_POST);
			//var_dump($news_id);die;
			if ($news_id) {
				$news_content_data['news_id'] = $news_id;
				$news_content_data['content'] = $_POST['content'];
				$res = D('News_content')->save($news_content_data);
				if ($res === false) {
					return show('error','主表修改成功，附表修改失败！');
				}
				return show('success','修改成功！');

			}else{
				return show('error','修改失败！');
			}

		}else{
			$news_id = $_GET['id'];
			if (!isset($news_id) || !$news_id) {
				$this->redirect('/admin/content');
			}
			$newsInfo = D('News')->getNewsInfoById($news_id);
			$contentInfo = D('News_content')->getContentById($news_id);
			$newsInfo['content'] = $contentInfo['content'];
			$barMenus = D('Menu')->getBarMenus();

			$this->assign('newsInfo',$newsInfo);
			$this->assign('titleColor',C('TITLE_FONT_COLOR'));
			$this->assign('copyFrom',C('COPY_FROM'));
			//var_dump(C('COPY_FROM'));die;
			$this->assign('barMenus',$barMenus);
			$this->display();
		}
		
	}

	public function setStatus(){
		$menu_id = $_POST['menu_id'];
		$status = $_POST['status'];
		if (!$menu_id || !is_numeric($menu_id)) {
			show('error','参数错误');
		}
		$result = D('News')->setNewstatus($menu_id,$status);
		if ($result) {
			show('success','删除成功');
		}else{
			show('error','删除失败');
		}
	}

	public function listorder(){
		$listInfo = $_POST;
		$error = array();
		$jump_url = $_SERVER['HTTP_REFERER'];
		foreach ($listInfo as $key => $value) {
			$res = D('News')->updateListOrder($key,$value);
			if ($res === false) {
				$error[] = $key;
			}
		}
		if ($error) {
			return show('error','id为'.implode(',', $error).'更新出错！');
		}
		return show('success','更新成功！',array('jump_url'=>$jump_url));
	}

	public function push(){
		$push = $_POST['push'];
		$positionId = $_POST['positionId'];
		$jump_url = $_SERVER['HTTP_REFERER'];
		if (!$push || !is_array($push)) {
			return show('error','请选择要推荐的文章！');
		}

		if (!$positionId) {
			return show('error','请选择推荐位！');
		}
		try {
			$news = D('News')->getNewsByIdIn($push);
			if (!$news) {
				return show('error','无相关内容！');
			}
			$error = array();
			foreach ($news as $key => $value) {
				$data = array(
					'position_id' => $positionId,
					'title'		  => $value['title'],
					'thumb'		  => $value['thumb'],
					'news_id'	  => $value['news_id'],
					'status'	  => '1',
					'create_time' => $value['create_time']
				);
				$res = D('Position_content')->insert($data);
				if (!$res) {
					$error[] = $value['news_id'];
				}
			}

			if ($error) {
				return show('error','id为'.implode(',', $error).'的文章推荐失败！');
			}
			return show('success','推荐成功！',array('jump_url'=>$jump_url));
		} catch (Exception $e) {
			return show('error',$e->getMessage());
		}
		
		
		//var_dump($news);
	}


}