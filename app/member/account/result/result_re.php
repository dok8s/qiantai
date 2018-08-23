<?
include "../../include/library.mem.php";
require ("../../include/config.inc.php");
require ("../../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$gtype = !empty($_REQUEST['game_type'])?$_REQUEST['game_type']:'FT';
$chg_type = !empty($_REQUEST['chg_type'])?$_REQUEST['chg_type']:'Matches';
$game_date = !empty($_REQUEST['list_date'])?$_REQUEST['list_date']:date('Y-m-d',time());

$q_game_date = date('Y-m-d',strtotime($game_date)-24*60*60);
$h_game_date = date('Y-m-d',strtotime($game_date)+24*60*60);

$mDate=date('m-d',strtotime($game_date));

// 判断用户
$memname=IsMember($uid);

//$langx=$row['language'];
require ("../../include/traditional.$langx.inc.php");


$sql = "select moredata,more,MID,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB,$m_league as M_League,MB_Win,TG_Win,M_Flat,MB_MID,TG_MID,ShowType,M_Type,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR,M_Start from foot_match where `m_start` < now( ) AND `m_Date`='$mDate' and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and ShowType='H' order by $m_league,M_Start,display limit 1,100;";
$result = mysql_query($sql);
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
		var chg_type = "<?=$chg_type?>";
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
			 <li id = "sel_gtype" onClick="showOption('gtype');" class="acc_selectMS_first" >Bóng đá</li>
			 <ul id = "chose_gtype" class="acc_selectMS_options" style="display:none;">
				 <li id = "gtype_FT" value = "FT">Bóng đá</li>
				 <li id="gtype_BK" value="BK" class="acc_selectBK">Bóng rổ</li>
				 <li id = "gtype_TN" value = "TN">Quần vợt</li>
				 <li id = "gtype_VB" value = "VB">Bóng chuyền</li>
				 <li id = "gtype_BM" value = "BM">Cầu lông</li>
				 <li id = "gtype_TT" value = "TT">Bóng bàn</li>
				 <li id = "gtype_BS" value = "BS">Bóng chày</li>
				 <li id = "gtype_SK" value = "SK">Bi-da / bi-a</li>
				 <li id = "gtype_OP" value = "OP">Khác</li>
			 </ul>
		 </ul>
           </span>

           <span class="acc_result_small">
                    <!--特制下拉罢--->
         <ul class="acc_selectMS"><li id = "sel_type" onClick="showOption('type');" class="acc_selectMS_first">Sự kiện</li>
			 <ul id = "chose_type" class="acc_selectMS_options" style="display:none;">
				 <li id ="Matches" value = "">Sự kiện</li>
				 <li id ="Outright" value = "FS">Quán quân</li>
			 </ul>
			 </li></ul>
          </span>

           <span class="acc_result_small">
                    <!--特制下拉罢--->
          <span class="acc_state_title">Chọn ngày</span>
         <ul class="acc_selectMS">
			 <li id="date_start" onClick="showDate();" class="acc_selectMS_first"><?=$game_date?></li></ul>
         </span>

		<span class="acc_previous_btn" onclick='setUrl("/app/member/account/result/result.php?game_type=<?=$gtype?>&chg_type=<?=$chg_type?>&list_date=<?=$q_game_date?>&uid=<?=$uid?>&langx=<?=$langx?>")'>Ngày hôm trước</span>
		<span class="acc_next_btn" onclick='setUrl("/app/member/account/result/result.php?game_type=<?=$gtype?>&chg_type=<?=$chg_type?>&list_date=<?=$h_game_date?>&uid=<?=$uid?>&langx=<?=$langx?>")'>Ngày hôm sau</span>
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
						$a2 = 'Nửa đầu';
						break;
					case 'BK':
						$a2 = 'Làm thêm giờ';
						break;
					case 'BS':
						$a2 = '5 lượt...';
						break;
					case 'SK':
						$a2 = '';
						break;
					case 'TN':
						$a2 = 'Nhường đường';
						break;
					case 'VB':
					case 'BM':
					case 'TT':
						$a2 = 'Điểm chấp';
						break;
				}
				?>
				<td class="acc_results_otherw"><?=$a1?></td>
				<td class="acc_results_otherw"><?=$a2?></td>
				<td class="acc_results_otherw"></td>
			</tr>
			<!--table>
			<!----------------------->
			<?php
			$cou=mysql_num_rows($result);
			if($cou){
				$league='';
				$m_id='';
				$icount=1;
				while ($row = mysql_fetch_array($result)) {
					$m_league=cp1252_utf8($row['M_League']);
					$MB_Team=cp1252_utf8($row['MB_Team']);
					$TG_Team=cp1252_utf8($row['TG_Team']);
					if($league != $m_league){
						$league=$m_league;
						$m_id=$row['MID'];
						?>
						<tr class="acc_results_league">
							<td colspan="5" id="S_<?=$m_id?>" onClick="showLEG('<?=$m_id?>');"><span><?=$league?></span></td>
						</tr>
						<?php
					}
					// TODO判断特殊属性
					?>
					<tr class="acc_result_tr_top TR_<?=$m_id?>">
						<td rowspan="2" class="acc_result_time">
							<?=$mDate?><br>
							<?php echo date('H:i',strtotime($row['M_Start']))?>
						</td>
						<td class="acc_result_team"><?=$MB_Team?> &nbsp;&nbsp;</td>
						<td class="acc_result_full"><span class="acc_result_post"><?php echo !$row['MB_Inball']?'Hủy bỏ':$row['MB_Inball'];?></span></td>
						<?php if($gtype != 'SK'){ ?>
							<td class="acc_result_bg"><span class="acc_result_post"><?php echo !$row['MB_Inball_HR']?'Hủy bỏ':$row['MB_Inball_HR'];?></span></td>
						<?php } ?>
						<?php if($gtype != 'OP'){ ?>
							<td rowspan="2" class="acc_result_bg">
								<span class="acc_result_btn" onclick="showResult_new('<?=$row['MID']?>','<?=$langx?>');">Tất cả kết quả</span>
							</td>
						<?php }?>
					</tr>
					<tr class="acc_result_tr_other TR_<?=$m_id?>">
						<td class="acc_result_team"><?=$TG_Team?> &nbsp;&nbsp;</td>
						<td class="acc_result_full"><span class="BlackWord"><?php echo !$row['TG_Inball']?'Hủy bỏ':$row['TG_Inball'];?></span></td>
						<td class="acc_result_bg"><span class="acc_cont_bold"><?php echo !$row['TG_Inball_HR']?'Hủy bỏ':$row['TG_Inball_HR'];?></span></td>
					</tr>
					<?php
				}
			}
			?>

			<!----------------------->
			<!--/table-->


		</table>

	</div>


</div>
<iframe id="result_new_Data" name="result_new_Data" height="100%" frameborder="NO" border="0" framespacing="0" noresize="" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" src="" style="display:none; width:100%; z-index:999;">

</iframe>
</body>
</html>
