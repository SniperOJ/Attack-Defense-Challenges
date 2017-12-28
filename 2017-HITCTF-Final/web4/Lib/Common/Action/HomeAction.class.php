<?php
//前台公用类库
namespace Common\Action;
use Common\Action\AllAction;
class HomeAction extends AllAction{
    public function _initialize(){
		parent::_initialize();
        $this->assign($this->Lable_Style());
    }
}
?>