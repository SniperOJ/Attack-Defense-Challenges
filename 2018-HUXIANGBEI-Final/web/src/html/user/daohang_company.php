<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/daohang_company.txt";
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
<?php
//本页用于初次注册本站的公司用户来完善公司信息（公司简介及公司形象图片信息）
	if (isset($_REQUEST['action'])){
	$action=$_REQUEST['action'];
	}else{
	$action="";
	}	
if ($action=="modify") {
			$province=trim($_POST["province"]);
			$city=trim($_POST["city"]);
			$xiancheng=trim($_POST["xiancheng"]);
			$b=trim($_POST["b"]);
			$s=trim($_POST["s"]);		
			$address=$_POST["address"];
			$homepage=$_POST["homepage"];
			$content=stripfxg(rtrim($_POST["content"]));
			$oldcontent=rtrim($_POST["oldcontent"]);
			$img=$_POST["img"];
			$sex=$_POST["sex"];
			$mobile=$_POST["mobile"];
			$qq=$_POST["qq"];
			query("update zzcms_user set bigclassid='$b',smallclassid='$s',content='$content',img='$img',
			province='$province',city='$city',xiancheng='$xiancheng',sex='$sex',mobile='$mobile',address='$address',qq='$qq',
			homepage='$homepage' where username='".$username."'");
			if ($oldcontent=="" || $oldcontent=="&nbsp;"){//只有第一次完善时加分，修改信息不计分，这里需要加验证，不许改为空，防止刷分
				query("update zzcms_user set totleRMB=totleRMB+".jf_addreginfo." where username='".$username."'");
				query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('$username','".$f_array[0]."','+".jf_addreginfo."','+".jf_addreginfo."','".date('Y-m-d H:i:s')."')");
			echo str_replace("{#jf_addreginfo}",jf_addreginfo,$f_array[1]);
			}		
			echo $f_array[2];
}else{		
?>
<script language = "JavaScript" src="/js/gg.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[3]?>   
}
</SCRIPT>
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody" >
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<div class="content">
<div class="admintitle"><?php echo $f_array[4]?></div>
<?php
$sql="select * from zzcms_user where username='" .$username. "'";
$rs=query($sql);
$row=fetch_array($rs);

if ($row['logins']==0) {
echo "<div class='box'> 您好！<b>".$username."</b>".$f_array[5]."</div>";
}else{
echo "<div class='box'>".$f_array[6]."</div>";
}
?>

<FORM name="myform" action="?action=modify" method="post" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border2"> <?php echo $f_array[7]?></td>
                  <td class="border2">
<select name="province" id="province" class="biaodan"></select>
<select name="city" id="city" class="biaodan"></select>
<select name="xiancheng" id="xiancheng" class="biaodan"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '<?php echo $row["xiancheng"]?>');
</script>             
             		  </td>
          </tr>
          <tr > 
            <td align="right" class="border"><?php echo $f_array[8]?></td>
            <td class="border"> 
              <input name="address" id="address" tabindex="4" class="biaodan" value="<?php echo $row['address']?>" size="30" maxlength="50"> 
            </td>
          </tr>
          <tr > 
            <td align="right" class="border2"><?php echo $f_array[9]?></td>
            <td class="border2"> 
              <input name="homepage" id="homepage" class="biaodan" value="<?php if ($row["homepage"]<>'') { echo  $row["homepage"] ;}else{ echo siteurl.getpageurl('zt',$row['id']);}?>" tabindex="5" size="30" maxlength="100"></td>
          </tr>
          <tr> 
            <td align="right" class="border"><?php echo $f_array[10]?></td>
            <td class="border">
			<?php
$sqln = "select * from zzcms_userclass where parentid<>'0' order by xuhao asc";
$rsn=query($sqln);
?>
<script language = "JavaScript" type="text/JavaScript">
var onecount;
subcat = new Array();
<?php 
$count = 0;
        while($rown = fetch_array($rsn)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($rown["classname"])?>","<?php echo trim($rown["parentid"])?>","<?php echo trim($rown["classid"])?>");
       <?php
		$count = $count + 1;
       }
        ?>
onecount=<?php echo $count ?>;
function changelocation(locationid){
    document.myform.s.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid){ 
                document.myform.s.options[document.myform.s.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
        }
    }</script>
      <select name="b" size="1" id="b" class="biaodan" onchange="changelocation(document.myform.b.options[document.myform.b.selectedIndex].value)">
        <option value="" selected="selected"><?php echo $f_array[11]?></option>
        <?php
	$sqln = "select * from zzcms_userclass where  parentid='0' order by xuhao asc";
    $rsn=query($sqln);
	while($rown = fetch_array($rsn)){
	?>
        <option value="<?php echo trim($rown["classid"])?>" <?php if ($rown["classid"]==$row["bigclassid"]) { echo "selected";}?>><?php echo trim($rown["classname"])?></option>
        <?php
				}
				?>
      </select>
	  <select name="s" class="biaodan">
      <option value="0"><?php echo $f_array[12]?></option>
      <?php	  
$sqln="select * from zzcms_userclass where parentid='" .$row["bigclassid"]."' order by xuhao asc";
$rsn=query($sqln);
while($rown = fetch_array($rsn)){
?>
<option value="<?php echo $rown["classid"]?>" <?php if ($rown["classid"]==$row["smallclassid"]) { echo "selected";}?>><?php echo $rown["classname"]?></option>
<?php 	  
}
?>
    </select>
			</td>
          </tr>
          <tr> 
           <td width="17%" align="right" class="border2">
		   <?php echo $f_array[13]?><input name="oldcontent" type="hidden" id="oldcontent" value="<?php echo $row["content"]?>">
		   </td>
            <td width="83%" class="border2"> 
              <textarea name="content" id="content"><?php echo $row["content"]?></textarea> 
			   <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('content');</script> 
            </td>
          </tr>
          <tr> 
            <td height="50" align="right" class="border"><?php echo str_replace("{#maximgsize}",maximgsize,$f_array[14])?> 
                    <input name="img" type="hidden" id="img" value="/image/nopic.gif" tabindex="8"></td>
            <td height="50" class="border">   

	  <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#cccccc">
          <tr align="center" bgcolor="#FFFFFF"> 
            <td id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)"> <input name="Submit2" type="button"  value="<?php echo $f_array[15]?>" /></td>
          </tr>
        </table>
			
            </td>
          </tr>
          <tr> 
            <td align="right" class="border2"><?php echo $f_array[16]?></td>
            <td class="border2"> 
              <input name="sex" type="radio" tabindex="9" value="1" <?php if ($row["sex"]==1) { echo 'checked';}?>/>
              <?php echo $f_array[17]?> 
              <input name="sex" type="radio" tabindex="10" value="0" <?php if ($row["sex"]==0) { echo 'checked';}?> />
              <?php echo $f_array[18]?></td>
          </tr>
          <tr > 
            <td align="right" class="border"><?php echo $f_array[19]?></td>
            <td class="border"> <input name="qq" id="qq" class="biaodan" value="<?php echo $row['qq']?>" tabindex="11" size="30" maxLength="50"></td>
          </tr>
          <tr > 
            <td align="right" class="border2"><?php echo $f_array[20]?></td>
            <td class="border2"> 
              <input name="mobile" id="mobile" class="biaodan" value="<?php echo $row['mobile']?>" tabindex="12" size="30" maxLength="50"></td>
          </tr>
          <tr> 
            <td class="border">&nbsp;</td>
            <td class="border"> <input name="Submit"  type="submit" class="buttons" id="Submit" value="<?php echo $f_array[21]?>" tabindex="13"> 
            </td>
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
}

unset ($f_array);
?>