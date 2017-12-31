<?php

namespace Common\Model;
use Think\Model\ViewModel;
class ActorViewModel extends ViewModel
{
	protected $viewFields = array(
		"Actor" => array(0 => "*", "Actor_id" => "ting_actor_id", "actor_vid" => "ting_actor_vid"),
		"Ting"   => array(0 => "*", "_on" => "Actor.actor_vid  = Ting.ting_id")
		);
}


