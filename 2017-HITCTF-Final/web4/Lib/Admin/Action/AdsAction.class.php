<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class AdsAction extends BaseAction{
	// 广告列表
    public function show(){
	    $rs = D("Ads");
		$list = $rs->order('ads_id desc')->select();
		$this->assign('list_ads',$list);
        $this->display('./Public/admin/ads_show.html');
    }
	// 添加广告
    public function add(){
		$this->display('./Public/admin/ads_add.html');
    }
	// 添加广告入库
	public function insert(){
		$rs = D("Ads");
		if ($rs->create()) {
			if (false !==  $rs->add()) {
			    $this->assign("jumpUrl",'?s=Admin-Ads-Show');
			}else{
				$this->error('添加广告位出错！');
			}
		}else{
		    $this->error($rs->getError());
		}
	}
	//后置操作
	public function _after_insert(){
		$array = $_POST;
		write_file('./'.C('admin_ads_file').'/'.$array['ads_name'].'.js',t2js(stripslashes(trim($array['ads_content']))));
		$this->success('添加广告位成功！');
	}
	// 更新广告
	public function update(){
	    $array = $_POST;
		$rs = D("Ads");			
		foreach($array['ads_id'] as $value){
		    $data['ads_id'] = $array['ads_id'][$value];
			$data['ads_name'] = trim($array['ads_name'][$value]);
			$data['ads_content'] = stripslashes(trim($array['ads_content'][$value]));
			if(empty($data['ads_name'])){
			    $rs->where('ads_id='.$data['ads_id'])->delete();
			}else{
			    write_file('./'.C('admin_ads_file').'/'.$data['ads_name'].'.js',t2js($data['ads_content']));
			    $rs->save($data);
			}
		}				
		$this->success('广告数据更新成功！');
	}
	// 预览广告
    public function view(){
		$id = $_GET['id'];
		if ($id) {
		    $rs = D("Ads");
			$list = $rs->field('ads_name')->where('ads_id='.$id)->find();
			echo(adurl($list['ads_name']));
		}
    }	
	// 删除广告
    public function del(){
		$rs = D("Ads");
		$where['ads_id'] = $_GET['id'];
		$array = $rs->field('ads_name')->where($where)->find();
	    $rs->where($where)->delete();
		@unlink('./'.C('admin_ads_file').'/'.$array['ads_name'].'.js');
		redirect('?s=Admin-Ads-Show');
    }					
}
?>