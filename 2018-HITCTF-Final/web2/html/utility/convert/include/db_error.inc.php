<?php

$errmsg = '';
if($error_dbtype == 'mysql') {
	$dberror = $this->error();
	$dberrno = $this->errno();
	if (!in_array($dberrno, array(1062, 1064, 1065, 1169, 1091)) || $GLOBALS['debug']){
		global $dberrnomsg;
		$errnomsg = $dberrnomsg[$dberrno];
		if($message) {
			$errmsg = "<b>XConvert info</b>: $message\n\n";
		}
		$errmsg .= "<b>Time</b>: ".gmdate("Y-n-j g:ia", $GLOBALS['timestamp'] + ($GLOBALS['timeoffset'] * 3600))."\n";
		if($sql) {
			$errmsg .= "<b>SQL</b>: ".htmlspecialchars($sql)."\n";
		}
		$errmsg .= "<b>Error</b>: $dberror\n";
		$errmsg .= "<b>Errormsg.</b>: $errnomsg\n";
		$errmsg .= "<b>Errno.</b>: $dberrno\n";
		$errmsg = nl2br(str_replace($GLOBALS['tablepre'], '[Table]', $errmsg));
		showmessage($errmsg);
	}
} elseif ($error_dbtype == 'access') {
	if($sql) {
		$errmsg = "<b>SQL</b>: ".htmlspecialchars($sql)."\n<br>";
	}
	$errmsg .= "<b>Errormsg</b>: ".$message;
	showmessage($errmsg);
} elseif ($error_dbtype == 'mssql') {
	if($sql) {
		$errmsg = "<b>SQL</b>: ".htmlspecialchars($sql)."\n<br>";
	}
	$errmsg .= "<b>Errormsg</b>: ".$message;
	($GLOBALS['debug'] || $GLOBALS['action'] == 'check') && showmessage($errmsg);
} elseif ($error_dbtype == 'oracle') {
	if($sql) {
		$errmsg = "<b>Oracle</b>: ".htmlspecialchars($sql)."\n<br>";
	}
	$errmsg .= "<b>Errormsg</b>: ".$message;
	($GLOBALS['debug'] || $GLOBALS['action'] == 'check') && showmessage($errmsg);
}
unset($error_dbtype);
?>