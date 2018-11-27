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
if (document.form1.flvurl.value==""){
    alert("此处不能为空！");
	document.form1.flvurl.focus();
	return false;
  }
}
//这段函数是重点，不然不能和CKEditor互动了   
function funCallback(funcNum,fileUrl){   
    var parentWindow = ( window.parent == window ) ? window.opener : window.parent;   
    parentWindow.CKEDITOR.tools.callFunction(funcNum, fileUrl);   
    window.close();   
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
	  	<li><a id="A2" href="#" onClick="javascript:doClick(this,'A','current')">网络图片</a></li>  
        <li><a id="A1" href="#" onClick="javascript:doClick(this,'A','current')" class="current">本地图片</a></li>                  
     </ul>
</div> 

<div class="content"> 
<div style="display:block;" id="A_con1">
<form action="uploadimg.php" method="post" enctype="multipart/form-data" onSubmit="return mysub()" style="padding:10px" target="doaction">
<div id="esave" style="position:absolute; top:0px; left:0px; z-index:10; visibility:hidden; width: 100%; height: 77px; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000;"> 
<div align="center"><br /><img src="image/loading.gif" width="24" height="24" />正在上传中...请稍候！</div>
</div>
<input type="file" name="g_fu_image[]" /><input type="submit" name="Submit" value="提交" />
<input name="noshuiyin" type="hidden" id="noshuiyin" value="<?php echo @$_GET['noshuiyin']?>" />
<input name="imgid" type="hidden" id="imgid" value="<?php echo @$_GET['imgid']?>" />
</form>
</div>
<div style="display:none;" id="A_con2">
<form name="form1" id="form1" method="post" action="" style="padding:10px" onSubmit='checkform()'>
<input name="flvurl" type="text" id="flvurl" size="40" maxlength="255" /><input type="submit" name="Submit2" value="提交" />
</form>
</div>
</div>  
<?php
$flvurl=@$_POST['flvurl'];
if ($flvurl<>''){
	$js="<script language=javascript>";
	if (@$_GET['imgid']==2){
	$js=$js."parent.window.opener.valueFormOpenwindow2('" . $flvurl ."');";//读取父页面中的JS函数传回值
	}else{
	$js=$js."parent.window.opener.valueFormOpenwindow('" . $flvurl ."');";//读取父页面中的JS函数传回值
	}
	$js=$js."parent.window.close();";
	$js=$js."</script>";
echo $js;
}
?>		
<iframe style="display:none" name="doaction"></iframe>
</body>
</html>