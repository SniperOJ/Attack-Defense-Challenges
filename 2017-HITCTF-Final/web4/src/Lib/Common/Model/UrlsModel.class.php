<?php
namespace Common\Model;
use Think\Model\AdvModel;
class UrlsModel extends AdvModel
{
	public function urls_update($id, $url, $type)
	{
		$rs = M("Urls");
		$data["ting_id"] = $id;

		if (!empty($type)) {
			$rs->where($data)->delete();
		}

		$urls = explode(",", str_replace(array("|", " ", "，", "、"), ",", $url));
		$urls = array_filter(array_unique($urls));

		foreach ($urls as $key => $val ) {
			$data["ting_urls"] = $val;
			$rs->where($data)->delete();
			$rs->data($data)->add();
		}
	}
}


