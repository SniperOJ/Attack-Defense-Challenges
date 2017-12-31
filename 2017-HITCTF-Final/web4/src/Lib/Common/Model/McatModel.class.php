<?php
namespace Common\Model;
use Think\Model\AdvModel;
class McatModel extends AdvModel
{
	protected $_validate = array(
		array("m_order", "number", "排序ID必须为数字", 1),
		array("m_name", "require", "分类名称错误", 1)
		);

	public function list_cat($list_id)
	{
		$gxl_list = M("List")->where("list_id = $list_id")->field("list_pid")->find();
		if ($gxl_list && (0 < $gxl_list["list_pid"])) {
			$list_id = $gxl_list["list_pid"];
		}

		return M("Mcat")->where("m_list_id = $list_id")->order("m_order asc")->select();
	}

	public function getmcid($cid, $mcid)
	{
		$list_mod = M("list");
		$arr = $list_mod->where("list_id='$cid'")->field("list_pid")->find();

		if ($arr["list_pid"] == "0") {
			$condition = $cid;
		}
		else {
			$condition = $arr["list_pid"];
		}

		$mcat = M("mcat");
		$tagArr = array();
		$tag = array_unique(explode(",", trim($mcid)));

		foreach ($tag as $k => $v ) {
			$mcid = $mcat->where("m_name='$v' and m_list_id='$condition'")->getField("m_cid");

			if (!empty($mcid)) {
				$tagArr[] = $mcid;
			}
		}

		$ting_mcid = implode(",", $tagArr);
		return $ting_mcid;
	}
}


