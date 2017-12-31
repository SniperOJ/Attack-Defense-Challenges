<?php
namespace Home\Action;
use Common\Action\HomeAction;
class TagAction extends HomeAction{
    public function ting(){
		$this->tagall('ting');
		$this->display('gxl_tingtag');
    }
    public function news(){
		$this->tagall('news');
		$this->display('gxl_newstag');
    }
	public function tagall($sidname = 'ting'){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = gxl_param_url();
		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';
		C('jumpurl',UU('Home-tag/'.$sidname,$JumpUrl,true,false));	
		C('currentpage',$Url['page']);
		//变量赋值
		$tag_list = $this->Lable_Tags($Url);
		$this->assign($tag_list);	
	}	
}
?>