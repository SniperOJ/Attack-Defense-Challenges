<?php

namespace Common\Model;

use Think\Model\ViewModel;

class ActorsViewModel extends ViewModel
{
	protected $viewFields = array(
		"Actors" => array(0 => "*", "Actors_name" => "ting_actors_name"),
		"Ting"    => array(0 => "*", "_on" => "Actors.actors_id  = Ting.ting_id")
		);
}


