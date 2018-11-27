<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/zxmodify.txt";
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
$sqlzx="select * from zzcms_zx where id='$id'";
$rszx = query($sqlzx); 
$rowzx = fetch_array($rszx);
if ($rowzx["editor"]<>$username) {
markit();
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
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
	$sql = "select * from zzcms_zxclass where isshowforuser=1 and parentid=0 order by xuhao asc";
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

$sql="select * from zzcms_zxclass where parentid=" .$rowzx["bigclassid"]." order by xuhao asc";
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
			 <input name="title" type="text" class="biaodan" size="50" maxlength="255" value="<?php echo $rowzx["title"]?>" >
			 <input type="checkbox" name="wailian" id="wailian" value="checkbox" onclick="showlink()" <?php if ($rowzx["link"]<>''){ echo 'checked';}?> />
 <label for="wailian"><?php echo $f_array[6]?></label> <span id="quote"></span> </td>
          </tr>
		  <?php 
		  if($rowzx["link"]<>''){
		  ?>
          <tr id="link" style="display:"> 
		  <?php 
		  }else{
		  ?>
		   <tr id="link" style="display:none"> 
		   <?php
		   }
		   ?>
            <td align="right" class="border" ><?php echo $f_array[7]?></td>
            <td class="border" ><input name="link" type="text" class="biaodan" size="50" maxlength="255"  value="<?php echo $rowzx["link"]?>" /></td>
          </tr>
          <tr id="trlaiyuan"> 
            <td align="right" class="border2" ><?php echo $f_array[8]?></td>
            <td class="border2" > <input name="laiyuan" type="text" class="biaodan" value="<?php echo sitename?>" size="50" maxlength="50" /></td>
          </tr>
          <tr id="trcontent"> 
            <td align="right" class="border2" ><?php echo $f_array[9]?></td>
            <td class="border2" > <textarea name="content" type="hidden" id="content"><?php echo $rowzx["content"]?></textarea> 
              <script type="text/javascript">CKEDITOR.replace('content');	</script>            </td>
          </tr>
          <tr id="trseo">
            <td colspan="2" class="admintitle" ><?php echo $f_array[10]?></td>
          </tr>
          <tr id="trkeywords">
            <td align="right" class="border2" ><?php echo $f_array[11]?></td>
            <td class="border2" ><input name="keywords" type="text" id="keywords" class="biaodan" size="50" maxlength="50" value="<?php echo $rowzx["keywords"]?>" /></td>
          </tr>
          <tr id="trdescription">
            <td align="right" class="border" ><?php echo $f_array[12]?></td>
            <td class="border" ><input name="description" type="text" id="description" class="biaodan" size="50" maxlength="500" value="<?php echo $rowzx["description"]?>" /></td>
          </tr><tr id="trquanxian">
      <td colspan="2" class="admintitle" ><strong><?php echo $f_array[13]?></strong></td>
    </tr>
    <tr id="trquanxian2"> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" > <select name="groupid" class="biaodan">
          <option value="0"><?php echo $f_array[14]?></option>
          <?php
		  $rs=query("Select * from zzcms_usergroup ");
		  $row = num_rows($rs);
		  if ($row){
		  while($row = fetch_array($rs)){
		  	if ($rowzx["groupid"]== $row["groupid"]) {
		  	echo "<option value='".$row["groupid"]."' selected>".$row["groupname"]."</option>";
			}else{
			echo "<option value='".$row["groupid"]."'>".$row["groupname"]."</option>";
			}
		  }
		  }
	 ?>
        </select> <select name="jifen" id="jifen" class="biaodan">
          <option value="0"><?php echo $f_array[15]?></option>
          <option value="0" <?php if ($rowzx["jifen"]==0) { echo "selected";}?>><?php echo $f_array[16]?></option>
          <option value="10" <?php if ($rowzx["jifen"]==10) { echo "selected";}?>><?php echo $f_array[17]?></option>
          <option value="20" <?php if ($rowzx["jifen"]==20) { echo "selected";}?>><?php echo $f_array[18]?></option>
          <option value="30" <?php if ($rowzx["jifen"]==30) { echo "selected";}?>><?php echo $f_array[19]?></option>
          <option value="50" <?php if ($rowzx["jifen"]==50) { echo "selected";}?>><?php echo $f_array[20]?></option>
          <option value="100" <?php if ($rowzx["jifen"]==100) { echo "selected";}?>><?php echo $f_array[21]?></option>
          <option value="200" <?php if ($rowzx["jifen"]==200) { echo "selected";}?>><?php echo $f_array[22]?></option>
          <option value="500" <?php if ($rowzx["jifen"]==500) { echo "selected";}?>><?php echo $f_array[23]?></option>
          <option value="1000" <?php if ($rowzx["jifen"]==1000) { echo "selected";}?>><?php echo $f_array[24]?></option>
        </select> </td>
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