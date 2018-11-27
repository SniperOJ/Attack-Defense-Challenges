<?php
function showflyad($b,$s){
$i=1;
$sql= "select * from zzcms_ad where bigclassname='".$b."' and smallclassname='".$s."' ";
if (isshowad_when_timeend=="No"){
$sql=$sql. "and endtime>= '".date('Y-m-d H:i:s')."' ";
}
$rs=query($sql);
$row=num_rows($rs);
if ($row){
$str="";
while($row=fetch_array($rs)){
$str=$str . "<div id='gg".$i."' style='position:absolute;z-index:2' title='".$row["title"]."'>";
if (substr($row["img"],-3)=="swf"){
$str=$str ."<embed src='" . siteurl.$row["img"] . "' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' wmode='transparent' width='135' height='50'></embed>";
}elseif (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false) {
$str=$str . "<a href='".$row["link"]."' target='_blank'><img src='". siteurl."/".$row["img"] ."' width='".$row["imgwidth"]."'  height='".$row["imgheight"]."' border='0'/></a>";
}
$str=$str . "<br><a href='javascript:' onclick=gg".$i.".style.visibility='hidden' title='关闭上面的广告'>×关闭</a>";
$str=$str . "</div>";
$i=$i+1;
}
$str=$str . "<SCRIPT src='".siteurl."/js/float.js' type='text/javascript'></SCRIPT>";
$str=$str . "<script type='text/javascript'>" ;

for ($n=1;$n<$i;$n++){
$str=$str . "var ad".$n."=new AdMove('gg".$n."');";
$str=$str . "ad".$n.".Run();";
}
$str=$str ."</script>";
return $str;
}
}

function showduilianad($b,$leftclassname,$rightclassname)
{
$str="<SCRIPT src='".siteurl."/js/duilian.js' type='text/javascript'></SCRIPT>";
//显示样式
$str=$str . "<style type='text/css'>";
$str=$str . "#leftDiv,#rightDiv{position:absolute;z-index:4}";
$str=$str . ".itemFloat{width:auto;height:auto;line-height:5px}";
$str=$str . "</style>";
$str=$str . "<div id='leftDiv' style='top:40px;left:5px'>";

$sql= "select * from zzcms_ad where bigclassname='".$b."' and smallclassname='".$leftclassname."' ";
if (isshowad_when_timeend=="No"){
$sql=$sql. "and endtime>= '".date('Y-m-d H:i:s')."' ";
}
$sql=$sql. "order by xuhao asc";

$rs=query($sql);
$row=num_rows($rs);
if ($row){
$i=1;
while($row=fetch_array($rs)){

$str=$str . "<div id='left".$i."' class='itemFloat' title='".$row["title"]."'>";
if (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false){
$str=$str . "<a target=_blank href=".$row["link"]."><img border=0 src=".siteurl.$row["img"]." width=".$row["imgwidth"]." height=".$row["imgheight"]."></a>";
}elseif (substr($row["img"],-3)=="swf"){
$str=$str . "<embed src=".siteurl.$row["img"]." wmode=transparent width=".$row["imgwidth"]." height=".$row["imgheight"]."></embed>";
}
$str=$str . "<br><br><br><a href='javascript:' onclick=left".$i.".style.visibility='hidden' title='关闭上面的广告'>×关闭</a><br><br><br><br>";
$str=$str . "</div>";
$i=$i+1;

}
}

$str=$str . "</div>";
$str=$str . "<div id='rightDiv' style='top:40px;right:5px' title='".$row["title"]."'>";//放到外面，无论有值或无值都显以免JS因找不到rightdiv而报错

$sql= "select * from zzcms_ad where bigclassname='".$b."' and smallclassname='".$rightclassname."' ";
if (isshowad_when_timeend=="No"){
$sql=$sql. "and endtime>= '".date('Y-m-d H:i:s')."' ";
}
$sql=$sql. "order by xuhao asc";

$rs=query($sql);
$row=num_rows($rs);
if ($row){
$i=1;
while($row=fetch_array($rs)){
$str=$str . "<div id='right".$i."' class='itemFloat' title='".$row["title"]."'>";
if (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false){
$str=$str . "<a target=_blank href=".$row["link"]."><img border=0 src=".siteurl.$row["img"]." width=".$row["imgwidth"]." height=".$row["imgheight"]."></a>";
}elseif (substr($row["img"],-3)=="swf"){
$str=$str . "<embed src=".siteurl.$row["img"]." wmode=transparent width=".$row["imgwidth"]." height=".$row["imgheight"]."></embed>";
}
$str=$str . "<br><br><br><a href='javascript:'  onclick=right".$i.".style.display='none' title='关闭上面的广告'>×关闭</a><br><br><br><br>";
$str=$str . "</div>";
$i=$i+1;

}
}
$str=$str . "</div>";
return $str;
}
?>