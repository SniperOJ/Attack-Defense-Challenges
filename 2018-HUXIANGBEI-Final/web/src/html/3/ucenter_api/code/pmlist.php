<?php
/**
 * UCenter 应用程序开发 Example
 *
 * 自制短消息平台的 Example 代码
 */

$timeoffset = 8;
$ppp = 10;

$phpself = $_SERVER['PHP_SELF'].'?example=pmlist';
$action = !empty($_GET['action']) ? $_GET['action'] : '';

$output = "
	<a href=\"$phpself\">短消息</a>
	<a href=\"$phpself&filter=newpm\">未读消息</a>
	<a href=\"$phpself&filter=announcepm\">公共消息</a>
	<a href=\"$phpself&action=send\">发送短消息</a>
	<a href=\"$phpself&action=viewblackls\">黑名单</a>
	<hr>
".print_r($newdata, 1);

switch($action) {
	case '':
		$_GET['page'] =  max(1, intval($_GET['page']));
		
		$_GET['folder'] = !empty($_GET['folder']) ? $_GET['folder'] : 'inbox';
		$_GET['filter'] = !empty($_GET['filter']) ? $_GET['filter'] : '';
		
		$data = uc_pm_list($Example_uid, $_GET['page'], $ppp, $_GET['folder'], $_GET['filter'], 100);

		foreach($data['data'] as $pm) {
			if($_GET['filter'] != 'announcepm') {
				$output .= "<li>[$pm[msgfrom]]<a href=\"$phpself&action=view&touid=$pm[touid]\">$pm[subject] (".gmdate('Y-m-d H:i:s', $pm['dateline'] + $timeoffset * 3600).")</a>";
				$pm['new'] && $output .= " New! ";
				$output .= "<br />$pm[message]";
			} else {
				$output .= "<li><a href=\"$phpself&action=view&pmid=$pm[pmid]\">$pm[subject]</a>";
			}			
		}
		break;
	case 'view':
		$pmid = !empty($_GET['pmid']) ? $_GET['pmid'] : '';
		$data = uc_pm_view($Example_uid, $pmid, $_GET['touid']);
		
		foreach($data as $pm) {
			$output .= "<b>$pm[msgfrom] (".gmdate('Y-m-d H:i:s', $pm['dateline'] + $timeoffset * 3600)."):</b>";
			if($_GET['touid'] == $pm['msgfromid']) {
				$output .= "<a href=\"$phpself&action=addblackls&user=$pm[msgfrom]\">[屏蔽]</a>";
			}
			$output .= "<br>$pm[message]<br><br>";
		}
		
		if(empty($_GET['pmid'])) {
			$output .= "
				<a href=\"$phpself&action=delete&uid=$_GET[touid]\">删除</a>
				<form method=\"post\" action=\"$phpself&action=send\">
				<input name=\"touid\" type=\"hidden\" value=\"$_GET[touid]\">
				<input name=\"subject\" value=\"\"><br>
				<textarea name=\"message\" cols=\"30\" rows=\"5\"></textarea>
				<input type=\"submit\">
				</form>
				";
		}
		break;
	case 'delete':
		if(uc_pm_deleteuser($Example_uid, array($_GET['uid']))) {
			$output .= "短消息已删除。";
		}
		break;
	case 'addblackls':
		$user = !empty($_GET['user']) ? $_GET['user'] : (!empty($_POST['user']) ? $_POST['user'] : '');
		if(uc_pm_blackls_add($Example_uid, $user)) {
			$output .= $_GET['user']." 已加入黑名单。";
		}
		break;
	case 'deleteblackls':
		if(uc_pm_blackls_delete($Example_uid, $_GET['user'])) {
			$output .= $_GET['user']." 已从黑名单中移除。";
		}
		break;
	case 'viewblackls':
		$data = explode(',', uc_pm_blackls_get($Example_uid));
		foreach($data as $ls) {
			$ls && $output .= "$ls <a href=\"$phpself&action=deleteblackls&user=$ls\">[移除]</a>";
		}
		$output .= "
			<form method=\"post\" action=\"$phpself&action=addblackls\">
			<input name=\"user\" value=\"\">
			<input type=\"submit\">
			</form>
			";
		break;
	case 'send':
		if(!empty($_POST)) {
			if(!empty($_POST['touser'])) {
				$msgto = $_POST['touser'];
				$isusername = 1;
			} else {
				$msgto = $_POST['touid'];
				$isusername = 0;
			}
			if(uc_pm_send($Example_uid, $msgto, $_POST['subject'], $_POST['message'], 1, 0, $isusername)) {
				$output .= "短消息已发送";
			} else {
				$output .= "短消息发送失败，<a href=\"###\" onclick=\"history.back()\">返回</a>";
			}
		} else {
			$output .= "
				<form method=\"post\" action=\"$phpself&action=send\">
				发送给:<input name=\"touser\" value=\"\"><br>
				标题:<input name=\"subject\" value=\"\"><br>
				内容:<textarea name=\"message\" cols=\"30\" rows=\"5\"></textarea>
				<input type=\"submit\">
				</form>
				";
		}
		break;
}

echo $output;
?>