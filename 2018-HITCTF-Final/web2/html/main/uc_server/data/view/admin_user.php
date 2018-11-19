<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>
<script src="js/calendar.js" type="text/javascript"></script>

<?php if($a == 'ls') { ?>

	<script type="text/javascript">
		function switchbtn(btn) {
			$('srchuserdiv').style.display = btn == 'srch' ? '' : 'none';
			$('srchuserdiv').className = btn == 'srch' ? 'tabcontentcur' : '' ;
			$('srchuserbtn').className = btn == 'srch' ? 'tabcurrent' : '';
			$('adduserdiv').style.display = btn == 'srch' ? 'none' : '';
			$('adduserdiv').className = btn == 'srch' ? '' : 'tabcontentcur';
			$('adduserbtn').className = btn == 'srch' ? '' : 'tabcurrent';
		}
	</script>

	<div class="container">
		<?php if($status) { ?>
			<div class="<?php if($status > 0) { ?>correctmsg<?php } else { ?>errormsg<?php } ?>"><p><?php if($status < 0) { ?><em>添加用户失败:</em> <?php } ?><?php if($status == 2) { ?>成功删除用户<?php } elseif($status == 1) { ?>成功添加用户。<?php } elseif($status == -1) { ?>用户名不合法<?php } elseif($status == -2) { ?>用户名包含敏感字符<?php } elseif($status == -3) { ?>该用户名已经被注册<?php } elseif($status == -4) { ?>Email 地址不合法<?php } elseif($status == -5) { ?>Email 包含不可使用的邮箱域名<?php } elseif($status == -6) { ?>该 Email 地址已经被注册<?php } ?></p></div>
		<?php } ?>
		<div class="hastabmenu">
			<ul class="tabmenu">
				<li id="srchuserbtn" class="tabcurrent"><a href="#" onclick="switchbtn('srch')">搜索用户</a></li>
				<li id="adduserbtn"><a href="#" onclick="switchbtn('add')">添加用户</a></li>
			</ul>
			<div id="adduserdiv" class="tabcontent" style="display:none;">
				<form action="admin.php?m=user&a=ls&adduser=yes" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table width="100%">
					<tr>
						<td>用户名:</td>
						<td><input type="text" name="addname" class="txt" /></td>
						<td>密码:</td>
						<td><input type="text" name="addpassword" class="txt" /></td>
						<td>Email:</td>
						<td><input type="text" name="addemail" class="txt" /></td>
						<td><input type="submit" value="提 交"  class="btn" /></td>
					</tr>
				</table>
				</form>
			</div>
			<div id="srchuserdiv" class="tabcontentcur">
				<form action="admin.php?m=user&a=ls" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table width="100%">
					<tr>
						<td>用户名:</td>
						<td><input type="text" name="srchname" value="<?php echo $srchname;?>" class="txt" /></td>
						<td>UID:</td>
						<td><input type="text" name="srchuid" value="<?php echo $srchuid;?>" class="txt" /></td>
						<td>Email:</td>
						<td><input type="text" name="srchemail" value="<?php echo $srchemail;?>" class="txt" /></td>
						<td rowspan="2"><input type="submit" value="提 交" class="btn" /></td>
					</tr>
					<tr>
						<td>注册日期:</td>
						<td colspan="3"><input type="text" name="srchregdatestart" onclick="showcalendar();" value="<?php echo $srchregdatestart;?>" class="txt" /> 到 <input type="text" name="srchregdateend" onclick="showcalendar();" value="<?php echo $srchregdateend;?>" class="txt" /></td>
						<td>注册IP:</td>
						<td><input type="text" name="srchregip" value="<?php echo $srchregip;?>" class="txt" /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>

		<?php if($adduser) { ?><script type="text/javascript">switchbtn('add');</script><?php } ?>
<br />
		<h3>用户列表</h3>
		<div class="mainbox">
			<?php if($userlist) { ?>
				<form action="admin.php?m=user&a=ls&srchname=<?php echo $srchname;?>&srchregdate=<?php echo $srchregdate;?>" onsubmit="return confirm('该操作不可恢复，您确认要删除这些用户吗？');" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
					<tr>
						<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">删除</label></th>
						<th>用户名</th>
						<th>Email</th>
						<th>注册日期</th>
						<th>注册IP</th>
						<th>编辑</th>
					</tr>
					<?php foreach((array)$userlist as $user) {?>
						<tr>
							<td class="option"><input type="checkbox" name="delete[]" value="<?php echo $user['uid'];?>" class="checkbox" /></td>
							<td><?php echo $user['smallavatar'];?> <strong><?php echo $user['username'];?></strong></td>
							<td><?php echo $user['email'];?></td>
							<td><?php echo $user['regdate'];?></td>
							<td><?php echo $user['regip'];?></td>
							<td><a href="admin.php?m=user&a=edit&uid=<?php echo $user['uid'];?>">编辑</a></td>
						</tr>
					<?php } ?>
					<tr class="nobg">
						<td><input type="submit" value="提 交" class="btn" /></td>
						<td class="tdpage" colspan="6"><?php echo $multipage;?></td>
					</tr>
				</table>
				</form>
			<?php } else { ?>
				<div class="note">
					<p class="i">目前没有相关记录!</p>
				</div>
			<?php } ?>
		</div>
	</div>

<?php } else { ?>

	<div class="container">
		<h3 class="marginbot">编辑用户资料
			<?php if(getgpc('fromadmin')) { ?>
				<a href="admin.php?m=admin&a=ls" class="sgbtn">返回管理员列表</a>
			<?php } else { ?>
				<a href="admin.php?m=user&a=ls" class="sgbtn">返回用户列表</a>
			<?php } ?>
		</h3>
		<?php if($status == 1) { ?>
			<div class="correctmsg"><p>编辑用户资料成功</p></div>
		<?php } elseif($status == -1) { ?>
			<div class="correctmsg"><p>编辑用户资料失败</p></div>
		<?php } else { ?>
			<div class="note"><p class="i">密码留空，保持不变。</p></div>
		<?php } ?>
		<div class="mainbox">
			<form action="admin.php?m=user&a=edit&uid=<?php echo $uid;?>" method="post">
			<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="opt">
					<tr>
						<th>头像: <input name="delavatar" class="checkbox" type="checkbox" value="1" /> 删除头像</th>
					</tr>
					<tr>
						<th>虚拟头像:</th>
					</tr>
					<tr>
						<td><?php echo $user['bigavatar'];?></td>
					</tr>
					<tr>
						<th>真实头像:</th>
					</tr>
					<tr>
						<td><?php echo $user['bigavatarreal'];?></td>
					</tr>
					<tr>
						<th>用户名:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="newusername" value="<?php echo $user['username'];?>" class="txt" />
							<input type="hidden" name="username" value="<?php echo $user['username'];?>" class="txt" />
						</td>
					</tr>
					<tr>
						<th>密　码:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="password" value="" class="txt" />
						</td>
					</tr>
					<tr>
						<th>安全提问: <input type="checkbox" class="checkbox" name="rmrecques" value="1" /> 清除安全提问</th>
					</tr>
					<tr>
						<th>Email:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="email" value="<?php echo $user['email'];?>" class="txt" />
						</td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" 提 交 " class="btn" tabindex="3" /></div>
			</form>
		</div>
	</div>
<?php } ?>
<?php include $this->gettpl('footer');?>