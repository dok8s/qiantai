<?
include "../include/library.mem.php";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$w_m_rate=$_REQUEST['w_m_rate'];
$active=$_REQUEST['active'];
$gold=$_REQUEST['gold'];
$line=$_REQUEST['line_type'];
$gwin=$_REQUEST['gwin'];


$wagerDatas			=	$_REQUEST['wagerDatas'];

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$memrow = mysql_fetch_array($result);
$langx=$memrow['language'];
$pay_type=$memrow['pay_type'];

order_accept($uid,$dbname);
//if($accept==1 && $not_active==1){
//	wager_order($uid,$langx);
//	exit;
//}
require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");
$odd_f_type=$_REQUEST['odd_f_type'];
$odd_type=$_REQUEST['odd_f_type'];

$memname		=	$memrow['Memname'];
$hmoney		=	$memrow['Money'];
$world			=	$memrow['world'];
$corprator		=	$memrow['corprator'];
$super			=	$memrow['super'];
$hidden		=	$memrow['hidden'];
$w_ratio		=	$memrow['ratio'];
$w_current		=	$memrow['CurType'];
$GMAX_SINGLE		=	$memrow['OP_PC_Scene'];
$GSINGLE_CREDIT	=	$memrow['OP_PC_Bet'];
$tmp=1;
$OpenType		=	$memrow['OpenType'];
$result		=	mysql_db_query($dbname,$mysql);
$havemoney		=	$hmoney-$gold;
$agid			=	$memrow['Agents'];
$count=0;
$havemoney=$hmoney-$gold;
$ShowType='';
$tmp=1;
$data=explode('|',$wagerDatas);
//userlog($memname);

	if ($hmoney < $gold){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}


	if ($gold > $GMAX_SINGLE){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}

	if ($gold > $GSINGLE_CREDIT){ 
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
	
	//串下注总额
	for($i=0;$i<count($data)-1;$i++){
		$data1 = explode(',',$data[$i]);
		$ggid .= $data1[0].",";
	}
	$ggid = substr($ggid,0,-1);

	$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and MID = '$ggid' and linetype=17 and active<3";

	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$score=$haverow['BetScore']+0;

	if ($gold + $score > $GMAX_SINGLE){
		wager_SingleMax($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}

for($i=0;$i<count($data)-1;$i++){
	$data1=explode(',',$data[$i]);

	$sql="select * from other_play where mid=$data1[0] and m_start>now() and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>''";
	$result = mysql_db_query($dbname,$sql);
	$cou=mysql_num_rows($result);
	
	if($cou==0){
			wager_order($uid,$langx);
			echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
			exit();
	}
	$row=mysql_fetch_array($result);
	$w_sleague=$row['M_League'];
	$w_sleague_tw=$row['M_League_tw'];
	$w_sleague_en=$row['M_League_en'];
		$s_sleague=$row[$m_league];
	

	$w_tg_team=$row['TG_Team'];
	$w_tg_team_tw=$row['TG_Team_tw'];
	$w_tg_team_en=$row['TG_Team_en'];

	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));

	$type=$data1[1];

	if($type=='' || $data1[0]=='' || $data1[5]==''){
			wager_order($uid,$langx);
			echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
			exit();
	}

	switch($type){
	case 'PRH':
		$lei_b			=	$Handicap;
		$s_m_place=$row[$mb_team];
		$w_m_place=$w_mb_team;
		$w_m_place_tw=$w_mb_team_tw;
		$w_m_place_en=$w_mb_team_en;
		$m_rate=$row["MB_LetB_Rate"]+1-0.01;
		$Mtype='R_H';
		$sign='<font class="his_con"> <span class="radio">'.$row['M_LetB'].'</span> </font>';
		$M_Letb=$row['M_LetB'];
		$mmid=$row['MB_MID'];
		$leagues='';
		break;
	case 'PRC':
		$lei_b			=	$Handicap;
		$s_m_place=$row[$tg_team];
		$w_m_place=$w_tg_team;
		$w_m_place_tw=$w_tg_team_tw;
		$w_m_place_en=$w_tg_team_en;
		$m_rate=$row["TG_LetB_Rate"]+1-0.01;
		$sign='<font class="his_con"> <span class="radio">'.$row['M_LetB'].'</span> </font>';
		$M_Letb=$row['M_LetB'];
		$Mtype='R_C';
		$mmid=$row['TG_MID'];
		$leagues='';
		break;
	case 'HPRH':
		$s_m_place=$row[$mb_team];
		$lei_b			=	$Handicap1;
		$w_m_place=$w_mb_team;
		$w_m_place_tw=$w_mb_team_tw;
		$w_m_place_en=$w_mb_team_en;
		$m_rate=$row["MB_LetB_Rate"]+1-0.01;
		$Mtype='R_H';
		$sign='<font class="his_con"> <span class="radio">'.$row['M_LetB'].'</span> </font>';
		$M_Letb=$row['M_LetB'];
		$mmid=$row['MB_MID'];
		$leagues		=	"<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>";
		break;
	case 'HPRC':
		$lei_b			=	$Handicap1;
		$s_m_place=$row[$tg_team];
		$w_m_place=$w_tg_team;
		$w_m_place_tw=$w_tg_team_tw;
		$w_m_place_en=$w_tg_team_en;
		$m_rate=$row["TG_LetB_Rate"]+1-0.01;
		$sign='<font class="his_con"> <span class="radio">'.$row['M_LetB'].'</span> </font>';
		$M_Letb=$row['M_LetB'];
		$Mtype='R_C';
		$mmid=$row['TG_MID'];
		$leagues		=	"<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>";
		break;
	case 'POUC':
		$w_m_place		=	'大'.$row["M_Dime"];
		$lei_b			=	$OverUnder;
		$w_m_place_tw	=	'大'.$row["M_Dime"];
		$w_m_place_en	=	'Over'.$row["M_Dime"];
		$s_m_place		=	$body_mb_dimes.$row["M_Dime"];
		$m_rate=$row['MB_Dime_Rate']+1-0.01;
		$M_Letb=$w_m_place_en;
		$sign='vs.';
		$Mtype='OU_C';
		$mmid=$row['MB_MID'];
		$leagues='';
		break;
	case 'POUH':
		$w_m_place		=	'小'.$row["M_Dime"];
		$w_m_place_tw	=	'小'.$row["M_Dime"];
		$w_m_place_en	=	'Under'.$row["M_Dime"];
		$s_m_place		=	$body_tg_dimes.$row["M_Dime"];
		$m_rate=$row['TG_Dime_Rate']+1-0.01;
		$Mtype='OU_H';
		$M_Letb=$w_m_place_en;
		$lei_b			=	$OverUnder;
		$sign='vs.';
		$mmid=$row['TG_MID'];
		$leagues='';
		break;
	case 'HPOUC':
		$w_m_place		=	'大'.$row["M_Dime"];
		$lei_b			=	$OverUnder1;
		$w_m_place_tw	=	'大'.$row["M_Dime"];
		$w_m_place_en	=	'Over'.$row["M_Dime"];
		$s_m_place		=	$body_mb_dimes.$row["M_Dime"];
		$m_rate=$row['MB_Dime_Rate']+1-0.01;
		$M_Letb=$w_m_place_en;
		$sign='vs.';
		$Mtype='OU_C';
		$mmid=$row['MB_MID'];
		$leagues		=	"<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>";
		break;
	case 'HPOUH':
		$w_m_place		=	'小'.$row["M_Dime"];
		$w_m_place_tw	=	'小'.$row["M_Dime"];
		$lei_b			=	$OverUnder1;
		$w_m_place_en	=	'Under'.$row["M_Dime"];
		$s_m_place		=	$body_tg_dimes.$row["M_Dime"];
		$m_rate				=	$row['TG_Dime_Rate']+1-0.01;
		$Mtype				=	'OU_H';
		$M_Letb				=	$w_m_place_en;
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	"<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>";
		break;
	case 'PO':
		$w_m_place		=	'单';
		$lei_b			=	$res_total." - ".$OddEven;
		$w_m_place_tw	=	'單';
		$w_m_place_en	=	'Odd';
		$s_m_place		=	$Odd1;
		$m_rate				=	$row['S_Single'];
		$Mtype				=	'OE_ODD';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['MB_MID'];
		$leagues			=	'';
		break;
	case 'PE':
		$w_m_place		=	'双';
		$w_m_place_tw	=	'雙';
		$lei_b			=	$res_total." - ".$OddEven;
		$w_m_place_en	=	'Even';
		$s_m_place		=	"$Even1";
		$m_rate				=	$row['S_Double'];
		$Mtype				=	'OE_EVEN';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "MH":
		$w_m_place		=	$row["MB_Team"];
		$lei_b			=	$res_total." - ".$win;
		$w_m_place_tw	=	$row["MB_Team_tw"];
		$w_m_place_en	=	$row["MB_Team_en"];
		$s_m_place		=	$row["$mb_team"];
		$m_rate				=	$row['MB_Win'];
		$Mtype				=	'M_H';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['MB_MID'];
		$leagues			=	'';
		break;
	case "MC":
		$w_m_place		=	$row["TG_Team"];
		$lei_b			=	$res_total." - ".$win;
		$w_m_place_tw	=	$row["TG_Team_tw"];
		$w_m_place_en	=	$row["TG_Team_en"];
		$s_m_place		=	$row["$tg_team"];
		$m_rate				=	$row['TG_Win'];
		$Mtype				=	'M_C';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "MN":
		$w_m_place		=	$heju;
		$lei_b			=	$res_total." - ".$win;
		$w_m_place_tw	=	$heju_tw;
		$w_m_place_en	=	$heji_en;
		$s_m_place		=	$Draw;
		$m_rate				=	$row['M_Flat'];
		$Mtype				=	'M_N';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "HPMH"://上半独赢
		$w_m_place		=	$row["MB_Team"];
		$lei_b			=	$res_half." - ".$win;
		$w_m_place_tw	=	$row["MB_Team_tw"];
		$w_m_place_en	=	$row["MB_Team_en"];
		$s_m_place		=	$row["$mb_team"];
		$m_rate			=	$row['MB_Win'];
		$Mtype			=	'M_H';
		$M_Letb			=	'';
		$sign			=	'vs.';
		$mmid			=	$row['MB_MID'];
		$leagues		=	"<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>";;
		break;
	case "HPMC"://上半独赢
		$w_m_place		=	$row["TG_Team"];
		$w_m_place_tw	=	$row["TG_Team_tw"];
		$w_m_place_en	=	$row["TG_Team_en"];
		$s_m_place		=	$row["$tg_team"];
		$m_rate			=	$row['TG_Win'];
		$Mtype			=	'M_C';
		$M_Letb			=	'';
		$sign			=	'vs.';
		$mmid			=	$row['TG_MID'];
		$leagues		=	"<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>";;
		break;
	case "HPMN"://上半独赢
		$w_m_place		=	$heju;
		$w_m_place_tw	=	$heju_tw;
		$w_m_place_en	=	$heji_en;
		$s_m_place		=	$Draw;
		$m_rate			=	$row['M_Flat'];
		$Mtype			=	'M_N';
		$M_Letb			=	'';
		$sign			=	'vs.';
		$mmid			=	$row['TG_MID'];
		$leagues		=	"<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>";;
		break;
	case "FHH":
		$w_m_place		=	$row["MB_Team"].' / '.$row["MB_Team"];
		$w_m_place_tw	=	$row["MB_Team_tw"].' / '.$row["MB_Team_tw"];
		$w_m_place_en	=	$row["MB_Team_en"].' / '.$row["MB_Team_en"];
		$s_m_place		=	$row["$mb_team"].' / '.$row["$mb_team"];
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$m_rate				=	$row['MBMB'];
		$Mtype				=	'F_FHH';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "FHN":
		$w_m_place		=	$row["MB_Team"].' / '.$heji;
		$w_m_place_tw	=	$row["MB_Team_tw"].' / '.$heju_tw;
		$w_m_place_en	=	$row["MB_Team_en"].' / '.$heju_en;
		$s_m_place		=	$row["$mb_team"].' / '."$Draw";
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$m_rate				=	$row['MBFT'];
		$Mtype				=	'F_FHN';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "FHC":
		$w_m_place		=	$row["MB_Team"].' / '.$row["TG_Team"];
		$w_m_place_tw	=	$row["MB_Team_tw"].' / '.$row["TG_Team_tw"];
		$w_m_place_en	=	$row["MB_Team_en"].' / '.$row["TG_Team_en"];
		$s_m_place		=	$row["$mb_team"].' / '.$row["$tg_team"];
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$m_rate				=	$row['MBTG'];
		$Mtype				=	'F_FHC';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "FNH":
		$w_m_place		=	$heju.' / '.$row["MB_Team"];
		$w_m_place_tw	=	$heju_tw.' / '.$row["MB_Team_tw"];
		$w_m_place_en	=	$heju_en.' / '.$row["MB_Team_en"];
		$s_m_place		=	$Draw.' / '.$row["$mb_team"];
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$m_rate				=	$row['FTMB'];
		$Mtype				=	'F_FNH';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "FNN":
		$w_m_place		=	$heju.' / '.$heju;
		$w_m_place_tw	=	$heju_tw.' / '.$heju_tw;
		$w_m_place_en	=	$heju_en.' / '.$heju_en;
		$s_m_place		=	$Draw.' / '.$Draw;
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$m_rate				=	$row['FTFT'];
		$Mtype				=	'F_FNN';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "FNC":
		$w_m_place		=	$heju.' / '.$row["TG_Team"];
		$w_m_place_tw	=	$heju_tw.' / '.$row["TG_Team_tw"];
		$w_m_place_en	=	$heju_en.' / '.$row["TG_Team_en"];
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$s_m_place		=	$Draw.' / '.$row["$tg_team"];
		$m_rate				=	$row['FTTG'];
		$Mtype				=	'F_FNC';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "FCH":
		$w_m_place		=	$row["TG_Team"].' / '.$row["MB_Team"];
		$w_m_place_tw	=	$row["TG_Team_tw"].' / '.$row["MB_Team_tw"];
		$w_m_place_en	=	$row["TG_Team_en"].' / '.$row["MB_Team_en"];
		$s_m_place		=	$row["$tg_team"].' / '.$row["$mb_team"];
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$m_rate				=	$row['TGMB'];
		$Mtype				=	'F_FCH';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "FCN":
		$w_m_place		=	$row["TG_Team"].' / '.$heju;
		$w_m_place_tw	=	$row["TG_Team_tw"].' / '.$heju_tw;
		$w_m_place_en	=	$row["TG_Team_en"].' / '.$heju_en;
		$s_m_place		=	$row["$tg_team"].' / '."$Draw";
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$m_rate				=	$row['TGFT'];
		$Mtype				=	'F_FCN';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "FCC":
		$w_m_place		=	$row["TG_Team"].' / '.$row["TG_Team"];
		$w_m_place_tw	=	$row["TG_Team_tw"].' / '.$row["TG_Team_tw"];
		$w_m_place_en	=	$row["TG_Team_en"].' / '.$row["TG_Team_en"];
		$s_m_place		=	$row["$tg_team"].' / '.$row["$tg_team"];
		$lei_b			=	$res_total." - ".$HalfFullTime;
		$m_rate				=	$row['TGTG'];
		$Mtype				=	'F_FCC';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "0~1":
		$w_m_place		=	'(0~1)';
		$w_m_place_tw	=	'(0~1)';
		$w_m_place_en	=	'(0~1)';
		$s_m_place		=	'(0~1)';
		$lei_b			=	$res_total." - ".$rqs;
		$m_rate				=	$row['S_0_1'];
		$Mtype				=	'T_0~1';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "2~3":
		$w_m_place		=	'(2~3)';
		$w_m_place_tw	=	'(2~3)';
		$w_m_place_en	=	'(2~3)';
		$s_m_place		=	'(2~3)';
		$lei_b			=	$res_total." - ".$rqs;
		$m_rate				=	$row['S_2_3'];
		$Mtype				=	'T_2~3';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "4~6":
		$w_m_place		=	'(4~6)';
		$w_m_place_tw	=	'(4~6)';
		$w_m_place_en	=	'(4~6)';
		$s_m_place		=	'(4~6)';
		$lei_b			=	$res_total." - ".$rqs;
		$m_rate				=	$row['S_4_6'];
		$Mtype				=	'T_4~6';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	case "OVER":
		$w_m_place		=	'(7UP)';
		$w_m_place_tw	=	'(7UP)';
		$w_m_place_en	=	'(7UP)';
		$s_m_place		=	'(7UP)';
		$lei_b			=	$res_total." - ".$rqs;
		$m_rate				=	$row['S_7UP'];
		$Mtype				=	'T_7UP';
		$M_Letb				=	'';
		$sign					=	'vs.';
		$mmid					=	$row['TG_MID'];
		$leagues			=	'';
		break;
	default:
		if(strlen($type)==4 || $type=='OVH'){
			if ($type=="OVH"){
				$team		=	"vs.";
				$ratio	=	"OVMB";
				$w_m_place		=	$qitabifen;
				$w_m_place_tw	=	$qitabifen_tw;
				$w_m_place_en	=	$qitabifen_en;
				$s_m_place		=	$pdscore;
				$Mtype				=	'PD_OVH';
			}else{
				$team_s	=	"''";
				$M_Sign=$type;
				$M_Sign=str_replace("H","(",$M_Sign);
				$M_Sign=str_replace("C",":",$M_Sign);
				$team=$M_Sign.")";
				$M_Rate=str_replace("H","MB",$type);
				$M_Rate=str_replace("C","TG",$M_Rate);
				$ratio=$M_Rate;
				$w_m_place		=	'';
				$w_m_place_tw	=	'';
				$w_m_place_en	=	'';
				$s_m_place		=	'';
				$Mtype				=	'PD_'.$M_Rate;				
			}
			$lei_b			=	$res_total." - ".$Correctscore;
			$m_rate				=	$row["$ratio"];
			$Mtype				=	'PD_'.$M_Rate;
			$M_Letb				=	'';
			$sign					=	$team;
			$mmid					=	$row['TG_MID'];
			$leagues			=	'';
			break;
		}else if(strlen($type)==5 || $type=='HOVH'){
			$type=substr($type,1,strlen($type));
			
			if ($type=="OVH"){
				$team		=	"vs.";
				$ratio	=	"OVMB";
				$w_m_place		=	$qitabifen;
				$w_m_place_tw	=	$qitabifen_tw;
				$w_m_place_en	=	$qitabifen_en;
				$s_m_place		=	$pdscore;
				$Mtype				=	'PD_OVH';
			}else{
				$team_s	=	"''";
				$M_Sign=$type;
				$M_Sign=str_replace("H","(",$M_Sign);
				$M_Sign=str_replace("C",":",$M_Sign);
				$team=$M_Sign.")";
				$M_Rate=str_replace("H","MB",$type);
				$M_Rate=str_replace("C","TG",$M_Rate);
				$ratio=$M_Rate;
				$w_m_place		=	'';
				$w_m_place_tw	=	'';
				$w_m_place_en	=	'';
				$s_m_place		=	'';	
				$Mtype				=	'PD_'.$M_Rate;			
			}

			$m_rate				=	$row["$ratio"];
			$lei_b			=	$res_half." - ".$Correctscore;
			$M_Letb				=	'';
			$sign					=	$team;
			$mmid					=	$row['TG_MID'];
			$leagues		=	"<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>";
		}else{
			wager_order($uid,$langx);
			echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		}
		break;
	}
	
	if ($row['ShowType']=='C' && in_array($type,array('PRH','PRC','HPRH','HPRC'))){
		$s_tg_team=$row[$mb_team];
		$s_mb_team=$row[$tg_team];
		$w_r_team=$w_mb_team;
		$w_r_team_tw=$w_mb_team_tw;
		$w_r_team_en=$w_mb_team_en;
		$w_l_team=$w_tg_team;
		$w_l_team_tw=$w_tg_team_tw;
		$w_l_team_en=$w_tg_team_en;
	}else{
		$s_mb_team=$row[$mb_team];
		$s_tg_team=$row[$tg_team];
		$w_l_team=$w_mb_team;
		$w_l_team_tw=$w_mb_team_tw;
		$w_l_team_en=$w_mb_team_en;
		$w_r_team=$w_tg_team;
		$w_r_team_tw=$w_tg_team_tw;
		$w_r_team_en=$w_tg_team_en;
	}
	$s_tg_team=filiter_team($s_tg_team);
	$s_mb_team=filiter_team($s_mb_team);
	$s_m_place=filiter_team($s_m_place);
	

	$w_r_team		=filiter_team($w_r_team);
	$w_r_team_tw	=filiter_team($w_r_team_tw);
	$w_r_team_en	=filiter_team($w_r_team_en);
	$w_l_team		=filiter_team($w_l_team);
	$w_l_team_tw	=filiter_team($w_l_team_tw);
	$w_l_team_en	=filiter_team($w_l_team_en);

	$w_m_place		=filiter_team($w_m_place);
	$w_m_place_tw	=filiter_team($w_m_place_tw);
	$w_m_place_en	=filiter_team($w_m_place_en);

	if($type=="PRH"||$type=="PRC"||$type=="HPRH"||$type=="HPRC"||$type=="POUH"||$type=="POUC"||$type=="HPOUH"||$type=="HPOUC"){
		$tmp=$tmp*($m_rate);
	}else{
		$tmp=$tmp*$m_rate;	
	}


	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	$m_date=date('Y').'-'.$row['M_Date'];

	if(empty($showType)){
		$showType=$row['ShowType'];
		$mid=$row['MID'];
		$w_m_rate=number_format($m_rate,2);
		$w_mtype=$Mtype;
		$w_mtype2=$M_Letb;
	}else{
		$showType.=','.$row['ShowType'];
		$mid=$mid.','.$row['MID'];
		$w_m_rate=$w_m_rate.','.number_format($m_rate,2);
		$w_mtype=$w_mtype.','.$Mtype;
		$w_mtype2=$w_mtype2.','.$M_Letb;
	}

	if($bet_place2<>''){
		$bet_place2=$bet_place2.'<br>';
		$bet_place2_tw=$bet_place2_tw.'<br>';
		$bet_place2_en=$bet_place2_en.'<br>';
	}

	if($leagues<>''){
		$bottom1="&nbsp;-&nbsp;<font color=gray><b>[上半]</b></font>";
		$bottom1_tw="&nbsp;-&nbsp;<font color=gray><b>[上半]</b></font>";
		$bottom1_en="&nbsp;-&nbsp;</font><font color=gray><b>[1st Half]</b></font>";
		
	}else{
		$bottom1='';	
		$bottom1_tw='';
		$bottom1_en='';
		
	}

	//防空注单
	if ($mid=='' or $w_m_rate=='' ){
		wager_order($uid,$langx);
		echo "<script language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
	
	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];
		
	$bet_place=$bet_place."<div id=TR$i><div class=leag><span class=leag_txt>".$s_sleague."</span></div>
    <div class=gametype>".$lei_b."</div>
    <div class=teamName><span class=tName>".$s_mb_team." &nbsp;".$sign."&nbsp;".$s_tg_team."</span></div>
    <div class=team id=team".$i."><em>".$s_m_place."</em><em></em> @ <strong class=light id=P".$i.">".number_format($m_rate,2)."</strong></div>
    <p class=errorP3 style=display: none></p>
  </div>";
	if( $count==count($data)-2){
	$bet_place2=$bet_place2."<div><font class=today_league>".$w_sleague."</font><br><font class=his_h>".$w_l_team."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team."</font><BR>";
	$bet_place2=$bet_place2."<FONT class=his_result>$w_m_place</FONT>$bottom1&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div>";


	$bet_place2_tw=$bet_place2_tw."<div><font class=today_league>".$w_sleague_tw."</font><br><font class=his_h>".$w_l_team_tw."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team_tw."</font><BR>";
	$bet_place2_tw=$bet_place2_tw."<FONT class=his_result>$w_m_place_tw</FONT>$bottom1_tw&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div>";

	$bet_place2_en=$bet_place2_en."<div><font class=today_league>".$w_sleague_en."</font><br><font class=his_h>".$w_l_team_en."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team_en."</font><BR>";
	$bet_place2_en=$bet_place2_en."<FONT class=his_result>$w_m_place_en</FONT>$bottom1_tw&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div>";
	
	
	}
	else{
	$bet_place2=$bet_place2."<div><font class=today_league>".$w_sleague."</font><br><font class=his_h>".$w_l_team."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team."</font><BR>";
	$bet_place2=$bet_place2."<FONT class=his_result>$w_m_place</FONT>$bottom1&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div><div class=statement_textbox2></div>";

	$bet_place2_tw=$bet_place2_tw."<div><font class=today_league>".$w_sleague_tw."</font><br><font class=his_h>".$w_l_team_tw."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team_tw."</font><BR>";
	$bet_place2_tw=$bet_place2_tw."<FONT class=his_result>$w_m_place_tw</FONT>$bottom1_tw&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div><div class=statement_textbox2></div>";

	$bet_place2_en=$bet_place2_en."<div><font class=today_league>".$w_sleague_en."</font><br><font class=his_h>".$w_l_team_en."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team_en."</font><BR>";
	$bet_place2_en=$bet_place2_en."<FONT class=his_result>$w_m_place_en</FONT>$bottom1_tw&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div><div class=statement_textbox2></div>";
	
	
	}
	
	

	$count++;
}

if($count==0 && count(explode(',',$mid))<2){
	wager_order($uid,$langx);
	exit;
}

$auth_code=md5($bet_place2_tw.$gold.$w_mtype);

$turn_rate="OP_Turn_PC";
$turn="OP_Turn_PC";
$caption=$RqggOrder;
$bettime=date('Y-m-d H:i:s');

$order='C';
$gwin=round($gold*$tmp-$gold,2);
$w_bettype1=$qitabc.$count.'串1';
$w_bettype1_tw=$qitabc.$count.'串1';
$w_bettype1_en=$qitabc.$count.'parlay1';
if ($active==2){
	$caption=$Soccer." - ".$zaopan;
	$w_bettype=$zaopanbc."<br>".$zongheguoguan;
	$w_bettype_tw=$zaopanbc_tw."<br>".$zongheguoguan_tw;
	$w_bettype_en=$zaopanbc_en."<br>".$zongheguoguan_en;
}else{
	$caption=$Soccer;
	$w_bettype=$qitabc."<br>".$zongheguoguan;
	$w_bettype_tw=$qitabc_tw."<br>".$zongheguoguan_tw;
	$w_bettype_en=$qitabc_en."<br>".$zongheguoguan_en;
}

$bet_id=strtoupper(substr(md5(time()),0,rand(17,20)));

$sql="SELECT web_member.$turn as turn,web_agents.$turn_rate as ag_turn,web_world.$turn_rate as wd_turn,web_corprator.$turn_rate AS cop_turn,web_agents.winloss_a,web_agents.winloss_s,web_agents.winloss_c FROM web_member, web_agents,web_world,web_corprator WHERE (web_member.Memname =  '$memname' and web_member.Agents=web_agents.Agname and web_member.corprator=web_corprator.agname )AND web_agents.world = web_world.Agname AND web_agents.corprator = web_corprator.Agname";

$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$turn=$row['turn']+0;
$agent_rate=$row['ag_turn']+0;
$world_rate=$row['wd_turn']+0;
$corpro_rate=$row['cop_turn']+0;
$agent_point=$row['winloss_a']+0;
$world_point=$row['winloss_s']+0;
$corpor_point=$row['winloss_c']+0;

$ip_addr = $_SERVER['REMOTE_ADDR'];

$mysql="insert into web_db_io(odd_type,wtype,auth_code,hidden,super,MID,Active,LineType,Mtype,M_Date,Middle,Middle_tw,Middle_en,M_Rate,M_Name,OpenType,BetTime,Agents,BetScore,ShowType,BetType,BetType_tw,BetType_en,M_Place,Gwin,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,betip,pay_type,corpor_turn,orderby,corpor_point,status,BetType1,BetType1_tw,BetType1_en) values ('$odd_type','PC','$auth_code','$hidden','$super','$mid','$active','17','$w_mtype','$m_date','$bet_place2','$bet_place2_tw','$bet_place2_en','$w_m_rate','$memname','$OpenType','$bettime','$agid','$gold','$showType','$w_bettype','$w_bettype_tw','$w_bettype_en','$w_mtype2','$gwin','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','0','$w_bettype1','$w_bettype1_tw','$w_bettype1_en')";

mysql_db_query($dbname,$mysql);

$oid=mysql_insert_id();
$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$ouid = $row['ID'];

$sql = "update web_member set Money=$havemoney where memname='$memname'";
mysql_db_query($dbname,$sql) or die ("操作失败!");


$betplace=$bet_place;

//$caption=$Soccer.$hungeguoguan.$xzd;


?>

<html>
<head>
<title>OP_P3_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
</head>
<body id="OFIN" class="bodyset" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$qita?> - <?=$zhgg?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=show_voucher(17,$ouid)?></div></div>
    <div class="main"><?=$betplace?>
      <div class="betdata">
          <p class="minBet"><span class="bet_txt"><?=$Xzjr?></span><?=number_format($gold)?></p>
    </div>
    </div>
  <div class="betBox"> 
  	<input type="button" name="PRINT" value="<?=$Prints?>" onClick="window.print()" class="yes">
    <input type="button" name="FINISH" value="<?=$Likai?>" onClick="parent.close_bet();" class="no">
   
  </div>
</div>
</body>
</html>
<?
//wager_finish($langx);

?>
<script>
parent.parent.header.reloadPHP1.location.href='../reloadCredit.php?uid=<?=$uid?>&langx=<?=$langx?>';
</script>

<?
mysql_close();
?>
