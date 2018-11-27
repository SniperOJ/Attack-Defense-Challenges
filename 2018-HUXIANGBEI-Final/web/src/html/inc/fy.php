<?php
$fpath="../inc/text/fy.txt";
$fcontent=file_get_contents($fpath);
$f_array_fy=explode("\n",$fcontent) ;

function showpage_admin(){
global $page,$totlepage,$totlenum,$page_size,$shenhe,$b,$s,$kind,$keyword,$showwhat;
$cs="";
if ($shenhe!=''){$cs=$cs."&shenhe=".$shenhe;}
if ($keyword!=''){$cs=$cs."&keyword=".$keyword;}
if ($b!=''){$cs=$cs."&b=".$b;}
if ($s!=''){$cs=$cs."&s=".$s;}
if ($kind<>''){$cs=$cs."&kind=".$kind;}
if ($showwhat<>''){$cs=$cs."&showwhat=".$showwhat;}

$str="页次：<strong><font color=#CC0033>".$page."</font>/".$totlepage."　</strong> ";
$str=$str." <strong>".$page_size."</strong>条/页　共<strong>".$totlenum."</strong>条";		 
 
if ($page!=1){
$str=$str."【<a href=?page=1".$cs.">首页</a>】";
$str=$str."【<a href=?page=".($page-1).$cs.">上一页</a>】";
}else{
$str=$str."【首页】【上一页】";
}
if ($page!=$totlepage){
$str=$str."【<a href=?page=".($page+1).$cs.">下一页</a>】";
$str=$str."【<a href=?page=".$totlepage.$cs.">尾页</a>】";
}else{
$str=$str."【下一页】【尾页】";
}
return $str;
}

function showpage($b='no'){
global $page,$totlepage,$totlenum,$page_size,$bigclassid,$f_array_fy;
$str=$f_array_fy[0]."<strong><font color=#CC0033>".$page."</font>/".$totlepage."　</strong> ";
$str=$str." <strong>".$page_size."</strong>".$f_array_fy[1]."&nbsp;".$f_array_fy[2]."<strong>".$totlenum."</strong>".$f_array_fy[3];		 
  
if ($page!=1){
	if ($b=="yes"){
	$str=$str."<a href=?page=1&bigclassid=".$bigclassid.">".$f_array_fy[4]."</a> ";
	$str=$str."<a href=?page=".($page-1)."&bigclassid=".$bigclassid.">".$f_array_fy[5]."</a> ";
	}else{
	$str=$str."<a href=?page=1>".$f_array_fy[4]."</a> ";
	$str=$str."<a href=?page=".($page-1).">".$f_array_fy[5]."</a> ";
	}
}else{
$str=$str.$f_array_fy[4].$f_array_fy[5];
}
if ($page!=$totlepage){
	if ($b=="yes"){
	$str=$str."<a href=?page=".($page+1)."&bigclassid=".$bigclassid.">".$f_array_fy[6]."</a> ";
	$str=$str."<a href=?page=".$totlepage."&bigclassid=".$bigclassid.">".$f_array_fy[7]."</a>";
	}else{	
	$str=$str."<a href=?page=".($page+1).">".$f_array_fy[6]."</a> ";
	$str=$str."<a href=?page=".$totlepage.">".$f_array_fy[7]."</a>";
	}
}else{
$str=$str.$f_array_fy[6].$f_array_fy[7];
}
return $str;
}

function showpage1(){
global $page,$totlepage,$totlenum,$page_size,$keyword,$yiju,$szm,$typeid;
//$cs="&keyword=".$keyword."&province=".$province."&city=".$city."&xiancheng=".$xiancheng."&b=".$b."&s=".$s."&sj=".$sj."&yiju=".$yiju;
//这个用在搜索页中，在搜索页中上面的大多数参数都写在cookies中了
$str="";
$cs='';
if ($keyword!=''){$cs=$cs."&keyword=".$keyword;}
if ($yiju!=''){$cs=$cs."&yiju=".$yiju;}
if ($szm!=''){$cs=$cs."&szm=".$szm;}
if ($typeid!=999){$cs=$cs."&typeid=".$typeid;}
$str=$str."<a><nobr>共".$totlenum."</nobr></a>";
		if ($page<>1) {
			$str=$str . "<a href='?page=1".$cs."' title='转到第一页'><nobr>&lt;&lt;</nobr></a>";
			$str=$str . "<a href='?page=".($page-1).$cs."' title='转到上一页' >&lt;</a>";
		}
		if ($page <10){
        $StartNum = 1;
        }else{
        $StartNum = $page-5;
        }
        $EndNum = $StartNum+9;
        if ($EndNum > $totlepage ){
        $EndNum = $totlepage;
        }
   for($a=$StartNum; $a<=$EndNum;$a++){
        if ($a==$page){
        $str=$str . "<span>".$a."</span>";
        }else{
        $str=$str . "<a href='?page=".$a.$cs."'><nobr>".$a."</nobr></a>";
		}
	}
		if ($page<>$totlepage) {
			$str=$str . "<a href='?page=".($page+1).$cs."' title='转到下一页'>&gt;</a>";
			$str=$str . "<a href='?page=".$totlepage.$cs."' title='转到第".$totlepage."页'><nobr>&gt;&gt;</nobr></a>";
		}
		return $str;
}

function showpage2($channel){
global $b,$s,$page,$totlepage,$totlenum,$page_size;
$str="<form name='formpage' action='/".$channel."/".$channel.".php' method='get' target='_self' onsubmit='return checkpage();'>";
$str=$str."<a><nobr>共".$totlenum."</nobr></a>";
		if ($page<>1){
			if (whtml=="Yes") {
				if ($s<>"") {
				$str=$str ."<a href='/".$channel."/".$b."/".$s."/1.htm' title='转到第一页'><nobr>&lt;&lt;</nobr></a>";//<nobr>防止手机浏览时A内的内容被换行
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".($page-1).".htm' title='转到上一页'>&lt;</a>";
				}
				elseif ($b<>"") {
				$str=$str . "<a href='/".$channel."/".$b."/1.htm' title='转到第一页'><nobr>&lt;&lt;</nobr></a>";
				$str=$str . "<a href='/".$channel."/".$b."/".($page-1).".htm' title='转到上一页'>&lt;</a>";
				}else{
				$str=$str . "<a href='/".$channel."/1.htm' title='转到第一页'>&lt;&lt;</a>";
				$str=$str . "<a href='/".$channel."/".($page-1).".htm' title='转到上一页'>&lt;</a>";
				}
			}else{
				if ($s<>"") {
				$str=$str . "<a href='?page=1&b=".$b."&s=".$s."' title='转到第一页'><nobr>&lt;&lt;</nobr></a>";
				$str=$str . "<a href='?page=".($page-1)."&b=".$b."&s=".$s."' title='转到上一页'>&lt;</a>";
				}elseif($b<>''){
				$str=$str . "<a href='?page=1&b=".$b."' title='转到第一页'><nobr>&lt;&lt;</nobr></a>";
				$str=$str . "<a href='?page=".($page-1)."&b=".$b."' title='转到上一页'>&lt;</a>";
				}else{
				$str=$str . "<a href='?page=1' title='转到第一页'><nobr>&lt;&lt;</nobr></a>";
				$str=$str . "<a href='?page=".($page-1)."' title='转到上一页'>&lt;</a>";
				}
			}
		}
		
		if ($page <10) {
        $StartNum = 1;
        }else{
        $StartNum = $page-5;
        }
        $EndNum = $StartNum+9;
        if ($EndNum > $totlepage) {
        $EndNum = $totlepage;
        }
   for($a=$StartNum; $a<=$EndNum;$a++){
        if ($a==$page) {
		$str=$str . "<span>".$a."</span>";
        }else{
			if (whtml=="Yes") {
				if ($s<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".$a.".htm'><nobr>".$a."</nobr></a>";
				}elseif($b<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".$a.".htm'><nobr>".$a."</nobr></a>";
				}else{
				$str=$str . "<a href='/".$channel."/".$a.".htm'><nobr>".$a."</nobr></a>";
				}
			}else{
				if ($s<>"") {
				$str=$str . "<a href='?page=".$a."&b=".$b."&s=".$s."'><nobr>".$a."</nobr></a>";
				}elseif($b<>""){
        		$str=$str . "<a href='?page=".$a."&b=".$b."'><nobr>".$a."</nobr></a>";
				}else{
				$str=$str . "<a href='?page=".$a."'><nobr>".$a."</nobr></a>";
				}
			}
		}	
	}
	
		if ($page<>$totlepage ){
			if (whtml=="Yes") {
				if ($s<>"") {
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".($page+1).".htm' title='转到下一页'>&gt;</a>";
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".$totlepage.".htm' title='转到第".$totlepage."页'><nobr>&gt;&gt;</nobr></a>";
				}elseif ($b<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".($page+1).".htm' title='转到下一页'>&gt;</a>";
				$str=$str . "<a href='/".$channel."/".$b."/".$totlepage.".htm' title='转到第".$totlepage."页'><nobr>&gt;&gt;</nobr></a>";
				}else{
				$str=$str . "<a href='/".$channel."/".($page+1).".htm' title='转到下一页'>&gt;</a>";
				$str=$str . "<a href='/".$channel."/".$totlepage.".htm' title='转到第".$totlepage."页'><nobr>&gt;&gt;</nobr></a>";
				}
			}else{
				if ($s<>""){
				$str=$str . "<a href='?page=".($page+1)."&b=".$b."&s=".$s."' title='转到下一页'>&gt;</a>";
				$str=$str . "<a href='?page=".$totlepage."&b=".$b."&s=".$s."' title='转到第".$totlepage."页'><nobr>&gt;&gt;</nobr></a>";
				}elseif ($b<>""){
				$str=$str . "<a href='?page=".($page+1)."&b=".$b."' title='转到下一页'>&gt;</a>";
				$str=$str . "<a href='?page=".$totlepage."&b=".$b."' title='转到第".$totlepage."页'><nobr>&gt;&gt;</nobr></a>";
				}else{
				$str=$str . "<a href='?page=".($page+1)."' title='转到下一页'>&gt;</a>";
				$str=$str . "<a href='?page=".$totlepage."' title='转到第".$totlepage."页'><nobr>&gt;&gt;</nobr></a>";
				}
			}
		}
$str=$str."\n";		
$str=$str."<input name='page' type='text' maxlength='10' value='$page' class='biaodan' style='width:40px;'/>";
$str=$str."<input type='submit'name='submit' value='GO' class='button'/>";
$str=$str."<input name='b' type='hidden' value='$b'/><input name='s' type='hidden' value='$s'/>";
$str=$str."</form>";	
return $str;
}

function showpage3($channel){//倒显，最新的信息，用新页码显示，老信息用原来的老页码，专用于生成静态页，这样老静态页不用重复生成。
global $b,$s,$page,$totlepage,$totlenum,$page_size;
$str="<form name='formpage' action='/".$channel."/".$channel.".php' method='get' target='_self' onsubmit='return checkpage();'>";
		if ($page<>$totlepage){
			if (whtml=="Yes") {
				if ($s<>"") {
				$str=$str ."<a href='/".$channel."/".$b."/".$s."/".$totlepage.".htm' title='转到第".$totlepage."页'><nobr>&lt;&lt;</nobr></a>";//<nobr>防止手机浏览时A内的内容被换行
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".($page+1).".htm' title='转到下一页'>&lt;</a>";
				}
				elseif ($b<>"") {
				$str=$str . "<a href='/".$channel."/".$b."/".$totlepage.".htm' title='转到第".$totlepage."页'><nobr>&lt;&lt;</nobr></a>";
				$str=$str . "<a href='/".$channel."/".$b."/".($page+1).".htm' title='转到下一页'>&lt;</a>";
				}else{
				$str=$str . "<a href='/".$channel."/".$totlepage.".htm' title='转到第".$totlepage."页'>&lt;&lt;</a>";
				$str=$str . "<a href='/".$channel."/".($page+1).".htm' title='转到下一页'>&lt;</a>";
				}
			}else{
				if ($s<>"") {
				$str=$str . "<a href='?page=".$totlepage."&b=".$b."&s=".$s."' title='转到第".$totlepage."页'><nobr>&lt;&lt;</nobr></a>";
				$str=$str . "<a href='?page=".($page+1)."&b=".$b."&s=".$s."' title='转到下一页'>&lt;</a>";
				}elseif($b<>''){
				$str=$str . "<a href='?page=".$totlepage."&b=".$b."' title='转到第".$totlepage."页'><nobr>&lt;&lt;</nobr></a>";
				$str=$str . "<a href='?page=".($page+1)."&b=".$b."' title='转到下一页'>&lt;</a>";
				}else{
				$str=$str . "<a href='?page=".$totlepage."' title='转到第".$totlepage."页'><nobr>&lt;&lt;</nobr></a>";
				$str=$str . "<a href='?page=".($page+1)."' title='转到下一页'>&lt;</a>";
				}
			}
		}
		if ($totlepage-$page <5) {		
		$EndNum=$totlepage;
		}else{
        $EndNum = $page+5;
        }
        $StartNum = $EndNum-9;
        if ($StartNum < 1 ){
        $StartNum = 1;
        }
	for($a=$EndNum; $a>=$StartNum;$a--){
        if ($a==$page) {
		$str=$str . "<span>".$a."</span>";
        }else{
			if (whtml=="Yes") {
				if ($s<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".$a.".htm'><nobr>".$a."</nobr></a>";
				}elseif($b<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".$a.".htm'><nobr>".$a."</nobr></a>";
				}else{
				$str=$str . "<a href='/".$channel."/".$a.".htm'><nobr>".$a."</nobr></a>";
				}
			}else{
				if ($s<>"") {
				$str=$str . "<a href='?page=".$a."&b=".$b."&s=".$s."'><nobr>".$a."</nobr></a>";
				}elseif($b<>""){
        		$str=$str . "<a href='?page=".$a."&b=".$b."'><nobr>".$a."</nobr></a>";
				}else{
				$str=$str . "<a href='?page=".$a."'><nobr>".$a."</nobr></a>";
				}
			}
		}	
	}
		
		if ($page<>1){
			if (whtml=="Yes") {
				if ($s<>"") {
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".($page-1).".htm' title='转到上一页'>&gt;</a>";
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/1.htm' title='转到第1页'><nobr>&gt;&gt;</nobr></a>";
				}elseif ($b<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".($page-1).".htm' title='转到上一页'>&gt;</a>";
				$str=$str . "<a href='/".$channel."/".$b."/1.htm' title='转到第1页'><nobr>&gt;&gt;</nobr></a>";
				}else{
				$str=$str . "<a href='/".$channel."/".($page-1).".htm' title='转到上一页'>&gt;</a>";
				$str=$str . "<a href='/".$channel."/1.htm' title='转到第1页'><nobr>&gt;&gt;</nobr></a>";
				}
			}else{
				if ($s<>""){
				$str=$str . "<a href='?page=".($page-1)."&b=".$b."&s=".$s."' title='转到上一页'>&gt;</a>";
				$str=$str . "<a href='?page=1&b=".$b."&s=".$s."' title='转到第1页'><nobr>&gt;&gt;</nobr></a>";
				}elseif ($b<>""){
				$str=$str . "<a href='?page=".($page-1)."&b=".$b."' title='转到上一页'>&gt;</a>";
				$str=$str . "<a href='?page=1&b=".$b."' title='转到第1页'><nobr>&gt;&gt;</nobr></a>";
				}else{
				$str=$str . "<a href='?page=".($page-1)."' title='转到上一页'>&gt;</a>";
				$str=$str . "<a href='?page=1' title='转到第1页'><nobr>&gt;&gt;</nobr></a>";
				}
			}
		}
$str=$str."\n";		
$str=$str."<input name='page' type='text' maxlength='10' value='$page' style='height:16px;width:40px;border:solid 1px #dddddd;'/>";
$str=$str."<input type='submit'name='submit' value='跳转' style='height:20px;border:solid 1px #dddddd;background-color:#F1F1F1'/>";
$str=$str."<input name='b' type='hidden' value='$b'/><input name='s' type='hidden' value='$s'/>";
$str=$str."</form>";	
return $str;
}
?>