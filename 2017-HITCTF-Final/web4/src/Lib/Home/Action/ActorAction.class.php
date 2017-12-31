<?php
namespace Home\Action;
use Common\Action\HomeAction;
class ActorAction extends HomeAction
{
	public function show()
	{
		$dir = I("get.dir", "none", "strip_tags,htmlspecialchars");
		$Url = gxl_param_url();

		if ($dir != "none") {
			$Url["id"] = get_id_by_dir($dir);
			$Url["dir"] = getlistdir($Url["id"]);
		}

		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl["p"] = "{!page!}";
		C("jumpurl", UU("Home-actor/show", $JumpUrl, true, false));
		C("currentpage", $Url["page"]);
		$List = list_search(F("_ppting/list"), "list_id=" . $Url["id"]);
		$channel = $this->Lable_Actor_List($Url, $List[0]);
		$this->assign($channel);
		$this->assign("sid", $channel);
		$this->display("gxl_actorlist");
	}

	public function read()
	{
		$name = I("get.name", "none", "strip_tags,htmlspecialchars");
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));

		if ($name != "none") {
			$id = get_id_by_name($name);
		}

		$array_detail = $this->get_cache_detail($id);
		$this->assign($array_detail["show"]);
		$this->assign($array_detail["read"]);
		$this->assign($array_detail["story"]);
		$this->assign($array_detail["actor"]);
		$this->display("gxl_actor");
	}

	public function role()
	{
		$name = I("get.name", "none", "strip_tags,htmlspecialchars");
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$vid = get_id_by_tingid($id);

		if ($name != "none") {
			$vid = get_id_by_name($name);
		}

		$array_detail = $this->get_cache_detail($vid);
		$array_actor["role"] = $array_detail["actor"]["actor_list"][$id];
		if ($array_detail && $array_actor["role"]) {
			$ting = A("Home.Ting");
			$actor = M("Actor");
			$year_tinglist = array();
			$where["actor_star"] = array("eq", $array_actor["role"]["star_name"]);
			$join = C("db_prefix") . "ting on " . C("db_prefix") . "actor.actor_vid = " . C("db_prefix") . "ting.ting_id ";
			$actorting = $actor->field("actor_id,actor_vid,actor_pic,actor_name,actor_star,ting_mcid,ting_id,ting_cid,ting_name,ting_pic,ting_actor,ting_filmtime,ting_jumpurl,ting_letters,ting_year")->join($join)->where($where)->limit(16)->order("ting_year desc")->select();

			foreach ($actorting as $key => $value ) {
				$year_tinglist[$key]["ting_year"] = $value["ting_year"];
				$year_tinglist[$key]["ting_filmtime"] = $value["ting_filmtime"];
				$year_tinglist[$key]["ting_name"] = $value["ting_name"];
				$year_tinglist[$key]["ting_mcid"] = $value["ting_mcid"];
				$year_tinglist[$key]["ting_pic"] = gxl_img_url($value["ting_pic"]);
				$year_tinglist[$key]["ting_actor"] = $value["ting_actor"];
				$year_tinglist[$key]["ting_readurl"] = gxl_data_url("ting", $value["ting_id"], $value["ting_cid"], $value["ting_name"], 1, $value["ting_jumpurl"], $value["ting_letters"]);
				$year_tinglist[$key]["actor_name"] = $actorting[$key]["actor_name"];
				$year_tinglist[$key]["actor_url"] = gxl_actor_url("role", $value["ting_cid"], $value["ting_id"], $value["ting_letters"], $actorting[$key]["actor_id"], 1);
				$year_tinglist[$key]["actor_pic"] = gxl_img_url($actorting[$key]["actor_pic"]);
			}

			$this->assign("year_tinglist", $year_tinglist);
			$this->assign($array_actor["role"]);
			$this->assign($array_detail["show"]);
			$this->assign($array_detail["read"]);
			$this->assign($array_detail["story"]);
			$this->assign($array_detail["actor"]);
			$this->assign("thisurl", gxl_actor_url("role", $array_detail["read"]["ting_cid"], $array_detail["read"]["ting_id"], $array_detail["read"]["ting_letters"], $id, 1));
			$this->display("gxl_role");
		}
		else {
			header("HTTP/1.0 404 Not Found");
			header("status: 404 not found");
			$this->display("my_404");
			exit();
		}
	}

	private function get_cache_detail($ting_id)
	{
		if (!$ting_id) {
			return false;
		}

		if (C("data_cache_ting")) {
			$array_detail = S("data_cache_ting_" . $ting_id);

			if ($array_detail) {
				return $array_detail;
			}
		}

		$where = array();
		$where["ting_id"] = $ting_id;
		$where["ting_cid"] = array("gt", 0);
		$where["ting_status"] = array("eq", 1);
		$rs = D("Ting");
		$array = $rs->where($where)->relation(array("Tag", "Mcid", "Story", "Actor"))->find();

		if ($array) {
			$array_detail = $this->Lable_Ting_Read($array);

			if (C("data_cache_ting")) {
				S("data_cache_ting_" . $ting_id, $array_detail, intval(C("data_cache_ting")));
			}

			return $array_detail;
		}

		return false;
	}
}


