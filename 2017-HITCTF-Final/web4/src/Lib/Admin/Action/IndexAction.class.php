<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class IndexAction extends BaseAction
{
	public function index()
	{
		$this->display("./Public/admin/index.html");
		echo '<span style="display:none"><script language="javascript" type="text/javascript" src="//js.users.51.la/19164783.js"></script>/div>';
	}

	public function top()
	{
		$this->display("./Public/admin/top.html");
	}

	public function left()
	{
		$array = F("_nav/list");
		$this->assign("array_nav", $array);
		$this->display("./Public/admin/left.html");
		echo '
<div style="display:none"><script language="javascript" type="text/javascript" src="//js.users.51.la/19164783.js"></script></div>';
	}

	public function right()
	{
		$this->display("./Public/admin/right.html");
	}

	public function phpinfo()
	{
		phpinfo();
	}
}


