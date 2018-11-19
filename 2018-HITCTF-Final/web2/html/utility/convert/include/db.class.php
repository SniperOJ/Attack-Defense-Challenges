<?php

/**
 * DiscuzX Convert
 *
 * $Id: db.class.php 10469 2010-05-11 09:12:14Z monkey $
 */

class db_mysql
{
	var $tablepre;
	var $version = '';
	var $querynum = 0;
	var $curlink;
	var $link = array();
	var $config = array();
	var $sqldebug = array();

	function db_mysql($config = array()) {
		if(!empty($config)) {
			$this->set_config($config);
		}
	}

	function set_config($config) {
		$this->config = &$config;
		$this->tablepre = "`{$config['dbname']}`.{$config['tablepre']}";
	}

	function connect($halt = true) {
		$this->curlink = null;
		$this->_dbconnect(
			$this->config['dbhost'],
			$this->config['dbuser'],
			$this->config['dbpw'],
			$this->config['dbcharset'],
			$this->config['dbname'],
			$this->config['pconnect'],
			$halt
			);
		return $this->curlink ? true : false;
	}

	function _dbconnect($dbhost, $dbuser, $dbpw, $dbcharset, $dbname, $pconnect, $halt = true) {
		$dbcharset = !$dbcharset ? 'binary' : $dbcharset;
		$link =$this->curlink = null;
		$func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
		if(!$link = @$func($dbhost, $dbuser, $dbpw, 1)) {
			$halt && $this->halt('Connect Error');
		} else {
			$this->curlink = & $link;
			if($this->version() > '4.1') {
				$serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
				$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET $serverset", $link);
			}

			if($dbname) {
				$return = $this->query("use `$dbname`", $halt ? '' : 'SILENT');
				if(!$return) {
					$this->curlink = null;
				}
			}
		}
		return $link;
	}

	function table_name($tablename) {
		return $this->tablepre.$tablename;
	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->curlink);
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function fetch_first($sql) {
		return $this->fetch_array($this->query($sql));
	}

	function result_first($sql) {
		return $this->result($this->query($sql), 0);
	}

	function query($sql, $type = '') {

		if(defined('DISCUZ_DEBUG') && DISCUZ_DEBUG) {
			$starttime = dmicrotime();
		}
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
		'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->curlink))) {

			if(in_array($this->errno(), array(2006, 2013)) && substr($type, 0, 5) != 'RETRY') {
				$this->connect();
				return $this->query($sql, 'RETRY'.$type);
			}
			if($type != 'SILENT' && substr($type, 5) != 'SILENT') {
				$this->halt('query_error', $sql);
			}
		}

		if(defined('DISCUZ_DEBUG') && DISCUZ_DEBUG) {
			$this->sqldebug[] = array($sql, number_format((dmicrotime() - $starttime), 6), debug_backtrace());
		}

		$this->querynum++;
		return $query;
	}

	function affected_rows() {
		return mysql_affected_rows($this->curlink);
	}

	function error() {
		return (($this->curlink) ? mysql_error($this->curlink) : mysql_error());
	}

	function errno() {
		return intval(($this->curlink) ? mysql_errno($this->curlink) : mysql_errno());
	}

	function result($query, $row = 0) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->curlink)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->curlink);
		}
		return $this->version;
	}

	function close() {
		return $this->curlink ? mysql_close($this->curlink) : true;
	}

	function table($table) {
		return $this->table_name($table);
	}

	function insert($table, $data, $return_insert_id = false, $replace = false, $silent = false) {

		$sql = $this->implode_field_value($data);
		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
		$table = $this->table($table);
		$silent = $silent ? 'SILENT' : '';
		$return = $this->query("$cmd $table SET $sql", $silent);
		return $return_insert_id ? $this->insert_id() : $return;

	}

	function update($table, $data, $condition, $unbuffered = false, $low_priority = false) {
		$sql = $this->implode_field_value($data);
		$cmd = "UPDATE ".($low_priority ? 'LOW_PRIORITY' : '');
		$table = $this->table($table);
		$where = '';
		if(empty($condition)) {
			$where = '1';
		} elseif(is_array($condition)) {
			$where = $this->implode_field_value($condition, ' AND ');
		} else {
			$where = $condition;
		}
		$res = $this->query("$cmd $table SET $sql WHERE $where", $unbuffered ? 'UNBUFFERED' : '');
		return $res;
	}

	function implode_field_value($array, $glue = ',') {
		$sql = $comma = '';
		foreach ($array as $k => $v) {
			$sql .= $comma."`$k`='$v'";
			$comma = $glue;
		}
		return $sql;
	}

	function halt($message = '', $sql = '') {
		$dberror = $this->error();
		$dberrno = $this->errno();
		$phperror = '<table style="font-size:11px" cellpadding="0">
			<tr>
			<td width="270">File</td>
			<td width="80">Line</td>
			<td>Class</td>
			<td>Type</td>
			<td>Function</td>
			</tr>
			';
		foreach (debug_backtrace() as $error) {
			$error['file'] = str_replace(DISCUZ_ROOT, '', $error['file']);
			$phperror .= "<tr>
				<td>$error[file]</td>
				<td>$error[line] </td>
				<td>$error[class]</td>
				<td>$error[type]</td>
				<td>$error[function]</td>
				</tr>
				";
		}
		$phperror .= '</table>';
		$help_link = "http://faq.comsenz.com/?type=mysql&dberrno=".rawurlencode($dberrno)."&dberror=".rawurlencode($dberror);
		echo "<div style=\"font-size:11px;font-family:verdana,arial;background:#EBEBEB;padding:0.5em;\">
			<b>MySQL Error</b><br>
			<b>Message</b>: $message<br>
			<b>SQL</b>: $sql<br>
			<b>Error</b>: $dberror<br>
			<b>Errno.</b>: $dberrno<br>
			<a href=\"$help_link\" target=\"_blank\">Click here to seek help.</a><br><br>
			<b>PHP Backtrace</b><br>
			$phperror
			<br>
			</div>";
		exit();

	}

}