<?php
namespace Common\Model;
use Think\Model;
use Think\Upload;

/**
* 
*/
class UploadImageModel extends Model{

	private $_uploadObj = '';
	const UPLOAD = 'upload';
	
	function __construct()
	{
		$this->_uploadObj = new Upload();
		$this->_uploadObj->rootPath = './'.self::UPLOAD.'/';
		$this->_uploadObj->subName = date('Y').'/'.date('m').'/'.date('d');
	}

	public function upload(){

		$res = $this->_uploadObj->upload();
		if ($res) {
			return '/'.self::UPLOAD.'/'.$res['imgFile']['savepath'].$res['imgFile']['savename'];
		}
	}
		
	public function imageUpload(){
		$res = $this->_uploadObj->upload();
		if ($res) {
			return '/'.self::UPLOAD.'/'.$res['file']['savepath'].$res['file']['savename'];
		}else{
			return false;
		}
	}
}