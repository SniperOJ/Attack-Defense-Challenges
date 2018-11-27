<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/askmodify.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?> 
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
if (isset($_GET["page"])){
$page=$_GET["page"];
}else{
$page=1;
}

if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id=0;
}
$sqlzx="select * from zzcms_ask where id='$id'";
$rszx = query($sqlzx); 
$rowzx = fetch_array($rszx);
if ($rowzx["editor"]<>$username) {
markit();
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
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
    }</script> <select name="bigclassid" class="biaodan" onchange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
                <option value="" selected="selected"><?php echo $f_array[3]?></option>
                <?php
	$sql = "select * from zzcms_askclass where isshowforuser=1 and parentid=0 order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
	?>
                <option value="<?php echo trim($row["classid"])?>" <?php if ($row["classid"]==$rowzx["bigclassid"]) { echo "selected";}?>><?php echo trim($row["classname"])?></option>
                <?php
				}
				?>
              </select> <select name="smallclassid" class="biaodan">
                <option value="0"><?php echo $f_array[4]?></option>
                <?php

$sql="select * from zzcms_askclass where parentid=" .$rowzx["bigclassid"]." order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
?>
               <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$rowzx["smallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
<?php
}
?>
            </select></td>
          </tr>
          <tr> 
            <td align="right" class="border"><?php echo $f_array[5]?></td>
			
            <td class="border">
			 <input name="title" type="text" class="biaodan" size="50" maxlength="255" value="<?php echo $rowzx["title"]?>" >			 </td>
          </tr>
		 
          <tr id="trcontent"> 
            <td align="right" class="border2" ><?php echo $f_array[9]?></td>
            <td class="border2" > <textarea name="content" type="hidden" id="content"><?php echo $rowzx["content"]?></textarea> 
              <script type="text/javascript">CKEDITOR.replace('content');	</script>            </td>
          </tr>
          <tr>
            <td align="right" class="border" >悬赏积分：</td>
            <td class="border" ><select name="jifen" id="jifen">
                <option value="0" <?php if ($rowzx["jifen"]==0){ echo 'selected';}?>>0</option>
                <option value="5" <?php if ($rowzx["jifen"]==5){ echo 'selected';}?>>5</option>
                <option value="10" <?php if ($rowzx["jifen"]==10){ echo 'selected';}?>>10</option>
                <option value="20" <?php if ($rowzx["jifen"]==20){ echo 'selected';}?>>20</option>
                <option value="30" <?php if ($rowzx["jifen"]==30){ echo 'selected';}?>>30</option>
              </select>
                <?php	   
		$sql="select totleRMB from zzcms_user where username='" .$_COOKIE["UserName"]. "'";
        $rs=query($sql);
		$row=fetch_array($rs);
		echo "您的积分：".$row['totleRMB'];
			?>
            </td>
          </tr>
            <td align="right" class="border2">&nbsp;</td>
            <td class="border2"> <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[25]?>">
              <input name="id" type="hidden" id="ypid2" value="<?php echo $rowzx["id"] ?>" /> 
              <input name="editor" type="hidden" id="editor2" value="<?php echo $username?>" />
              <input name="page" type="hidden" id="action" value="<?php echo $page?>" />
              <input name="action" type="hidden" id="action2" value="modify" /></td>
          </tr>
        </table>
</form>
</div>
</div>
</div>
</div>
<?php

unset ($f_array);
?>
</body>
</html>