<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/ztliuyan_show.txt";
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
<?php
$id=trim($_REQUEST["id"]);
if ($id<>""){
checkid($id);
}else{
$id=0;
}
?>
</head>
<body>
<?php
$sql="select * from zzcms_guestbook where id='$id'";
$rs=query($sql,$conn);
$row=num_rows($rs);
if (!$row){
echo  $f_array[1];
}else{
$row=fetch_array($rs);
$dlsname=$row['linkmen'];
$tel=$row['phone'];
$email=$row['email'];
$looked=$row['looked'];
function showlx($dlsname,$tel,$email){ 
global $f_array;
$str="<table width='100%' border='0' cellpadding=5 cellspacing=1 class=bgcolor>";
$str=$str."<tr>";
$str=$str."<td width=22% align=right class=bgcolor1>".$f_array[2]."</td>";
$str=$str."<td width=78% bgcolor=#FFFFFF>".$dlsname."</td>";
$str=$str."</tr>";
$str=$str."<tr>";
$str=$str."<td align=right class=bgcolor1>".$f_array[3]."</td>";
$str=$str."<td bgcolor=#FFFFFF>".$tel."</td>";
$str=$str."</tr>";
$str=$str."<tr> ";
$str=$str."<td align=right class=bgcolor1>".$f_array[4]."</td>";
$str=$str."<td bgcolor=#FFFFFF>".$email."</td>";
$str=$str."</tr>";
$str=$str."</table>";
return $str;
}
if ($row["saver"]<>$_COOKIE["UserName"]){
markit();
echo $f_array[5];
exit;
}
?>
<div class="content">
<div class="admintitle"><?php echo $f_array[6]?></div> 
    <table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
          <tr>
            <td width="22%" align="right" class="bgcolor1"><?php echo $f_array[7]?></td>
            <td width="78%" bgcolor="#FFFFFF"><?php echo $row["title"]?></td>
          </tr>
          <tr>
            <td align="right" class="bgcolor1"><?php echo $f_array[8]?></td>
            <td bgcolor="#FFFFFF"><?php echo nl2br($row["content"])?></td>
          </tr>
          <tr>
            <td align="right" class="bgcolor1"><?php echo $f_array[9]?></td>
            <td bgcolor="#FFFFFF"><?php echo $row["sendtime"]?></td>
          </tr>
</table><br>
        <div class="admintitle"><?php echo $f_array[10]?></div>
		  
 <?php
         switch  (check_user_power("look_dls_liuyan")){
			case "yes" ;
			query("update zzcms_guestbook set looked=1 where id='$id'");
            echo showlx($dlsname,$tel,$email);
			break;
			case "no";
			    if (jifen=="Yes"){
				    if ($looked==1) {
					echo showlx($dlsname,$tel,$email);
					}
					if (isset($_POST["action"])){
					$action=$_POST["action"];
					}else{
					$action="";
					}
					
					if ($action=="" && $looked==0) {?>
            		<div class="box">
					<form name="form1" method="post" action="">
                    <input type="submit" name="Submit2" style="height:30px" value="<?php echo $f_array[11].jf_lookmessage?>">
                    <input name="action" type="hidden" id="action" value="kan">
                  	</form>
				  	</div>		
					<?php		
			    	}elseif ($action=="kan" && $looked==0) {
                    $sql="select totleRMB from zzcms_user where username='".$_COOKIE["UserName"]."'";
					$rsuser=query($sql);
					$rowuser=fetch_array($rsuser);
			        	if ($rowuser["totleRMB"]>=jf_lookmessage) {
						query("update zzcms_user set totleRMB=totleRMB-".jf_lookmessage." where username='".$_COOKIE["UserName"]."'");//查看时扣除积分
						query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".@$_COOKIE['UserName']."','".$f_array[12]."','-".jf_lookmessage."','<a href=ztliuyan_show.php?id=$id>$id</a>','".date('Y-m-d H:i:s')."')");//写入冲值记录 
			       		query("update zzcms_guestbook set looked=1 where id='$id'");
						echo showlx($dlsname,$tel,$email);
						}else{
						echo str_replace("{#jf_lookmessage}",jf_lookmessage,$f_array[13]);
		            	?>
						<div class="box">
						<input name="Submit22" type="button"  value="<?php echo $f_array[14]?>" onClick="location.href='/one/vipuser.php'"/>
						</div>
		         		<?php    
				 		}
					}	
			}elseif (jifen=="No" ){
			?>
<div class="box">
<?php echo $f_array[15]?><br><br><input name="Submit22" type="button"  value="<?php echo $f_array[16]?>" onClick="location.href='/one/vipuser.php'"/>
	</div>
             
			<?php
			}
		break;
		}
}
?>

</div>
</body>
</html>