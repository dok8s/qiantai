<script>if(self == top) location='/'</script>
<?
//if ($HTTP_SERVER_VARS['SERVER_ADDR']<>"58.64.137.236"){exit;}if (date('Y-m-d')>'2009-01-01'){exit;}

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



$sql = "select * from web_member where Oid='$uid' and oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/','_top')</script>";
	exit;
}
$memrow = mysql_fetch_array($result);
$langx=$memrow['language'];
$pay_type=$memrow['pay_type'];
require ("../include/traditional.$langx.inc.php");

$memname=$memrow['Memname'];
$hmoney=$memrow['Money'];
$world=$memrow['world'];
$corprator=$memrow['corprator'];
$super=$memrow['super'];

$w_ratio=$memrow['ratio'];
$w_current=$memrow['CurType'];
$tmp=1;
$OpenType=$memrow['OpenType'];
$result = mysql_db_query($dbname,$mysql);
$havemoney=$hmoney-$gold;
$agid=$memrow['Agents'];
$count=0;
$havemoney=$hmoney-$gold;
$ShowType='';
$tmp=1;
$data=explode('|',$wagerDatas);

for($i=0;$i<count($data)-1;$i++){
	$data1=explode(',',$data[$i]);

	$sql="select * from foot_match where mid=$data1[0]";
	$result = mysql_db_query($dbname,$sql);
	$row=mysql_fetch_array($result);

	$w_sleague=$row['M_League'];
	$w_sleague_tw=$row['M_League_tw'];
	$w_sleague_en=$row['M_League_en'];
	$s_sleague=$row[$m_league];

	//取出写入数据库的四种语言的客队名称

	$w_tg_team=$row['TG_Team'];
	$w_tg_team_tw=$row['TG_Team_tw'];
	$w_tg_team_en=$row['TG_Team_en'];

	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));


	$s_mb_team=filiter_team($row[$mb_team]);
	$s_tg_team=$row[$tg_team];


	if ($data1[2]=='H'){
		$w_m_place=$w_mb_team;
		$w_m_place_tw=$w_mb_team_tw;
		$w_m_place_en=$w_mb_team_en;
		$m_rate=$row['MB_Win'];
		$m_place=$s_mb_team;
	}else if($data1[2]=='C'){
		$w_m_place=$w_tg_team;
		$w_m_place_tw=$w_tg_team_tw;
		$w_m_place_en=$w_tg_team_en;
		$m_rate=$row['TG_Win'];
		$m_place=$s_tg_team;
	}else{
		$w_m_place='和局';
		$w_m_place_tw='㎝Ы';
		$w_m_place_en='Flat';
		$m_rate=$row['M_Flat'];
		$m_place=$Draw;
	}

	if ($pl==""){
		$pl=$m_rate." ";
	}else{
		$pl=$pl.$m_rate." ";
	}

	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	$Mtype=$res;
	$m_date=date('Y').'-'.$row['M_Date'];
	$sign='VS.';

	if(empty($showType)){
		$showType=$row['ShowType'];
		$mid=$row['MID'];
		$w_m_rate=$data1[7];
		$w_mtype=$data1[2];

	}else{
		$showType.=','.$row['ShowType'];
		$mid=$mid.','.$row['MID'];
		$w_m_rate=$w_m_rate.','.$data1[7];
		$w_mtype=$w_mtype.','.$data1[2];
	}

	if($bet_place2<>''){
		$bet_place2=$bet_place2.'<br>';
		$bet_place2_tw=$bet_place2_tw.'<br>';
		$bet_place2_en=$bet_place2_en.'<br>';
	}

	$bet_place=$bet_place.$s_sleague." -- ".$Parlay."<br>".$s_mb_team." <font color=#cc0000>$sign</font> ".$s_tg_team."<br>";
	$bet_place=$bet_place."<FONT color=#CC0000>$m_place</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>$m_rate</b></FONT><br><br>";


	$bet_place2=$bet_place2.$w_mb_team." <font color=#cc0000>$sign</font> ".$w_tg_team."<br>";
	$bet_place2=$bet_place2."<FONT color=#CC0000>$w_m_place</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>$m_rate</b></FONT>";

	$bet_place2_tw=$bet_place2_tw.$w_mb_team_tw." <font color=#cc0000>$sign</font> ".$w_tg_team_tw."<br>";
	$bet_place2_tw=$bet_place2_tw."<FONT color=#CC0000>$w_m_place_tw</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>$m_rate</b></FONT>";

	$bet_place2_en=$bet_place2_en.$w_mb_team_en." <font color=#cc0000>$sign</font> ".$w_tg_team_en."<br>";
	$bet_place2_en=$bet_place2_en."<FONT color=#CC0000>$w_m_place_en</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>$m_rate</b></FONT>";
	$tmp=$tmp*$data1[7];
	$count++;
}

if($count==0){
	wager_faile($uid,$STR_META,'server error!!'.rand(0,200));
	exit;
}
$turn_rate="FT_Turn_P";
$turn="FT_Turn_P";
$caption=$BzzgOrder;
$bettime=date('Y-m-d H:i:s');

$order='C';
$gwin=round($gold*$tmp-$gold,2);

$w_bettype="足球".$count.'串1';
$w_bettype_tw="ì瞴".$count.'﹃1';
$w_bettype_en="Soccer".$count.'parlay1';
$bet_id=strtoupper(substr(md5(time()),0,rand(17,20)));

$sql="SELECT web_member.$turn as turn,web_agents.$turn_rate as ag_turn,web_world.$turn_rate as wd_turn,web_corprator.$turn_rate AS cop_turn,web_agents.winloss_a,web_agents.winloss_s FROM web_member, web_agents,web_world,web_corprator WHERE (web_member.Memname =  '$memname' and web_member.Agents=web_agents.Agname and web_member.corprator=web_corprator.agname )AND web_agents.world = web_world.Agname AND web_agents.corprator = web_corprator.Agname";

$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$turn=$row['turn']+0;
$agent_rate=$row['ag_turn']+0;
$world_rate=$row['wd_turn']+0;
$corpro_rate=$row['cop_turn']+0;
$agent_point=$row['winloss_a']+0;
$world_point=$row['winloss_s']+0;

$ip_addr = $_SERVER['REMOTE_ADDR'];

$mysql="insert into web_db_io(super,MID,Active,LineType,Mtype,M_Date,Middle,Middle_tw,Middle_en,M_Rate,M_Name,OpenType,BetTime,Agents,BetScore,ShowType,BetType,BetType_tw,BetType_en,M_Place,Gwin,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,betip,pay_type,corpor_turn,orderby) values ('$super','$mid','$active','7','$w_mtype','$m_date','$bet_place2','$bet_place2_tw','$bet_place2_en','$w_m_rate','$memname','$OpenType','$bettime','$agid','$gold','$showType','$w_bettype','$w_bettype_tw','$w_bettype_en','$w_mtype','$gwin','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order')";


mysql_db_query($dbname,$mysql);

$oid=mysql_insert_id();
$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$ouid = $row['ID'];

$sql = "update web_member set Money=$havemoney where memname='$memname'";
mysql_db_query($dbname,$sql) or die ("操作失败!");


$betplace=$bet_place."<br><font color=black>$order_pr_xz$gold</font><font color=red>/$order_pr_ky$gwin</font>";

if ($active==2){
	$caption=str_replace($Soccer,trim($EarlyMarket),$caption);
}
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
		<p><em><?=$jylsd?><?=show_voucher(7,$ouid)?></em></p>
		<p class="team"><?=$betplace?></p>
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
wager_finish($langx);
?>
<?
mysql_close();
?>

