<?php

namespace Plus\Action;
use Common\Action\BaseAction;
class MyAction extends BaseAction
{
	public function statusall()
	{
		if (empty($_POST["ids"])) {
			$this->error("请选择需要审核的作品！");
		}

		$rs = D("Ting");
		$array = $_POST["ids"];

		foreach ($array as $val ) {
			$where["ting_id"] = $val;
			$rs->where($where)->setField("ting_status", 1);
		}

		redirect("?s=Admin-Ting-Show-status-3");
	}
}


