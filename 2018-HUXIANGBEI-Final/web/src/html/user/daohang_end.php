<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<div class="content">
          <div class="box"> 
            <?php echo "<b>".$username."</b>"?>
            恭喜您成为本站用户！<br>
            从现在起，您便拥有一个永不落幕的网上展厅！<br>
            开始吧！先去看看我的展厅
<?php
	if ($usersf=='公司'){
	echo ' | ';
		if (sdomain=="Yes"){
			echo"<a href='http://".$username.".".substr(siteurl,strpos(siteurl,".")+1)."' target='_blank'>http://".$username.".".substr(siteurl,strpos(siteurl,".")+1)."</a>";
		}else{
			echo"<a href='".getpageurl("zt",$userid)."' target='_blank'>".siteurl.getpageurl("zt",$userid)."</a>";
		}
	}
 
?>
</div>
</div>      
</div>
</div>
</div>
</body>
</html>