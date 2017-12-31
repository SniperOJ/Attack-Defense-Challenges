<?php
session_start();
require_once("include/common.php");
require_once(sea_INC."/filter.inc.php");
require_once(sea_INC.'/main.class.php');

if($cfg_feedbackstart=='0'){
	showMsg('对不起，报错功能暂时关闭','index.php');
	exit();
}

$id=$_GET['id'];
$id=intval($id);
$row1 = $dsql->GetOne("SELECT v_name FROM `sea_data` WHERE `v_id` = '$id' ORDER BY `v_id` DESC ");
		if(!is_array($row1)){
			showMsg('请勿恶意提交报错数据','index.php');
			exit();
		}

if(empty($action)) $action = '';
if($action=='add')
{
	$ip = GetIP();
	$sendtime = time();
	
	//检查验证码是否正确
if($cfg_feedback_ck=='1')
{	
	$validate = empty($validate) ? '' : strtolower(trim($validate));
	$svali = $_SESSION['sea_ckstr'];
	if($validate=='' || $validate != $svali)
	{
		ResetVdValue();
		ShowMsg('验证码不正确!','-1');
		exit();
	}
}	
	//检查报错间隔时间；
	if(!empty($cfg_feedback_times))
	{
		$row = $dsql->GetOne("SELECT sendtime FROM `sea_erradd` WHERE `ip` = '$ip' ORDER BY `id` DESC ");
		if($sendtime - $row['sendtime'] < $cfg_feedback_times)
		{
			ShowMsg("提交过快，歇会再来报错吧","-1");
			exit();
		}
	}
	
	
$id=$_SERVER['HTTP_REFERER'];
$id=getSubStrByFromAndEnd($id,"?id=","","start");
$id = !empty($id) && is_numeric($id) ? $id : 0;
$ip = GetIP();
$author = HtmlReplace($author);
$errtxt = trimMsg(cn_substr($errtxt,2000),1);
$time = time();
	
if(!preg_match("/[".chr(0xa1)."-".chr(0xff)."]/",$errtxt)){
		showMsg('你必需输入中文才能发表!','-1');
		exit();
	}
if($author=='' || $errtxt=='') {
		showMsg('你的名字和报错内容不能为空!','-1');
		exit();
	}

	$query = "INSERT INTO `sea_erradd`(vid,author,ip,errtxt,sendtime)
                  VALUES ('$id','$author','$ip','$errtxt','$time'); ";
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("谢谢您对本网站的支持，我们会尽快处理您的报错！","index.php");
	exit();
}
?>

<html>
    <head>
    	<title>影片报错</title>
        <script>
			function checkReportErr(){if (document.getElementById('author').value.length<1){alert('请填写报错者');return false;}; if (document.getElementById('errtxt').value.length<1){alert('请填写报错内容');return false;}}
        </script>
		<style>
		h2,p{padding:0; margin:0;}
		h2{font-size:14px;height:25px;color:#027DB9;line-height:25px;background:#B4E5FE;text-align:center;margin-bottom:10px;}
		.err{width:380px;height:185px;background:#F5FBFE;border:1px solid #B0DCF5;margin: 0 auto}
		.err p{margin-left:10px;} 
		</style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body  style="font-size:12px;background-color:#D7EDFA;height:22px;line-height:22px;">
        <form id="reporterr" action="?id=<?php echo $id ?>&action=add" method="post" onSubmit="return checkReportErr()">
            <div class="err">
			<h2>失效影片，我们会在第一时间内修正</h2>
               <p style="padding-bottom:5px;">昵称:<input type="text" id="author" name="author"  value="匿名"  size="15"><font color="#FF0000">*必填</font></p>
			
                <p>详情:<textarea id="errtxt"  name="errtxt" style="width:270px;height:88px" rows=5 cols=30></textarea>
                <font color="#FF0000">*必填</font></p>
				<?php
				$vcode="<p>验证：<input name=\"validate\" type=\"text\" id=\"vdcode\" style=\"width:50px;text-transform:uppercase;\" class=\"text\" tabindex=\"3\"/> <img id=\"vdimgck\" src=\"include/vdimgck.php\" alt=\"看不清？点击更换\"  align=\"absmiddle\"  style=\"cursor:pointer\" onClick=\"this.src=this.src+'?get=' + new Date()\"/><span class=\"red\"></span></p>";
				if($cfg_feedback_ck=='1'){echo $vcode;}
				?>
                <input type="submit" value="影片报错" style="margin:5px 0 0 130px;">
            </div>
        </form>
    </body>
</html>