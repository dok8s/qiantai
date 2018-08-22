<?php

include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$now_page = $_REQUEST['page'];
$chk_cw = !empty($_REQUEST['chk_cw'])?$_REQUEST['chk_cw']:'';

$where='';
$where1='';
$mDate=date('Y-m-d');
//判断用户登入状态
$memname=IsMemberAjax($uid);

//$langx=$row['language'];
require ("../include/traditional.$langx.inc.php");
if ($chk_cw=='Y'){
    $ncancel=" status>0 and status<>2 and status<>3 ";//and m_date='".date('Y-m-d')."'
    $caption=$guanzhu;
	$cancelwhere = " (status in(0,2,3)) and result_type=0 ";
}else{
    $ncancel=" (status in(0,2,3)) and result_type=0 ";
    $caption=$quxiao;
	$cancelwhere = " status>0 and status<>2 and status<>3 ";
}

if($langx=="zh-cn"){
    $middle="middle";
    $bettype="BetType";
    $pankou="pankou";
}
if($langx=="zh-vn"){
    $middle="middle_tw";
    $bettype="BetType_tw";
    $pankou="pankou_tw";
}
if($langx=="en-us"){
    $middle="middle_en";
    $bettype="BetType_en";
    $pankou="pankou_en";
}
$where="hidden=0 and M_Name='{$memname}' and {$ncancel}";
$sql1 = "select BetScore,Gwin from web_db_io where {$where}";

$result1 = mysql_query($sql1);
$cou1=mysql_num_rows($result1);
$total_page = (int)($cou1/$offset);
if($cou1%$offset == 0){
    $total_page = $total_page==0?1:$total_page;
}else{
    $total_page += 1;
}

$cancelwheresql ="hidden=0 and M_Name='{$memname}' and {$cancelwhere}";
$cancelSql = "select BetScore,Gwin from web_db_io where {$cancelwheresql}";

$cancelresult1 = mysql_query($cancelSql);
$cancelcou=mysql_num_rows($cancelresult1);

	$cou2 = $cancelcou;


$sql2 = "select BetScore,Gwin,sum(BetScore) as sum_betScore,sum(Gwin) as sum_gwin from web_db_io where {$where}";
$result2 = mysql_query($sql2);
$rel = mysql_fetch_array($result1);

$data = array(
    'code'=>$chk_cw,
    'page_gold'=>$rel['sum_betScore'],
    'total_gold'=>number_format($rel['sum_gwin'],2),
    'now_page'=>$now_page,
    'total_page'=>$total_page,
    'onepage'=>$offset,
    'cancel_str'=>$nyou.' <span id="cancel_strNUM">('.$cou2.')</span> '.$caption,
    'cancel_count'=>$cou1,
);
$info['info']['cancel'] = $data;

/******************************************************/

$order = 'order by orderby,id desc';
$page = ($now_page-1)*$offset;
$limit = " limit {$page},{$offset} ";

$sql = "select odd_type,status,danger,active,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,$bettype as BetType,$middle as Middle,BetScore,Gwin from web_db_io where {$where}".$order.$limit;

$result = mysql_query($sql);
$str = '';
$list = array();
$sumnum=0;
$sumbet=0;
$sumwin=0;
$m=1;
while ($row = mysql_fetch_array($result)){
    $list[$m]['ID']=$m;
    $middle=$row['Middle'];

    if($row['M_Date']>$mDate){
        //$tDate='<b>'.$row['M_Date'].'</b>';
        if (($row['LineType']<>7) && ($row['LineType']<>8) && ($row['LineType']<>17)){
            if($row['active']<>6){
                $data1=explode("<br>",$row['Middle']);
                $middle=$data1[0].'<br>';
                for($j=1;$j<sizeof($data1);$j++){
                    $middle=$middle.$data1[$j].'<br>';
                }
            }else{
                $data1=explode("<br>",$row['Middle']);

                $middle="<font color=#000000>$tDate</font>&nbsp;&nbsp;&nbsp;";
                for($j=0;$j<sizeof($data1);$j++){
                    $middle=$middle.$data1[$j].'<br>';
                }
            }
        }
        $css='_mor';
    }else{
        $css='';
    }
    $list[$m]['W_ID']=show_voucher($row['LineType'],$row['ID']);
    $dateee=explode("-",$row['BetTime']);
    $yy=explode("<br>",$dateee[1]);
    $list[$m]['ADDTIME'] = $dateee[0].'Tháng'.$yy[0].'Ngày,'.$yy[1];
    if($langx=="zh-cn"){
        $list[$m]['addtime'] = $dateee[0].'月'.$yy[0].'日,'.$yy[1];
    }
    if($langx=="zh-vn"){
        $list[$m]['addtime'] = $dateee[0].'Tháng'.$yy[0].'Ngày,'.$yy[1];
    }
    if($langx=="en-us"){
        $list[$m]['addtime'] = $dateee[0].'-'.$yy[0].' ,'.$yy[1];
    }
    $pankou=$ODDS['EE'];
    switch($row['odd_type']){
        case 'H':
            $pankou=$ODDS['HH'];
            break;
        case 'M':
            $pankou=$ODDS['MM'];
            break;
        case 'I':
            $pankou=$ODDS['II'];
            break;
        case 'E':
            $pankou=$ODDS['EE'];
            break;
    }
    $list[$m]['ODDF_TYPE'] = $pankou;
    $list[$m]['BetType'] = $row['BetType'];
    $list[$m]['middle'] = $middle;
    switch($row['danger']){
        case 1:
            $list[$m]['weixian'] = $weixian;
            $list[$m]['weixian_color'] = '#0033FF';
            break;
        case 3:
            $list[$m]['weixian'] = $weixian1;
            $list[$m]['weixian_color'] = '#009900';
            break;
        case 2:
            $list[$m]['weixian'] = $weixian2;
            $list[$m]['weixian_color'] = '#FF0000';
            break;
        default:
            break;
    }
    $list[$m]['status'] = number_format($row['BetScore'],0);
    if($row['status']>0){
        $list[$m]['status_s'] = 1;
        $list[$m]['status_j'] = $wager_vars_re[$row['status']];
    }else{
        $list[$m]['status_s'] = 0;
        $list[$m]['status_j'] = $jiesuan;
    }
    $list[$m]['BetScore'] = $row['BetScore'];
    $list[$m]['Gwin'] = number_format($row['Gwin'],2);
    $sumwin=$sumwin+$row['Gwin'];
    $sumnum=$sumnum+1;
    $sumbet=$sumbet+$row['BetScore'];
    $tDate='';
    $m++;
}


$info['info']['list'] = $list;
$info['info']['present_page_gold'] = $sumbet;
$info['info']['present_total_gold'] = $sumwin;
$info['state'] = 1;


echo json_encode($info);exit;
?>

