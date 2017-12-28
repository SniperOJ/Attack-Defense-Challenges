<?php
namespace Org\Net;
class VideoCaiji{
	public function getUrl($url){
		if(!$url){
			exit;
		}
		if(strpos($url,'youku.com') || strpos($url,'_wd1')){
			return $this->getYouku($url);
		}
		elseif(strpos($url,'tudou.com') || strpos($url,'_wd2')){
			return $this->gettudou($url);
		}
		elseif(strpos($url,'letv.com') || strpos($url,'_wd3')){
			return $this->getletv($url);
		}
		elseif(strpos($url,'56.com') || strpos($url,'_wd4')){
			return $this->get56($url);
		}
		elseif(strpos($url,'ku6.com') || strpos($url,'_wd5')){
			return $this->getku6($url);
		}
		else{
			return $url;
			exit;
		}
	}

	function getku6($url){
		if(strpos($url,'html')){
			$arr=explode('/',$url);
			$wd=$arr[count($arr)-1];
			$wd=str_replace('.html','',$wd);
		}
		elseif(strpos($url,'swf')){
			$arr=explode('/',$url);
			$wd=$arr[count($arr)-2];
		}
		else{
			$wd=str_replace('_wd5','',$url);
		}
		$content2=$this->get_curl_contents('http://v.ku6.com/fetchVideo4Player/'.$wd.'.html');
		$data=json_decode($content2);
		$wd2=$data->data->f;
		$wd3=explode(',',$wd2);
		$wd4='';
		for($i=0;$i<count($wd3);$i++){
			if($wd4 == ''){
				$wd4 = $wd3[$i];
			}else{
				$wd4 .= "|".$wd3[$i];
			}
		}
		return $wd4;
	}
	function get56($url){
		if(strpos($url,'v_')){
			$wd=$this->inter($url,'v_','.');
		}
		else{
			$wd=str_replace('_wd4','',$url);
		}
		$content=$this->get_curl_contents('http://vxml.56.com/json/'.$wd.'/?src=out');
		$data=json_decode($content);
		$wd2=$data->info->rfiles;
		for($i==0;$i<count($wd2);$i++){
			$type=$wd2[$i]->type;
			if($type=='normal'){
				$wd3=$wd2[$i]->url;
				break;
			}
		}
		if(!$wd3){
			$wd3=$wd2[0]->url;
		}
		return $wd3;
	}
	function getletv($url){
		if(strpos($url,'swf')){
			$wd=$this->inter($url,'swf?id=','&');
			return $this->loadletvxml($wd);
		}
		elseif(strpos($url,'wd3')){
			return $this->loadletvxml(str_replace('_wd3','',$url));
		}
		else{
			return $this->loadletvurl($url);	
		}
	}
	function loadletvurl($url){
		$content=$this->get_curl_contents($url);
		$wd=$this->inter($content,'vid:',',');
		if($wd){
			return $this->loadletvxml($wd);
		}
	}
	function loadletvxml($url){
		$content=$this->get_curl_contents('http://app.letv.com/v.php?id='.$url);
		$wd3=$this->inter($content,'<mmsJson>','</mmsJson>');
		$wd3=$this->inter($wd3,'<![CDATA[',']]>');
		$data=json_decode($wd3);
		$wd4=$data->bean->video;
		$wd5=$wd4[0]->url;
		$content2=$this->get_curl_contents($wd5);
		$data2=json_decode($content2);
		$wd6=$data2->location;
		$wd6='http://'.$this->inter($wd6,'http://','.letv').'.'.$this->inter($wd6,'video_type=','&');
		return $wd6;
	}

	function gettudou($url){
		if(strpos($url,'swf')){
			$wd=$this->inter($url,'iid=','/');
			if(strpos($wd,'swf')){
				$wd=$this->inter($url,'iid=','&');
			}
			return $this->loadtudou($wd);
		}
		elseif(strpos($url,'_wd2')){
			return $this->loadtudou(str_replace('_wd2','',$url));
		}
		else{
			return $this->loadtudouurl($url);
		}
	}
	function loadtudou($url){
		$content=$this->get_curl_contents('http://v2.tudou.com/v?vn=02&st=1%2C2&it='.str_replace(' ','',$url));
		$wd=$this->inter($content,'brt="2">','<');

		return $wd;
	}
	function loadtudouurl($url){
		$content=$this->get_curl_contents($url);
		$wd=$this->inter($content,'vcode:"','"');
		if(!$wd){
			$wd=$this->inter($content,'vcode: \'','\'');	
		}
		if ($wd){
			return $this->getYouku($wd);
		}
		else{
			$wd=$this->inter($content,'iid:',',');
			return $this->loadtudou($wd);
		}
	}
	function getYouku($url){
		if(strpos($url,'html')){
			$url2=$this->inter($url,'id_','.html');
		}
		elseif(strpos($url,'swf')){
			$url2=$this->inter($url,'/sid/','/');
		}
		else{
			$url2=str_replace('_wd1','',$url);
		}
		$content=$this->get_curl_contents('http://v.youku.com/player/getPlayList/VideoIDS/'.$url2);
		$data=json_decode($content);
		$fileid_=$data->data[0]->streamfileids;
		
		if(isset($fileid_->hd2) && 0){
			$fileid2_=$fileid_->hd2;
			$sk='hd2';
		}else if(isset($fileid_->mp4)){
			$fileid2_=$fileid_->mp4;
			$sk='mp4';
		}else{
			$fileid2_=$fileid_->flv;
			$sk='flv';
		}
		$sid=$this->getSid();
		$fileid3_=$this->getfileid($fileid2_,$data->data[0]->seed);
		$filed1_=substr($fileid3_,0,8);
		$filed2_=substr($fileid3_,10);
		$segs=$data->data[0]->segs->$sk;
		$i=0;
		$urllist='';
		foreach($segs AS $seg1 => $v1){
			$AA= strtoupper(dechex($i)).'';
			if(strlen($AA)<2) $AA='0'.$AA;
			$filed_=$filed1_.$AA.$filed2_;
			$k1=$v1->k;
			$k2=$v1->k2;
			$size=$v1->size;
			$seconds=$v1->seconds;
			if($k1 == -1 || $k2 == -1){
				break;
			}
			if($urllist == ""){
				$urllist='http://f.youku.com/player/getFlvPath/sid/00_00/st/'.$sk.'/fileid/'.$filed_.'?K='.$k1.',k2='.$k2;
			}else{
				$urllist.='|http://f.youku.com/player/getFlvPath/sid/00_00/st/'.$sk.'/fileid/'.$filed_.'?K='.$k1.',k2='.$k2;
			}
			
			$i+=1;
		}

		return $urllist;
	}
	function numx($url,$g){
		$num=0;
		if($url && $g){
			$arr=explode($g,$url);
			$num=count($arr)-1;
		}
		return $num;
	}
	function inter($str,$start,$end){
		$wd2='';
		if($str && $start){
			$arr=explode($start,$str);
			if(count($arr)>1){
				$wd=$arr[1];
				if($end){
					$arr2=explode($end,$wd);
					if(count($arr2)>1){
						$wd2=$arr2[0];
					}
					else{
						$wd2=$wd;
					}
				}
				else{
					$wd2=$wd;
				}
			}
		}
		return $wd2;
	}

	function get_curl_contents($url,$bm='utf-8', $second = 5){
		if(!function_exists('curl_init')) die('php.ini未开启php_curl.dll');
		$c = curl_init();
		curl_setopt($c,CURLOPT_URL,$url);
		$UserAgent=$_SERVER['HTTP_USER_AGENT'];
		curl_setopt($c,CURLOPT_USERAGENT,$UserAgent);
		curl_setopt($c,CURLOPT_HEADER,0);
		curl_setopt($c,CURLOPT_TIMEOUT,$second);
		curl_setopt($c,CURLOPT_RETURNTRANSFER, true);
		$cnt = curl_exec($c);
		$cnt=mb_check_encoding($cnt,$bm)?iconv('gbk','utf-8//IGNORE',$cnt):$cnt; //字符编码转换
		curl_close($c);
		return $cnt;
	}

	//以下是解析优酷用到的
	function getSid() {
		$sid = time().(rand(0,9000)+10000);
		return $sid;
	}
	function getkey($key1,$key2){
		$a = hexdec($key1);
		$b = $a ^ 0xA55AA5A5;
		$b = dechex($b);
		return $key2.$b;
	}
	function getfileid($fileId,$seed) {
		$mixed = $this->getMixString($seed);
		$ids = explode("*",$fileId);
		unset($ids[count($ids)-1]);
		$realId = "";
		for ($i=0;$i < count($ids);++$i) {
		$idx = $ids[$i];
		$realId .= substr($mixed,$idx,1);
		}
		return $realId;
	}
	function getMixString($seed) {
		$mixed = "";
		$source = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/\\:._-1234567890";
		$len = strlen($source);
		for($i=0;$i< $len;++$i){
		$seed = ($seed * 211 + 30031) % 65536;
		$index = ($seed / 65536 * strlen($source));
		$c = substr($source,$index,1);
		$mixed .= $c;
		$source = str_replace($c, "",$source);
		}
		return $mixed;
	}
	//以上是解析优酷用到的
}

?> 