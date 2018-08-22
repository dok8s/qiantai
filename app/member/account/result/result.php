<?
include "../../include/library.mem.php";
require ("../../include/config.inc.php");
require ("../../include/define_function_list.inc.php");
require ("../../include/http.class.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$mtype=$_REQUEST['mtype'];
$gtype=$_REQUEST['game_type'];
$game_date = $list_date=$_REQUEST['list_date'];
$row = mysql_fetch_array($result);
// $langx=$_REQUEST['langx'];
require ("../../include/traditional.$langx.inc.php");
if($game_date == ''){
	$game_date = date('Y-m-d');
}

$q_game_date = date('Y-m-d',strtotime($game_date)-24*60*60);
$h_game_date = date('Y-m-d',strtotime($game_date)+24*60*60);

$mDate=date('m-d',strtotime($game_date));

$memname=$row['memname'];
//userlog($memname);
if ($list_date==""){
	$today=$_REQUEST['today'];
	if (empty($today)){
		$today=date("Y-m-d");
		$tomorrow="";
		$lastday=date("Y-m-d",mktime (0,0,0,date("m"),date("d")-1,date("Y")));
	}else{
		$date_list_1=explode("-",$today);
		$d1=mktime(0,0,0,$date_list_1[1],$date_list_1[2],$date_list_1[0]);
		$tomorrow=date('Y-m-d',$d1+24*60*60);
		$lastday=date('Y-m-d',$d1-24*60*60);

		if ($today>=date('Y-m-d')){
			$tomorrow='';
		}
	}
	$list_date=$today;
}else{
	$today = $list_date;
	$date_list=mktime(0,0,0,substr($list_date,5,2),substr($list_date,8,2),substr($list_date,0,4));
	$tomorrow = date("Y-m-d",mktime (0,0,0,date("m",$date_list),date("d",$date_list)+1,date("Y",$date_list)));
	$lastday  = date("Y-m-d",mktime (0,0,0,date("m",$date_list),date("d",$date_list)-1,date("Y",$date_list)));
	if (strcmp($tomorrow,date("Y-m-d"))>0){
		$tomorrow="";
	}
}

if($gtype == 'NFS' || $gtype == 'FI')
{

	$yesterday='<a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&today='.$lastday.'&uid='.$uid.'&langx='.$langx.'">'.$res_yestoday.'</a>';
	if (!empty($tomorrow)){
		$tomorrow='  / <a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&today='.$tomorrow.'&uid='.$uid.'&langx='.$langx.'">'.$res_tommrow.'</a>';
	}
}
else
{
	$yesterday='<a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&list_date='.$lastday.'&uid='.$uid.'&langx='.$langx.'">'.$res_yestoday.'</a>';
	if (!empty($tomorrow)){
		$tomorrow='  / <a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&list_date='.$tomorrow.'&uid='.$uid.'&langx='.$langx.'">'.$res_tommrow.'</a>';
	}

}

$date_search=$yesterday.$tomorrow;
$mysql = "select * from web_system";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
switch($langx){
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		break;
	case "zh-tw":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		break;
}
$base_url = "".$site."/app/member/FT_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=$mtype";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);

if ($gtype == 'NFS' || $gtype == 'FI') {
	$filename = "" . $site . "/app/member/result/result_" . strtolower($gtype) . ".php?game_type=$gtype&today=$today&uid=$suid&langx=$langx";
} else if($gtype=='FT' || $gtype=='BK' || $gtype=='OP') {
	$filename="".$site."/app/member/result/result.php?game_type=$gtype&list_date=$today&uid=$suid&langx=$langx";
} else {
	$gtype1 = strtolower($gtype);
	$filename = "" . $site . "/app/member/result/result_" . $gtype1 . ".php?game_type=$gtype&list_date=$today&uid=$suid&langx=$langx";
}
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
preg_match_all("/Array\((.+?)\);/is",$msg,$matches);
$cou=sizeof($matches[0]);
//$chs = new Chinese("UTF8","BIG5", $mem_msg);
switch($gtype){
	case "FT":
	case "FS":
		$caption=$str_order_FT;
		$guanjun=1;
		break;
	case "BK":
		$caption=$str_order_BK;
		break;
	case "TN":
		$caption=$str_order_TN;
		break;
	case "VB":
		$caption=$str_order_VB;
		break;
	case "BS":
		$caption=$str_order_BS;
		break;
	case "OP":
		$caption=$str_order_OP;
		break;
}

$res=explode('<table border="0" cellspacing="0" cellpadding="0" class="game">',$msg);

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
	<meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
	<title>hg0088</title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/my_account.css" rel="stylesheet" type="text/css">
	<link href="/style/member/calendar.css" rel="stylesheet" type="text/css">
	<script src="/js/lib/util.js"></script>
	<script src="/js/lib/ClassFankCal_history.js"></script>
	<script src="/js/jquery-3.1.0.min.js"></script>
	<script src="/js/result.js"></script>
	<script>
		var game_type = "<?=$gtype?>";
		var chg_type = "<?=($gtype=='FS')?'Outright':'Matches';?>";
		var game_date = "<?=$game_date?>";
		var max_day ="<?=$mDate?>";
		var lasttr ='N';//最後的tr是否為藍色
	</script>
</head>
<body onload="init();">
<div id="div_state" class="acc_leftMain" >
	<!--header-->
	<div class="acc_header noFloat">
		<span class="acc_refreshBTN" onClick="reload_var();"></span>
		<h1><?=$saiguo?></h1>
	</div>
	<div class="acc_state_head">
          <span class="acc_result_ball">
                    <!--特制下拉罢--->
         <ul class="acc_selectMS">
			 <li id = "sel_gtype" onClick="showOption('gtype');" class="acc_selectMS_first" ><?=$caption?></li>
			 <ul id = "chose_gtype" class="acc_selectMS_options" style="display:none;">
				 <li id = "gtype_FT" value = "FT"><?=$str_order_FT?></li>
				 <li id="gtype_BK" value="BK" class="acc_selectBK"><?=$str_order_BK?></li>
				 <li id = "gtype_TN" value = "TN"><?=$str_order_TN?></li>
				 <li id = "gtype_VB" value = "VB"><?=$str_order_VB?></li>
<!--				 <li id = "gtype_BM" value = "BM">羽毛球</li>-->
<!--				 <li id = "gtype_TT" value = "TT">乒乓球</li>-->
				 <li id = "gtype_BS" value = "BS"><?=$str_order_BS?></li>
<!--				 <li id = "gtype_SK" value = "SK">斯诺克/台球</li>-->
				 <li id = "gtype_OP" value = "OP"><?=$str_order_OP?></li>
			 </ul>
		 </ul>
           </span>

           <span class="acc_result_small">
                    <!--特制下拉罢--->
         <ul class="acc_selectMS"><li id = "sel_type" onClick="showOption('type');" class="acc_selectMS_first">赛事</li>
			 <ul id = "chose_type" class="acc_selectMS_options" style="display:none;">
				 <li id ="Matches" value="Matches">赛事</li>
				 <? if($guanjun == 1){
					 ?>
					 <li id ="Outright" value="Outright">冠军</li>
					 <?
				 }?>
			 </ul>
			 </li></ul>
          </span>

           <span class="acc_result_small">
                    <!--特制下拉罢--->
          <span class="acc_state_title">选择日期</span>
         <ul class="acc_selectMS">
			 <li id="date_start" onClick="showDate();" class="acc_selectMS_first"><?=$game_date?></li></ul>
         </span>

		<span class="acc_previous_btn" onclick='setUrl("/app/member/account/result/result.php?game_type=<?=$gtype?>&list_date=<?=$q_game_date?>&uid=<?=$uid?>&langx=<?=$langx?>")'>前一天</span>
		<span class="acc_next_btn" onclick='setUrl("/app/member/account/result/result.php?game_type=<?=$gtype?>&list_date=<?=$h_game_date?>&uid=<?=$uid?>&langx=<?=$langx?>")'>下一天</span>
	</div>
	<?php

	?>
	<div>
		<table cellpadding="0" cellspacing="0" border="0" id="results_tableLine" class="acc_results_table">
			<tr class="acc_results_tr_title">
				<td class="acc_results_timew"></td>
				<td class="acc_results_teamw"></td>
				<?php
				switch($gtype){
					case 'FT':
					case 'BK':
					case 'BS':
					case 'SK':
					case 'OP':
						$a1 = $quanchang;
						break;
					case 'TN':
					case 'VB':
					case 'BM':
					case 'TT':
						$a1 = $wansai;
						break;
				}
				switch($gtype){
					case 'FT':
					case 'OP':
						$a2 = '上半场';
						break;
					case 'BK':
						$a2 = '加时';
						break;
					case 'BS':
						$a2 = '首5局';
						break;
					case 'SK':
						$a2 = '';
						break;
					case 'TN':
						$a2 = '让局';
						break;
					case 'VB':
					case 'BM':
					case 'TT':
						$a2 = '让分';
						break;
				}
				?>
				<td class="acc_results_otherw"><?=$a1?></td>
				<td class="acc_results_otherw"><?=$a2?></td>
				<td class="acc_results_otherw"></td>
			</tr>
			<? if ($res[2]==""){?>
		</table>
		<? } else{
			$msg='';
			$ress=explode('<!--table>',$res[2]);
			foreach($ress as $k=>$val){
				$vall=explode("<tr",$val);
				if(is_array($vall)){
					$idStr = '';
					$timeStr = '';
					$showResult = '';
					$name_H = '';
					$name_MB = '';
					$hr_H = '';
					$hr_MB = '';
					$full_H = '';
					$full_MB = '';
					foreach($vall as $key=>$vo){
						if($key == 1){
							$msg .= '<tr class="acc_results_league">';
							$id1 =  explode('S_',$vo);
							$id2 =  explode('" on',$id1[1]);
							$id3 =  explode('_',$id2[0]);
							$msg .= '<td colspan="5" id="S_'.$id2[0].'" onClick="showLEG(\''.$id3[0].'\');"><span>';
							$ms1 =  explode('leg_bar">',$vo);
							$msg .= $ms1[1];
						}elseif(($key-1)%4 == 1){
							$id1 =  explode('TR_',$vo);
							$id2 =  explode('class="time">',$id1[1]);
							$id3 =  explode('" ',$id2[0]);
							$idStr = $id3[0];
							$time1 =  explode('time">',$vo);
							$time2 =  explode('</td>',$time1[1]);
							$timeStr = $time2[0];
						}elseif(($key-1)%4 == 2){
							$showResult1 =  explode('showResult_new(',$vo);
							$showResult2 =  explode(');">',$showResult1[1]);
							$showResult = $showResult2[0];
							$name1 =  explode('</a>',$showResult2[1]);
							$name_H = $name1[0];
							$name2 =  explode('class="team_h_ft">',$name1[1]);
							$name2_1 =  explode('</td>',$name2[1]);
							$name_MB = $name2_1[0];
						}elseif(($key-1)%4 == 3){
							$hr =  explode('<span style="overflow:hidden;">',$vo);
							$hr1 =  explode('</span>',$hr[1]);
							$hr_H = $hr1[0];
							$hr2 =  explode('</span>',$hr[2]);
							$hr_MB = $hr2[0];
						}elseif(($key-1)%4 == 0){
							$full =  explode('<span style="overflow:hidden;">',$vo);
							$full1 =  explode('</span>',$full[1]);
							$full_H = $full1[0];
							$full2 =  explode('</span>',$full[2]);
							$full_MB = $full2[0];
							$msg .= '<tr class="acc_result_tr_top" id="TR_'.$idStr.'">';
							$msg .= '<td rowspan="2" class="acc_result_time">'.$timeStr.'</td>';
							$msg .= '<td class="acc_result_team">'.$name_H.'</td>';
							$msg .= '<td class="acc_result_full"><span class="acc_cont_bold">'.$hr_H.'</span></td>';
							$msg .= '<td class="acc_result_bg"><span class="acc_cont_bold">'.$full_H.'</span></td>';
							$msg .= '<td rowspan="2" class="acc_result_bg"><span class="acc_result_btn" onclick="showResult_new('.$showResult.')">所有赛果</span></td></tr>';
							$msg .= '<tr class="acc_result_tr_other" id="TR_1_'.$idStr.'">';
							$msg .= '<td class="acc_result_team">'.$name_MB.'</td>';
							$msg .= '<td class="acc_result_full"><span class="acc_cont_bold">'.$hr_MB
.'</span></td>';
							$msg .= '<td class="acc_result_bg"><span class="acc_cont_bold">'.$full_MB.'</span></td></tr>';
						}
					}
				}
			}
			echo $msg;
		}?>
	</div>
</div>
<iframe id="result_new_Data" name="result_new_Data" height="100%" frameborder="NO" border="0" framespacing="0" noresize="" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" src="" style="display:none; width:100%; z-index:999;">
</iframe>
</body>
</html>
