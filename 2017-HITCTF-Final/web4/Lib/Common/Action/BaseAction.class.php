<?php
namespace Common\Action;
use Common\Action\AllAction;

class BaseAction extends AllAction
{
	public function _initialize()
	{
		parent::_initialize();

		if (!$_SESSION[C("USER_AUTH_KEY")]) {
			$this->assign("jumpUrl", C("cms_admin") . "?s=Admin-Login");
			$this->error("对不起，您还没有登录，请先登录！");
		}

		if (!in_array(strtolower(ACTION_NAME), explode(",", C("NOT_AUTH_ACTION")))) {
			$model_id = array_search(CONTROLLER_NAME, explode(",", C("REQUIRE_AUTH_MODULE")));

			if (is_int($model_id)) {
				$usertype = explode(",", $_SESSION["admin_ok"]);

				if (!$usertype[$model_id]) {
					$this->error("对不起，您没有管理该模块的权限，请联系超级管理员授权！");
				}
			}
		}
	}

	public function ppting_play()
	{
		$this->assign("countemplateayer", count(C("PP_PLAYER")));
		$this->assign("playtree", C("play_player"));
	}

	public function ppting_list()
	{
		$rs = D("List");
		$where["list_status"] = array("eq", 1);
		$list = $rs->where($where)->order("list_oid asc")->select();

		foreach ($list as $key => $val ) {
			if ($list[$key]["list_sid"] == 9) {
				$list[$key]["list_url"] = $list[$key]["list_jumpurl"];
				$list[$key]["list_url_big"] = $list[$key]["list_jumpurl"];
			}
			else {
				if (C("url_rewrite")) {
					$list[$key]["list_url"] = gxl_list_url(getsidname($list[$key]["list_sid"]), array("id" => $list[$key]["list_id"], "listdir" => $list[$key]["list_dir"]), 1);
					$list[$key]["list_url_big"] = gxl_list_url(getsidname($list[$key]["list_sid"]), array("id" => $list[$key]["list_pid"], "listdir" => gelistdir_id($list[$key]["list_pid"])), 1);
				}
				else {
					$list[$key]["list_url"] = gxl_list_url(getsidname($list[$key]["list_sid"]), array("id" => $list[$key]["list_id"]), 1);
					$list[$key]["list_url_big"] = gxl_list_url(getsidname($list[$key]["list_sid"]), array("id" => $list[$key]["list_pid"]), 1);
				}

				$list[$key]["list_name_big"] = getlistname($list[$key]["list_pid"]);

				if ($list[$key]["list_sid"] == 1) {
					$list[$key]["list_limit"] = gettemplatenum("gxl_sql_ting\('(.*)'\)", $list[$key]["list_skin"]);
				}
			
				else {
					$list[$key]["list_limit"] = gettemplatenum("gxl_sql_news\('(.*)'\)", $list[$key]["list_skin"]);
				}
			}
		}

		$condition = array("list_pid" => 0, "list_sid" => 1);
		$tree = M("List")->where($condition)->field("list_id,list_name,list_oid")->order("list_oid asc")->select();

		foreach ($tree as $k => $v ) {
			$tree[$k]["son"] = D("Mcat")->list_cat($v["list_id"]);
			$tree[$k]["total"] = ($tree[$k]["son"] == null ? 0 : count($tree[$k]["son"]));
		}

		$mcat_mcid = M("Mcat")->order("m_cid asc")->select();

		foreach ($tree as $k => $v ) {
			$mcat_mcid[$k]["son"] = $mcat_mcid[0]["m_cid"];
		}

		F("_ppting/mcat", $tree);
		F("_ppting/mcid", $mcat_mcid);
		F("_ppting/list", $list);
		F("_ppting/listtree", list_to_tree($list, "list_id", "list_pid", "son", 0));
		$where["list_sid"] = array("EQ", 1);
		$list = $rs->where($where)->order("list_oid asc")->select();
		F("_ppting/listting", list_to_tree($list, "list_id", "list_pid", "son", 0));
		$where["list_sid"] = array("EQ", 2);
		$list = $rs->where($where)->order("list_oid asc")->select();
		F("_ppting/listnews", list_to_tree($list, "list_id", "list_pid", "son", 0));
	
		
	}
}


