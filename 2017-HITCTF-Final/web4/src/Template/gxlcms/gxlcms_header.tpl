                <div class="top-layout" id="J-fixtop">
            <div class="top-wrap fn-clear">
                <h1><a href="{$siteurl}">{$sitename}</a></h1>  
                <div class="search-wrap">
                    <form method="post" action="{:str_replace('-wd--p-1','',UU('Home-ting/search','',true,false))}">
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
                    <a href="{$siteurl}" <eq name="list_id" value=""><if condition=" $sid['sid'] gt ''"><else/>class="on"</if></eq>><i class="iconfont"></i><em>首页</em></a>
                    <volist name="list_menu" id="ppvod"><eq name="ppvod.list_pid" value="0">
                    <a href="{$ppvod.list_url}"  <eq name="sid.sid" value="story"><else/><eq name="ppvod.list_id" value="$list_id">class="on"</eq><eq name="ppvod.list_id" value="$list_pid">class="on"</eq></eq>><i class="iconfont"></i><em>{$ppvod.list_name}</em></a>
</eq></volist>
                 </div>
               
            </div>
            <div class="navgation-shodw"></div>
        </div>