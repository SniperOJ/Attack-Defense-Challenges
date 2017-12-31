<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$ting_name}</title>
<meta name="keywords" content="{$ting_skeywords}">
<meta name="description" content="{$ting_sdescription|h|msubstr=0,100}...">       
<include file="gxlcms:include" />  
<link rel="stylesheet" href="/v256/tingcss/smusic.css"/>   
</head>
<body>
<include file="gxlcms:header" />

<div class="film-detail-layout fn-clear"> 
                <div class="film-detail-img">
                    <a href="{$ting_readurl}" class="play_btn" rel="nofollow" target="_blank"> <img src="{$ting_picurl}" alt="{$ting_name}" /><if condition="($list_pid eq $tv_id) OR ($list_id eq $zy_id) OR ($list_id eq $dm_id)"><neq name="ppting.ting_continu" value="0"><i class="updating"></i></neq></if><span class="hide-bg"></span><span class="hide-btn hover"></span>
                    </a>
                </div>
                <input type='hidden' name='_void_id' id='_void_id' value='{$ting_id}'/>
                <div class="film-detail-con">
        
       
                    <i class="film-detail-icon"></i>
                    <div class="fd-box">
                        <div class="fd-box-t fn-clear">
                            <h1>{$ting_name}</h1>
                               <neq name="ting_continu" value="0">
<notempty name="ji">
<div class="ting_z">更新至<font color="#FF3300">{$ji}</font><eq name="list_id" value="$zy_id">期<else/>集</eq><notempty name="ting_total">&nbsp;&nbsp;|&nbsp;&nbsp;共<php>echo preg_replace('/\D/s', '', $ting_total);</php>集</notempty></div></notempty>
</neq>

                        </div>

                    
                          <p class="fd-list">
                         
                            <span>作者：{$ting_author}</span>
                        </p>
                          <p class="fd-list">
                            <span> 主播：{$ting_anchor}</span>
                        </p>

                             <div class="update-last-time">
                     <div id="detail-rating" class="fn-left">
		  <div id="detail-rating" class="fn-clear">
          <div id="rating" class="fn-left"><span class="label">给影片评分：</span>
            <ul class="rating">
              <li class="one current" title="很差" val="1">很差</li>
              <li class="two current" title="较差" val="2">较差</li>
              <li class="three current" title="还行" val="3">还行</li>
              <li class="four" title="推荐" val="4">推荐</li>
              <li class="five" title="力荐" val="5">力荐</li>
            </ul>
            <span id="ratewords">还行</span></div>
        </div>
			</div>
             <div class="ting-info ui-boxb" id="detail-box">
	  <div class="rating-box" id="rating-main" style="display: block;"><div class="rating-total fn-clear"><label class="rating-total-item" id="total">&nbsp;</label><div class="pingfen-total"><strong id="pingfen"></strong><em id="pingfen2"></em></div></div><div class="rating-panle"><div class="rating-bar"><div class="rating-bar-item" id="fenshu">&nbsp;</div></div><ul class="rating-show"><li><span title="力荐" class="starstop star5">力荐</span><div class="power"><div class="power-item" id="pam"></div></div><em id="pa">人</em></li><li><span title="推荐" class="starstop star4">推荐</span><div class="power"><div class="power-item" id="pbm"></div></div><em id="pb">人</em></li><li><span title="还行" class="starstop star3">还行</span><div class="power"><div class="power-item" id="pcm"></div></div><em id="pc">人</em></li><li><span title="较差" class="starstop star2">较差</span><div class="power"><div class="power-item" id="pdm"></div></div><em id="pd">人</em></li><li><span title="很差" class="starstop star1">很差</span><div class="power"><div class="power-item" id="pem"></div></div><em id="pe">人</em></li></ul></div></div>
	  <div class="rating-box" id="rating-kong" style="display: none;"><div class="rating-kong-item"><span class="loadingg">评分加载中...</span></div></div></div>  
                    </div><!--update-last-time-->       
                        <p class="fd-list ting-jj"><span>介绍：{:strip_tags($ting_content)}</span></p>
                                           
<!--                        <div class="fd-play-box fn-clear">
                            <div id="ad7" class="fn-left"></div>
                        </div>-->
            </div>
        </div>
 </div>
   <div class="grid-music-container f-usn">
    <div class="m-music-play-wrap">
        <div class="u-cover"></div>
        <div class="m-now-info">
            <h1 class="u-music-title"><strong>{$ting_name}</strong><small>主播</small></h1>
            <div class="m-now-controls">
                <div class="u-control u-process">
                    <span class="buffer-process"></span>
                    <span class="current-process"></span>
                </div>
                <div class="u-control u-time">00:00/00:00</div>
                <div class="u-control u-volume">
                    <div class="volume-process" data-volume="0.50">
                        <span class="volume-current"></span>
                        <span class="volume-bar"></span>
                        <span class="volume-event"></span>
                    </div>
                    <a class="volume-control"></a>
                </div>
            </div>
            <div class="m-play-controls">
                <a class="u-play-btn prev" title="上一曲"></a>
                <a class="u-play-btn ctrl-play play" title="暂停"></a>
                <a class="u-play-btn next" title="下一曲"></a>
                <a class="u-play-btn mode mode-list current" title="列表循环"></a>
                <a class="u-play-btn mode mode-random" title="随机播放"></a>
                <a class="u-play-btn mode mode-single" title="单曲循环"></a>
            </div>
        </div>
    </div>
    <div class="f-cb">&nbsp;</div>
    <div class="m-music-list-wrap"></div>
</div>





<script src="/v256/tingjs/smusic.min.js"></script>
<script>
var musicList = [
<volist name="playson" id="pptingson" key="i" offset="$ting_pid-1" length='20'>
	{
		title : '{$pptingson.playname}',
		singer : '主播：{$ting_anchor}',
		cover  : '{$ting_picurl}',
		src    : '{$pptingson.playpath}'
	}<neq name="i" value="20">,</neq>
	</volist>
];
new SMusic({
	musicList:musicList
});
</script>
<include file="gxlcms:footer" />
</body>
</html>