<?php 
namespace Common\Model;
use Think\Model\AdvModel;
class AdminModel extends AdvModel {
	protected $_validate=array(
		array('admin_name','require','管理员名称必须填写！',1,'',1),
		array('admin_pwd','require','管理员密码必须填写！',1,'',1),
		array('admin_repwd','admin_pwd','两次输入的密码不一致,请重新输入！',1,'confirm','',3),
		array('admin_name','','帐号名称已经存在！',1,'unique',1),
	);
	protected $_auto=array(
		array('admin_pwd','admin_pwd',3,'callback'),
		array('admin_count','0'),
		array('admin_ip','get_client_ip',3,'function'),
		array('admin_logintime','time',1,'function'),
	);
	public function admin_pwd(){
		if (empty($_POST['admin_pwd'])) {
		    return false;
		}else{
		    return md5($_POST['admin_pwd']);
		}
	}
}
?>