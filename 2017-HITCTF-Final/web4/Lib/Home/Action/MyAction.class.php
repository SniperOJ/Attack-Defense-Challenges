<?php
namespace Home\Action;
use Common\Action\HomeAction;
class MyAction extends HomeAction{
    public function show(){
		$id = I('get.id','new','strip_tags,htmlspecialchars');
		$thisurl=gxl_mytemplate_url($id);
		$this->assign('thisurl',$thisurl);
		$this->display('my_'.trim($id));
	}	
}
?>