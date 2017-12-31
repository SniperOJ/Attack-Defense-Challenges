<?php
namespace Common\Model;
use Think\Model\ViewModel;
class GbViewModel extends ViewModel {
	//视图定义
	protected $viewFields = array (
		 'Gb'=>array('*'),
		 'User'=>array('user_id,user_name,user_face','_on'=>'Gb.gb_uid = User.user_id'),
	);
}
?>