<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/managepwd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 transitional//EN" "http://www.w3.org/tr/xhtml1/Dtd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
include "../inc/mail_class.php";
include '../3/ucenter_api/config.inc.php';//集成ucenter
include '../3/ucenter_api/uc_client/client.php';//集成ucenter
include '../3/mobile_msg/inc.php';
?>
<title><?php echo $f_array[0]?></title>
<script>
function CheckForm(){
<?php echo $f_array[1]?>
}
</script>
</head>
<body>
<?php
if (isset($_POST["action"])){
$action=$_POST["action"];
}else{
$action="";
}
$founderr=0;
if ($action=="modify") {
$oldpassword=md5(trim($_POST["oldpassword"]));
$password=md5(trim($_POST["password"]));
	$sql="select password,email,mobile from zzcms_user where username='" . $username . "'";
	$rs=query($sql);
	$row=fetch_array($rs);
	if ($oldpassword<>$row["password"]){
	$founderr=1;
	$errmsg=$f_array[2];
	}
	if ($founderr==1){
	WriteErrMsg($errmsg);
	}else{
	query("update zzcms_user set password='$password',passwordtrue='".trim($_POST["password"])."' where username='".$username."'");
		if (whenmodifypassword=="Yes"){
$smtp=new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
//$smtp->debug = true; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释
$to = $row['email']; //收件人
$subject = $f_array[3].sitename;
$body= str_replace("{#siteurl}",siteurl,str_replace("{#password}",trim($_POST["password"]),str_replace("{#username}",$username,$f_array[4])));
$fp="../template/".siteskin."/email.htm";
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#body}",$body,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#logourl}",logourl,$strout) ;
$body=$strout;
$send=$smtp->sendmail($to,sender,$subject,$body,"HTML");//邮件的类型可选值是 TXT 或 HTML 
$msg= str_replace("{#password}",trim($_POST["password"]),str_replace("{#username}",$username,$f_array[5]));
$msg = iconv("UTF-8","GBK",$msg);
$result = sendSMS(smsusername,smsuserpass,$row['mobile'],$msg,apikey_mobile_msg);//发手机短信	
		}
		//集成ucenter	
		if (bbs_set=='Yes'){	
		$ucresult = uc_user_edit($username, $_POST['oldpassword'], $_POST['password'], $row["email"]);
		}
		//end
	echo $f_array[6];
	}
}else{

?>
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
<div class="admintitle"><?php echo $f_array[0]?></div>
<form name="form1" action="?" method="post" onsubmit="return CheckForm()">
<table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr>             
            <td width="15%" align="right" class="border"><?php echo $f_array[7]?></td>  
      <td width="85%" class="border"><?php echo $username ?></td>
            </tr>
            <tr>   
            <td align="right" class="border2"><?php echo $f_array[8]?></td>      
      <td class="border2"> 
        <INPUT  type="password" maxLength="16" size="30" name="oldpassword" class="biaodan"> 
              </td>
            </tr>
            <tr> 
            <td align="right" class="border"><?php echo $f_array[9]?></td>     
      <td class="border"> 
        <INPUT  type="password" maxLength="16" size="30" name="password" class="biaodan"> 
              </td>
            </tr>
            <tr>      
            <td align="right" class="border2"><?php echo $f_array[10]?></td>     
      <td class="border2">
<INPUT name=pwdconfirm   type=password id="pwdconfirm" size="30" maxLength="16" class="biaodan">
                <input name="action" type="hidden" id="action" value="modify"> 
              </td>
            </tr>
            <tr>      
      <td align="center" class="border">&nbsp; </td>   
      <td class="border"> 
        <input name="Submit"   type="submit" class="buttons" id="Submit" value="<?php echo $f_array[11]?>">
      </td>
            </tr>
          </table>
</form>
</div>
</div>
</div>
</div>
<?php
}

unset ($f_array);
?>
</body>
</html>