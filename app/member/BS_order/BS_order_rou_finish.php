<?
//if ($HTTP_SERVER_VARS['SERVER_ADDR']<>"58.64.137.236"){exit;}if (date('Y-m-d')>'2009-01-01'){exit;}
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
$sql = "select tick,pretick,status,cancel,hidden,super,ID,Money,Memname,Agents,LogDate,world,pay_type,corprator,OpenType,language,BS_ROU_Scene,BS_ROU_Bet from web_member where Oid='$uid' and oid<>'' and Status<>0 order by ID";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$memrow = mysql_fetch_array($result);
	$langx=$memrow['language'];
	$hidden=$memrow['hidden'];
	$logdate=$memrow['LogDate'];
	$accept=$memrow['cancel'];
	$open=$memrow['OpenType'];
	$pay_type=$memrow['pay_type'];
$tick=$memrow['tick'];
	$pretick=$memrow['pretick'];

	if($accept==1 && $not_active==1){
		wager_order($uid,$langx);
		exit;
	}
	order_accept($uid,$dbname);

	require ("../include/traditional.$langx.inc.php");
	require ("../include/traditional.inc.php");
	$odd_f_type=$_REQUEST['odd_f_type'];
$odd_type=$_REQUEST['odd_f_type'];

switch ($odd_f_type){
case "H":
		$ph=$xg;
		$ph_tw=$xg_tw;
		$ph_en=$xg_en;
		break;
case "M":
		$ph=$ml;
		$ph_tw=$ml_tw;
		$ph_en=$ml_en;
		break;
case "I":
		$ph=$yn;
		$ph_tw=$yn_tw;
		$ph_en=$yn_en;
		break;
case "E":
		$ph=$oz;
		$ph_tw=$oz_tw;
		$ph_en=$oz_en;
		break;
}
	if($memrow['status']!=1){exit;}
	$memname=$memrow['Memname'];
	$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";
	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}
	$GMAX_SINGLE=$memrow['BS_ROU_Scene'];
	$GSINGLE_CREDIT=$memrow['BS_ROU_Bet'];
//userlog($memname);
	$HMoney=$memrow['Money'];

	if ($HMoney <((($_REQUEST['ioradio_r_h']<0 && $odd_type=='I')?abs($_REQUEST['ioradio_r_h']*$gold):$gold))){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit();
	}

	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where M_Name='$memname' and MID='$gid' and LineType=10 and Mtype='$gtype'";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore'];
	if ($have_bet==''){
		$have_bet=0;
	}

	if ($have_bet+$gold > $GMAX_SINGLE){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit();
	}

	if ($gold > $GMAX_SINGLE){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit();
	}

	if ($gold > $GSINGLE_CREDIT){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit();
	}$accept=0;

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

	$mysql = "select rcard_h,rcard_c,M_Time,MB_MID,TG_MID,MB_Ball,TG_Ball,M_Flat,M_League,M_League_tw,M_League_en,ShowType,TG_Team_tw,TG_Team_en,MB_Team_tw,MB_Team_en,M_Date,M_Time,MB_Team,TG_Team,M_RE_Dime as M_Dime,mb_re_dime_Rate as MB_Dime_Rate,tg_re_dime_rate as TG_Dime_Rate from baseball where `MID`=$gid and fopen=1";

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
	$inball=$row['MB_Ball'].":".$row['TG_Ball'];
	$inball1=$row['MB_Ball'].":".$row['TG_Ball'].','.$row['rcard_h'].":".$row['rcard_c'];

	if($row['M_Time']=='H/T'){
		$danger=0;
	}else{
		$danger=1;
	}
$danger=0;
	$bet_type='滚球大小';
	$bet_type_tw="簎瞴";
	$bet_type_en="running<br>over/under";

	$caption=$GqdxOrder;
	$turn_rate="BS_Turn_OU_".$opentype;
	switch ($gtype){
	case "C":
		$w_m_place		=	'大'.$row["M_Dime"];
		$w_m_place_tw	=	''.$row["M_Dime"];
		$w_m_place_en	=	'O'.$row["M_Dime"];
		$s_m_place		=	$body_mb_dimes.$row["M_Dime"];
		$w_m_rate			=	change_rate($open,$row["MB_Dime_Rate"]);
		$turn_url=BROWSER_IP."/app/member/BS_order/BS_order_rou.php?gid=".$gid."&uid=".$uid."&type=C&gnum=".$row[TG_MID];
		break;
	case "H":
		$w_m_place		=	'小'.$row["M_Dime"];
		$w_m_place_tw	=	''.$row["M_Dime"];
		$w_m_place_en	=	'U'.$row["M_Dime"];
		$s_m_place		=	$body_tg_dimes.$row["M_Dime"];
		$w_m_rate			=	change_rate($open,$row["TG_Dime_Rate"]);
		$turn_url=BROWSER_IP."/app/member/BS_order/BS_order_rou.php?gid=".$gid."&uid=".$uid."&type=H&gnum=".$row[MB_MID];
		break;
	}

	$Sign="vs.";
	$grape=$w_m_place_en;
	$turn="BS_Turn_OU";
	
$gwin=$w_m_rate>0?($odd_type=='E'?($w_m_rate-1):$w_m_rate)*$gold:$gold;
	$c_m_rate=$_REQUEST['ioradio_r_h'];
	$turn_url=$turn_url.'&change=1';

	$bet_type1="棒球".$bet_type;
	$bet_type1_tw="次瞴".$bet_type_tw;
	$bet_type1_en="BaseBall".$bet_type_en;
	
	$bet_type="棒球<br>".$res_total1."<br>".$bet_type_r_ou;
	$bet_type_tw="次瞴<br>".$res_total_tw."<br>".$bet_type_r_ou_tw;
	$bet_type_en="BaseBall<br>".$res_total_en1."<br>".$bet_type_r_ou_en;

	if ($w_m_rate=='' or $grape==''){
		echo "<script language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit;
	}

	if ($w_m_rate<>$c_m_rate){
		$turn_url=$turn_url.'&change=1';
		echo "<script language='javascript'>self.location='$turn_url';</script>";
		exit;
	}

	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	$M_Rate1=$M_Rate;

	$lines2=$row['M_League']."<br>".$w_mb_team."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines2=$lines2."<FONT color=#cc0000><b>$w_m_place</b></FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_tw=$row['M_League_tw']."<br>".$w_mb_team_tw."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_tw."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000><b>$w_m_place_tw</b></FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_en=$row['M_League_en']."<br>".$w_mb_team_en."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_en."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000><b>$w_m_place_en</b></FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";
	
	
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
	$active=7;
	$line=10;
	$sql = "INSERT INTO web_db_io(odd_type,tick,pretick,wtype,auth_code,hidden,QQ526738,danger,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,BetIP,pay_type,corpor_turn,orderby,corpor_point,status,BetType1,BetType1_tw,BetType1_en) values ('$odd_type','$tick','$pretick','ROU','$auth_code','$hidden','$inball1','$danger','$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$bet_type1','$bet_type1_tw','$bet_type1_en')";
	mysql_db_query($dbname,$sql) or die ("操作失败!!");

	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

$havemoney=$HMoney-(($M_Rate<0 && $odd_type=='I')?abs($M_Rate*$gold):$gold);
	$logdate=date('Y-m-d',strtotime($logdate));
	if($sDate==date('Y-m-d') || $logdate<date('Y-m-d')){
		$sql = "update web_member set Money='$havemoney',cancel=1 where memname='$memname'";
		mysql_db_query($dbname,$sql) or die ("操作失败!");
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
	<div class="title"><h1><?=$bangqiu?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div><div class="fin_acc1" style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px; "><?=$weixian?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><?=$res_total?> <?=$run?> - <?=$OverUnder2?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> vs. <?=$s_tg_team?> <font color="#BB2636"><strong>(<?=$inball?>)</strong></font></span></div>
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
if($danger==0){
	wager_finish($langx);
}else{
	wager_finish_re($langx);
}
}
mysql_close();
?>
