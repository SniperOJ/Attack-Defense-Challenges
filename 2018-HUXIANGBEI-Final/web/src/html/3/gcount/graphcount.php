<?php
/*******************************************************************************
*  标题：PHP的图形计数器（PHPGcount） 
*  版本：@ 2009年8月21日1.2
*  作者：MING MING
*******************************************************************************/
include("../../inc/config.php");
// 设定您的计数器（下面的资料请认真填写确保准确无误！）

// 请输入此统计器的目录地址。包括一个尾部“/”!!!
$base_url = siteurl."/3/gcount/";

// 风格目录（默认是WEB1），如果您想添加，请到此统计器的目录/styles/里面添加。
$default_style = 'web1';

// Default counter image extension
$default_ext = 'gif';

// 只计算浏览量PV么？ 1 =是，0 =否 （默认是0）
$count_unique = 0;

// 超过多少小时的游客被看作是“独立IP”默认24小时
$unique_hours = 24;

// Minimum number of digits shown (zero-padding). Set to 0 to disable.
$min_digits = 0;

#############################
#  下面的不要编辑O(∩_∩)O  #
#############################

/* Turn error notices off */
error_reporting(E_ALL ^ E_NOTICE);

/* Get page and log file names */
$logfile    = 'logs/test.txt';
/* Get style and extension information */
$style      = input($_GET['style']) or $style = $default_style;
$style_dir  = 'styles/' . $style . '/';
$ext        = input($_GET['ext']) or $ext = $default_ext;

/* Does the log exist? */
if (file_exists($logfile)) {

	/* Get current count */
	$count = intval(trim(file_get_contents($logfile))) or $count = 0;
	$cname = 'gcount_unique_test';

	if ($count_unique==0 || !isset($_COOKIE[$cname]))
    {
		/* Increase the count by 1 */
		$count = $count + 1;
		$fp = @fopen($logfile,'w+') or die('ERROR: Can\'t write to the log file ('.$logfile.'), please make sure this file exists and is CHMOD to 666 (rw-rw-rw-)!');
		flock($fp, LOCK_EX);
		fputs($fp, $count);
		flock($fp, LOCK_UN);
		fclose($fp);

		/* Print the Cookie and P3P compact privacy policy */
		header('P3P: CP="NOI NID"');
		setcookie($cname, 1, time()+60*60*$unique_hours);
	}

    /* Is zero-padding enabled? */
    if ($min_digits > 0)
    {
        $count = sprintf('%0'.$min_digits.'s',$count);
    }

    /* Print out Javascript code and exit */
    $len = strlen($count);
    for ($i=0;$i<$len;$i++)
    {
        echo 'document.write(\'<img src="'.$base_url . $style_dir . substr($count,$i,1) . '.' . $ext .'" border="0">\');';
    }
    exit();

}
else
{
    die('ERROR: Invalid log file!');
}

/* This functin handles input parameters making sure nothing dangerous is passed in */
function input($in)
{
    $out = htmlentities(stripslashes($in));
    $out = str_replace(array('/','\\'), '', $out);
    return $out;
}
?>
