<?php
namespace Common\Model;
use Think\Model\AdvModel;
class CommentModel extends AdvModel
{
	private $userid;
	protected $_validate = array(
		array("cm_cid", "number", "您没有指定评论ID！", 1),
		array("cm_sid", "require", "您没有指定评论模型！", 1),
		array("cm_content", "require", "您没有填写评论内容！", 1)
		);
	protected $_auto = array(
		array("cm_content", "hh_content", 1, "callback"),
		array("cm_uid", "get_userid", 1, "callback"),
		array("cm_sid", "intval", 1, "function"),
		array("cm_ip", "get_client_ip", 1, "function"),
		array("cm_addtime", "time", 3, "function")
		);
	protected $_link = array(
		"User" => array("mapping_type" => self::HAS_MANY, "class_name" => "User", "mapping_name" => "User", "foreign_key" => "user_id", "parent_key" => "userid", "mapping_fields" => "nickname,email")
		);

	public function check_vcode()
	{
		if ($_SESSION["verify"] != md5($_POST["vcode"])) {
			return false;
		}
	}

	public function check_reinput()
	{
		$cookie = $_COOKIE["comment_" . intval($_POST["cm_sid"]) . "_" . intval($_POST["cm_cid"])];

		if (isset($cookie)) {
			return false;
		}
	}

	public function check_login()
	{
		$userid = intval($_COOKIE["gx_userid"]);

		if ($userid) {
			return true;
		}
		else {
			$rs = M("User");
			$userid = $rs->check_login();

			if ($userid) {
				C("gxl_user_id", $userid);
				return true;
			}
			else {
				return false;
			}
		}
	}

	public function get_userid()
	{
		return 1;
		$userid = intval($_COOKIE["gxl_user_id"]);

		if ($userid) {
			return $userid;
		}

		if (C("gxl_user_id")) {
			return C("gxl_user_id");
		}

		return 1;
	}

	public function hh_content($str)
	{
		$array = explode("|", C("user_replace"));
		return str_replace($array, "***", msubstr(remove_xss($str), 0, 200));
	}
}


