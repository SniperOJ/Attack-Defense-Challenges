<?php

namespace Admin\Action;
use Common\Action\BaseAction;
class PicAction extends BaseAction
{
	public function down()
	{
		C("upload_http", 1);
		$img = D("Img");
		$rs = D("Ting");

		if ("fail" == trim($_GET["id"])) {
			$rs->execute("update " . C("db_prefix") . "ting set ting_pic=REPLACE(ting_pic,\"httpf://\", \"http://\")");
		}

		$count = $rs->where("Left(ting_pic,7)=\"http://\"")->count("ting_id");
		$list = $rs->where("Left(ting_pic,7)=\"http://\"")->order("ting_addtime desc")->limit(C("upload_http_down"))->select();

		if ($list) {
			echo "<style type=\"text/css\">div{font-size:13px;color: #333333;line-height:21px;}span{font-weight:bold;color:#FF0000}</style>";
			echo "<div>共有<span>" . $count . "</span>张远程图片，每次批量下载<span>" . C("upload_http_down") . "</span>张，<span>" . C("play_collect_time") . "</span>秒后执行下一次操作。<br />";

			foreach ($list as $key => $value ) {
				if (C("pic_pinyin")) {
					@$imgnew = $img->down_load($value["ting_pic"], "ting", $value["ting_letters"]);
				}
				else {
					@$imgnew = $img->down_load($value["ting_pic"], "ting");
				}

				if ($value["ting_pic"] == $imgnew) {
					$rs->where("ting_id=" . $value["ting_id"])->setField("ting_pic", str_replace("http://", "httpf://", $value["ting_pic"]));
					echo ($key + 1) . " <a href=\"" . $value["ting_pic"] . "\" target=\"_blank\">" . $value["ting_pic"] . "</a> <font color=red>下载失败!</font><br/>";
				}
				else {
					$rs->where("ting_id = " . $value["ting_id"])->setField("ting_pic", $imgnew);
					echo ($key + 1) . " <a href=\"" . $value["ting_pic"] . "\" target=\"_blank\">" . $value["ting_pic"] . "</a> 下载成功！<br />";
				}

				ob_flush();
				flush();
			}

			echo "请稍等一会，正在释放服务器资源...<meta http-equiv=\"refresh\" content=" . C("play_collect_time") . ";url=?s=Admin-Pic-Down>";
			echo "</div>";
		}
		else {
			$count = $rs->where("Left(ting_pic,8)=\"httpf://\"")->count("ting_id");

			if ($count) {
				echo "<div style=\"font-size:14px;\">共有<span>" . $count . "</span>张远程图片保存失败,如果需要重新下载,请点击<a href=\"?s=Admin-Pic-Down-id-fail\">[这里]</a>!</div>";
			}
			else {
				$this->assign("jumpUrl", "?s=Admin-Ting-Show");
				$this->success("恭喜您,所有远程图片已经下载完成！");
			}
		}
	}

	public function news()
	{
		C("upload_http", 1);
		$img = D("Img");
		$rs = D("News");

		if ("fail" == trim($_GET["id"])) {
			$rs->execute("update " . C("db_prefix") . "news set news_pic=REPLACE(news_pic,\"httpf://\", \"http://\")");
		}

		$count = $rs->where("Left(news_pic,7)=\"http://\"")->count("news_id");
		$list = $rs->where("Left(news_pic,7)=\"http://\"")->order("news_addtime desc")->limit(C("upload_http_down"))->select();

		if ($list) {
			echo "<style type=\"text/css\">div{font-size:13px;color: #333333;line-height:21px;}span{font-weight:bold;color:#FF0000}</style>";
			echo "<div>共有<span>" . $count . "</span>张远程图片，每次批量下载<span>" . C("upload_http_down") . "</span>张，<span>" . C("play_collect_time") . "</span>秒后执行下一次操作。<br />";

			foreach ($list as $key => $value ) {
				@$imgnew = $img->down_load($value["news_pic"], "news");

				if ($value["news_pic"] == $imgnew) {
					$rs->where("news_id=" . $value["news_id"])->setField("news_pic", str_replace("http://", "httpf://", $value["news_pic"]));
					echo ($key + 1) . " <a href=\"" . $value["news_pic"] . "\" target=\"_blank\">" . $value["news_pic"] . "</a> <font color=red>下载失败!</font><br/>";
				}
				else {
					$rs->where("news_id = " . $value["news_id"])->setField("news_pic", $imgnew);
					echo ($key + 1) . " <a href=\"" . $value["news_pic"] . "\" target=\"_blank\">" . $value["news_pic"] . "</a> 下载成功！<br />";
				}

				ob_flush();
				flush();
			}

			echo "请稍等一会，正在释放服务器资源...<meta http-equiv=\"refresh\" content=" . C("play_collect_time") . ";url=?s=Admin-Pic-news>";
			echo "</div>";
		}
		else {
			$count = $rs->where("Left(news_pic,8)=\"httpf://\"")->count("news_id");

			if ($count) {
				echo "<div style=\"font-size:14px;\">共有<span>" . $count . "</span>张远程图片保存失败,如果需要重新下载,请点击<a href=\"?s=Admin-Pic-Down-id-fail\">[这里]</a>!</div>";
			}
			else {
				$this->assign("jumpUrl", "?s=Admin-Ting-Show");
				$this->success("恭喜您,所有远程图片已经下载完成！");
			}
		}
	}

	public function downactorpic()
	{
		C("upload_http", 1);
		$img = D("Img");
		$rs = D("Actor");

		if ("fail" == trim($_GET["id"])) {
			$rs->execute("update " . C("db_prefix") . "actor set actor_pic=REPLACE(actor_pic,\"httpf://\", \"http://\")");
		}

		$count = $rs->where("Left(actor_pic,7)=\"http://\"")->count("actor_id");
		$list = $rs->where("Left(actor_pic,7)=\"http://\"")->order("actor_id desc")->limit(C("upload_http_down"))->select();

		if ($list) {
			echo "<style type=\"text/css\">div{font-size:13px;color: #333333;line-height:21px;}span{font-weight:bold;color:#FF0000}</style>";
			echo "<div>共有<span>" . $count . "</span>张远程图片，每次批量下载<span>" . C("upload_http_down") . "</span>张，<span>" . C("play_collect_time") . "</span>秒后执行下一次操作。<br />";

			foreach ($list as $key => $value ) {
				@$imgnew = $img->down_load($value["actor_pic"], "actor");

				if ($value["actor_pic"] == $imgnew) {
					$rs->where("actor_id=" . $value["actor_id"])->setField("actor_pic", str_replace("http://", "httpf://", $value["actor_pic"]));
					echo ($key + 1) . " <a href=\"" . $value["actor_pic"] . "\" target=\"_blank\">" . $value["actor_pic"] . "</a> <font color=red>下载失败!</font><br/>";
				}
				else {
					$rs->where("actor_id = " . $value["actor_id"])->setField("actor_pic", $imgnew);
					echo ($key + 1) . " <a href=\"" . $value["actor_pic"] . "\" target=\"_blank\">" . $value["actor_pic"] . "</a> 下载成功！<br />";
				}

				ob_flush();
				flush();
			}

			echo "请稍等一会，正在释放服务器资源...<meta http-equiv=\"refresh\" content=" . C("play_collect_time") . ";url=?s=Admin-Pic-downactorpic>";
			echo "</div>";
		}
		else {
			$count = $rs->where("Left(actor_pic,8)=\"httpf://\"")->count("actor_id");

			if ($count) {
				echo "<div style=\"font-size:14px;\">共有<span>" . $count . "</span>张远程图片保存失败,如果需要重新下载,请点击<a href=\"?s=Admin-Pic-downactorpic-id-fail\">[这里]</a>!</div>";
			}
			else {
				echo "恭喜您,所有远程图片已经下载完成！";
			}
		}
	}

	public function downactorpicvid()
	{
		C("upload_http", 1);
		$img = D("Img");
		$rs = D("Actor");
		$vid = intval($_GET["vid"]);

		if ("fail" == trim($_GET["id"])) {
			$rs->execute("update " . C("db_prefix") . "actor set actor_pic=REPLACE(actor_pic,\"httpf://\", \"http://\")");
		}

		$count = $rs->where("Left(actor_pic,7)='http://' and actor_vid ='$vid' ")->count("actor_id");
		$list = $rs->where("Left(actor_pic,7)='http://' and actor_vid ='$vid'")->order("actor_id desc")->select();

		if ($list) {
			echo "<style type=\"text/css\">div{font-size:13px;color: #333333;line-height:21px;}span{font-weight:bold;color:#FF0000}</style>";
			echo "<div>共有<span>" . $count . "</span>张远程图片，<span>" . C("play_collect_time") . "</span>秒后执行下一次操作。<br />";

			foreach ($list as $key => $value ) {
				@$imgnew = $img->down_load($value["actor_pic"], "actor");

				if ($value["actor_pic"] == $imgnew) {
					$rs->where("actor_id=" . $value["actor_id"])->setField("actor_pic", str_replace("http://", "httpf://", $value["actor_pic"]));
					echo ($key + 1) . " <a href=\"" . $value["actor_pic"] . "\" target=\"_blank\">" . $value["actor_pic"] . "</a> <font color=red>下载失败!</font><br/>";
				}
				else {
					$rs->where("actor_id = " . $value["actor_id"])->setField("actor_pic", $imgnew);
					echo ($key + 1) . " <a href=\"" . $value["actor_pic"] . "\" target=\"_blank\">" . $value["actor_pic"] . "</a> 下载成功！<br />";
				}

				ob_flush();
				flush();
			}

			echo "</div>";
		}
		else {
			$count = $rs->where("Left(actor_pic,8)='httpf://' and actor_vid ='$vid'")->count("actor_id");

			if ($count) {
				echo "<div style=\"font-size:14px;\">共有<span>" . $count . "</span>张远程图片保存失败,如果需要重新下载,请点击<a href=\"?s=Admin-Pic-downactorpic-id-fail\">[这里]</a>!</div>";
			}
			else {
				echo "恭喜您,所有远程图片已经下载完成！";
			}
		}
	}

	public function downstarpic()
	{
		C("upload_http", 1);
		$img = D("Img");
		$rs = M("Star");

		if ("fail" == trim($_GET["id"])) {
			$rs->execute("update " . C("db_prefix") . "star set star_pic=REPLACE(star_pic,\"httpf://\", \"http://\")");
		}

		$count = $rs->where("Left(star_pic,7)=\"http://\"")->count("star_id");
		$list = $rs->where("Left(star_pic,7)=\"http://\"")->order("star_id desc")->limit(C("upload_http_down"))->select();

		if ($list) {
			echo "<style type=\"text/css\">div{font-size:13px;color: #333333;line-height:21px;}span{font-weight:bold;color:#FF0000}</style>";
			echo "<div>共有<span>" . $count . "</span>张远程图片，每次批量下载<span>" . C("upload_http_down") . "</span>张，<span>" . C("play_collect_time") . "</span>秒后执行下一次操作。<br />";

			foreach ($list as $key => $value ) {
				if (C("pic_pinyin")) {
					@$imgnew = $img->down_load($value["star_pic"], "star", $value["star_pyname"]);
				}
				else {
					@$imgnew = $img->down_load($value["star_pic"], "star");
				}

				if ($value["star_pic"] == $imgnew) {
					$rs->where("star_id=" . $value["actor_id"])->setField("star_pic", str_replace("http://", "httpf://", $value["star_pic"]));
					echo ($key + 1) . " <a href=\"" . $value["star_pic"] . "\" target=\"_blank\">" . $value["star_pic"] . "</a> <font color=red>下载失败!</font><br/>";
				}
				else {
					$rs->where("star_id = " . $value["star_id"])->setField("star_pic", $imgnew);
					echo ($key + 1) . " <a href=\"" . $value["star_pic"] . "\" target=\"_blank\">" . $value["star_pic"] . "</a> 下载成功！<br />";
				}

				ob_flush();
				flush();
			}

			echo "请稍等一会，正在释放服务器资源...<meta http-equiv=\"refresh\" content=" . C("play_collect_time") . ";url=?s=Admin-Pic-downstarpic>";
			echo "</div>";
		}
		else {
			$count = $rs->where("Left(star_pic,8)=\"httpf://\"")->count("star_id");

			if ($count) {
				echo "<div style=\"font-size:14px;\">共有<span>" . $count . "</span>张远程图片保存失败,如果需要重新下载,请点击<a href=\"?s=Admin-Pic-downstarpic-id-fail\">[这里]</a>!</div>";
			}
			else {
				echo "恭喜您,所有远程图片已经下载完成！";
			}
		}
	}

	public function show()
	{
		$id = trim($_GET["id"]);

		if ($id) {
			$dirpath = admin_gxl_url_repalce(str_replace("*", "-", $id));
		}
		else {
			$dirpath = "./" . C("upload_path");
		}

		if (!strpos($dirpath, C("upload_path"))) {
			$this->error("不在上传文件夹范围内！");
		}

		$dirlast = $this->dirlast();
		$dir = new \Org\Net\Dir($dirpath);
		$list_dir = $dir->toArray();

		foreach ($list_dir as $key => $value ) {
			$list_dir[$key]["pathfile"] = admin_gxl_url_repalce($value["path"], "desc") . "|" . str_replace("-", "*", $value["filename"]);
		}

		if (empty($list_dir)) {
			$this->error("还没有上传任何附件,无需管理！");
		}

		if ($dirlast && ($dirlast != ".")) {
			$this->assign("dirlast", admin_gxl_url_repalce($dirlast, "desc"));
		}

		$this->assign("dirpath", $dirpath);
		$this->assign("list_dir", $list_dir);
		$this->display("./Public/admin/pic_show.html");
	}

	public function dirlast()
	{
		$id = admin_gxl_url_repalce(trim($_GET["id"]));

		if ($id) {
			return substr($id, 0, strrpos($id, "/"));
		}
		else {
			return false;
		}
	}

	public function del()
	{
		$path = trim(str_replace("*", "-", $_GET["id"]));
		@unlink($path);
		@unlink(str_replace(C("upload_path") . "/", C("upload_path") . "-s/", $path));
		$this->success("删除附件成功！");
	}

	public function ajaxpic()
	{
		$path = trim(str_replace("*", "-", $_GET["id"]));
		$list = glob($path . "/*");

		if (empty($list)) {
			exit("无图片");
		}

		foreach ($list as $i => $file ) {
			$dir[] = str_replace("./" . C("upload_path") . "/", "", $path . "/" . basename($file));
		}

		if (stristr($path, "/ting")) {
			$rs = M("Ting");
			$array = $rs->field("ting_pic")->where("Left(ting_pic,4)!=\"http\"")->order("ting_addtime desc")->select();

			foreach ($array as $value ) {
				$dir2[] = $value["ting_pic"];
			}
		}
		else if (stristr($path, "/news")) {
			$rs = M("News");
			$array = $rs->field("news_pic")->where("Left(news_pic,4)!=\"http\"")->order("news_addtime desc")->select();

			foreach ($array as $value ) {
				$dir2[] = $value["news_pic"];
			}
		}
		else if (stristr($path, "/star")) {
			$rs = M("Star");
			$array = $rs->field("star_pic")->where("Left(star_pic,4)!=\"http\"")->order("star_addtime desc")->select();

			foreach ($array as $value ) {
				$dir2[] = $value["star_pic"];
			}
		}
		else if (stristr($path, "/actor")) {
			$rs = M("Actor");
			$array = $rs->field("actor_pic")->where("Left(actor_pic,4)!=\"http\"")->order("star_id desc")->select();

			foreach ($array as $value ) {
				$dir2[] = $value["actor_pic"];
			}
		}
		else if (stristr($path, "/slide")) {
			$rs = D("Slide");
			$array = $rs->field("slide_pic")->where("Left(slide_pic,4)!=\"http\"")->order("slide_id desc")->select();

			foreach ($array as $value ) {
				$dir2[] = $value["slide_pic"];
			}
		}
		else if (stristr($path, "/link")) {
			$rs = M("Link");
			$array = $rs->field("link_logo")->where("Left(link_logo,4)!=\"http\"")->order("link_id desc")->select();

			foreach ($array as $value ) {
				$dir2[] = $value["link_logo"];
			}
		}

		$del = array_diff($dir, $dir2);

		foreach ($del as $key => $value ) {
			@unlink("./" . C("upload_path") . "/" . $value);
		}

		exit("清理完成");
	}
}


