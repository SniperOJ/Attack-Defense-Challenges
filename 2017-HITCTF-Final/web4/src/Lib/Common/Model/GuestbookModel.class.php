<?php
namespace Common\Model;
use Think\Model\AdvModel;
class GuestbookModel extends AdvModel
{
	protected $_validate = array(
		array("gb_code", "check_vcode", "您填写的验证码不正确！", 1, "callback", 1),
		array("gb_content", "require", "您没有填写留言内容或内容存在非法字符！", 1),
		array("gb_content", "check_cookie", "您已经留言过了，请休息一会，喝杯咖啡！", 1, "callback")
		);
	protected $_auto = array(
		array("gb_ip", "get_client_ip", 1, "function"),
		array("gb_addtime", "time", 1, "function"),
		array("gb_content", "get_content", 1, "callback")
		);

	public function check_vcode()
	{
		$validate = strtolower($_POST["validate"]);

		if (C("user_vcode")) {
			if (empty($validate) || ($_SESSION["gcode"] != $validate)) {
				return false;
			}
		}

		return true;
	}

	public function check_cookie()
	{
		$cookie = "gbook-" . intval($_POST["gb_cid"]);

		if (isset($_COOKIE[$cookie])) {
			return false;
		}
	}

	public function get_content($str)
	{
		$array = explode("|", C("user_replace"));
		return trim(str_replace($array, "***", nb(nr($str))));
	}

	public function get_uid()
	{
		$userid = $this->memberinfo["userid"];

		if ($userid) {
			return $userid;
		}

		return 1;
	}
}


