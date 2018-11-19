<?php
if(!defined('duomi_INC'))
{
	exit("Request Error!");
}

function SpCreateDir($spath)
{
	global $cfg_dir_purview,$cfg_basedir,$isSafeMode;
	if($spath=='')
	{
		return true;
	}
	$flink = false;
	$truepath = $cfg_basedir;
	$truepath = str_replace("\\","/",$truepath);
	$spaths = explode("/",$spath);
	$spath = "";
	foreach($spaths as $spath)
	{
		if($spath=="")
		{
			continue;
		}
		$spath = trim($spath);
		$truepath .= "/".$spath;
		if(!is_dir($truepath) || !is_writeable($truepath))
		{
			if(!is_dir($truepath))
			{
				$isok = MkdirAll($truepath,$cfg_dir_purview);
			}
			else
			{
				$isok = ChmodAll($truepath,$cfg_dir_purview);
			}
			if(!$isok)
			{
				echo "创建或修改目录：".$truepath." 失败！<br>";
				return false;
			}
		}
	}
	return true;
}


function SpGetNewInfo()
{
	global $cfg_version;
	$nurl = $_SERVER['HTTP_HOST'];
	if( m_eregi("[a-z\-]{1,}\.[a-z]{2,}",$nurl) ) {
		$nurl = urlencode($nurl);
	}
	else {
		$nurl = "test";
	}
	return $offUrl;
}

