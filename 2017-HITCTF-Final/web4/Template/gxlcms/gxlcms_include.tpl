<script language="javascript"><!-- 
window.onerror=function(){return true;} 
// --></script>
<link href="{$apicss}v256/css/base.css" type="text/css" rel="stylesheet">  
<script type="text/javascript"> <notempty name="mobile_status">var Siteurl='{:rtrim($murl,'/')}'; var Mvodurl='{:rtrim($murl,'/')}{$thisurl}'; <else />var Siteurl='{$siteurl}'; var Mvodurl='{:rtrim($siteurl,'/')}{$thisurl}'; </notempty> Root='{$root}';var Sid='{$sid}';var Cid='{$list_id}';<if condition="$sid eq 1">var Id='{$ting_id}';<else />var Id='{$news_id}';</if></script>
<script type="text/javascript" src="{$apicss}v256/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="{$apicss}v256/js/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="{$apicss}v256/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="{$apicss}v256/js/scrollbar.js"></script>

<script type="text/javascript" src="{$apicss}v256/js/lazyload.js"></script>
<script type="text/javascript" src="{$apicss}v256/js/v256.js"></script>
<script type="text/javascript" src="{$apicss}v256/js/playclass.js"></script>
<script type="text/javascript" src="{$apicss}v256/js/jquery.base.js"></script>
<script type="text/javascript" src="{$apicss}v256/js/js.js"></script>
<notempty name="mobile_status">
<link rel="canonical" href="{:rtrim($siteurl,'/')}{$thisurl}"/>
<meta name="mobile-agent" content="format=xhtml;url={:rtrim($murl,'/')}{$thisurl}" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<script src="{$apicss}v256/js/uaredirectforpc.js" type="text/javascript"></script>
<script type="text/javascript">uaredirect("{:rtrim($murl,'/')}{$thisurl}");</script>
</notempty>
<php>$cattvlist = getlistmcat($tv_id); </php>
<php>$catmovlist = getlistmcat($mov_id);</php>
<php>$catdmlist = getlistmcat($dm_id);</php>
<php>$catzylist = getlistmcat($zy_id);</php>
<php>$catweilist = getlistmcat($wei_id);</php>
<php>$array_listtvid = getlistall($tv_id);</php>
<php>$array_listmovid = getlistall($mov_id);</php>

<php>$listarray = getlistmcat($list_id);</php>