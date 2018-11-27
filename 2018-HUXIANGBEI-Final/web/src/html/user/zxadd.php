<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
$fpath="text/zxadd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[1]?></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?>
}  
function doChange(objText, pic){
	if (!pic) return;
	var str = objText.value;
	var arr = str.split("|");
	pic.length=0;
	for (var i=0; i<arr.length; i++){
		pic.options[i] = new Option(arr[i], arr[i]);
	}
} 
function showlink(){
whichEl = eval("link");
if (whichEl.style.display == "none"){
eval("link.style.display=\"\";");
eval("trlaiyuan.style.display=\"none\";");
eval("trcontent.style.display=\"none\";");
eval("trseo.style.display=\"none\";");
eval("trkeywords.style.display=\"none\";");
eval("trdescription.style.display=\"none\";");
eval("trquanxian.style.display=\"none\";");
eval("trquanxian2.style.display=\"none\";");
}else{
eval("link.style.display=\"none\";");
eval("trlaiyuan.style.display=\"\";");
eval("trcontent.style.display=\"\";");
eval("trseo.style.display=\"\";");
eval("trkeywords.style.display=\"\";");
eval("trdescription.style.display=\"\";");
eval("trquanxian.style.display=\"\";");
eval("trquanxian2.style.display=\"\";");
}
} 
</script>
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
<div class="admintitle"><?php echo $f_array[1]?></div>
<?php
$tablename="zzcms_zx";
include("checkaddinfo.php");
if (isset($_REQUEST["b"])){
$b=$_REQUEST["b"];
}
if (isset($_REQUEST["s"])){
$s=$_REQUEST["s"];
}
?>	  
<form action="zxsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="18%" align="right" class="border2"><?php echo $f_array[2]?></td>
            <td width="82%" class="border2"> 
              <?php

$sql = "select * from zzcms_zxclass where parentid<>0 order by xuhao asc";
$rs=query($sql);
?>
              <script language = "JavaScript" type="text/JavaScript">
var onecount;
subcat = new Array();
        <?php 
        $count = 0;
        while($row = fetch_array($rs)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($row["classname"])?>","<?php echo trim($row["parentid"])?>","<?php echo trim($row["classid"])?>");
        <?php
        $count = $count + 1;
       }
        ?>
onecount=<?php echo $count ?>;

function changelocation(locationid){
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
    }</script> <select name="bigclassid" class="biaodan" onchange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
                <option value="" selected="selected"><?php echo $f_array[3]?> </option>
                <?php
	$sql = "select * from zzcms_zxclass where isshowforuser=1 and parentid=0 order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
		if ($row["classid"]==@$b){
	?>
	 <option value="<?php echo trim($row["classid"])?>" selected><?php echo trim($row["classname"])?></option>
                <?php
		}elseif($row["classid"]==@$_SESSION["bigclassid"] && @$b==''){	
				?>
		<option value="<?php echo trim($row["classid"])?>" selected><?php echo trim($row["classname"])?></option>
		<?php 
		}else{
		?>
		<option value="<?php echo trim($row["classid"])?>"><?php echo trim($row["classname"])?></option>
		<?php 
		}
	}	
		?>		
              </select> 
			  <select name="smallclassid"  class="biaodan">
                <option value="0"><?php echo $f_array[4]?></option>
                <?php
if ($b!=''){//从index.php获取的大类值优先
$sql="select * from zzcms_zxclass where parentid=".$b." order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
				?>
				  <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$s) { echo "selected";}?>><?php echo $row["classname"]?></option>
                <?php
	}
}elseif($_SESSION["bigclassid"]!=''){
$sql="select * from zzcms_zxclass where parentid=" .@$_SESSION["bigclassid"]." order by xuhao asc";
$rs=query($sql);
	while($row = fetch_array($rs)){
	?>
   <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$_SESSION["smallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
<?php 
	}
	}
	?>					  
              </select></td>
          </tr>
          <tr> 
            <td align="right" class="border"><?php echo $f_array[5]?></td>
			
            <td class="border">
			<script type="text/javascript" src="/js/jquery.js"></script>  
<script language="javascript">  
$(document).ready(function(){  
  $("#title").change(function() { //jquery 中change()函数  
	$("#quote").load(encodeURI("/ajax/zxtitlecheck_ajax.php?id="+$("#title").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});  
</script>  
			 <input name="title" type="text" id="title" size="50" maxlength="255"  class="biaodan"> 
              <input type="checkbox" name="wailian" id="wailian" value="checkbox" onclick="showlink()">
               <label for="wailian"><?php echo $f_array[6]?></label> 
			  <span id="quote"></span>              </td>
          </tr>
          <tr id="link" style="display:none"> 
            <td align="right" class="border" ><?php echo $f_array[7]?></td>
            <td class="border" ><input name="link" type="text" id="laiyuan3" size="50" maxlength="255"  class="biaodan"/>            </td>
          </tr>
          <tr id="trlaiyuan"> 
            <td align="right" class="border2" ><?php echo $f_array[8]?></td>
            <td class="border2" > <input name="laiyuan" type="text" id="laiyuan" value="<?php echo sitename?>" size="50" maxlength="50" class="biaodan" /></td>
          </tr>
          <tr id="trcontent"> 
            <td align="right" class="border2" ><?php echo $f_array[9]?></td>
            <td class="border2" > <textarea name="content" id="content"></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('content');</script>            </td>
          </tr>
          <tr id="trseo">
            <td colspan="2" class="admintitle" ><strong><?php echo $f_array[10]?></strong></td>
          </tr>
          <tr id="trkeywords">
            <td align="right" class="border" ><?php echo $f_array[11]?></td>
            <td class="border" ><input name="keywords" type="text" id="keywords" size="50" maxlength="50"  class="biaodan"/></td>
          </tr>
          <tr id="trdescription">
            <td align="right" class="border2" ><?php echo $f_array[12]?></td>
            <td class="border2" ><input name="description" type="text" id="description" size="50" maxlength="50"  class="biaodan"/></td>
          </tr>
          <tr id="trquanxian">
            <td colspan="2" class="admintitle" ><strong><?php echo $f_array[13]?></strong></td>
          </tr>
          <tr id="trquanxian2">
            <td align="right" class="border" >&nbsp;</td>
            <td class="border" ><select name="groupid"  class="biaodan">
                <option value="0"><?php echo $f_array[14]?></option>
                <?php
		  $rs=query("Select * from zzcms_usergroup ");
		  $row = num_rows($rs);
		  if ($row){
		  while($row = fetch_array($rs)){
		  	echo "<option value='".$row["groupid"]."'>".$row["groupname"]."</option>";
		  }
		  }
	 ?>
              </select>
                <select name="jifen" id="jifen"  class="biaodan">
                  <?php echo $f_array[15]?>
                </select>
            </td>
          </tr>
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"> <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[16]?>">
              <input name="editor" type="hidden" id="editor2" value="<?php echo $username?>" />
              <input name="action" type="hidden" id="action3" value="add"></td>
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
session_write_close();
unset ($f_array);
?>