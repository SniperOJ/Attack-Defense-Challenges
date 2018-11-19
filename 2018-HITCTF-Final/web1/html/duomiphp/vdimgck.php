<?php
/**
 * 验证码
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
session_start();

//获取随机字符
$rndstring = '';
for($i=0; $i<4; $i++) $rndstring .= chr(mt_rand(65,90));

//如果支持GD，则绘图
if(function_exists("imagecreate"))
{
	//Firefox部份情况会多次请求的问题，5秒内刷新页面将不改变session
	//$ntime = time();
	$_SESSION['duomi_ckstr'] = strtolower($rndstring);
	$_SESSION['duomi_ckstr_last'] = '';
	$rndcodelen = strlen($rndstring);

	//创建图片，并设置背景色
	$im = imagecreate(50,20);
	ImageColorAllocate($im, 224,228,231);

	//输出文字
	$fontColor = ImageColorAllocate($im, 25,113,180);
	for($i=0;$i<$rndcodelen;$i++)
	{
		$bc = mt_rand(0,1);
		$rndstring[$i] = strtoupper($rndstring[$i]);
		imagestring($im, 5, $i*10+6, mt_rand(2,4), $rndstring[$i], $fontColor);
	}

	header("Pragma:no-cache\r\n");
	header("Cache-Control:no-cache\r\n");
	header("Expires:0\r\n");

	//输出特定类型的图片格式，优先级为 gif -> jpg ->png
	if(function_exists("imagejpeg"))
	{
		header("content-type:image/jpeg\r\n");
		imagejpeg($im);
	}
	else
	{
		header("content-type:image/png\r\n");
		imagepng($im);
	}
	ImageDestroy($im);
	exit();
}
else
{
	//不支持GD，只输出字母 ABCD
	$_SESSION['duomi_ckstr'] = "abcd";
	$_SESSION['duomi_ckstr_last'] = '';
	header("content-type:image/jpeg\r\n");
	header("Pragma:no-cache\r\n");
	header("Cache-Control:no-cache\r\n");
	header("Expires:0\r\n");
	$fp = fopen("data/vdcode.jpg","r");
	echo fread($fp,filesize("data/vdcode.jpg"));
	fclose($fp);
	exit();
}

?>