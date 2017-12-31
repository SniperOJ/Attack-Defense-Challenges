<?php

namespace Common\Model;
use Think\Model\AdvModel;
class ActorsModel extends AdvModel
{
	public function actors_update($id, $actors, $type)
	{
		$rs = M("Actors");
		$data["actors_id"] = $id;
		$data["actors_type"] = $type;
		$rs->where($data)->delete();
		$actors_arr = explode(",", str_replace(array("/", "|", " ", "，", "、"), ",", $actors));
		$actors_arr = array_filter(array_unique($actors_arr));

		foreach ($actors_arr as $key => $val ) {
			$data["actors_name"] = $val;
			$rs->data($data)->add();
		}
	}
}


