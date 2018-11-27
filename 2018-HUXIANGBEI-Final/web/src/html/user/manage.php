<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/manage.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[0]?></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript" src="/js/gg.js"></script>
<script src="/js/swfobject.js" type="text/javascript"></script>
<script>
function CheckForm(){
<?php echo $f_array[1]?>
}
</script>
</head>
<body>
<?php
$founderr=0;
$errmsg="";
	$sql="select * from zzcms_user where username='" .$username. "'";
	$rs=query($sql);
	$row=fetch_array($rs);
	
	if (isset($_REQUEST['action'])){
	$action=$_REQUEST['action'];
	}else{
	$action="";
	}
	
if ($action=="modify") {
			$sex=trim($_POST["sex"]);
			$email=trim($_POST["email"]);
			$qq=trim($_POST["qq"]);
			$oldqq=trim($_POST["oldqq"]);
			
			if(!empty($_POST['qqid'])){
   			$qqid=$_POST['qqid'][0];
			}else{
			$qqid="";
			}
			
			$homepage=trim($_POST["homepage"]);
			//comane=trim($_POST["qomane"])
            $b=trim($_POST["b"]);
			if ($b==""){//针对个人用户
			$b=0;
			}
			$s=trim($_POST["s"]);
			if ($s==""){//针对个人用户
			$s=0;
			}
			$content=stripfxg(rtrim($_POST["content"]));
			$img=trim($_POST["img"]);
			$oldimg=trim($_POST["oldimg"]);
			if (isset($_POST["flv"])){
			$flv=trim($_POST["flv"]);
			}else{
			$flv="";
			}
			if (isset($_POST["oldflv"])){
			$oldflv=trim($_POST["oldflv"]);
			}else{
			$oldflv="";
			}			
			$province=trim($_POST["province"]);
			$city=trim($_POST["city"]);	
			$xiancheng=trim($_POST["xiancheng"]);		
			$somane=trim($_POST["somane"]);
			$address=trim($_POST["address"]);
			$mobile=trim($_POST["mobile"]);
			$fox=trim($_POST["fox"]);
			$sex=trim($_POST["sex"]);
			if ($row["usersf"]=="公司"){
				if ($content==""){//为防止输入空格
				$founderr=1;
				$errmsg=$errmsg . $f_array[2];
				}
			}
			$phone=trim($_POST["phone"]);
			if (allowrepeatreg=='no'){
			$rsn=query("select * from zzcms_user where phone='" . $phone . "' and username!='$username'");
			$r=num_rows($rsn);
			if ($r){
			$founderr=1;
			$errmsg=$errmsg . $f_array[3];
			}
			}
		
			if ($founderr==1){
			WriteErrMsg($errmsg);
			}else{
			query("update zzcms_user set bigclassid='$b',smallclassid='$s',content='$content',img='$img',flv='$flv',province='$province',city='$city',
			xiancheng='$xiancheng',somane='$somane',sex='$sex',phone='$phone',mobile='$mobile',fox='$fox',address='$address',
			email='$email',qq='$qq',qqid='$qqid',homepage='$homepage' where username='".$username."'");
			if ($oldimg<>$img && $oldimg<>"/image/nopic.gif"){
				$f="../".$oldimg;
				if (file_exists($f)){
				unlink($f);
				}
				$fs="../".str_replace(".","_small.",$oldimg);
				if (file_exists($fs)){
				unlink($fs);		
				}
			}
			if ($oldflv<>$flv){
				$f="../".$oldflv;
				if (file_exists($f)==true){
				unlink($f);
				}
			}
				if ($qq<>$oldqq) {
				query("Update zzcms_main set qq=" . $qq . " where editor='" . $username . "'");
				}
				echo $f_array[4];
			}
}else{
?>
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
<div class="admintitle"><?php echo $f_array[0]?></div>
<FORM name="myform" action="?action=modify" method="post" onSubmit="return CheckForm()">              
          <table width=100% border=0 cellpadding=3 cellspacing=1>
            <tr> 
              <td width="15%" align="right" class="border2"><?php echo $f_array[5]?>：</td>
              <td width="85%" class="border2"><?php echo $row["username"]?></td>
            </tr>
            <tr> 
              <td align="right" class="border"><?php echo $f_array[6]?>：</td>
              <td class="border"> <input name="somane" class="biaodan" value="<?php echo $row["somane"]?>" size="30" maxLength="50"></td>
            </tr>
            <tr > 
              <td align="right" class="border2"><?php echo $f_array[7]?>：</td>
              <td class="border2"> <input type="radio" value="1" name="sex" <?php if ($row["sex"]==1) { echo "CHECKED";}?>>
                <?php echo $f_array[8]?>
<INPUT type="radio" value="0" name="sex" <?php if ($row["sex"]==0) { echo "CHECKED";}?>>
               <?php echo $f_array[9]?></td>
            </tr>
            <tr> 
              <td align="right" class="border"><?php echo $f_array[10]?>：</td>
              <td class="border"> <input name="email"  class="biaodan" value="<?php echo $row["email"]?>" size="30" maxLength="50"> 
              </td>
            </tr>
            <tr > 
              <td align="right" class="border2"><?php echo $f_array[11]?>：</td>
              <td class="border2"> <input name="qq" id="qq"  class="biaodan" value="<?php echo $row["qq"]?>" size="30" maxLength="50">
                <input name="oldqq" type="hidden" id="oldqq" value="<?php echo $row["qq"]?>"></td>
            </tr>
            <tr> 
              <td align="right" class="border"><?php echo $f_array[12]?>：</td>
              <td class="border">
                <?php if ($row["qqid"]<>"") { ?>
                <input name="qqid[]" type="checkbox" id="qqid" value="1" checked>
               <?php echo $f_array[13];
				}else{
		echo $f_array[14];
	}
		?>
              </td>
            </tr>
            <tr > 
              <td align="right" class="border2"><?php echo $f_array[15]?>：</td>
              <td class="border2"> 
                <input name="mobile" id="mobile"  class="biaodan" value="<?php echo $row["mobile"]?>" size="30" maxLength="50"></td>
            </tr>
            <tr > 
              <td align="right" class="border">&nbsp;</td>
              <td class="border"> 
                <input name="Submit2"   type="submit" class="buttons" id="Submit2" value="<?php echo $f_array[16]?>"></td>
            </tr>
          </table>
	  <?php 
	  if ($row["usersf"]=="公司"){
	  ?>     
 <div class="admintitle"><?php echo $f_array[17]?></div>
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="15%" align="right" class="border2"><?php echo $f_array[18]?>：</td>
            <td width="85%" class="border2"><?php echo $row["comane"]?></td>
          </tr>
          <tr> 
            <td align="right" class="border"><?php echo $f_array[19]?>：</td>
            <td class="border"><?php
$sqln = "select * from zzcms_userclass where parentid<>'0' order by xuhao asc";
$rsn=query($sqln);
?>
              <script language = "JavaScript" type="text/javascript">
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
              <select name="b" size="1" id="b"  class="biaodan" onchange="changelocation(document.myform.b.options[document.myform.b.selectedIndex].value)">
                <option value="" selected="selected"><?php echo $f_array[20]?></option>
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
              <select name="s"  class="biaodan">
                <option value="0"><?php echo $f_array[21]?></option>
                <?php
$sqln="select * from zzcms_userclass  where parentid='" .$row["bigclassid"]."' order by xuhao asc";
$rsn=query($sqln);
$rown= num_rows($rsn);//返回记录数
if(!$rown){
?>
                <option value="" ><?php echo $f_array[22]?></option>
                <?php
}else{
while($rown = fetch_array($rsn)){
?>
                <option value="<?php echo $rown["classid"]?>" <?php if ($rown["classid"]==$row["smallclassid"]) { echo "selected";}?>><?php echo $rown["classname"]?></option>
                <?php 	  
}
}
?>
              </select></td>
          </tr>
          <tr class="border" > 
            <td align="right" class="border2"><?php echo $f_array[23]?>：</td>
            <td class="border2"><select name="province" id="province"  class="biaodan"></select>
<select name="city" id="city"  class="biaodan"></select>
<select name="xiancheng" id="xiancheng"  class="biaodan"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '<?php echo $row["xiancheng"]?>');
</script>
 
  </td>
          </tr>
          <tr> 
            <td align="right" class="border"><?php echo $f_array[24]?>：</td>
            <td class="border"> <input name="address" id="address" class="biaodan" value="<?php echo $row["address"]?>" size="30" maxlength="50"> 
            </td>
          </tr>
          <tr > 
            <td align="right" class="border2"><?php echo $f_array[25]?>：</td>
            <td class="border2"> <input name="homepage" id="homepage"  class="biaodan" value="<?php echo $row["homepage"]?>" size="30" maxLength="100"></td>
          </tr>
          <tr > 
            <td align="right" class="border"><?php echo $f_array[26]?>：</td>
            <td class="border"> <input name="phone"  class="biaodan" value="<?php echo $row["phone"]?>" size="30" maxLength="50"></td>
          </tr>
          <tr > 
            <td align="right" class="border2"><?php echo $f_array[27]?>：</td>
            <td class="border2"> <input name="fox"  class="biaodan" value="<?php echo $row["fox"]?>" size="30" maxLength="50"></td>
          </tr>
          <tr> 
            <td align="right" class="border2"><?php echo $f_array[28]?>：</td>
            <td class="border2"> 
			<textarea name="content" id="content"><?php echo $row["content"] ?></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('content');</script>   
            </td>
          </tr>
          <tr> 
            <td height="50" align="right" class="border"> <?php echo $f_array[29]?>：<br> 
              <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>">
              <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"]?>">
             </td>
            <td height="50" class="border"> 
			 <table width="140" height="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)"> 
                    <?php
				  if($row["img"]<>"" && $row["img"]<>"/image/nopic.gif"){
				  echo "<img src='".$row["img"]."' border=0 width=200 /><br>".$f_array[30];
				  }else{
				  echo "<input name='Submit2' type='button'  value='". $f_array[31]."'/>";
				  }
				  ?>
                  </td>
                </tr>
              </table></td>
          </tr>
      
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[32]?>： 
              <input name="flv" type="hidden" id="flv" value="<?php echo $row["flv"]?>" />
              <input name="oldflv" type="hidden" id="oldflv" value="<?php echo $row["flv"]?>">
              </td>
            <td class="border2" > 
			    <?php 
if (check_user_power("uploadflv")=="yes"){
?>
			<table width="140" height="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="container" onClick="openwindow('/uploadflv_form.php',400,300)"> 
                    <?php
		if($row["flv"]<>""){
				  if (substr($row["flv"],-3)=="flv") {
				  ?>
				  
                    <script type="text/javascript">
          var s1 = new SWFObject("/image/player.swf","ply","200","200","9","#FFFFFF");
          s1.addParam("allowfullscreen","true");
          s1.addParam("allowscriptaccess","always");
          s1.addParam("flashvars","file=<?php echo $row["flv"] ?>&autostart=false");
          s1.write("container");
         </script> 
                    <?php 
				 }elseif (substr($row["flv"],-3)=="swf") {
				 echo "<embed src='".$row["flv"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width=200 height=200></embed>";
				 }
			echo "<br/>".$f_array[33];
			}else{
			echo "<input name='Submit2' type='button'  value='".$f_array[34]."'/>";
			}
				  
				  ?>
                  </td>
                </tr>
              </table>
			  	    <?php
		   }else{
		  ?>
              <table width="140" height="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td onclick="javascript:window.location.href='vip_add.php'"> <?php echo $f_array[35]?></td>
                </tr>
              </table>
			 <?php
	}
	?>  
			  </td>
          </tr>
         
          <tr> 
            <td class="border">&nbsp;</td>
            <td height="40" class="border"> <input name=Submit   type=submit class="buttons" id="Submit" value="<?php echo $f_array[16]?>"> 
            </td>
          </tr>
        </table>
	  <?php
	  }
	  ?>
  </form>
 </div>
</div>
</div> 
</div>
<?php
}

unset ($f_array);
?>
</body>
</html>