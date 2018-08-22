<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");

$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$M_Rate=$_REQUEST['ioradio_r_h'];
$active=$_REQUEST['active'];
$gold=$_REQUEST['gold'];
$line=$_REQUEST['line_type'];
$gwin=$_REQUEST['gwin'];
$restcredit=$_REQUEST['restcredit'];
$odd_type=$_REQUEST['odd_f_type'];
$langx=$_REQUEST['langx'];
$sql = "select tick,pretick,status,cancel,hidden,super,ID,Money,Memname,Agents,world,pay_type,LogDate,corprator,OpenType,language,FT_T_Scene,FT_T_Bet from web_member where Oid='$uid' and oid<>'' and Status<>0 order by ID";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$memrow = mysql_fetch_array($result);

	$hidden=$memrow['hidden'];
	$accept=$memrow['cancel'];
	$open=$memrow['OpenType'];
	$logdate=$memrow['LogDate'];
	$pay_type=$memrow['pay_type'];
$tick=$memrow['tick'];
	$pretick=$memrow['pretick'];

//	if($accept==1 && $not_active==1){
//		wager_order($uid,$langx);
//		exit;
//	}
	order_accept($uid,$dbname);
	require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");
$odd_f_type=$_REQUEST['odd_f_type'];

if($memrow['status']!=1){exit;}
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
	$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";
	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}
	$GMAX_SINGLE=$memrow['FT_T_Scene'];
	$GSINGLE_CREDIT=$memrow['FT_T_Bet'];
//userlog($memname);
	$HMoney=$memrow['Money'];

	if ($HMoney <((($_REQUEST['ioradio_r_h']<0 && $odd_type=='I')?abs($_REQUEST['ioradio_r_h']*$gold):$gold))){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}

	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where M_Name='$memname' and MID='$gid' and LineType=15 and Mtype='$gtype'";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore'];
	if ($have_bet==''){
		$have_bet=0;
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
	$corprator=$memrow['corprator'];
	$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];
	$w_current=$memrow['CurType'];

	$havemoney=$HMoney-$gold;
	$memid=$memrow['ID'];
	$bettime=date('Y-m-d H:i:s');

	$mysql = "select rcard_h,rcard_c,M_Time,MB_MID,TG_MID,MB_Ball,TG_Ball,M_Flat,M_League,M_League_tw,M_League_en,ShowType,TG_Team_tw,TG_Team_en,MB_Team_tw,MB_Team_en,M_Date,M_Time,MB_Team,TG_Team,str_odd,str_even,ior_RT01,ior_RT23,ior_RT46,ior_ROVER,ior_HRT0,ior_HRT1,ior_HRT2,ior_HRTOV,ior_HREOO,ior_HREOE from foot_match where `MID`=$gid and fopen=1";

	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);

	//主客队伍名称
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

	$w_sleague=$row['M_League'];
	$w_sleague_tw=$row['M_League_tw'];
	$w_sleague_en=$row['M_League_en'];
	$s_sleague=$row[$m_league];

	$order='A';

	if($row['M_Time']=='H/T'){
		$danger=0;
	}else{
		$danger=1;
	}

$gwin=($s_m_rate-1)*$gold;

	$caption=$GqdxOrder;
	$turn_rate="FT_Turn_RT_".$opentype;
	$inball1=$row['mb_ball'].":".$row['tg_ball'].','.$row['rcard_h'].":".$row['rcard_c'];
	
	switch ($gtype){
	case "RODD":
		$ior=get_other_ioratio($odd_type,change_rate($open,$row["str_odd"]),change_rate($open,$row["str_even"]),1);
		$w_m_place='单';
		$w_m_place_tw='單';
		$w_m_place_en='Odd';
		$bet_type=$danshuang;
		$bet_type_tw=$danshuang_tw;
		$bet_type_en=$danshaung_en;
		$s_m_place		=	$Odd1;
		$name1="<font color=\"#FF0000\">".$res_total."</font> - ".$run." - ".$strOdd.$strEven;
		$w_m_rate=$row["str_odd"];$ior_m_rate=$row["str_even"];
		break;
	case "REVEN":
		$ior=get_other_ioratio($odd_type,change_rate($open,$row["str_odd"]),change_rate($open,$row["str_even"]),1);
		$w_m_place='双';
		$w_m_place_tw='雙';
		$w_m_place_en='Even';
		$name1="<font color=\"#FF0000\">".$res_total."</font> - ".$run." - ".$strOdd.$strEven;
		$bet_type=$danshuang;
		$bet_type_tw=$danshuang_tw;
		$bet_type_en=$danshaung_en;
		$s_m_place		=	$Even1;
		$w_m_rate=$row["str_even"];$ior_m_rate=$row["str_odd"];
		break;
	case "HRODD":
		$w_m_place='单';
		$w_m_place_tw='單';
		$w_m_place_en='Odd';
		$bet_type=$danshuang;
		$bet_type_tw=$danshuang_tw;
		$bet_type_en=$danshaung_en;
		$bottom1=" - <font color=#666666>[上半]</font>";
		$bottom1_tw=" - <font color=#666666>[上半]</font>";
		$bottom1_en=" - <font color=#666666>[1st half]</font>";
		$s_m_place		=	$Odd1;
		$name1="<font color=\"#FF0000\">".$body_sb."</font> - ".$run." - ".$strOdd.$strEven;
		$w_m_rate=$row["ior_HREOO"];
		$ior_m_rate=$row["ior_HREOE"];
		break;
	case "HREVEN":
		$w_m_place='双';
		$w_m_place_tw='雙';
		$w_m_place_en='Even';
		$bottom1=" - <font color=#666666>[上半]</font>";
		$bottom1_tw=" - <font color=#666666>[上半]</font>";
		$bottom1_en=" - <font color=#666666>[1st half]</font>";
		$name1="<font color=\"#FF0000\">".$body_sb."</font> - ".$run." - ".$strOdd.$strEven;
		$bet_type=$danshuang;
		$bet_type_tw=$danshuang_tw;
		$bet_type_en=$danshaung_en;
		$s_m_place		=	$Even1;
		$w_m_rate=$row["ior_HREOE"];
		$ior_m_rate=$row["ior_HREOO"];
		break;
	case "R0~1":
		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		$w_m_place='0~1';
		$w_m_place_tw='0~1';
		$w_m_place_en='0~1';
		$s_m_place='0~1';
		$w_m_rate=$row["ior_RT01"];
		
		$name1=$run." - ".$rqs;
		break;
	case "R2~3":
		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		$name1=$run." - ".$rqs;
		$w_m_place='2~3';
		$w_m_place_tw='2~3';
		$w_m_place_en='2~3';
		$s_m_place='2~3';
		$w_m_rate=$row["ior_RT23"];
		
		break;
	case "R4~6":
		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		$name1=$run." - ".$rqs;
		$w_m_place='4~6';
		$w_m_place_tw='4~6';
		$w_m_place_en='4~6';
		$s_m_place='4~6';
		$w_m_rate=$row["ior_RT46"];
		break;
	case "ROVER":
		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		$w_m_place='7或以上';
		$w_m_place_tw='7up';
		$w_m_place_en='7up';
		$s_m_place=$qi;
		$name1=$run." - ".$rqs;
		$w_m_rate=$row["ior_ROVER"];
		break;
	case "HRT0":
		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		$bottom1=" - <font color=#666666>[上半]</font>";
		$bottom1_tw=" - <font color=#666666>[上半]</font>";
		$bottom1_en=" - <font color=#666666>[1st half]</font>";
		$name1="<font color=\"#FF0000\">".$body_sb."</font> - ".$run." - ".$rqs;
		$w_m_place='0';
		$w_m_place_tw='0';
		$w_m_place_en='0';
		$s_m_place='0';
		$w_m_rate=$row["ior_HRT0"];
		
		break;
	case "HRT1":
		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		$bottom1=" - <font color=#666666>[上半]</font>";
		$bottom1_tw=" - <font color=#666666>[上半]</font>";
		$bottom1_en=" - <font color=#666666>[1st half]</font>";
		$name1="<font color=\"#FF0000\">".$body_sb."</font> - ".$run." - ".$rqs;
		$w_m_place='1';
		$w_m_place_tw='1';
		$w_m_place_en='1';
		$s_m_place='1';
		$w_m_rate=$row["ior_HRT1"];
		break;
	case "HRT2":
		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		$bottom1=" - <font color=#666666>[上半]</font>";
		$bottom1_tw=" - <font color=#666666>[上半]</font>";
		$bottom1_en=" - <font color=#666666>[1st half]</font>";
		$name1="<font color=\"#FF0000\">".$body_sb."</font> - ".$run." - ".$rqs;
		$w_m_place='2';
		$w_m_place_tw='2';
		$w_m_place_en='2';
		$s_m_place='2';
		$w_m_rate=$row["ior_HRT2"];
		break;
	case "HRTOV":
		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		$bottom1=" - <font color=#666666>[上半]</font>";
		$bottom1_tw=" - <font color=#666666>[上半]</font>";
		$bottom1_en=" - <font color=#666666>[1st half]</font>";
		$name1=$body_sb."- ".$rqs;
		$w_m_place='3或以上';
		$w_m_place_tw='3up';
		$w_m_place_en='3up';
		$s_m_place=$san;
		$w_m_rate=$row["ior_HRTOV"];
		$name1="<font color=\"#FF0000\">".$body_sb."</font> - ".$run." - ".$rqs;
		$M_Place=$san;
		break;
	}

	$Sign="vs.";
	$grape=$w_m_place_en;
	$turn="FT_Turn_T";
	
	$c_m_rate=$_REQUEST['ioradio_r_h'];
	$turn_url=BROWSER_IP."/app/member/FT_order/FT_order_rt.php?gid=".$gid."&uid=".$uid."&rtype=".$gtype."&change=1&odd_f_type=$odd_type&langx=$langx";

	if($line==15){
	
		$bet_type1=$zuqiubc.$quanchang.$gunqiu.$bet_type;
		$bet_type1_tw=$zuqiubc_tw.$quanchang_tw.$gunqiu_tw.$bet_type_tw;
		$bet_type1_en=$zuqiubc_en.$quanchang_en1.$gunqiu_en.$bet_type_en;
		$bet_type=$zuqiubc."<br>".$quanchang."<br>".$gunqiu." - ".$bet_type;
		$bet_type_tw=$zuqiubc_tw."<br>".$quanchang_tw."<br>".$gunqiu_tw." - ".$bet_type_tw;
		$bet_type_en=$zuqiubc_en."<br>".$quanchang_en1."<br>".$gunqiu_en." ".$bet_type_en;
	}elseif($line==35){
		$bet_type1=$zuqiubc.$shangban.$gunqiu.$bet_type;
		$bet_type1_tw=$zuqiubc_tw.$shangban_tw.$gunqiu_tw.$bet_type_tw;
		$bet_type1_en=$zuqiubc_en.$shangban_en1.$gunqiu_en.$bet_type_en;
		$bet_type=$zuqiubc."<br>".$shangban."<br>".$gunqiu." - ".$bet_type;
		$bet_type_tw=$zuqiubc_tw."<br>".$shangban_tw."<br>".$gunqiu_tw." - ".$bet_type_tw;
		$bet_type_en=$zuqiubc_en."<br>".$shangban_en1."<br>".$gunqiu_en." ".$bet_type_en;
	}else{
		$bet_type1=$zuqiubc.$gunqiu.$bet_type;
		$bet_type1_tw=$zuqiubc_tw.$gunqiu_tw.$bet_type_tw;
		$bet_type1_en=$zuqiubc_en.$gunqiu_en.$bet_type_en;
		$bet_type=$zuqiubc."<br>".$gunqiu." - ".$bet_type;
		$bet_type_tw=$zuqiubc_tw."<br>".$gunqiu_tw." - ".$bet_type_tw;
		$bet_type_en=$zuqiubc_en."<br>".$gunqiu_en." ".$bet_type_en;

	}

	if ($w_m_rate=='' or $grape==''){
		//echo $w_m_rate."--".$grape;exit;
		echo "<script language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit;
	}
	if ($w_m_rate<>$c_m_rate){
	//echo $w_m_rate."<>".$c_m_rate;exit;
		echo "<script language='javascript'>self.location='$turn_url';</script>";
		exit;
	}

	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	$M_Rate1=$M_Rate;

	$lines2=$row['M_League']."<br>".$w_mb_team."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team."<br>";
	$lines2=$lines2."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_tw=$row['M_League_tw']."<br>".$w_mb_team_tw."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_tw."<br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_en=$row['M_League_en']."<br>".$w_mb_team_en."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_en."<br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";
	
	
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

	$sql = "INSERT INTO web_db_io(odd_type,tick,pretick,wtype,auth_code,hidden,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,BetIP,pay_type,corpor_turn,orderby,corpor_point,status,BetType1,BetType1_tw,BetType1_en) values ('$odd_type','$tick','$pretick','RT','$auth_code','$hidden','$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$bet_type1','$bet_type1_tw','$bet_type1_en')";
	mysql_db_query($dbname,$sql) or die ($pwno);

	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];
$havemoney=$HMoney-(($M_Rate<0 && $odd_type=='I')?abs($M_Rate*$gold):$gold);
	$logdate=date('Y-m-d',strtotime($logdate));
	if($sDate==date('Y-m-d') || $logdate<date('Y-m-d')){
		$sql = "update web_member set Money='$havemoney',cancel=1 where memname='$memname'";
		mysql_db_query($dbname,$sql) or die ($pwno);
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
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><?=$name1?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> <font class="radio">vs</font> <?=$s_tg_team?></span></div>
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
<script>
parent.parent.header.reloadPHP1.location.href='../reloadCredit.php?uid=<?=$uid?>&langx=<?=$langx?>';
</script>
<?
}
}
mysql_close();
?>
