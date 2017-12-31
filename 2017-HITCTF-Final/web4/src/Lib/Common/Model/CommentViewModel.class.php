<?php
namespace Common\Model;
use Think\Model\ViewModel;
class CommentViewModel extends ViewModel
{
	protected $viewFields = array(
		"Comment" => array(0 => "*", "username" => "user_username", "ip" => "user_ip"),
		"User"    => array(0 => "nickname,email", "_on" => "Comment.userid = User.userid")
		);
}


