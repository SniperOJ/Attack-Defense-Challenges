<?php
namespace Home\Action;
use Common\Action\HomeAction;
class PlayAction extends HomeAction
{
	public function index()
	{
		$name = I("get.name", "none", "strip_tags,htmlspecialchars");
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));

		if ($name != "none") {
			$id = get_id_by_name($name);
		}

		$array_detail = $this->get_cache_detail($id);
		$array["ting_playlist"] = $this->gxl_playlist_all($array_detail["read"]);
		$player_dir = gxl_play_url_dir($array_detail["read"]["ting_id"], 0, 1, $array_detail["read"]["ting_cid"], $array_detail["read"]["ting_name"]);
		$players = "var gxl_urls='" . $this->gxl_playlist_json(array($array_detail["read"]["ting_name"], $array_detail["show"]["list_name"], $array_detail["show"]["list_url"]), $array["ting_playlist"]) . "';";
		header("Pragma: public");
		header("Expires: 0");
		header("Content-Type: application/download");
		header("Content-Type:application/x-javascript; charset=utf-8");
		header("Content-Disposition: attachment;filename=play.js");
		exit($players);
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


