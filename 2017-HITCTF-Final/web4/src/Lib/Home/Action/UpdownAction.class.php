<?php
namespace Home\Action;
use Common\Action\HomeAction;
use Think\Model;
class UpdownAction extends HomeAction{
    public function ting(){
		$id = intval(I('get.id','','strip_tags,htmlspecialchars'));
		$type=trim(I('get.type','','strip_tags,htmlspecialchars'));
		if ($id < 1) {
			$data['data']="-1";
			$data['info']="数据非法";
			$data['status']="-1";	
			$this->ajaxReturn($data);
		}
		$this->show($id,$type,'ting');
    }
    public function news(){
		$id = intval(I('get.id','','strip_tags,htmlspecialchars'));
		$type =trim(I('get.type','','strip_tags,htmlspecialchars'));
		if ($id < 1) {
			$data['data']="-1";
			$data['info']="数据非法";
			$data['status']="-1";	
			$this->ajaxReturn($data);
		}
		$this->show($id,$type,'news');
    }	
	public function show($id,$type,$model='ting'){
		$rs = D(ucfirst($model));
		if($type){
			$cookie = $model.'-updown-'.$id;
			if(isset($_COOKIE[$cookie])){
			    $data['data']=0;
			    $data['info']="您已操作过，晚点再试！";
			    $data['status']=0;	
				$this->ajaxReturn($data);
			}
			if ('up' == $type){
				$rs->where(array('ting_id'=>$id))->setInc($model.'_up');
				setcookie($cookie, 'true', time()+intval(C('user_second')));
			}elseif( 'down' == $type){
				$rs->where(array('ting_id'=>$id))->setInc($model.'_down');
				setcookie($cookie, 'true', time()+intval(C('user_second')));
			}
		}
		$array = $rs->field(''.$model.'_up,'.$model.'_down')->find($id);
		if (!$array) {
			$array[$model.'_up'] = 0;
			$array[$model.'_down'] = 0;
		}
		$arrays['data']=$array[$model.'_up'].':'.$array[$model.'_down'];
		$arrays['info']="感谢您的参与，操作成功！";
		$arrays['status']=1;
		$this->ajaxReturn($arrays);
		
		//echo($array[$model.'_up'].':'.$array[$model.'_down']);			
	}	
}
?>