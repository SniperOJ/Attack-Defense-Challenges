<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class CjAction extends BaseAction{
	public function show(){
		dump('预留功能');
	}
	// 添加编辑采集节点
    public function add(){
		dump('预留功能');
		exit();
		$rs = D("Cj");
		$cj_id = intval($_GET['id']);
		$cj_mod = trim($_GET['mod']);
		$where = array();
		if($cj_id){
			if(!$cj_mod){
				$where['cj_id'] = $cj_id;
				$where['cj_pid'] = 0;
				$array = $rs->where($where)->find();
				dump($array);			
			}else{
				$where['cj_pid'] = $cj_id;
				$where['cj_oid'] = array('gt',1);	
				$list = $rs->where($where)->select();
				if($list){
					dump($list);
				}else{
					$array['cj_mod'] = $cj_mod;
				}
			}
			$array['cj_templatetitle'] = '编辑';
		}else{
		    $array['cj_coding'] = 'gbk';
			$array['cj_savepic'] = 0;
			$array['cj_order'] = 0;
			$array['cj_pid'] = 0;
			$array['cj_oid'] = 1;
			$array['cj_mod'] = 'node';
			$array['cj_templatetitle'] = '添加';
		}
		$this->assign($array);
		$this->ppting_play();
		$this->assign('listtree',F('_ppting/listting'));
		$this->display('./Public/admin/cj_add.html');
    }
	// 添加采集节点数据第一步	
	public function insert() {
		$rs = D("Cj");
		if (!$rs->create()) {
			$this->error($rs->getError());
		}
		$cj_id = $rs->add();
		if(false !==  $cj_id){
			redirect('?s=Admin-Cj-Add-id-'.$cj_id.'-oid-2-mod-'.$_POST['cj_nextmod']);
		}else{
			$this->error('添加采集节点添加出错！');
		}
	}
	// 更新数据库信息
	public function update(){
		if(empty($_POST['collect_savepic'])){
			$_POST['collect_savepic'] = 0;
		}
		if(empty($_POST['collect_order'])){
			$_POST['collect_order'] = 0;
		}
		$rs = D("Collect");
		if($rs->create()){
			$id = intval($_POST['collect_id']);
			if(false !==  $rs->save()){
				//F('_collects/id_'.$id,NULL);
				//F('_collects/id_'.$id.'_rule',NULL);
				//$this->f_replace($_POST['collect_replace'],$id);
				$this->assign("jumpUrl",'?s=Admin-Collect-Caiji-ids-'.$id.'-tid-2');
				$this->success('采集规则更新成功,测试一下是否能正常采集！');
			}else{
				$this->error("没有更新任何数据！");
			}
		}else{
			$this->error($rs->getError());
		}
	}
	// 栏目分类转换
    public function change(){
		$change_content = trim(F('_collect/change'));
		$this->assign('change_content',$change_content);
        $this->display('./Public/admin/cj_change.html');
    }
	// 栏目分类转换保存
    public function changeup(){
		F('_collect/change',trim($_POST["content"]));
		$array_rule = explode(chr(13),trim($_POST["content"]));
		foreach($array_rule as $key => $listvalue){
			$arrlist = explode('|',trim($listvalue));
			$array[$arrlist[0]] = intval($arrlist[1]);
		}
		F('_collect/change_array',$array);		
		$this->assign("jumpUrl",'?s=Admin-Cj-Change');
		$this->success('栏目转换规则编辑成功！');
	}			
}
?>