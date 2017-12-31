<?php
namespace Common\Model;
use Think\Model\AdvModel;
class PrtyModel extends AdvModel
{
	public function prty_update($id, $prty)
	{
		$rs = M("Prty");
		$data["prty_id"] = $id;
		$rs->where($data)->delete();
		$prty_arr = explode(",", $prty);
		$prty_arr = array_unique($prty_arr);

		foreach ($prty_arr as $key => $val ) {
			$data["prty_cid"] = $val;
			$rs->data($data)->add();
		}
	}
}


