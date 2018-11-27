<?php
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin: 0px;
	padding: 0px;
	font-size: 12px;
	background:transparent
}
-->
</style>
</head>
<body>
<form action="/job/search.php" method="get" name="myform" id="myform" target="_parent">
<table border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td><?php
$sql = "select * from zzcms_jobclass where parentid<>'0' order by xuhao asc";
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
    document.myform.s.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid)
            { 
                document.myform.s.options[document.myform.s.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
        }
    }</script>
      <select name="b"  id="b" onchange="changelocation(document.myform.b.options[document.myform.b.selectedIndex].value)" style="width:210px" class="biaodan">
        <option value="" selected="selected">请选择职位大类</option>
        <?php
	$sql = "select * from zzcms_jobclass where  parentid='0' order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
	?>
        <option value="<?php echo trim($row["classid"])?>" ><?php echo trim($row["classname"])?></option>
        <?php
				}
				?>
      </select></td>
  </tr>
  <tr>
    <td><select name="s" style="width:210px" class="biaodan">
      <option value="">请选择职位小类</option>
      <?php
$sql="select * from zzcms_jobclass  order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
?>
<option value="<?php echo $row["classid"]?>" ><?php echo $row["classname"]?></option>
<?php 	  
}
?>
    </select></td>
  </tr>
  <tr>
    <td>
<select name="province" id="province" style="width:210px" class="biaodan"></select></td>
  </tr>
  <tr>
    <td>
	<select name="city" id="city" style="width:210px" class="biaodan"></select>	  </td>
  </tr>
  <tr>
    <td><select name="xiancheng" id="xiancheng" style="width:210px" class="biaodan"></select>
	<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '', '', '');
</script>	</td>
  </tr>
  <tr>
    <td><input name="keyword" type="text"  id="keyword" value="" size="25" maxlength="255" class="biaodan" style="width:60px"/>
      <label><input type="radio" name="yiju" value="Pname" />职位</label>
      <label><input name="yiju" type="radio" value="Pcompany" />企业</label>
      <input name="Submit3" type="submit"  value="搜索" class="buttons"/></td>
  </tr>
</table>
</form>
</body>
</html>