<?php
ob_start();//打开缓冲区，可以setcookie
include("../../inc/conn.php");
include '../ucenter_api/config.inc.php';//集成ucenter
include '../ucenter_api/uc_client/client.php';//集成ucenter
require_once("API/qqConnectAPI.php");
$qc = new QC();
$arr = $qc->get_user_info();
$qq_nicheng=$arr["nickname"];
$qq_touxiang=$arr["figureurl_1"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>QQ登录</title>
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<script>
function CheckForm(){
  if (document.form1.UserName.value==""){	
	alert("请输入用户名！");
	document.form1.UserName.focus();
	return false;
	}
    //创建正则表达式
    var re=/^[0-9a-zA-Z]{4,14}$/; //只输入数字和字母的正则
    //var re=/^[\u4e00-\u9fa5]{1,10}$/; //只输入汉字的正则
    if(document.form1.UserName.value.search(re)==-1){
	alert("用户名只能为字母和数字，字符介于4到14个。");
	document.form1.UserName.value="";
	document.form1.UserName.focus();
    return false;
    }
	 if (document.form1.pwd.value==""){	
	alert("请输入密码！");
	document.form1.pwd.focus();
	return false;
	}
}
</script>
</head>
<body>
<div class="main">

<?php
include("../../inc/top2.php");
echo sitetop();
$username=$_POST["username"];
$pwd=$_POST["pwd"];
$qqid=$_POST["qqid"];

if ($qqid==""){
$errmsg=$errmsg . "参数不足";
WriteErrMsg($errmsg);
}else{
	$rs=query("select qqid from zzcms_user where qqid='".$qqid."'");
	$row=num_rows($rs);
	if (!$row){
?>
	<div class="bordercccccc" style="height:300px">
	<div class="titlebig center" > <img src="<?php echo $qq_touxiang;?>" border="0"> <?php echo  $qq_nicheng	?> 您是首次用QQ登录，请按提示完成绑定</div>
	<?php
		if ($_POST["isuser"]==1 && $_POST["action"]=="step2") {
				//绑定已有会员帐号
				$sql="select * from zzcms_user where lockuser=0 and username='". $username ."' and password='". md5($pwd) ."'";
				$rs=query($sql);
				$row=num_rows($rs);
				if (!$row){
				WriteErrMsg("用户名或密码不正确或者您的用户被锁定了。");
				}else{
				query("update zzcms_user set qqid='".$qqid."' where username='".$username."'");
				//登录
				query("UPDATE zzcms_user SET showlogintime = lastlogintime where qqid='".$qqid."'");//更新上次登录时间
				query("UPDATE zzcms_user SET showloginip = loginip where qqid='".$qqid."'");//更新上次登录IP
				query("UPDATE zzcms_user SET logins = logins+1 where qqid='".$qqid."'");
				query("UPDATE zzcms_user SET loginip = '".getip()."' where qqid='".$qqid."'");//更新最后登录IP
					if (strtotime(date("Y-m-d H:i:s"))-strtotime($row['lastlogintime'])>86400){
					query("UPDATE zzcms_user SET totleRMB = totleRMB+".jf_login." WHERE qqid='".$qqid."'");//登录时加积分
					}
				query("UPDATE zzcms_user SET lastlogintime = '".date('Y-m-d H:i:s')."' WHERE qqid='".$qqid."'");//更新最后登录时间

		
				$rs=query("select username,password from zzcms_user where qqid='".$qqid."'");
				$row=fetch_array($rs);
				if ($CookieDate==1){
				setcookie("UserName",$row['username'],time()+3600*24,"/");
				setcookie("PassWord",$row['password'],time()+3600*24,"/");
				}elseif($CookieDate==0){
				setcookie("UserName",$row['username'],time()+3600*24,"/");
				setcookie("PassWord",$row['password'],time()+3600*24,"/");
				}

				//集成ucenter
				if (bbs_set=='Yes'){	
				list($uid, $username, $password, $email) = uc_user_login($_POST["username"], $_POST['pwd']);
				setcookie('Example_auth', '', -86400);
				if($uid > 0) {
					//用户登录成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
					setcookie('Example_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
					//生成同步登录的代码
					$ucsynlogin = uc_user_synlogin($uid);
					echo '同时登录论坛成功'.$ucsynlogin;//必须输出，否则不同步
					} elseif($uid == -1) {
						echo '论坛用户不存在,或者被删除';
					} elseif($uid == -2) {
					echo '密码错';
					} else {
					echo '未定义';
					}
				}	
				//end
				echo "<script>location.href='/index.php'</script>";
				}
	}	
	if ($_POST["action"]==""){
	?>
	<form name="form2" id="form2" method="post" action="">
      
        <table width="100%" height="100" border="0" cellpadding="10" cellspacing="0">
          <tr>
            <td width="38%">&nbsp;</td>
            <td width="62%" class="bigbigword"><input type="radio" name="isuser" id="isuseryes" value="1" onclick="this.form.submit()"/>
              <label for="isuseryes">已是本站会员</label></td>
          </tr>
      <tr> 
        <td>&nbsp;</td>
          <td class="bigbigword">
<input type="radio" name="isuser" id="radio" value="0" onClick="this.form.submit()"/> 
          <label for="radio"> 不是本站会员</label> 
          <input name="action" type="hidden" id="action4" value="step1" />
          <input name="qqid" type="hidden" id="action" value="<?php echo $qqid;?>" /></td>
      </tr>
    </table>
      </form>
	  <?php
	  }elseif ($_POST["action"]=="step1"){
			if ($_POST["isuser"]==1) {
	  ?>
<form name="form1" id="form1" method="post" action="" onSubmit="return CheckForm()">
        <table width="100%" height="100" border="0" cellpadding="10" cellspacing="0">
          <tr> 
            <td width="38%" align="right" class="bigbigword">&nbsp;</td>
            <td width="62%">请输入您的用户名，密码</td>
          </tr>
          <tr> 
            <td align="right" class="bigbigword">用户名</td>
            <td width="62%"><input name="username" type="text" id="username" /></td>
          </tr>
          <tr> 
            <td width="38%" align="right" class="bigbigword">密　码</td>
            <td><input name="pwd" type="password" id="pwd" /></td>
          </tr>
          <tr> 
            <td width="38%" align="right">&nbsp;</td>
            <td><input type="submit" name="Submit2" value="绑定登录QQ" /> <input name="action" type="hidden" id="action6" value="step2" /> 
              <input name="isuser" type="hidden" id="isuser3" value="1" /> <span class="bigbigword">
              <input name="qqid" type="hidden" id="qqid" value="<?php echo $qqid;?>" />
              </span></td>
          </tr>
        </table>
</form>
			<?php	
			}elseif ($_POST["isuser"]==0) {
			?>
<form name="form2" id="form2" method="post" action="/reg/<?php echo getpageurl3("userreg")?>">
        <table width="100%" height="100" border="0" cellpadding="10" cellspacing="0">
          <tr> 
            <td width="38%">&nbsp;</td>
            <td width="62%">请先注册成为本站会员后再用QQ登录</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="62%"><input type="submit" name="Submit" value="免费注册" style="height:40px;width:80px" /></td>
          </tr>
        </table>
</form>
<?php
			}
	}
		
}else{
//直接登录
query("UPDATE zzcms_user SET showlogintime = lastlogintime where qqid='".$qqid."'");//更新上次登录时间
query("UPDATE zzcms_user SET showloginip = loginip where qqid='".$qqid."'");//更新上次登录IP
query("UPDATE zzcms_user SET logins = logins+1 where qqid='".$qqid."'");
query("UPDATE zzcms_user SET loginip = '".getip()."' where qqid='".$qqid."'");//更新最后登录IP
	if (strtotime(date("Y-m-d H:i:s"))-strtotime($row['lastlogintime'])>86400){
	query("UPDATE zzcms_user SET totleRMB = totleRMB+".jf_login." WHERE qqid='".$qqid."'");//登录时加积分
	}
query("UPDATE zzcms_user SET lastlogintime = '".date('Y-m-d H:i:s')."' WHERE qqid='".$qqid."'");//更新最后登录时间
	
$rs=query("select username,password,passwordtrue from zzcms_user where qqid='".$qqid."'");
$row=fetch_array($rs);
if ($CookieDate==1){
setcookie("UserName",$row['username'],time()+3600*24,"/");
setcookie("PassWord",$row['password'],time()+3600*24,"/");
}elseif($CookieDate==0){
setcookie("UserName",$row['username'],time()+3600*24,"/");
setcookie("PassWord",$row['password'],time()+3600*24,"/");
echo '<span class=bigbigword>登录成功，正在跳转，请稍候……</span><br>';
}

//集成ucenter
if(bbs_set=='Yes'){
	list($uid, $username, $password, $email) = uc_user_login($row['username'], $row['passwordtrue']);
	setcookie('Example_auth', '', -86400);
	if($uid > 0) {
		//用户登录成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
		setcookie('Example_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
		//生成同步登录的代码
		$ucsynlogin = uc_user_synlogin($uid);
		echo '同时登录论坛成功'.$ucsynlogin;//必须输出，否则不同步
		
	} elseif($uid == -1) {
		echo '论坛用户不存在,或者被删除';
	} elseif($uid == -2) {
		echo '密码错';
	} else {
		echo '未定义';
	}
}	
//end
//echo "<script>location.href='/index.php'<//script>";
echo "<script>parent.location.href='/index.php'</script>";
	}
}
?>
</div>
<?php
include("../../inc/bottom_company.htm");

?>
</div>
</body>
</html>