<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class LinkAction extends BaseAction{	
	// 显示友情链接
    public function show(){
	    $rs = D("Link");
		$link = $rs->order('link_type asc,link_order asc')->select();
		F('_ppting/link',$link);		
		$list = $rs->order('link_order asc')->select();
		$this->assign('list_link',$list);
		$this->display('./Public/admin/link_show.html');
    }
	// 添加友情链接
    public function add(){
		$id = intval($_GET['id']);
	    $rs = D("Link");
		if ($id) {
            $where['link_id'] = $id;
			$list = $rs->where($where)->find();
			$list['templatetitle'] = '编辑';
		}else{
		    $list['link_order'] = $rs->max('link_order')+1;
			$list['templatetitle'] = '添加';
		}
		$this->assign($list);	
		$this->display('./Public/admin/link_add.html');
    }
	// 添加友情链接并写入数据库
	public function insert(){
		$rs = D("Link");
		if ($rs->create()) {
			if ( false !==  $rs->add() ) {
				redirect('?s=Admin-Link-Show');
			}else{
				$this->error('添加友情链接失败！');
			}
		}else{
		    $this->error($rs->getError());
		}		
	}
	// 更新友情链接
	public function update(){
		$rs = D("Link");
		if ($rs->create()) {
			$list = $rs->save();
			if ($list !== false) {
			    redirect('?s=Admin-Link-Show');
			}else{
				$this->error("更新友情链接失败！");
			}
		}else{
			$this->error($rs->getError());
		}
	}			
	// 批量更新
	public function updateall(){
	    $array = $_POST;
		$rs = D("Link");
		foreach($array['link_id'] as $value){
		    $data['link_id'] = $array['link_id'][$value];
			$data['link_name'] = trim($array['link_name'][$value]);
			$data['link_url'] = trim($array['link_url'][$value]);
			$data['link_logo'] = trim($array['link_logo'][$value]);
			$data['link_order'] = $array['link_order'][$value];
			$data['link_type'] = $array['link_type'][$value];
			if(empty($data['link_name'])){
			    $rs->where('link_id = '.intval($data['link_id']))->delete();
			}else{
			    $rs->save($data);
			}
		}
		$this->success('友情链接数据更新成功！');
	}
	// 删除友情链接
    public function del(){
		$rs = D("Link");
		$where['link_id'] = $_GET['id'];
	    $rs->where($where)->delete();
		redirect('?s=Admin-Link-Show');
    }					
}
?>