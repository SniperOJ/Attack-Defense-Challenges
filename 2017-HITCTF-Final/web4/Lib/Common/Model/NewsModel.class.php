<?php
namespace Common\Model;
use Think\Model\RelationModel;
class NewsModel extends RelationModel
{
	private $news_id;
	protected $_validate = array(
		array("news_cid", "number", "请选择分类！", 1, "", 3),
		array("news_cid", "getlistson", "请选择当前分类下面的子栏目！", 1, "function", 3),
		array("news_name", "require", "文章标题必须填写！", 1, "", 3)
		);
	protected $_auto = array(
		array("news_name", "trim", 3, "function"),
		array("news_remark", "get_remark", 3, "callback"),
		array("news_letter", "a_letter", 3, "callback"),
		array("news_addtime", "a_addtime", 3, "callback"),
		array("news_pic", "news_pic", 3, "callback"),
		array("news_content", "news_content", 3, "callback")
		);
	protected $_link = array(
		"Tag" => array("mapping_type" => HAS_MANY, "class_name" => "Tag", "mapping_name" => "Tag", "foreign_key" => "tag_id", "parent_key" => "news_id", "mapping_fields" => "tag_id,tag_sid,tag_name", "condition" => "tag_sid = 2")
		);

	public function get_remark()
	{
		if (empty($_POST["news_remark"])) {
			return msubstr(trim($_POST["news_content"]), 0, 100, "utf-8", false);
		}
		else {
			return trim($_POST["news_remark"]);
		}
	}

	public function a_letter()
	{
		return gxl_letter_first(trim($_POST["news_name"]));
	}

	public function a_addtime()
	{
		if ($_POST["checktime"]) {
			return time();
		}
		else {
			return strtotime($_POST["addtime"]);
		}
	}

	public function news_content()
	{
		if (!empty($_POST["news_content"])) {
			$news_content = gxl_news_img_array($_POST["news_content"], 1);
			if ((C("upload_http") && !empty($news_content)) || (C("upload_http_news") && !empty($news_content))) {
				$img = D("Img");

				if (!!$path = getarraypic($news_content)) {
					$savePath = $img->down_load($path, "news");
					$contents1 = str_ireplace($path, $savePath, $news_content);
					return $contents1;
				}
				else {
					return $_POST["news_content"];
				}
			}
			else {
				return $news_content;
			}
		}
		else {
			return $_POST["news_content"];
		}
	}

	public function news_pic()
	{
		$img = D("Img");
		if (empty($_POST["news_pic"]) && $_POST["news_content"]) {
			if (C("news_pic")) {
				$urlpic = gxl_img_url_preg_news("", trim($_POST["news_content"]), 1);
			}
			else {
				$urlpic = gxl_img_url_preg("", trim($_POST["news_content"]), 1);
			}

			if ($urlpic) {
				return $img->down_load($urlpic, "news");
			}
			else {
				return $img->down_load(trim($_POST["news_pic"]), "news");
			}
		}
		else {
			return $img->down_load(trim($_POST["news_pic"]), "news");
		}
	}
}


