<?php

include "./include/library.mem.php";
require ("./include/define_function_list.inc.php");
require ("./include/config.inc.php");

$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];

$memname = IsMember($uid);
$loginname = IsMember2($uid);
//$order_money = IsMember3($uid);
require ("./include/traditional.$langx.inc.php");

switch($langx){
    case 'en-us':
        $css='_en';
        break;
    case 'zh-cn':
        $css='_cn';
        break;
    case 'zh-vn':
        $css='_en';
        break;
    default:
        $css='';
        break;
}
$Y = date('Y',time());
$M = date('m',time());
$D = date('d',time());
$H = date('H',time());
$I = date('i',time());
$toDate = date('Y-m-d h:i:s',time());
if($mtype==""){
    $mtype=3;
}
$show_url = "http://pc.1198160.com/app/member/FT_index.php?mtype=$mtype&uid=$uid&langx=$langx";
?>
<!doctype html>
<html><head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
    <title>hg0088</title>
    <link href="/style/member/reset_indexFT.css" rel="stylesheet" type="text/css">
    <link href="/style/member/header.css" rel="stylesheet" type="text/css">
    <script>
        var toDate = "<?=$toDate?>";
        top['langx'] = "<?=$langx?>";
    </script>
    <SCRIPT language="JavaScript" src="/js/header.js"></SCRIPT>
    <script src="/js/lib/XmlNode.js"></script>
    <script src="/js/lib/HttpRequestXML.js"></script>
    <script src="/js/lib/util.js"></script>
<!--    <script src="/js/initHeader.js"></script>-->
</head>

<!--<body onload="SetRB('FT','><?//=$uid?>//');onloaded();">-->
<body onLoad="onloaded()">

<div>
    <div class="head_main noFloat">

        <!--帐户区-->
        <div class="head_accDIV">

                	<span class="head_acc">
                    <span id="sel_div_acc" class="head_accBTN" onClick="showDiv('div_acc');"></span><!--将按钮图案取出-->
                    <div id="div_acc" class="head_MINImenu" onMouseLeave="hideDiv('div_acc');" style="display:none" tabindex="100">
                        <span class="head_MINImenu_arr"></span>
                        <h1>Tài khoản của tôi</h1>
                        <ul class="head_MINIul">
                            <li id="hide_balance" onClick="showDiv('div_acc');setBalanceVisible(false);" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$hidden_balance?></li>
                            <li id="show_balance" onClick="showDiv('div_acc');setBalanceVisible(true);" style="display:none;" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$display_balance?></li>
                            <li onClick="showDiv('div_acc');showMyAccount('Account');" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$pljs?></li>
                            <li onClick="showDiv('div_acc');showMyAccount('setEmail');" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$pass_recovery?> <span id="mail_status" class="head_annouTD_new"></span></li>
                            <li onClick="showDiv('div_acc');showMyAccount('ChgPass');" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$passw?></li>
                            <li onClick="logOut('/');" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$tuichu?></li>
                        </ul>
                    </div>
                	</span>

            <div class="head_cre">
                <h1 id="head_cre"><?=$loginname;?></h1><!--隐藏余额class="head_hideCre"-->
                <h2 id="credit"><?=$order_money?> <span id="credit_money">0</span></h2>
                <span class="head_refresh" onClick="reloadCrditFunction();"></span>
            </div>
        </div>

        <div class="head_Right noFloat">
            <!--功能按钮区-->
            <ul id="head_MINI" class="head_OUTmenu noFloat CN">
                <li class="head_lan no_margin" title="Chuyển đổi...">
                    <span id="sel_div_langx" class="head_lanBTN<?=$css?>" onClick="showDiv('div_langx');"></span><!--将按钮图案取出-->
                    <span class="head_lanTxt"><?=$head_lanTxt?></span>
                    <div id="div_langx" class="head_MINImenu" style="display:none" onMouseLeave="hideDiv('div_langx');" tabindex="100">
                        <span class="head_MINImenu_arr"></span>
                        <h1>Ngôn ngữ</h1>
                        <ul class="head_MINIul">
                            <li class="head_en" onClick="showDiv('div_langx');changeLangx('en-us')" onMouseOver="showOn(this);" onMouseOut="showOut(this);">English</li>
                            <li class="head_tw" onClick="showDiv('div_langx');changeLangx('zh-vn')" onMouseOver="showOn(this);" onMouseOut="showOut(this);">Người việt</li>
                            <li class="head_cn" onClick="showDiv('div_langx');changeLangx('zh-cn')" onMouseOver="showOn(this);" onMouseOut="showOut(this);">简体</li>
                            <li style="display:none" class="head_kr" onClick="showDiv('div_langx');changeLangx('ko-kr')" onMouseOver="showOn(this);" onMouseOut="showOut(this);">한국어</li>
                        </ul>
                    </div>
                </li>

                <li class="head_help" title="Trợ giúp">
                    <span id="sel_div_help" class="head_helpBTN" onClick="showDiv('div_help');"></span><!--将按钮图案取出-->
                    <div id="div_help" class="head_MINImenu" style="display:none" onmouseleave="hideDiv('div_help');" tabindex="100">
                        <span class="head_MINImenu_arr"></span>
                        <h1>Trợ giúp</h1>
                        <ul class="head_MINIul">
                            <li onClick="showDiv('div_help');showMyAccount('Rules');" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$guize?></li>
                            <li onClick="showDiv('div_help');showMyAccount('Terms');" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$rules_terms?></li>
                            <li onClick="showDiv('div_help');showMyAccount('NewFeatures');" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$new_function?></li>
                            <li onClick="showDiv('div_help');showMyAccount('OddsConversion');" onMouseOver="showOn(this);" onMouseOut="showOut(this);"><?=$calculations?></li>
                        </ul>
                    </div>
                </li>

                <li class="head_con" onClick="showDiv('');showMyAccount('Contactus');" title="<?=$lianxiz?>"></li>
                <li id="head_live" class="head_live" onClick="showDiv('');showLive();" title="<?=$nba?>"></li>

                <li id="head_ann" class="head_ann" title="<?=$gongg?>">
                	<span id="head_annBTN" class="head_annBTN" onClick="showDiv('annou');">
                    <span id="count_ann" class="head_annMINI" style="display:none;">0</span></span><!--将按钮图案取出-->
                    <span id="head_ann_arr" class="head_MINImenu_arr" style="display:none"></span>
                    <iframe id="annou" name="annou" class="head_annouDIV" style="display:none;" onmouseleave="hideDiv('annou');" src="/">

                    </iframe>
                </li>
            </ul>

            <ul class="head_Left">
			
                <li class="head_time" id="head_date" style="display: none">
                    <span id="head_year" class="head_space"><?=$Y?></span>
                    <span id="head_month" class="head_space"><?=$M?></span>
                    <span id="head_day" class="head_space"><?=$D?></span>
                    <span id="head_hour"><?=$H?></span>:<span id="head_min"><?=$I?></span>
                </li>
				<li id="" style=""><a href="<?=$show_url?>" target="_blank">Chuyển sang phiên...</a></li>
                <li id="chg_site" style=""><?=$switch_version?></li>
                <li id="btn_openbets" onClick="showMyAccount('OpenBets');"><?=$WagerCondition1?></li>
                <li id="btn_history" onClick="showMyAccount('Statement');"><?=$AccountHistory?></li>
                <li id="btn_result" onClick="showMyAccount('Results');"><?=$saiguo?></li>

            </ul>
        </div>
    </div>

    <div>
        <div id="showURL"></div>
<!--                    <iframe id="memOnline" name="memOnline" height="0" width="0" style="display:none;" src="./saved_resource(2).html"></iframe>-->
        <!--            <iframe id="reloadPHP" name="reloadPHP" width="0" height="0" style="display:none;" src="./saved_resource(3).html"></iframe>-->
        <!--            <iframe id="reloadPHP1" name="reloadPHP1" width="0" height="0" style="display:none;" src="./saved_resource(4).html"></iframe>-->
    </div>

</div>
</body>
</html>
