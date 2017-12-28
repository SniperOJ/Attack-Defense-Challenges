<?php
namespace Home\Action;
use Common\Action\HomeAction;
class MapAction extends HomeAction{
	public function show(){
		$mapname = I("get.id", "rss", "strip_tags,htmlspecialchars");
		$limit = I("get.limit", "30", "strip_tags,htmlspecialchars");
		$page = I("get.p", "1", "strip_tags,htmlspecialchars");
		$this->assign("list_map", $this->Lable_Maps($mapname, $limit, $page));
		$this->display("./Public/maps/" . $mapname . ".html", "utf-8", "text/xml");
	}
	public function rss(){
		$rs = M("Ting");
		$where["ting_id"] = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$where["ting_status"] = 1;
		$array_ting = $rs->where($where)->find();
		if ($array_ting) {
			$array = $this->Lable_Ting_Read($array_ting);
			$this->assign($array["show"]);
			$this->assign($array["read"]);
			$this->display("./Public/maps/rssid.html", "utf-8", "text/xml");
		}
	}
}
?>