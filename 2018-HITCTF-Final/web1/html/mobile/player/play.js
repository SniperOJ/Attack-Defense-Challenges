//全局
var zzid=0;
var playerw='100%';//播放器宽度
var playerh='250';//播放器高度
var skinColor='d3e3f3,999999|d1d3a2,3300FF|94d2e2,000000|000000,000000|c9abca,000000';//是否默认自动播放
var adsPage="";//视频播放前广告页路径
var adsTime=1;//视频播放前广告时间，单位秒
var alertwin='0';//是否弹窗播放
var alertwinw='720';//弹窗宽度
var alertwinh='530';//弹窗高度
//数组加载
window.onload = function () {
var videolist = VideoInfoList.split("$$");
var all = VideoInfoList.split("$$$");
var pn_num = paras[1];
var cji = paras[2];
var pn=all[pn_num];
var pn=pn.split("$$");
var now3=pn;
var pn=pn[1];
var pn=pn.split("$");
var pn=pn[2];
var pn=pn.split("#");
var pn=pn[0];
//alert(now3);
getPlay(cji,now3,pn,videolist);
}

function getPlay(cji,now1,pn,videolist) {
	 var cji=parseInt(cji);
	 var now3=now1;
	 var now2=now1;
	 var now3 = now3.join("");
	 var now2 = now2.join("");
	 var now3 = now3.split("#");
	 var now2 = now2.split("#");
	 var jishu= now3.length;
	 var now3 = now3[cji];
	 var now2 = now2[cji+1];
     var now4 = now3.split("$");
	 now = now4[1];
	 pn = now4[2];
var ssurl =window.location.href;
setTimeout(appendFrm(pn),1000);
}
//调用来源
function appendFrm(pn) {
    var pn=pn;
	document.getElementById("cciframe").width = playerw;
	document.getElementById("cciframe").height = playerh;
    document.getElementById("cciframe").src = '/player/html/'+ pn + '.html';
}
//首尾提示
function video_jump(flag){
	var f = 0;
	var video_len = video_level_2[video_url_group].length -1;	
	var video_current = video_url_index + flag; 
	
	if(flag == -1 && video_current < 0){
		alert('已经是第一集啦!');
		return false;
	}else if(flag == 1 && video_len < video_current){
		alert('已经是最后一集啦!');
		return false;
	}else{
		window.location.href = video_url_path + video_url_id + '-'+ video_url_group + '-' + video_current + '.' + video_url_type;	
	}
}