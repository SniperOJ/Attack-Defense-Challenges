<?php
if(@$step==3){
$token = md5(uniqid(rand(), true));    
$_SESSION['token']= $token; 
?>
<div class="body">      
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
    <tr bgcolor="#F1F1F1"> 
      <td width="35%"><strong>目录/文件</strong></td>
      <td width="29%"><strong>属性</strong></td>
      <td width="36%"><strong>安装要求</strong></td>
    </tr>
	<?php 
$pass=true;
$files_array=array("../inc/config.php","../inc/wjt.php","../skin/test.txt","../template/test.txt","../uploadfiles/test.txt","../html/test.txt");
	foreach ($files_array as $files){ ?>
    <tr> 
      <td bgcolor="#FFFFFF"><?php echo str_replace('/test.txt','',$files)?></td>
      <td bgcolor="#FFFFFF"><?php  
	  		if (new_is_writeable($files)==1){
				echo "可写<img src=dui2.png>";
			} else{
				echo "不可写<img src=error.gif>";
				$pass=false;
			}?></td>
      <td bgcolor="#FFFFFF">可写<img src="dui2.png" width="18" height="17"></td>
    </tr>
	<?php } ?>
    
  </table>
   <br/>
      <?php
	if($pass==false){
		echo '<span style="color:red;">目录/文件属性未通过检测，安装无法进行!</span> <br/>';
		echo '提示：请设置不可写目录/文件(含子目录及文件)写入权限';	
	}
	?>

<form action="index.php" method="post" id="myform">
<input type="hidden" name="step" value="4"/>
<input name="token" type="hidden"  value="<?php echo $token?>"/>
    <input type="button" value="上一步" class="btn" onclick="history.back(-1);"/>
    <input type="submit" value="下一步" class="btn" <?php if(!$pass) echo ' disabled';?>/>
&nbsp;&nbsp;
    <input type="button" value="取消" class="btn" onclick="if(confirm('您确定要退出安装向导吗？')) window.close();"/>
</form>
</div>
<?php
}
?>