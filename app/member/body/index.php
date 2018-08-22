<?php

include "../include/library.mem.php";
require ("../include/define_function_list.inc.php");
require ("../include/config.inc.php");

$langx=$_COOKIE['langx'];
$uid=$_COOKIE['uid_value'];
$mtype=!empty($_REQUEST['mtype'])?$_REQUEST['mtype']:2;

$gtype=!empty($_REQUEST['gtype'])?$_REQUEST['gtype']:'FT';
$rtype=!empty($_REQUEST['rtype'])?$_REQUEST['rtype']:'r';
$showType=!empty($_REQUEST['showtype'])?$_REQUEST['showtype']:'today';
// 分类类型 (1:2:3:4:5:6:7:8:9)
$sortType=!empty($_REQUEST['sortType'])?$_REQUEST['sortType']:1;
$page_no=!empty($_REQUEST['page_no'])?$_REQUEST['page_no']:1;

$memname = IsMember($uid);
require ("../include/traditional.$langx.inc.php");
$g = 'str_order_'.$gtype;
$gameName = $$g;
define('NUM_PAGE', 20);
$data=array();
$count=0;

//$showtype = !empty($_REQUEST['showtype'])?$_REQUEST['showtype']:'';
//if ($showtype=="future"){
//	$header="future";
//	$body=BROWSER_IP."/app/member/FT_future/index.php?uid=$uid&langx=$langx&mtype=$mtype";
//}else{
//	$header="";
//	$body=BROWSER_IP."/app/member/FT_browse/index.php?uid=$uid&langx=$langx&mtype=$mtype";
//}

// 显示类型 今天 早盘 综合过关 滚球 冠军
switch($showType) {
    case 'R':
        $rName = $RunningBall;
        break;
    case 'today':
        $rName = $today;
        break;
    case 'early':
        $rName = $early;
        break;
    case 'parlay':
        $rName = $parlay2;
        break;
    case 'C':
        $rName = $spmatch;
        break;
    default :
        $rName = $today;
        break;
}


?>
<!doctype html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
    <title>hg0088</title>
    <link href="/style/member/reset.css" rel="stylesheet" type="text/css">
    <link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
    <script>
        var uid='<?=$uid?>';
        var langx='<?=$langx?>';
        var mtype='<?=$mtype?>';
        var sel_gtype='<?=$gtype?>';
        var rtype='<?=$rtype?>';
        var sortType='<?=$sortType?>';
        var showtype='<?=$showType?>';
        var page_no = '<?=$page_no?>';
        var num_page = '<?=NUM_PAGE?>';
    </script>

    <script src="/js/jquery-3.1.0.min.js"></script>
    <script src="/js/body/index.js"></script>

</head>

<body id="MFT" onLoad="onLoad();" onScroll="showfixhead();" class="bet_r_FT">


<div  id="max_leg">

    <div id=fixhead_layer class="fixhead_layer">

        <div class="bet_head">

            <!--左侧按钮-->
            <div class="bet_left">

                <span id="showNull" title="Không có..." class="bet_star_btn_out"><tt class="bet_star_text">0</tt></span>
                <span id="showAll" title="Tất cả sự kiện" onClick="showAllGame('FT');" style="display:none;" class="bet_star_btn_all"><tt class="bet_star_All">Tất cả</tt><tt id="live_num_all" class="bet_star_text">0</tt></span>
                <span id="showMy" title="Sự kiện sưu..." onClick="showMyLove('FT');" style="display:none;" class="bet_star_btn_on"><tt id="live_num" class="bet_star_text">0</tt></span>


                <span id="sel_league" onClick="chg_league();" class="bet_league_btn"><tt class="bet_normal_text">Chọn giải đấu<tt id="str_num" class="bet_yellow">(Tất cả)</tt></tt></span>
                <span id="sel_Market" class="bet_view_btn" onClick="chgMarket();"><tt id="SpanMarket" class="bet_normal_text">Thị trường chính</tt></span>
                <span id="sel_filters" class="bet_Special_btn" onClick="show_filters();"><tt id="SpanFilter" class="bet_normal_text">Ẩn đặc biệt</tt><!--span class="bet_btn_rednew">新</span--></span>
                <span id="show_pg_chk" style="display:none;" class="bet_paging"><label><input id="pg_chk" onClick="clickChkbox();" type="checkbox"  class="bet_selsect_box" value="C" id="box_C"><span></span><span class="bet_more_chk">Pagination</span></label></span>
                <div id="show_pg_chk_msg" style="display:none;" class="bet_game_head_i"><div class="bet_head_i_bg"><span class="bet_head_iarrow_text">Nếu bạn cảm thấy trang đang chạy chậm, vui lòng chọn trang, <br> điều này sẽ giới hạn số lượng trò chơi được hiển thị trên mỗi trang.</span></div></div>
            </div>

            <!--右侧按钮-->
            <div class="bet_right">
         	<span id="pg_txt"  class="bet_page_btn" style="display:none;"></span>
            <span id="sel_sort"  class="bet_sort_btn">
                <tt class="bet_sort_text">Sắp</tt>
                <div id="show_sort" onmouseleave="hideDiv(this.id);" class="bet_sort_bg" style="display:none;">
                    <span class="bet_arrow"></span>
                    <span class="bet_arrow_text">Sắp xếp các kết...</span>
                    <ul id="SortSel">
                        <li id="sort_time" onClick="chgSortValue('T');" class="bet_sort_time">Sắp xếp thời gian</li>
                        <li id="sort_leg" onClick="chgSortValue('C');" class="bet_sort_comp">Liên kết sắp xếp</li>
                    </ul>
                </div>
            </span>
            <span id="sel_odd"  class="bet_odds_btn">
                <tt id="chose_odd" class="bet_normal_text">Tấm Hồng Kông</tt>
                <div id="show_odd" onmouseleave="hideDiv(this.id);" class="bet_odds_bg" style="display:none;">
                    <span class="bet_arrow"></span>
                    <span class="bet_arrow_text">Loại</span>
                    <ul id="myoddType">
                        <!--li class="bet_odds_contant">Hong Kong Odds</li>
                       <li class="bet_odds_contant">Malay Odds</li>
                       <li class="bet_odds_contant">Euro Decimal Odds</li>
                       <li class="bet_odds_contant">Indo Odds</li-->
                    </ul>
                </div>
            </span>
            <span class="bet_time_btn" onClick="javascript:refreshReload('',true)"><tt id="refreshTime" class="bet_time_text">99</tt></span>
            </div>
        </div>
        <!--Special-head-->
        <div class="bet_head_more" id="filter_div" style="display: none">

            <div class="bet_left_more">
                <label><input type="checkbox"  class="bet_selsect_box" value="C" id="box_C"><span></span><span class="bet_more_chk">Hiển thị cú...</span></label>
                <label><input type="checkbox"  class="bet_selsect_box" value="B" id="box_B"><span></span><span class="bet_more_chk">Hiển thị hình phạt</span></label>
                <span id="" class="bet_Apply_btn" onClick="set_filters();"><tt id="" class="bet_normal_text">Ứng dụng</tt></span>
            </div>

            <div class="bet_right_more">
                <!--span class="bet_cursor" onClick="set_allbox('Sel');">全选</span>
               <span>|</span>
               <span class="bet_cursor" onClick="set_allbox('Del');">全不选</span-->
            </div>

        </div>
        <!---->
    </div>
    <div id="backTOP" onClick="backtop();" class="bet_top_bg"></div>
    <div id=showtable class="showtable_normal">
        <table class="bet_game_table" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <?php
            // 加载头部
            require ("index_head.php");
            ?>
            <?php
            // 加载身体
            $reUrl = 'body_sort_'.$sortType.'.php';
            require ($reUrl);
            ?>

            <?php
                if(!$count){
            ?>
            <td colspan="20" class="bet_no_game">Không có sự kiện nào cho mặt hàng bạn đã chọn.</td>
            <?php } ?>
            </tbody></table>

        <div id="show_page_txt" class="bet_page_bot">
            <?php
            if($count > NUM_PAGE){
                $max = ceil($count/NUM_PAGE);
                ?>
                <span id="top_left" <?php if($page_no>1)echo 'onclick="clickpg(\'1\')"'?> class="bet_page_Lleft<?php if($page_no<=1)echo '_out'?>"></span>
                <span id="pg_left" <?php if($page_no>1)echo 'onclick="clickpg(\'del\')"'?> class="bet_page_left_out<?php if($page_no<=1)echo '_out'?>"></span>
                <tt id="num" class="bet_page_text"><?=$page_no?>/<?=$max?></tt>
                <span id="pg_right" <?php if($page_no>1)echo 'onclick="clickpg(\'add\')"'?> class="bet_page_right<?php if($page_no>=$max)echo '_out'?>"></span>
                <?php
            }
            ?>
        </div>
        <div id="show_page_txt" style="" class="bet_page_bot_rt">
        </div>
    </div>

    <div id="ObtData" style="display:none;">
        <xmp>
            <tr *DIS_MORE* *DIS_ALL* id="OBT_*ID_STR*">
                <td colspan='9'>
                    <div class="bet_game_more_div">
                        <table id="show_et" *DIS_ETIME* cellpadding="0" cellspacing="0" border="0" class="bet_game_more_title">
                            <tr>
                                <td class="bet_game_time"></td>
                                <td colspan="10" class="bet_team bet_more_text">Làm thêm giờ</td>
                                <td></td>
                            </tr>
                        </table>
                        <table *DIS_PD* cellpadding="0" cellspacing="0" border="0" class="bet_game_table_obt">
                            <tr class="bet_game_tr_top_obt bet_topline_none">
                                <td rowspan="3" class="bet_game_time"></td>
                                <td class="bet_team bet_more_text" *TR_EVENT*>Làn sóng</td>
                                <td class="bet_obt_pdw">1-0</td>
                                <td class="bet_obt_pdw">2-0</td>
                                <td class="bet_obt_pdw">2-1</td>
                                <td class="bet_obt_pdw">3-0</td>
                                <td class="bet_obt_pdw">3-1</td>
                                <td class="bet_obt_pdw">3-2</td>
                                <td class="bet_obt_pdw">4-0</td>
                                <td class="bet_obt_pdw">4-1</td>
                                <td class="bet_obt_pdw">4-2</td>
                                <td class="bet_obt_pdw">4-3</td>
                                <td class="bet_obt_pdw">0-0</td>
                                <td class="bet_obt_pdw">1-1</td>
                                <td class="bet_obt_pdw">2-2</td>
                                <td class="bet_obt_pdw">3-3</td>
                                <td class="bet_obt_pdw">4-4</td>
                                <td class="bet_obt_pdw">Khác</td>
                            </tr>

                            <tr class="bet_game_tr_other_obt">
                                <td class="bet_team" *TR_EVENT*>Chúa</td>
                                <td class="bet_text">*RATIO_H1C0*</td>
                                <td class="bet_text">*RATIO_H2C0*</td>
                                <td class="bet_text">*RATIO_H2C1*</td>
                                <td class="bet_text">*RATIO_H3C0*</td>
                                <td class="bet_text">*RATIO_H3C1*</td>
                                <td class="bet_text">*RATIO_H3C2*</td>
                                <td class="bet_text">*RATIO_H4C0*</td>
                                <td class="bet_text">*RATIO_H4C1*</td>
                                <td class="bet_text">*RATIO_H4C2*</td>
                                <td class="bet_text">*RATIO_H4C3*</td>
                                <td rowspan="2" class="bet_text">*RATIO_H0C0*</td>
                                <td rowspan="2" class="bet_text">*RATIO_H1C1*</td>
                                <td rowspan="2" class="bet_text">*RATIO_H2C2*</td>
                                <td rowspan="2" class="bet_text">*RATIO_H3C3*</td>
                                <td rowspan="2" class="bet_text">*RATIO_H4C4*</td>
                                <td rowspan="2" class="bet_text">*RATIO_OVH*</td>
                            </tr>

                            <tr class="bet_game_tr_other_obt">
                                <td class="bet_team" *TR_EVENT*>Khách</td>
                                <td class="bet_text">*RATIO_H0C1*</td>
                                <td class="bet_text">*RATIO_H0C2*</td>
                                <td class="bet_text">*RATIO_H1C2*</td>
                                <td class="bet_text">*RATIO_H0C3*</td>
                                <td class="bet_text">*RATIO_H1C3*</td>
                                <td class="bet_text">*RATIO_H2C3*</td>
                                <td class="bet_text">*RATIO_H0C4*</td>
                                <td class="bet_text">*RATIO_H1C4*</td>
                                <td class="bet_text">*RATIO_H2C4*</td>
                                <td class="bet_text">*RATIO_H3C4*</td>
                            </tr>
                        </table>
                        <table *DIS_T* cellpadding="0" cellspacing="0" border="0" class="bet_game_table_obt_h">
                            <tr class="bet_game_tr_top_obt">
                                <td rowspan="3" class="bet_game_time"></td>
                                <td class="bet_team bet_more_text bet_more_w" >Bóng tiên...</td>
                                <td class="bet_text bet_more_lineh"><span class="bet_more_f">Chúa</span><br>*RATIO_PGFH*</td>
                                <td class="bet_text bet_more_lineh"><span class="bet_more_f">Khách</span><br>*RATIO_PGFC*</td>
                                <td class="bet_text bet_more_lineh"><span class="bet_more_f">Không</span><br>*RATIO_PGFN*</td>
                                <td class="bet_more_brown_line"></td>
                                <td class="bet_more_title_text">Tổng số...</td>
                                <td class="bet_obt_point">0 - 1</td>
                                <td class="bet_text bet_obt_right">*RATIO_T01*</td>
                                <td class="bet_obt_point">2 - 3</td>
                                <td class="bet_text bet_obt_right">*RATIO_T23*</td>
                                <td class="bet_obt_point">4 - 6</td>
                                <td class="bet_text bet_obt_right">*RATIO_T46*</td>
                                <td class="bet_obt_point">7+</td>
                                <td class="bet_text bet_obt_right">*RATIO_OVER*</td>
                            </tr>
                        </table>


                        <table *DIS_TS* cellpadding="0" cellspacing="0" border="0" class="bet_game_table_obt_h">
                            <tr class="bet_game_tr_top_obt">
                                <td rowspan="3" class="bet_game_time"></td>
                                <td class="bet_team bet_more_text bet_more_w" *TR_EVENT*>Cả hai đội...</td>
                                <td class="bet_text bet_more_con_w"><span class="bet_more_f">Có</span>*RATIO_TSY*</td>
                                <td class="bet_text bet_more_con_w"><span class="bet_more_f">Không</span>*RATIO_TSN*</td>
                                <td class="bet_more_brown_line"></td>
                                <td class="bet_more_title_text">Zero thừa...</td>
                                <td class="bet_text bet_more_lineh_right"><span class="bet_lineh_right"><span class="bet_more_f">Chúa</span><br>*RATIO_WNH*</span></td>
                                <td class="bet_text bet_more_lineh_right"><span class="bet_lineh_right"><span class="bet_more_f">Khách</span><br>*RATIO_WNC*</span></td>
                                <td class="bet_more_brown_line"></td>
                                <td class="bet_more_title_text2">Zero thừa...</td>
                                <td class="bet_text bet_more_lineh_right"><span class="bet_lineh_right"><span class="bet_more_f">Chúa</span><br>*RATIO_CSH*</span></td>
                                <td class="bet_text bet_more_lineh_right"><span class="bet_lineh_right"><span class="bet_more_f">Khách</span><br>*RATIO_CSC*</span></td>
                            </tr>
                        </table>


                        <table *DIS_OUHO* cellpadding="0" cellspacing="0" border="0" class="bet_game_table_obt_h">
                            <tr class="bet_game_tr_top_obt">
                                <td rowspan="3" class="bet_game_time"></td>
                                <td class="bet_team bet_more_text bet_more_w" *TR_EVENT*>球队进球数 大/小<span class="bet_game_more_i"><div class="bet_more_i_bg"><span class="bet_more_iarrow"></span>
                                            <span class="bet_more_iarrow_text">预测各球队的总入球数。</span></div></span></td>
                                <td class="bet_more_text_w">主</td>
                                <td class="bet_text bet_more_lon_w"><span class="bet_text_oue">大</span><span class="bet_text_thin">*CON_OUHO*</span>*RATIO_OUHO*</td>
                                <td class="bet_text bet_more_lon_w"><span class="bet_text_oue">小</span><span class="bet_text_thin">*CON_OUHU*</span>*RATIO_OUHU*</td>
                                <td class="bet_more_brown_line"></td>
                                <td class="bet_more_text_w">客</td>
                                <td class="bet_text bet_more_lon_w"><span class="bet_text_oue">大</span><span class="bet_text_thin">*CON_OUCO*</span>*RATIO_OUCO*</td>
                                <td class="bet_text bet_more_lon_w"><span class="bet_text_oue">小</span><span class="bet_text_thin">*CON_OUCU*</span>*RATIO_OUCU*</td>
                            </tr>
                        </table>


                        <table  *DIS_MOU* cellpadding="0" cellspacing="0" border="0" class="bet_game_table_obt_h">
                            <tr class="bet_game_tr_top_obt">
                                <td rowspan="3" class="bet_game_time"></td>
                                <td class="bet_team bet_more_text bet_more_w" *TR_EVENT*>独赢 & 进球 大/小<span class="bet_game_more_i"><div class="bet_more_i_bg"><span class="bet_more_iarrow"></span>
                                            <span class="bet_more_iarrow_text">预测各球队的赛果和总入球数。</span></div></span></td>
                                <td colspan="2" class="bet_text bet_more_lineh2"><div class="bet_text_table_obt"><span class="bet_text_tdl"><span class="bet_more_f">主&nbsp;& </span><span class="bet_text_oue">大</span><span class="bet_text_thin">*CON_MOUHO*</span><br><span class="bet_more_f">主&nbsp;& </span><span class="bet_text_oue">小</span><span class="bet_text_thin">*CON_MOUHU*</span></span><span class="bet_text_tdr">*RATIO_MOUHO*<br> *RATIO_MOUHU*</span></div></td>
                                <td class="bet_more_brown_line"></td>
                                <td colspan="2" class="bet_text bet_more_lineh2"><div class="bet_text_table_obt"><span class="bet_text_tdl"><span class="bet_more_f">*DARW_STRO* </span><span class="bet_text_oue">*DARW_O*</span><span class="bet_text_thin">*CON_MOUNO*</span><br><span class="bet_more_f">*DARW_STRU* </span><span class="bet_text_oue">*DARW_U*</span><span class="bet_text_thin">*CON_MOUNU*</span></span><span class="bet_text_tdr">*RATIO_MOUNO*<br>*RATIO_MOUNU*</span></div></td>
                                <td class="bet_more_brown_line"></td>
                                <td colspan="2" class="bet_text bet_more_lineh2"><div class="bet_text_table_obt"><span class="bet_text_tdl"><span class="bet_more_f">客&nbsp;& </span><span class="bet_text_oue">大</span><span class="bet_text_thin">*CON_MOUCO*</span><br><span class="bet_more_f">客&nbsp;& </span><span class="bet_text_oue">小</span><span class="bet_text_thin">*CON_MOUCU*</span></span><span class="bet_text_tdr">*RATIO_MOUCO*<br>*RATIO_MOUCU*</span></div></td>
                            </tr>
                        </table>
                        <div class="bet_game_more_btn" *ONCLICK_MORE*>览看所有玩法</div>

                    </div>
                </td>
            </tr>
        </xmp>
    </div>

    <div id=DataTR style="display:none;">
        <xmp>
            <!--SHOW LEGUAGE START-->
            <tr *ST* *LegMark*>
                <td colspan="9" onClick="showLeg('*LEG*')">*LEG*</td>
            </tr>
            <!--SHOW LEGUAGE END-->
            <tr id="TR_*ID_STR*" *CLASS* *TR_EVENT* *TR_TOP*>
                <td rowspan="*TR_NUM*" class="bet_game_time"><div>*DATETIME*</div><div *DISPLAY_LIVE* class="bet_time_live">滚球</div><div *DISPLAY_MIDFIELD* class="bet_game_n"></div></td>
                <td class="bet_team" *TR_EVENT*><div class="bet_team_div_ft">*TEAM_H*</div></td>
                <td class="bet_text">*RATIO_MH*</td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_OUH*</tt><tt class="bet_text_thin">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_EOO*</tt></span><span class="bet_text_tdr">*RATIO_EOO*</span></div></td>
                <td id="TR_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMH*</td>
                <td id="TR_*ID_STR*_text_2"class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt  class="bet_text_thin_bg">*CON_HRH*</tt></span><span class="bet_text_tdr">*RATIO_HRH*</span></div></td>
                <td id="TR_*ID_STR*_text_3"class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_HOUH*</tt><tt  class="bet_text_thin_bg">*CON_HOUH*</tt></span><span class="bet_text_tdr">*RATIO_HOUH*</span></div></td>
            </tr>

            <tr id="TR1_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_other">
                <td class="bet_team" *TR_EVENT*>*TEAM_C*</td>
                <td class="bet_text">*RATIO_MC*</td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_OUC*</tt><tt class="bet_text_thin">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_EOE*</tt></span><span class="bet_text_tdr">*RATIO_EOE*</span></div></td>
                <td id="TR1_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMC*</td>
                <td id="TR1_*ID_STR*_text_2"class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRC*</tt></span><span class="bet_text_tdr">*RATIO_HRC*</span></div></td>
                <td id="TR1_*ID_STR*_text_3"class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_HOUC*</tt><tt class="bet_text_thin_bg">*CON_HOUC*</tt></span><span class="bet_text_tdr">*RATIO_HOUC*</span></div></td>
            </tr>

            <tr id="TR2_*ID_STR**NODARW*" *DIS_DARW* *CLASS* *TR_EVENT* class="bet_game_tr_other">
                <td class="bet_team" id="TR_*ID_STR*_1" *TR_EVENT*><div class="bet_text_table_draw"><span class="bet_text_tdl">*DRAW_STR*</span><span class="bet_text_tdstar"><span id="*MYLOVE_ID_none*" *MYLOVE_CSS_none* class="bet_game_star_none"></span><span id="*MYLOVE_ID*" *MYLOVE_CSS*></span></span></div></td>
                <td class="bet_text">*RATIO_MN*</td>
                <td colspan="3"><span style='display:*DISPLAY_MORE*' *ONCLICK_MORE* class="bet_more_btn">所有玩法&nbsp;&nbsp;<tt>*COUNT_MORE*</tt></span></td>
                <td id="TR2_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMN*</td>
                <td id="TR2_*ID_STR*_text_2"class="bet_td_bg"></td>
                <td id="TR2_*ID_STR*_text_3"class="bet_td_bg"><span title="可以观看滚球在线直播" *TV_CLASS* *TV*></span></td>
            </tr>
        </xmp>
    </div>

    <div id="subDataTR" style="display:none;">
        <xmp>
            <!--SHOW LEGUAGE START-->
            <tr *ST* *LegMark*>
                <td colspan="9" onClick="showLeg('*LEG*')">*LEG*</td>
            </tr>
            <!--子盘多玩法tr-->
            <tr id="TR_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_top">
                <td rowspan="*PTYPE_TR_NUM*" class="bet_game_time"><div>*DATETIME*</div><div *DISPLAY_LIVE* class="bet_time_live">滚球</div><div *DISPLAY_MIDFIELD* class="bet_game_n"></div></td>
                <td colspan="5" class="bet_team bet_more_text" *TR_EVENT*><div>*PTYPE*</div></td>
                <td colspan="3" id="TR_*ID_STR*_text_1"class="bet_text_left_bg"></td>
            </tr>

            <tr id="TR1_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_other">
                <td class="bet_team" *TR_EVENT*><div class="bet_team_div_ft">*TEAM_H*</div></td>
                <td class="bet_text">*RATIO_MH*</td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_OUH*</tt><tt class="bet_text_thin">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_EOO*</tt></span><span class="bet_text_tdr">*RATIO_EOO*</span></div></td>
                <td id="TR1_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMH*</td>
                <td id="TR1_*ID_STR*_text_2"class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt  class="bet_text_thin_bg">*CON_HRH*</tt></span><span class="bet_text_tdr">*RATIO_HRH*</span></div></td>
                <td id="TR1_*ID_STR*_text_3"class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_HOUH*</tt><tt  class="bet_text_thin_bg">*CON_HOUH*</tt></span><span class="bet_text_tdr">*RATIO_HOUH*</span></div></td>
            </tr>

            <tr id="TR2_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_other">
                <td class="bet_team" *TR_EVENT*>*TEAM_C*</td>
                <td class="bet_text">*RATIO_MC*</td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_OUC*</tt><tt class="bet_text_thin">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_EOE*</tt></span><span class="bet_text_tdr">*RATIO_EOE*</span></div></td>
                <td id="TR2_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMC*</td>
                <td id="TR2_*ID_STR*_text_2"class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRC*</tt></span><span class="bet_text_tdr">*RATIO_HRC*</span></div></td>
                <td id="TR2_*ID_STR*_text_3"class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_HOUC*</tt><tt class="bet_text_thin_bg">*CON_HOUC*</tt></span><span class="bet_text_tdr">*RATIO_HOUC*</span></div></td>
            </tr>

            <tr id="TR3_*ID_STR**NODARW*" *PTYPE_DIS_DARW*  *CLASS* *TR_EVENT* class="bet_game_tr_other">
                <td class="bet_team" id="TR_*ID_STR*_1" *TR_EVENT*><div class="bet_text_table_draw"><span class="bet_text_tdl">*DRAW_STR*</span><span class="bet_text_tdstar"><span id="*MYLOVE_ID_none*" *MYLOVE_CSS_none* class="bet_game_star_none"></span><span id="*MYLOVE_ID*" *MYLOVE_CSS*></span></span></div></td>
                <td class="bet_text">*RATIO_MN*</td>
                <td colspan="3"><span style='display:*DISPLAY_MORE*' *ONCLICK_MORE* class="bet_more_btn">所有玩法&nbsp;&nbsp;<tt>*COUNT_MORE*</tt></span></td>
                <td id="TR3_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMN*</td>
                <td id="TR3_*ID_STR*_text_2"class="bet_td_bg"></td>
                <td id="TR3_*ID_STR*_text_3"class="bet_td_bg"><span title="可以观看滚球在线直播" *TV_CLASS* *TV*></span></td>
            </tr>
        </xmp>
    </div>

    <div id="MtypeData" style="display:none;">
        <xmp>
            <!--SHOW LEGUAGE START-->
            <tr *ST* *LegMark*>
                <td colspan="9" onClick="showLeg('*LEG*')">*LEG*</td>
            </tr>
            <!--蓝色盘多玩法tr-->
            <tr id="TR_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_top_more">
                <td rowspan="*PTYPE_TR_NUM*" class="bet_game_time"><div>*DATETIME*</div><div *DISPLAY_LIVE* class="bet_time_live">滚球</div><div *DISPLAY_MIDFIELD* class="bet_game_n"></div></td>
                <td colspan="5" class="bet_team" *TR_EVENT*><div>*PTYPE*</div></td>
                <td colspan="3" id="TR_*ID_STR*_text_1"class="bet_text_left_bg"></td>
            </tr>

            <tr id="TR1_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_other_more">
                <td class="bet_team" *TR_EVENT*><div class="bet_team_div_ft">*TEAM_H*</div></td>
                <td class="bet_text">*RATIO_MH*</td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RH*</tt></span><span class="bet_text_tdr">*RATIO_RH*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_OUH*</tt><tt class="bet_text_thin">*CON_OUH*</tt></span><span class="bet_text_tdr">*RATIO_OUH*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_EOO*</tt></span><span class="bet_text_tdr">*RATIO_EOO*</span></div></td>
                <td id="TR1_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMH*</td>
                <td id="TR1_*ID_STR*_text_2"class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt  class="bet_text_thin_bg">*CON_HRH*</tt></span><span class="bet_text_tdr">*RATIO_HRH*</span></div></td>
                <td id="TR1_*ID_STR*_text_3"class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_HOUH*</tt><tt  class="bet_text_thin_bg">*CON_HOUH*</tt></span><span class="bet_text_tdr">*RATIO_HOUH*</span></div></td>
            </tr>

            <tr id="TR2_*ID_STR*" *CLASS* *TR_EVENT* class="bet_game_tr_other_more">
                <td class="bet_team" *TR_EVENT*>*TEAM_C*</td>
                <td class="bet_text">*RATIO_MC*</td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin">*CON_RC*</tt></span><span class="bet_text_tdr">*RATIO_RC*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_OUC*</tt><tt class="bet_text_thin">*CON_OUC*</tt></span><span class="bet_text_tdr">*RATIO_OUC*</span></div></td>
                <td class="bet_text"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_EOE*</tt></span><span class="bet_text_tdr">*RATIO_EOE*</span></div></td>
                <td id="TR2_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMC*</td>
                <td id="TR2_*ID_STR*_text_2"class="bet_text_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_thin_bg">*CON_HRC*</tt></span><span class="bet_text_tdr">*RATIO_HRC*</span></div></td>
                <td id="TR2_*ID_STR*_text_3"class="bet_text_right_bg"><div class="bet_text_table"><span class="bet_text_tdl"><tt class="bet_text_oue">*TEXT_HOUC*</tt><tt class="bet_text_thin_bg">*CON_HOUC*</tt></span><span class="bet_text_tdr">*RATIO_HOUC*</span></div></td>
            </tr>

            <tr id="TR3_*ID_STR**NODARW*" *PTYPE_DIS_DARW* *CLASS* *TR_EVENT* class="bet_game_tr_other_more">
                <td class="bet_team" id="TR_*ID_STR*_1" *TR_EVENT*><div class="bet_text_table_draw"><span class="bet_text_tdl">*DRAW_STR*</span><span class="bet_text_tdstar"><span id="*MYLOVE_ID_none*" *MYLOVE_CSS_none* class="bet_game_star_none"></span><span id="*MYLOVE_ID*" *MYLOVE_CSS*></span></span></div></td>
                <td class="bet_text">*RATIO_MN*</td>
                <td colspan="3"><span style='display:*DISPLAY_MORE*' *ONCLICK_MORE* class="bet_more_btn">所有玩法&nbsp;&nbsp;<tt>*COUNT_MORE*</tt></span></td>
                <td id="TR3_*ID_STR*_text_1"class="bet_text_left_bg">*RATIO_HMN*</td>
                <td id="TR3_*ID_STR*_text_2"class="bet_td_bg"></td>
                <td id="TR3_*ID_STR*_text_3"class="bet_td_bg"><span title="可以观看滚球在线直播" *TV_CLASS* *TV*></span></td>
            </tr>
        </xmp>
    </div>

    <div id=NoDataTR style="display:none;">
        <xmp>
            <td colspan="20" class="bet_no_game">您选择的项目暂时没有赛事。</td>
        </xmp>
    </div>

</div>

<div id="legView" style="display:none; width:100%; height:100%;" class="legView">
    <div class="leg_head" onMousedown="initializedragie('legView')"></div>
    <div style="width:100%; height:100%;"><iframe id="legFrame" frameborder="no" border="0" allowtransparency="true" scrolling="no" width=100% height=100%></iframe></div>
    <div class="leg_foot"></div>
</div>
<div class="more_iframe_w" id="more_window" name="more_window" style=" display:none;">
    <iframe id=showdata name=showdata scrolling='no' frameborder="NO" border="0" framespacing="0" noresize topmargin="0" leftmargin="0" marginwidth=0 marginheight=0  height="100%" width="100%"></iframe>
</div>

<div id="controlscroll"  style="position:absolute;">
    <table border="0" cellspacing="0" cellpadding="0" class="loadBox">
        <tr>
            <td><!--loading--></td></tr></table></div>
<!--<iframe id='body_var' name='body_var' style='display:none;'></iframe>-->

</body>
</html>
