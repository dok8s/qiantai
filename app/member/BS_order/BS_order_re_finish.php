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
$sql = "select tick,pretick,status,cancel,hidden,super,ID,Money,Memname,Agents,world,pay_type,LogDate,corprator,OpenType,language,BS_RE_Scene,BS_RE_Bet from web_member where Oid='$uid' and oid<>'' and Status<>0 order by ID";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$memrow = mysql_fetch_array($result);
	$langx=$memrow['language'];
	$logdate=$memrow['LogDate'];
	$GMAX_SINGLE=$memrow['BS_RE_Scene'];
	$GSINGLE_CREDIT=$memrow['BS_RE_Bet'];
	$open=$memrow['OpenType'];
	$hidden=$memrow['hidden'];
	$accept=$memrow['cancel'];
	$tick=$memrow['tick'];
	$pretick=$memrow['pretick'];
	$active=1;
	$open=$memrow['OpenType'];
	$pay_type=$memrow['pay_type'];
	require ("../include/traditional.$langx.inc.php");
	require ("../include/traditional.inc.php");
	$odd_f_type=$_REQUEST['odd_f_type'];




	$memname=$memrow['Memname'];
	if($accept==1 && $not_active==1){
		wager_order($uid,$langx);
		exit;
	}
	if($memrow['status']!=1){exit;}
	order_accept($uid,$dbname);
//userlog($memname);
	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where M_Name='$memname' and MID='$gid' and LineType=9 and Mtype='$gtype'";
	$result = mysql_db_query($dbname,$havesql);

	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

		$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";
	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}

	$HMoney=$memrow['Money'];

	if ($HMoney <((($_REQUEST['ioradio_r_h']<0 && $odd_type=='I')?abs($_REQUEST['ioradio_r_h']*$gold):$gold))){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit();
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

	$mysql = "select * from baseball where `MID`=$gid and fopen=1";
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

	//联盟
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
	$order='A';

	$inball1=$row['mb_ball'].":".$row['tg_ball'].','.$row['rcard_h'].":".$row['rcard_c'];

	if($row['M_Time']=='H/T'){
		$danger=0;
	}else{

		$danger=1;
	}
$danger=0;
 		

		$caption=$GqOrder;
		$turn_rate="BS_Turn_RE_".$opentype;
		$ior=get_other_ioratio($odd_type,change_rate($open,$row["MB_RE_LetB_Rate"]),change_rate($open,$row["TG_RE_LetB_Rate"]),1);
	switch ($gtype){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$s_mb_team;
			$w_m_rate=$ior[0];$ior_m_rate=$ior[1];
			$turn_url=BROWSER_IP."/app/member/BS_order/BS_order_re.php?gid=".$gid."&uid=".$uid."&type=H&gnum=".$row[TG_MID];
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$s_tg_team;
			$w_m_rate=$ior[1];$ior_m_rate=$ior[0];
			$turn_url=BROWSER_IP."/app/member/BS_order/BS_order_re.php?gid=".$gid."&uid=".$uid."&type=C&gnum=".$row[MB_MID];
			break;
		}

		$Sign=$row['M_RE_LetB'];
		$grape=$Sign;
		if ($showtype==''){
			$turn_url=$turn_url.'&change=1';
			echo "<script language='javascript'>self.location='$turn_url';</script>";
			exit;
		}

		if ($grape==''){
			$turn_url=$turn_url.'&change=1';
			echo "<script language='javascript'>self.location='$turn_url';</script>";
			exit;
		}

		IF (strtoupper($showtype)=="H"){
			$l_team=$s_mb_team;
			$r_team=$s_tg_team;
			$w_l_team=$w_mb_team;
			$w_l_team_tw=$w_mb_team_tw;
			$w_l_team_en=$w_mb_team_en;
			$w_r_team=$w_tg_team;
			$w_r_team_tw=$w_tg_team_tw;
			$w_r_team_en=$w_tg_team_en;
			$inball=$row['mb_ball'].":".$row['tg_ball'];
		}ELSE{
			$r_team=$s_mb_team;
			$l_team=$s_tg_team;
			$w_r_team=$w_mb_team;
			$w_r_team_tw=$w_mb_team_tw;
			$w_r_team_en=$w_mb_team_en;
			$w_l_team=$w_tg_team;
			$w_l_team_tw=$w_tg_team_tw;
			$w_l_team_en=$w_tg_team_en;
			$inball=$row['tg_ball'].":".$row['mb_ball'];

		}
		$s_mb_team=$l_team;
		$s_tg_team=$r_team;

		$w_mb_team=$w_l_team;
		$w_mb_team_tw=$w_l_team_tw;
		$w_mb_team_en=$w_l_team_en;

		$w_tg_team=$w_r_team;
		$w_tg_team_tw=$w_r_team_tw;
		$w_tg_team_en=$w_r_team_en;

		$turn="BS_Turn_RE";
		$gwin=$w_m_rate>0?($odd_type=='E'?($w_m_rate-1):$w_m_rate)*$gold:$gold;


	$c_m_rate=$_REQUEST['ioradio_r_h'];
	$turn_url=$turn_url.'&change=1';

	$bet_type1=$bangqiubc.$quanchang.$gunqiu.$rangqiu;
	$bet_type1_tw=$bangqiubc_tw.$quanchang_tw.$gunqiu_tw.$rangqiu_tw;
	$bet_type1_en=$bangqiubc_en.$quanchang_en1.$gunqiu_en.$rangqiu_en;
	$bet_type=$bangqiubc."<br>".$quanchang."<br>".$gunqiu." - ".$rangfen;
	$bet_type_tw=$bangqiubc_tw."<br>".$quanchang_tw."<br>".$gunqiu_tw." - ".$rangqiu_tw;
	$bet_type_en=$bangqiubc_en."<br>".$quanchang_en1."<br>".$gunqiu_en." ".$rangqiu_en;

	if ($w_m_rate=='' or $grape==''){
		echo "<script language='javascript'>self.location='$turn_url';</script>";
		exit();
	}

	if ($w_m_rate<>$c_m_rate){
		echo "<script language='javascript'>self.location='$turn_url';</script>";
		exit();
	}
	if ($w_m_place=='' or $s_m_place==''){
		echo "<script language='javascript'>self.location='$turn_url';</script>";
		exit();
	}

	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	$M_Rate1=$M_Rate;

	$lines2=$row['M_League']."<br>".$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines2=$lines2."<FONT color=#cc0000><b>$w_m_place</b></FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_tw=$row['M_League_tw']."<br>".$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000><b>$w_m_place_tw</b></FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_en=$row['M_League_en']."<br>".$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
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
	$line=9;
	$sql = "INSERT INTO web_db_io(odd_type,tick,pretick,wtype,auth_code,hidden,QQ526738,danger,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,BetIP,pay_type,corpor_turn,orderby,corpor_point,status,BetType1,BetType1_tw,BetType1_en) values ('$odd_type','$tick','$pretick','RE','$auth_code','$hidden','$inball1','$danger','$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$bet_type1','$bet_type1_tw','$bet_type1_en')";
	mysql_db_query($dbname,$sql) or die ("操作失败!");

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
<body  id="OFIN" class="bodyset" onSelectStart="parent.event.returnValue=false" oncontextmenu="parent.event.returnValue=false;window.event.returnValue=false;" >
<div class="ord">
	<div class="title"><h1><?=$bangqiu?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div><div class="fin_acc1" style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px; "><?=$weixian?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><?=$res_total?> <?=$run?> - <?=$rang?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> <font color=#CC0000><?=$Sign?></font> <?=$s_tg_team?> <font color="#BB2636"><strong>(<?=$inball?>)</strong></font></span></div>
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

