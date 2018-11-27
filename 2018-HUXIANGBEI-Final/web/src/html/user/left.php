<?php 
//if(!isset($_SERVER['HTTP_REFERER'])){//禁止从外部直接打开
//exit;
//}

if (isset($_COOKIE["UserName"])){

$fpath="text/left.txt";
$fcontent=file_get_contents($fpath);
$f_array_left=explode("\n",$fcontent) ;
$current_url=$_SERVER['PHP_SELF'];
$c_name= substr( $current_url,strrpos($current_url,'/')+1);  
?>
<script type="text/javascript">
<!--
function disp(n){
for (var i=0;i<9;i++){
	if (!document.getElementById("left"+i)) return;			
		document.getElementById("left"+i).style.display="none";
	}
	document.getElementById("left"+n).style.display="";
}

function Confirmdeluser(){
   if(confirm("注销后将不能恢复！确定要注销帐户么？"))
     return true;
   else
     return false;	 
}	
//-->
</script>
<div id="left1" style="display:block"  class="leftcontent"> 
<div class="lefttitle"><img src="image/ico/ico4.gif"> <?php echo $f_array_left[0]?> </div>
<div>
<ul>
<?php
if (str_is_inarr(usergr_power,'zs')=='yes'|| $usersf=='公司'){
	if ($c_name=='zsadd.php'||$c_name=='zsmanage.php'||$c_name=='zsmodify.php'||$c_name=='zspx.php'||$c_name=='zs_elite.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='zsadd.php' target='_self'>".$f_array_left[1].channelzs."</a> | <a href='zsmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
}

if (str_is_inarr(channel,'pp')=='yes'){
if (str_is_inarr(usergr_power,'pp')=='yes'|| $usersf=='公司'){
	if ($c_name=='ppadd.php'||$c_name=='ppmanage.php'||$c_name=='ppmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='ppadd.php' target='_self'>".$f_array_left[3]."</a> | <a href='ppmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";	
}
}

if (str_is_inarr(usergr_power,'dl')=='yes'|| $usersf=='公司'){
	if ($c_name=='dladd.php'||$c_name=='dlmanage.php'||$c_name=='dlmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='dladd.php' target='_self'>".$f_array_left[1].channeldl."</a> | <a href='dlmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
}

if (str_is_inarr(channel,'baojia')=='yes'){
if (str_is_inarr(usergr_power,'baojia')=='yes'|| $usersf=='公司'){
	if ($c_name=='baojiaadd.php'||$c_name=='baojiamanage.php'||$c_name=='baojiamodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='baojiaadd.php' target='_self'>发报价</a> | <a href='baojiamanage.php' target='_self'>管理</a></li> ";
}
}

if (str_is_inarr(channel,'zh')=='yes'){
if (str_is_inarr(usergr_power,'zh')=='yes'|| $usersf=='公司'){
	if ($c_name=='zhadd.php'||$c_name=='zhmanage.php'||$c_name=='zhmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='zhadd.php' target='_self'>".$f_array_left[4]."</a> | <a href='zhmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
}
}

if (str_is_inarr(channel,'wangkan')=='yes'){
if (str_is_inarr(usergr_power,'wangkan')=='yes'|| $usersf=='公司'){
	if ($c_name=='wangkanadd.php'||$c_name=='wangkanmanage.php'||$c_name=='wangkanmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='wangkanadd.php' target='_self'>".$f_array_left[42]."</a> | <a href='wangkanmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
}
}

if (str_is_inarr(channel,'zx')=='yes'){
if (str_is_inarr(usergr_power,'zx')=='yes'|| $usersf=='公司'){
	if ($c_name=='zxadd.php'||$c_name=='zxmanage.php'||$c_name=='zxmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='zxadd.php' target='_self'>".$f_array_left[5]."</a> | <a href='zxmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
}
}

if (str_is_inarr(channel,'special')=='yes'){
if (str_is_inarr(usergr_power,'special')=='yes'|| $usersf=='公司'){
	if ($c_name=='specialadd.php'||$c_name=='specialmanage.php'||$c_name=='specialmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='specialadd.php' target='_self'>".$f_array_left[6]."</a> | <a href='specialmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
}
}

if (str_is_inarr(channel,'ask')=='yes'){
if (str_is_inarr(usergr_power,'ask')=='yes'|| $usersf=='公司'){
	if ($c_name=='askadd.php'||$c_name=='askmanage.php'||$c_name=='askmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='askadd.php' target='_self'>发问答</a> | <a href='askmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
}
}

if (str_is_inarr(channel,'job')=='yes'){
if (str_is_inarr(usergr_power,'job')=='yes'|| $usersf=='公司'){
	if ($c_name=='jobadd.php'||$c_name=='jobmanage.php'||$c_name=='jobmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='jobadd.php' target='_self'>".$f_array_left[7]."</a> | <a href='jobmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
}
}

$sql_left="select classid from zzcms_zxclass where classname='公司新闻' ";
$rs_left=query($sql_left);
$row_left=fetch_array($rs_left);

if (str_is_inarr(channel,'zx')=='yes'){
if (str_is_inarr(usergr_power,'zx')=='yes'|| $usersf=='公司'){
	if ($c_name=='zxadd.php'||$c_name=='zxmanage.php'||$c_name=='zxmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='index.php?gotopage=zxadd.php&b=".$row_left['classid']."' target='_self'>".$f_array_left[8]."</a> | <a href='zxmanage.php?bigclassid=".$row_left['classid']."' target='_self'>".$f_array_left[2]."</a></li> ";
}
}

if ($c_name=='advadd.php'||$c_name=='advmanage.php'||$c_name=='advmodify.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='advadd.php' target='_self'>".$f_array_left[9]."</a> | <a href='advmanage.php' target='_self'>".$f_array_left[2]."</a></li> ";
?>
</ul>
</div>
</div>

<?php if (str_is_inarr(usergr_power,'zs')=='yes'|| $usersf=='公司'){?>
<div id="left2" style="display:block" class="leftcontent">
<div class="lefttitle"><img src="image/ico/ico8.gif"> <?php echo $f_array_left[10]?></div>
<div>
<ul>
<?php
if ($c_name=='dls_message_manage.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='dls_message_manage.php' target='_self'>".$f_array_left[11]."</a> ";		  
$sql_left="select id from zzcms_dl where saver='".@$username."' and looked=0 and del=0 and passed=1";
$rs_left=query($sql_left);
$row_left=num_rows($rs_left);
if($row_left){
echo "<span class='buttons'>".$row_left."</span>";
}
echo "</li>";

if ($c_name=='ztliuyan.php'){
	echo "<li class='current2'>";
	}else{
	echo "<li class='current1'>";
	}
echo "<a href='ztliuyan.php?show=all' target='_self'>".$f_array_left[12]."</a> ";

$sql_left="select id from zzcms_guestbook where saver='".@$username."' and looked=0 and passed=1";
$rs_left=query($sql_left);
$row_left=num_rows($rs_left);
if($row_left){
echo "<span class='buttons'>".$row_left."</span>";
}
echo "</li>";
?>			
</ul>		
</div>
</div>
<?php }?>

<div id="left3" style="display:block" class="leftcontent"> 		
<div class="lefttitle"> <img src="image/ico/ico9.gif" width="12" height="16"> <?php echo $f_array_left[13]?></div>
<div> 
<ul>
<li><a href="adv.php" target="_self"><?php echo $f_array_left[14]?></a></li>
<li><a href="adv2.php" target="_self"><?php echo $f_array_left[15]?></a><img src="image/ico/ico6.gif" width="23" height="12"></li>
</ul>
</div>
</div>

<?php 
if ($usersf=="公司"){ 
?>	
<div id="left4" style="display:block" class="leftcontent"> 
<div class="lefttitle"><img src="image/ico/ico5.gif" width="16" height="16"> <?php echo $f_array_left[16]?></div>
<div>
<ul>			
<li><a href="licence_add.php" target="_self"> <?php echo $f_array_left[17]?></a></li> 
<li><a href="licence.php" target="_self" ><?php echo $f_array_left[18]?></a></li>
</ul>
</div>
</div>
<?php 
}
?>
<div id="left5" style="display:block" class="leftcontent"> 
<div class="lefttitle"><img src="image/ico/ico7.gif" width="16" height="15"> <?php echo $f_array_left[19]?></div>
<div>
<ul>	
<li><a href="/3/alipay/" target="_blank"> <?php echo $f_array_left[20]?></a></li>
<li><a href="/3/tenpay/" target="_blank"> <?php echo $f_array_left[21]?></a></li>
<li><a href="pay_manage.php" target="_self"> <?php echo $f_array_left[22]?></a></li>
</ul>
</div>
</div>
			
<div id="left6" style="display:block" class="leftcontent"> 
<div class="lefttitle"><img src="image/ico/ico10.gif" width="16" height="16"> <?php echo $f_array_left[23]?></div>
<div>
<ul>
<li><a href="vip_add.php" target="_self"><?php echo $f_array_left[24]?></a></li> 
<li><a href="vip_xufei.php" target="_self"><?php echo $f_array_left[25]?></a></li> 
<li><a href="manage.php" target="_self"><?php echo $f_array_left[26]?></a></li>
<li><a href="managepwd.php" target="_self"><?php echo $f_array_left[27]?></a></li>
<li><a href="/one/vipuser.php" target="_blank"><?php echo $f_array_left[28]?></a></li>
<li><a href="index.php" target="_self"><?php echo $f_array_left[29]?></a></li> 
</ul>
</div>
</div>
<?php if ($usersf=="公司"){ ?>
<div id="left7" style="display:block" class="leftcontent"> 
<div class="lefttitle"><img src="image/ico/ico10.gif" width="16" height="16"> <?php echo $f_array_left[30]?></div>
<div>
<ul>
<li><a href="ztconfig_skin.php" target="_self"> <?php echo $f_array_left[31]?></a></li>
<li><a href="ztconfig_skin_mobile.php" target="_self"><?php echo $f_array_left[32]?></a></li>
<li><a href="ztconfig.php" target="_self"> <?php echo $f_array_left[33]?></a></li>
<li><a href="domain_manage.php" target="_self"> 绑定顶级域名</a></li>
</ul>
</div>
</div>				
<?php 
}
?>				
<div id="left8" style="display:block" class="leftcontent">			
<div class="lefttitle"><img src="image/ico/ico8.gif"> <?php echo $f_array_left[34]?></div>
<div>
<ul>
<li><a href="msg_manage.php" target="_self" ><?php echo $f_array_left[35]?></a></li>
<li><a href="../dl/dl.php" target="_blank"><?php echo str_replace("{#channeldl}",channeldl,$f_array_left[36])?></a></li>			
</ul>		
</div>
</div>		

<div id="left9" style="display:block" class="leftcontent"> 
<div class="lefttitle"><img src="image/ico/ico3.gif"> <?php echo $f_array_left[37]?></div>
<div>
<ul>
<li><a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=<?php echo kfqq?>&Site=<?php echo sitename?>&Menu=yes><img border="0" src=http://wpa.qq.com/pa?p=1:<?php echo kfqq ?>:4><?php echo $f_array_left[38]?></a></li>
<li><a href="#"><?php echo $f_array_left[39].kftel?></a></li>
<li><a href="/one/help.php" target="_blank"><?php echo $f_array_left[40]?></a></li>
<li><a href="message.php"><?php echo $f_array_left[41]?></a></li>
</ul>
</div>
</div>
<?php 
}
unset ($f_array_left);
?>