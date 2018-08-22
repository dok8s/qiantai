<?

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/http.class.php");
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['rtype'];
$change=$_REQUEST['change'];
$wtype=$_REQUEST['wtype'];
$odd_f_type=$_REQUEST['odd_f_type'];
$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$langx=$_REQUEST['langx'];
$pay_type=$row['pay_type'];
//$body_js=getcss($langx);
require ("../include/traditional.$langx.inc.php");

	wager_danger($uid,$dbname);order_accept($uid,$dbname);
/////////////////////////////////////////////////////////////////////

	$mysql1 = "select * from web_system";
	$result1 = mysql_db_query($dbname,$mysql1);
	$row1 = mysql_fetch_array($result1);
	$mDate=date('m-d');
	switch($langx){
	case "en-us":
		$suid=$row1['uid_en'];
		$site=$row1['datasite_en'];
		break;
	case "zh-tw":
		$suid=$row1['uid_tw'];
		$site=$row1['datasite_tw'];
		break;
	default:
		$suid=$row1['uid_cn'];
		$site=$row1['datasite'];
		break;
	}
$base_url = "".$site."/app/member/FT_index.php?rtype=re&uid=$suid&mtype=3";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename="".$site."/app/member/FT_order/FT_order_single.php?gid=$gid&uid=$suid&rtype=$gtype&wtype=$wtype&odd_f_type=H&langx=$langx";


$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$msg_c=explode("@",$msg);

if(sizeof($msg_c)<2)
{
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit();
}

////////////////////////////////////////////////////////////////////
if ($change==1){
	$bet_title=$nobettitle;
}
if(substr($wtype,0,1)=="R"){
	$mysql = "select mb_ball,tg_ball,maxgold,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ior_WMH1,ior_WMC1,ior_WMH2,ior_WMC2,ior_WMH3,ior_WMC3,ior_WMHOV,ior_WMCOV,ior_WM0,ior_WMN,ior_DCHN,ior_DCCN,ior_DCHC,ior_WEH,ior_WEC,ior_WBH,ior_WBC,ior_TSY,ior_TSN,ior_CSH,ior_CSC,ior_T3G1,ior_T3G2,ior_T3GN,ior_WNH,ior_WNC,ior_SBH,ior_SBC,ior_T1G1,ior_T1G2,ior_T1G3,ior_T1G4,ior_T1G5,ior_T1G6,ior_T1GN,ior_HGH,ior_HGC,ior_MGH,ior_MGC,ior_MGN,ior_BHC,ior_BHH,ior_F2GH,ior_F2GC,ior_F3GH,ior_F3GC,ior_FGS,ior_FGH,ior_FGN,ior_FGP,ior_FGF,ior_FGO from foot_match where `MID`=$gid and cancel<>1 and fopen=1";// and now()>date_add(m_start,interval 40 second)
}else{
	$mysql = "select mb_ball,tg_ball,maxgold,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ior_WMH1,ior_WMC1,ior_WMH2,ior_WMC2,ior_WMH3,ior_WMC3,ior_WMHOV,ior_WMCOV,ior_WM0,ior_WMN,ior_DCHN,ior_DCCN,ior_DCHC,ior_WEH,ior_WEC,ior_WBH,ior_WBC,ior_TSY,ior_TSN,ior_CSH,ior_CSC,ior_T3G1,ior_T3G2,ior_T3GN,ior_WNH,ior_WNC,ior_SBH,ior_SBC,ior_T1G1,ior_T1G2,ior_T1G3,ior_T1G4,ior_T1G5,ior_T1G6,ior_T1GN,ior_HGH,ior_HGC,ior_MGH,ior_MGC,ior_MGN,ior_BHC,ior_BHH,ior_F2GH,ior_F2GC,ior_F3GH,ior_F3GC,ior_FGS,ior_FGH,ior_FGN,ior_FGP,ior_FGF,ior_FGO from foot_match where `MID`=$gid and cancel<>1 and fopen=1";// `m_start`>now() and
}

$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
//echo $mysql;
//exit;
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit;
}else{
	$memname=$row['Memname'];
	$credit=$row['Money'];
	$maxcredit=$row['Credit'];
	$ptype=$row['pay_type'];
//userlog($memname);
	$GMAX_SINGLE=$row['FT_RM_Scene'];
	$GSINGLE_CREDIT=$row['FT_RM_Bet'];

	$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and MID='$gid' and linetype=104";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);

	$btset=singleset('m');
	$GMIN_SINGLE=$btset[0];
	$maxgold=$row['maxgold'];

	if($GSINGLE_CREDIT>$maxgold){
		$bettop=$maxgold;
	}else{
		$bettop=$GSINGLE_CREDIT;
	}

	if(!$ptype){
		$gdate=date('Y-').$row['M_Date'];
		$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as gold from web_db_io where m_date='$gdate' and m_name='$memname' order by id";/*求出本日累计*/
		$result = mysql_query($sql);
		$haverow = mysql_fetch_array($result);
		$gold		=$haverow['gold']+0;
	    $credit=(($credit+$gold)<>$maxcredit)?($maxcredit-$gold):$credit;
	}
		$active=1;
		$css="OFT";
		
	$caption=$GqOrder;
	
	if ($row['M_Sleague']==''){
		$m_league=$row['M_League'];
	}
	else{
		$m_league=$row['M_Sleague'];
	}
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	$TG_Team=filiter_team($TG_Team);
	switch($wtype){
	//滚球
		case "RWM":
			$linetype=104;//净赢比数
			$name1=$shuyingbifen;
			break;
		case "RDC":
			$linetype=105;//双赢盘
			$name1=$shuangyingpan;
			break;
		case "RWE":
			$linetype=106;//赢得任一半场
			$name1=$yingderenyibanqiu;
			break;
		case "RWB":
			$linetype=107;//赢得所有半场
			$name1=$yingdesuoyoubanchang;
			break;
		case "RTS":
			$linetype=108;//双方球队进球
			$name1=$shuangfangqiudui;
			break;
		case "RCS":
			$linetype=109;//零失球
			$name1=$lingshiqiu;
			break;
		case "RT3G"://首个进球时间-三项
			$linetype=221;
			$name1=$shougejinqiushijian." - ".$sanxiang;
			break;
		case "RWN":
			$linetype=222;//零失球获胜 滚球
			$name1=$lingshiqiuhuosheng;
			break;
		case "RSB":
			$linetype=223;//双半场进球 滚球
			$name1=$shuangbanchang;
			break;
		case "RT1G":
			$linetype=204;//首个进球时间 滚球
			$name1=$shougejinqiushijian;
			break;
	//初盘
		case "WM":
			$linetype=114;//净赢比数
			$name1=$shuyingbifen;
			break;
		case "DC":
			$linetype=115;//双赢盘
			$name1=$shuangyingpan;
			break;
		case "WE":
			$linetype=116;//赢得任一半场
			$name1=$yingderenyibanqiu;
			break;
		case "WB":
			$linetype=117;//赢得所有半场
			$name1=$yingdesuoyoubanchang;
			break;
		case "TS":
			$linetype=118;//双方球队进球
			$name1=$shuangfangqiudui;
			break;
		case "CS":
			$linetype=119;//零失球
			$name1=$lingshiqiu;
			break;
		case "T3G"://首个进球时间-三项
			$linetype=211;
			$name1=$shougejinqiushijian." - ".$sanxiang;
			break;
		case "WN":
			$linetype=212;//零失球获胜
			$name1=$lingshiqiuhuosheng;
			break;
		case "SB":
			$linetype=213;//双半场进球
			$name1=$shuangbanchang;
			break;
		case "T1G":
			$linetype=214;//首个进球时间
			$name1=$shougejinqiushijian;
			break;
		case "HG":
			$linetype=215;//进球最多半场
			$name1=$zuiduojinqiu;
			break;
		case "MG":
			$linetype=216;//进球最多半场-独赢
			$name1=$zuiduojinqiu." -".$win;
			break;
		case "BH":
			$linetype=217;//落后反超获胜
			$name1=$louhoufanchao;
			break;
		case "F2G":
			$linetype=218;//先进两球一方
			$name1=$xiangjinliangqiu;
			break;
		case "F3G":
			$linetype=219;//先进三球一方
			$name1=$xianjinsanqiu;
			break;
		case "FG":
			$linetype=220;//首个进球方式
			$name1=$shougejinqiufangshi;
			break;
	}
	
	switch ($gtype){
	//滚球
		case "RWMH1"://主队净赢1球
			$M_Place=$MB_Team." -".$jingying1qiu;
			$M_Rate=$row["ior_WMH1"];
			break;
		case "RWMC1"://客队净赢1球
			$M_Place=$TG_Team." -".$jingying1qiu;
			$M_Rate=$row["ior_WMC1"];
			break;
		case "RWMH2"://主队净赢2球
			$M_Place=$MB_Team." -".$jingying2qiu;
			$M_Rate=$row["ior_WMH2"];
			break;
		case "RWMC2"://客队净赢2球
			$M_Place=$TG_Team." -".$jingying2qiu;
			$M_Rate=$row["ior_WMC2"];
			break;
		case "RWMH3"://主队净赢3球
			$M_Place=$MB_Team." -".$jingying3qiu;
			$M_Rate=$row["ior_WMH3"];
			break;
		case "RWMC3"://客队净赢3球
			$M_Place=$TG_Team." -".$jingying3qiu;
			$M_Rate=$row["ior_WMC3"];
			break;
		case "RWMHOV"://主队净赢4球或更多 
			$M_Place=$MB_Team." -".$jingying4qiu;
			$M_Rate=$row["ior_WMHOV"];
			break;
		case "RWMCOV"://客队净赢4球或更多
			$M_Place=$TG_Team." -".$jingying4qiu;
			$M_Rate=$row["ior_WMCOV"];
			break;
		case "RWM0"://无进球
			$M_Place=$wujinqiu;
			$M_Rate=$row["ior_WM0"];
			break;
		case "RWMN"://任何进球和局
			$M_Place=$renhejinqiuheju;
			$M_Rate=$row["ior_WMN"];
			break;
		case "RDCHN"://主队/和局
			$M_Place=$MB_Team." /".$Draw;
			$M_Rate=$row["ior_DCHN"];
			break;
		case "RDCCN"://客队/和局
			$M_Place=$TG_Team." /".$Draw;
			$M_Rate=$row["ior_DCCN"];
			break;
		case "RDCHC"://主队/客队
			$M_Place=$MB_Team." /".$TG_Team;
			$M_Rate=$row["ior_DCHC"];
			break;
		case "RWEH"://主队赢得任一半场
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_WEH"];
			break;
		case "RWEC"://客队赢得任一半场
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_WEC"];
			break;
		case "RWBH"://主队赢所有半场
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_WBH"];
			break;
		case "RWBC"://客队赢得所有半场
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_WBC"];
			break;
		case "RTSY"://是双方球队进球
			$M_Place=$shi;
			$M_Rate=$row["ior_TSY"];
			break;
		case "RTSN"://否双方球队进球
			$M_Place=$fou;
			$M_Rate=$row["ior_TSN"];
			break;
		case "RCSH"://主队零失球
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_CSH"];
			break;
		case "RCSC"://客队零失球
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_CSC"];
			break;
		case "RT3G1"://第26分钟或之前
			$M_Place=$fenzhong26;
			$M_Rate=$row["ior_T3G1"];
			break;
		case "RT3G2"://第27分钟或之后前
			$M_Place=$fenzhong27;
			$M_Rate=$row["ior_T3G2"];
			break;
		case "RT3GN"://无进球
			$M_Place=$wujinqiu;
			$M_Rate=$row["ior_T3GN"];
			break;
		case "RWNH"://主队零失球获胜
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_WNH"];
			break;
		case "RWNC"://客队零失球获胜
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_WNC"];
			break;
		case "RSBH"://主队双半场进球
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_SBH"];
			break;
		case "RSBC"://客队双半场进球
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_SBC"];
			break;
		//首个进球时间
		case "RT1G1":
			$M_Place="0 - 14:59".$fenzhong;
			$M_Rate=$row["ior_T1G1"];
			break;
		case "RT1G2":
			$M_Place="15 - 29:59".$fenzhong;
			$M_Rate=$row["ior_T1G2"];
			break;
		case "RT1G3":
			$M_Place="30 - ".$banchang;
			$M_Rate=$row["ior_T1G3"];
			break;
		case "RT1G4":
			$M_Place=$xiabanchangkaishi." - 59:59".$fenzhong;
			$M_Rate=$row["ior_T1G4"];
			break;
		case "RT1G5":
			$M_Place="60 - 74:59".$fenzhong;
			$M_Rate=$row["ior_T1G5"];
			break;
		case "RT1G6":
			$M_Place="75".$fenzhong." - ".$quanchang;
			$M_Rate=$row["ior_T1G6"];
			break;
		case "RT1GN":
			$M_Place=$wujinqiu;
			$M_Rate=$row["ior_T1GN"];
			break;
			
	//初盘
		case "WMH1"://主队净赢1球
			$M_Place=$MB_Team." -".$jingying1qiu;
			$M_Rate=$row["ior_WMH1"];
			break;
		case "WMC1"://客队净赢1球
			$M_Place=$TG_Team." -".$jingying1qiu;
			$M_Rate=$row["ior_WMC1"];
			break;
		case "WMH2"://主队净赢2球
			$M_Place=$MB_Team." -".$jingying2qiu;
			$M_Rate=$row["ior_WMH2"];
			break;
		case "WMC2"://客队净赢2球
			$M_Place=$TG_Team." -".$jingying2qiu;
			$M_Rate=$row["ior_WMC2"];
			break;
		case "WMH3"://主队净赢3球
			$M_Place=$MB_Team." -".$jingying3qiu;
			$M_Rate=$row["ior_WMH3"];
			break;
		case "WMC3"://客队净赢3球
			$M_Place=$TG_Team." -".$jingying3qiu;
			$M_Rate=$row["ior_WMC3"];
			break;
		case "WMHOV"://主队净赢4球或更多 
			$M_Place=$MB_Team." -".$jingying4qiu;
			$M_Rate=$row["ior_WMHOV"];
			break;
		case "WMCOV"://客队净赢4球或更多
			$M_Place=$TG_Team." -".$jingying4qiu;
			$M_Rate=$row["ior_WMCOV"];
			break;
		case "WM0"://无进球
			$M_Place=$wujinqiu;
			$M_Rate=$row["ior_WM0"];
			break;
		case "WMN"://任何进球和局
			$M_Place=$renhejinqiuheju;
			$M_Rate=$row["ior_WMN"];
			break;
		case "DCHN"://主队/和局
			$M_Place=$MB_Team." /".$Draw;
			$M_Rate=$row["ior_DCHN"];
			break;
		case "DCCN"://客队/和局
			$M_Place=$TG_Team." /".$Draw;
			$M_Rate=$row["ior_DCCN"];
			break;
		case "DCHC"://主队/客队
			$M_Place=$MB_Team." /".$TG_Team;
			$M_Rate=$row["ior_DCHC"];
			break;
		case "WEH"://主队赢得任一半场
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_WEH"];
			break;
		case "WEC"://客队赢得任一半场
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_WEC"];
			break;
		case "WBH"://主队赢所有半场
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_WBH"];
			break;
		case "WBC"://客队赢得所有半场
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_WBC"];
			break;
		case "TSY"://是双方球队进球
			$M_Place=$shi;
			$M_Rate=$row["ior_TSY"];
			break;
		case "TSN"://否双方球队进球
			$M_Place=$fou;
			$M_Rate=$row["ior_TSN"];
			break;
		case "CSH"://主队零失球
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_CSH"];
			break;
		case "CSC"://客队零失球
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_CSC"];
			break;
		case "T3G1"://第26分钟或之前
			$M_Place=$fenzhong26;
			$M_Rate=$row["ior_T3G1"];
			break;
		case "T3G2"://第27分钟或之后前
			$M_Place=$fenzhong27;
			$M_Rate=$row["ior_T3G2"];
			break;
		case "T3GN"://无进球
			$M_Place=$wujinqiu;
			$M_Rate=$row["ior_T3GN"];
			break;
		case "WNH"://主队零失球获胜
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_WNH"];
			break;
		case "WNC"://客队零失球获胜
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_WNC"];
			break;
		case "SBH"://主队双半场进球
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_SBH"];
			break;
		case "SBC"://客队双半场进球
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_SBC"];
			break;
		//首个进球时间
		case "T1G1":
			$M_Place="0 - 14:59".$fenzhong;
			$M_Rate=$row["ior_T1G1"];
			break;
		case "T1G2":
			$M_Place="15 - 29:59".$fenzhong;
			$M_Rate=$row["ior_T1G2"];
			break;
		case "T1G3":
			$M_Place="30 - ".$banchang;
			$M_Rate=$row["ior_T1G3"];
			break;
		case "T1G4":
			$M_Place=$xiabanchangkaishi." - 59:59".$fenzhong;
			$M_Rate=$row["ior_T1G4"];
			break;
		case "T1G5":
			$M_Place="60 - 74:59".$fenzhong;
			$M_Rate=$row["ior_T1G5"];
			break;
		case "T1G6":
			$M_Place="75".$fenzhong." - ".$quanchang;
			$M_Rate=$row["ior_T1G6"];
			break;
		case "T1GN":
			$M_Place=$wujinqiu;
			$M_Rate=$row["ior_T1GN"];
			break;
		//最多进球半场
		case "HGH":
			$M_Place=$shangbanchang;
			$M_Rate=$row["ior_HGH"];
			break;
		case "HGC":
			$M_Place=$xiabanchang;
			$M_Rate=$row["ior_HGC"];
			break;
		//最多进球半场-独赢
		case "MGH":
			$M_Place=$shangbanchang;
			$M_Rate=$row["ior_MGH"];
			break;
		case "MGC":
			$M_Place=$xiabanchang;
			$M_Rate=$row["ior_MGC"];
			break;
		case "MGN":
			$M_Place=$str_irish_kiss;
			$M_Rate=$row["ior_MGN"];
			break;
		//落后反超获胜
		case "BHH"://主队
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_BHH"];
			break;
		case "BHC"://客队
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_BHC"];
			break;
			
		//先进两球一方
		case "F2GH"://主队
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_F2GH"];
			break;
		case "F2GC"://客队
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_F2GC"];
			break;
		//先进三球一方
		case "F3GH"://主队
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_F3GH"];
			break;
		case "F3GC"://客队
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_F3GC"];
			break;
		//首个进球方式
		case "FGS"://射门
			$M_Place=$shemen;
			$M_Rate=$row["ior_FGS"];
			break;
		case "FGH"://头球
			$M_Place=$touqiu;
			$M_Rate=$row["ior_FGH"];
			break;
		case "FGN"://无进球
			$M_Place=$wujinqiu;
			$M_Rate=$row["ior_FGN"];
			break;
		case "FGP"://点球
			$M_Place=$dianqiu;
			$M_Rate=$row["ior_FGP"];
			break;
		case "FGF"://任意球
			$M_Place=$renyiqiu;
			$M_Rate=$row["ior_FGF"];
			break;
		case "FGO"://乌龙球
			$M_Place=$wulongqiu;
			$M_Rate=$row["ior_FGO"];
			break;
		
	}
	/*if (($M_Rate+0)<=1){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit;
	}*/
	
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
<script language="JavaScript" src="/js/football_order2.js"></script>
</head>
<body id="OFT" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_single_finish.php" method="post" onSubmit="return false">
<div class="ord">
	<div class="title"><h1><?=$Soccer?></h1><div class="tiTimer" onClick="orderReload();"><span id="ODtimer">10</span><input type="checkbox" id="checkOrder" onClick="onclickReloadTime()" checked value="10"></div></div>
    <div class="main">
	  <div class="leag"><?=$m_league?></div>
      <div class="gametype"><? if(substr($wtype,0,1)=='R'){?><?=$run?>  <? }?><?=$name1?></div>
      <div class="teamName"><span class="tName"><?=$MB_Team?> <font class="radio">vs</font> <?=$TG_Team?></span></div>
      <p class="team"><em><?=$M_Place?></em> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
      <p class="auto"><input type="checkbox" id="autoOdd" name="autoOdd" onClick="onclickReloadAutoOdd()" checked value="Y"><span class="auto_info" title="<?=$zdjs_title?>"><?=$zdjs?></span></p>
      	
	  <p class="error" style="display:none;"><?=$bet_title?></p>
      <div class="betdata">
          <p class="amount"><?=$Xzjr?><input name="gold" type="text" class="txt" id="gold" onKeyPress="return CheckKey(event)" onKeyUp="return CountWinGold1()" size="8" maxlength="10"></p>
          <p class="mayWin"><span class="bet_txt"><?=$Kyje?></span><font id="pc">0</font></p>
          <p class="minBet"><span class="bet_txt"><?=$Zdxe?></span><?=number_format($GMIN_SINGLE)?></p>
          <p class="maxBet"><span class="bet_txt"><?=$Dczg?></span><?=number_format($GMAX_SINGLE)?></p>
    </div>
    </div>
  <div id="gWager" style="display: none;position: absolute;"></div>
  <div id="gbutton" style="display: block;position: absolute;"></div>
  <div class="betBox">
    <input type="button" name="btnCancel" value="<?=$Qxxz?>" onClick="parent.close_bet();" class="no">
    <input type="button" name="Submit" value="<?=$Qdxz?>" onClick="CountWinGold1();return SubChk();" class="yes">
  </div>
</div>
  <div id="gfoot" style="display: block;position: absolute;"></div>
  <div class="ord" id="line_window" style="display: none;">
    <div class="betChk" id="gdiv_table">
      <span class="notice">*SHOW_STR*</span>
      <input type="button" name="wgCancel" value="<?=$Qxxz?>" onClick="Close_div();" class="no">
      <input type="button" name="wgSubmit" value="<?=$Qdxz?>" onmousedown='Sure_wager();' class="yes">
    </div>
  </div>
<input type="hidden" value="<?=$uid?>" name=uid>
<input type="hidden" value="<?=$langx?>" name=langx>
	<input type="hidden" value="<?=$gid?>" name=gid>
	<INPUT type="hidden" id=ioradio_r_h  value="<?=number_format($M_Rate,2)?>" name=ioradio_r_h>
	<input type="hidden" value="<?=$bettop?>" name=gmax_single>
	<input type="hidden" value="<?=$GMIN_SINGLE?>" name=gmin_single>
	<input type="hidden" value="<?=$GMAX_SINGLE?>" name=singlecredit>
	<input type="hidden" value="<?=$GSINGLE_CREDIT?>" name=singleorder>
	<input type="hidden" value="<?=$active?>" name=active>
	<input type="hidden" value="0" name=gwin>
	<input type="hidden" value="<?=$linetype?>" name=line_type>
	<input type="hidden" value="<?=$pay_type?>" name=pay_type>
	<input type="hidden" value="<?=$gtype?>" name=type>
	<input type="hidden" value="<?=$have_bet?>" name=restsinglecredit>
	<input type="hidden" value="<?=$credit?>" name=restcredit>
	<input type="hidden" value="<?=$odd_f_type?>" name=odd_f_type>
	<input type="hidden" value="<?=$wtype?>" name=wtype>
</form>


</body>
</html>
<?
}
mysql_close();
?>

