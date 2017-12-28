<?php

namespace Admin\Action;
use Common\Action\BaseAction;
class CacheAction extends BaseAction
{
	public function show()
	{
		$this->display("./Public/admin/cache_show.html");
	}

	public function del()
	{
		$dir = new \Org\Net\Dir();
		$this->ppting_list();
		@unlink("./Runtime/common~runtime.php");

		if (!$dir->isEmpty("./Runtime/Data/_fields")) {
			$dir->del("./Runtime/Data/_fields");
		}

		if (!$dir->isEmpty("./Runtime/Temp")) {
			$dir->delDir("./Runtime/Temp");
		}

		if (!$dir->isEmpty("./Runtime/Cache")) {
			$dir->delDir("./Runtime/Cache");
		}

		if (!$dir->isEmpty("./Runtime/Logs")) {
			$dir->delDir("./Runtime/Logs");
		}

		echo "清除成功";
	}

	public function delhtml()
	{
		$id = $_GET["id"];
		$dir = new \Org\Net\Dir();

		if ("index" == $id) {
			@unlink(HTML_PATH . "index" . C("html_file_suffix"));
		}
		else if ("tinglist" == $id) {
			if (is_dir(HTML_PATH . "Ting_show")) {
				$dir->delDir(HTML_PATH . "Ting_show");
			}
		}
		else if ("tingread" == $id) {
			if (is_dir(HTML_PATH . "Ting_read")) {
				$dir->delDir(HTML_PATH . "Ting_read");
			}
		}
		else if ("tingplay" == $id) {
			if (is_dir(HTML_PATH . "Ting_play")) {
				$dir->delDir(HTML_PATH . "Ting_play");
			}
		}
		else if ("newslist" == $id) {
			if (is_dir(HTML_PATH . "News_show")) {
				$dir->delDir(HTML_PATH . "News_show");
			}
		}
		else if ("newsread" == $id) {
			if (is_dir(HTML_PATH . "News_read")) {
				$dir->delDir(HTML_PATH . "News_read");
			}
		}
		else if ("ajax" == $id) {
			if (is_dir(HTML_PATH . "My_show")) {
				$dir->delDir(HTML_PATH . "My_show");
			}

			if (is_dir(HTML_PATH . "Ajax_show")) {
				$dir->delDir(HTML_PATH . "Ajax_show");
			}
		}
		else if ("speciallist" == $id) {
			if (is_dir(HTML_PATH . "Special_show")) {
				$dir->delDir(HTML_PATH . "Special_show");
			}
		}
		else if ("specialread" == $id) {
			if (is_dir(HTML_PATH . "Special_read")) {
				$dir->delDir(HTML_PATH . "Special_read");
			}
		}
		else if ("starlist" == $id) {
			if (is_dir(HTML_PATH . "Star_show")) {
				$dir->delDir(HTML_PATH . "Star_show");
			}
		}
		else if ("starread" == $id) {
			if (is_dir(HTML_PATH . "Star_read")) {
				$dir->delDir(HTML_PATH . "Star_read");
			}
		}
		else if ("starhz" == $id) {
			if (is_dir(HTML_PATH . "Star_hz")) {
				$dir->delDir(HTML_PATH . "Star_hz");
			}
		}
		else if ("starwork" == $id) {
			if (is_dir(HTML_PATH . "Star_work")) {
				$dir->delDir(HTML_PATH . "Star_work");
			}
		}
		else if ("actorshow" == $id) {
			if (is_dir(HTML_PATH . "Actor_show")) {
				$dir->delDir(HTML_PATH . "Actor_show");
			}
		}
		else if ("actorshow" == $id) {
			if (is_dir(HTML_PATH . "Actorread")) {
				$dir->delDir(HTML_PATH . "Actor_read");
			}
		}
		else if ("actoroler" == $id) {
			if (is_dir(HTML_PATH . "Actor_role")) {
				$dir->delDir(HTML_PATH . "Actor_role");
			}
		}
		else if ("storyread" == $id) {
			if (is_dir(HTML_PATH . "Story_read")) {
				$dir->delDir(HTML_PATH . "Story_read");
			}
		}
		else if ("storyshow" == $id) {
			if (is_dir(HTML_PATH . "Story_show")) {
				$dir->delDir(HTML_PATH . "Story_show");
			}
		}
		else if ("day" == $id) {
			$this->delhtml_day();
		}
		else {
			@unlink(HTML_PATH . "index" . C("html_file_suffix"));

			if (is_dir(HTML_PATH . "Ting_show")) {
				$dir->delDir(HTML_PATH . "Ting_show");
			}

			if (is_dir(HTML_PATH . "Ting_read")) {
				$dir->delDir(HTML_PATH . "Ting_read");
			}

			if (is_dir(HTML_PATH . "Ting_play")) {
				$dir->delDir(HTML_PATH . "Ting_play");
			}

			if (is_dir(HTML_PATH . "News_show")) {
				$dir->delDir(HTML_PATH . "News_show");
			}

			if (is_dir(HTML_PATH . "News_read")) {
				$dir->delDir(HTML_PATH . "News_read");
			}

			if (is_dir(HTML_PATH . "My_show")) {
				$dir->delDir(HTML_PATH . "My_show");
			}

			if (is_dir(HTML_PATH . "Special_read")) {
				$dir->delDir(HTML_PATH . "Special_read");
			}

			if (is_dir(HTML_PATH . "Ajax_show")) {
				$dir->delDir(HTML_PATH . "Ajax_show");
			}

			if (is_dir(HTML_PATH . "Star_read")) {
				$dir->delDir(HTML_PATH . "Star_read");
			}

			if (is_dir(HTML_PATH . "Star_show")) {
				$dir->delDir(HTML_PATH . "Star_show");
			}

			if (is_dir(HTML_PATH . "Star_hz")) {
				$dir->delDir(HTML_PATH . "Star_hz");
			}

			if (is_dir(HTML_PATH . "Star_work")) {
				$dir->delDir(HTML_PATH . "Star_work");
			}

			if (is_dir(HTML_PATH . "Actor_show")) {
				$dir->delDir(HTML_PATH . "Actor_show");
			}

			if (is_dir(HTML_PATH . "Actor_read")) {
				$dir->delDir(HTML_PATH . "Actor_read");
			}

			if (is_dir(HTML_PATH . "Actor_role")) {
				$dir->delDir(HTML_PATH . "Actor_role");
			}

			if (is_dir(HTML_PATH . "Story_read")) {
				$dir->delDir(HTML_PATH . "Story_read");
			}

			if (is_dir(HTML_PATH . "Story_show")) {
				$dir->delDir(HTML_PATH . "Story_show");
			}
		}

		echo "清除成功";
	}

	public function delhtml_day()
	{
		$where = array();
		$where["ting_addtime"] = array("gt", getxtime(1));
		$rs = D("Ting");
		$array = $rs->field("ting_id")->where($where)->order("ting_id desc")->select();

		if ($array) {
			foreach ($array as $key => $val ) {
				$id = md5($array[$key]["ting_id"]) . C("html_file_suffix");
				@unlink(HTML_PATH . "/Ting_read/" . get_small_id($array[$key]["ting_id"]) . "/" . $id);
				@unlink(HTML_PATH . "/Ting_play/" . $array[$key]["ting_id"] . "/" . $id);
				delmulu(HTML_PATH . "/Story_read/" . get_small_id($array[$key]["ting_id"]) . "/" . $array[$key]["ting_id"] . "/");
				@unlink(HTML_PATH . "/Actor_read/" . get_small_id($array[$key]["ting_id"]) . "/" . $id);
			}

			$dir = new \Org\Net\Dir();

			if (!$dir->isEmpty(HTML_PATH . "/Ting_show")) {
				$dir->delDir(HTML_PATH . "/Ting_show");
			}

			if (!$dir->isEmpty(HTML_PATH . "/My_show")) {
				$dir->delDir(HTML_PATH . "/My_show");
			}

			if (is_dir(HTML_PATH . "Ajax_show")) {
				$dir->delDir(HTML_PATH . "Ajax_show");
			}

			@unlink(HTML_PATH . "/Html/index" . C("html_file_suffix"));
		}

		echo "清除成功";
	}

	public function dataclear()
	{
		if ((C("data_cache_type") == "memcache") || (C("data_cache_type") == "xcache")) {
			$cache = \Think\Cache::getInstance();
			$cache->clear();
		}
		else {
			$dir = new \Org\Net\Dir();

			if (!$dir->isEmpty(TEMP_PATH)) {
				$dir->delDir(TEMP_PATH);
			}
		}

		echo "清除成功";
	}

	public function dataforeach()
	{
		$config_old = require "./Runtime/Conf/config.php";
		$config_new = array_merge($config_old, array("data_cache_foreach" => uniqid()));
		arr2file("./Runtime/Conf/config.php", $config_new);
		@unlink("./Runtime/common~runtime.php");
		echo "清除成功";
	}

	public function datadayting()
	{
		$where = array();
		$where["ting_addtime"] = array("gt", getxtime(1));
		$rs = M("Ting");
		$array = $rs->field("ting_id")->where($where)->order("ting_id desc")->select();

		foreach ($array as $key => $val ) {
			S("data_cache_ting_" . $val["ting_id"], NULL);
		}

		echo "清除成功";
	}

	public function datadaystar()
	{
		$where = array();
		$where["star_addtime"] = array("gt", getxtime(1));
		$rs = M("Star");
		$array = $rs->field("star_id")->where($where)->order("star_id desc")->select();

		foreach ($array as $key => $val ) {
			S("data_cache_star_" . $val["star_id"], NULL);
		}

		echo "清除成功";
	}

	public function datadaynews()
	{
		$where = array();
		$where["news_addtime"] = array("gt", getxtime(1));
		$rs = M("News");
		$array = $rs->field("news_id")->where($where)->order("news_id desc")->select();

		foreach ($array as $key => $val ) {
			S("data_cache_news_" . $val["news_id"], NULL);
		}

		echo "清除成功";
	}

	public function datadayspecial()
	{
		$where = array();
		$where["special_addtime"] = array("gt", getxtime(1));
		$rs = M("Special");
		$array = $rs->field("special_id")->where($where)->order("special_id desc")->select();

		foreach ($array as $key => $val ) {
			S("data_cache_special_" . $val["special_id"], NULL);
		}

		echo "清除成功";
	}
}


