<?

include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];

$mDate=date('Y-m-d');
// 判断用户
$memname=IsMember($uid);

//$langx=$row['language'];
require ("../include/traditional.$langx.inc.php");

?>
<!doctype html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
    <title>hg0088</title>
    <link href="/style/member/reset.css" rel="stylesheet" type="text/css">
    <link href="/style/member/my_account.css" rel="stylesheet" type="text/css">
    <script src="/js111/lib/util.js"></script>
    <!--    <script src="/js/lib/XmlNode.js"></script>-->
    <script src="/js111/jquery-3.1.0.min.js"></script>
    <script src="/js111/account/today_wagers.js?t=7"></script>
    <script>
        //console.log(util);
    </script>
</head>
<body onload="init();">
<div class="acc_leftMain">
    <!--header-->
    <div class="acc_header noFloat">
        <!--伸缩页码-->
        <div id="acc_pg" class="acc_pageDIV"><?=$page?> <span id="now_page">1</span>/<span id="total_page">1</span>
            <div id="div_page" class="acc_pageG" style="display:none">
                <span class="acc_MINImenu_arr"></span>
                <ul id="page">
                    <li id="page_0" class="acc_pageTitle"><?=$page?></li>
                    <!--<li id="page_1" value="1" class="bet_page_contant_choose">1</li>
                    <li id="page_2" value="2">2</li>
                    <li id="page_3" value="3">3</li>-->
                </ul>
            </div>
        </div>
        <span onClick="javascript:reload_var()" class="acc_refreshBTN"></span>
        <span id="cancel_str" onClick="chgCW();"  class="acc_CancelWord"><?=$nyou?> <span id="cancel_strNUM">(0)</span> <?=$quxiao?></span>

        <h1 id="WAGERS"><?=$WagerCondition1?></h1>
    </div>


    <!--main-->
    <div id="div_nodata" >
        <table cellspacing="0" cellpadding="0" class="acc_openbetTB">
            <tr><!--客户坚持使用px宽度-->
                <th width="38"><?=$messageid?></th>
                <th width="115"><?=$zhudan1?></th>
                <th width="95"><?=$leixin?></th>
                <th width="228"><?=$xuanxiang?></th>
                <th width="84"><?=$touzhu?></th>
                <th width="83"><?=$key?></th>
                <th width="83"><?=$zhudan?></th>
            </tr>
        </table>
        <!--no data-->
        <div class="acc_noData div_none ">
            <?=$nimeizhudan?>
        </div>
        <!--has data-->
        <div class="div_show" style="display: none">
            <table id="" cellspacing="0" cellpadding="0" class="acc_openbet_totalTB">

                <!------------------------ normal model ------------------------>
				<tbody id="normal_show"></tbody>
                <!------------------------ normal model ------------------------>

                    <tr class="acc_openbet_total_top">
                        <td width="476" colspan="4" class="acc_openbet_total_txt"><?=$yemian?>:</td>
                        <td width="84" id="present_page_gold"></td>
                        <td width="166" colspan="2" id="present_total_gold"></td>
                    </tr>
                    <tr class="acc_openbet_total_bottom">
                        <td colspan="4" class="acc_openbet_total_txt"><?=$his_count?>:</td>
                        <td id="page_gold"></td>
                        <td colspan="2" id="total_gold"></td>
                    </tr>
                    <tr class="acc_openbet_page">
                        <td colspan="7"><div class="acc_openbet_pageDIV noFloat">
                                <div id="P_Page" onClick="chgPageEvent(-1)"  class="acc_openbet_pageBTN_L"><span id="preBTN" class="acc_openbet_page_preBTN"></span><span class="acc_openbet_page_txt">Trang trước</span></div>
                                <tt>|</tt>
                                <div id="N_Page" onClick="chgPageEvent(1)" class="acc_openbet_pageBTN"><span class="acc_openbet_page_txt">Trang tiếp theo</span><span id="nextBTN" class="acc_openbet_page_nextBTN"></span></div>
                            </div></td>
                    </tr>
            </table>
            <!--滑过显示时间日期-->
            <div class="acc_timeDIV" style="display:none">Ngày đặt cược: July 14, 2015 05:00</div>

            <input type="hidden" id="pending_tid" name="pending_tid" value="">
        </div>
    </div>

</div>

</body>
</html>
