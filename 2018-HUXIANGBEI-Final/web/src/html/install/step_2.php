<?php
if(@$step==2){
?>
<div class="body">	
  <table width="100%" cellpadding="4" cellspacing="1" bgcolor="#dddddd" class="bgcolor2">
    <tr align="center" bgcolor="#f1f1f1"> 
      <td>检查项目</td>
      <td>当前环境</td>
      <td>要求环境</td>
      <td>推荐环境</td>
      <td>检测结果</td>
    </tr>
    <tr align="center"> 
      <td bgcolor="#FFFFFF">PHP版本</td>
      <td bgcolor="#FFFFFF"><?php echo $PHP_VERSION;?></td>
      <td bgcolor="#FFFFFF">4.3.0及以上</td>
      <td bgcolor="#FFFFFF">5.0.0及以上</td>
      <td bgcolor="#FFFFFF"><?php echo $php_pass ? '通过<img src=dui2.png>' : '<span style="color:red;">PHP版本过低</span>';?></td>
    </tr>
    <tr align="center"> 
      <td bgcolor="#FFFFFF">MySQL版本</td>
      <td bgcolor="#FFFFFF"><?php echo $PHP_MYSQL;?></td>
      <td bgcolor="#FFFFFF">4.0.0及以上</td>
      <td bgcolor="#FFFFFF">5.0.0及以上</td>
      <td bgcolor="#FFFFFF"><?php echo $mysql_pass ? '通过<img src=dui2.png>' : '<span style="color:red;">MySQL版本过低</span>';?></td>
    </tr>
    <tr align="center"> 
      <td bgcolor="#FFFFFF">GD库</td>
      <td bgcolor="#FFFFFF"><?php echo $PHP_GD;?></td>
      <td bgcolor="#FFFFFF">jpg gif png</td>
      <td bgcolor="#FFFFFF">jpg gif png</td>
      <td bgcolor="#FFFFFF"><?php echo $gd_pass ? '通过<img src=dui2.png>' : '<span style="color:red;">无法处理图片</span>';?></td>
    </tr>
    <tr align="center"> 
      <td bgcolor="#FFFFFF">URL打开文件</td>
      <td bgcolor="#FFFFFF"><?php echo $PHP_URL ? '支持' : '不支持';?></td>
      <td bgcolor="#FFFFFF">支持</td>
      <td bgcolor="#FFFFFF">支持</td>
      <td bgcolor="#FFFFFF"><?php echo $url_pass ? '通过<img src=dui2.png>' : '<span style="color:red;">建议开启</span>';?></td>
    </tr>
    <tr align="center"> 
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
  </table>
	<br/>

	<?php
	if(!$pass) {
		echo '<span style="color:red;">服务器环境配置未通过检测，安装无法进行!</span> <br/>';
		echo '提示：请按提示配置好服务器环境后重新运行本安装向导。';
	}
	?>
<form action="index.php" method="post" id="myform">
      <input type="hidden" name="step" value="3"/>
    <input type="button" value="上一步" class="btn" onclick="history.back(-1);"/>
    <input type="submit" value="下一步" class="btn" <?php if(!$pass) echo ' disabled';?>/>
&nbsp;&nbsp;
    <input type="button" value=" 取消 " class="btn" onclick="if(confirm('您确定要退出安装向导吗？')) window.close();"/>
</form>
 </div>
<?php
}
?>