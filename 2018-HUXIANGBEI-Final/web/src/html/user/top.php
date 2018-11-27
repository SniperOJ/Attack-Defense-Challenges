<?php
//if(!isset($_SERVER['HTTP_REFERER'])){//禁止从外部直接打开
//exit;
//}

if (isset($_COOKIE["UserName"])){

$fpath="text/top.txt";
$fcontent=file_get_contents($fpath);
$f_array_top=explode("\n",$fcontent) ;
?>
<div class="menu">
  <div class="system_logo"></div>
  <div id="tabs"> 
    <ul>
	 <?php 
	 if ($usersf=="公司")
	 { 
	 ?>
      <li><a href="zsmanage.php" target="_self"><span><?php echo $f_array_top[0]?></span></a></li>
      <li><a href="dls_message_manage.php"  target="_self"><span><?php echo  $f_array_top[1]?></span></a></li>
      <li><a href="adv2.php"  target="_self"><span><?php echo $f_array_top[2]?></span></a></li>
      <li><a href="licence.php" target="_self"><span><?php echo $f_array_top[3]?></span></a></li>
      <li><a href="pay_manage.php" target="_self"><span><?php echo $f_array_top[4]?></span></a></li>
      <?php
	  }
	  ?>
      <li><a href="manage.php"  target="_self"><span><?php echo $f_array_top[5]?></span></a></li>
      <li><a href="managepwd.php"  target="_self"><span><?php echo $f_array_top[6]?></span></a></li>
	  
	  <?php
	  if (str_is_inarr(usergr_power,'zt')=='yes' || $usersf=='公司'){
	  ?>
	  <li><a href="ztconfig.php"  target="_self"><span><?php echo $f_array_top[7]?></span></a></li>
	   <?php 
	   }
	  ?>
    </ul>
	</div>
</div>
<div style="clear:both"></div>
<div class="userbar"> <span style="float:right"> [ <a href="/<?php echo getpageurl3("index")?>" target="_top"> 
  <?php echo $f_array_top[8]?></a> 
  <?php
	if (str_is_inarr(usergr_power,'zt')=='yes' || $usersf=='公司'){
	echo " | ";
		if (sdomain=="Yes"){
			echo "<a href='http://".$username.".".substr(siteurl,strpos(siteurl,".")+1)."' target='_blank'>".$f_array_top[9]."</a>";
		}else{
			echo "<a href='".getpageurl("zt",$userid)."'  target='_blank'>".$f_array_top[9]."</a>";	
		}
	}
	  ?>
        | <a href='/one/help.php#64' target='blank'><?php echo $f_array_top[10]?></a> | <a href="logout.php" target="_top"><?php echo $f_array_top[11]?></a> ] </span>
		<?php echo $f_array_top[12]?><strong><?php echo $_COOKIE["UserName"];?></strong>( <?php echo ShowUserSf();?>) 
<?php
}

function ShowUserSf(){
global $f_array_top;
	if ($_COOKIE["UserName"]<>"" ){
		$sql="select groupname,grouppic from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$_COOKIE["UserName"]."')";
        $rs=query($sql);
		$row=fetch_array($rs);
		$rownum=num_rows($rs);
		if ($rownum){
        $str= "<b>".$row["groupname"]."</b><img src='../".$row["grouppic"]."'> " ;
		}
 		   
		$sql="select groupid,totleRMB,startdate,enddate from zzcms_user where username='" .$_COOKIE["UserName"]. "'";
        $rs=query($sql);
		$row=fetch_array($rs);
		$rownum=num_rows($rs);
		if ($rownum){
			if ($row["groupid"]>1){
			$str=$str .$f_array_top[13].$row["startdate"]." 至 ".$row["enddate"];
			}elseif ($row["groupid"]==1){
			$str=$str . "<a href='/one/vipuser.php' target='_blank'>".$f_array_top[14]."</a>";
			}
		}else{
			$str=$str . $f_array_top[15];
		}		
		
	}else{
	$str=$str. $f_array_top[16];
	}
unset ($f_array_top);	
echo $str;			 
}
?>		
</div>