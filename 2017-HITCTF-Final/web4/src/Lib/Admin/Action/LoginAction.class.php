<?php
namespace Admin\Action;
use Think\Action;
class LoginAction extends Action{
    //默认操作
    public function index(){
	
		if ($_SESSION[C('USER_AUTH_KEY')]) {
			redirect("?s=Admin-Index");
		}
		$this->display('./Public/admin/login.html');
    }
	//登陆检测_前置
	public function _before_check(){
	    if (empty($_POST['user_name'])) {
			$this->error(L('login_username_check'));
		}
		if (empty($_POST['user_pwd'])) {
			$this->error(L('login_password_check'));
		}			
	}
	//登陆检测
    public function check(){
        $where = array();
		$where['admin_name'] = trim($_POST['user_name']);
		$rs = D("Admin");
		$list = $rs->where($where)->find();
        if (NULL == $list) {
            $this->error(L('login_username_not'));
        }
		if ($list['admin_pwd'] != md5($_POST['user_pwd'])) {
			$this->error(L('login_password_not'));
		}
		// 缓存访问权限
		$_SESSION[C('USER_AUTH_KEY')] = $list['admin_id'];
		$_SESSION['admin_name'] = $list['admin_name'];
		$_SESSION['admin_ok'] = $list['admin_ok'];
		//更新用户登陆信息
		$data = array();
		$data['admin_id'] = $list['admin_id'];
		$data['admin_logintime'] = time();
		$data['admin_count'] = array('exp','admin_count+1');
		$data['admin_ip'] = get_client_ip();
		$rs->save($data);					
		redirect('?s=Admin-Index');
    }
	// 用户登出
    public function logout(){
		
        if (isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION);
			session_destroy();
        }
		if (!$_SESSION[C('USER_AUTH_KEY')]) {
			redirect("?s=Admin-Login");
		}
		header("Content-Type:text/html; charset=utf-8");
		echo ('您已经退出网站管理后台，如需操作请重新登录！');
    }
}
?>