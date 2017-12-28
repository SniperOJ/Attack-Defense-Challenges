<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<base target="_blank">
<title><?php echo ($sitename); ?></title>
<meta name="keywords" content="<?php echo ($keywords); ?>">
<meta name="description" content="<?php echo ($description); ?>">
<script language="javascript"><!-- 
window.onerror=function(){return true;} 
// --></script>
<link href="<?php echo ($apicss); ?>v256/css/base.css" type="text/css" rel="stylesheet">  
<script type="text/javascript"> <?php if(!empty($mobile_status)): ?>var Siteurl='<?php echo rtrim($murl,'/');?>'; var Mvodurl='<?php echo rtrim($murl,'/'); echo ($thisurl); ?>'; <?php else: ?>var Siteurl='<?php echo ($siteurl); ?>'; var Mvodurl='<?php echo rtrim($siteurl,'/'); echo ($thisurl); ?>';<?php endif; ?> Root='<?php echo ($root); ?>';var Sid='<?php echo ($sid); ?>';var Cid='<?php echo ($list_id); ?>';<?php if($sid == 1): ?>var Id='<?php echo ($ting_id); ?>';<?php else: ?>var Id='<?php echo ($news_id); ?>';<?php endif; ?></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/scrollbar.js"></script>

<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/lazyload.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/v256.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/playclass.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/jquery.base.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/js.js"></script>
<?php if(!empty($mobile_status)): ?><link rel="canonical" href="<?php echo rtrim($siteurl,'/'); echo ($thisurl); ?>"/>
<meta name="mobile-agent" content="format=xhtml;url=<?php echo rtrim($murl,'/'); echo ($thisurl); ?>" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<script src="<?php echo ($apicss); ?>v256/js/uaredirectforpc.js" type="text/javascript"></script>
<script type="text/javascript">uaredirect("<?php echo rtrim($murl,'/'); echo ($thisurl); ?>");</script><?php endif; ?>
<?php $cattvlist = getlistmcat($tv_id); ?>
<?php $catmovlist = getlistmcat($mov_id); ?>
<?php $catdmlist = getlistmcat($dm_id); ?>
<?php $catzylist = getlistmcat($zy_id); ?>
<?php $catweilist = getlistmcat($wei_id); ?>
<?php $array_listtvid = getlistall($tv_id); ?>
<?php $array_listmovid = getlistall($mov_id); ?>

<?php $listarray = getlistmcat($list_id); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
                <div class="top-layout" id="J-fixtop">
            <div class="top-wrap fn-clear">
                <h1><a href="<?php echo ($siteurl); ?>"><?php echo ($sitename); ?></a></h1>  
                <div class="search-wrap">
                    <form method="post" action="<?php echo str_replace('-wd--p-1','',UU('Home-ting/search','',true,false));?>">
                        <div class="search-l">
                            <i class="iconfont">&#xe601;</i>
                            <input autocomplete="off" id="wd" name="wd" type="text" value="输入作品名或主播。" onfocus="if(this.value=='输入作品名或主播。'){this.value='';}" onblur="if(this.value==''){this.value='输入作品名或主播。';};" autocomplete="off" class="search-text1">
                        </div>
                        <input type="submit" value="搜 索" class="search-btn" id="btn"></form>
                            <div class="search-list">
      <div class="search-list-left fn-left">
        <ul class="search-list-ul" id="search-list-ul">

        </ul>
      </div>
      
      <div class="search-list-right fn-right">
        <div class="slr-inner" id="slr-inner">
        </div>
      </div>
    <div class="search-list-right"></div>
    </div><!--search-list-->
                </div>
               
            </div>
        </div>
        <div class="navgation-layout">
            <div class="navgation-wrap fn-clear">
                <div class="navgation-left">
                    <a href="<?php echo ($siteurl); ?>" <?php if(($list_id) == ""): if( $sid['sid'] > ''): else: ?>class="on"<?php endif; endif; ?>><i class="iconfont"></i><em>首页</em></a>
                    <?php if(is_array($list_menu)): $i = 0; $__LIST__ = $list_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppvod): $mod = ($i % 2 );++$i; if(($ppvod["list_pid"]) == "0"): ?><a href="<?php echo ($ppvod["list_url"]); ?>"  <?php if(($sid["sid"]) == "story"): else: if(($ppvod["list_id"]) == $list_id): ?>class="on"<?php endif; if(($ppvod["list_id"]) == $list_pid): ?>class="on"<?php endif; endif; ?>><i class="iconfont"></i><em><?php echo ($ppvod["list_name"]); ?></em></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                 </div>
               
            </div>
            <div class="navgation-shodw"></div>
        </div>
<!-- 
<div class="banner-layout">
  <div class="banner-wrap">
    <div class="banner-slider">
      <div class="banner">
        <?php if(is_array($list_slide)): $i = 0; $__LIST__ = array_slice($list_slide,0,9,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxlting): $mod = ($i % 2 );++$i;?><div class="banner-b-img" 
        <?php if(($i) != "1"): ?>style="display: none"<?php endif; ?>
        ><a href="<?php if(!empty($gxlting["ting_url"])): echo ($gxlting["ting_url"]); ?>
        <?php else: ?>
        <?php echo ($gxlting["slide_url"]); endif; ?>
        " style="background-image: url(<?php echo ($gxlting["slide_pic"]); ?>)" target="_blank"></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
  </div>
  <div class="banner-smile">
    <?php if(is_array($list_slide)): $i = 0; $__LIST__ = array_slice($list_slide,0,9,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxlting): $mod = ($i % 2 );++$i;?><a href="<?php if(!empty($gxlting["ting_url"])): echo ($gxlting["ting_url"]); ?>
      <?php else: ?>
      <?php echo ($gxlting["slide_url"]); endif; ?>
      "
      <?php if(($i) == "1"): ?>class="onn"<?php endif; ?>
      target="_blank"><img src="<?php echo (getpicurl($gxlting["slide_logo"])); ?>" alt="<?php if(!empty($gxlting["ting_name"])): echo ($gxlting["ting_name"]); ?>
      <?php else: ?>
      <?php echo ($gxlting["slide_name"]); endif; ?>
      "></a><?php endforeach; endif; else: echo "" ;endif; ?>
  </div>
  <div class="banner-s-tit">
    <?php if(is_array($list_slide)): $i = 0; $__LIST__ = array_slice($list_slide,0,9,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxlting): $mod = ($i % 2 );++$i;?><div class="banner-s-t" 
    <?php if(($i) == "1"): ?>style="display: block"<?php endif; ?>
    >
    <p class="name">
      <?php if(!empty($gxlting["ting_name"])): echo ($gxlting["ting_name"]); ?>
        <?php else: ?>
        <?php echo ($gxlting["slide_name"]); endif; ?>
    </p>
    <p class="desc">
      <?php if(!empty($gxlting["slide_content"])): echo (msubstr($gxlting["slide_content"],0,20,'...')); ?>
        <?php else: ?>
        <?php echo (msubstr($gxlting["ting_content"],0,20,'...')); endif; ?>
    </p>
  </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</div>
</div>
-->
<div class="content-box fn-clear">
  <div class="content-box-sf">
    <div class="box-model hot-layout">
      <div class="box-model-tit fn-clear">
        <h2><?php echo getlistname(2,'list_name');?></h2>
        <div class="box-model-nav" id="J-film-nav"> <a href="javascript:;" class="on">热听</a>
          <?php if(is_array($array_listmovid)): $i = 0; $__LIST__ = array_slice($array_listmovid,0,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxl_listid): $mod = ($i % 2 );++$i;?><a href="javascript:;"><?php echo (msubstr($gxl_listid['list_name'],0,2)); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="box-model-more"><a href="<?php echo getlistname(2,'list_url');?>" target="_blank">更多<i class="iconfont">&#xe60b;</i></a></div>
      </div>
      <div id="J-film-con">
        <?php $index_movie =gxl_sql_ting('cid:2;field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime;limit:4;order:ting_addtime desc'); ?>
        <div class="box-model-cont fn-clear" style="display: block">
          <?php if(is_array($index_movie)): $i = 0; $__LIST__ = $index_movie;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><a href="<?php echo ($ppting["ting_readurl"]); ?>" title="<?php echo ($ppting["ting_name"]); ?>" 
            <?php if(in_array(($i), explode(',',"1,6"))): ?>class="first"<?php endif; ?>
            target="_blank"> <span class="box-img"> <img class="loading" src="<?php echo ($apicss); ?>v256/images/pic.png" data-original="<?php echo ($ppting["ting_picurl"]); ?>"  alt="<?php echo ($ppting["ting_name"]); ?>"> <i class="box-img-bg"></i> <em><i class="box-fs"><?php echo ($ppting["ting_gold"]); ?></i>分</em> <i class="box-img-h-bg"></i> <i class="box-img-play"></i> </span> <span class="box-tc"> <em class="box-tc-t"><?php echo ($ppting["ting_name"]); ?></em> <em class="box-tc-c"><?php echo ($ppting["ting_anchor"]); ?></em> </span> </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <?php if(is_array($array_listmovid)): $i = 0; $__LIST__ = array_slice($array_listmovid,0,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxl_listid): $mod = ($i % 2 );++$i; $index_mov =gxl_sql_ting('cid:'.$gxl_listid['list_id'].';field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime;limit:4;order:ting_addtime desc'); ?>
          <div class="box-model-cont fn-clear">
            <?php if(is_array($index_mov )): $i = 0; $__LIST__ = $index_mov ;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><a href="<?php echo ($ppting["ting_readurl"]); ?>" title="<?php echo ($ppting["ting_name"]); ?>" 
              <?php if(in_array(($i), explode(',',"1,6"))): ?>class="first"<?php endif; ?>
              target="_blank"> <span class="box-img"> <img src="<?php echo ($apicss); ?>v256/images/pic.png" class="lazy" data-original="<?php echo ($ppting["ting_picurl"]); ?>" alt="<?php echo ($ppting["ting_name"]); ?>"> <i class="box-img-bg"></i> <em><i class="box-fs"><?php echo ($ppting["ting_gold"]); ?></i>分</em> <i class="box-img-h-bg"></i> <i class="box-img-play"></i> </span> <span class="box-tc"> <em class="box-tc-t"><?php echo ($ppting["ting_name"]); ?></em> <em class="box-tc-c"><?php echo ($ppting["ting_anchor"]); ?></em> </span> </a><?php endforeach; endif; else: echo "" ;endif; ?>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
                 
               

    </div>
  </div>
  <div class="content-box-r">
    <div class="rebobang">
      <div class="rebo-tit fn-clear">
        <h3>热播榜</h3>
        <div class="rebo-nav" id="J-film-rb-nav">
          <?php if(is_array($array_listmovid)): $i = 0; $__LIST__ = array_slice($array_listmovid,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxl_listid): $mod = ($i % 2 );++$i;?><a href="javascript:;" 
            <?php if(($i) == "1"): ?>class="on"<?php endif; ?>
            ><?php echo (msubstr($gxl_listid['list_name'],0,2)); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
      </div>
      <div class="rebo-con" id="J-film-rb-con">
        <?php if(is_array($array_listmovid)): $i = 0; $__LIST__ = array_slice($array_listmovid,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxl_listid): $mod = ($i % 2 );++$i; $index_movie_hist =gxl_sql_ting('cid:'.$gxl_listid['list_id'].';field:ting_id,ting_cid,ting_name,ting_author,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_hits,ting_addtime;limit:7;order:ting_addtime desc'); ?>
        <div class="film-list" 
        <?php if(($i) == "1"): ?>style="display: block"<?php endif; ?>
        >
        <?php if(is_array($index_movie_hist)): $i = 0; $__LIST__ = array_slice($index_movie_hist,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><dl class="fn-clear">
            <dt><a href="<?php echo ($ppting["ting_readurl"]); ?>" target="_blank"><img src="<?php echo ($ppting["ting_picurl"]); ?>"><i></i><span><?php echo ($ppting["ting_hits"]); ?></span></a></dt>
            <dd>
              <h3><a href="<?php echo ($ppting["ting_readurl"]); ?>" target="_blank" title="<?php echo ($ppting["ting_name"]); ?>"><?php echo (msubstr($ppting["ting_name"],0,8)); echo ($i); ?></a></h3>
              <p class="fn-clear"><em>作者:</em><span><?php echo ($ppting["ting_author"]); ?></span></p>
              <p class="film-zy fn-clear"><em>主播:</em><span><?php echo ($ppting["ting_anchor"]); ?></span></p>
              <p class="fn-clear"><em>评分:</em><span><i><?php echo ($ppting["ting_gold"]); ?></i>分</span></p>
            </dd>
          </dl><?php endforeach; endif; else: echo "" ;endif; ?>
        <div class="film-model-list fn-clear">
          <?php if(is_array($index_movie_hist)): $i = 0; $__LIST__ = array_slice($index_movie_hist,1,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><a href="<?php echo ($ppting["ting_readurl"]); ?>" title="<?php echo ($ppting["ting_name"]); ?>" 
            <?php if(in_array(($i), explode(',',"3,6"))): ?>class="mr0"<?php endif; ?>
            target="_blank"> <span class="film-img"> <img src="<?php echo ($ppting["ting_picurl"]); ?>" alt="<?php echo ($ppting["ting_name"]); ?>"> <i></i> <em><?php echo ($ppting["ting_hits"]); ?></em> </span> <span class="film-tit"><?php echo ($ppting["ting_name"]); ?></span> </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
      </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
  </div>
  
</div>
</div>
<div class="content-box fn-clear">
  <div class="content-box-sf">
    <div class="box-model hot-layout">
      <div class="box-model-tit fn-clear">
        <h2><?php echo getlistname(15,'list_name');?></h2>
        <div class="box-model-nav" id="J-zy-nav"> <a href="javascript:;" class="on">推荐</a>
          <?php if(is_array($catzylist)): $i = 0; $__LIST__ = array_slice($catzylist,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="javascript:;"><?php echo ($vo["m_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="box-model-more"><a href="<?php echo getlistname(15,'list_url');?>" target="_blank">更多<i class="iconfont">&#xe60b;</i></a></div>
      </div>
      <div id="J-zy-con">
        <?php $index_zy =gxl_sql_ting('cid:15;field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime;limit:5;order:ting_addtime desc'); ?>
        <div class="hot-wrap zy-hover fn-clear" style="display: block">
          <ul class="fn-clear">
            <?php if(is_array($index_zy)): $i = 0; $__LIST__ = array_slice($index_zy,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><li class="hot-list hot-box-375x260"> <a href="<?php echo ($ppting["ting_readurl"]); ?>" title="<?php echo ($ppting["ting_name"]); ?>" class="hot-bg-icon" target="_blank"> <img class="loading" src="<?php echo ($apicss); ?>v256/images/pic.png" data-original="<?php echo ($ppting["ting_picurl"]); ?>"  alt="<?php echo ($ppting["ting_name"]); ?>"> <span class="hot-zy-span fn-clear"> <em class="play-bg"><i class="iconfont">&#xe611;</i></em> <span> <em><?php echo ($ppting["ting_name"]); ?></em> <em>
                <?php if($ppting["ting_continu"] != 0): ?>第<?php echo ($ppting["ting_continu"]); ?>集
                  <?php else: ?>
                  <?php echo ($ppting["ting_title"]); endif; ?>
                </em> </span> </span> <i class="hot-zy-bg"></i> </a> </li><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($index_zy)): $i = 0; $__LIST__ = array_slice($index_zy,1,12,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i; if(($i) == "7"): ?></ul>
          <ul class="hot-zy fn-clear"><?php endif; ?>
            <li class="hot-list hot-box-cj180x100 <?php if(($i) == "7"): ?>hot-zy-first<?php endif; ?>
              "> <a  href="<?php echo ($ppting["ting_readurl"]); ?>" title="<?php echo ($ppting["ting_name"]); ?>" class="hot-bg-icon" target="_blank"><img src="<?php echo ($ppting["ting_picurl"]); ?>"  alt="<?php echo ($ppting["ting_name"]); ?>" /></a>
              <p class="hot-t"><?php echo ($ppting["ting_name"]); ?></p>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <?php if(is_array($catzylist)): $i = 0; $__LIST__ = array_slice($catzylist,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $index_zy_mcid =gxl_sql_ting('cid:15;mcid:'.$vo['m_cid'].';field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime;limit:5;order:ting_addtime desc'); ?>
          <div class="hot-wrap zy-hover fn-clear">
            <ul class="fn-clear">
              <?php if(is_array($index_zy_mcid)): $i = 0; $__LIST__ = array_slice($index_zy_mcid,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><li class="hot-list hot-box-375x260"> <a href="<?php echo ($ppting["ting_readurl"]); ?>" title="<?php echo ($ppting["ting_name"]); ?>" class="hot-bg-icon" target="_blank"> <img src="<?php echo ($apicss); ?>v256/images/pic.png" class="lazy" data-original="<?php echo ($ppting["ting_picurl"]); ?>" alt="<?php echo ($ppting["ting_name"]); ?>"> <span class="hot-zy-span fn-clear"> <em class="play-bg"><i class="iconfont">&#xe611;</i></em> <span> <em><?php echo ($ppting["ting_name"]); ?></em> <em>
                  <?php if($ppting["ting_continu"] != 0): ?>第<?php echo ($ppting["ting_continu"]); ?>集
                    <?php else: ?>
                    <?php echo ($ppting["ting_title"]); endif; ?>
                  </em> </span> </span> <i class="hot-zy-bg"></i> </a> </li><?php endforeach; endif; else: echo "" ;endif; ?>
              <?php if(is_array($index_zy_mcid)): $i = 0; $__LIST__ = array_slice($index_zy_mcid,1,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i; if(($i) == "7"): ?></ul>
            <ul class="hot-zy fn-clear"><?php endif; ?>
              <li class="hot-list hot-box-cj180x100 <?php if(($i) == "7"): ?>hot-zy-first<?php endif; ?>
                "> <a href="<?php echo ($ppting["ting_readurl"]); ?>" title="<?php echo ($ppting["ting_name"]); ?>" class="hot-bg-icon" target="_blank"><img src="<?php echo ($apicss); ?>v256/images/pic.png" class="lazy" data-original="<?php echo ($ppting["ting_picurl"]); ?>" alt="<?php echo ($ppting["ting_name"]); ?>" /></a>
                <p class="hot-t"><?php echo ($ppting["ting_name"]); ?></p>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
    </div>
  </div>
  <div class="content-box-r">
    <div class="rebobang">
      <div class="rebo-tit fn-clear">
        <h3><?php echo getlistname(15,'list_name');?></h3>
      </div>
      <div class="zongyi-layout">
        <ul>
          <?php $index_zy_hits=gxl_sql_ting('cid:15;field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime,ting_hits;limit:8;order:ting_hits desc'); ?>
          <?php if(is_array($index_zy_hits)): $i = 0; $__LIST__ = $index_zy_hits;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><li class="fn-clear"> <em 
              <?php if(($i) <= "3"): ?>class="fst"<?php endif; ?>
              ><?php echo ($i); ?></em> <a href="<?php echo ($ppting["ting_readurl"]); ?>"  title="<?php echo ($ppting["ting_name"]); ?>" target="_blank"><?php echo ($ppting["ting_name"]); ?></a> <span><i><?php echo ($ppting["ting_hits"]); ?></i>人</span> </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </div>

  </div>
</div>
<?php $tv_new=gxl_sql_ting('cid:16;field:ting_id,ting_cid,ting_name,ting_pic,ting_anchor,ting_title,ting_content,ting_gold,ting_addtime,ting_hits;limit:8;order:ting_hits desc'); ?>
<div class="content-box fn-clear">
        <div class="box-model hot-layout">
            <div class="box-model-tit fn-clear">
                <h3>最近更新</h3>
                <div class="box-model-nav" id="J-neidi-nav">
                <?php if(is_array($tv_new)): $i = 0; $__LIST__ = array_slice($tv_new,5,10,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxlting): $mod = ($i % 2 );++$i;?><a href="<?php echo ($gxlting["ting_readurl"]); ?>" target="_blank"><?php echo ($gxlting["ting_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?> 
                    </div>
                <div class="box-model-more"><a href="<?php echo gxl_mytpl_url('my_new.html');?>">更多<i class="iconfont">&#xe60b;</i></a></div>
            </div>
            <div class="hot-wrap zy-hover fn-clear" style="display: block">
                <ul class="fn-clear">
                <?php if(is_array($tv_new)): $i = 0; $__LIST__ = array_slice($tv_new,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxlting): $mod = ($i % 2 );++$i;?><li class="hot-list hot-box-400x300">
                            <a href="<?php echo ($gxlting["ting_readurl"]); ?>" title="<?php echo ($gxlting["ting_name"]); ?>" target="_blank" class="hot-bg-icon">
                                <img class="loading" src="<?php echo ($apicss); ?>v256/images/pic.png" data-original="<?php echo ($gxlting["ting_picurl"]); ?>"  alt="<?php echo ($gxlting["ting_name"]); ?>" />
                                <span class="hot-zy-span fn-clear">
                                    <em class="play-bg"><i class="iconfont">&#xe611;</i></em>
                                    <span>
                                        <em><?php echo ($gxlting["ting_name"]); ?></em>
                                        <em><?php echo (msubstr($gxlting["ting_content"],0,20,'...')); ?></em>
                                    </span>
                                </span>
                                <i class="hot-zy-bg"></i>
                            </a>
                            
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>  
                        <?php if(is_array($tv_new)): $i = 0; $__LIST__ = array_slice($tv_new,1,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxlting): $mod = ($i % 2 );++$i;?><li class="hot-list hot-box-190x300">
                            <a href="<?php echo ($gxlting["ting_readurl"]); ?>" target="_blank" title="<?php echo ($gxlting["ting_name"]); ?>" class="first">
                                <span class="box-img">
                                    <img class="loading" src="<?php echo ($apicss); ?>v256/images/pic.png" data-original="<?php echo ($gxlting["ting_picurl"]); ?>"  alt="<?php echo ($gxlting["ting_name"]); ?>"/>
                                    <i class="box-img-h-bg"></i>
                                    <i class="box-img-play"></i>
                                </span>
                                <span class="box-tc">
                                    <em class="box-tc-t"><?php echo ($gxlting["ting_name"]); ?></em>
                                    <em class="box-tc-c"><?php echo (msubstr($gxlting["ting_actor"],0,15,'...')); ?></em>
                                </span>
                            </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        
                </ul>
            </div>
            
        </div>
        
    </div>
	
	
<?php $array_listidd = getlistall(2); ?>
<?php if(is_array($array_listidd)): $k = 0; $__LIST__ = array_slice($array_listidd,0,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxl_listid): $mod = ($k % 2 );++$k;?><div class="content-box fn-clear">
    <div class="box-model hot-layout">
        <div class="box-model-tit fn-clear">
            <h3><?php echo ($gxl_listid["list_name"]); ?></h3>
            <div class="box-model-more"><a href="<?php echo ($gxl_listid["list_url"]); ?>">更多<i class="iconfont">&#xe60b;</i></a></div>
        </div>
        <div id="J-neidi-con" class="film-model-layout">
            <div class="box-model-cont fn-clear" style="display: block">
            <?php $mov_list = gxl_sql_ting('cid:'.$gxl_listid['list_id'].';field:ting_id,ting_cid,ting_name,ting_pic,ting_title,ting_gold;limit:6;order:ting_addtime desc'); ?>  
             <?php if(is_array($mov_list)): $i = 0; $__LIST__ = $mov_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><a href="<?php echo ($ppting["ting_readurl"]); ?>" title="<?php echo ($ppting["ting_name"]); ?>" <?php if(in_array(($i), explode(',',"1"))): ?>class="first"<?php endif; ?>target="_blank">
                        <span class="box-img">
                            <img class="loading" src="<?php echo ($apicss); ?>v256/images/pic.png" data-original="<?php echo ($ppting["ting_picurl"]); ?>"  alt="<?php echo ($ppting["ting_name"]); ?>" />
                            <i class="box-img-h-bg"></i>
                            <i class="box-img-play"></i>
                        </span>
                        <span class="box-tc">
                            <em class="box-tc-t"><?php echo ($ppting["ting_name"]); ?></em>
                            <em class="box-tc-c"><?php echo ($ppting["ting_actor"]); ?></em>
                            <em class="box-tc-f"><?php echo ($ppting["ting_gold"]); ?></em>
                        </span>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>                          
            </div>
        
        </div>
    </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?> 
<div class="content-box fn-clear">
  <div class="box-model hot-layout">
    <div class="box-model-tit fn-clear">
      <h3>合作伙伴</h3>
      <div class="box-model-nav" id="J-hz-nav"> <a  class="on">媒体合作</a> <a >友情链接</a> </div>
    </div>
    <div class="friend-link" id="J-hz-con">
      <div class="fl-model fl-friend fn-clear" style="display: block">
	  
	  
	   <?php if(is_array($list_link)): $i = 0; $__LIST__ = $list_link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i; if(($ppting["link_type"]) == "2"): ?><span><a href="<?php echo ($ppting["link_url"]); ?>" target="_blank"><img src="<?php echo ($ppting["link_logo"]); ?>" alt="<?php echo ($ppting["link_name"]); ?>友情链接"></a></span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	  
	  </div>
      <div class="fl-model fl-link fn-clear" >
        <?php if(is_array($list_link)): $i = 0; $__LIST__ = $list_link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i; if(($ppting["link_type"]) == "1"): ?><span><a href="<?php echo ($ppting["link_url"]); ?>" target="_blank"><?php echo ($ppting["link_name"]); ?></a></span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
      </div>
    </div>
  </div>
</div>
<div class="foot">        
    
    <div class="foot-layout">
    <div class="foot-wrap">
       
<p class="foot-p2"><?php echo ($copyright); ?></p>
<p class="foot-p2">若本站收集的节目无意侵犯了贵司版权，请给<a href="mailto:<?php echo ($email); ?>"><?php echo ($email); ?></a>邮箱地址来信，我们将在第一时间删除相应资源</p>
    </div>
</div>
    </div>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/read.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/foot_js.js"></script>   
    

<script>v256.index.init();v256.film.init();</script>
</body>
</html>