<?
include "../../include/library.mem.php";
require ("../../include/config.inc.php");
require ("../../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$gtype = !empty($_REQUEST['game_type'])?$_REQUEST['game_type']:'FT';
$game_date = !empty($_REQUEST['list_date'])?$_REQUEST['list_date']:date('Y-m-d',time());
$gid = !empty($_REQUEST['game_id'])?$_REQUEST['game_id']:0;

//$langx=$row['language'];
require ("../../include/traditional.$langx.inc.php");
$fromName = 'foot_match';
switch($gtype){
    case 'BK':
        $fromName = 'bask_match';
        break;
    case 'BS':
        $fromName = 'baseball';
        break;
    case 'OP':
        $fromName = 'other_play';
        break;
    case 'TN':
        $fromName = 'tennis';
        break;
    case 'VB':
        $fromName = 'volleyball';
        break;
}

$sql = "select MID,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB,$m_league as M_League,ShowType,M_Type from $fromName where mid='$gid'";


$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
    "<script>location.href ='result.php?uid=".$uid."&gtype=".$gtype."&list_date=".$game_date."&langx=".$langx."'</script>";
    exit;
}
$row = mysql_fetch_array($result);
$m_league=$row['M_League'];
$MB_Team=$row['MB_Team'];
$TG_Team=$row['TG_Team'];

$mDate=date('Y-m-d',time());


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
    <script language="javascript">
        var gtype="<?=$gtype?>";
        var game_date="<?=$game_date?>";
        var langx="<?=$langx?>";
        function init(){
        }
        function closeIframe(){
            location.href ="result.php?uid="+top.uid+"&gtype="+gtype+"&list_date="+game_date+"&langx="+langx;
        }
        function dataReload(){
            location.reload();
        }
        function goTop(){
            document.getElementById('div_result_data').scrollTop = "0";
        }
    </script>
</head>

<body onload="init()">
<div class="acc_select_bg">

    <!--right buttons-->
    <div class="acc_right_btn">
        <ul class="acc_right_ul">
            <li class="acc_right_refresh" onclick = "dataReload();"><?=$refreshTime?></li>
            <li class="acc_right_close" onclick = "closeIframe();"><?=$lang_msg_close?></li>
            <li class="acc_right_top" onclick = "goTop();"><tt><?=$lea_back_top?></tt></li>
        </ul>
    </div>
    <!--right buttons-->

    <div id="div_result_data" class="acc_select_content">
        <table class="acc_select_table" cellpadding="0" cellspacing="0" border="0">

            <tr class="acc_select_title">
                <td colspan="3">
                    <div class="acc_select_left"><?=$m_league?></div>

                    <div class="acc_select_right">
                        <span class="acc_select_close" onClick="closeIframe();"></span>
                    </div>

                </td>
            </tr>

            <tr>
                <td colspan="3" class="acc_select_text"><div class="acc_select_team"><?=$MB_Team?>   v  <?=$TG_Team?> </div><span class="acc_select_text_number">2017-08-21 00:30a</span></td>
            </tr>

            <tr class="acc_select_tr">
                <td class="acc_all_titlew"></td>
                <td class="acc_all_pointw"><?=$MB_Team?> <BR></td>
                <td class="acc_all_pointw"><?=$TG_Team?> <BR></td>
            </tr>

            <tr class="acc_cont_tr" id="TR_1_101224_2212177">
                <td class="acc_cont_name">第一节</td>
                <td>35</td>
                <td>7</td>
            </tr>

            <tr class="acc_cont_tr" id="TR_2_101224_2212177">
                <td class="acc_cont_name">第二节</td>
                <td>33</td>
                <td>7</td>
            </tr>

            <tr class="acc_cont_tr" id="TR_3_101224_2212177">
                <td class="acc_cont_name">第三节</td>
                <td>29</td>
                <td>9</td>
            </tr>

            <tr class="acc_cont_tr" id="TR_4_101224_2212177">
                <td class="acc_cont_name">第四节</td>
                <td>24</td>
                <td>11</td>
            </tr>

            <tr class="acc_cont_tr" id="TR_5_101224_2212177">
                <td class="acc_cont_name">上半场</td>
                <td>68</td>
                <td>14</td>
            </tr>

            <tr class="acc_cont_tr" id="TR_6_101224_2212177">
                <td class="acc_cont_name">下半场</td>
                <td>53</td>
                <td>20</td>
            </tr>

            <tr class="acc_cont_tr" id="TR_7_101224_2212177">
                <td class="acc_cont_name">加时</td>
                <td>-</td>
                <td>-</td>
            </tr>

            <tr class="acc_cont_tr" id="TR_8_101224_2212177">
                <td class="acc_cont_name">全场</td>
                <td class="acc_cont_bold">121</td>
                <td class="">34</td>
            </tr>

        </table>

    </div>

</div>
</body>
</html>