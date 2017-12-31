<?php
namespace Common\Model;
use Think\Model\ViewModel;
class UrlsViewModel extends ViewModel
{
	protected $viewFields = array(
		"Urls" => array(0 => "*", "ting_id" => "urls_ting_id"),
		"Ting"  => array(0 => "*", "_on" => "Urls.ting_id  = Ting.ting_id")
		);
}


