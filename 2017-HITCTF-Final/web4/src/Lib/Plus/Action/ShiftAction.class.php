<?php
namespace Plus\Action;
use Common\Action\BaseAction;
class ShiftAction extends BaseAction
{
	public function Pinying()
	{
		$rs = M("Ting");
		$limit = C("url_num_admin");
		$list = $rs->field("ting_id,ting_name,ting_letters")->where("ting_letters is NULL")->order("ting_id desc")->limit($limit)->select();

		foreach ($list as $key => $value ) {
			$letterss = $rs->where("ting_id = " . $value["ting_id"])->getField("ting_letters");

			if ($letterss) {
				dump($value["ting_id"] . " 已有拼音跳过");
			}
			else {
				$_POST["ting_letters"] = tingletters($value["ting_name"]);
				$edit = array();
				$edit["ting_id"] = $value["ting_id"];
				$edit["ting_letters"] = $_POST["ting_letters"];
				$rs->data($edit)->save();
				echo ($key + 1) . "作品ID：" . $value["ting_id"] . "  作品名称：" . $value["ting_name"] . " 生成拼音：" . $_POST["ting_letters"] . "  成功！<br />";
			}
		}

		$listt = $rs->where("ting_letters is NULL")->count();

		if (0 < $listt) {
			$this->redirect("Plus-shift/pinying", array(), 5, "还有" . $listt . "个作品需要生成,为了减小服务器压力，5秒后进行下一次操作~");
		}
		else {
			dump("生成作品拼音完成");
		}
	}

	public function actors()
	{
		$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);

		if ($currentpage == 1) {
			$jumpurl = F("_Shift/jumpurl_actors");

			if ($jumpurl) {
				header("Location: " . $jumpurl);
			}
		}

		$rs = D("Ting");
		$rst = D("Actors");
		$count = $rs->count("ting_id");
		$totalpages = ceil($count / 1000);
		$list = $rs->field("ting_id,ting_name,ting_content,ting_actor,ting_director,ting_cid")->order("ting_addtime desc")->limit(1000)->page($currentpage)->select();

		foreach ($list as $key => $value ) {
			$actors = $rst->where("actors_id = " . $value["ting_id"])->find();

			if ($actors) {
				dump($value["ting_id"] . " 已有演员导演跳过");
			}
			else {
				$actorarray = $value["ting_actor"];
				$directorarray = $value["ting_director"];

				if ($actorarray) {
					$actorarray_arr = explode(",", str_replace(array("/", "|", " ", "，", "、"), ",", $actorarray));
					$actorarray_arr = array_filter(array_unique($actorarray_arr));

					foreach ($actorarray_arr as $value2 ) {
						$rst->data(array("actors_id" => $value["ting_id"], "actors_type" => 1, "actors_name" => $value2))->add();
						dump($rst->getLastSql());
					}
				}

				if ($directorarray) {
					$directorarray_arr = explode(",", str_replace(array("/", "|", " ", "，", "、"), ",", $directorarray));
					$directorarray_arr = array_filter(array_unique($directorarray_arr));

					foreach ($directorarray_arr as $value3 ) {
						$rst->data(array("actors_id" => $value["ting_id"], "actors_type" => 2, "actors_name" => $value3))->add();
						dump($rst->getLastSql());
					}
				}
			}
		}

		if ($currentpage < $totalpages) {
			echo $actorarray;
			F("_actors/jumpurl_ting", "?s=plus-shift-actors-p-" . ($currentpage + 1));
			$this->redirect("Plus-Shift/actors", array("p" => $currentpage + 1), 3, "减小服务器压力，3秒后进行下一次操作~");
		}
		else {
			F("_Shift/jumpurl_actors", NULL);
			dump("完成");
		}
	}

	public function prty()
	{
		$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);

		if ($currentpage == 1) {
			$jumpurl = F("_Shift/jumpurl_prty");

			if ($jumpurl) {
				header("Location: " . $jumpurl);
			}
		}

		$where["ting_prty"] = array("neq", "");
		$rs = D("Ting");
		$rst = D("Prty");
		$count = $rs->where($where)->count("ting_id");
		$totalpages = ceil($count / 10);
		$list = $rs->where($where)->field("ting_id,ting_name,ting_content,ting_prty,ting_cid")->order("ting_addtime desc")->limit(10)->page($currentpage)->select();

		foreach ($list as $key => $value ) {
			$prtys = $rst->where("prty_id = " . $value["ting_id"])->find();

			if ($prtys) {
				dump($value["ting_id"] . " 已添加了属性");
			}
			else {
				$prtyarry = $value["ting_prty"];

				if ($prtyarry) {
					$prtyarry_arr = explode(",", $prtyarry);

					foreach ($prtyarry_arr as $value2 ) {
						$rst->data(array("prty_id" => $value["ting_id"], "prty_cid" => $value2))->add();
						dump($rst->getLastSql());
					}
				}
			}
		}

		if ($currentpage < $totalpages) {
			echo $prtyarry;
			F("_Shift/jumpurl_prty", "?s=plus-shift-prty-p-" . ($currentpage + 1));
			$this->redirect("Plus-Shift/prty", array("p" => $currentpage + 1), 3, "减小服务器压力，3秒后进行下一次操作~");
		}
		else {
			F("_Shift/jumpurl_prty", NULL);
			dump("完成");
		}
	}

	public function weekday()
	{
		$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);

		if ($currentpage == 1) {
			$jumpurl = F("_Shift/jumpurl_weekday");

			if ($jumpurl) {
				header("Location: " . $jumpurl);
			}
		}

		$where["ting_weekday"] = array("neq", "0");
		$rs = D("Ting");
		$rst = D("Weekday");
		$count = $rs->where($where)->count("ting_id");
		$totalpages = ceil($count / 10);
		$list = $rs->field("ting_id,ting_name,ting_content,ting_weekday,ting_cid")->order("ting_addtime desc")->where($where)->limit(10)->page($currentpage)->select();

		foreach ($list as $key => $value ) {
			$weekdays = $rst->where("weekday_id = " . $value["ting_id"])->find();

			if ($weekdays) {
				dump($value["ting_id"] . " 已添加了周期");
			}
			else {
				$weekdayarry = $value["ting_weekday"];

				if ($weekdayarry) {
					$weekdayarry_arr = explode(",", $weekdayarry);

					foreach ($weekdayarry_arr as $value2 ) {
						$rst->data(array("weekday_id" => $value["ting_id"], "weekday_cid" => $value2))->add();
						dump($rst->getLastSql());
					}
				}
			}
		}

		if ($currentpage < $totalpages) {
			echo $weekdayarry;
			F("_Shift/jumpurl_weekday", "?s=plus-shift-weekday-p-" . ($currentpage + 1));
			$this->redirect("Plus-Shift/weekday", array("p" => $currentpage + 1), 3, "减小服务器压力，3秒后进行下一次操作~");
		}
		else {
			F("_Shift/jumpurl_weekday", NULL);
			dump("完成");
		}
	}

	public function urls()
	{
		$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);

		if ($currentpage == 1) {
			$jumpurl = F("_Shift/jumpurl_urls");

			if ($jumpurl) {
				header("Location: " . $jumpurl);
			}
		}

		$rs = D("Ting");
		$rst = D("Urls");
		$count = $rs->count("ting_id");
		$totalpages = ceil($count / 1000);
		$list = $rs->field("ting_id,ting_name,ting_content,ting_actor,ting_director,ting_cid,ting_reurl")->order("ting_addtime desc")->limit(1000)->page($currentpage)->select();

		foreach ($list as $key => $value ) {
			$actors = $rst->where("ting_id = " . $value["ting_id"])->find();
			$urlsarray = $value["ting_reurl"];

			if ($urlsarray) {
				$urlsarray = explode(",", str_replace(array("|", " ", "，", "、"), ",", $urlsarray));
				$urlsarray = array_filter(array_unique($urlsarray));

				foreach ($urlsarray as $values ) {
					$rst->where(array("ting_id" => $value["ting_id"], "ting_urls" => $values))->delete();
					$rst->data(array("ting_id" => $value["ting_id"], "ting_urls" => $values))->add();
					dump($rst->getLastSql());
				}
			}
		}

		if ($currentpage < $totalpages) {
			F("_actors/jumpurl_ting", "?s=plus-shift-urls-p-" . ($currentpage + 1));
			$this->redirect("Plus-Shift/urls", array("p" => $currentpage + 1), 3, "减小服务器压力，3秒后进行下一次操作~");
		}
		else {
			F("_Shift/jumpurl_urls", NULL);
			dump("完成");
		}
	}

	public function tingtv()
	{
		$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);

		if ($currentpage == 1) {
			$jumpurl = F("_Shift/jumpurl_tingtv");

			if ($jumpurl) {
				header("Location: " . $jumpurl);
			}
		}

		$where["ting_diantai"] = array("neq", "");
		$rs = D("Ting");
		$rst = D("Tingtv");
		$count = $rs->where($where)->count("ting_id");
		$totalpages = ceil($count / 100);
		$list = $rs->where($where)->field("ting_id,ting_name,ting_content,ting_diantai,ting_cid")->order("ting_addtime desc")->limit(100)->page($currentpage)->select();

		foreach ($list as $key => $value ) {
			$tingtvs = $rst->where("tingtv_id = " . $value["ting_id"])->find();

			if ($tingtvs) {
				dump($value["ting_id"] . " 已添加了周期");
			}
			else {
				$tingtvarry = $value["ting_diantai"];

				if ($tingtvarry) {
					$tingtvarry_arr = explode(",", $tingtvarry);

					foreach ($tingtvarry_arr as $value2 ) {
						$rst->data(array("tingtv_id" => $value["ting_id"], "tingtv_name" => $value2))->add();
						dump($rst->getLastSql());
					}
				}
			}
		}

		if ($currentpage < $totalpages) {
			echo $tingtvarry;
			F("_Shift/jumpurl_tingtv", "?s=plus-shift-tingtv-p-" . ($currentpage + 1));
			$this->redirect("Plus-Shift/tingtv", array("p" => $currentpage + 1), 3, "减小服务器压力，3秒后进行下一次操作~");
		}
		else {
			F("_Shift/jumpurl_tingtv", NULL);
			dump("完成");
		}
	}
}


