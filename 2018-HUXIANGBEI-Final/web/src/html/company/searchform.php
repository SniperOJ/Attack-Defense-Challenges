<?php
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
	margin: 0px;
	padding: 0px;
	font-size: 12px;
}
-->
</style>
</head>
<body>
<form name="myform" id="myform" method="get" action="/company/search.php" target="_parent">
<?php
$sql = "select * from zzcms_userclass where parentid<>'0' order by xuhao asc";
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
    document.myform.s.length = 1; 
   // var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++){
            if (subcat[i][1] == locationid){ 
                document.myform.s.options[document.myform.s.length] = new Option(subcat[i][0], subcat[i][2]);
			}    
        }
    }
	</script>
      <select name="b" id="b" onchange="changelocation(document.myform.b.options[document.myform.b.selectedIndex].value);document.getElementById('myform').submit()">
        <option value="" selected="selected">请选择大类</option>
        <?php
	$sql = "select * from zzcms_userclass where  parentid='0' order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
	?>
        <option value="<?php echo trim($row["classid"])?>" <?php if ($row["classid"]==@$_COOKIE['companyb']){ echo 'selected';}?>><?php echo trim($row["classname"])?></option>
        <?php
				}
				?>
  </select>
	  <select name="s" onchange="document.getElementById('myform').submit()">
      <option value="">请选择小类</option>
      <?php
if (isset($_COOKIE['companyb'])){
checkid($_COOKIE['companyb']);
$sql="select * from zzcms_userclass where parentid='" .$_COOKIE['companyb']."'  order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
?>
<option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==@$_COOKIE['companys']){ echo 'selected';}?>><?php echo $row["classname"]?></option>
<?php 	  
}
}
?>
</select>
<input name="keyword" type="text"  id="keyword" value="<?php echo @$_COOKIE['companyk']?>" size="25" maxlength="50"  style="display: none;"/>
<input  type="submit" style="display: none;" value="提交" />  
</form>
</body>
</html>