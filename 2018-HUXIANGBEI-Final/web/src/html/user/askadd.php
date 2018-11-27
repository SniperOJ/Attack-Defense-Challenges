<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
$fpath="text/askadd.txt";
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
$tablename="zzcms_ask";
include("checkaddinfo.php");
if (isset($_REQUEST["b"])){
$b=$_REQUEST["b"];
}
if (isset($_REQUEST["s"])){
$s=$_REQUEST["s"];
}
?>	  
<form action="asksave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="18%" align="right" class="border2"><?php echo $f_array[2]?></td>
            <td width="82%" class="border2"> 
              <?php

$sql = "select * from zzcms_askclass where parentid<>0 order by xuhao asc";
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
	$sql = "select * from zzcms_askclass where isshowforuser=1 and parentid=0 order by xuhao asc";
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
$sql="select * from zzcms_askclass where parentid=".$b." order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
				?>
				  <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$s) { echo "selected";}?>><?php echo $row["classname"]?></option>
                <?php
	}
}elseif($_SESSION["bigclassid"]!=''){
$sql="select * from zzcms_askclass where parentid=" .@$_SESSION["bigclassid"]." order by xuhao asc";
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
	$("#quote").load(encodeURI("/ajax/asktitlecheck_ajax.php?id="+$("#title").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});  
</script>  
			 <input name="title" type="text" id="title" size="50" maxlength="255"  class="biaodan"></td>
          </tr>
          <tr id="trcontent"> 
            <td align="right" class="border2" ><?php echo $f_array[9]?></td>
            <td class="border2" > <textarea name="content" id="content"></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('content');</script>            </td>
          </tr>
         
          <tr id="trkeywords">
            <td align="right" class="border" >悬赏积分：</td>
            <td class="border" ><select name="jifen" id="jifen">
              <option value="0" selected="selected">0</option>
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
            </select>
			<?php	   
		$sql="select totleRMB from zzcms_user where username='" .$_COOKIE["UserName"]. "'";
        $rs=query($sql);
		$row=fetch_array($rs);
		echo "您的积分：".$row['totleRMB'];
			?>            </td>
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