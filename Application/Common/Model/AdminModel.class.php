<?php
namespace Common\Model;
use Think\Model;

/**
 * 用户组操作
 * @author  singwa
 */
class AdminModel extends Model {
	private $_db = '';

	/*public function __construct() {
		$this->_db = M('admin');
	}*/
   
    public function getAdminByUsername($username='') {
        $res = $this->where('username="'.$username.'"')->find();
        // echo $this->getLastSql();exit;
        return $res;
    }
    public function getAdminByAdminId($adminId=0) {
        $res = $this->where('admin_id='.$adminId)->find();
        return $res;
    }

    public function updateByAdminId($id, $data) {

        if(!$id || !is_numeric($id)) {
            E("ID不合法");
        }
        if(!$data || !is_array($data)) {
            E('更新的数据不合法');
        }
        return  $this->where('admin_id='.$id)->save($data); // 根据条件更新记录
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->add($data);
    }

    public function getAdmins() {
        $data = array(
            'status' => array('neq',-1),
        );
        return $this->where($data)->order('admin_id desc')->select();
    }
    /**
     * 通过id更新的状态
     * @param $id
     * @param $status
     * @return bool
     */
    public function updateStatusById($id, $status) {
        if(!is_numeric($status)) {
            E("status不能为非数字");
        }
        if(!$id || !is_numeric($id)) {
            E("ID不合法");
        }
        $data['status'] = $status;
        return  $this->where('admin_id='.$id)->save($data); // 根据条件更新记录

    }

    public function getLastLoginUsers() {
        $time = mktime(0,0,0,date("m"),date("d"),date("Y"));
        $data = array(
            'status' => 1,
            'lastlogintime' => array("gt",$time),
        );

        $res = $this->where($data)->count();
        return $res['tp_count'];
    }

}
