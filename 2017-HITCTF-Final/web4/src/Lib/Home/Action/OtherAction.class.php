<?php

namespace Home\Action;
use Common\Action\HomeAction;
class OtherAction extends HomeAction
{
	public function tingid()
	{
		$where = array();
		$rs = D("Ting");
		$where["ting_id"] = array("in", $_REQUEST["id"]);
		$where["ting_cid"] = array("gt", 0);
		$where["ting_status"] = 1;
		$array = $rs->where($where)->relation(true)->select();

		if ($array) {
			foreach ($array as $value ) {
				$this->ting_read_create($value);
			}
		}
	}

	public function ting_read_create($array)
	{
		$arrays = $this->Lable_Ting_Read($array);
		$this->assign($arrays["show"]);
		$this->assign($arrays["read"]);
		$videodir = gxl_data_url_dir("ting", $arrays["read"]["ting_id"], $arrays["read"]["ting_cid"], $arrays["read"]["ting_name"], 1, $arrays["read"]["ting_pyname"]);
		$filename = $_SERVER["DOCUMENT_ROOT"] . "/" . $videodir . ".html";
		$this->buildHtml($videodir, "./", $arrays["read"]["ting_skin"]);
		ob_flush();
		flush();
	}

	public function gettag()
	{
		$title = $_POST["title"];
		$content = $_POST["content"];
		echo gxl_tag_auto($title, $content);
	}
}


