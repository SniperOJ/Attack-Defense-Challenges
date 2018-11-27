<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/adv2.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[0]?></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if (qiangad=="No"){

echo $f_array[1];
exit;
}

$rs=query("select * from zzcms_ad");
$row=num_rows($rs);
if ($row){
while($row = fetch_array($rs)){
	if (time()-strtotime($row['sendtime'])>24*3600*showadvdate and $row['elite']==0){
	query("Update zzcms_ad set username='' where id=".$row['id']."");
	}
}
}

$rs=query("select usersf from zzcms_user where username='".$_COOKIE["UserName"]."' ");
$row=fetch_array($rs);
if ($row["usersf"]=="个人"){
echo $f_array[2];

exit;
}
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}

function setAdv($ispay){
global $f_array;
$rs=query("select * from zzcms_main where editor='".$_COOKIE["UserName"]."'");
$row=num_rows($rs);
if (!$row){
$a=0;
}else{
$a=1;
}

$rs=query("select * from zzcms_zh where editor='".$_COOKIE["UserName"]."'");
$row=num_rows($rs);
if (!$row){
$c=0;
}else{
$c=1;
}

if ($a+$c==0){     
	echo replace_str("{#chanagezs}",chanagezs,$f_array[3]);
}else{
	$rs=query("select * from zzcms_textadv where username='".$_COOKIE["UserName"]."'");
	$row=num_rows($rs);
	if (!$row){ 
	echo $f_array[4];
	}else{
		$rs=query("select * from zzcms_ad where username='".$_COOKIE["UserName"]."' or nextuser='".$_COOKIE["UserName"]."'");
		$row=num_rows($rs);
		if ($row){ 
		echo $f_array[5];
       }else{
              $rs=query("select * from zzcms_ad where id=".$_POST["id"]."");//'使用From 传值为防止通过地址栏直接提交数值，造成非法抢占。
		      $row=fetch_array($rs);
              if ($row["nextuser"]<>""){//当几个用户点击同一个抢占按纽时(即抢占同一样位置)，这里就会有最先抢得的那个用户名
		      echo str_replace("{#nextuser}",$row["nextuser"],$f_array[6]);
		      }else{
			  		if ($ispay==1){//当用户组没有权限参占时，扣费
					 	$rsn=query("select totleRMB from zzcms_user where username='".$_COOKIE["UserName"]."'");
			  			$rown=fetch_array($rsn);			
                    
			        	if ($rown["totleRMB"]>=jf_set_adv){
						query("update zzcms_user set totleRMB=totleRMB-".jf_set_adv." where username='".$_COOKIE["UserName"]."'");//'扣除积分
						query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".@$_COOKIE['UserName']."','".$f_array[7]."','-".jf_set_adv."','-".jf_set_adv."','".date('Y-m-d H:i:s')."')");
						echo str_replace("{#jf_set_adv}",jf_set_adv,$f_array[8]);
						}else{
						echo str_replace("{#jf_set_adv}",jf_set_adv,$f_array[9]);
						exit;
						}
			  		}
			query("update zzcms_ad set nextuser='".$_COOKIE["UserName"]."' where id=".$_POST["id"]."");		
		    	//在表中记录抢占人以备下面显示用，另一作用就是以此为标记，此位置未被审核之前，不再让此用户抢占其它广告位，审核后通过后，这里的值会被清空
			  query("update zzcms_textadv set newsid='".$_POST["id"]."',passed=0 where username='".$_COOKIE["UserName"]."'"); //把占得的ID值写入到表textadv中
              //passed=0只要抢占位置了，不管以前审核是否通过，现在要重审，重审的目的是执行表中内容的复制由textadv至news
              $rs=query("select * from zzcms_textadv where username='".$_COOKIE["UserName"]."'");
			  $row=fetch_array($rs);
			  if (time()-strtotime($row['gxsj'])>24*3600*showadvdate ){
			  query("update zzcms_textadv set gxsj='".date('Y-m-d H:i:s')."' where username='".$_COOKIE["UserName"]."'");
		      }//如果上次修改广告词的时间至今天已大于广告显示期，那么就更新抢占时间，否则不更新，为了防止一个用户通过修改广告词功能长期霸占一个位置。
	          echo $f_array[10];
		      }
      	}
	}
}

}

if ($action=="modify"){
switch (check_user_power("set_text_adv")){
case "no";
	if (jifen=="Yes"){
	setAdv(1);
	}else{
	echo $f_array[11];
	}
	break;
case "yes";
	setAdv(0);
	break;
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
<div class="admintitle"><?php echo $f_array[12] ?></div>
<div class="box"><?php echo str_replace("{#showadvdate}",showadvdate,$f_array[13])?></div>
<br><div class="admintitle"><?php echo $f_array[14] ?></div>	  
<?php
$n=1;
$rs=query("select * from zzcms_ad where bigclassname='首页' and smallclassname='A' order by xuhao asc,id asc");
$row=num_rows($rs);
if (!$row){
echo $f_array[15];
}else{
?> 
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
  <tr> 
		<?php while($row=fetch_array($rs)){ ?>      
    <td width="25%" height="50"   class="border" ><?php echo "A".$n?> 
	<a href='<?php echo $row["link"]?>' target='_blank'><?php echo $row["title"]?></a> 
      <?php
if ($row["elite"]==1){
echo $f_array[16];
}else{
	  if (time()-strtotime($row['sendtime'])>24*3600*showadvdate){
	  ?>
      <form name="form1" method="post" action="">
              <input name="action" type="hidden" id="action" value="modify">
              <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>">
              <?php if ($row["nextuser"]<>""){//如果审核没被通过，且被删除后，相对应的nextuser值同时也被删。
					echo  str_replace("{#nextuser}",$row["nextuser"],$f_array[17]);
					}else{
				?>
        <input name="Submit" type="submit"  value="<?php echo $f_array[18]?>">
              	<?php
				}
			?>
          </form>
       	<?php
	}else{
		?>
		<div><input name="Submit" style="width:160px" type="button"  disabled value="<?php echo str_replace("{#day}",number_format((24*3600*showadvdate-(time()-strtotime($row['sendtime'])))/(24*3600),1,'.',''),$f_array[19])?>"></div>
		<?php
		}
}		
		?>
    </td>
<?php
if ($n % 4==0){ 
echo "</tr>";
}
$n=$n+1;
}
?>
</table>
<?php
}
?>
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