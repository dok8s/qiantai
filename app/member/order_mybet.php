<?


include "./include/library.mem.php";

require ("./include/config.inc.php");
require ("./include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
//	echo "<script>window.open('".BROWSER_IP."','_top')<script>";
//	exit;
}
$row = mysql_fetch_array($result);
$memname=$row['Memname'];

//$langx=$row['language'];
if($langx=='zh-cn'){
    $middle="Middle";
}
if($langx=='zh-vn'){
    $middle="Middle_tw";
}
if($langx=='en-us'){
    $middle="Middle_en";
}
$mDate=date('Y-m-d');

require ("./include/traditional.$langx.inc.php");
?>
<!doctype html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
    <title>hg0088</title>
    <link href="/style/member/reset.css" rel="stylesheet" type="text/css">
    <link href="/style/member/order.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" src="/js/jquery-3.1.0.min.js"></script>
    <script>
        function loadData(){
            window.location.href=window.location;
        }
        $(function(){
            $("#un_ord_setTitle").click(function(){
                var c = $("#un_ord_setTitle").attr('class');
                if(c == 'ord_setTitle noFloat'){
                    $("#un_ord_setTitle").attr('class','ord_setTitle_off noFloat');
                    $("#un_ord_setTxT").hide();
                }else{
                    $("#un_ord_setTitle").attr('class','ord_setTitle noFloat');
                    $("#un_ord_setTxT").show();
                }
                $("#ord_setTitle").attr('class','ord_setTitle_off noFloat');
                $("#ord_setTxT").hide();
            });
            $("#ord_setTitle").click(function(){
                var c = $("#ord_setTitle").attr('class');
                if(c == 'ord_setTitle noFloat'){
                    $("#ord_setTitle").attr('class','ord_setTitle_off noFloat');
                    $("#ord_setTxT").hide();
                }else{
                    $("#ord_setTitle").attr('class','ord_setTitle noFloat');
                    $("#ord_setTxT").show();
                }
                $("#un_ord_setTitle").attr('class','ord_setTitle_off noFloat');
                $("#un_ord_setTxT").hide();
            });
        });
    </script>
</head>

<body id="OHIS"">
<div id="ord_main">
    <div class="ord_DIV">
        <!--未结算注单-->
        <div class="ord_unsetDIV">
            <?
            $sql = "select danger,mid,mtype,active,wtype,showtype,linetype,date_format(BetTime,'%m-%d %H:%i:%s') as betime,Middle,BetScore,M_Date,Gwin,M_Place,M_Rate,Active from web_db_io where hidden=0 and Middle<>'' and M_Name='$memname' and m_Date>='$mDate' and m_result='' and (linetype<>7 and linetype<>8) order by id desc limit 0,20";
            $result = mysql_db_query($dbname,$sql);
            $cou=mysql_num_rows($result);
            ?>
            <div id="un_ord_setTitle" class="ord_setTitle<?php if(!$cou)echo '_off';?> noFloat"><!--关起来class="ord_setTitle_off"-->
                <ul>
                    <li>Ghi chú chưa được...</li>
                    <li class="ord_setTitle_miniTxt">20 giao dịch</li>
                </ul>
                <!--未结算和已结算 不用秀统计量了-->
                <!--<span id="unord_setNUM" class="ord_setNUM">0</span>-->
            </div>
            <div id="un_ord_setTxT">
            <?
            if($cou){
                ?>
                <!--有单-->
                <div class="ord_setTxT">
                    <?
                    while ($row = mysql_fetch_array($result)){
                        $linetype=$row['linetype'];
                        $row['Middle']=str_replace("<b>","",$row['Middle']);
                        $row['Middle']=str_replace("</b>","",$row['Middle']);
                        $middle=explode('<br>',$row['Middle']);
                        ?>
                        <div class="ord_mybet_dangerN" onClick="loadData();">
                            <div class="ord_betSucc_general_List">
                                <ul class="ord_betArea_wordTop">
                                    <li class="dark_BrownWord">
                                        <font>
                                            <?
                                            echo trim($middle[count($middle)-2]);
                                            ?>
                                        </font><br>
                                        <?
                                        echo trim($middle[count($middle)-1]);
                                        ?>
                                    </li>
                                </ul>
                            </div>

                            <table cellspacing="0" cellpadding="0" class="ord_betSucc_TB">
                                <tr>
                                    <td width="40%">Số tiền đặt:</td>
                                    <td width="60%" class="ord_betSucc_stake Word_Paddright">RMB <?=number_format($row['BetScore'])?></td>
                                </tr>
                                <tr>
                                    <td>Số tiền trúng thầu:</td>
                                    <td class="ord_betSucc_stake Word_Paddright"><?=$row['Gwin']?></td>
                                </tr>
                            </table>
                        </div>
                        <?
                    }?>
                </div>
                <?
            }else{
                ?>
                <!--没单-->
                <div id="un_ord_noMyBet" class="ord_noMyBet">Bạn không có cược chưa...</div>
                <?
            }
            ?>
            </div>

            <!--单子钮-->
            <div id="unord_viewG" class="ord_viewG" style="display:none;" onClick="showPage('OpenBets');">
                <span class="ord_viewBTN">Xem tất cả cược chưa...</span>
            </div>
        </div>

        <!--已结算注单-->
        <div class="ord_setDIV">
            <?
            $sql = "select danger,mid,mtype,active,wtype,showtype,linetype,date_format(BetTime,'%m-%d %H:%i:%s') as betime,Middle,BetScore,M_Date,Gwin,M_Place,M_Rate,Active from web_db_io where hidden=0 and Middle<>'' and M_Name='$memname' and m_Date>='$mDate' and m_result='' and (linetype<>7 and linetype<>8) and Active=0 order by id desc limit 0,20";
            $result = mysql_db_query($dbname,$sql);
            $cou=mysql_num_rows($result);
            ?>
            <div id="ord_setTitle" class="ord_setTitle<?php if(!$cou)echo '_off';?> noFloat"><!--关起来class="ord_setTitle_off"-->
                <ul>
                    <li>Lưu ý thanh toán</li>
                    <li class="ord_setTitle_miniTxt">Hôm nay</li>
                </ul>
                <!--未结算和已结算 不用秀统计量了-->
                <!--<span id="ord_setNUM" class="ord_setNUM">0</span>-->
            </div>
            <div id="ord_setTxT">
            <?
            if($cou){
                ?>
                <!--有单-->
                <div class="ord_setTxT">
                    <?
                    while ($row = mysql_fetch_array($result)){
                        $linetype=$row['linetype'];
                        $row['Middle']=str_replace("<b>","",$row['Middle']);
                        $row['Middle']=str_replace("</b>","",$row['Middle']);
                        $middle=explode('<br>',$row['Middle']);
                        ?>
                        <div class="ord_mybet_dangerN" onClick="loadData();">
                            <div class="ord_betSucc_general_List*SP*">
                                <ul class="ord_betArea_wordTop">
                                    <!--                                    <li class="BlueWordS">*WTYPE*</li>-->
                                    <li class="dark_BrownWord *SHOWVS*">
                                        <font class="his_h">
                                            <?
                                            echo $middle[count($middle)-2];
                                            ?>
                                        </font><br>
                                        <?
                                        echo $middle[count($middle)-1];
                                        ?></li>
                                </ul>
                            </div>

                            <table cellspacing="0" cellpadding="0" class="ord_betSucc_TB">
                                <tr>
                                    <td width="40%">Số tiền đặt cược:</td>
                                    <td width="60%" class="ord_betSucc_stake Word_Paddright">RMB <?=number_format($row['BetScore'])?></td>
                                </tr>
                                <tr>
                                    <td>Số tiền trúng thầu:</td>
                                    <td class="ord_betSucc_stake Word_Paddright"><?=$row['Gwin']?></td>
                                </tr>
                            </table>
                        </div>
                        <?
                    }?>
                </div>
                <?
            }else{
                ?>
                <!--没单-->
                <div id="ord_noMyBet" class="ord_noMyBet">Bạn không có cược chưa được...</div>
                <?
            }
            ?>
            </div>

            <!--单子钮-->
            <div id="ord_viewG" class="ord_viewG" style="display:none" onClick="showPage('Statement');">
                <span class="ord_viewBTN">Xem tất cả cược đặt cược</span>
            </div>
        </div>

        <!--弹出遮罩-->
        <div id="ord_DIV_Mask" class="ord_DIV_Mask" style="display:none" onKeyPress="SumbitCheckKey(event)" tabindex="1"></div>

    </div>
    <input type="hidden" id="pending_tid" name="pending_tid" value="">
</div>
</body>
</html>
