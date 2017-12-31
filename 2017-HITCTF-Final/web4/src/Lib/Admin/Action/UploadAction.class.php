<?php
namespace Admin\Action;
use Common\Action\BaseAction;

class UploadAction extends BaseAction
{
	public function show()
	{
		$this->display("./Public/admin/upload_show.html");
	}
	public function sc()
	{
		$fid = intval($_GET["gvid"]);
		$sid = intval($_GET["sid"]);
		$this->assign("gvid",$fid);
		$this->assign("sid",$sid);
		$this->display("./Public/admin/upload_sc.html");
	}
	public function upload()
	{
		
		echo "<div style=\"font-size:12px; height:30px; line-height:30px\">";
		$uppath = "./" . str_replace(array("..", "//"), "", C("upload_path")) . "/";
		$uppath_s = "./" . str_replace(array("..", "//"), "", C("upload_path")) . "-s/";
		$sid = trim($_POST["sid"]);
		$fileback = (!empty($_POST["fileback"]) ? trim($_POST["fileback"]) : "ting_pic");

		if ($sid) {
			$uppath .= $sid . "/";
			$uppath_s .= $sid . "/";
			mkdirss($uppath);
			mkdirss($uppath_s);
		}

		$up = new \Org\Net\UploadFile();
		$up->savePath = $uppath;
		$up->saveRule = uniqid;
		$up->uploadReplace = true;
		$upload_class = str_replace(array("php", "asp", "apsx", "txt", "asax", "ascx", "cdx", "cer", "cgi", "jsp", "html", "html", "htm", ",,"), "", strtolower(C("upload_class")));
		$upload_classs = trim($upload_class, ",");
		$up->allowExts = explode(",", $upload_classs);
		$up->autoSub = true;
		$up->subType = date;
		$up->dateFormat = C("upload_style");

		if (!$up->upload()) {
			$error = $up->getErrorMsg();

			if ($error == "上传文件类型不允许") {
				$error .= "，可上传<font color=red>" . $upload_classs . "</font>";
			}

			exit($error . " [<a href=\"?s=Admin-Upload-Show-sid-" . $sid . "-fileback-" . $fileback . "\">重新上传</a>]");
		}

		$uploadList = $up->getUploadFileInfo();

		if (C("upload_water")) {
			$image = new \Think\Image();
			$image->open($uppath . $uploadList[0]["savename"])->water(C("upload_water_img"), C("upload_water_pos"), C("upload_water_pct"))->save($uppath . $uploadList[0]["savename"]);
		}

		if (C("upload_thumb")) {
			$thumbdir = substr($uploadList[0]["savename"], 0, strrpos($uploadList[0]["savename"], "/"));
			mkdirss($uppath_s . $thumbdir);
			$image = new \Think\Image();
			$image->open($uppath . $uploadList[0]["savename"]);
			$image->thumb(C("upload_thumb_w"), C("upload_thumb_h"), C("upload_thumb_pos"))->save($uppath_s . $uploadList[0]["savename"]);
		}

		if (C("upload_ftp")) {
			$img = D("Img");
			$img->ftp_upload($sid . "/" . $uploadList[0]["savename"]);
		}

		echo "<script type='text/javascript'>parent.document.getElementById('" . $fileback . "').value='" . $sid . "/" . $uploadList[0]["savename"] . "';</script>";
		echo "文件上传成功　[<a href=\"?s=Admin-Upload-Show-sid-" . $sid . "-fileback-" . $fileback . "\">重新上传</a>]";
		echo "</div>";
	}
	public function shng()
	
	{
		
		$rs = D("Ting");
		$ting_id = intval($_GET["sid"]);
		$id= intval($_GET["gvid"]);
		$where["ting_id"] = $ting_id;
		$array = $rs->where($where)->relation(array("Tag"))->find();
		$array["ting_url"] = explode("$$$", $array["ting_url"]);
		$array["ting_count"] = substr_count($array["ting_url"]["0"],"$")+$id-1;
		$ji='第'.$array["ting_count"].'集$';
			
		
		echo "<div style=\"font-size:12px; height:30px; line-height:30px\">";
		$uppath = "./" . str_replace(array("..", "//"), "", C("upload_path")) . "/";
		$uppath_s = "./" . str_replace(array("..", "//"), "", C("upload_path")) . "-s/";
		$sid = trim($_POST["sid"]);
		$fileback = (!empty($_POST["fileback"]) ? trim($_POST["fileback"]) : "ting_zj$id");
		

		if ($sid) {
			$uppath .= $sid . "/";
			$uppath_s .= $sid . "/";
			mkdirss($uppath);
			mkdirss($uppath_s);
		}

		$up = new \Org\Net\UploadFile();
		$up->savePath = $uppath;
		$up->saveRule = uniqid;
		$up->uploadReplace = true;
		$upload_class = str_replace(array("php", "asp", "apsx", "txt", "asax", "ascx", "cdx", "cer", "cgi", "jsp", "html", "html", "htm", ",,"), "", strtolower(C("upload_class")));
		$upload_classs = trim($upload_class, ",");
		$up->allowExts = explode(",", $upload_classs);
		$up->autoSub = true;
		$up->subType = date;
		$up->dateFormat = C("upload_style");

		if (!$up->upload()) {
			$error = $up->getErrorMsg();

			if ($error == "上传文件类型不允许") {
				$error .= "，可上传<font color=red>" . $upload_classs . "</font>";
			}

			exit($error . " [<a href=\"?s=Admin-Upload-sc-sid-" . $sid . "-fileback-" . $fileback . "\">重新上传</a>]");
		}

		$uploadList = $up->getUploadFileInfo();

		if (C("upload_water")) {
			$image = new \Think\Image();
			$image->open($uppath . $uploadList[0]["savename"])->water(C("upload_water_img"), C("upload_water_pos"), C("upload_water_pct"))->save($uppath . $uploadList[0]["savename"]);
		}

		if (C("upload_thumb")) {
			$thumbdir = substr($uploadList[0]["savename"], 0, strrpos($uploadList[0]["savename"], "/"));
			mkdirss($uppath_s . $thumbdir);
			$image = new \Think\Image();
			$image->open($uppath . $uploadList[0]["savename"]);
			$image->thumb(C("upload_thumb_w"), C("upload_thumb_h"), C("upload_thumb_pos"))->save($uppath_s . $uploadList[0]["savename"]);
		}

		if (C("upload_ftp")) {
			$img = D("Img");
			$img->ftp_upload($sid . "/" . $uploadList[0]["savename"]);
		}

		echo "<script type='text/javascript'>parent.document.getElementById('" . $fileback . "').value='".$ji.C(site_url) .C(upload_path)."/". $sid . "/" . $uploadList[0]["savename"] . "';</script>";
		echo "文件上传成功　[<a href=\"?s=Admin-Upload-sc-sid-" . $sid . "-fileback-" . $fileback . "\">重新上传</a>]";
		echo "</div>";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


