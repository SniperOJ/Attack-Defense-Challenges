<?php
namespace Home\Action;
use Common\Action\HomeAction;
class ShowlistAction extends HomeAction
{
	public function show()
	{
		$dir = I("get.dir", "none", "strip_tags,htmlspecialchars");
		$Url = gxl_param_url();

		if ($dir != "none") {
			$Url["id"] = get_id_by_dir($dir);
		}

		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl["p"] = "{!page!}";
		C("jumpurl", UU("Home-ting/type", $JumpUrl, true, false));
		C("currentpage", $Url["page"]);
		$List = list_search(F("_ppting/list"), "list_id=" . $Url["id"]);
		$channel = $this->Lable_Ting_List($Url, $List[0]);
		$this->assign($channel);
		$channel["list_skin"] = "gxl_ajaxlist";
		$this->display($channel["list_skin"]);
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
		$array = $rs->where($where)->relation("Tag")->find();

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


