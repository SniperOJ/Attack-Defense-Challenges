<?php
namespace Common\Model;
use Think\Model\RelationModel;
class TingModel extends RelationModel
{
	private $ting_id;
	protected $_validate = array(
		array("ting_cid", "number", "请选择分类！", 1, "", 3),
		array("ting_cid", "getlistson", "请选择当前子类栏目！", 1, "function", 3),
		array("ting_name", "require", "作品名称必须填写！", 1, "", 3)
		);
	protected $_auto = array(
		array("ting_letter", "ting_letter", 3, "callback"),
		array("ting_gold", "ting_gold", 3, "callback"),
		array("ting_pic", "ting_pic", 3, "callback"),
		array("ting_addtime", "ting_addtime", 3, "callback"),
		array("ting_content", "ting_content", 3, "callback")
		);
	protected $_link = array(
		"Tag"     => array("mapping_type" => self::HAS_MANY, "class_name" => "Tag", "mapping_name" => "Tag", "foreign_key" => "tag_id", "parent_key" => "ting_id", "mapping_fields" => "tag_id,tag_sid,tag_name", "condition" => "tag_sid = 1")
		);

	public function ting_letter()
	{
		return gxl_letter_first(trim($_POST["ting_name"]));
	}

	public function ting_pic()
	{
		$img = D("Img");
		return $img->down_load(trim($_POST["ting_pic"]));
	}
	
	public function ting_urlu($f,$char)
	{
		$_POST["ting_url"]=$f.$char;
		return $_POST["ting_url"];
	}
	public function ting_gold()
	{
		if (10 < $_POST["ting_gold"]) {
			$_POST["ting_gold"] = 10;
		}

		return $_POST["ting_gold"];
	}

	public function ting_addtime()
	{
		if ($_POST["checktime"]) {
			return time();
		}
		else {
			return strtotime($_POST["ting_addtime"]);
		}
	}



	public function ting_content()
	{
		if (!empty($_POST["ting_content"])) {
			$ting_content = gxl_news_img_array($_POST["ting_content"], 1);
			if ((C("upload_http") && !empty($ting_content)) || (C("upload_http_news") && !empty($ting_content))) {
				$img = D("Img");

				if (!!$path = getarraypic($ting_content)) {
					$savePath = $img->down_load($path, "ting");
					$contents1 = str_ireplace($path, $savePath, $ting_content);
					return $contents1;
				}
				else {
					return $_POST["ting_content"];
				}
			}
			else {
				return $ting_content;
			}
		}
		else {
			return $_POST["ting_content"];
		}
	}


}


