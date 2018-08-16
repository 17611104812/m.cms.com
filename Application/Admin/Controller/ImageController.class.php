<?php
namespace Admin\Controller;
use Think\Controller;

/**
* 
*/
class ImageController extends CommonController
{
	
	public function ajaxuploadimage(){
		$upload = D('UploadImage');
		$res = $upload->imageUpload();
		if ($res == false) {
			return show('error','上传失败！');
		}else{
			return show('success','上传成功！',$res);
		}
	}

	public function kindupload(){
		$upload = D('UploadImage');
		$res = $upload->upload();
		if ($res == false) {
			return kindeShow('1','上传失败！');
		}else{
			return kindeShow('0',$res);
		}
	}
}