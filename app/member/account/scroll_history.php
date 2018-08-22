<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$select_date = !empty($_REQUEST['select_date'])?$_REQUEST['select_date']:'-4';
$fField = !empty($_REQUEST['fField'])?$_REQUEST['fField']:'';
$t_important = !empty($_REQUEST['t_important'])?$_REQUEST['t_important']:0;
$type = !empty($_REQUEST['type'])?$_REQUEST['type']:'';

// 判断用户
$memname=IsMember($uid);

//userlog($memname);
if ($langx==''){
    $langx='zh-vn';
}
require ("../include/traditional.$langx.inc.php");

$where = "where level=4 and mshow='$t_important' ";
if($select_date==='-3'){
    $ndate=date('Y-m-d');
    $where .= "and ndate='$ndate' ";
}
if($select_date==='-1'){
    $ndate=date('Y-m-d',strtotime('-1 day'));
    $where .= "and ndate='$ndate' ";
}
if($select_date==='-2'){
    $ndate=date('Y-m-d',strtotime('-1 day'));
    $where .= "and ndate<'$ndate' ";
}
if($fField){
    $fField = utf8_cp1252($fField);
    $where .= "and (message like '%".$fField."%' or message_tw like '%".$fField."%' or message_en like '%".$fField."%') ";
}

$sql="select date_format(ntime,'%y-%m-%d') as ntime,$shistory as message from web_marquee $where order by id desc limit 1,15";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);

if($type == 'scroll_count') {
    $info['state'] = 1;
    $info['info'] = $cou;
    echo json_encode($info);
    exit;
}
$class = 'acc_ann_msgRead';
$classNgO = 'acc_ann_NgO';
if($type == 'scroll_header'){
    $class = 'acc_ann_msgTXT';
    $classNgO = 'acc_ann_NgO_Header';
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
    <link href="/style/member/my_account.css" rel="stylesheet" type="text/css">
    <script src="/js/lib/util.js"></script>
    <script src="/js/account/scroll_history.js"></script>
    <script>
        var select_date='<?=$select_date?>';
        var t_page='1';
        var page_no='';
        var langx="<?=$langx?>";
        var fField="<?=$fField?>";
        var t_important ="<?=$t_important?>";
        var counts = 0;
        var scroll_id = '18642';
        var Imp_count = '0';
        var annouType = '<?=$type?>';
        var mid='16617016';
    </script>

</head>

<body onLoad="init();">
<div class="acc_leftMain">
    <!--header-->
    <div class="acc_header noFloat"><span  onClick="reload_var();" class="acc_refreshBTN"></span><h1><?=$gglan?></h1></div>

    <!--main-->
    <div class="acc_ann_DataMain">
        <!--搜寻区-->
        <?php if($type != 'scroll_header'){ ?>
        <div class="acc_searchDIV noFloat">
            <!--特制下拉罢--->
            <ul class="acc_selectSP">
                <li id="sel_type" onClick="showOption();" class="acc_selectSP_first">All</li>
                <ul id ="chose_type" class="acc_selectSP_options" style="display:none;">
                    <li id = "all" value = "-4"><?=$alldata?></li>
                    <li id = "today" value = "-3"><?=$jinri?></li>
                    <li id = "yesterday" value = "-1"><?=$zuori?></li>
                    <li id = "before" value = "-2"><?=$zuori1?></li>
                </ul>
            </ul>
            <div class="acc_ann_input"><input type="text" id="findField"/><span id="acc_ann_delBTN" class="acc_ann_delBTN" style="display:none"></span></div>
            <span id="findbutton" name="" onClick="FindNext();"  class="acc_ann_searchBTN"><?=$souxun?></span>
        </div>
        <?php } ?>
        <!--文字区-->
        <ul class="acc_ann_header noFloat">
            <li id = "Important" class="acc_ann_msgBTN" onClick="chg_important(1,'<?=$type?>')">Quan trọng</li>
            <li id = "Personal" class="acc_ann_msgBTN" onClick="chg_important(2,'<?=$type?>')">Cá nhân</li>
            <li id = "General" class="acc_ann_msgBTN" onClick="chg_important(0,'<?=$type?>')">Chung</li>
        </ul>
        <?
        if($cou) {
            ?>
            <table cellspacing="0" cellpadding="0" class="acc_ann_msgTXT">
                <?php
                $icount=1;
                while ($row = mysql_fetch_array($result)) {
                    //$message=cp1252_utf8($row['message']);
                    $message=$row['message'];
                    ?>
                    <tr style="display: ">
                        <td>
                            <h1>
                                <?=$row['ntime']?>
                                <span style="display: none" class="acc_ann_msgNew"></span>
                            </h1>
                            <h2 class="<?=$class?>"><?=$message?></h2>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                <!--tr><td id="foot"><b>&nbsp;</b></td></tr-->
            </table>
            <?php
        }else{
            ?>
            <!--無訊息-->
            <div class="<?=$classNgO?>"><?=$meixin?></div>
            <?php
        }
        mysql_close();
        ?>
    </div>
</div>

<iframe name="loadPHP" width="0" height="0"></iframe>
</body>
</html>

