<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>5sing独立播放页|中国原创音乐基地</title>
    <link href="/v256/tingcss/public_new.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/v256/tingcss/player.css"/>

    <style type="text/css">
        .item_img {
            position: relative
        }
    </style>

</head>

<body style="padding: 0px">
<div class="mian_palyer rel">
    <!--  top  -->
    <div class="p_top c_wap c_zm">
        <div class="p_logo lt rel"><a href="http://5sing.kugou.com" target="_blank"><img alt=""
                                                                                         src="http://static.5sing.kugou.com/release/fm/v3.0.00/m/images/p_logo.png"></a>
        </div>
        <div class="p_sc_t_box lt a_btn_rb3 c_wap c_zm rel">

            <div class="sc_txt lt">
                <input type="text" class="p_sc_v" id="txtKey" placeholder="歌曲/歌单/会员">
                <a href="javascript:void(0);" onclick="return false;" target="_blank" class="a_btn p_sc_btn rt"><i
                        class="ico"></i></a>

                <div class="abs ser_tips"></div>
            </div>
        </div>

        <div class="log_div p_login rt rel" style="display:block">
            <a href="javascript:void(0);" onclick="return false;" id="loginLink" title="中国原创音乐基地 5SING"
               class="f14">登录</a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="http://5sing.kugou.com/reg" target="_blank" title="中国原创音乐基地 5SING" class="f14">注册</a>
        </div>

    </div>

    <!-- 播放器 -->
    <div class="p_palyer_box">
        <div id="playerbox" class="jp-audio">
            <div class="c_wap c_zm">
                <div class="jp-infos lt">
                    <div class="p_now c_wap c_zm" style="display:block;">
                        <span class="u_head lt a_btn_rb lt">
                            <a href="javascript:void(0);">
                                <img alt="" src="images/head.jpg" width="80" height="80" class="a_btn_rb">
                            </a>
                        </span>
                        <!--============需修改=========================-->
                        <img src="images/no_play.png" class="lt noplay_img"/>

                        <div class="lt">
                            <h2 class="sing_title f16 ell" id="_sing_title"></h2>

                            <h2 class="sing_name f12 ell" id="_sing_name"><a href="#" target="_blank"></a></h2>
                        </div>
                    </div>
                    <div class="p_noplay"><img alt=""></div>
                </div>
                <div class="rt">
                    <div class="action_btn lt c_wap c_zm">
                        <a href="javascript:void(0);" onclick="return false;" class="jp-collect a_btn lt"
                           id="jp-collect1" tabindex="1" title="收藏"><i class="ico">收藏</i></a>
                        <a href="javascript:void(0);" class="jp-download a_btn lt" tabindex="1" title="下载"
                           target="_blank"><i class="ico">下载</i></a>
                        <a href="javascript:void(0);" onclick="return false;" class="jp-share song_share_link a_btn lt"
                           id="jp-share" tabindex="1" title="分享"><i class="ico">分享</i></a>
                    </div>
                    <div class="jp-controls lt c_wap c_zm">
                        <a href="javascript:void(0);" onclick="return false;" id="prev" class="wsp_c_prev a_btn lt"
                           title="上一首"><i class="ico">上一首</i></a>
                        <a href="javascript:void(0);" onclick="return false;" id="play" class="wsp_c_play a_btn lt"
                           title="播放"><i class="ico">播放</i></a>
                        <a href="javascript:void(0);" onclick="return false;" id="pause" class="wsp_c_pause a_btn lt"
                           title="暂停" style="display: none ;"><i class="ico">暂停</i></a>
                        <a href="javascript:void(0);" onclick="return false;" id="next" class="wsp_c_next a_btn lt"
                           title="下一首"><i class="ico">下一首</i></a>
                    </div>
                    <div class="jp-repeat lt rel" id="list">
                        <a href="javascript:void(0);" onclick="return false;" class="repeat repeat-01 a_btn rel"
                           id="jp-collect2" title="列表循环">列表循环<i class="ico lt"></i><b class="abs"></b></a>

                        <div class="repeat_lists abs" style="display:none;">
                            <a href="javascript:void(0);" onclick="return false;" class="repeat repeat-01 a_btn"
                               title="列表循环" id="list1"><i class="ico lt"></i>列表循环</a>
                            <a href="javascript:void(0);" onclick="return false;" class="repeat repeat-02 a_btn"
                               title="单曲循环" id="repeat"><i class="ico lt"></i>单曲循环</a>
                            <a href="javascript:void(0);" onclick="return false;" class="repeat repeat-03 a_btn"
                               title="随机播放" id="shuffle"><i class="ico lt"></i>随机播放</a>
                        </div>
                    </div>
                    <div class="jp-toggles lt ">
                        <div class="total c_wap c_zm">
                            <input id="mute" class="wsp_v_mute lt ico" type="button" value="静音" title="静音">

                            <div class="wsp_v_total lt" id="volume_bar">
                                <div class="wsp_v_current" style="width: 44%;"></div>
                            </div>
                        </div>
                        <span class="wsp_currentTime f14"><strong id="currentTime">00:00</strong><strong id="duration">/00:00</strong></span>
                    </div>
                </div>
            </div>
            <!-- 进度条 -->
            <div id="pb_t" class="wsp_p_total">
                <div id="pb_b" class="wsp_p_buffered" style="width:0%;">
                    <div id="pb_c" class="wsp_p_current" style="width: 10%;"></div>
                </div>
            </div>
            <audio id="audio">
                <p>您的浏览器不支持HTML5播放器呢！赶紧换一个最新的呗^_^.</p>
            </audio>
        </div>
    </div>
    <!-- 列表 -->
    <div class="p_lists_box abs">
        <div class="p_lists rel c_wap c_zm">
            <!-- 菜单 tab -->
            <!-- 左 菜单固定部分 -->
            <div class="p_menu_left abs" id="lists_left">
                <ul id="p_menu_left">
                    <li class="p_sel curr"><a href="javascript:void(0);" onclick="return false;"
                                              class="a_btn mu_01 rel"><i class="ico lt"></i><b id="add_tip"
                                                                                               class="abs ico add_tip animation fadeInTop"></b><span
                            class="rel">播放列表</span></a></li>
                    <li><a href="javascript:void(0);" onclick="return false;" class="a_btn mu_02"><i class="ico lt"></i><span
                            class="rel">播放历史</span></a></li>
                    <li><a href="javascript:void(0);" onclick="return false;" class="a_btn mu_03"><i class="ico lt"></i><span
                            class="rel">歌曲收藏</span></a></li>
                    <li><a href="javascript:void(0);" onclick="return false;" class="a_btn mu_04"><i class="ico lt"></i><span
                            class="rel">歌单收藏</span></a></li>
                    <li><a href="javascript:void(0);" onclick="return false;" class="a_btn mu_05"><i class="ico lt"></i><span
                            class="rel">我的歌单</span></a></li>
                </ul>
                <dl id="fm_menu_left">
                    <dt class="c_wap c_zm">
                    <h2 class="lt f16">电台推荐</h2><a href="javascript:void(0);" onclick="return false;"
                                                   class="a_btn rt next_page"><i class="ico lt"></i>换一换</a></dt>
                    <dd channelid="20"><a href="javascript:void(0);" onclick="return false;" class="a_btn mu_06"><i
                            class="ico lt"></i><span class="rel">华语</span></a></dd>
                    <dd channelid="26"><a href="javascript:void(0);" onclick="return false;" class="a_btn mu_06"><i
                            class="ico lt"></i><span class="rel">欧美</span></a></dd>
                    <dd channelid="28"><a href="javascript:void(0);" onclick="return false;" class="a_btn mu_06"><i
                            class="ico lt"></i><span class="rel">古风</span></a></dd>
                </dl>

            </div>
            <!-- 中间内容自适应部分 -->
            <div class="p_cont_auto rel">
                <!-- 歌曲 -->
                <div class="p_song_lists" style="display:block;">
                    <div id="p_title" class="p_song_t rel c_wap c_zm">
                        <div class="ck_act abs">&nbsp;</div>
                        <div class="lt w_60 f14">歌曲</div>
                        <div class="lt w_20 f14">演唱者</div>
                        <div class="lt w_20 f14">来源</div>
                    </div>
                    <div id="fm_title" class="p_song_t rel c_wap c_zm" style="display:none">
                        <div class="ck_act abs">&nbsp;</div>
                        <div class="lt w_80 f14">歌曲名</div>
                        <div class="lt w_20 f14">演唱者</div>
                    </div>
                    <div id="list_ScrollContent" class="p_items abs" style="display:block;">

                        <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" tabindex="0">
                            <div class="mCSB_container" id="songList">

                            </div>

                        </div>
                    </div>

                    <div id="defaultPlay" class="p_items_null" style="display:none;">
                        <dl class="c_wap c_zm">
                            <dt class="lt"><i class="ico"></i></dt>
                            <dd class="lt">
                                <h4 class="f16">暂无播放的歌曲</h4>

                                <p>你可以到5sing网页添加歌曲</p>
                                <a href="http://5sing.kugou.com" target="_blank"
                                   class="a_btn a_btn_rb3 a_btn_txt f14 lt">去5sing首页逛逛</a>
                            </dd>
                        </dl>
                    </div>
                    <div id="historyPlay" class="p_items_null" style="display:none;">
                        <dl class="c_wap c_zm">
                            <dt class="lt"><i class="ico"></i></dt>
                            <dd class="lt">
                                <h4 class="f16">暂无播放记录</h4>

                                <p>你可以到5sing网页添加歌曲</p>
                                <a href="http://5sing.kugou.com" target="_blank"
                                   class="a_btn a_btn_rb3 a_btn_txt f14 lt">去5sing首页逛逛</a>
                            </dd>
                        </dl>
                    </div>
                    <div id="mbPlay" class="p_items_null" style="display:none;">
                        <dl class="c_wap c_zm">
                            <dt class="lt"><i class="ico"></i></dt>
                            <dd class="lt">
                                <h4 class="f16">暂无收藏的歌曲</h4>

                                <p>你可以到5sing网页收藏喜欢的歌曲</p>
                                <a href="http://5sing.kugou.com" target="_blank"
                                   class="a_btn a_btn_rb3 a_btn_txt f14 lt">去5sing首页逛逛</a>
                            </dd>
                        </dl>
                    </div>
                </div>
                <!-- 歌单 -->
                <div class="p_shan_lists" style="display:none;">
                    <div class="p_song_t rel c_wap c_zm">
                        <div class="ck_act abs">&nbsp;</div>
                        <div class="lt w_80 f14">歌单名</div>
                        <div class="lt w_20 f14">歌单创建者</div>
                    </div>
                    <div id="MFsongList" class="p_items abs">
                        <div>
                            <div class="mCSB_container">
                            </div>
                        </div>
                    </div>

                    <div id="no_have_dj" class="p_items_null" style="display:none;">
                        <dl class="c_wap c_zm">
                            <dt class="lt"><i class="ico"></i></dt>
                            <dd class="lt">
                                <h4 class="f16">暂无歌单收藏</h4>

                                <p>你可以到5sing网页收藏喜欢的歌单</p>
                                <a href="http://5sing.kugou.com" target="_blank"
                                   class="a_btn a_btn_rb3 a_btn_txt f14 lt">去5sing首页逛逛</a>
                            </dd>
                        </dl>
                    </div>

                    <div id="is_not_dj" class="p_items_null" style="display:none;">
                        <dl class="c_wap c_zm">
                            <dt class="lt"><i class="ico"></i></dt>
                            <dd class="lt">
                                <h4 class="f16">你还不是淘歌达人哦</h4>

                                <p>成为淘歌达人，制作属于自己的歌单</p>
                                <a href="http://5sing.kugou.com/my/set/dj" target="_blank"
                                   class="a_btn a_btn_rb3 a_btn_txt f14 lt">立即申请</a>
                            </dd>
                        </dl>
                    </div>
                </div>

            </div>
            <!-- 右 歌词部分 -->
            <div class="lrc_right abs">
                <div class="lrc_mian rel">
                    <h2 class="sing_title f16 abs tc ell" id="title"></h2>

                    <div id="lyr" class="lrc_content abs tc">
                        <div>
                            <div class="mCSB_container" id="lyricContainer" style="position: relative; top: 0px; left: 0px;">

                            </div>

                        </div>


                    </div>
                    <div id="no_lyr" class="lrc_content abs tc" style="display:none;">
                        <div class="lrc_null">
                            <i class="ico"></i>
                            <p class="tc f14">这首歌还没有歌词哟</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部操作 -->
    <div class="b_tool abs">
        <div class="b_tool_box">
            <!-- 歌曲 操作 -->
            <div id="default_foot" class="song_l_tools tool_act c_wap c_zm" style="display:block;">
                <div class="ck_act lt"><input type="checkbox" name="ccheckAll" class="defaultCheckAll"></div>
                <a href="javascript:void(0);" onclick="return false;" class="a_btn a_btn_rb3 lt del_btn"><i
                        class="ico lt"></i>删除</a>
                <a href="javascript:void(0);" onclick="return false;" class="a_btn a_btn_rb3 lt clear_btn"><i
                        class="ico lt"></i>清空列表</a>
            </div>
            <div id="history_foot" class="history_l_tools tool_act c_wap c_zm">
                <div class="ck_act lt"><input type="checkbox" name="ccheckAll" class="historyCheckAll"></div>
                <a href="javascript:void(0);" onclick="return false;" class="a_btn a_btn_rb3 lt plyer_btn"><i
                        class="ico lt"></i>播放</a>
                <a href="javascript:void(0);" onclick="return false;" class="a_btn a_btn_rb3 lt add_btn"><i
                        class="ico lt"></i>添加到播放列表</a>
                <a href="javascript:void(0);" onclick="return false;" class="a_btn a_btn_rb3 lt del_btn"><i
                        class="ico lt"></i>删除</a>
            </div>
            <!-- 收藏 操作 -->
            <!--             <div id="mb_foot" class="keep_l_tools tool_act c_wap c_zm">
                            <div class="ck_act lt"><input type="checkbox" class="mbCheckAll"></div>
                            <a href="javascript:void(0);" onclick="return false;" class="a_btn a_btn_rb3 lt add_btn"><i class="ico lt"></i>添加到播放列表</a>
                        </div> -->
            <!-- 我的歌单 操作 -->
            <div class="my_s_l_tools tool_act c_wap c_zm">
                <div class="ck_act lt"><input type="checkbox"></div>
                <a href="javascript:void(0);" onclick="return false;" class="a_btn a_btn_rb3 lt plyer_btn"><i
                        class="ico lt"></i>播放</a>
            </div>
            <!-- 电台 操作 -->
            <div id="fm_foot" class="desk_l_tools tool_act c_wap c_zm">
                <a href="javascript:void(0);" onclick="return false;" class="a_btn a_btn_rb3 rt change_btn"><i
                        class="ico lt"></i>换一批歌曲</a>
            </div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="/v256/tingjs/list.js"></script>
<script type="text/javascript" src="/v256/tingjs/musicplayer.js"></script>
<script type="text/javascript" src="/v256/tingjs/jquery-2.1.4.js"></script>

<script type="text/javascript" src="/v256/tingjs/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="/v256/tingjs/jquery.mousewheel.min.js.js"></script>
<script type="text/javascript" src="/v256/tingjs/musiclist.js"></script>


</html>
