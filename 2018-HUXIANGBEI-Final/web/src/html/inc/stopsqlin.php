<?php
//主要针对在任何文件后加?%3Cscript%3E，即使文件中没有参数
if (strpos($_SERVER['REQUEST_URI'],'script')!==false || strpos($_SERVER['REQUEST_URI'],'%26%2399%26%')!==false|| strpos($_SERVER['REQUEST_URI'],'%2F%3Cobject')!==false){
die ("无效参数");//注意这里不能用js提示
}
//转义安全字符,转义html格式
function zc_check($string){
		if(!is_array($string)) return addslashes(htmlspecialchars(trim($string)));
		foreach($string as $k => $v) $string[$k] = zc_check($v);
		return $string;
}
	
//只转义安全字符,用于magic_quotes_gpc()开启的情况
function zc_check2($string){
		if(!is_array($string)) return htmlspecialchars(trim($string));
		foreach($string as $k => $v) $string[$k] = zc_check2($v);
		return $string;
}
	
if($_REQUEST){
		if(get_magic_quotes_gpc()){
			$_POST =zc_check2($_POST);
			$_GET =zc_check2($_GET);
			$_COOKIE =zc_check2($_COOKIE);
			//@extract($_POST);
			//@extract($_GET);
		}else{
			$_POST = zc_check($_POST);
			$_GET = zc_check($_GET);
			$_COOKIE =zc_check($_COOKIE);
			//@extract($_POST);
			//@extract($_GET);
		}
}

//特别的表单，需要特别提示的
function nostr($str){
	$sql_injdata = "',/,\,<,>,�";
    $sql_inj = explode(",",$sql_injdata);
	for ($i=0; $i< count($sql_inj);$i++){
		if (@strpos($str,$sql_inj[$i])!==false){ 
		showmsg ("含有非法字符 [".$sql_inj[$i]."] 返回重填");
		}
	}
	return $str;//没有的返回值
}
	
//过滤指定字符,
function stopsqlin($str){
if(!is_array($str)) {//有数组数据会传过来比如代理留言中的省份$_POST['province'][$i]
	$str=strtolower($str);//否则过过滤不全
	
	$sql_injdata = "";
	$sql_injdata= $sql_injdata."|".stopwords;
	$sql_injdata=CutFenGeXian($sql_injdata,"|");
	
    $sql_inj = explode("|",$sql_injdata);
	for ($i=0; $i< count($sql_inj);$i++){
		if (@strpos($str,$sql_inj[$i])!==false) {showmsg ("参数中含有非法字符 [".$sql_inj[$i]."] 系统不与处理");}
	}
}	
}
	
$r_url=strtolower($_SERVER["REQUEST_URI"]);
if (checksqlin=="Yes") {
if (strpos($r_url,"siteconfig.php")==0 && strpos($r_url,"label")==0 && strpos($r_url,"template.php")==0) {
foreach ($_GET as $get_key=>$get_var){ stopsqlin($get_var);} /* 过滤所有GET过来的变量 */      
foreach ($_POST as $post_key=>$post_var){ stopsqlin($post_var);	}/* 过滤所有POST过来的变量 */
foreach ($_COOKIE as $cookie_key=>$cookie_var){ stopsqlin($cookie_var);	}/* 过滤所有COOKIE过来的变量 */
foreach ($_REQUEST as $request_key=>$request_var){ stopsqlin($request_var);	}/* 过滤所有request过来的变量 */
}
}
?>