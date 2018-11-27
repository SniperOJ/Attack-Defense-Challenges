<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/vip_add.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
$ErrMsg="";
$FoundErr=0;
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if (isset($_POST["canshu"])){
$groupid=$_POST["canshu"];//由VIPUSER.php传来的值
checkid($groupid);
}else{
$groupid=2;
}
//groupid=$_POST("groupid");

if ($action=="modify"){
	$sj=trim($_POST["sj"]);
	$startdate=date('Y-m-d');
	if ($sj<>""){
	checkid($sj);
	}
	$enddate=date('Y-m-d',time()+60*60*24*365);
		
    $rs=query("Select RMB from zzcms_usergroup where groupid='$groupid'");
	$row=fetch_array($rs);
	$totleRMB=$sj*$row["RMB"];
	
	$rs=query("select * from zzcms_user where username='" . $username ."'");
	$row=num_rows($rs);
	if (!$row){
		$FoundErr=1;
		$ErrMsg=$ErrMsg. $f_array[0];
		WriteErrMsg($ErrMsg);
	}else{
	$row=fetch_array($rs);
		if ($row["groupid"]>=$groupid){
			$FoundErr=1;
			$ErrMsg=$ErrMsg . $f_array[1];
			WriteErrMsg($ErrMsg);
		}else{
			if ($row["totleRMB"]<$totleRMB){
			$FoundErr=1;
			$ErrMsg=$ErrMsg . $f_array[2];
			WriteErrMsg($ErrMsg);
			}else{
			query("update zzcms_user set groupid='$groupid',startdate='$startdate',enddate='$enddate',totleRMB=totleRMB-".$totleRMB." where username='" . $username ."'");			
			query("Update zzcms_main set groupid=" . $groupid . " where editor='" . $username . "'");
			query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime)values('$username','". $f_array[3]."','$totleRMB','".$f_array[4].$startdate."-".$enddate."','".date('Y-m-d H:i:s')."')");
			echo $f_array[5];
			}
		}
	}	
}else{		
				
?>
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
<div class="admintitle"><?php echo $f_array[6]?></div>
<FORM name="myform" action="?action=modify" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
            <tr> 
              <td width="15%" align="right" class="border"><?php echo $f_array[7]?></td>
              <td width="85%" class="border"><?php echo $username?></td>
            </tr>
            <tr> 
              <td align="right" class="border2"><?php echo $f_array[8]?></td>
                    <td class="border2"> 
                      <?php
$rs=query("Select groupname from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$username."')");
$row=fetch_array($rs);
echo $row["groupname"];
?>
                      <a href="/one/vipuser.php" target="_blank"><strong><?php echo $f_array[9]?>
                      </strong></a></td>
            </tr>
            <tr> 
              <td align="right" class="border2"><?php echo $f_array[10]?></td>
              <td width="85%" class="border2"> <select name="canshu">
                  <?php
				
     $rs=query("Select * from zzcms_usergroup ");
	 $row=num_rows($rs);
     if ($row){
	 while($row=fetch_array($rs)){
	 ?>
      <option value="<?php echo $row["groupid"]?>" <?php if ($row["groupid"]==$groupid){ echo "selected";}?>><?php echo $row["groupname"]?>(<?php echo $row["RMB"].$f_array[11]?>)</option>
    <?php
	}
	}
			?>
                </select>
              </td>
            </tr>
            <tr> 
              <td align="right" class="border"><?php echo $f_array[12]?></td>
              <td class="border"><select name="sj" id="sj">
			  <?php echo $f_array[13]?>
                 
                </select> </td>
            </tr>
            <tr > 
              <td align="right" class="border2">&nbsp;</td>
              <td class="border2"> <input name="Submit2"   type="submit" class="buttons" id="Submit2" value="<?php echo $f_array[14]?>"></td>
            </tr>
          </table>
  </form>
</div>
</div>
</div> 
</div> 
</body>
</html>
<?php
}

unset ($f_array);
?>