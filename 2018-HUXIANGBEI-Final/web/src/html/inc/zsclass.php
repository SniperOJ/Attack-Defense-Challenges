<?php
function showzsclass($cs){
global $siteskin;
$cs=explode(",",$cs); //传入的$cs是一个整体字符串,转成数组
$style=isset($cs[0])?$cs[0]:0;
$num_b=isset($cs[1])?$cs[1]:99;
$long_b=isset($cs[2])?$cs[2]:10;
$num_s=isset($cs[3])?$cs[3]:99;
$long_s=isset($cs[4])?$cs[4]:6;
$column_p=isset($cs[5])?$cs[5]:2;checkid($column_p,0,'{#zsclass}标签第6个参数必须为大于0的整数');
$num_p=isset($cs[6])?$cs[6]:2;
$long_p=isset($cs[7])?$cs[7]:6;
$showcount=isset($cs[8])?$cs[8]:'yes';
$adv=isset($cs[9])?$cs[9]:'no';

$fp=zzcmsroot."cache/".$siteskin."/zsclass_".$style.".htm";
if (cache_update_time!=0 && file_exists($fp) && time()-filemtime($fp)<3600*24*cache_update_time ) {//12小时更新一次,
	$f=fopen($fp,"r+");
	$fcontent="";
	while (!feof($f)){$fcontent=$fcontent.fgets($f);}
	fclose($f);
	return $fcontent;
}else{
$sql="select * from zzcms_zsclass where parentid='A' and isshow=1 order by xuhao asc limit 0,$num_b";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
$n=1;
$str="";
while ($row=fetch_array($rs)){
if ($style==1){
$str=$str."<div class='zsclass' onMouseOver=\"showfilter2(zsLayer$n)\" onMouseOut=\"showfilter2(zsLayer$n)\">\n";
$str=$str."<label>\n";
}else{
$str=$str. "<div class='zsclass_zhankai'>\n";
if ($n % 2==0){ $str=$str. "<div class='zsclass_s_zhankai_style1'> \n";}else{$str=$str. "<div class='zsclass_s_zhankai_style2'> \n";}//套在里面，以设PADDING值
}
$str=$str. "<h2>";
if ($row["img"]<>'0' && $row["img"]<>''){$str=$str. "<img src=".str_replace('{#siteskin}',$siteskin,$row["img"]).">&nbsp;";}
$str=$str. "<a href=".getpageurl2("zs",$row["classzm"],'').">".cutstr($row["classname"],$long_b)."</a>";
	if($showcount=='yes'){
	$rsnumb=query("select count(*) as total from zzcms_main where bigclasszm='".$row["classzm"]."' ");//统计所属大类下的信息数
	$rown = fetch_array($rsnumb);
	$totlenum = $rown['total'];
	$str=$str. "<span>(共 <b>" .$totlenum. "</b> 条)</span>" ;
	}
$str=$str. "</h2>\n";

if ($style==1){//--------------style为1时左侧大类下显示小类
	if ($adv=="yes"){//开启广告后只显广告
	//$str=$str.showad(2,4,"no","yes","no",0,0,5,$row["classname"],"分类招商间","no");//两种方法都可以
	$str=$str.adshow("index_zsclass",$row["classname"],"分类招商间");//在广告标签中加个名为index_zsclass的广告,这种布局更灵活，缺点：得加个自定标签，麻烦点
	}else{
	$rsn=query("select * from zzcms_zsclass where parentid='".$row["classzm"]."' order by xuhao asc limit 0,3");
	$rown=num_rows($rsn);
		$nn=1;
		if ($rown){
			while ($rown=fetch_array($rsn)){
			$str=$str. "<a href=".getpageurl2('zs',$row["classzm"],$rown["classzm"]).">".cutstr($rown["classname"],$long_s)."</a>&nbsp;&nbsp;\n";
			$nn=$nn+1;
			}
		}else{
		$str=$str.'';//左边不显示小类，且不显示任何提示内容
		}
	}

$str=$str. "<div id=zsLayer$n class='zsclass_s'> \n";//把左测要显示的小类内容放到这个DIV的外面，而展开的样式里则要放到里面，所以把这个div移了下来，整体结构是完整的。
$str=$str. "<div class='bigbigword ico_size'>";
if ($row["img"]<>'0' && $row["img"]<>''){$str=$str. "<img src=".str_replace('{#siteskin}',$siteskin,$row["img"]).">&nbsp;";}
$str=$str. $row["classname"]."</div>\n";//右边的小类框上面显示大类名	
}				//--------------end为1时大类下显示小类
	
$nn=1;
$rsn=query("select * from zzcms_zsclass where parentid='".$row["classzm"]."' order by xuhao asc limit 0,$num_s");
$rown=num_rows($rsn);
	if ($rown){
		while ($rown=fetch_array($rsn)){
		$str=$str. "<div class='zsclass_s_li'>\n";
		$str=$str. "<div class='zsclass_s_name'><a href=".getpageurl2('zs',$row["classzm"],$rown["classzm"]).">".cutstr($rown["classname"],$long_s)."</a></div>\n";
			if ($num_p<>0){
			$str=$str. "<div class='zsclass_cp'>";
			$nnn=1;
			if(zsclass_isradio=='No'){
			$sqlcp="select id,proname from zzcms_main where bigclasszm='".$row["classzm"]."' and smallclasszm like '%".$rown["classzm"]."%' order by sendtime desc limit 0,$num_p";
			}else{
			$sqlcp="select id,proname from zzcms_main where bigclasszm='".$row["classzm"]."' and smallclasszm='".$rown["classzm"]."' order by sendtime desc limit 0,$num_p";
			}
			$rscp=query($sqlcp);
			$rowcp=num_rows($rscp);
			if ($rowcp){
				while ($rowcp=fetch_array($rscp)){
				$str=$str. "<a href='".getpageurl("zs",$rowcp['id'])."' target='_blank'>".cutstr($rowcp['proname'],$long_p)."</a>";
				if ($nnn % $column_p==0){$str=$str.'<br/>' ;}else {$str=$str.'&nbsp;|&nbsp; ';}
				$nnn=$nnn+1;
				}
			}else{
			$str=$str. '下无产品';
			}
			$str=$str. "</div>\n";
			}
		$str=$str. "</div>\n";
		$nn=$nn+1;
		}
	//$str=$str. "<a href=".getpageurl2("zs",$row["classzm"],"").">更多...</a>";
	}else{
	$str=$str. '下无子类';
	}
$str=$str. "</div>\n";
if ($style==1){
$str=$str."</label>\n";
}
$str=$str. "</div>\n";	

$n=$n+1;		 
}
$str=$str. '';
}else{
$str= '暂无分类信息';
}
	if (cache_update_time!=0){
	$fp=zzcmsroot."cache/".$siteskin."/zsclass_".$style.".htm";
	if (!file_exists(zzcmsroot."cache/".$siteskin)) {mkdir(zzcmsroot."cache/".$siteskin,0777,true);}
	$f=fopen($fp,"w+");//fopen()的其它开关请参看相关函数
	fputs($f,$str);
	fclose($f);
	}
return $str;
}
}
?>