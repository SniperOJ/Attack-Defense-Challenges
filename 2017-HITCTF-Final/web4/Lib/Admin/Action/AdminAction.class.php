<?php

namespace Admin\Action;
use Common\Action\BaseAction;
class AdminAction extends BaseAction{
	public function show()
	{
		$rs = D("Admin");
		$list = $rs->order("admin_logintime desc")->select();
		$this->assign("url_html_suffix", C("url_html_suffix"));
		$this->assign("html_file_suffix", C("html_file_suffix"));
		$this->assign("list", $list);
		$this->display("./Public/admin/admin_show.html");
	}

	public function add()
	{
		$array = array();
		$where["admin_id"] = $_GET["id"];
		$rs = D("Admin");
		$array = $rs->where($where)->find();
		$type = explode(",", $array["admin_ok"]);
		$this->assign("admin", $type);
		$this->assign($array);
		$this->display("./Public/admin/admin_add.html");
	}

	public function _before_insert()
	{
		$ok = $_POST["ids"];

		for ($i = 0; $i < 25; $i++) {
			if ($ok[$i]) {
				$rs[$i] = $ok[$i];
			}
			else {
				$rs[$i] = 0;
			}
		}

		$_POST["admin_ok"] = implode(",", $rs);
	}

	public function insert()
	{
		$rs = D("Admin");

		if ($rs->create()) {
			if (false !== $rs->add()) {
				$this->assign("jumpUrl", "?s=Admin-Admin-Show");
				$this->success("添加后台管理员成功！");
			}
			else {
				$this->error("添加后台管理员失败");
			}
		}
		else {
			$this->error($rs->getError());
		}
	}

	public function update()
	{
		$this->_before_insert();
		$rs = D("Admin");

		if ($rs->create()) {
			if (false !== $rs->save()) {
				$_SESSION["admin_ok"] = $_POST["admin_ok"];
				$this->assign("jumpUrl", "?s=Admin-Admin-Show");
				$this->success("更新管理员信息成功！");
			}
			else {
				$this->error("更新管理员信息失败！");
			}
		}
		else {
			$this->error($rs->getError());
		}
	}

	public function del()
	{
		$rs = D("Admin");
		$rs->where("admin_id=" . $_GET["id"])->delete();
		$this->success("删除后台管理员成功！");
	}

	public function delall()
	{
		$where["admin_id"] = array("in", implode(",", $_POST["ids"]));
		$rs = D("Admin");
		$rs->where($where)->delete();
		$this->success("批量删除后台管理员成功！");
	}

	public function config()
	{
		$template = C("VIEW_PATH") . "*";
		$list = glob($template);
		$usertemplate = C("USER_THEME_PATH") . "*";
		$ulist = glob($usertemplate);

		foreach ($list as $i => $file ) {
			$dir[$i]["filename"] = basename($file);
		}

		foreach ($ulist as $i => $file ) {
			$userdir[$i]["name"] = basename($file);
		}

		$this->assign("dir", $dir);
		$this->assign("userdir", $userdir);
		$config = require "./Runtime/Conf/config.php";
		$this->assign($config);
		$this->ppting_list();
		$this->display("./Public/admin/admin_conf.html");
	}

	public function configsave()
	{
		$config = $_POST["config"];
		$config["site_tongji"] = stripslashes($config["site_tongji"]);
		$config["play_collect_content"] = stripslashes($config["play_collect_content"]);
		$config["admin_time_edit"] = (bool) $config["admin_time_edit"];
		$config["url_tingdata"] = trim($config["url_tingdata"]);
		$config["url_newsdata"] = trim($config["url_newsdata"]);
		$config["upload_path"] = str_replace(array("..", "//"), "", $config["upload_path"]);
		$config["upload_class"] = trim(str_replace(array("php", "asp", "apsx", "txt", "asax", "ascx", "cdx", "cer", "cgi", "jsp", "html", "html", "htm", ",,"), "", strtolower($config["upload_class"])), ",");
		$config["upload_thumb"] = (bool) $config["upload_thumb"];
		$config["upload_water"] = (bool) $config["upload_water"];
		$config["upload_http"] = (bool) $config["upload_http"];
		$config["upload_ftp"] = (bool) $config["upload_ftp"];
		$config["play_collect"] = (bool) $config["play_collect"];
		$config["play_second"] = intval($config["play_second"]);
		$config["tmpl_cache_on"] = (bool) $config["tmpl_cache_on"];
		$config["html_cache_on"] = (bool) $config["html_cache_on"];
		$config["user_gbcm"] = (bool) $config["user_gbcm"];

		foreach (explode(chr(13), trim($config["play_server"])) as $v ) {
			list($key, $val) = explode("$\$\$", trim($v));
			$arrserver[trim($key)] = trim($val);
		}

		$config["play_server"] = $arrserver;

		foreach (explode(chr(13), trim($config["play_collect_content"])) as $v ) {
			$arrcollect[] = trim($v);
		}

		$config["play_collect_content"] = $arrcollect;
		$config["html_cache_time"] = $config["html_cache_time"] * 3600;

		if (0 < $config["html_cache_index"]) {
			$config["html_cache_rules"]["home:index:index"] = array("{:action}", $config["html_cache_index"] * 3600);
		}
		else {
			$config["html_cache_rules"]["home:index:index"] = NULL;
		}

		if (0 < $config["html_cache_list"]) {
			$config["html_cache_rules"]["home:ting:show"] = array("{:controller}_{:action}/{\$_SERVER.REQUEST_URI|md5}", $config["html_cache_list"] * 3600);
			$config["html_cache_rules"]["home:news:show"] = array("{:controller}_{:action}/{\$_SERVER.REQUEST_URI|md5}", $config["html_cache_list"] * 3600);
		}
		else {
			$config["html_cache_rules"]["home:ting:show"] = NULL;
			$config["html_cache_rules"]["home:news:show"] = NULL;
		}

		if (0 < $config["html_cache_content"]) {
			$config["html_cache_rules"]["home:ting:read"] = array("{:controller}_{:action}/{name|get_small_id_by_name}{id|get_small_id}/{name|gettingidmd}{id|getmd5}", $config["html_cache_content"] * 3600);
			$config["html_cache_rules"]["home:news:read"] = array("{:controller}_{:action}/{\$_SERVER.REQUEST_URI|md5}", $config["html_cache_content"] * 3600);
		}
		else {
			$config["html_cache_rules"]["home:ting:read"] = NULL;
			$config["html_cache_rules"]["home:news:read"] = NULL;
		}

		if (0 < $config["html_cache_play"]) {
			$config["html_cache_rules"]["home:ting:play"] = array("{:controller}_{:action}/{name|get_small_id_by_name}{id|get_small_id}/{name|gettingid}{id}/{\$_SERVER.REQUEST_URI|md5}", $config["html_cache_play"] * 3600);
		}
		else {
			$config["html_cache_rules"]["home:ting:play"] = NULL;
		}

		if (0 < $config["html_cache_ajax"]) {
			$config["html_cache_rules"]["home:my:show"] = array("{:controller}_{:action}/{\$_SERVER.REQUEST_URI|md5}", $config["html_cache_ajax"] * 3600);
			$config["html_cache_rules"]["home:special:read"] = array("{:controller}_{:action}/{\$_SERVER.REQUEST_URI|md5}", $config["html_cache_ajax"] * 3600);
		}
		else {
			$config["html_cache_rules"]["home:my:show"] = NULL;
			$config["html_cache_rules"]["home:special:read"] = NULL;
		}

		if (0 < $config["html_cache_juqing"]) {
			$config["html_cache_rules"]["home:story:read"] = array("{:controller}_{:action}/{name|get_small_id_by_name}{id|get_small_id}/{name|gettingid}{id}/{name|gettingidmd}{id|getmd5}{p}", $config["html_cache_juqing"] * 24 * 3600);
		}
		else {
			$config["html_cache_rules"]["home:story:read"] = NULL;
		}

		if (0 < $config["html_cache_story"]) {
			$config["html_cache_rules"]["home:story:show"] = array("{:controller}_{:action}/{dir|gediridmd}{id|getmd5}{p}", $config["html_cache_juqing"] * 3600);
		}
		else {
			$config["html_cache_rules"]["home:story:show"] = NULL;
		}

		if (0 < $config["html_cache_actorshow"]) {
			$config["html_cache_rules"]["home:actor:show"] = array("{:controller}_{:action}/{\$_SERVER.REQUEST_URI|md5}", $config["html_cache_actorshow"] * 3600);
		}
		else {
			$config["html_cache_rules"]["home:actor:show"] = NULL;
		}

		if (0 < $config["html_cache_actor"]) {
			$config["html_cache_rules"]["home:actor:read"] = array("{:controller}_{:action}/{name|get_small_id_by_name}{id|get_small_id}/{name|gettingidmd}{id|getmd5}", $config["html_cache_actor"] * 24 * 3600);
		}
		else {
			$config["html_cache_rules"]["home:actor:read"] = NULL;
		}
		if (0 == $config["url_html"]) {
			@unlink("./index" . C("html_file_suffix"));
		}
		else {
			$config["html_home_suffix"] = $config["html_file_suffix"];
		}

		$config_old = require "./Runtime/Conf/config.php";
		$config_new = array_merge($config_old, $config);
		arr2file("./Runtime/Conf/config.php", $config_new);
		@unlink("./Runtime/common~runtime.php");
		$gxl_play .= "var gxl_root=\"" . $config["site_path"] . "\";";
		$gxl_play .= "var gxl_width=" . $config["play_width"] . ";";
		$gxl_play .= "var gxl_height=" . $config["play_height"] . ";";
		admin_gxl_hot_key(C("site_hot"));
		$this->success("恭喜您，配置信息更新成功！");
	}
}


