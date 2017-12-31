<?php

namespace Common\Model;
use Think\Model;

class ImgModel extends Model
{
	public function down_load($url, $sid = "ting", $pyname)
	{
		if (is_array($url)) {
			$pathArr = array();

			foreach ($url as $key => $value ) {
				if ((C("upload_http") && (0 < strpos($value, "://"))) || (C("upload_http_news") && ($sid == "news") && ($sid == "ting") && ($sid == "tv") && ($sid == "star") && (0 < strpos($value, "://")))) {
					$pathArr[] = $this->down_img($value, $sid);
				}
				else {
					$pathArr[] = $value;
				}
			}

			return $pathArr;
		}
		else {
			if ((C("upload_http") && (0 < strpos($url, "://"))) || (C("upload_http_news") && ($sid == "news") && ($sid == "ting") && ($sid == "tv") && ($sid == "star") && (0 < strpos($url, "://")))) {
				return $this->down_img($url, $sid, $pyname);
			}
			else {
				return $url;
			}
		}
	}

	public function down_img($url, $sid = "ting", $pyname)
	{
		$chr = strrchr($url, ".");

		if (!empty($pyname)) {
			$imgUrl = $pyname;
		}
		else {
			$imgUrl = uniqid();
		}

		$imgPath = $sid . "/" . date(C("upload_style"), time()) . "/";
		$imgPath_s = "./" . C("upload_path") . "-s/" . $imgPath;
		$filename = "./" . C("upload_path") . "/" . $imgPath . $imgUrl . $chr;
		$get_file = gxl_file_get_contents($url);

		if ($get_file) {
			write_file($filename, $get_file);

			if (C("upload_water")) {
				@$image = new \Think\Image();
				@$image->open($filename)->water(C("upload_water_img"), C("upload_water_pos"), C("upload_water_pct"))->save($filename);
			}

			if (C("upload_thumb")) {
				mkdirss($imgPath_s);
				@$image = new \Think\Image();
				@$image->open($filename);
				@$image->thumb(C("upload_thumb_w"), C("upload_thumb_h"))->save($imgPath_s . $imgUrl . $chr);
			}

			if (C("upload_ftp")) {
				$this->ftp_upload($imgPath . $imgUrl . $chr);
			}

			return $imgPath . $imgUrl . $chr;
		}
		else {
			return $url;
		}
	}

	public function ftp_upload($imgurl)
	{
		$ftpcon = array("ftp_host" => C("upload_ftp_host"), "ftp_port" => C("upload_ftp_port"), "ftp_user" => C("upload_ftp_user"), "ftp_pwd" => C("upload_ftp_pass"), "ftp_dir" => C("upload_ftp_dir"));
		$ftp = new \Org\Net\Ftp();
		$ftp->config($ftpcon);
		$ftp->connect();
		$ftpimg = $ftp->put(C("upload_path") . "/" . $imgurl, C("upload_path") . "/" . $imgurl);

		if (C("upload_thumb")) {
			$ftpimg_s = $ftp->put(C("upload_path") . "-s/" . $imgurl, C("upload_path") . "-s/" . $imgurl);
		}

		if (C("upload_ftp_del")) {
			if ($ftpimg) {
				@unlink(C("upload_path") . "/" . $imgurl);
			}

			if ($ftpimg_s) {
				@unlink(C("upload_path") . "/thumb" . $imgurl_s);
			}
		}

		$ftp->bye();
	}
}


