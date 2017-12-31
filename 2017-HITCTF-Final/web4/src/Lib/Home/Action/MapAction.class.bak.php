<?php
namespace Home\Action;
use Common\Action\HomeAction;
class MapAction extends HomeAction{
    public function show(){
		$mapname = !empty($_GET['id'])?trim($_GET['id']):'rss';
		$limit = !empty($_GET['limit'])?intval($_GET['limit']):30;
		$page = !empty($_GET['p'])?intval($_GET['p']):1;
		$this->assign('list_map',$this->Lable_Maps($mapname,$limit,$page));
		$this->display('./Public/maps/'.$mapname.'.html','utf-8','text/xml');
	}
    public function rss(){
		$rs = M("Ting");
		$where['ting_id'] = $_GET['id'];
		$where['ting_status'] = 1;
		$array_ting = $rs->where($where)->find();
		if($array_ting){
			$array = $this->Lable_Ting_Read($array_ting);
			$this->assign($array['show']);
			$this->assign($array['read']);
			$this->display('./Public/maps/rssid.html','utf-8','text/xml');
		}
	}
}
?>