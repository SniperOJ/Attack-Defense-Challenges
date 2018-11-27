<?php
if (!isset($_SESSION['dlliuyan'])){
$_SESSION['dlliuyan']='';
}
$rs=query("select config from zzcms_usergroup where groupid=$groupid");
$row=fetch_array($rs);
$showcontact=str_is_inarr($row["config"],'showcontact');
$siteleft="<div class='titleleft'>联系人</div>";
$siteleft=$siteleft."<div class='contentleft'>";
if ($showcontact=="yes" || $_SESSION["dlliuyan"]==$editor) {
$siteleft=$siteleft. "<ul>";
$siteleft=$siteleft. "<li><b>".$somane."</b>&nbsp;&nbsp; ";
if ($sex==1){ 
$siteleft=$siteleft. "先生";
}elseif ($sex==0){ 
$siteleft=$siteleft. "女士";
}
$siteleft=$siteleft. "</li>";
$siteleft=$siteleft. "<li>电话：".$phone."</li>";
$siteleft=$siteleft. "<li>手机：".$mobile."</li>";
$siteleft=$siteleft. "<li>传真：".$fox."</li>";

if ($qq<>""){
$siteleft=$siteleft. "<li><a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=".$qq."&Site=".sitename."&Menu=yes><img border='0' src=http://wpa.qq.com/pa?p=1:".$qq.":10 alt='QQ交流'></a> </li>";
}
$siteleft=$siteleft. "<li>";
if (whtml=="Yes"){ 
$siteleft=$siteleft. "<a href='contact-".$id.".htm' style='text-decoration: underline;font-weight:bold'>";
}else{ 
$siteleft=$siteleft. "<a href='contact.php?id=".$id."#contact' style='text-decoration: underline;font-weight:bold'>";
}
$siteleft=$siteleft. "详细信息";
$siteleft=$siteleft. "</a></li>";
$siteleft=$siteleft. "</ul>";
}else{
$siteleft=$siteleft. "<ul>";
$siteleft=$siteleft. "<li>联系方式不显示</li>";
$siteleft=$siteleft. "</ul>";
}

$siteleft=$siteleft. "</div>";
//以下显示招商分类
if (isset($_REQUEST['bigclass'])){
$bigclass=$_REQUEST['bigclass'];
}else{
$bigclass="";
}

if (isset($_REQUEST['smallclass'])){
$smallclass=$_REQUEST['smallclass'];
}else{
$smallclass="";
}
$siteleft=$siteleft. "<div class='titleleft'>分类".channelzs."</div>";

$siteleft=$siteleft. "<div class='contentleft'>";
$rsleft=query("select bigclasszm from zzcms_main where editor='".$editor."'and bigclasszm<>'' group by bigclasszm");
$rowleft=num_rows($rsleft);
if ($rowleft){
	while ($rowleft=fetch_array($rsleft)){
		$rsb=query("select classname from zzcms_zsclass where classzm='".$rowleft["bigclasszm"]."'");
		$rowb=num_rows($rsb);
		if ($rowb){
		$rowb=fetch_array($rsb);
		$bigclassnames=cutstr($rowb["classname"],5);
		}else{
		$bigclassnames="大类已删除";
		}
		
		$rsb=query("select count(id) from zzcms_main where editor='".$editor."'and bigclasszm='".$rowleft["bigclasszm"]."'");
		$numb=mysql_result($rsb,0);
		
		$siteleft=$siteleft."<li style='font-weight:bold'>";
		if ($rowleft["bigclasszm"]==$bigclass){
			if (whtml=="Yes"){
			$siteleft=$siteleft."<a href='zs-".$id."-".$rowleft["bigclasszm"].".htm' style='color:red'>".$bigclassnames."</a>";
			}else{
			$siteleft=$siteleft."<a href='zs.php?id=".$id."&bigclass=".$rowleft["bigclasszm"]."' style='color:red'>".$bigclassnames."</a>";
			}
		}else{
			if (whtml=="Yes"){
			$siteleft=$siteleft."<a href='zs-".$id."-".$rowleft["bigclasszm"].".htm'>".$bigclassnames."</a>";
			}else{	
			$siteleft=$siteleft."<a href='zs.php?id=".$id."&bigclass=".$rowleft["bigclasszm"]."'>".$bigclassnames ."</a>";
			}
		}
		$siteleft=$siteleft."&nbsp;(<span style='color:#ff6600'>".$numb."</span>)";
		$siteleft=$siteleft."</li>";
		
		
		
		
		$rsn=query("select smallclasszm from zzcms_main where editor='".$editor."'and bigclasszm='".$rowleft["bigclasszm"]."' and smallclasszm<>''");
		$rown=num_rows($rsn);
		if ($rown){
		$smallclasszms="";
		while ($rown=fetch_array($rsn)){
		$smallclasszms=$smallclasszms.$rown["smallclasszm"].",";
		//echo $rown["smallclasszm"].","."<br/>";
		}
		}
	
		$smallclasszms=substr($smallclasszms,0,strlen($smallclasszms)-1);//去除最后面的","
		
		echo $smallclasszms;
		//exit;
		
		$rsn=query("select classzm from zzcms_zsclass where parentid='".$rowleft["bigclasszm"]."' and classzm in ($smallclasszms)");
		$rown=num_rows($rsn);
		if ($rown){
			while ($rown=fetch_array($rsn)){
				$rss=query("select classname from zzcms_zsclass where classzm='".$rown["classzm"]."'");
				$rows=num_rows($rss);
				if ($rows){
				$rows=fetch_array($rss);
				$smallclassnames=$rows["classname"];
				}else{
				$smallclassnames="小类已删除";
				}
				
				$rss=query("select count(id) from zzcms_main where editor='".$editor."'and smallclasszm='".$rown["classzm"]."'");
				$nums=mysql_result($rss,0);
		
				$siteleft=$siteleft."<li style='list-style:none;'>";
				if ($rown["classzm"]==$smallclass){
					if (whtml=="Yes"){
					$siteleft=$siteleft."<a href='zs-".$id."-".$rowleft["bigclasszm"]."-".$rown["classzm"].".htm' style='color:red'>".$smallclassnames."</a>";
					}else{
					$siteleft=$siteleft."<a href='zs.php?id=".$id."&bigclass=".$rowleft["bigclasszm"]."&smallclass=".$rown["classzm"]."' style='color:red'>".$smallclassnames."</a>";
					}
				}else{
					if (whtml=="Yes"){
					$siteleft=$siteleft.  "<a href='zs-".$id."-".$rowleft["bigclasszm"]."-".$rown["classzm"].".htm'>".$smallclassnames."</a>";
					}else{	
					$siteleft=$siteleft. "<a href='zs.php?id=".$id."&bigclass=".$rowleft["bigclasszm"]."&smallclass=".$rown["classzm"]."'>".$smallclassnames ."</a>";
					}
				}
				$siteleft=$siteleft."&nbsp;(<span style='color:#ff6600'>".$nums."</span>)";
				$siteleft=$siteleft."</li>";
			}
		}else{
		$siteleft=$siteleft. "暂无信息";
		}	
	}
}else{
$siteleft=$siteleft. "暂无信息";
}
$siteleft=$siteleft. "</div>";

?>			