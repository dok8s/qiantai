<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/http.class.php");
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gnum=$_REQUEST['gnum'];
$sql = "select status,cancel,hidden,super,ID,Money,Memname,Agents,world,corprator,OpenType,language,pay_type,FT_RM_Scene,LogDate,FT_RM_Bet from web_member where Oid='$uid' and Oid<>'' and Status<>0 order by ID";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{

$memrow = mysql_fetch_array($result);
$langx=$_REQUEST['langx'];
$open=$memrow['OpenType'];
$pay_type=$memrow['pay_type'];
$logdate=$memrow['LogDate'];
$hidden=$memrow['hidden'];
$accept=$memrow['cancel'];
order_accept($uid,$dbname);
//if($accept==1 && $not_active==1){
//	wager_order($uid,$langx);
//	exit;
//}
if($memrow['status']!=1){exit;}

require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");
$odd_f_type=$_REQUEST['odd_f_type'];
$odd_type=$_REQUEST['odd_f_type'];


//接收传递过来的参数：其中赔率和位置需要进行判断
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$M_Rate=$_REQUEST['ioradio_r_h'];
$active=$_REQUEST['active'];
$gold=$_REQUEST['gold'];
$line=$_REQUEST['line_type'];
$gwin=$_REQUEST['gwin'];
$wtype=$_REQUEST['wtype'];



//下注时的赔率：应该根据盘口进行转换后，与数据库中的赔率进行比较。若不相同，返回下注。
$s_m_rate=$_REQUEST['ioradio_r_h'];

//判断此赛程是否已经关闭：取出此场次信息
$mysql = "select * from foot_match where `MID`=$gid and cancel<>1 and fopen=1";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit();
}else{
	$memname=$memrow['Memname'];
	$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' order by id desc limit 0,1";
	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}
	$GMAX_SINGLE=$memrow['FT_RM_Scene'];
	$GSINGLE_CREDIT=$memrow['FT_RM_Bet'];
//userlog($memname);
	$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and MID='$gid' and linetype=104";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

	$HMoney=$memrow['Money'];
	if ($HMoney < $gold){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
	if ($have_bet+$gold > $GMAX_SINGLE){

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
	//if($not_active==0){
		$accept=0;
	//}

	$agid=$memrow['Agents'];
	$world=$memrow['world'];
	$corprator=$memrow['corprator'];$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];

	$w_ratio=1;

	$w_current=$memrow['CurType'];

	$havemoney=$HMoney-$gold;
	$memid=$memrow['ID'];

	$w_tg_team=filiter_team($row['TG_Team']);
	$w_tg_team_tw=filiter_team($row['TG_Team_tw']);
	$w_tg_team_en=filiter_team($row['TG_Team_en']);

	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));

	//取出当前字库的主客队伍名称

	$s_mb_team=filiter_team($row[$mb_team]);
	$s_tg_team=filiter_team($row[$tg_team]);
	//下注时间
	$M_Date=$row["M_Date"];
	$sDate=Date('Y').'-'.$M_Date;
	$showtype=$row["ShowType"];
	$bettime=date('Y-m-d H:i:s');


	//联盟处理:生成写入数据库的联盟样式和显示的样式，二者有区别
	if ($row[$m_sleague]==''){
		$w_sleague=$row['M_League'];
		$w_sleague_tw=$row['M_League_tw'];
		$w_sleague_en=$row['M_League_en'];
		$s_sleague=$row[$m_league];
	}else{
		$w_sleague=$row['M_Sleague'];
		$w_sleague_tw=$row['M_Sleague_tw'];
		$w_sleague_en=$row['M_Sleague_en'];
		$s_sleague=$row[$m_sleague];
	}

	//根据下注的类型进行处理：构建成新的数据格式，准备写入数据库
	$order='A';
	switch($wtype){
	//滚球
		case "RWM":
			$name1=$shuyingbifen;
			$gunj=$gunqiu." ".$jsy7;
			$gunj_tw=$gunqiu_tw." ".$jsy7_tw;
			$gunj_en=$gunqiu_en." ".$jsy7_en;
			break;
		case "RDC":
			$name1=$shuangyingpan;
			$gunj=$gunqiu." ".$syp8;
			$gunj_tw=$gunqiu_tw." ".$syp8_tw;
			$gunj_en=$gunqiu_en." ".$syp8_en;
			break;
		case "RWE"://赢得任一半场
			$name1=$yingderenyibanqiu;
			$gunj=$gunqiu." ".$syp9;
			$gunj_tw=$gunqiu_tw." ".$syp9_tw;
			$gunj_en=$gunqiu_en." ".$syp9_en;
			$inball1=$row['mb_ball'].":".$row['tg_ball'].','.$row['rcard_h'].":".$row['rcard_c'];
			if($row['M_Time']=='H/T'){
				$danger=0;
			}else{
		
				$danger=1;
			}
			$gqqr="danger,QQ526738,";
			$gqqr1="'$danger','$inball1',";
			$jdk='<div class="fin_acc1" style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px; ">'.$weixian.'</div>';
			break;
		case "RWB"://赢得所有半场
			$name1=$yingdesuoyoubanchang;
			$gunj=$gunqiu." ".$syp10;
			$gunj_tw=$gunqiu_tw." ".$syp10_tw;
			$gunj_en=$gunqiu_en." ".$syp10_en;
			$inball1=$row['mb_ball'].":".$row['tg_ball'].','.$row['rcard_h'].":".$row['rcard_c'];
			if($row['M_Time']=='H/T'){
				$danger=0;
			}else{
		
				$danger=1;
			}
			$gqqr="danger,QQ526738,";
			$gqqr1="'$danger','$inball1',";
			$jdk='<div class="fin_acc1" style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px; ">'.$weixian.'</div>';
			break;
		case "RTS"://双方球队进球
			$name1=$shuangfangqiudui;
			$gunj=$gunqiu." ".$syp11;
			$gunj_tw=$gunqiu_tw." ".$syp11_tw;
			$gunj_en=$gunqiu_en." ".$syp11_en;
			break;
		case "RCS"://零失球
			$name1=$lingshiqiu;
			$gunj=$gunqiu." ".$syp12;
			$gunj_tw=$gunqiu_tw." ".$syp12_tw;
			$gunj_en=$gunqiu_en." ".$syp12_en;
			$inball1=$row['mb_ball'].":".$row['tg_ball'].','.$row['rcard_h'].":".$row['rcard_c'];
			if($row['M_Time']=='H/T'){
				$danger=0;
			}else{
		
				$danger=1;
			}
			$gqqr="danger,QQ526738,";
			$gqqr1="'$danger','$inball1',";
			$jdk='<div class="fin_acc1" style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px; ">'.$weixian.'</div>';
			break;
		case "RT3G"://首个进球时间 - 三项
			$name1=$shougejinqiushijian." - ".$sanxiang;
			$gunj=$gunqiu." ".$syp13;
			$gunj_tw=$gunqiu_tw." ".$syp13_tw;
			$gunj_en=$gunqiu_en." ".$syp13_en;
			break;
		case "RWN"://零失球获胜
			$name1=$lingshiqiuhuosheng;
			$gunj=$gunqiu." ".$syp14;
			$gunj_tw=$gunqiu_tw." ".$syp14_tw;
			$gunj_en=$gunqiu_en." ".$syp14_en;
			$inball1=$row['mb_ball'].":".$row['tg_ball'].','.$row['rcard_h'].":".$row['rcard_c'];
			if($row['M_Time']=='H/T'){
				$danger=0;
			}else{
		
				$danger=1;
			}
			$gqqr="danger,QQ526738,";
			$gqqr1="'$danger','$inball1',";
			$jdk='<div class="fin_acc1" style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px; ">'.$weixian.'</div>';
			break;
		case "RSB"://双半场进球
			$name1=$shuangbanchang;
			$gunj=$gunqiu." ".$syp15;
			$gunj_tw=$gunqiu_tw." ".$syp15_tw;
			$gunj_en=$gunqiu_en." ".$syp15_en;
			$inball1=$row['mb_ball'].":".$row['tg_ball'].','.$row['rcard_h'].":".$row['rcard_c'];
			if($row['M_Time']=='H/T'){
				$danger=0;
			}else{
		
				$danger=1;
			}
			$gqqr="danger,QQ526738,";
			$gqqr1="'$danger','$inball1',";
			$jdk='<div class="fin_acc1" style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px; ">'.$weixian.'</div>';
			break;
		case "RT1G"://首个进球时间
			$name1=$shougejinqiushijian;
			$gunj=$gunqiu." ".$syp16;
			$gunj_tw=$gunqiu_tw." ".$syp16_tw;
			$gunj_en=$gunqiu_en." ".$syp16_en;
			$inball1=$row['mb_ball'].":".$row['tg_ball'].','.$row['rcard_h'].":".$row['rcard_c'];
			if($row['M_Time']=='H/T'){
				$danger=0;
			}else{
		
				$danger=1;
			}
			$gqqr="danger,QQ526738,";
			$gqqr1="'$danger','$inball1',";
			$jdk='<div class="fin_acc1" style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px; ">'.$weixian.'</div>';
			break;
	//初盘
		case "WM":
			$name1=$shuyingbifen;
			$gunj=$jsy7;
			$gunj_tw=$jsy7_tw;
			$gunj_en=$jsy7_en;
			break;
		case "DC":
			$name1=$shuangyingpan;
			$gunj=$syp8;
			$gunj_tw=$syp8_tw;
			$gunj_en=$syp8_en;
			break;
		case "WE"://赢得任一半场
			$name1=$yingderenyibanqiu;
			$gunj=$syp9;
			$gunj_tw=$syp9_tw;
			$gunj_en=$syp9_en;
			break;
		case "WB"://赢得所有半场
			$name1=$yingdesuoyoubanchang;
			$gunj=$syp10;
			$gunj_tw=$syp10_tw;
			$gunj_en=$syp10_en;
			break;
		case "TS"://双方球队进球
			$name1=$shuangfangqiudui;
			$gunj=$syp11;
			$gunj_tw=$syp11_tw;
			$gunj_en=$syp11_en;
			break;
		case "CS"://零失球
			$name1=$lingshiqiu;
			$gunj=$syp12;
			$gunj_tw=$syp12_tw;
			$gunj_en=$syp12_en;		
			break;
		case "T3G"://首个进球时间 - 三项
			$name1=$shougejinqiushijian." - ".$sanxiang;
			$gunj=$syp13;
			$gunj_tw=$syp13_tw;
			$gunj_en=$syp13_en;
			break;
		case "WN"://零失球获胜
			$name1=$lingshiqiuhuosheng;
			$gunj=$syp14;
			$gunj_tw=$syp14_tw;
			$gunj_en=$syp14_en;
			
			break;
		case "SB"://双半场进球
			$name1=$shuangbanchang;
			$gunj=$syp15;
			$gunj_tw=$syp15_tw;
			$gunj_en=$syp15_en;
			break;
		case "T1G"://首个进球时间
			$name1=$shougejinqiushijian;
			$gunj=$syp16;
			$gunj_tw=$syp16_tw;
			$gunj_en=$syp16_en;
			break;
		case "HG"://进球最多半场
			$name1=$zuiduojinqiu;
			$gunj=$syp17;
			$gunj_tw=$syp17_tw;
			$gunj_en=$syp17_en;
			break;
		case "MG"://进球最多半场-独赢
			$name1=$zuiduojinqiu." -".$win;
			$gunj=$syp18;
			$gunj_tw=$syp18_tw;
			$gunj_en=$syp18_en;
			break;
		case "BH"://落后反超获胜
			$name1=$louhoufanchao;
			$gunj=$syp19;
			$gunj_tw=$syp19_tw;
			$gunj_en=$syp19_en;
			break;
		case "F2G"://先进两球一方
			$name1=$xiangjinliangqiu;
			$gunj=$syp20;
			$gunj_tw=$syp20_tw;
			$gunj_en=$syp20_en;
			break;
		case "F3G"://先进三球一方
			$name1=$xianjinsanqiu;
			$gunj=$syp21;
			$gunj_tw=$syp21_tw;
			$gunj_en=$syp21_en;
			break;
		case "FG"://首个进球方式
			$name1=$shougejinqiufangshi;
			$gunj=$syp22;
			$gunj_tw=$syp22_tw;
			$gunj_en=$syp22_en;
			break;
	}
	$caption=$GqOrder;
	$turn_rate="FT_Turn_RM";
	$turn="FT_Turn_RM";
	switch ($gtype){
	//滚球
		case "RWMH1"://主队净赢1球
			$s_m_place=$s_mb_team." -".$jingying1qiu;
			$w_m_rate=$row["ior_WMH1"];
			$w_m_place=$w_mb_team." -".$jy1q;
			$w_m_place_tw=$w_mb_team_tw." -".$jy1q_tw;
			$w_m_place_en=$w_mb_team_en." -".$jy1q_en;
			break;
		case "RWMC1"://客队净赢1球
			$s_m_place=$s_tg_team." -".$jingying1qiu;
			$w_m_rate=$row["ior_WMC1"];
			$w_m_place=$w_tg_team." -".$jy1q;
			$w_m_place_tw=$w_tg_team_tw." -".$jy1q_tw;
			$w_m_place_en=$w_tg_team_en." -".$jy1q_en;
			break;
		case "RWMH2"://主队净赢2球
			$s_m_place=$s_mb_team." -".$jingying2qiu;
			$w_m_rate=$row["ior_WMH2"];
			$w_m_place=$w_mb_team." -".$jy2q;
			$w_m_place_tw=$w_mb_team_tw." -".$jy2q_tw;
			$w_m_place_en=$w_mb_team_en." -".$jy2q_en;
			break;
		case "RWMC2"://客队净赢2球
			$s_m_place=$s_tg_team." -".$jingying2qiu;
			$w_m_rate=$row["ior_WMC2"];
			$w_m_place=$w_tg_team." -".$jy2q;
			$w_m_place_tw=$w_tg_team_tw." -".$jy2q_tw;
			$w_m_place_en=$w_tg_team_en." -".$jy2q_en;
			break;
		case "RWMH3"://主队净赢3球
			$s_m_place=$s_mb_team." -".$jingying3qiu;
			$w_m_rate=$row["ior_WMH3"];
			$w_m_place=$w_mb_team." -".$jy3q;
			$w_m_place_tw=$w_mb_team_tw." -".$jy3q_tw;
			$w_m_place_en=$w_mb_team_en." -".$jy3q_en;
			break;
		case "RWMC3"://客队净赢3球
			$s_m_place=$s_tg_team." -".$jingying3qiu;
			$w_m_rate=$row["ior_WMC3"];
			$w_m_place=$w_tg_team." -".$jy3q;
			$w_m_place_tw=$w_tg_team_tw." -".$jy3q_tw;
			$w_m_place_en=$w_tg_team_en." -".$jy3q_en;
			break;
		case "RWMHOV"://主队净赢4球或更多 
			$s_m_place=$s_mb_team." -".$jingying4qiu;
			$w_m_rate=$row["ior_WMHOV"];
			$w_m_place=$w_mb_team." -".$jy4q;
			$w_m_place_tw=$w_mb_team_tw." -".$jy4q_tw;
			$w_m_place_en=$w_mb_team_en." -".$jy4q_en;
			break;
		case "RWMCOV"://客队净赢4球或更多
			$s_m_place=$s_tg_team." -".$jingying4qiu;
			$w_m_rate=$row["ior_WMCOV"];
			$w_m_place=$w_tg_team." -".$jy4q;
			$w_m_place_tw=$w_tg_team_tw." -".$jy4q_tw;
			$w_m_place_en=$w_tg_team_en." -".$jy4q_en;
			break;
		case "RWM0"://无进球
			$s_m_place=$wujinqiu;
			$w_m_place=$wjq5;
			$w_m_place_tw=$wjq5_tw;
			$w_m_place_en=$wjq5_en;
			$w_m_rate=$row["ior_WM0"];
			break;
		case "RWMN"://任何进球和局
			$s_m_place=$renhejinqiuheju;
			$w_m_rate=$row["ior_WMN"];
			$w_m_place=$wjq6;
			$w_m_place_tw=$wjq6_tw;
			$w_m_place_en=$wjq6_en;
			break;
		case "RDCHN"://主队/和局
			$s_m_place=$s_mb_team." /".$Draw;
			$w_m_rate=$row["ior_DCHN"];
			$w_m_place=$w_mb_team.' / '.$heju;
			$w_m_place_tw=$w_mb_team_tw.' / '.$heju_tw;
			$w_m_place_en=$w_mb_team_en.' / '.$heju_en;
			break;
		case "RDCCN"://客队/和局
			$s_m_place=$s_tg_team." /".$Draw;
			$w_m_rate=$row["ior_DCCN"];
			$w_m_place=$w_tg_team.' / '.$heju;
			$w_m_place_tw=$w_tg_team_tw.' / '.$heju_tw;
			$w_m_place_en=$w_tg_team_en.' / '.$heju_en;
			break;
		case "RDCHC"://主队/客队
			$s_m_place=$s_mb_team." /".$s_tg_team;
			$w_m_rate=$row["ior_DCHC"];
			$w_m_place=$w_mb_team.' / '.$w_tg_team;
			$w_m_place_tw=$w_mb_team_tw.' / '.$w_tg_team_tw;
			$w_m_place_en=$w_mb_team_en.' / '.$w_tg_team_en;
			break;
		case "RWEH"://主队赢得任一半场
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_WEH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "RWEC"://客队赢得任一半场
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_WEC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		case "RWBH"://主队赢所有半场
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_WBH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "RWBC"://客队赢得所有半场
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_WBC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		case "RTSY"://是双方球队进球
			$s_m_place=$shi;
			$w_m_rate=$row["ior_TSY"];
			$w_m_place=$shishi;
			$w_m_place_tw=$shishi_tw;
			$w_m_place_en=$shishi_en;
			break;
		case "RTSN"://否双方球队进球
			$s_m_place=$fou;
			$w_m_rate=$row["ior_TSN"];
			$w_m_place=$foufou;
			$w_m_place_tw=$foufou_tw;
			$w_m_place_en=$foufou_en;
			break;
		case "RCSH"://主队零失球
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_CSH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "RCSC"://客队零失球
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_CSC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		case "RT3G1"://第26分钟或之前
			$s_m_place=$fenzhong26;
			$w_m_rate=$row["ior_T3G1"];
			$w_m_place=$fz26;
			$w_m_place_tw=$fz26_tw;
			$w_m_place_en=$fz26_en;
			break;
		case "RT3G2"://第27分钟或之后前
			$s_m_place=$fenzhong27;
			$w_m_rate=$row["ior_T3G2"];
			$w_m_place=$fz27;
			$w_m_place_tw=$fz27_tw;
			$w_m_place_en=$fz27_en;
			break;
		case "RT3GN"://无进球
			$s_m_place=$wujinqiu;
			$w_m_rate=$row["ior_T3GN"];
			$w_m_place=$wjq5;
			$w_m_place_tw=$wjq5_tw;
			$w_m_place_en=$wjq5_en;
			break;
		case "RWNH"://主队零失球获胜
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_WNH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "RWNC"://客队零失球获胜
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_WNC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		case "RSBH"://主队双半场进球
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_SBH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "RSBC"://客队双半场进球
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_SBC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		//首个进球时间
		case "RT1G1":
			$s_m_place="0 - 14:59".$fenzhong;
			$w_m_rate=$row["ior_T1G1"];
			$w_m_place="0 - 14:59".$fz128;
			$w_m_place_tw="0 - 14:59".$fz128_tw;
			$w_m_place_en="0 - 14:59".$fz128_en;
			break;
		case "RT1G2":
			$s_m_place="15 - 29:59".$fenzhong;
			$w_m_rate=$row["ior_T1G2"];
			$w_m_place="15 - 29:59".$fz128;
			$w_m_place_tw="15 - 29:59".$fz128_tw;
			$w_m_place_en="15 - 29:59".$fz128_en;
			break;
		case "RT1G3":
			$s_m_place="30 - ".$banchang;
			$w_m_rate=$row["ior_T1G3"];
			$w_m_place="30 - ".$banchang;
			$w_m_place_tw="30 - ".$banchang_tw;
			$w_m_place_en="30 - ".$banchang1_en;
			break;
		case "RT1G4":
			$s_m_place=$xiabanchangkaishi." - 59:59".$fenzhong;
			$w_m_rate=$row["ior_T1G4"];
			$w_m_place=$fz129." - 59:59".$fz128;
			$w_m_place_tw=$fz129_tw." - 59:59".$fz128_tw;
			$w_m_place_en=$fz129_en." - 59:59".$fz128_en;
			break;
		case "RT1G5":
			$s_m_place="60 - 74:59".$fenzhong;
			$w_m_rate=$row["ior_T1G5"];
			$w_m_place="60 - 74:59".$fz128;
			$w_m_place_tw="60 - 74:59".$fz128_tw;
			$w_m_place_en="60 - 74:59".$fz128_en;
			break;
		case "RT1G6":
			$s_m_place="75".$fenzhong." - ".$quanchang;
			$w_m_rate=$row["ior_T1G6"];
			$w_m_place="75".$fz128." - ".$quanchang;
			$w_m_place_tw="75".$fz128_tw." - ".$quanchang_tw;
			$w_m_place_en="75".$fz128_en." - ".$quanchang1_en;
			break;
		case "RT1GN":
			$s_m_place=$wujinqiu;
			$w_m_rate=$row["ior_T1GN"];
			$w_m_place=$wjq;
			$w_m_place_tw=$wjq_tw;
			$w_m_place_en=$wjq_en;
			break;
	//初盘
		case "WMH1"://主队净赢1球
			$s_m_place=$s_mb_team." -".$jingying1qiu;
			$w_m_rate=$row["ior_WMH1"];
			$w_m_place=$w_mb_team." -".$jy1q;
			$w_m_place_tw=$w_mb_team_tw." -".$jy1q_tw;
			$w_m_place_en=$w_mb_team_en." -".$jy1q_en;
			break;
		case "WMC1"://客队净赢1球
			$s_m_place=$s_tg_team." -".$jingying1qiu;
			$w_m_rate=$row["ior_WMC1"];
			$w_m_place=$w_tg_team." -".$jy1q;
			$w_m_place_tw=$w_tg_team_tw." -".$jy1q_tw;
			$w_m_place_en=$w_tg_team_en." -".$jy1q_en;
			break;
		case "WMH2"://主队净赢2球
			$s_m_place=$s_mb_team." -".$jingying2qiu;
			$w_m_rate=$row["ior_WMH2"];
			$w_m_place=$w_mb_team." -".$jy2q;
			$w_m_place_tw=$w_mb_team_tw." -".$jy2q_tw;
			$w_m_place_en=$w_mb_team_en." -".$jy2q_en;
			break;
		case "WMC2"://客队净赢2球
			$s_m_place=$s_tg_team." -".$jingying2qiu;
			$w_m_rate=$row["ior_WMC2"];
			$w_m_place=$w_tg_team." -".$jy2q;
			$w_m_place_tw=$w_tg_team_tw." -".$jy2q_tw;
			$w_m_place_en=$w_tg_team_en." -".$jy2q_en;
			break;
		case "WMH3"://主队净赢3球
			$s_m_place=$s_mb_team." -".$jingying3qiu;
			$w_m_rate=$row["ior_WMH3"];
			$w_m_place=$w_mb_team." -".$jy3q;
			$w_m_place_tw=$w_mb_team_tw." -".$jy3q_tw;
			$w_m_place_en=$w_mb_team_en." -".$jy3q_en;
			break;
		case "WMC3"://客队净赢3球
			$s_m_place=$s_tg_team." -".$jingying3qiu;
			$w_m_rate=$row["ior_WMC3"];
			$w_m_place=$w_tg_team." -".$jy3q;
			$w_m_place_tw=$w_tg_team_tw." -".$jy3q_tw;
			$w_m_place_en=$w_tg_team_en." -".$jy3q_en;
			break;
		case "WMHOV"://主队净赢4球或更多 
			$s_m_place=$s_mb_team." -".$jingying4qiu;
			$w_m_rate=$row["ior_WMHOV"];
			$w_m_place=$w_mb_team." -".$jy4q;
			$w_m_place_tw=$w_mb_team_tw." -".$jy4q_tw;
			$w_m_place_en=$w_mb_team_en." -".$jy4q_en;
			break;
		case "WMCOV"://客队净赢4球或更多
			$s_m_place=$s_tg_team." -".$jingying4qiu;
			$w_m_rate=$row["ior_WMCOV"];
			$w_m_place=$w_tg_team." -".$jy4q;
			$w_m_place_tw=$w_tg_team_tw." -".$jy4q_tw;
			$w_m_place_en=$w_tg_team_en." -".$jy4q_en;
			break;
		case "WM0"://无进球
			$s_m_place=$wujinqiu;
			$w_m_place=$wjq5;
			$w_m_place_tw=$wjq5_tw;
			$w_m_place_en=$wjq5_en;
			$w_m_rate=$row["ior_WM0"];
			break;
		case "WMN"://任何进球和局
			$s_m_place=$renhejinqiuheju;
			$w_m_rate=$row["ior_WMN"];
			$w_m_place=$wjq6;
			$w_m_place_tw=$wjq6_tw;
			$w_m_place_en=$wjq6_en;
			break;
		case "DCHN"://主队/和局
			$s_m_place=$s_mb_team." /".$Draw;
			$w_m_rate=$row["ior_DCHN"];
			$w_m_place=$w_mb_team.' / '.$heju;
			$w_m_place_tw=$w_mb_team_tw.' / '.$heju_tw;
			$w_m_place_en=$w_mb_team_en.' / '.$heju_en;
			break;
		case "DCCN"://客队/和局
			$s_m_place=$s_tg_team." /".$Draw;
			$w_m_rate=$row["ior_DCCN"];
			$w_m_place=$w_tg_team.' / '.$heju;
			$w_m_place_tw=$w_tg_team_tw.' / '.$heju_tw;
			$w_m_place_en=$w_tg_team_en.' / '.$heju_en;
			break;
		case "DCHC"://主队/客队
			$s_m_place=$s_mb_team." /".$s_tg_team;
			$w_m_rate=$row["ior_DCHC"];
			$w_m_place=$w_mb_team.' / '.$w_tg_team;
			$w_m_place_tw=$w_mb_team_tw.' / '.$w_tg_team_tw;
			$w_m_place_en=$w_mb_team_en.' / '.$w_tg_team_en;
			break;
		case "WEH"://主队赢得任一半场
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_WEH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "WEC"://客队赢得任一半场
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_WEC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		case "WBH"://主队赢所有半场
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_WBH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "WBC"://客队赢得所有半场
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_WBC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		case "TSY"://是双方球队进球
			$s_m_place=$shi;
			$w_m_rate=$row["ior_TSY"];
			$w_m_place=$shishi;
			$w_m_place_tw=$shishi_tw;
			$w_m_place_en=$shishi_en;
			break;
		case "TSN"://否双方球队进球
			$s_m_place=$fou;
			$w_m_rate=$row["ior_TSN"];
			$w_m_place=$foufou;
			$w_m_place_tw=$foufou_tw;
			$w_m_place_en=$foufou_en;
			break;
		case "CSH"://主队零失球
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_CSH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "CSC"://客队零失球
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_CSC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		case "T3G1"://第26分钟或之前
			$s_m_place=$fenzhong26;
			$w_m_rate=$row["ior_T3G1"];
			$w_m_place=$fz26;
			$w_m_place_tw=$fz26_tw;
			$w_m_place_en=$fz26_en;
			break;
		case "T3G2"://第27分钟或之后前
			$s_m_place=$fenzhong27;
			$w_m_rate=$row["ior_T3G2"];
			$w_m_place=$fz27;
			$w_m_place_tw=$fz27_tw;
			$w_m_place_en=$fz27_en;
			break;
		case "T3GN"://无进球
			$s_m_place=$wujinqiu;
			$w_m_rate=$row["ior_T3GN"];
			$w_m_place=$wjq5;
			$w_m_place_tw=$wjq5_tw;
			$w_m_place_en=$wjq5_en;
			break;
		case "WNH"://主队零失球获胜
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_WNH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "WNC"://客队零失球获胜
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_WNC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		case "SBH"://主队双半场进球
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_SBH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "SBC"://客队双半场进球
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_SBC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		//首个进球时间
		case "T1G1":
			$s_m_place="0 - 14:59".$fenzhong;
			$w_m_rate=$row["ior_T1G1"];
			$w_m_place="0 - 14:59".$fz128;
			$w_m_place_tw="0 - 14:59".$fz128_tw;
			$w_m_place_en="0 - 14:59".$fz128_en;
			break;
		case "T1G2":
			$s_m_place="15 - 29:59".$fenzhong;
			$w_m_rate=$row["ior_T1G2"];
			$w_m_place="15 - 29:59".$fz128;
			$w_m_place_tw="15 - 29:59".$fz128_tw;
			$w_m_place_en="15 - 29:59".$fz128_en;
			break;
		case "T1G3":
			$s_m_place="30 - ".$banchang;
			$w_m_rate=$row["ior_T1G3"];
			$w_m_place="30 - ".$banchang;
			$w_m_place_tw="30 - ".$banchang_tw;
			$w_m_place_en="30 - ".$banchang1_en;
			break;
		case "T1G4":
			$s_m_place=$xiabanchangkaishi." - 59:59".$fenzhong;
			$w_m_rate=$row["ior_T1G4"];
			$w_m_place=$fz129." - 59:59".$fz128;
			$w_m_place_tw=$fz129_tw." - 59:59".$fz128_tw;
			$w_m_place_en=$fz129_en." - 59:59".$fz128_en;
			break;
		case "T1G5":
			$s_m_place="60 - 74:59".$fenzhong;
			$w_m_rate=$row["ior_T1G5"];
			$w_m_place="60 - 74:59".$fz128;
			$w_m_place_tw="60 - 74:59".$fz128_tw;
			$w_m_place_en="60 - 74:59".$fz128_en;
			break;
		case "T1G6":
			$s_m_place="75".$fenzhong." - ".$quanchang;
			$w_m_rate=$row["ior_T1G6"];
			$w_m_place="75".$fz128." - ".$quanchang;
			$w_m_place_tw="75".$fz128_tw." - ".$quanchang_tw;
			$w_m_place_en="75".$fz128_en." - ".$quanchang1_en;
			break;
		case "T1GN":
			$s_m_place=$wujinqiu;
			$w_m_rate=$row["ior_T1GN"];
			$w_m_place=$wjq;
			$w_m_place_tw=$wjq_tw;
			$w_m_place_en=$wjq_en;
			break;
		//最多进球半场
		case "HGH":
			$s_m_place=$shangbanchang;
			$w_m_rate=$row["ior_HGH"];
			$w_m_place=$shangban1;
			$w_m_place_tw=$shangban1_tw;
			$w_m_place_en=$shangban1_en;
			break;
		case "HGC":
			$s_m_place=$xiabanchang;
			$w_m_rate=$row["ior_HGC"];
			$w_m_place=$xbcxia;
			$w_m_place_tw=$xbcxia_tw;
			$w_m_place_en=$xbcxia_en;
			break;
		//最多进球半场-独赢
		case "MGH":
			$s_m_place=$shangbanchang;
			$w_m_rate=$row["ior_MGH"];
			$w_m_place=$shangban1;
			$w_m_place_tw=$shangban1_tw;
			$w_m_place_en=$shangban1_en;
			break;
		case "MGC":
			$s_m_place=$xiabanchang;
			$w_m_rate=$row["ior_MGC"];
			$w_m_place=$xbcxia;
			$w_m_place_tw=$xbcxia_tw;
			$w_m_place_en=$xbcxia_en;
			break;
		case "MGN":
			$s_m_place=$str_irish_kiss;
			$w_m_rate=$row["ior_MGN"];
			$w_m_place=$heju;
			$w_m_place_tw=$heju_tw;
			$w_m_place_en=$heju_en;
			break;
		//落后反超获胜
		case "BHH"://主队
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_BHH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "BHC"://客队
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_BHC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		//先进两球一方
		case "F2GH"://主队
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_F2GH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "F2GC"://客队
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_F2GC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		//先进三球一方
		case "F3GH"://主队
			$s_m_place=$s_mb_team;
			$w_m_rate=$row["ior_F3GH"];
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			break;
		case "F3GC"://客队
			$s_m_place=$s_tg_team;
			$w_m_rate=$row["ior_F3GC"];
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			break;
		//首个进球方式
		case "FGS"://射门
			$s_m_place=$shemen;
			$w_m_rate=$row["ior_FGS"];
			$w_m_place=$fg1;
			$w_m_place_tw=$fg1_tw;
			$w_m_place_en=$fg1_en;
			break;
		case "FGH"://头球
			$s_m_place=$touqiu;
			$w_m_rate=$row["ior_FGH"];
			$w_m_place=$fg2;
			$w_m_place_tw=$fg2_tw;
			$w_m_place_en=$fg2_en;
			break;
		case "FGN"://无进球
			$s_m_place=$wujinqiu;
			$w_m_rate=$row["ior_FGN"];
			$w_m_place=$wjq;
			$w_m_place_tw=$wjq_tw;
			$w_m_place_en=$wjq_en;
			break;
		case "FGP"://点球
			$s_m_place=$dianqiu;
			$w_m_rate=$row["ior_FGP"];
			$w_m_place=$fg3;
			$w_m_place_tw=$fg3_tw;
			$w_m_place_en=$fg3_en;
			break;
		case "FGF"://任意球
			$s_m_place=$renyiqiu;
			$w_m_rate=$row["ior_FGF"];
			$w_m_place=$fg4;
			$w_m_place_tw=$fg4_tw;
			$w_m_place_en=$fg4_en;
			break;
		case "FGO"://乌龙球
			$s_m_place=$wulongqiu;
			$w_m_rate=$row["ior_FGO"];
			$w_m_place=$fg5;
			$w_m_place_tw=$fg5_tw;
			$w_m_place_en=$fg5_en;
			break;
		
	}


		//水位与数据库水位不等时提示
		$turn_url=BROWSER_IP."/app/member/FT_order/FT_order_single.php?gid=".$gid."&uid=".$uid."&rtype=$gtype&wtype=$wtype&odd_f_type=$odd_type&langx=$langx";
		if ($M_Rate<>$w_m_rate){
		//echo $M_Rate."---".$w_m_rate;exit;
			$turn_url=$turn_url.'&change=1';
			echo "<script language='javascript'>self.location='$turn_url';</script>";
			exit;
		}
		if ($showtype==''){
			$turn_url=$turn_url.'&change=1';
			echo "<script language='javascript'>self.location='$turn_url';</script>";
			exit();
		}

	$Sign="vs";
	$grape="";
	$gwin=($s_m_rate-1)*$gold;

	$w_mb_mid='';
	$w_tg_mid='';

	$w_mid='<br>';
	$bet_type1=$zuqiubc.$gunj;
	$bet_type1_tw=$zuqiubc_tw.$gunj_tw;
	$bet_type1_en=$zuqiubc_en.$gunj_en;

	$bet_type=$zuqiubc."<br>".$gunj;
	$bet_type_tw=$zuqiubc_tw."<br>".$gunj_tw;
	$bet_type_en=$zuqiubc_en."<br>".$gunj_en;

	if ($w_m_rate==''){
		echo "<script language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}



	$lines2=$row['M_League'].$w_mid.$w_mb_team."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team."<font color=\"#0000BB\">[".$gunj."]</font><br>";
	$lines2=$lines2."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_tw=$row['M_League_tw'].$w_mid.$w_mb_team_tw."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_tw."<font color=\"#0000BB\">[".$gunj_tw."]</font><br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_en=$row['M_League_en'].$w_mid.$w_mb_team_en."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_en."<font color=\"#0000BB\">[".$gunj_en."]</font><br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";
	
	

	$auth_code=md5($lines2_tw.$gold.$gtype);

	$I_Date=Date('Y')."-".$M_Date;
$ip_addr = $_SERVER['REMOTE_ADDR'];

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

	$sql = "INSERT INTO web_db_io($gqqr odd_type,wtype,auth_code,hidden,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,BetIP,pay_type,corpor_turn,orderby,corpor_point,status,BetType1,BetType1_tw,BetType1_en) values ($gqqr1 '$odd_type','$wtype','$auth_code','$hidden','$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$bet_type1','$bet_type1_tw','$bet_type1_en')";
	//echo $sql;exit;
	mysql_db_query($dbname,$sql) or die ($pwno);
	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];
	$logdate=date('Y-m-d',strtotime($logdate));
	if($sDate==date('Y-m-d') || $logdate<date('Y-m-d')){
		$sql = "update web_member set Money='$havemoney',cancel=1 where memname='$memname'";
		mysql_db_query($dbname,$sql) or die ($pwno);
	}
if ($active==2){
	$caption=str_replace($Soccer,trim($EarlyMarket),$caption);
}

?>
<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
</head>
<body  id="OFIN" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$Soccer?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div><?=$jdk?></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><? if(substr($wtype,0,1)=='R'){?><?=$run?>  <? }?><?=$name1?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> vs. <?=$s_tg_team?> </span></div>
      <p class="team"><em><?=$s_m_place?></em> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
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
}
}
mysql_close();
?>




