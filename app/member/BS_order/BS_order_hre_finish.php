<?

//if ($HTTP_SERVER_VARS['SERVER_ADDR']<>"58.64.137.236"){exit;}if (date('Y-m-d')>'2009-01-01'){exit;}
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

include "../include/library.mem.php";

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
$gnum=$_REQUEST['gnum'];
$restcredit=$_REQUEST['restcredit'];
$odd_type=$_REQUEST['odd_f_type'];
$sql = "select super,ID,Money,Memname,Agents,world,pay_type,corprator,LogDate,OpenType,language from web_member where Oid='$uid' and oid<>'' and Status<>0 order by ID";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}else{
	$memrow = mysql_fetch_array($result);
	$langx=$memrow['language'];
	$logdate=$memrow['LogDate'];
	$open=$memrow['OpenType'];
	$pay_type=$memrow['pay_type'];
	require ("../include/traditional.$langx.inc.php");
	require ("../include/traditional.inc.php");
	$odd_f_type=$_REQUEST['odd_f_type'];

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
	$memname=$memrow['Memname'];
	$HMoney=$memrow['Money'];

	if ($HMoney <((($_REQUEST['ioradio_r_h']<0 && $odd_type=='I')?abs($_REQUEST['ioradio_r_h']*$gold):$gold))){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit();
	}

	$agid=$memrow['Agents'];
	$world=$memrow['world'];
	$corprator=$memrow['corprator'];$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];
	$w_current=$memrow['CurType'];

	$havemoney=$HMoney-$gold;
	$memid=$memrow['ID'];
	$bettime=date('Y-m-d H:i:s');

	$mysql = "select * from foot_match where `MID`=$gid and fopen=1";

	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	//主客队伍名称
	$w_tg_team=filiter_team($row['TG_Team']);
	$w_tg_team_tw=filiter_team($row['TG_Team_tw']);
	$w_tg_team_en=filiter_team($row['TG_Team_en']);

	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));

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

	$inball1=$row['mb_ball'].":".$row['tg_ball'];

	if($row['M_Time']=='H/T'){

		$danger=0;
	}else{

		$danger=1;
	}
	$bet_type='半场让球';
	$bet_type_tw="半场让球";
	$bet_type_en="running ball";

	$caption=$GqOrder;
	$turn_rate="FT_Turn_RE_".$opentype;
	$ior=get_other_ioratio($odd_type,change_rate($open,$row["MB_RE_LetB_Rate"]),change_rate($open,$row["TG_RE_LetB_Rate"]),1);
	switch ($gtype){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$s_mb_team;
			$w_m_rate=$ior[0];$ior_m_rate=$ior[1];
			$turn_url="/app/member/FT_order/FT_order_hre.php?gid=".$gid."&uid=".$uid."&type=H&gnum=".$row[TG_MID];
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$s_tg_team;
			$w_m_rate=$ior[1];$ior_m_rate=$ior[0];
			$turn_url="/app/member/FT_order/FT_order_hre.php?gid=".$gid."&uid=".$uid."&type=C&gnum=".$row[MB_MID];
			break;
	}

	$Sign=$row['M_RE_LetB'];
	$grape=$Sign;

	if ($showtype==''){
		$turn_url=$turn_url.'&change=1';
		echo "<script language='javascript'>self.location='$turn_url';</script>";
		exit();
	}

	if ($grape==''){
		$turn_url=$turn_url.'&change=1';
		echo "<script language='javascript'>self.location='$turn_url';</script>";
		exit();
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

	$turn="FT_Turn_RE";
	$gwin=$w_m_rate>0?($odd_type=='E'?($w_m_rate-1):$w_m_rate)*$gold:$gold;

	$w_rtype='RE';
	$w_wtype='R';

	$c_m_rate=$_REQUEST['ioradio_r_h'];
	$turn_url=$turn_url.'&change=1';

	$bet_type="足球".$bet_type;
	$bet_type_tw="足球".$bet_type_tw;
	$bet_type_en="Soccer 1st".$bet_type_en;
	$btype="-<font color=red><b>[$body_sb]</b></font>";

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

	$bottom1="&nbsp;-&nbsp;<font color=#666666>[上半]</font>";
	$bottom1_tw="&nbsp;-&nbsp;<font color=#666666>[上半]</font>";
	$bottom1_en="&nbsp;-&nbsp;</font><font color=#666666>[1st Half]</font>";

	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

//$M_Rate1=$M_Rate;
	$M_Rate1=$M_Rate;

	$lines2=$row['M_League']."<br>[".$row['MB_MID'].']vs['.$row['TG_MID']."]<br>".$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines2=$lines2."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;".$bottom1."&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_tw=$row['M_League_tw']."<br>[".$row['MB_MID'].']vs['.$row['TG_MID']."]<br>".$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;".$bottom1_tw."&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_en=$row['M_League_en']."<br>[".$row['MB_MID'].']vs['.$row['TG_MID']."]<br>".$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."&nbsp;&nbsp;<FONT color=red><b>$inball</b></FONT><br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;".$bottom1_tw."&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$I_Date=Date('Y')."-".$M_Date;
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$sql="SELECT web_member.$turn as turn,web_agents.$turn_rate as ag_turn,web_world.$turn_rate as wd_turn,web_corprator.$turn_rate AS cop_turn,web_agents.winloss_a,web_agents.winloss_s FROM web_member, web_agents,web_world,web_corprator WHERE (web_member.Memname =  '$memname' and web_member.Agents=web_agents.Agname and web_member.corprator=web_corprator.agname )AND web_agents.world = web_world.Agname AND web_agents.corprator = web_corprator.Agname";

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$turn=$row['turn']+0;
	$agent_rate=$row['ag_turn']+0;
	$world_rate=$row['wd_turn']+0;
	$corpro_rate=$row['cop_turn']+0;
	$agent_point=$row['winloss_a']+0;
	$world_point=$row['winloss_s']+0;


	$sql = "INSERT INTO web_db_io(odd_type,ior_m_rate,QQ10000,danger,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,BetIP,pay_type,corpor_turn,orderby,pankou,pankou_tw,pankou_en) values ('$odd_type','$ior_m_rate','$inball1','$danger','$super','$gid','$active','19','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$ph','$ph_tw','$ph_en')";
	mysql_db_query($dbname,$sql) or die ("操作失败!");


	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

	$havemoney=$HMoney-(($M_Rate<0 && $odd_type=='I')?abs($M_Rate*$gold):$gold);
	$logdate=date('Y-m-d',strtotime($logdate));
	if($sDate==date('Y-m-d') || $logdate<date('Y-m-d')){
		$sql = "update web_member set Money='$havemoney' where memname='$memname'";
		mysql_db_query($dbname,$sql) or die ("操作失败!");
	}
	mysql_close();
	?>
	<html>
	<head>
		<title>ft_r_order_finish</title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">

		<link rel="stylesheet" href="/style/member/mem_order.css" type="text/css">
		<script>window.setTimeout("self.location='../select.php?uid=<?=$uid?>'", 45000);</script>
	</head>
	<body id="OFIN" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
	<div class="ord">
		<span><h1><?=$caption?></h1></span>
		<div id="info">
			<p><?=$Name?><?=$memname?></p>
			<p><?=$Money?><?=$havemoney?></p>
			<p><em><?=$jylsd?><?=show_voucher($line,$ouid)?></em></p>
			<?
			if($danger==1){
				?>
				<p align=center><em><strong><font color=white><font style=background-color=red><?=$zzqrzd?></font></font></strong></em></p>
				<?
			}
			?><p class="team"><?=$s_sleague?>&nbsp;<?=$btype?>&nbsp;<?=$M_Date?><BR><?=$inball?>&nbsp;&nbsp;<?=$s_mb_team?>&nbsp;&nbsp;<font color=#cc0000><?=$Sign?></font>&nbsp;&nbsp;<?=$s_tg_team?>
				<br><em><?=$s_m_place?></em>@<em><strong><?=$M_Rate?></strong></em></p>
			<p><?=$Xzjr?><?=$gold?></p>
			<p><?=$Kyje?><FONT id=pc color=#cc0000><?=$gwin?></FONT></p>
		</div>
		<p class="foot">
			<input type="button" name="FINISH" value="<?=$Likai?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
			<input type="button" name="PRINT" value="<?=$Prints?>" onClick="window.print()" class="yes">
		</p>
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

