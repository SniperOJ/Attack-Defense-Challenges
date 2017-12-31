<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<base target="_blank">
<title>{$sitename}</title>
<meta name="keywords" content="{$keywords}">
<meta name="description" content="{$description}">
<include file="gxlcms:include" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<include file="gxlcms:header" />
<!-- 
<div class="banner-layout">
  <div class="banner-wrap">
    <div class="banner-slider">
      <div class="banner">
        <volist name="list_slide" id="gxlting" offset="0" length='9'>
        <div class="banner-b-img" 
        <neq name="i" value="1">style="display: none"</neq>
        ><a href="<notempty name="gxlting.ting_url">{$gxlting.ting_url}
        <else />
        {$gxlting.slide_url}
        </notempty>
        " style="background-image: url({$gxlting.slide_pic})" target="_blank"></a></div>
      </volist>
    </div>
  </div>
  <div class="banner-smile">
    <volist name="list_slide" id="gxlting" offset="0" length='9'> <a href="<notempty name="gxlting.ting_url">{$gxlting.ting_url}
      <else />
      {$gxlting.slide_url}
      </notempty>
      "
      <eq name="i" value="1">class="onn"</eq>
      target="_blank"><img src="{$gxlting.slide_logo|getpicurl}" alt="<notempty name="gxlting.ting_name">{$gxlting.ting_name}
      <else />
      {$gxlting.slide_name}
      </notempty>
      "></a> </volist>
  </div>
  <div class="banner-s-tit">
    <volist name="list_slide" id="gxlting" offset="0" length='9'>
    <div class="banner-s-t" 
    <eq name="i" value="1">style="display: block"</eq>
    >
    <p class="name">
      <notempty name="gxlting.ting_name">{$gxlting.ting_name}
        <else />
        {$gxlting.slide_name}</notempty>
    </p>
    <p class="desc">
      <notempty name="gxlting.slide_content">{$gxlting.slide_content|msubstr=0,20,'...'}
        <else />
        {$gxlting.ting_content|msubstr=0,20,'...'}</notempty>
    </p>
  </div>
  </volist>
</div>
</div>
</div>
-->
<div class="content-box fn-clear">
  <div class="content-box-sf">
    <div class="box-model hot-layout">
      <div class="box-model-tit fn-clear">
        <h2>{:getlistname(2,'list_name')}</h2>
        <div class="box-model-nav" id="J-film-nav"> <a href="javascript:;" class="on">热听</a>
          <volist name="array_listmovid" id="gxl_listid" offset="0" length='7'> <a href="javascript:;">{$gxl_listid['list_name']|msubstr=0,2}</a> </volist>
        </div>
        <div class="box-model-more"><a href="{:getlistname(2,'list_url')}" target="_blank">更多<i class="iconfont">&#xe60b;</i></a></div>
      </div>
      <div id="J-film-con">
        <php>$index_movie =gxl_sql_ting('cid:2;field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime;limit:4;order:ting_addtime desc');</php>
        <div class="box-model-cont fn-clear" style="display: block">
          <volist name="index_movie" id="ppting"> <a href="{$ppting.ting_readurl}" title="{$ppting.ting_name}" 
            <in name="i" value="1,6">class="first"</in>
            target="_blank"> <span class="box-img"> <img class="loading" src="{$apicss}v256/images/pic.png" data-original="{$ppting.ting_picurl}"  alt="{$ppting.ting_name}"> <i class="box-img-bg"></i> <em><i class="box-fs">{$ppting.ting_gold}</i>分</em> <i class="box-img-h-bg"></i> <i class="box-img-play"></i> </span> <span class="box-tc"> <em class="box-tc-t">{$ppting.ting_name}</em> <em class="box-tc-c">{$ppting.ting_anchor}</em> </span> </a> </volist>
        </div>
        <volist name="array_listmovid" id="gxl_listid" offset="0" length='7'>
          <php>$index_mov =gxl_sql_ting('cid:'.$gxl_listid['list_id'].';field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime;limit:4;order:ting_addtime desc');</php>
          <div class="box-model-cont fn-clear">
            <volist name="index_mov " id="ppting"> <a href="{$ppting.ting_readurl}" title="{$ppting.ting_name}" 
              <in name="i" value="1,6">class="first"</in>
              target="_blank"> <span class="box-img"> <img src="{$apicss}v256/images/pic.png" class="lazy" data-original="{$ppting.ting_picurl}" alt="{$ppting.ting_name}"> <i class="box-img-bg"></i> <em><i class="box-fs">{$ppting.ting_gold}</i>分</em> <i class="box-img-h-bg"></i> <i class="box-img-play"></i> </span> <span class="box-tc"> <em class="box-tc-t">{$ppting.ting_name}</em> <em class="box-tc-c">{$ppting.ting_anchor}</em> </span> </a> </volist>
          </div>
        </volist>
      </div>
                 
               

    </div>
  </div>
  <div class="content-box-r">
    <div class="rebobang">
      <div class="rebo-tit fn-clear">
        <h3>热播榜</h3>
        <div class="rebo-nav" id="J-film-rb-nav">
          <volist name="array_listmovid" id="gxl_listid" offset="0" length='3'> <a href="javascript:;" 
            <eq name="i" value="1">class="on"</eq>
            >{$gxl_listid['list_name']|msubstr=0,2}</a> </volist>
        </div>
      </div>
      <div class="rebo-con" id="J-film-rb-con">
        <volist name="array_listmovid" id="gxl_listid" offset="0" length='3'>
        <php>$index_movie_hist =gxl_sql_ting('cid:'.$gxl_listid['list_id'].';field:ting_id,ting_cid,ting_name,ting_author,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_hits,ting_addtime;limit:7;order:ting_addtime desc');</php>
        <div class="film-list" 
        <eq name="i" value="1">style="display: block"</eq>
        >
        <volist name="index_movie_hist" id="ppting" offset="0" length='1'>
          <dl class="fn-clear">
            <dt><a href="{$ppting.ting_readurl}" target="_blank"><img src="{$ppting.ting_picurl}"><i></i><span>{$ppting.ting_hits}</span></a></dt>
            <dd>
              <h3><a href="{$ppting.ting_readurl}" target="_blank" title="{$ppting.ting_name}">{$ppting.ting_name|msubstr=0,8}{$i}</a></h3>
              <p class="fn-clear"><em>作者:</em><span>{$ppting.ting_author}</span></p>
              <p class="film-zy fn-clear"><em>主播:</em><span>{$ppting.ting_anchor}</span></p>
              <p class="fn-clear"><em>评分:</em><span><i>{$ppting.ting_gold}</i>分</span></p>
            </dd>
          </dl>
        </volist>
        <div class="film-model-list fn-clear">
          <volist name="index_movie_hist" id="ppting" offset="1" length='3'> <a href="{$ppting.ting_readurl}" title="{$ppting.ting_name}" 
            <in name="i" value="3,6">class="mr0"</in>
            target="_blank"> <span class="film-img"> <img src="{$ppting.ting_picurl}" alt="{$ppting.ting_name}"> <i></i> <em>{$ppting.ting_hits}</em> </span> <span class="film-tit">{$ppting.ting_name}</span> </a> </volist>
        </div>
      </div>
      </volist>
    </div>
  </div>
  
</div>
</div>
<div class="content-box fn-clear">
  <div class="content-box-sf">
    <div class="box-model hot-layout">
      <div class="box-model-tit fn-clear">
        <h2>{:getlistname(15,'list_name')}</h2>
        <div class="box-model-nav" id="J-zy-nav"> <a href="javascript:;" class="on">推荐</a>
          <volist name="catzylist" id="vo" offset="0" length='3'> <a href="javascript:;">{$vo.m_name}</a> </volist>
        </div>
        <div class="box-model-more"><a href="{:getlistname(15,'list_url')}" target="_blank">更多<i class="iconfont">&#xe60b;</i></a></div>
      </div>
      <div id="J-zy-con">
        <php>$index_zy =gxl_sql_ting('cid:15;field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime;limit:5;order:ting_addtime desc');</php>
        <div class="hot-wrap zy-hover fn-clear" style="display: block">
          <ul class="fn-clear">
            <volist name="index_zy" id="ppting" offset="0" length="1">
              <li class="hot-list hot-box-375x260"> <a href="{$ppting.ting_readurl}" title="{$ppting.ting_name}" class="hot-bg-icon" target="_blank"> <img class="loading" src="{$apicss}v256/images/pic.png" data-original="{$ppting.ting_picurl}"  alt="{$ppting.ting_name}"> <span class="hot-zy-span fn-clear"> <em class="play-bg"><i class="iconfont">&#xe611;</i></em> <span> <em>{$ppting.ting_name}</em> <em>
                <if condition="$ppting.ting_continu neq 0">第{$ppting.ting_continu}集
                  <else/>
                  {$ppting.ting_title}</if>
                </em> </span> </span> <i class="hot-zy-bg"></i> </a> </li>
            </volist>
            <volist name="index_zy" id="ppting" offset="1" length="12">
            <eq name="i" value="7">
          </ul>
          <ul class="hot-zy fn-clear">
            </eq>
            <li class="hot-list hot-box-cj180x100 <eq name="i" value="7">hot-zy-first
              </eq>
              "> <a  href="{$ppting.ting_readurl}" title="{$ppting.ting_name}" class="hot-bg-icon" target="_blank"><img src="{$ppting.ting_picurl}"  alt="{$ppting.ting_name}" /></a>
              <p class="hot-t">{$ppting.ting_name}</p>
            </li>
            </volist>
          </ul>
        </div>
        <volist name="catzylist" id="vo" offset="0" length='3'>
          <php>$index_zy_mcid =gxl_sql_ting('cid:15;mcid:'.$vo['m_cid'].';field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime;limit:5;order:ting_addtime desc');</php>
          <div class="hot-wrap zy-hover fn-clear">
            <ul class="fn-clear">
              <volist name="index_zy_mcid" id="ppting" offset="0" length="1">
                <li class="hot-list hot-box-375x260"> <a href="{$ppting.ting_readurl}" title="{$ppting.ting_name}" class="hot-bg-icon" target="_blank"> <img src="{$apicss}v256/images/pic.png" class="lazy" data-original="{$ppting.ting_picurl}" alt="{$ppting.ting_name}"> <span class="hot-zy-span fn-clear"> <em class="play-bg"><i class="iconfont">&#xe611;</i></em> <span> <em>{$ppting.ting_name}</em> <em>
                  <if condition="$ppting.ting_continu neq 0">第{$ppting.ting_continu}集
                    <else/>
                    {$ppting.ting_title}</if>
                  </em> </span> </span> <i class="hot-zy-bg"></i> </a> </li>
              </volist>
              <volist name="index_zy_mcid" id="ppting" offset="1" length="4">
              <eq name="i" value="7">
            </ul>
            <ul class="hot-zy fn-clear">
              </eq>
              <li class="hot-list hot-box-cj180x100 <eq name="i" value="7">hot-zy-first
                </eq>
                "> <a href="{$ppting.ting_readurl}" title="{$ppting.ting_name}" class="hot-bg-icon" target="_blank"><img src="{$apicss}v256/images/pic.png" class="lazy" data-original="{$ppting.ting_picurl}" alt="{$ppting.ting_name}" /></a>
                <p class="hot-t">{$ppting.ting_name}</p>
              </li>
              </volist>
            </ul>
          </div>
        </volist>
      </div>
    </div>
  </div>
  <div class="content-box-r">
    <div class="rebobang">
      <div class="rebo-tit fn-clear">
        <h3>{:getlistname(15,'list_name')}</h3>
      </div>
      <div class="zongyi-layout">
        <ul>
          <php>$index_zy_hits=gxl_sql_ting('cid:15;field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime,ting_hits;limit:8;order:ting_hits desc');</php>
          <volist name="index_zy_hits" id="ppting">
            <li class="fn-clear"> <em 
              <elt name="i" value="3">class="fst"</elt>
              >{$i}</em> <a href="{$ppting.ting_readurl}"  title="{$ppting.ting_name}" target="_blank">{$ppting.ting_name}</a> <span><i>{$ppting.ting_hits}</i>人</span> </li>
          </volist>
        </ul>
      </div>
    </div>

  </div>
</div>
<php>$tv_new=gxl_sql_ting('cid:16;field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime,ting_hits;limit:8;order:ting_hits desc');</php>
<div class="content-box fn-clear">
        <div class="box-model hot-layout">
            <div class="box-model-tit fn-clear">
                <h3>最近更新</h3>
                <div class="box-model-nav" id="J-neidi-nav">
                <volist name="tv_new" id="gxlting" offset="5" length='10'> 
                    <a href="{$gxlting.ting_readurl}" target="_blank">{$gxlting.ting_name}</a></volist> 
                    </div>
                <div class="box-model-more"><a href="{:gxl_mytpl_url('my_new.html')}">更多<i class="iconfont">&#xe60b;</i></a></div>
            </div>
            <div class="hot-wrap zy-hover fn-clear" style="display: block">
                <ul class="fn-clear">
                <volist name="tv_new" id="gxlting" offset="0" length='1'> 
                    <li class="hot-list hot-box-400x300">
                            <a href="{$gxlting.ting_readurl}" title="{$gxlting.ting_name}" target="_blank" class="hot-bg-icon">
                                <img class="loading" src="{$apicss}v256/images/pic.png" data-original="{$gxlting.ting_picurl}"  alt="{$gxlting.ting_name}" />
                                <span class="hot-zy-span fn-clear">
                                    <em class="play-bg"><i class="iconfont">&#xe611;</i></em>
                                    <span>
                                        <em>{$gxlting.ting_name}</em>
                                        <em>{$gxlting.ting_content|msubstr=0,20,'...'}</em>
                                    </span>
                                </span>
                                <i class="hot-zy-bg"></i>
                            </a>
                            
                        </li>  
                        </volist>  
                        <volist name="tv_new" id="gxlting" offset="1" length='4'>                     
                             
                             <li class="hot-list hot-box-190x300">
                            <a href="{$gxlting.ting_readurl}" target="_blank" title="{$gxlting.ting_name}" class="first">
                                <span class="box-img">
                                    <img class="loading" src="{$apicss}v256/images/pic.png" data-original="{$gxlting.ting_picurl}"  alt="{$gxlting.ting_name}"/>
                                    <i class="box-img-h-bg"></i>
                                    <i class="box-img-play"></i>
                                </span>
                                <span class="box-tc">
                                    <em class="box-tc-t">{$gxlting.ting_name}</em>
                                    <em class="box-tc-c">{$gxlting.ting_actor|msubstr=0,15,'...'}</em>
                                </span>
                            </a>
                        </li>                 
                        </volist>
                        
                </ul>
            </div>
            
        </div>
        
    </div>
	
	
<php>$array_listidd = getlistall(2);</php>
<volist name="array_listidd" id="gxl_listid" key="k" offset="0" length='7'>  
<div class="content-box fn-clear">
    <div class="box-model hot-layout">
        <div class="box-model-tit fn-clear">
            <h3>{$gxl_listid.list_name}</h3>
            <div class="box-model-more"><a href="{$gxl_listid.list_url}">更多<i class="iconfont">&#xe60b;</i></a></div>
        </div>
        <div id="J-neidi-con" class="film-model-layout">
            <div class="box-model-cont fn-clear" style="display: block">
            <php>$mov_list = gxl_sql_ting('cid:'.$gxl_listid['list_id'].';field:ting_id,ting_cid,ting_name,ting_pic,ting_title,ting_gold;limit:6;order:ting_addtime desc');</php>  
             <fflist name="mov_list" id="ppting">
                <a href="{$ppting.ting_readurl}" title="{$ppting.ting_name}" <in name="i" value="1">class="first"</in>target="_blank">
                        <span class="box-img">
                            <img class="loading" src="{$apicss}v256/images/pic.png" data-original="{$ppting.ting_picurl}"  alt="{$ppting.ting_name}" />
                            <i class="box-img-h-bg"></i>
                            <i class="box-img-play"></i>
                        </span>
                        <span class="box-tc">
                            <em class="box-tc-t">{$ppting.ting_name}</em>
                            <em class="box-tc-c">{$ppting.ting_actor}</em>
                            <em class="box-tc-f">{$ppting.ting_gold}</em>
                        </span>
                    </a>
               </fflist>                          
            </div>
        
        </div>
    </div>
</div>
 </volist> 
<div class="content-box fn-clear">
  <div class="box-model hot-layout">
    <div class="box-model-tit fn-clear">
      <h3>合作伙伴</h3>
      <div class="box-model-nav" id="J-hz-nav"> <a  class="on">媒体合作</a> <a >友情链接</a> </div>
    </div>
    <div class="friend-link" id="J-hz-con">
      <div class="fl-model fl-friend fn-clear" style="display: block">
	  
	  
	   <volist name="list_link" id="ppting">  <eq name="ppting.link_type" value="2"><span><a href="{$ppting.link_url}" target="_blank"><img src="{$ppting.link_logo}" alt="{$ppting.link_name}友情链接"></a></span></eq></volist>
	  
	  </div>
      <div class="fl-model fl-link fn-clear" >
        <volist name="list_link" id="ppting">  <eq name="ppting.link_type" value="1"><span><a href="{$ppting.link_url}" target="_blank">{$ppting.link_name}</a></span></eq></volist>
      </div>
    </div>
  </div>
</div>
<include file="gxlcms:footer" />
<script>v256.index.init();v256.film.init();</script>
</body>
</html>
