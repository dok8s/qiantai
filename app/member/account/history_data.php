<?
include "../include/library.mem.php";
require ("../include/define_function_list.inc.php");
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$gtype = !empty($_REQUEST['gtype'])?$_REQUEST['gtype']:'ALL';
$gdate = !empty($_REQUEST['gdate'])?$_REQUEST['gdate']:'';
$gdate1 = !empty($_REQUEST['gdate1'])?$_REQUEST['gdate1']:'';
require ("../include/traditional.$langx.inc.php");

$sumall=0;
$rsumall=0;
$sql = "select id,Memname from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
    echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
    exit;
}
if ($gtype=='' or $gtype=='ALL'){
    $gtype='ALL';
    $style='_fu';
    $active='';
}else if($gtype=='FT'){
    $style='';
    $active=' and (active=1 or active=2)';
}else{
    $style='_'.strtolower($gtype);
    switch($gtype){
        case 'BK':
            $active=' and active=3';
            break;
        case 'TN':
            $active=' and active=4';
            break;
        case 'VB':
            $active=' and active=5';
            break;
        case 'BS':
            $active=' and active=7';
            break;
        case 'FS':
            $active=' and active=6';
            break;
        case 'BM':
            $active=' and active=9';
            break;
        case 'TT':
            $active=' and active=10';
            break;
        case 'SK':
            $active=' and active=11';
            break;
        default:
            $active=' and active=8';
            break;
    }
}

$row = mysql_fetch_array($result);
$memname=$row['Memname'];
$mid=$row['id'];

if ($gdate=='' or $gdate1==''){
    $gdate1=date('Y-m-d');
    $gdate=date('Y-m-d',time()-7*24*60*60);
}
$gtime = strtotime(date('Y-m-d',time()-7*24*60*60));

$xq = array("$week7","$week1","$week2","$week3","$week4","$week5","$week6");

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
    <link href="/style/member/calendar.css" rel="stylesheet" type="text/css">
    <script src="/js/lib/util.js"></script>
    <script src="/js/lib/ClassFankCal_history.js"></script>
    <script src="/js/account/history_data.js"></script>
</head>

<body onLoad="init();">
<div id="div_state" class="acc_leftMain HIS_data" >
    <!--header-->
    <div class="acc_header noFloat"><h1><?=$AccountHistory?></h1></div>

    <form method="post" id="myform" onSubmit="return on_Submit()" style="display:none;">
        <input id="gtype" name="gtype" type="hidden"/>
        <input id="gdate" name="gdate" type="hidden"/>
        <input id="gdate1" name="gdate1" type="hidden"/>
    </form>

    <div class="acc_state_head">

        <!--特制下拉罢--->
        <span class="acc_state_title"><?=$jlu?>:</span>
        <ul class="acc_selectMS" onclick="showDiv('gtype');">
            <li id="sel_gtype" name="sel_gtype" value="ALL" class="acc_selectMS_first"></li>
            <ul id="chose_gtype" class="acc_selectMS_options">
                <li id="gtype_ALL" value="ALL"><?=$sel_all?></li>
                <li id="gtype_FT" value="FT"><?=$Soccer?></li>
                <li id="gtype_BK" value="BK" class="acc_selectBK"><?=$BasketBall."&".$mszq?></li>
                <li id="gtype_TN" value="TN"><?=$Tennis?></li>
                <li id="gtype_VB" value="VB"><?=$Voll?></li>
                <li id="gtype_BM" value="BM"><?=$ymq?></li>
                <li id="gtype_TT" value="TT"><?=$ppq?></li>
                <li id="gtype_BS" value="BS"><?=$bangqiu?></li>
                <li id="gtype_SK" value="SK"><?=$snooker?></li>
                <li id="gtype_FS" value="FS"><?=$spmatch?></li>
                <li id="gtype_OP" value="OP"><?=$qita?></li>
            </ul>
        </ul>

           <span class="acc_state_date">
                    <!--特制下拉罢--->
          <span class="acc_state_title"><?=$his_date?></span>
		         	<ul class="acc_selectMS" onClick="showDate('sel_date_s');">
                        <li id="sel_date_s" name="sel_date_s" value="<?=$gdate?>" class="acc_selectMS_first"><?=$gdate?></li>
                        <ul id="chose_date_s" class="acc_selectMS_options" style = "display:none">
                            <?php
                            for($i=0;$i<7;$i++){
                                $class = '';
                                $d=date('Y-m-d',$gtime+$i*24*60*60);
                                if(date('Y-m-d',$gtime) == $gdate){
                                    $class = " class='On'";
                                }
                                echo "<li value=\"{$d}\"{$class}>{$d} </li>";
                            }
                            ?>
                        </ul>
                    </ul>
          </span>

          <span class="acc_state_to">
                    <!--特制下拉罢--->
          <span class="acc_state_title">Để</span>
			        <ul class="acc_selectMS" onClick="showDate('sel_date_e');">
                        <li id="sel_date_e" name="sel_date_e" value="<?=$gdate1?>" class="acc_selectMS_first"><?=$gdate1?></li>
                        <ul id="chose_date_e" class="acc_selectMS_options" style = "display:none">
                            <?php
                            for($i=0;$i<7;$i++){
                                $class = '';
                                $d=date('Y-m-d',$gtime+$i*24*60*60);
                                if(date('Y-m-d',$gtime) == $gdate1){
                                    $class = " class='On'";
                                }
                                echo "<li value=\"{$d}\"{$class}>{$d} </li>";
                            }
                            ?>
                        </ul>
                    </ul>
         	</span>

        <span class="acc_ann_searchBTN" onClick="searchEvent();"><?=$tod_search?></span>
    </div>


    <div>
        <table cellpadding="0" cellspacing="0" border="0" class="acc_state_table">
            <tr class="acc_state_tr_title">
                <td class="acc_state_datew"><?=$his_date?></td>
                <td class="acc_state_otherw"><?=$his_score?></td>
                <td class="acc_state_otherw"><?=$his_have?></td>
                <td class="acc_state_otherw"><?=$his_w_l?></td>
            </tr>
            <?php
            if ($gdate>$gdate1){
                $t      = $gdate;
                $gdate  = $gdate1;
                $gdate1  = $t;
            }
            $Date_List_1=explode("-",$gdate1);
            $Date_List_2=explode("-",$gdate);
            $Date_List_3=explode("-",date('Y-m-d'));
            $d1=mktime(0,0,0,$Date_List_1[1],$Date_List_1[2],$Date_List_1[0]);
            $d2=mktime(0,0,0,$Date_List_2[1],$Date_List_2[2],$Date_List_2[0]);
            $d3=mktime(0,0,0,$Date_List_3[1],$Date_List_3[2],$Date_List_3[0]);
            if($gdate=='' && $gdate1==''){
                $days=7;
                $ff=0;
            }else{
                $days=round(($d1-$d2)/3600/24);
                $ff=0-round(($d3-$d1)/3600/24);
            }
            $ss=1;
            $aa=0;
            $bb=0;
            $vgold=0;

            for($i=$days;$i>=0;$i--)
            {
                if($ff==0){
                    $today=date("m".$his_month."d".$his_day.' ').$week.$xq[date("w",time())];
                }else{
                    $today=date("m".$his_month."d".$his_day.' ',strtotime("$ff day")).$week.$xq[date("w",date(strtotime("$ff day")))];
                }

                //$t=$d2+$i*$dd;
                //date("Y-m-d",strtotime("-1 day")),
                //$today=date('m-d ',$t).$week.$xq[date("w",$t)];
                //$sql="select middle, sum(vgold) as vgold,sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore,sum(m_result) as m_result from web_db_io where hidden=0 and result_type=1 and m_date='".date('Y-m-d',strtotime("$ff day"))."' and m_name='$memname'".$active;
                $sql="select sum(vgold) as vgold,sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore,sum(m_result) as m_result from web_db_io where hidden=0 and result_type=1 and m_date='".date('Y-m-d',strtotime("$ff day"))."' and m_name='$memname'".$active;

                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                $sum=number_format($row['betscore']+0,0);
                $middle = cp1252_utf8($row['middle']);


                $rsum=number_format($row['m_result']+0,2);
                $rsum1=number_format($row['vgold']+0,0);
                if($sum==0){$sum="-";}
                if($rsum==0){$rsum="-";}
                if($rsum1==0){$rsum1="-";}
                $aa=$aa+$row['betscore'];
                $bb=$bb+$row['m_result'];
                $vgold=$vgold+$row['vgold'];

                if($sum>0){
                    $link='<span onClick=changeUrl("'."history_view.php?uid=$uid&member_id=$mid&tmp_flag=N&today_gmt=".date('Y-m-d',strtotime("$ff day"))."&gtype=$gtype&gdate=$gdate&gdate1=$gdate1&langx=$langx".'")><strong><a href="#">'.$today.'</a></strong></span>';
                }else{
                    $link='<span >'.$today.'</span>';
                }
                if($ss%2==0){
                    $tt=2;
                }
                else{
                    $tt=1;
                }
                $his1='his_over';
                $his2='his_list';
            ?>

                <tr class="acc_state_tr_cont">
                    <td class='acc_state_leftdate'><span ><?=$link?></span></td>
                    <td class="acc_state_number"><?=$sum?></td>
                    <td class="acc_state_number"><?=$rsum1?></td>
                    <td><span class='acc_state_bold'><?=$rsum?></span></td>
                </tr>
            <?php
                $sum=0;
                $rsum1=0;
                $rsum=0;
                $ss=$ss+1;
                $ff=$ff-1;
            }
            ?>

            <tr class="acc_state_tr_total">
                <td class="acc_state_total_color"><?=$his_count?>:</td>
                <td><?=number_format($aa,0)?></td>
                <td><?=number_format($vgold,0)?></td>
                <td><?=number_format($bb,0)?></td>
            </tr>

        </table>
    </div>


</div>
</body>
</html>

