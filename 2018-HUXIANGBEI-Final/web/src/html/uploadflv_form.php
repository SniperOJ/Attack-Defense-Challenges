<?php
if(!isset($_SESSION)){session_start();}
if (!isset($_COOKIE["UserName"]) && !isset($_SESSION["admin"])){
session_write_close();
echo "No Login!";
exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache,no-store, must-revalidate">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
<META HTTP-EQUIV="expires" CONTENT="0">
<title>上传图片</title>
<script>
function mysub(){
	esave.style.visibility="visible";
}
function checkform(){
if (document.form1.flvurl.value=="")
  {
    alert("此处不能为空！");
	document.form1.flvurl.focus();
	return false;
  }
}
</script>
<script language="JavaScript" type="text/JavaScript"  src="/js/qt.js"></script>
<style type="text/css">
BODY{font-size:14px;background-color: transparent;margin:0px;padding:0px}
form{margin:0px;}
ul,li{list-style:none;}
a{color:#333;text-decoration: none;}
.boxitem {width:100%;height:27px;background:url(/image/x.gif) repeat-x 0  bottom}
.boxitem li{float:left;margin:0 5px;}
.boxitem a{padding:5px;border:solid 1px #cccccc;border-bottom:0px;display:block;}
.current{background-color:#f1f1f1;}
.content{background-color:#f1f1f1;}
</style>
</head>
<base target=_self>
<body>
<div class="boxitem" id="A"> 
      <ul> 
	  	<li><a id="A2" href="#" onClick="javascript:doClick(this,'A','current')" class="current">网络视频</a></li>  
        <li><a id="A1" href="#" onClick="javascript:doClick(this,'A','current')">本地视频</a></li>
                          
       </ul>
</div> 		          
<div class="content"> 
<div style="display:none;" id="A_con1">
<form action="uploadflv.php" method="post" enctype="multipart/form-data" style="padding:10px" onSubmit="return mysub()" target="doaction">
<div id="esave" style="position:absolute; top:0px; left:0px; z-index:10; visibility:hidden; width: 100%; height: 50%; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000;"> 
<div align="center"><p>&nbsp;</p><p><img src="image/loading.gif" width="24" height="24" /><br /><br />正在上传中...请稍候！不要关闭本窗口。</p></div>
</div>
<input type="file" name="g_fu_image[]" /><input type="submit" name="Submit" value="上传" />
</form>
</div>
		  
<div style="display:block;" id="A_con2">
<form name="form1" id="form1" method="post" action="uploadflv_form.php" style="padding:10px" onSubmit='checkform()'>
<input name="flvurl" type="text" id="flvurl" size="40" maxlength="255" /><input type="submit" name="Submit2" value="提交" />
</form>
</div>
</div>  
<?php
$flvurl=@$_POST['flvurl'];
if ($flvurl<>''){
	$js="<script language=javascript>";
	$js=$js."parent.window.opener.valueFormOpenwindowForFlv('" . $flvurl ."');";//读取父页面中的JS函数传回值
	$js=$js."parent.window.close();";
	$js=$js."</script>";
echo $js;
}
?>
<iframe style="display:none" name="doaction"></iframe>
</body>
</html>