<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class ListAction extends BaseAction{	
	// 显示分类
    public function show(){
	    $sid = $_GET['sid'];
		if ($sid) {
			$where['list_sid'] = $sid;
		}
	    $rs = D("List");
		$list = $rs->where($where)->order('list_oid asc')->select();
		if($list){
			$this->assign('listtree',list_to_tree($list,'list_id','list_pid','son',0));
			$this->display('./Public/admin/list_show.html');
		}else{
		    $this->assign("jumpUrl",'?s=Admin-List-Add');
			$this->success('暂无分类数据请先添加！');		    
		}
    }
	// 添加编辑分类
    public function add(){
		$cid = intval($_GET['id']);
	    $rs = D("List");
		if ($cid>0) {
            $where['list_id'] = $cid;
			$list = $rs->where($where)->find();
			$list['templatetitle'] = '编辑';
		}else{
		    $list['list_id'] = 0;
		    $list['list_pid'] = intval($_GET['pid']);
			$list['list_sid'] = intval($_GET['sid']);
		    $list['list_oid'] = $rs->max('list_oid')+1;
			$list['list_status'] = 1;
			$list['templatetitle'] = '添加';
		}
		$this->assign($list);
		$this->assign('list_tree',F('_ppting/listtree'));
		$this->display('./Public/admin/list_add.html');
    }	
	// 写入数据
	public function _before_insert(){//写入前置
		if($_POST['list_sid'] == 9){
			$_POST['list_dir'] = uniqid();
		}
	}	
	public function insert(){
		$rs = D("List");
		if ($rs->create()) {
			if ( false !==  $rs->add() ) {
			    $this->ppting_list();
				$this->assign("jumpUrl",'?s=Admin-List-Show');
				$this->success('添加栏目分类成功！');
			}else{
				$this->error('添加栏目分类错误');
			}
		}else{
		    $this->error($rs->getError());
		}		
	}	
	// 更新数据
	public function _before_update(){//前置
		$where['list_dir'] = trim($_POST['list_dir']);
		$rs = D("List");
		$list = $rs->field('id,cfile')->where($where)->find();
		if(!empty($list)){
			if(intval($_POST['list_id']) != $list['list_id']){
				$this->error('栏目英文别名已经存在,请重新填写！');
			}
		}
	}
	public function update(){
		$rs = D("List");
		if ($rs->create()) {
			$list = $rs->save();
			if ($list !== false) {
			    $this->ppting_list();
				$this->assign("jumpUrl",'?s=Admin-List-Show');
				$this->success('栏目分类更新成功！');
			}else{
				$this->error("栏目分类更新失败！");
			}
		}else{
			$this->error($rs->getError());
		}
	}
	// 批量更新数据
    public function updateall(){
		if(empty($_POST['ids'])){
			$this->error('请选择需要修改的栏目！');
		}
		$rs = D("List");
		$array = $_POST;
		foreach($array['ids'] as $key=>$value){
		    $data['list_oid'] = intval($array['list_oid'][$value]);
			$data['list_name'] = $array['list_name'][$value];
			$data['list_skin'] = $array['list_skin'][$value];
			if(empty($array['list_dir'][$value])){
				$data['list_dir'] = gxl_pinyin($array['list_name'][$value]);
			}else{
				$data['list_dir'] = $array['list_dir'][$value];
			}				
			$rs->where('list_id = '.intval($value))->save($data);
		}
		$this->ppting_list();
		$this->redirect('Admin-List/Show');
    }
	// 隐藏与显示栏目
    public function status(){
		$where['list_id'] = intval($_GET['id']);
		if (!getlistson($where['list_id'])) {
			$this->error("该栏目有子类,不可以隐藏！");
		}
		$rs = D("List");
		if (intval($_GET['sid'])) {
			$rs->where($where)->setField('list_status',1);
		}else{
			$rs->where($where)->setField('list_status',0);
		}	
		$this->ppting_list();
		$this->redirect('Admin-List/Show');
    }
	// 删除数据
    public function del(){
		$rs = D("List");
		$where['list_id'] = $_GET['id'];
		if (!getlistson($_GET['id'])) {
			$this->error("请先删除本类下面的子栏目！");
		}
		$rs->where($where)->delete();
		$sid = getlistname($id,'list_id');
		$this->deldata($sid,$id);
		$this->ppting_list();
		$this->success('成功删除该栏目分类与本类有关的内容！');
    }
	//删除对应的数据
	public function deldata($sid,$cid){
		if ($sid == 1) {
			$rs = M("Ting");
			$rs->where('ting_cid = '.$cid)->delete();
		}elseif($sid == 2){
			$rs = M("News");
			$rs->where('news_cid = '.$cid)->delete();			
		}
	}
	// 批量删除数据
    public function delall(){
		if(empty($_POST['ids'])){
			$this->error('请选择需要删除的栏目！');
		}	
		$list = D("List");
		$array = $_POST;
		foreach($array['ids'] as $value){
			$id = intval($value);
			$sid = getlistname($id,'list_id');
			if (!getlistson($id)) {
				$this->error("请先删除本类下面的子栏目！");
			}			
		    $list->where('list_id = '.$id)->delete(); 
			$this->deldata($sid,$id);
		}
		$this->ppting_list();
		$this->success('批量删除栏目成功！');
    }					
}
?>