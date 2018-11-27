<?php
if(@$step==5){
if ($_POST['token'] != $_SESSION['token'] || $_POST['token']=='' ){    
showmsg('非法提交','back');
}else{
unset($_SESSION['token']);
}
?>
<div class="body">
<div style="width:660px; height:500px; overflow: scroll;">
<?php
//@header("content-Type: text/html; charset=UTF-8");
//error_reporting(0);
//$dbcharset = 'utf8';
$admin=trim($_POST["admin"]);
$adminpwdtrue=trim($_POST["adminpwd"]);
$adminpwd=md5(trim($_POST["adminpwd"]));

$conn=mysql_connect($db_host,$db_user,$db_pass,$db_name);
mysql_query("CREATE DATABASE $db_name");
mysql_query("SET NAMES 'utf8'",$conn); 
mysql_select_db($db_name,$conn);

$get_sqls =file_get_contents("data.sql");
$sqls = explode(";",$get_sqls);
$cnt = count($sqls);
for($i=0;$i<$cnt;$i++){
   $sql = $sqls[$i];
   $result =mysql_query($sql);
   if($result){
       echo "成功执行第:".$i."个查询<br>";
   }
   else
    {
       echo "导入失败:".mysql_error();
   }
}
mysql_query("replace into `zzcms_admin` values('1','1','$admin','$adminpwd','0','','2013-04-12 08:46:54','','2013-04-11 15:49:15');");//写入管理员帐号
?>
</div>
<form action="index.php" method="post" id="myform">
<input type="hidden" name="admin" value="<?php echo $admin;?>"/>
<input type="hidden" name="adminpwdtrue" value="<?php echo $adminpwdtrue;?>"/>
<input type="hidden" name="step" value="6"/>
    <input type="button" value="上一步" class="btn" onclick="history.back(-1);" disabled/>
    <input type="submit" value="下一步" class="btn"/>
    &nbsp;&nbsp; 
  </form>
</div>
<?php
}
?>