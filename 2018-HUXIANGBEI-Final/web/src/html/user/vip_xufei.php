<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/vip_xufei.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
$ErrMsg="";
$FoundErr=0;
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
$rs=query("Select * from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$username."')");
$row=fetch_array($rs);
$groupname=$row["groupname"];
$RMB_xufei=$row["RMB"];

if( $action=="modify"){
	$sj=trim($_POST["sj"]);
	if ($sj<>"") {
	checkid($sj);
	}

	$rs=query("select * from zzcms_user where username='" . $username ."'");
	$row=num_rows($rs);
	if (!$row){
		$FoundErr=1;
		$ErrMsg=$ErrMsg. $f_array[0];
		WriteErrMsg($ErrMsg);
	}else{
	$row=fetch_array($rs);
	$enddate=$row['enddate'];
		if ($row["groupid"]==1){
		$FoundErr=1;
		$ErrMsg=$ErrMsg .$f_array[1] ;
		WriteErrMsg($ErrMsg);
		}else{
			if ($row["totleRMB"]< $RMB_xufei) {
			$FoundErr=1;
			$ErrMsg=$ErrMsg .$f_array[2];
			WriteErrMsg($ErrMsg);
			}else{			
			query("update zzcms_user set enddate='".date('Y-m-d',strtotime($enddate)+3600*24*365*$sj)."',totleRMB=totleRMB-".$sj*$RMB_xufei." where username='" . $username ."'");
			query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime)values('$username','".$f_array[3]."','".$sj*$RMB_xufei."','".$f_array[4].$sj.$f_array[5]."','".date('Y-m-d H:i:s')."')");
		
			echo $f_array[6];
			}
		}
	}	
}else{
$rs=query("select * from zzcms_user where username='" . $username ."'");
$row=fetch_array($rs);		
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
<div class="admintitle"><?php echo $f_array[7]?></div>
<FORM name="myform" action="?action=modify" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
            <tr> 
              <td width="15%" align="right" class="border"><?php echo $f_array[8]?></td>
              <td width="85%" class="border"><?php echo  $username?></td>
            </tr>
            <tr> 
              <td align="right" class="border2"><?php echo $f_array[9]?></td>
              <td width="85%" class="border2"> <?php echo $groupname?> </td>
            </tr>
			<?php if ($row["groupid"]>1){ ?>
            <tr> 
              <td align="right" class="border"><?php echo $groupname?><?php echo $f_array[10]?></td>
              <td class="border"> <?php echo $row["startdate"]?> </td>
            </tr>
            <tr> 
              <td align="right" class="border2"><?php echo $groupname?><?php echo $f_array[11]?></td>
              <td class="border2"> <?php echo $row["enddate"]?>  </td>
            </tr>
			<?php
			}
			?>
            <tr> 
              <td align="right" class="border"><?php echo $f_array[12]?></td>
              <td class="border"><select name="sj" id="sj">
                  <option value="1" selected><?php echo $f_array[13]?>(<?php echo $RMB_xufei.$f_array[17]?>)</option>
                  <option value="2"><?php echo $f_array[14]?>(<?php echo 2*$RMB_xufei.$f_array[17]?>)</option>
                  <option value="3"><?php echo $f_array[15]?>(<?php echo 3*$RMB_xufei.$f_array[17]?>)</option>
                  <option value="5"><?php echo $f_array[16]?>(<?php echo 5*$RMB_xufei.$f_array[17]?>)</option>
                </select> </td>
            </tr>
            <tr > 
              <td align="right" class="border2">&nbsp;</td>
              <td class="border2"> <input name="Submit2"   type="submit" class="buttons" id="Submit2" value="<?php echo $f_array[18]?>"></td>
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