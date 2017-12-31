<?php
namespace Home\Action;
use Common\Action\HomeAction;
class GoldAction extends HomeAction
{
	public function ting()
	{
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$type = trim(I("get.type", "", "strip_tags,htmlspecialchars"));

		if ($id < 1) {
			$data["data"] = "数据非法";
			$data["info"] = "-1";
			$data["status"] = "-1";
			$this->ajaxReturn($data);
		}

		$this->show($id, $type, "ting");
	}

	public function news()
	{
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$type = trim(I("get.type", "", "strip_tags,htmlspecialchars"));

		if ($id < 1) {
			$data["data"] = "数据非法";
			$data["info"] = "-1";
			$data["status"] = "-1";
			$this->ajaxReturn($data);
		}

		$this->show($id, $type, "news");
	}

	public function show($id, $type, $model = "ting")
	{
		$rs = D(ucfirst($model));
		$array = $rs->field("" . $model . "_gold," . $model . "_golder")->find($id);

		if ($array) {
			if ($type) {
				$cookie = $model . "-gold-" . $id;

				if (isset($_COOKIE[$cookie])) {
					$data["data"] = "您已评分！";
					$data["info"] = 0;
					$data["status"] = 0;
					$this->ajaxReturn($data);
				}

				$array[$model . "_gold"] = number_format((($array[$model . "_gold"] * $array[$model . "_golder"]) + $type) / ($array[$model . "_golder"] + 1), 1);
				$array[$model . "_golder"] = $array[$model . "_golder"] + 1;
				$rs->where($model . "_id = " . $id)->save($array);
				setcookie($cookie, "t", time() + intval(C("user_second")));
			}
			else {
				$array = $array;
			}
		}
		else {
			$array[$model . "_gold"] = 0;
			$array[$model . "_golder"] = 0;
		}

		$this->ajaxReturn($array[$model . "_gold"] . ":" . $array[$model . "_golder"], "感谢您的参与，评分成功！", 1);
	}
}


