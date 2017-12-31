<?php
namespace Common\Model;
use Think\Model\ViewModel;
class PrtyViewModel extends ViewModel
{
	protected $viewFields = array(
		"Prty" => array(0 => "*", "prty_cid" => "ting_prty_id"),
		"Ting"  => array(0 => "*", "_on" => "Prty.prty_id  = Ting.ting_id")
		);
}


