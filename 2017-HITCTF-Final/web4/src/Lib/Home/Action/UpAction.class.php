<?php

namespace Home\Action;
use Common\Action\HomeAction;

class UpAction extends HomeAction
{
	public function show()
	{
		$dir = I("get.dir", "none", "strip_tags,htmlspecialchars");
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$s = I("get.s", "", "strip_tags,htmlspecialchars");
		$getdata = $_GET["data"];

		if ($getdata) {
			$year = substr($getdata, 0, 4);
			$month = substr($getdata, 4);
		}
		else {
			$year = date("Y");
			$month = date("n");
		}

		if ($dir != "none") {
			$id = get_id_by_dir($dir);
		}
		else {
			$dir = getlistdir($id);
		}

		if ($s == "up") {
			if ($month == 12) {
				$ymonth = $month - 1;
				$yyear = $year;
				$smonth = 1;
				$ssmonth = $smonth + 1;
				$sssmonth = $ssmonth + 1;
				$syear = $year + 1;
				$ssyear = $syear;
				$sssyear = $year + 1;
			}
			else if ($month == 11) {
				$ymonth = $month - 1;
				$yyear = $year;
				$syear = $year;
				$ssyear = $year + 1;
				$sssyear = $ssyear;
				$smonth = $month + 1;
				$ssmonth = 1;
				$sssmonth = $ssmonth + 1;
			}
			else if ($month == 10) {
				$ymonth = $month - 1;
				$yyear = $year;
				$syear = $year;
				$ssyear = $syear;
				$sssyear = $syear + 1;
				$smonth = $month + 1;
				$ssmonth = $smonth + 1;
				$sssmonth = 1;
			}
			else if ($month == 1) {
				$ymonth = 12;
				$yyear = $year - 1;
				$syear = $year;
				$ssyear = $year;
				$sssyear = $year;
				$smonth = $month + 1;
				$ssmonth = $month + 2;
				$sssmonth = $ssmonth + 1;
			}
			else {
				$ymonth = $month - 1;
				$yyear = $year;
				$syear = $year;
				$ssyear = $year;
				$sssyear = $year;
				$smonth = $month + 1;
				$ssmonth = $month + 2;
				$sssmonth = $ssmonth + 1;
			}
		}
		else if ($month == 1) {
			$smonth = 12;
			$ssmonth = $smonth - 1;
			$syear = $year - 1;
			$ssyear = $year - 1;
			$sssyear = $year - 1;
			$sssmonth = $ssmonth - 1;
		}
		else if ($month == 2) {
			$syear = $year - 1;
			$ssyear = $year - 1;
			$smonth = $month - 1;
			$ssmonth = 12;
			$sssyear = $year - 1;
			$sssmonth = $ssmonth - 1;
		}
		else if ($month == 3) {
			$syear = $year;
			$ssyear = $year;
			$sssyear = $year - 1;
			$smonth = $month - 1;
			$ssmonth = $month - 2;
			$sssmonth = 12;
		}
		else {
			$syear = $year;
			$ssyear = $year;
			$sssyear = $year;
			$smonth = $month - 1;
			$ssmonth = $month - 2;
			$sssmonth = $month - 3;
		}

		$p = $year . $month;
		$d = date("Y") . date("n");

		if ($p == $d) {
			$ymonth = "";
		}

		$this->assign("year", $year);
		$this->assign("month", $month);
		$this->assign("ymonth", $ymonth);
		$this->assign("getdata", $getdata);
		$this->assign("yyear", $yyear);
		$this->assign("syear", $syear);
		$this->assign("ssyear", $ssyear);
		$this->assign("sssyear", $sssyear);
		$this->assign("smonth", $smonth);
		$this->assign("ssmonth", $ssmonth);
		$this->assign("sssmonth", $sssmonth);
		$this->assign("ssssmonth", $ssssmonth);
		$this->assign("id", $id);
		$this->assign("dir", $dir);
		$this->assign("list_name", getlistname($id, "list_name"));
		$this->display("gxl_up");
	}
}


