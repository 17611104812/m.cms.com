<?php
namespace Home\Controller;
use Think\Controller;

/**
* 
*/
class CronController
{
	
	public function mysql_dump(){
		$shell = 'mysqldump -u'.C('DB_USER').' -p'.C('DB_PWD').' cms > /tmp/cms/'.date('Ymd',time()).'.sql';
		exec($shell);
	}
}