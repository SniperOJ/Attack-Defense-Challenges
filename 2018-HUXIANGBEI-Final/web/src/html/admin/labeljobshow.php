<?php 
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<title></title>
<?php
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if ($action=="add") {
checkadminisdo("label");
$title=nostr(trim($_POST["title"]));
$title_old=trim($_POST["title_old"]);
$bigclassid=trim($_POST["bigclassid"]);
$smallclassid=trim($_POST["smallclassid"]);
$numbers=trim($_POST["numbers"]);
$orderby=trim($_POST["orderby"]);
$titlenum=trim($_POST["titlenum"]);
$row=trim($_POST["row"]);
$start=stripfxg($_POST["start"]);
$mids=stripfxg($_POST["mids"]);
$ends=stripfxg($_POST["ends"]);

$f="../template/".siteskin."/label/jobshow/".$title.".txt";
$fp=fopen($f,"w+");//fopen()的其它开关请参看相关函数
$str=$title . "|||" .$bigclassid . "|||".$smallclassid ."|||" . $numbers . "|||" . $orderby ."|||" . $titlenum ."|||" . $row . "|||" . $start . "|||" . $mids . "|||" . $ends;
fputs($fp,$str);
fclose($fp);
$title==$title_old ?$msg='修改成功':$msg='添加成功';
echo "<script>alert('".$msg."');location.href='?labelname=".$title.".txt'</script>";
}

if ($action=="del") {
checkadminisdo("label");
$f="../template/".siteskin."/label/jobshow/".nostr(trim($_POST["title"])).".txt";
	if (file_exists($f)){
	unlink($f);
	}else{
	echo "<script>alert('请选择要删除的标签');history.back()</script>";
	}	
}

$sql = "select * from zzcms_jobclass order by classid asc";
$rs=query($sql);
?>
<script language = "JavaScript">
var onecount;
subcat = new Array();
        <?php
        $count = 0;
		while ($r=fetch_array($rs)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($r['classname'])?>","<?php echo trim($r['parentid'])?>","<?php echo trim($r['classid'])?>");
        <?php
        $count = $count + 1;
        }
        ?>
onecount=<?php echo $count?>;

function changelocation(locationid)
    {
    document.myform.smallclassid.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid)
            { 
                document.myform.smallclassid.options[document.myform.smallclassid.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
        }
    }
	
function CheckForm()
{
//创建正则表达式
var re=/^[0-9a-zA-Z_]{1,20}$/; //只输入数字和字母的正则
if (document.myform.title.value=="")
  {
    alert("标签名称不能为空！");
	document.myform.title.focus();
	return false;
  }
if(document.myform.title.value.search(re)==-1)  {
    alert("标签名称只能用字母，数字，_ 。且长度小于20个字符！");
	document.myform.title.focus();
	return false;
  }  
if (document.myform.bigclassid.value=="")
  {
    alert("请选择大类别！");
	document.myform.bigclassid.focus();
	return false;
  } 
//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.myform.numbers.value)) 
{
alert("只能填数字！"); 
document.myform.numbers.focus(); 
return false; 
} 

if(!strP.test(document.myform.titlenum.value)) 
{
alert("只能填数字！"); 
document.myform.titlenum.focus(); 
return false; 
}  

if(!strP.test(document.myform.row.value)) 
{
alert("只能填数字！"); 
document.myform.row.focus(); 
return false; 
}  

}  

	</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">招聘内容标签</td>
  </tr>
</table>
<form action="" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="150" align="right" class="border" >现有标签：</td>
      <td class="border" >
	  <div class="boxlink"> 
        <?php
$labelname=isset($_GET['labelname'])?$_GET['labelname']:"";
if (file_exists("../template/".siteskin."/label/jobshow")==false){
echo '文件不存在';
}else{			
$dir = opendir("../template/".siteskin."/label/jobshow");
while(($file = readdir($dir))!=false){
	if ($file!="." && $file!="..") { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。
		if ($labelname==$file){
  		echo "<li><a href='?labelname=".$file."' style='color:#000000;background-color:#FFFFFF'>".$file."</a></li>";
		}else{
		echo "<li><a href='?labelname=".$file."'>".$file."</a></li>";
		}
	} 
}
closedir($dir);	  
}	  
//读取现有标签中的内容
if (isset($_REQUEST["labelname"])){
if (substr($labelname,-3)!='txt'){
showmsg('只能是txt这种格式');//防止直接输入php 文件地址显示PHP代码
}

$fp="../template/".siteskin."/label/jobshow/".$labelname;
$f=fopen($fp,"r+");
$fcontent="";
while (!feof($f))
{
    $fcontent=$fcontent.fgets($f);
}
fclose($f);
$fcontent=removeBOM($fcontent);//去除BOM信息，使修改时不用再重写标签名
$f=explode("|||",$fcontent) ;
$title=$f[0];
$bigclassid=$f[1];
$smallclassid=$f[2];
$numbers=$f[3];
$orderby=$f[4];
$titlenum=$f[5];
$row=$f[6];
$start=$f[7];
$mids=$f[8];
$ends=$f[9];	
}else{
$title="";
$bigclassid="";
$smallclassid="";
$numbers="";
$orderby="";
$titlenum="";
$row="";
$start="";
$mids="";
$ends="";
} 
	   ?>
	   </div>
      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >标签名称：</td>
      <td class="border" >
<input name="title" type="text" id="title" value="<?php echo $title?>" size="50" maxlength="255">
<input name="title_old" type="hidden" id="title_old" value="<?php echo $title?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >调用内容：</td>
      <td class="border" > <select name="bigclassid" onChange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
          <option value="empty" selected>不指定大类</option>
          <?php
       $sql = "select * from zzcms_jobclass where parentid='0' order by xuhao asc";
       $rs=query($sql);
		   while($r=fetch_array($rs)){
			?>
          <option value="<?php echo $r["classid"]?>" <?php if ($r["classid"]==$bigclassid) { echo "selected";}?>> 
         <?php echo trim($r["classname"])?></option>
          <?php   
    	     }	
		 ?>
        </select> <select name="smallclassid">
          <option value="empty" selected>不指定小类</option>
          <?php if ($bigclassid<>""){
			$sql="select * from zzcms_jobclass where parentid='" . $bigclassid ."' order by classid asc";
			$rs=query($sql);
			while($r=fetch_array($rs)){
			?>
          <option value="<?php echo $r["classid"]?>" <?php if ($r["classid"]==$smallclassid) { echo "selected";}?>><?php echo $r["classname"]?></option>
          <?php   
			}
		}
			?>
        </select></td>
    </tr>
    <tr> 
      <td align="right" class="border" >调用记录条数：</td>
      <td class="border" ><input name="numbers" type="text"  value="<?php echo $numbers?>" size="10" maxlength="255"> 
      </td>
    </tr>
    <tr > 
      <td align="right" class="border" >排序方式设置：</td>
      <td class="border" > <select name="orderby" id="orderby">
          <option value="id" <?php if ($orderby=="id") { echo "selected";}?>>最新发布</option>
		   <option value="sendtime" <?php if ($orderby=="sendtime") { echo "selected";} ?>>最近更新</option>
          <option value="hit" <?php if ($orderby=="hit") { echo "selected";}?>>最多点击</option>
        <option value="rand" <?php if ($orderby=="rand") { echo "selected";}?>>随机显示</option>
		</select></td>
    </tr>
    <tr > 
      <td align="right" class="border" >标题长度：</td>
      <td class="border" > <input name="titlenum" type="text" id="titlenum" value="<?php echo $titlenum?>" size="20" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >列数：</td>
      <td class="border" > <input name="row" type="text" id="row" value="<?php echo $row?>" size="20" maxlength="255">
        （分几列显示）</td>
    </tr>
    <tr> 
      <td align="right" class="border" >解释模板（开始）：</td>
      <td class="border" ><textarea name="start" cols="100" rows="6" id="start" style="width:100%"><?php echo $start?></textarea></td>
    </tr>
    <tr> 
      <td align="right" class="border" >解释模板（循环）：</td>
      <td class="border" ><textarea name="mids" cols="100" rows="6" id="mids" style="width:100%"><?php echo $mids ?></textarea> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >解释模板（结束）：</td>
      <td class="border" ><textarea name="ends" cols="100" rows="6" id="ends" style="width:100%"><?php echo $ends ?></textarea></td>
    </tr>
    <tr> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" > <input type="submit" name="Submit" value="添加/修改" onClick="myform.action='?action=add'"> 
        <input type="submit" name="Submit2" value="删除选中的标签" onClick="myform.action='?action=del'"></td>
    </tr>
  </table>
      </form>		  
</body>
</html>
