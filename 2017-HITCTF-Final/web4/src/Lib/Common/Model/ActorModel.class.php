<?php
namespace Common\Model;
use Think\Model\RelationModel;
class ActorModel extends RelationModel
{
	private $ting_id;
	protected $_validate = array(
		array("actor_vid", "require", "作品ID必须填写！", 1, "", 3)
		);
	protected $_auto = array(
		array("actor_content", "actor_content", 3, "callback")
		);
	protected $_link = array(
		"Ting" => array("mapping_type" => HAS_MANY, "class_name" => "Ting", "mapping_name" => "Ting", "foreign_key" => "ting_id", "parent_key" => "actor_vid", "mapping_fields" => "ting_id,ting_cid,ting_mcid,ting_name,ting_title,ting_keywords,ting_actor,ting_director,ting_content,ting_pic")
		);

	public function actor_content()
	{
		if (!empty($_POST["actor_content"])) {
			$actor_content = gxl_news_img_array($_POST["actor_content"], 1);
			if ((C("upload_http") && !empty($actor_content)) || (C("upload_http_news") && !empty($actor_content))) {
				$img = D("Img");

				if (!!$path = getarraypic($actor_content)) {
					$savePath = $img->down_load($path, "ting");
					$contents1 = str_ireplace($path, $savePath, $actor_content);
					return $contents1;
				}
				else {
					return $_POST["actor_content"];
				}
			}
			else {
				return $actor_content;
			}
		}
		else {
			return $_POST["actor_content"];
		}
	}
}


