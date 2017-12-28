<?php
namespace org\net;

class Code
{
	public $_keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	public $Qval = "";
	public $sid = "";

	public function SetPar($Qval, $Aval, $sid)
	{
		$this->Qval = $Qval;
		$this->Aval = $Aval;
		$this->sid = $sid;
	}

	public function J($str)
	{
		return base64_encode($str);
	}

	public function _C($str)
	{
		return base64_decode($str);
	}

	public function GID($str)
	{
		return "";
	}

	public function k($a)
	{
		return $this->Qval;
	}

	public function c()
	{
		$id = $this->sid;
		return $id;
	}

	public function d($p, $h)
	{
		$v = $this->w($h);
		$x = $this->c();
		$d = 2;
		$i = ($d == 0 ? 7 : $d);
		$i = $i * $i;
		$F = $this->_keyStr[$i];
		return $F . $this->J($x . "|" . $this->e($p)) . $v;
	}

	public function e($u)
	{
		$x = 1;
		$a = $this->Aval;

		if (!empty($a)) {
			$x = $a;
		}
		else {
			$x = $u;
		}

		return $a;
	}

	public function w($v)
	{
		$t = $this->GID("head");
		$a = "|";

		if (empty($t)) {
			$tl = "/";
		}
		else {
			$tl = $v;
		}

		$r = $this->J($a . $this->K($tl));
		return $r;
	}
}

namespace Org\Net;

function encode($QID, $AID, $SID)
{
	$A_ = new Code();
	$A_->setPar($QID, $AID, $SID);
	return $A_->d("a", "src");
}


