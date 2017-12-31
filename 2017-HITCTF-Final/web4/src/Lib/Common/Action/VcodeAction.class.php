<?php
namespace Common\Action;
use Common\Action\AllAction;
//生成验证码
class VcodeAction extends AllAction{
    public function index(){
	    import("ORG.Util.Image");
		Image::buildImageVerify();//6,0,'png',1,20,'verify'
    }
}
?>