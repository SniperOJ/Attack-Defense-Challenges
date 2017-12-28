<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class GbAction extends BaseAction{
	// 用户留言管理
    public function show(){
		$admin = array();$where = array();
		$admin['cid']    = intval($_REQUEST['cid']);
		$admin['status'] = intval($_GET['status']);
		$admin['intro']     = intval($_GET['intro']);
		$admin['wd']     = urldecode(trim($_REQUEST['wd']));
		if ($admin['cid']) {
			$where['gb_cid'] = array('gt',0);
			$admin['gb_title'] = '报错';
		}else{
			$where['gb_cid'] = array('eq',0);
			$admin['gb_title'] = '留言';
		}
		if ($admin['status'] == 2) {
			$where['gb_status'] = array('eq',0);
		}elseif ($admin['status'] == 1) {
			$where['gb_status'] = array('eq',1);
		}
		if ($admin['intro']) {
			$where['gb_intro'] = array('eq','');
		}		
		if (!empty($admin['wd'])) {
			$search['gb_ip']      = array('like','%'.$admin['wd'].'%');
			$search['gb_content'] = array('like','%'.$admin['wd'].'%');
			$search['user_name'] = array('like','%'.$admin['wd'].'%');
			$search['_logic'] = 'or';
			$where['_complex'] = $search;
			$admin['wd'] = urlencode($admin['wd']);
		}
		//
		$admin['p'] = '';
		$rs = D('Guestbook');
		$count  = $rs->where($where)->count();
		$limit = intval(C('url_num_admin'));
		$currentpage = !empty($_GET['p'])?intval($_GET['p']):1;
		$totalpages = ceil($count/$limit);
		$currentpage = get_maxpage($currentpage,$totalpages);
		$pageurl = U('Admin-Gb/Show',$admin,false,false)."-p-{!page!}";
		//
		$admin['p'] = $currentpage;$_SESSION['gb_jumpurl'] = U('Admin-Gb/Show',$admin);
		$admin['pages'] = '共'.$count.'篇留言&nbsp;当前:'.$currentpage.'/'.$totalpages.'页&nbsp;'.getpage($currentpage,$totalpages,8,$pageurl,'pagego(\''.$pageurl.'\','.$totalpages.')');
		$admin['list'] = $rs->where($where)->limit($limit)->page($currentpage)->order('gb_oid desc,gb_addtime desc')->select();
		$this->assign($admin);
        $this->display('./Public/admin/gb_show.html');
    }
	// 用户留言编辑
    public function add(){
		$rs = D('Guestbook');
		$where['gb_id'] = $_GET['id'];
		$array = $rs->where($where)->find();
		$this->assign($array);	
        $this->display('./Public/admin/gb_add.html');
    }
	// 更新用户留言
	public function update(){
		$rs = D('Guestbook');
		if ($rs->create()) {
			if (false !==  $rs->save()) {
			    $this->assign("jumpUrl",$_SESSION['gb_jumpurl']);
				$this->success('更新留言信息成功！');
			}else{
				$this->error("更新留言信息失败！");
			}
		}else{
		    $this->error($rs->getError());
		}	
	}
	// 删除留言BY-ID
    public function del(){
		$rs = D('Gb');
		$where['gb_id'] = $_GET['id'];
		$rs->where($where)->delete();
		redirect($_SERVER['HTTP_REFERER']);
    }
	// 删除留言All
    public function delall($uid){
		if(empty($_POST['ids'])){
			$this->error('请选择需要删除的留言信息！');
		}
		$rs = D('Gb');	
		$where['gb_id'] = array('in',implode(',',$_POST['ids']));
		$rs->where($where)->delete();
		redirect($_SERVER['HTTP_REFERER']);
    }	
	// 清空留言
    public function delclear(){
		$rs = D('Gb');
		if ($_REQUEST['cid']) {
			$rs->where('gb_cid > 0')->delete();
		}else{
			$rs->where('gb_cid = 0')->delete();
		}
		$this->success('所有用户留言或报错信息已经清空！');
    }
	// 隐藏与显示留言
    public function status(){
		$rs = D('Gb');
		$where['gb_id'] = $_GET['id'];
		if(intval($_GET['value'])){
			$rs->where($where)->setField('gb_status',1);
		}else{
			$rs->where($where)->setField('gb_status',0);
		}
		redirect($_SERVER['HTTP_REFERER']);
    }
	// 置顶留言
    public function order(){
		$rs = D('Gb');
		$where['gb_id'] = $_GET['id'];
		if(intval($_GET['value'])){
			$rs->where($where)->setField('gb_oid',1);
		}else{
			$rs->where($where)->setField('gb_oid',0);
		}
		redirect($_SERVER['HTTP_REFERER']);
    }	
   // 批量隐藏与显示留言
    public function statusall(){
		if(empty($_POST['ids'])){
			$this->error('请选择需要操作的留言内容！');
		}
		$rs = D('Gb');
		$where['gb_id'] = array('in',implode(',',$_POST['ids']));
		if(intval($_GET['value'])){
			$rs->where($where)->setField('gb_status',1);
		}else{
			$rs->where($where)->setField('gb_status',0);
		}
		redirect($_SERVER['HTTP_REFERER']);
    }							
}
?>