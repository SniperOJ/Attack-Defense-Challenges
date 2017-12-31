<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class NavAction extends BaseAction{
    public function show(){
		$array = F('_nav/list');
		$this->assign('array_nav',$array);
        $this->display('./Public/admin/nav.html');
    }
	
    public function update(){
		$content = trim($_POST["content"]);
		if(empty($content)){
			$this->error('自定义菜单不能为空！');
		}
		foreach(explode(chr(13),$content) as $value){
			list($key,$val) = explode('|',trim($value));
			if(!empty($val)){
				$arrlist[trim($key)] = trim($val);
			}
		}
		F('_nav/list',$arrlist);
		$this->assign("jumpUrl",C('cms_admin').'?s=Admin-Nav-Show-reload-1');
		$this->success('自定义菜单编辑成功！');
	}
}
?>