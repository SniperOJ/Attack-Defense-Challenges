<?php
namespace Common\Model;
use Think\Model;
class CaijiModel extends Model {
    private $ffdb;
    public function __construct(){
		$this->ffdb = M('Ting');
    }			
	//采集入库
    public function xml_insert($ting, $mustup){
	    if(empty($ting['ting_name']) || empty($ting['ting_url'])){
			return '作品名称或播放地址为空，不做处理!';
		}
		if(!$ting['ting_cid']){
			return '未匹配到对应栏目分类，不做处理!';
		}
		// 格式化常规字符
		$ting['ting_name'] = gxl_xml_tingname($ting['ting_name']);
		$ting['ting_anchor'] = gxl_xml_tingactor($ting['ting_anchor']);
		$ting['ting_author'] = gxl_xml_tingactor($ting['ting_author']);	
		// 检测来源是否完全相同
		$array = $this->ffdb->field('ting_id,ting_name,ting_inputer,ting_play,ting_url')->where('ting_reurl="'.$ting['ting_reurl'].'"')->find();
		if($array){
			return $this->xml_update($ting, $array, $mustup);
		}
		// 检测作品名称是否相等(需防止同名的作品)
		$array = $this->ffdb->field('ting_id,ting_name,ting_anchor,ting_inputer,ting_play,ting_url')->where('ting_name="'.$ting['ting_name'].'" ')->find();
		if($array){
			//无作者 或 演员完全相等时 更新该作品
			if(empty($ting['ting_anchor']) || ($array['ting_anchor'] == $ting['ting_anchor'])){
				return $this->xml_update($ting,$array,$mustup);
			}
			//有相同演员时更新该作品
			$arr_actor_1 = explode(',', gxl_xml_tingactor($ting['ting_anchor']));
			$arr_actor_2 = explode(',', gxl_xml_tingactor($array['ting_anchor']));
			if(array_intersect($arr_actor_1,$arr_actor_2)){
				return $this->xml_update($ting,$array,$mustup);
			}
		}
		//  相似条件判断
		if(C('play_collect_name')){
			$length = ceil(strlen($ting['ting_name'])/3) - intval(C('play_collect_name'));
			if($length > 1){
				$where = array();
				$where['ting_name'] = array('like',msubstr($ting['ting_name'],0,$length).'%');
				$array = $this->ffdb->field('ting_id,ting_name,ting_anchor,ting_title,ting_inputer,ting_play,ting_url')->where($where)->order('ting_id desc')->find();
				if($array){
					// 作者完全相同 则检查是否需要更新
					if(!empty($array['ting_anchor']) && !empty($ting['ting_anchor']) ){
						$arr_actor_1 = explode(',', gxl_xml_tingactor($ting['ting_anchor']));
						$arr_actor_2 = explode(',', gxl_xml_tingactor($array['ting_anchor']));
						if(!array_diff($arr_actor_1,$arr_actor_2) && !array_diff($arr_actor_2,$arr_actor_1)){//若差集为空
							return $this->xml_update($ting,$array,$mustup);
						}
					}
					// 不是同一资源库 则标识为相似待审核
					if(!in_array($ting['ting_inputer'],$array)){
						$ting['ting_status'] = -1;
					}
				}
			}
		}
		// 添加作品开始
		unset($ting['ting_id']);
		$img = D('Img');
		$ting['ting_pic'] = $img->down_load($ting['ting_pic']);
		$ting['ting_gold']    = mt_rand(1,C('rand_gold'));
		$ting['ting_golder']  = mt_rand(1,C('rand_golder'));
		$ting['ting_up']      = mt_rand(1,C('rand_updown'));
		$ting['ting_down']    = mt_rand(1,C('rand_updown'));
		$ting['ting_hits']    = mt_rand(0,C('rand_hits'));
		$ting['ting_letter'] = gxl_letter_first($ting['ting_name']);
		// 随机伪原创
		if(C('play_collect')){
			$ting['ting_content'] = gxl_rand_str($ting['ting_content']);
		}		
		$ting['ting_stars'] = 1;
		$ting['ting_addtime'] = time();
		$id = $this->ffdb->data($ting)->add();
		// 增加关联tag
		if( $ting['ting_keywords'] ){
			$data = array();
			$data['tag_id'] = $id;
			$data['tag_sid'] = 1;
			$rstag = M("Tag");
			$rstag->where($data)->delete();
			$tags = array_unique(explode(',',trim($ting['ting_keywords'])));
			foreach($tags as $key=>$val){
				$data['tag_name'] = $val;
				$rstag->data($data)->add();
			}
		}
		// 关联写入
		if($id){
			return '添加成功('.$id.')。';
		}
		return '添加失败。';
    }	
	// 更新数据
	public function xml_update($ting, $ting_old, $mustup=false){	
		// 检测是否站长手动锁定更新
		if('ppting' == $ting_old['ting_inputer']){
			return '站长手动设置，不更新。';
		}
		// 是否为强制更新资料图片等参数
		$edit = array();
		if( $mustup ){
			$img = D('Img');
			$edit['ting_pic'] = $img->down_load($ting['ting_pic']);
			$edit['ting_anchor'] = $ting['ting_anchor'];
			$edit['ting_author'] = $ting['ting_author'];
			$edit['ting_language'] = $ting['ting_language'];
		}else{
			//if($ting['ting_title']){ $edit['ting_title'] = $ting['ting_title']; }
		
			if($ting['ting_language']){ $edit['ting_language'] = $ting['ting_language']; }
		}
		// 分解原服务器组
		$array_play_old = explode('$$$', $ting_old['ting_play']);
		$play_key = array_search($ting['ting_play'], $array_play_old);
		// 检测是否已存在相同播放器组的播放地址
		if($play_key !== false){
			$array_url_old = explode('$$$',$ting_old['ting_url']);
			$ting_old['ting_url_key_old'] = $array_url_old[$play_key];
			$ting_old['ting_url_key_new'] = $this->xml_update_urlone($ting_old['ting_url_key_old'], $ting['ting_url']);
			// 检测当组的新播放地址与原数据库里的是否相同
			if($ting_old['ting_url_key_old'] == $ting_old['ting_url_key_new']){
				return strtoupper($ting['ting_play']).' 对应的地址未变化，不更新。';
			}else{
				$array_url_old[$play_key] = $ting_old['ting_url_key_new'];
				$edit['ting_url'] = implode('$$$',$array_url_old);
				$edit['ting_update_info'] = strtoupper($ting['ting_play']).' 对应更新。';
			}
		}else{
			$edit['ting_play'] = $ting_old['ting_play'].'$$$'.$ting['ting_play'];
			$edit['ting_url'] = trim($ting_old['ting_url']).'$$$'.$ting['ting_url'];
			$edit['ting_update_info'] = strtoupper($ting['ting_play']).' 新添加地址。';			
		}
		// 组合更新条件及内容(以最后一次更新的库为检测依据)
		$edit['ting_id'] = $ting_old['ting_id'];
		$edit['ting_name'] = $ting['ting_name'];
		$edit['ting_continu'] = $ting['ting_continu'];	
		$edit['ting_inputer'] = $ting['ting_inputer'];
		$edit['ting_reurl'] = $ting['ting_reurl'];
		$edit['ting_addtime'] = time();
		$this->ffdb->data($edit)->save();
		//删除数据缓存
		if(C('data_cache_ting')){
			S('data_cache_ting_'.$ting_old['ting_id'],NULL);
		}			
		return $edit['ting_update_info'];
	}	
	// 重生成某一组的播放地址 返回新的地址(string)
	public function xml_update_urlone($tingurlold, $tingurlnew){
		$arrayold = explode(chr(13),trim($tingurlold));
		$arraynew = explode(chr(13),trim($tingurlnew));
		foreach($arraynew as $key=>$value){
			unset($arrayold[$key]);
		}
		if($arrayold){
			return implode(chr(13),array_merge($arraynew,$arrayold));
		}else{
			return implode(chr(13),$arraynew);
		}
	}					
}
?>