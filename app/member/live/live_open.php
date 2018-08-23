<div class="liveTV_main">
    <!-- title -->
    <div class="live_header">
        <h1>Xem cảnh</h1>
    </div>
    <!-- title End -->

    <!-- body -->
    <div class="liveTVG noFloat">
        <!--左边区域-->
        <div class="liveTV_leftDIV">

            <!--计分板-->
            <div id="div_info" class="live_scoreDIV" style="display: none;">
                <!-- 全部-->
                <div id="info_all" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_SC">
                        <tbody><tr>
                            <td id="all_point_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="all_serve_h" width="21">&nbsp;</td>
                            <td id="all_team_h" class="live_score_team"></td>
                            <td rowspan="2" id="all_best" class="live_score_best"></td>
                        </tr>
                        <tr>
                            <td id="all_point_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="all_serve_c">&nbsp;</td>
                            <td id="all_team_c" class="live_score_team"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--足球-->
                <div id="info_FT" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_SC">
                        <tbody><tr>
                            <td id="FT_clothes_h" width="20">&nbsp;</td>
                            <td id="FT_sc_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td class="live_score_team"><span id="FT_team_h"></span><span id="FT_red_h" style="display:none" class="live_score_redCard">0</span></td>
                        </tr>
                        <tr>
                            <td id="FT_clothes_c">&nbsp;</td>
                            <td id="FT_sc_c" class="TXTnowrap tuhuiWord">0</td>
                            <td class="live_score_team"><span id="FT_team_c"></span><span id="FT_red_c" style="display:none" class="live_score_redCard">0</span></td>
                        </tr>
                        </tbody></table>
                </div>
                <!--篮球&棒球&其他-->
                <div id="info_BK" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_BK">
                        <tbody><tr>
                            <td id="BK_clothes_h" width="20">&nbsp;</td>
                            <td id="BK_sc_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="BK_team_h" class="live_score_team"></td>
                        </tr>
                        <tr>
                            <td id="BK_clothes_c">&nbsp;</td>
                            <td id="BK_sc_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="BK_team_c" class="live_score_team"></td>
                        </tr>
                        </tbody></table>
                </div>
                <div id="info_BS" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_BS">
                        <tbody><tr>
                            <td id="BS_sc_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="BS_clothes_h" width="20">&nbsp;</td>
                            <td id="BS_team_h" class="live_score_team"></td>
                        </tr>
                        <tr>
                            <td id="BS_sc_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="BS_clothes_c">&nbsp;</td>
                            <td id="BS_team_c" class="live_score_team"></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="padd0">
                                <table cellspacing="0" cellpadding="0" class="live_scoreTB_inside">
                                    <tbody><tr>
                                        <td width="35%">
                                            <div class="live_LeiBaoG">
                                                <span id="BS_base_1B" class="live_LeiBao01"></span><span id="BS_base_2B" class="live_LeiBao02"></span><span id="BS_base_3B" class="live_LeiBao03"></span>
                                            </div>
                                        </td>
                                        <td width="65%" class="Word_Paddright">Gửi đi:<tt id="BS_out_count" class="dark_pink"></tt></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                        </tr>
                        </tbody></table>
                    <span id="BS_game_count" class="live_FTarr"></span><!--场次-->
                </div>
                <div id="info_OP" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_BK">
                        <tbody><tr>
                            <td id="OP_clothes_h" width="20">&nbsp;</td>
                            <td id="OP_sc_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td class="live_score_team"><span id="OP_team_h"></span><span id="OP_red_h" style="display:none" class="live_score_redCard">0</span></td>
                        </tr>
                        <tr>
                            <td id="OP_clothes_c">&nbsp;</td>
                            <td id="OP_sc_c" class="TXTnowrap tuhuiWord">0</td>
                            <td class="live_score_team" <span="" id="OP_team_c">&gt;<span id="OP_red_c" style="display:none" class="live_score_redCard">0</span></td>
                        </tr>
                        </tbody></table>
                </div>
                <!--网球-->
                <div id="info_TN" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_TN">
                        <tbody><tr>
                            <td id="TN_game_h" width="20" class="Word_Paddleft tuhuiWord">0</td>
                            <td id="TN_set_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="TN_point_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="TN_serve_h" width="21">&nbsp;</td>
                            <td id="TN_team_h" class="live_score_team"></td>
                            <td rowspan="2" id="TN_best" class="live_score_best"></td>
                        </tr>
                        <tr>
                            <td id="TN_game_c" class="Word_Paddleft tuhuiWord">0</td>
                            <td id="TN_set_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="TN_point_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="TN_serve_c">&nbsp;</td>
                            <td id="TN_team_c" class="live_score_team"></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="padd0">
                                <table cellspacing="0" cellpadding="0" class="live_scoreTB_inside">
                                    <tbody><tr>
                                        <td width="35%"><span id="TN_before"></span><span id="TN_weather" class="RedWord" style="display:none">Thời tiết trễ</span></td>
                                        <td width="65%" class="Word_Paddright topTD">Tổng số...<tt id="TN_total" class="dark_pink"></tt></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
                <!--羽毛 乒乓 排球-->
                <div id="info_VB" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_TN">
                        <tbody><tr>
                            <td id="VB_set_h" width="20" class="Word_Paddleft tuhuiWord">0</td>
                            <td id="VB_point_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="VB_serve_h" width="21" class="live_scoreIcon_a">&nbsp;</td>
                            <td id="VB_team_h" class="live_score_team"></td>
                            <td rowspan="2" id="VB_best" class="live_score_best"></td>
                        </tr>
                        <tr>
                            <td id="VB_set_c" class="Word_Paddleft tuhuiWord">0</td>
                            <td id="VB_point_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="VB_serve_c" class="live_scoreIcon_b">&nbsp;</td>
                            <td id="VB_team_c" class="live_score_team"></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="padd0">
                                <table cellspacing="0" cellpadding="0" class="live_scoreTB_inside">
                                    <tbody><tr>
                                        <td id="VB_before" width="35%"></td>
                                        <td width="65%" class="Word_Paddright topTD">Tổng số...<tt id="VB_total" class="dark_pink"></tt></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
                <div id="info_BM" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_TN">
                        <tbody><tr>
                            <td id="BM_set_h" width="20" class="Word_Paddleft tuhuiWord">0</td>
                            <td id="BM_point_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="BM_serve_h" width="21" class="live_scoreIcon_a">&nbsp;</td>
                            <td id="BM_team_h" class="live_score_team"></td>
                            <td rowspan="2" id="BM_best" class="live_score_best"></td>
                        </tr>
                        <tr>
                            <td id="BM_set_c" class="Word_Paddleft tuhuiWord">0</td>
                            <td id="BM_point_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="BM_serve_c" class="live_scoreIcon_b">&nbsp;</td>
                            <td id="BM_team_c" class="live_score_team"></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="padd0">
                                <table cellspacing="0" cellpadding="0" class="live_scoreTB_inside">
                                    <tbody><tr>
                                        <td id="BM_before" width="35%"></td>
                                        <td width="65%" class="Word_Paddright topTD">Tổng số...<tt id="BM_total" class="dark_pink"></tt></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
                <div id="info_TT" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_TN">
                        <tbody><tr>
                            <td id="TT_set_h" width="20" class="Word_Paddleft tuhuiWord">0</td>
                            <td id="TT_point_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="TT_serve_h" width="21" class="live_scoreIcon_a">&nbsp;</td>
                            <td id="TT_team_h" class="live_score_team"></td>
                            <td rowspan="2" id="TT_best" class="live_score_best"></td>
                        </tr>
                        <tr>
                            <td id="TT_set_c" class="Word_Paddleft tuhuiWord">0</td>
                            <td id="TT_point_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="TT_serve_c" class="live_scoreIcon_b">&nbsp;</td>
                            <td id="TT_team_c" class="live_score_team"></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="padd0">
                                <table cellspacing="0" cellpadding="0" class="live_scoreTB_inside">
                                    <tbody><tr>
                                        <td id="TT_before" width="35%"></td>
                                        <td width="65%" class="Word_Paddright topTD">Tổng số...<tt id="TT_total" class="dark_pink"></tt></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
                <div id="info_SK" style="display:none">
                    <table cellspacing="0" cellpadding="0" class="live_scoreTB live_BS">
                        <tbody><tr>
                            <td id="SK_sc_h" width="10" class="TXTnowrap tuhuiWord">0</td>
                            <td id="SK_team_h" class="live_score_team"></td>
                        </tr>
                        <tr>
                            <td id="SK_sc_c" class="TXTnowrap tuhuiWord">0</td>
                            <td id="SK_team_c" class="live_score_team"></td>
                        </tr>

                        </tbody></table>

                </div>


            </div>
            <!--计分板 End-->


            <!--没有TV播放 -->
            <div valign="top" id="DemoImgLayer" class="liveTV_demo" style=""></div>
            <!--没有TV播放 End-->


            <!--视讯影片区-->
            <div id="FlahLayer" class="liveTV_movieBIGDIV" style="display:none;">
                <div id="videoFrame" style="display:none;" class="dome_L"></div>
                <div class="dome_L">
                    <iframe id="DefLive" name="DefLive" width="100%" height="438" src="" scrolling="no" frameborder="0" framespacing="0" cellspacing="0" cellpadding="0" style="display:none;"></iframe>
                </div>

                <!--TV未播放假图 -->
                <div id="div_fake" class="live_TVdemoBG_BIG01" style="display:none;">Bấm để chơi</div>
                <!-- img : live_TVdemoBG_BIG01 / perform : live_TVdemoBG_BIG02 / unas : live_TVdemoBG_BIG03 -->
                <!--TV未播放假图 End-->
            </div>
            <!--视讯影片区 End-->


        </div>
        <!--左边区域 End-->



        <!--右边区域-->
        <div id="TV_right" class="liveTV_rightDIV">
            <!--弹出TV新增钮-->
            <div id="no_bet_head" style="display:none" class="noFloat">
                <span id="bet_list" class="liveTV_headerBTN_on" title="">Đặt cược</span>
                <span tabindex="1" id="btn_bet" class="liveTV_headerBTN" title="" onclick="go_livepage();">Thời khóa</span>
            </div>

            <!--赛事直播日程表-->
            <div id="time_list" class="live_listG_nomal">
                <!--head-->
                <div id="main_head" class="noFloat" style="position: fixed; z-index: 1; width: 302px;">
                    <span tabindex="1" id="TVbut" class="liveTV_headerBTN" title="" onclick="go_betpage();">Đặt cược</span>
                    <span tabindex="2" id="BEbut" class="liveTV_headerBTN_on" title="">Thời khóa</span>
                </div>
                <div id="main_head_bak" style="height: 40px; width: 316px;"><span tabindex="1" id="btn_bet_main" class="liveTV_headerBTN" title="">Đặt cược</span></div>
                <h1>Lịch biểu</h1>
                <div id="sel_gtype" class="live_allSportsBTN" onclick="divOnBlur('show_gtype')">
                    <tt id="select_gtype">Tất cả các</tt>
                    <div id="show_gtype" onmouseleave="hideDiv(this);" style="display:none" class="live_MINImenu" tabindex="100">
                        <span class="live_MINImenu_arr"></span>
                        <h1>Chọn môn...</h1>
                        <!--球类拉霸-->
                        <ul id="option_gtype" class="live_MINIul">
                            <li id="option_All" value="All" onclick="chggype(this)">Tất cả các...</li>
                            <li id="option_FT" value="FT" onclick="chggype(this)">Bóng đá</li>
                            <li id="option_BK" value="BK" onclick="chggype(this)">Bóng rổ</li>
                            <li id="option_TN" value="TN" onclick="chggype(this)">Quần vợt</li>
                            <li id="option_VB" value="VB" onclick="chggype(this)">Bóng chuyền</li>
                            <!--<li id="option_BM" value="BM" onclick="chggype(this)">羽毛球</li>-->
                            <!--<li id="option_TT" value="TT" onclick="chggype(this)">兵乓球</li>-->
                            <li id="option_BS" value="BS" onclick="chggype(this)">Bóng chày</li>
                            <!--<li id="option_SK" value="SK" onclick="chggype(this)">斯诺克/台球</li>-->
                            <li id="option_OP" value="OP" onclick="chggype(this)">Khác</li>
                        </ul>
                        <!--球类拉霸 End-->
                    </div>


                </div>


                <!--没有赛事-->
                <div id="even_none" class="live_noList" style="display:none">Hiện không có luồng trực tiếp nào của các sự kiện trực tiếp và trong tương lai.</div>
                <!--没有赛事 End-->

                <!-- 赛事列表 -->
                <div id="even_list" class="live_scrollBar">
                    <div id="showlayers">

                    </div>
                </div>
                <!-- 赛事列表 End-->

                <!-- 赛事模组 -->
                <div id="tb_layer" style="display:none">
                    <xmp>

                        <h2>*GAME_DATE*</h2>
                        <table cellspacing="0" cellpadding="0" class="live_listTB">
                            *GAME_LIST*
                        </table>

                    </xmp>
                </div>

                <div id="tr_layer" style="display:none">
                    <xmp>
                        <tr id="live_txt_*ID*" *LIVE_TXT_CLASS* *onclick*>
                            <td id="live_tv_*ID*" width="50" *LIVE_TV_CLASS*>*TIME*</td>
                            <td id="live_gtype_*ID*" width="30" *LIVE_GTYPE_CLASS*>&nbsp;</td>
                            <td>*TEAMH* vs *TEAMC*</td>
                        </tr>

                    </xmp>
                </div>
                <!-- 赛事模组 End -->

            </div>
            <!--赛事直播日程表 End-->

            <!-- 盘面 Start -->
            <div id="bet_box" style="display:none">
                <div id="bet_mem" class="bet_mem">
                    <div id="mem_div" class="Live_mem">
                        <iframe id="Live_mem" name="Live_mem" scrolling="YES" frameborder="NO" border="0" width="316" height="0px" allowtransparency="true"></iframe>
                    </div>
                    <div id="bet_div" class="liveTV_DIV_Mask" style="display:none">
                        <iframe id="bet_order_frame" class="liveTV_MaskG" name="bet_order_frame" scrolling="NO" frameborder="NO" border="0" width="100%" height="483" allowtransparency="true"></iframe>
                    </div>
                </div>
            </div>
            <!-- 盘面 End -->

        </div>
        <!--右边区域 End-->


    </div>
    <!-- body End -->



    <!-- load data -->
    <iframe id="reloadPHP" name="reloadPHP" src="/ok.html" style="display:none" width="0" height="0" frameborder="NO" border="0"></iframe>
    <iframe id="reloadgame" name="reloadgame" src="/ok.html" style="display:none" width="0" height="0" frameborder="NO" border="0"></iframe>
    <iframe id="registLive" name="registLive" src="/ok.html" style="display:none" width="0" height="0" frameborder="NO" border="0"></iframe>
    <!-- load data End-->



</div>