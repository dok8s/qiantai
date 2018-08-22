<?php
$reUrl = '../order/body_var.php';
if($gtype == 'FT'){
    $reUrl = '../order/body_var_ft.php';
}
require ($reUrl);
?>

<?php
if($count > 0){
    $leaguName = '';
    // 'moredata','more','MID','pdate','M_League','MB_MID','MB_Win','TG_Win','M_Flat','TG_MID','MB_Team','TG_Team','ShowType','M_LetB','M_Type','MB_LetB_Rate','TG_LetB_Rate','MB_Dime','TG_Dime','TG_Dime_Rate','MB_Dime_Rate','s_single','s_double'
    foreach($data as $val){
        if($leaguName != $val['M_League']){
            $leaguName = $val['M_League'];
            ?>
            <tr class="bet_game_league" id="LEG_08-2550578">
                <td onclick="showLeg('<?=$val['MID']?>')" colspan="9"><?=$leaguName?></td>
            </tr>
            <?php
        }
    ?>
        <tr class="bet_game_tr_top TR_<?=$val['MID']?>" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
            <td class="bet_game_time" rowspan="3">
                <div class="bet_time_score"><?=$val['pdate']?></div>
                <div class="bet_game_n" style="display: none;"></div>
            </td>
            <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
                <div class="bet_team_div_ft">
                    <span class="bet_text_tdl"><?=$val['MB_Team']?>&nbsp;</span>
                    <span class="bet_text_tdred">
                        <span class="bet_red_card" style="display: none;"><?=$val['MB_Win']?></span>
                    </span>
                </div>
            </td>
            <td class="bet_text">
                <span class="bet_bg_color" id="RMH2869306">
                    <a title="<?=$val['MB_Team']?>" onclick="parent.mem_order.betOrder(<?=$gtype?>,'RM','gid=<?=$val['MID']?>&amp;uid=<?=$uid?>&amp;odd_f_type=H&amp;type=H&amp;gnum=50578&amp;langx=<?=$langx?>&amp;ptype=&amp;imp=N&amp;rtype=RMH&amp;wtype=RM','RMH2869306');" href="javascript://"><?=$val['MB_Win']?></a>
                </span>
            </td>
            <td class="bet_text">
                <div class="bet_text_table">
                    <span class="bet_text_tdl">
                        <tt class="bet_text_thin">0 / 0.5</tt>
                    </span>
                    <span class="bet_text_tdr">
                        <span class="bet_bg_color" id="REH2869306">
                            <a title="麦拉斯萨卡特卡斯" onclick="parent.mem_order.betOrder('FT','RE','gid=2869306&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50578&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2869306');" href="javascript://">1.19</a>
                        </span>
                    </span>
                </div>
            </td>
            <td class="bet_text">
                <div class="bet_text_table">
                    <span class="bet_text_tdl">
                        <tt class="bet_text_oue">大</tt>
                        <tt class="bet_text_thin">3.5</tt>
                    </span>
                    <span class="bet_text_tdr">
                        <span class="bet_bg_color" id="ROUC2869306">
                            <a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869306&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50577&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2869306');" href="javascript://">0.96</a>
                        </span>
                    </span>
                </div>
            </td>
            <td class="bet_text">
                <div class="bet_text_table">
                    <span class="bet_text_tdl">
                        <tt class="bet_text_oue">单</tt>
                    </span>
                    <span class="bet_text_tdr">
                        <span class="bet_text_color" id="REOO2869306" onmouseover="iornameMouseOver(this.id);">
                            <a title="单" onclick="parent.mem_order.betOrder('FT','REO','gid=2869306&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=RODD&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RODD&amp;wtype=REO','REOO2869306');" href="javascript://">1.49</a>
                        </span>
                    </span>
                </div>
            </td>
            <td class="bet_text_left_bg" id="TR_08-2550578_text_1"></td>
            <td class="bet_text_bg" id="TR_08-2550578_text_2">
                <div class="bet_text_table">
                    <span class="bet_text_tdl">
                        <tt class="bet_text_thin_bg"></tt>
                    </span>
                    <span class="bet_text_tdr"></span>
                </div>
            </td>
            <td class="bet_text_right_bg" id="TR_08-2550578_text_3">
                <div class="bet_text_table">
                    <span class="bet_text_tdl">
                        <tt class="bet_text_oue"></tt>
                        <tt class="bet_text_thin_bg"></tt>
                    </span>
                    <span class="bet_text_tdr"></span>
                </div>
            </td>
        </tr>
        <tr class="bet_game_tr_other  TR_<?=$val['MID']?>" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
            <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft">
                    <span class="bet_text_tdl"><?=$val['TG_Team']?>&nbsp;</span>
                    <span class="bet_text_tdred">
                        <span class="bet_red_card" style="display: none;"><?=$val['TG_Win']?></span>
                    </span>
                </div>
            </td>
            <td class="bet_text"><span class="bet_bg_color" id="RMC2869306"><a title="坦皮科马德罗" onclick="parent.mem_order.betOrder('FT','RM','gid=2869306&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50577&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMC&amp;wtype=RM','RMC2869306');" href="javascript://"><?=$val['TG_Win']?></a></span></td>
            <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2869306"><a title="坦皮科马德罗" onclick="parent.mem_order.betOrder('FT','RE','gid=2869306&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50577&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2869306');" href="javascript://">0.64</a></span></span></div></td>
            <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">3.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2869306"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869306&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50578&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2869306');" href="javascript://">0.82</a></span></span></div></td>
            <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">双</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="REOE2869306" onmouseover="iornameMouseOver(this.id);"><a title="双" onclick="parent.mem_order.betOrder('FT','REO','gid=2869306&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=REVEN&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REVEN&amp;wtype=REO','REOE2869306');" href="javascript://">2.56</a></span></span></div></td>
            <td class="bet_text_left_bg" id="TR1_08-2550578_text_1"></td>
            <td class="bet_text_bg" id="TR1_08-2550578_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
            <td class="bet_text_right_bg" id="TR1_08-2550578_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
        </tr>


    <?php
    }
}
?>
<!--SHOW LEGUAGE START-->
<!--SHOW LEGUAGE END-->

<tr class="bet_game_tr_other" id="TR2_08-2550578" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" id="love08-2550578_none"></span><span title="赛事收藏" class="bet_game_star_out" id="love08-2550578" style="display: none;" onclick="addShowLoveI('50578','08-25<br>08:00p','墨西哥甲组联赛','麦拉斯萨卡特卡斯','坦皮科马德罗','1785570');"></span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMN2869306"><a title="和" onclick="parent.mem_order.betOrder('FT','RM','gid=2869306&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=50577&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMN&amp;wtype=RM','RMN2869306');" href="javascript://">6.40</a></span></td>
    <td colspan="3"><span class="bet_more_btn" onclick="show_allbets('2869306',event,'',0);">所有玩法&nbsp;&nbsp;<tt>16</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550578_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550578_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550578_text_3"><span title="可以观看在线直播" class="bet_TV_btn_on" onclick="OpenLive('89BCBBBCBCBCBABCBBBCB8CCBABCB38FC8CACAC7C8CECBA9B3','FT')" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550580" style="display: none;">
    <td onclick="showLeg('墨西哥甲组联赛')" colspan="9">墨西哥甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top_color" id="TR_08-2550580" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="2"><div class="bet_time_score"></div><div></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">麦拉斯萨卡特卡斯&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="REH2869308" onmouseover="iornameMouseOver(this.id);"><a title="麦拉斯萨卡特卡斯" onclick="parent.mem_order.betOrder('FT','RE','gid=2869308&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50580&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2869308');" href="javascript://">0.35</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">3.5 / 4</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2869308"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869308&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50579&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2869308');" href="javascript://">1.33</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550580_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550580_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550580_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550580" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">坦皮科马德罗&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="REC2869308" onmouseover="iornameMouseOver(this.id);"><a title="坦皮科马德罗" onclick="parent.mem_order.betOrder('FT','RE','gid=2869308&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50579&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2869308');" href="javascript://">1.81</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">3.5 / 4</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2869308"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869308&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50580&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2869308');" href="javascript://">0.53</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550580_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550580_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550580_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550580_sub" style="display: none;" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" style="display: none;"></span><span></span></span></div></td>
    <td class="bet_text"></td>
    <td colspan="3"><span class="bet_more_btn" style="display: none;">所有玩法&nbsp;&nbsp;<tt>0</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550580_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550580_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550580_text_3"><span title="可以观看在线直播" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2551706">
    <td onclick="showLeg('阿根廷超级联赛')" colspan="9">阿根廷超级联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top" id="TR_08-2551706" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="3"><div class="bet_time_score"><tt class="bet_score_og">2</tt> - <tt class="bet_score">0</tt></div><div>下半场 <font class="rb_color">21'</font></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">班菲特&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMH2873410"><a title="班菲特" onclick="parent.mem_order.betOrder('FT','RM','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=51706&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMH&amp;wtype=RM','RMH2873410');" href="javascript://">1.02</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2873410"><a title="班菲特" onclick="parent.mem_order.betOrder('FT','RE','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=51706&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2873410');" href="javascript://">0.67</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">2.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2873410"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=51705&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2873410');" href="javascript://">0.77</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">单</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="REOO2873410" onmouseover="iornameMouseOver(this.id);"><a title="单" onclick="parent.mem_order.betOrder('FT','REO','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=RODD&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RODD&amp;wtype=REO','REOO2873410');" href="javascript://">2.36</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2551706_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2551706_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2551706_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2551706" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">贝尔格拉诺&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMC2873410"><a title="贝尔格拉诺" onclick="parent.mem_order.betOrder('FT','RM','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=51705&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMC&amp;wtype=RM','RMC2873410');" href="javascript://">36.00</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2873410"><a title="贝尔格拉诺" onclick="parent.mem_order.betOrder('FT','RE','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=51705&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2873410');" href="javascript://">1.23</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">2.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2873410"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=51706&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2873410');" href="javascript://">1.07</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">双</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="REOE2873410" onmouseover="iornameMouseOver(this.id);"><a title="双" onclick="parent.mem_order.betOrder('FT','REO','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=REVEN&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REVEN&amp;wtype=REO','REOE2873410');" href="javascript://">1.58</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2551706_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2551706_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2551706_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2551706" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" id="love08-2551706_none"></span><span title="赛事收藏" class="bet_game_star_out" id="love08-2551706" style="display: none;" onclick="addShowLoveI('51706','08-25<br>08:05p','阿根廷超级联赛','班菲特','贝尔格拉诺','1788178');"></span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMN2873410"><a title="和" onclick="parent.mem_order.betOrder('FT','RM','gid=2873410&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=51705&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMN&amp;wtype=RM','RMN2873410');" href="javascript://">13.50</a></span></td>
    <td colspan="3"><span class="bet_more_btn" onclick="show_allbets('2873410',event,'',2);">所有玩法&nbsp;&nbsp;<tt>28</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2551706_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2551706_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2551706_text_3"><span title="可以观看在线直播" class="bet_TV_btn_on" onclick="OpenLive('8DBCB7CCBABCBABCBBBCB8CCB6CCB387C8CEC7C7C8CECBA9B3','FT')" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2551708" style="display: none;">
    <td onclick="showLeg('阿根廷超级联赛')" colspan="9">阿根廷超级联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top_color" id="TR_08-2551708" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="2"><div class="bet_time_score"></div><div></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">班菲特&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0 / 0.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2873412"><a title="班菲特" onclick="parent.mem_order.betOrder('FT','RE','gid=2873412&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=51708&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2873412');" href="javascript://">1.38</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">2.5 / 3</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2873412"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2873412&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=51707&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2873412');" href="javascript://">1.17</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2551708_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2551708_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2551708_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2551708" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">贝尔格拉诺&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2873412"><a title="贝尔格拉诺" onclick="parent.mem_order.betOrder('FT','RE','gid=2873412&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=51707&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2873412');" href="javascript://">0.58</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">2.5 / 3</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2873412"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2873412&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=51708&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2873412');" href="javascript://">0.69</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2551708_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2551708_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2551708_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2551708_sub" style="display: none;" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" style="display: none;"></span><span></span></span></div></td>
    <td class="bet_text"></td>
    <td colspan="3"><span class="bet_more_btn" style="display: none;">所有玩法&nbsp;&nbsp;<tt>0</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2551708_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2551708_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2551708_text_3"><span title="可以观看在线直播" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550222">
    <td onclick="showLeg('巴西乙组联赛')" colspan="9">巴西乙组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top" id="TR_08-2550222" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="3"><div class="bet_time_score"><tt class="bet_score_og">2</tt> - <tt class="bet_score">1</tt></div><div>半场</div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">国际体育会RS&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMH2866886"><a title="国际体育会RS" onclick="parent.mem_order.betOrder('FT','RM','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50222&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMH&amp;wtype=RM','RMH2866886');" href="javascript://">1.06</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0.5 / 1</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2866886"><a title="国际体育会RS" onclick="parent.mem_order.betOrder('FT','RE','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50222&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2866886');" href="javascript://">0.84</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">4 / 4.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2866886"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50221&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2866886');" href="javascript://">0.91</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">单</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOO2866886"><a title="单" onclick="parent.mem_order.betOrder('FT','REO','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=RODD&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RODD&amp;wtype=REO','REOO2866886');" href="javascript://">1.83</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550222_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550222_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550222_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550222" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">帕桑度PA&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMC2866886"><a title="帕桑度PA" onclick="parent.mem_order.betOrder('FT','RM','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50221&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMC&amp;wtype=RM','RMC2866886');" href="javascript://">31.00</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2866886"><a title="帕桑度PA" onclick="parent.mem_order.betOrder('FT','RE','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50221&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2866886');" href="javascript://">1.02</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">4 / 4.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2866886"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50222&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2866886');" href="javascript://">0.93</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">双</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOE2866886"><a title="双" onclick="parent.mem_order.betOrder('FT','REO','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=REVEN&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REVEN&amp;wtype=REO','REOE2866886');" href="javascript://">2.02</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550222_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550222_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550222_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550222" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" id="love08-2550222_none"></span><span title="赛事收藏" class="bet_game_star_out" id="love08-2550222" style="display: none;" onclick="addShowLoveI('50222','08-25<br>08:30p','巴西乙组联赛','国际体育会RS','帕桑度PA','1782865');"></span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMN2866886"><a title="和" onclick="parent.mem_order.betOrder('FT','RM','gid=2866886&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=50221&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMN&amp;wtype=RM','RMN2866886');" href="javascript://">9.70</a></span></td>
    <td colspan="3"><span class="bet_more_btn" onclick="show_allbets('2866886',event,'',4);">所有玩法&nbsp;&nbsp;<tt>18</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550222_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550222_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550222_text_3"><span title="可以观看在线直播" class="bet_TV_btn_on" style="visibility: hidden;" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550224" style="display: none;">
    <td onclick="showLeg('巴西乙组联赛')" colspan="9">巴西乙组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top_color" id="TR_08-2550224" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="2"><div class="bet_time_score"></div><div></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">国际体育会RS&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">1</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2866888"><a title="国际体育会RS" onclick="parent.mem_order.betOrder('FT','RE','gid=2866888&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50224&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2866888');" href="javascript://">1.33</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">4.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2866888"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2866888&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50223&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2866888');" href="javascript://">1.14</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550224_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550224_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550224_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550224" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">帕桑度PA&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2866888"><a title="帕桑度PA" onclick="parent.mem_order.betOrder('FT','RE','gid=2866888&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50223&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2866888');" href="javascript://">0.61</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">4.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2866888"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2866888&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50224&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2866888');" href="javascript://">0.71</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550224_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550224_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550224_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550224_sub" style="display: none;" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" style="display: none;"></span><span></span></span></div></td>
    <td class="bet_text"></td>
    <td colspan="3"><span class="bet_more_btn" style="display: none;">所有玩法&nbsp;&nbsp;<tt>0</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550224_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550224_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550224_text_3"><span title="可以观看在线直播" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550666">
    <td onclick="showLeg('厄瓜多尔甲组联赛')" colspan="9">厄瓜多尔甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top" id="TR_08-2550666" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="3"><div class="bet_time_score"><tt class="bet_score_og">1</tt> - <tt class="bet_score">1</tt></div><div>半场</div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">国家报队&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMH2869986"><a title="国家报队" onclick="parent.mem_order.betOrder('FT','RM','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50666&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMH&amp;wtype=RM','RMH2869986');" href="javascript://">3.10</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2869986"><a title="国家报队" onclick="parent.mem_order.betOrder('FT','RE','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50666&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2869986');" href="javascript://">1.14</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">3.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2869986"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50665&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2869986');" href="javascript://">1.03</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">单</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOO2869986"><a title="单" onclick="parent.mem_order.betOrder('FT','REO','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=RODD&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RODD&amp;wtype=REO','REOO2869986');" href="javascript://">2.01</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550666_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550666_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550666_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550666" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">瓦伦独立&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMC2869986"><a title="瓦伦独立" onclick="parent.mem_order.betOrder('FT','RM','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50665&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMC&amp;wtype=RM','RMC2869986');" href="javascript://">2.50</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2869986"><a title="瓦伦独立" onclick="parent.mem_order.betOrder('FT','RE','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50665&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2869986');" href="javascript://">0.69</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">3.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2869986"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50666&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2869986');" href="javascript://">0.77</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">双</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOE2869986"><a title="双" onclick="parent.mem_order.betOrder('FT','REO','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=REVEN&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REVEN&amp;wtype=REO','REOE2869986');" href="javascript://">1.84</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550666_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550666_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550666_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550666" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" id="love08-2550666_none"></span><span title="赛事收藏" class="bet_game_star_out" id="love08-2550666" style="display: none;" onclick="addShowLoveI('50666','08-25<br>08:30p','厄瓜多尔甲组联赛','国家报队','瓦伦独立','1786473');"></span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMN2869986"><a title="和" onclick="parent.mem_order.betOrder('FT','RM','gid=2869986&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=50665&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMN&amp;wtype=RM','RMN2869986');" href="javascript://">2.50</a></span></td>
    <td colspan="3"><span class="bet_more_btn" onclick="show_allbets('2869986',event,'',6);">所有玩法&nbsp;&nbsp;<tt>24</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550666_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550666_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550666_text_3"><span title="可以观看在线直播" class="bet_TV_btn_on" onclick="OpenLive('8DBCB6CCBABCBABCBBBCB8CCB7CCB38CC8CBC9C7C8CECBA9B3','FT')" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550668" style="display: none;">
    <td onclick="showLeg('厄瓜多尔甲组联赛')" colspan="9">厄瓜多尔甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top_color" id="TR_08-2550668" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="2"><div class="bet_time_score"></div><div></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">国家报队&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2869988"><a title="国家报队" onclick="parent.mem_order.betOrder('FT','RE','gid=2869988&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50668&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2869988');" href="javascript://">0.68</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">3 / 3.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2869988"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869988&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50667&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2869988');" href="javascript://">0.69</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550668_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550668_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550668_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550668" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">瓦伦独立&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0 / 0.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2869988"><a title="瓦伦独立" onclick="parent.mem_order.betOrder('FT','RE','gid=2869988&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50667&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2869988');" href="javascript://">1.13</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">3 / 3.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2869988"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869988&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50668&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2869988');" href="javascript://">1.09</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550668_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550668_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550668_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550668_sub" style="display: none;" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" style="display: none;"></span><span></span></span></div></td>
    <td class="bet_text"></td>
    <td colspan="3"><span class="bet_more_btn" style="display: none;">所有玩法&nbsp;&nbsp;<tt>0</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550668_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550668_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550668_text_3"><span title="可以观看在线直播" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550672" style="display: none;">
    <td onclick="showLeg('厄瓜多尔甲组联赛')" colspan="9">厄瓜多尔甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top" id="TR_08-2550672" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="3"><div class="bet_time_score"><tt class="bet_score">0</tt> - <tt class="bet_score">0</tt></div><div>半场</div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">奎托&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMH2869990"><a title="奎托" onclick="parent.mem_order.betOrder('FT','RM','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50672&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMH&amp;wtype=RM','RMH2869990');" href="javascript://">2.97</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2869990"><a title="奎托" onclick="parent.mem_order.betOrder('FT','RE','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50672&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2869990');" href="javascript://">0.87</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">1</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2869990"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50671&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2869990');" href="javascript://">0.74</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">单</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOO2869990"><a title="单" onclick="parent.mem_order.betOrder('FT','REO','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=RODD&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RODD&amp;wtype=REO','REOO2869990');" href="javascript://">2.08</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550672_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550672_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550672_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550672" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">巴塞隆拿SC&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMC2869990"><a title="巴塞隆拿SC" onclick="parent.mem_order.betOrder('FT','RM','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50671&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMC&amp;wtype=RM','RMC2869990');" href="javascript://">3.05</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2869990"><a title="巴塞隆拿SC" onclick="parent.mem_order.betOrder('FT','RE','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50671&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2869990');" href="javascript://">0.95</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">1</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2869990"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50672&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2869990');" href="javascript://">1.06</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">双</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOE2869990"><a title="双" onclick="parent.mem_order.betOrder('FT','REO','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=REVEN&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REVEN&amp;wtype=REO','REOE2869990');" href="javascript://">1.77</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550672_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550672_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550672_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550672" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" id="love08-2550672_none"></span><span title="赛事收藏" class="bet_game_star_out" id="love08-2550672" style="display: none;" onclick="addShowLoveI('50672','08-25<br>08:30p','厄瓜多尔甲组联赛','奎托','巴塞隆拿SC','1786476');"></span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMN2869990"><a title="和" onclick="parent.mem_order.betOrder('FT','RM','gid=2869990&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=50671&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMN&amp;wtype=RM','RMN2869990');" href="javascript://">2.18</a></span></td>
    <td colspan="3"><span class="bet_more_btn" onclick="show_allbets('2869990',event,'',8);">所有玩法&nbsp;&nbsp;<tt>24</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550672_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550672_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550672_text_3"><span title="可以观看在线直播" class="bet_TV_btn_on" onclick="OpenLive('8DBCBEBCB9CCBABCBBBCB8CCB7CCB389C8CBC9C7C8CECBA9B3','FT')" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550674" style="display: none;">
    <td onclick="showLeg('厄瓜多尔甲组联赛')" colspan="9">厄瓜多尔甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top_color" id="TR_08-2550674" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="2"><div class="bet_time_score"></div><div></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">奎托&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0 / 0.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2869992"><a title="奎托" onclick="parent.mem_order.betOrder('FT','RE','gid=2869992&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50674&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2869992');" href="javascript://">1.40</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">1 / 1.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUC2869992"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869992&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50673&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2869992');" href="javascript://">1.19</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550674_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550674_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550674_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550674" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">巴塞隆拿SC&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2869992"><a title="巴塞隆拿SC" onclick="parent.mem_order.betOrder('FT','RE','gid=2869992&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50673&amp;strong=&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2869992');" href="javascript://">0.53</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">1 / 1.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="ROUH2869992"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869992&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50674&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2869992');" href="javascript://">0.64</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550674_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550674_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550674_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550674_sub" style="display: none;" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" style="display: none;"></span><span></span></span></div></td>
    <td class="bet_text"></td>
    <td colspan="3"><span class="bet_more_btn" style="display: none;">所有玩法&nbsp;&nbsp;<tt>0</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550674_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550674_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550674_text_3"><span title="可以观看在线直播" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550684" style="display: none;">
    <td onclick="showLeg('厄瓜多尔甲组联赛')" colspan="9">厄瓜多尔甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top" id="TR_08-2550684" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="3"><div class="bet_time_score"><tt class="bet_score">0</tt> - <tt class="bet_score">0</tt></div><div>上半场 <font class="rb_color">25'</font></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">瓜亚基尔城&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMH2869998"><a title="瓜亚基尔城" onclick="parent.mem_order.betOrder('FT','RM','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50684&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMH&amp;wtype=RM','RMH2869998');" href="javascript://">2.97</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2869998"><a title="瓜亚基尔城" onclick="parent.mem_order.betOrder('FT','RE','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50684&amp;strong=C&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2869998');" href="javascript://">1.08</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">1.5</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="ROUC2869998" onmouseover="iornameMouseOver(this.id);"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50683&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2869998');" href="javascript://">0.90</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">单</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOO2869998"><a title="单" onclick="parent.mem_order.betOrder('FT','REO','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=RODD&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RODD&amp;wtype=REO','REOO2869998');" href="javascript://">1.99</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550684_text_1"><span class="bet_text_color" id="HRMH2869999" onmouseover="iornameMouseOver(this.id);"><a title="瓜亚基尔城" onclick="parent.mem_order.betOrder('FT','HRM','gid=2869999&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50684&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HRMH&amp;wtype=HRM','HRMH2869999');" href="javascript://">5.20</a></span></td>
    <td class="bet_text_bg" id="TR_08-2550684_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="HREH2869999"><a title="瓜亚基尔城" onclick="parent.mem_order.betOrder('FT','HRE','gid=2869999&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50684&amp;strong=C&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HREH&amp;wtype=HRE','HREH2869999');" href="javascript://">1.14</a></span></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550684_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin_bg">0.5</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HROUC2869999" onmouseover="iornameMouseOver(this.id);"><a title="大" onclick="parent.mem_order.betOrder('FT','HROU','gid=2869999&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50683&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HROUC&amp;wtype=HROU','HROUC2869999');" href="javascript://">1.40</a></span></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550684" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">德芬&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMC2869998"><a title="德芬" onclick="parent.mem_order.betOrder('FT','RM','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50683&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMC&amp;wtype=RM','RMC2869998');" href="javascript://">2.47</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2869998"><a title="德芬" onclick="parent.mem_order.betOrder('FT','RE','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50683&amp;strong=C&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2869998');" href="javascript://">0.74</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">1.5</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="ROUH2869998" onmouseover="iornameMouseOver(this.id);"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50684&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2869998');" href="javascript://">0.90</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">双</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOE2869998"><a title="双" onclick="parent.mem_order.betOrder('FT','REO','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=REVEN&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REVEN&amp;wtype=REO','REOE2869998');" href="javascript://">1.86</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550684_text_1"><span class="bet_text_color" id="HRMC2869999" onmouseover="iornameMouseOver(this.id);"><a title="德芬" onclick="parent.mem_order.betOrder('FT','HRM','gid=2869999&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50683&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HRMC&amp;wtype=HRM','HRMC2869999');" href="javascript://">4.55</a></span></td>
    <td class="bet_text_bg" id="TR1_08-2550684_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">0</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="HREC2869999"><a title="德芬" onclick="parent.mem_order.betOrder('FT','HRE','gid=2869999&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50683&amp;strong=C&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HREC&amp;wtype=HRE','HREC2869999');" href="javascript://">0.69</a></span></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550684_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin_bg">0.5</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HROUH2869999" onmouseover="iornameMouseOver(this.id);"><a title="小" onclick="parent.mem_order.betOrder('FT','HROU','gid=2869999&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50684&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HROUH&amp;wtype=HROU','HROUH2869999');" href="javascript://">0.51</a></span></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550684" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" id="love08-2550684_none"></span><span title="赛事收藏" class="bet_game_star_out" id="love08-2550684" style="display: none;" onclick="addShowLoveI('50684','08-25<br>09:00p','厄瓜多尔甲组联赛','瓜亚基尔城','德芬','1786482');"></span></span></div></td>
    <td class="bet_text"><span class="bet_bg_color" id="RMN2869998"><a title="和" onclick="parent.mem_order.betOrder('FT','RM','gid=2869998&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=50683&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMN&amp;wtype=RM','RMN2869998');" href="javascript://">2.64</a></span></td>
    <td colspan="3"><span class="bet_more_btn" onclick="show_allbets('2869998',event,'',10);">所有玩法&nbsp;&nbsp;<tt>41</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550684_text_1"><span class="bet_text_color" id="HRMN2869999" onmouseover="iornameMouseOver(this.id);"><a title="和" onclick="parent.mem_order.betOrder('FT','HRM','gid=2869999&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=50683&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HRMN&amp;wtype=HRM','HRMN2869999');" href="javascript://">1.41</a></span></td>
    <td class="bet_td_bg" id="TR2_08-2550684_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550684_text_3"><span title="可以观看在线直播" class="bet_TV_btn_on" onclick="OpenLive('8DBCB6CCBCBCBABCBBBCB8CCB7CCB38DC7CBC9C7C8CECBA9B3','FT')" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550686" style="display: none;">
    <td onclick="showLeg('厄瓜多尔甲组联赛')" colspan="9">厄瓜多尔甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top_color" id="TR_08-2550686" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="2"><div class="bet_time_score"></div><div></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">瓜亚基尔城&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2870000"><a title="瓜亚基尔城" onclick="parent.mem_order.betOrder('FT','RE','gid=2870000&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50686&amp;strong=C&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2870000');" href="javascript://">0.69</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">1.5 / 2</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="ROUC2870000" onmouseover="iornameMouseOver(this.id);"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2870000&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50685&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2870000');" href="javascript://">1.17</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550686_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550686_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HREH2870001" onmouseover="iornameMouseOver(this.id);"><a title="瓜亚基尔城" onclick="parent.mem_order.betOrder('FT','HRE','gid=2870001&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50686&amp;strong=C&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HREH&amp;wtype=HRE','HREH2870001');" href="javascript://">0.31</a></span></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550686_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin_bg">0.5 / 1</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HROUC2870001" onmouseover="iornameMouseOver(this.id);"><a title="大" onclick="parent.mem_order.betOrder('FT','HROU','gid=2870001&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50685&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HROUC&amp;wtype=HROU','HROUC2870001');" href="javascript://">2.00</a></span></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550686" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">德芬&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0 / 0.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2870000"><a title="德芬" onclick="parent.mem_order.betOrder('FT','RE','gid=2870000&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50685&amp;strong=C&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2870000');" href="javascript://">1.14</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">1.5 / 2</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="ROUH2870000" onmouseover="iornameMouseOver(this.id);"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2870000&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50686&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2870000');" href="javascript://">0.65</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550686_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550686_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">0 / 0.5</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HREC2870001" onmouseover="iornameMouseOver(this.id);"><a title="德芬" onclick="parent.mem_order.betOrder('FT','HRE','gid=2870001&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50685&amp;strong=C&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HREC&amp;wtype=HRE','HREC2870001');" href="javascript://">2.04</a></span></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550686_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin_bg">0.5 / 1</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HROUH2870001" onmouseover="iornameMouseOver(this.id);"><a title="小" onclick="parent.mem_order.betOrder('FT','HROU','gid=2870001&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50686&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HROUH&amp;wtype=HROU','HROUH2870001');" href="javascript://">0.30</a></span></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550686_sub" style="display: none;" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" style="display: none;"></span><span></span></span></div></td>
    <td class="bet_text"></td>
    <td colspan="3"><span class="bet_more_btn" style="display: none;">所有玩法&nbsp;&nbsp;<tt>0</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550686_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550686_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550686_text_3"><span title="可以观看在线直播" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550690" style="display: none;">
    <td onclick="showLeg('厄瓜多尔甲组联赛')" colspan="9">厄瓜多尔甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top" id="TR_08-2550690" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="3"><div class="bet_time_score"><tt class="bet_score_og">1</tt> - <tt class="bet_score">0</tt></div><div>上半场 <font class="rb_color">25'</font></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">库恩卡&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"><span class="bet_text_color" id="RMH2870002" onmouseover="iornameMouseOver(this.id);"><a title="库恩卡" onclick="parent.mem_order.betOrder('FT','RM','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50690&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMH&amp;wtype=RM','RMH2870002');" href="javascript://">1.11</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0.5 / 1</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2870002"><a title="库恩卡" onclick="parent.mem_order.betOrder('FT','RE','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50690&amp;strong=H&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2870002');" href="javascript://">1.05</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">2.5 / 3</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="ROUC2870002" onmouseover="iornameMouseOver(this.id);"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50689&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2870002');" href="javascript://">0.95</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">单</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOO2870002"><a title="单" onclick="parent.mem_order.betOrder('FT','REO','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=RODD&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RODD&amp;wtype=REO','REOO2870002');" href="javascript://">1.87</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550690_text_1"><span class="bet_bg_color" id="HRMH2870003"><a title="库恩卡" onclick="parent.mem_order.betOrder('FT','HRM','gid=2870003&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50690&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HRMH&amp;wtype=HRM','HRMH2870003');" href="javascript://">1.06</a></span></td>
    <td class="bet_text_bg" id="TR_08-2550690_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">0 / 0.5</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HREH2870003" onmouseover="iornameMouseOver(this.id);"><a title="库恩卡" onclick="parent.mem_order.betOrder('FT','HRE','gid=2870003&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50690&amp;strong=H&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HREH&amp;wtype=HRE','HREH2870003');" href="javascript://">1.38</a></span></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550690_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin_bg">1.5</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HROUC2870003" onmouseover="iornameMouseOver(this.id);"><a title="大" onclick="parent.mem_order.betOrder('FT','HROU','gid=2870003&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50689&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HROUC&amp;wtype=HROU','HROUC2870003');" href="javascript://">1.28</a></span></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550690" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">福尔扎阿玛利拉&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"><span class="bet_text_color" id="RMC2870002" onmouseover="iornameMouseOver(this.id);"><a title="福尔扎阿玛利拉" onclick="parent.mem_order.betOrder('FT','RM','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50689&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMC&amp;wtype=RM','RMC2870002');" href="javascript://">15.00</a></span></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2870002"><a title="福尔扎阿玛利拉" onclick="parent.mem_order.betOrder('FT','RE','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50689&amp;strong=H&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2870002');" href="javascript://">0.77</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">2.5 / 3</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="ROUH2870002" onmouseover="iornameMouseOver(this.id);"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50690&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2870002');" href="javascript://">0.85</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">双</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REOE2870002"><a title="双" onclick="parent.mem_order.betOrder('FT','REO','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;rtype=REVEN&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REVEN&amp;wtype=REO','REOE2870002');" href="javascript://">1.98</a></span></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550690_text_1"><span class="bet_bg_color" id="HRMC2870003"><a title="福尔扎阿玛利拉" onclick="parent.mem_order.betOrder('FT','HRM','gid=2870003&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50689&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HRMC&amp;wtype=HRM','HRMC2870003');" href="javascript://">26.00</a></span></td>
    <td class="bet_text_bg" id="TR1_08-2550690_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HREC2870003" onmouseover="iornameMouseOver(this.id);"><a title="福尔扎阿玛利拉" onclick="parent.mem_order.betOrder('FT','HRE','gid=2870003&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50689&amp;strong=H&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HREC&amp;wtype=HRE','HREC2870003');" href="javascript://">0.54</a></span></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550690_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin_bg">1.5</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="HROUH2870003" onmouseover="iornameMouseOver(this.id);"><a title="小" onclick="parent.mem_order.betOrder('FT','HROU','gid=2870003&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50690&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HROUH&amp;wtype=HROU','HROUH2870003');" href="javascript://">0.58</a></span></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550690" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" id="love08-2550690_none"></span><span title="赛事收藏" class="bet_game_star_out" id="love08-2550690" style="display: none;" onclick="addShowLoveI('50690','08-25<br>09:00p','厄瓜多尔甲组联赛','库恩卡','福尔扎阿玛利拉','1786485');"></span></span></div></td>
    <td class="bet_text"><span class="bet_text_color" id="RMN2870002" onmouseover="iornameMouseOver(this.id);"><a title="和" onclick="parent.mem_order.betOrder('FT','RM','gid=2870002&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=50689&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=RMN&amp;wtype=RM','RMN2870002');" href="javascript://">6.40</a></span></td>
    <td colspan="3"><span class="bet_more_btn" onclick="show_allbets('2870002',event,'',12);">所有玩法&nbsp;&nbsp;<tt>40</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550690_text_1"><span class="bet_bg_color" id="HRMN2870003"><a title="和" onclick="parent.mem_order.betOrder('FT','HRM','gid=2870003&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=N&amp;gnum=50689&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HRMN&amp;wtype=HRM','HRMN2870003');" href="javascript://">7.30</a></span></td>
    <td class="bet_td_bg" id="TR2_08-2550690_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550690_text_3"><span title="可以观看在线直播" class="bet_TV_btn_on" onclick="OpenLive('8DBCB6CCB7CCBABCBBBCB8CCB7CCB38AC7CBC9C7C8CECBA9B3','FT')" span="" <=""></span></td>
</tr>



<!--SHOW LEGUAGE START-->
<tr class="bet_game_league" id="LEG_08-2550692" style="display: none;">
    <td onclick="showLeg('厄瓜多尔甲组联赛')" colspan="9">厄瓜多尔甲组联赛</td>
</tr>
<!--SHOW LEGUAGE END-->
<tr class="bet_game_tr_top_color" id="TR_08-2550692" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_game_time" rowspan="2"><div class="bet_time_score"></div><div></div><div class="bet_game_n" style="display: none;"></div></td>
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">库恩卡&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_H*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">0.5</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REH2870004"><a title="库恩卡" onclick="parent.mem_order.betOrder('FT','RE','gid=2870004&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50692&amp;strong=H&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REH&amp;wtype=RE','REH2870004');" href="javascript://">0.77</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin">2.5 / 3</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="ROUC2870004" onmouseover="iornameMouseOver(this.id);"><a title="大" onclick="parent.mem_order.betOrder('FT','ROU','gid=2870004&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50691&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUC&amp;wtype=ROU','ROUC2870004');" href="javascript://">0.93</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR_08-2550692_text_1"></td>
    <td class="bet_text_bg" id="TR_08-2550692_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">0</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="HREH2870005"><a title="库恩卡" onclick="parent.mem_order.betOrder('FT','HRE','gid=2870005&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50692&amp;strong=H&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HREH&amp;wtype=HRE','HREH2870005');" href="javascript://">0.34</a></span></span></div></td>
    <td class="bet_text_right_bg" id="TR_08-2550692_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">大</tt><tt class="bet_text_thin_bg">1.5 / 2</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="HROUC2870005"><a title="大" onclick="parent.mem_order.betOrder('FT','HROU','gid=2870005&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50691&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HROUC&amp;wtype=HROU','HROUC2870005');" href="javascript://">1.78</a></span></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR1_08-2550692" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);"><div class="bet_team_div_ft"><span class="bet_text_tdl">福尔扎阿玛利拉&nbsp;</span><span class="bet_text_tdred"><span class="bet_red_card" style="display: none;">*REDCARD_C*</span></span></div></td>
    <td class="bet_text"></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="REC2870004"><a title="福尔扎阿玛利拉" onclick="parent.mem_order.betOrder('FT','RE','gid=2870004&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50691&amp;strong=H&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=REC&amp;wtype=RE','REC2870004');" href="javascript://">1.03</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin">2.5 / 3</tt></span><span class="bet_text_tdr"><span class="bet_text_color" id="ROUH2870004" onmouseover="iornameMouseOver(this.id);"><a title="小" onclick="parent.mem_order.betOrder('FT','ROU','gid=2870004&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50692&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=ROUH&amp;wtype=ROU','ROUH2870004');" href="javascript://">0.85</a></span></span></div></td>
    <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue"></tt></span><span class="bet_text_tdr"></span></div></td>
    <td class="bet_text_left_bg" id="TR1_08-2550692_text_1"></td>
    <td class="bet_text_bg" id="TR1_08-2550692_text_2"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg"></tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="HREC2870005"><a title="福尔扎阿玛利拉" onclick="parent.mem_order.betOrder('FT','HRE','gid=2870005&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=C&amp;gnum=50691&amp;strong=H&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HREC&amp;wtype=HRE','HREC2870005');" href="javascript://">1.92</a></span></span></div></td>
    <td class="bet_text_right_bg" id="TR1_08-2550692_text_3"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">小</tt><tt class="bet_text_thin_bg">1.5 / 2</tt></span><span class="bet_text_tdr"><span class="bet_bg_color" id="HROUH2870005"><a title="小" onclick="parent.mem_order.betOrder('FT','HROU','gid=2870005&amp;uid=ihf638w8m16617016l2680780&amp;odd_f_type=H&amp;type=H&amp;gnum=50692&amp;langx=zh-cn&amp;ptype=&amp;imp=N&amp;rtype=HROUH&amp;wtype=HROU','HROUH2870005');" href="javascript://">0.36</a></span></span></div></td>
</tr>

<tr class="bet_game_tr_other" id="TR2_08-2550692_sub" style="display: none;" onmouseover="mouseEnter_pointer(this.id);" onmouseout="mouseOut_pointer(this.id);">
    <td class="bet_team"><div class="bet_text_table_star"><span class="bet_text_tdl">和局</span><span class="bet_text_tdstar"><span class="bet_game_star_none" style="display: none;"></span><span></span></span></div></td>
    <td class="bet_text"></td>
    <td colspan="3"><span class="bet_more_btn" style="display: none;">所有玩法&nbsp;&nbsp;<tt>0</tt></span></td>
    <td class="bet_text_left_bg" id="TR2_08-2550692_text_1"></td>
    <td class="bet_td_bg" id="TR2_08-2550692_text_2"></td>
    <td class="bet_td_bg" id="TR2_08-2550692_text_3"><span title="可以观看在线直播" span="" <=""></span></td>
</tr>
