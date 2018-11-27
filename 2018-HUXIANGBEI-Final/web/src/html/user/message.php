<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/message.txt";
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
<script language="JavaScript" src="/js/gg.js"></script>
<script language = "JavaScript">
<?php echo $f_array[0]?>
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
if( isset($_GET["page"]) && $_GET["page"]!="") {$page=$_GET['page'];}else{$page=1;}
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_usermessage where editor='".$username."' ";
$rs = query($sql,$conn); 
$totlenum= num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);		
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = query($sql,$conn); 
if(!$totlenum){
echo $f_array[2];
}else{
?>
<form name="myform" method="post" action="del.php">
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
    <tr> 
      <td width="70%" class="border"><?php echo $f_array[3]?></td>
      <td width="5%" align="center" class="border"><?php echo $f_array[4]?></td>
    </tr>
<?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td>
	  <div style="border-bottom:dotted 1px #b4cced;"><span style="float:right"><?php echo $row["sendtime"]?></span><?php echo $f_array[5].$row["content"]?></div>
	  <div style="color:green">
	  <?php 
	  if ($row["reply"]<>''){
	  ?>
	  <span style="float:right"><?php echo $row["replytime"]?></span><?php echo $f_array[6].$row["reply"]?></div>
	  <?php 
	  }else{
	  echo $f_array[7];
	  }
	  ?>
	  </td>
      <td align="center" class="docolor"><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
    </tr>
<?php
}
?>
  </table>

<div class="fenyei">
<?php echo showpage()?> 
<input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
          <label for="chkAll"><?php echo $f_array[8]?></label>
          <input name="submit"  type="submit" class="buttons"  value="<?php echo $f_array[9]?>" onclick="return ConfirmDel()" />
          <input name="pagename" type="hidden" id="pagename" value="message.php?page=<?php echo $page ?>" />
          <input name="tablename" type="hidden" id="tablename" value="zzcms_usermessage" />
        </div>
</form>
<?php
}
?>
  <div class="admintitle"><?php echo $f_array[10]?></div>
  <form action="?" method="post" name="myform2" id="myform2" onSubmit="return CheckForm()">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr id="trcontent"> 
            <td width="15%" align="right" class="border" ><?php echo $f_array[11]?></td>
            <td width="85%" class="border" > 
			<textarea name="content" cols="100" rows="5" id="content" onpropertychange="if(value.length>200) value=value.substr(0,200)"></textarea> 
              </td>
          </tr>
         
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"> <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[12]?>">
              <input name="editor" type="hidden" id="editor2" value="<?php echo $username?>" />
              <input name="action" type="hidden" id="action3" value="add"></td>
          </tr>
        </table>
</form>
<?php 
if (isset($_POST["action"])){
$content=trim($_POST["content"]);
$editor=trim($_POST["editor"]);
//判断是不是重复信息,为了修改信息时不提示这段代码要放到添加信息的地方
$sql="select content,editor from zzcms_usermessage where content='".$content."'";
$rs = query($sql); 
$row= num_rows($rs); 
if ($row){
echo $f_array[13];
}else{
query("Insert into zzcms_usermessage(content,editor,sendtime) values('$content','$editor','".date('Y-m-d H:i:s')."')"); 
echo "<script lanage='javascript'>location.replace('message.php')</script>"; 
}
}

?>
</div>
</div>
</div>
</div>
</body>
</html>