<?php

namespace Home\Action;
use Common\Action\HomeAction;
class HitsAction extends HomeAction
{
	public function show()
	{
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$sid = trim(I("get.sid", "", "strip_tags,htmlspecialchars"));
		$type = trim(I("get.type", "", "strip_tags,htmlspecialchars"));

		if (in_array($sid, array("ting", "star", "story", "special", "news", "actor"))) {
			$where[$sid . "_id"] = $id;
			$rs = M(ucfirst($sid));
			$array = $rs->field($sid . "_id," . $sid . "_hits," . $sid . "_hits_month," . $sid . "_hits_week," . $sid . "_hits_day," . $sid . "_addtime," . $sid . "_hits_lasttime")->where($where)->find();

			if ($type == "insert") {
				$this->hits_insert($sid, $array);
			}
			else if ($array) {
				echo "document.write('" . $array[$type] . "');";
			}
			else {
				echo "document.write('0');";
			}
		}
	}

	public function story()
	{
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$where["story_vid"] = $id;
		$rs = M("Story");
		$array = $rs->field("story_id,story_vid,story_hits,story_hits_lasttime")->where($where)->find();
		$hits["story_hits"] = $array["story_hits"];
		$new = getdate();
		$old = getdate($array["story_hits_lasttime"]);
		$weekStart = mktime(0, 0, 0, $new["mon"], $new["mday"], $new["year"]) - ($new["wday"] * 86400);
		$weekEnd = mktime(23, 59, 59, $new["mon"], $new["mday"], $new["year"]) + ((6 - $new["wday"]) * 86400);
		if (($weekStart <= $array["story_hits_lasttime"]) && ($array["story_hits_lasttime"] <= $weekEnd)) {
			$hits["story_hits"]++;
		}
		else {
			$hits["story_hits"] = 1;
		}

		$hits["story_id"] = $array["story_id"];
		$hits["story_hits_lasttime"] = time();
		$rs->save($hits);
		return $hits;
	}

	public function hits_insert($sid, $array)
	{
		$hits[$sid . "_hits"] = $array[$sid . "_hits"];
		$hits[$sid . "_hits_month"] = $array[$sid . "_hits_month"];
		$hits[$sid . "_hits_week"] = $array[$sid . "_hits_week"];
		$hits[$sid . "_hits_day"] = $array[$sid . "_hits_day"];
		$new = getdate();
		$old = getdate($array[$sid . "_hits_lasttime"]);
		if (($new["year"] == $old["year"]) && ($new["mon"] == $old["mon"])) {
			$hits[$sid . "_hits_month"]++;
		}
		else {
			$hits[$sid . "_hits_month"] = 1;
		}

		$weekStart = mktime(0, 0, 0, $new["mon"], $new["mday"], $new["year"]) - ($new["wday"] * 86400);
		$weekEnd = mktime(23, 59, 59, $new["mon"], $new["mday"], $new["year"]) + ((6 - $new["wday"]) * 86400);
		if (($weekStart <= $array[$sid . "_hits_lasttime"]) && ($array[$sid . "_hits_lasttime"] <= $weekEnd)) {
			$hits[$sid . "_hits_week"]++;
		}
		else {
			$hits[$sid . "_hits_week"] = 1;
		}

		if (($new["year"] == $old["year"]) && ($new["mon"] == $old["mon"]) && ($new["mday"] == $old["mday"])) {
			$hits[$sid . "_hits_day"]++;
		}
		else {
			$hits[$sid . "_hits_day"] = 1;
		}

		$hits[$sid . "_id"] = $array[$sid . "_id"];
		$hits[$sid . "_hits"] = $hits[$sid . "_hits"] + 1;
		$hits[$sid . "_hits_lasttime"] = time();
		$rs = M(ucfirst($sid));
		$rs->save($hits);
		return $hits;
	}
}


