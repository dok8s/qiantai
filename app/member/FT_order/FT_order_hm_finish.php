<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select status,cancel,hidden,super,ID,Money,Memname,Agents,world,corprator,OpenType,language,pay_type from web_member where Oid='$uid' and Oid<>'' and Status<>0 order by ID";
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
$hidden=$memrow['hidden'];
$accept=$memrow['cancel'];
//if($accept==1 && $not_active==1){
//	wager_order($uid,$langx);
//	exit;
//}
order_accept($uid,$dbname);

require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");
$odd_f_type=$_REQUEST['odd_f_type'];
if($memrow['status']!=1){exit;}
//接收传递过来的参数：其中赔率和位置需要进行判断
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$M_Rate=$_REQUEST['ioradio_r_h'];
$active=$_REQUEST['active'];
$gold=$_REQUEST['gold'];
$line=$_REQUEST['line_type'];
$gwin=$_REQUEST['gwin'];

//下注时的赔率：应该根据盘口进行转换后，与数据库中的赔率进行比较。若不相同，返回下注。
$s_m_rate=$_REQUEST['ioradio_r_h'];

//判断此赛程是否已经关闭：取出此场次信息
$mysql = "select * from foot_match where `m_start`>now() and `MID`=$gid and cancel<>1 and fopen=1 and mb_inball=''";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
	exit();
}else{
	$memname=$memrow['Memname'];
//userlog($memname);
	$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";
	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}

	$HMoney=$memrow['Money'];
	if ($HMoney < $gold){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit();
	}

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
	$w_tg_team1=filiter_team1($row['TG_Team']);
	$w_tg_team1_tw=filiter_team1($row['TG_Team_tw']);
	$w_tg_team1_en=filiter_team1($row['TG_Team_en']);

	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	$w_mb_team1=filiter_team1($row['MB_Team']);
	$w_mb_team1_tw=filiter_team1($row['MB_Team_tw']);
	$w_mb_team1_en=filiter_team1($row['MB_Team_en']);
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
	$btype="-<font color=red><b>[$body_sb]</b></font>";
	$caption=$SbdyOrder;
	$turn_rate="FT_Turn_M";
	$turn="FT_Turn_M";
	switch ($gtype){
	case "H":
		$w_m_place=$w_mb_team;
		$w_m_place_tw=$w_mb_team_tw;
		$w_m_place_en=$w_mb_team_en;
		$w_m_place1=$w_mb_team." -<font color=gray>[".$shangban."]</font>";
		$w_m_place1_tw=$w_mb_team_tw." -<font color=gray>[".$shangban_tw."]</font>";
		$w_m_place1_en=$w_mb_team_en." -<font color=gray>[".$shangban_en1."]</font>";
		$s_m_place=$row[$mb_team];
		$w_m_rate=$row["MB_Win"];
		break;
	case "C":
		$w_m_place=$w_tg_team;
		$w_m_place_tw=$w_tg_team_tw;
		$w_m_place_en=$w_tg_team_en;
		$w_m_place1=$w_tg_team." -<font color=gray>[".$shangban."]</font>";
		$w_m_place1_tw=$w_tg_team_tw." -<font color=gray>[".$shangban_tw."]</font>";
		$w_m_place1_en=$w_tg_team_en." -<font color=gray>[".$shangban_en1."]</font>";
		$s_m_place=$row[$tg_team];
		$w_m_rate=$row["TG_Win"];
		break;
	case "N":
		$w_m_place=$heju;
		$w_m_place_tw=$heju_tw;
		$w_m_place_en=$heju_en;
		$w_m_place1=$heju." -<font color=gray>[".$shangban."]</font>";
		$w_m_place1_tw=$heju_tw." -<font color=gray>[".$shangban_tw."]</font>";
		$w_m_place1_en=$heju_en." -<font color=gray>[".$shangban_en1."]</font>";
		$s_m_place=$Draw;
		$w_m_rate=$row["M_Flat"];
	break;
	}
	$Sign="vs.";
	$grape="";
	$gwin=($s_m_rate-1)*$gold;
	$w_rtype='VM';
	$w_wtype='V';

	$bottom1_tw="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
	$bottom1="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
	$bottom1_en="<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";

	$w_mid="<br>";
	$w_mid1="<br>[".$row['MB_MID']."]vs[".$row[TG_MID]."]<br>";
	$bet_type1=$zuqiubc.$banchang.$duying;
	$bet_type1_tw=$zuqiubc_tw.$banchang_tw.$duying_tw;
	$bet_type1_en=$zuqiubc_en.$banchang_en.$duying_en;
	if ($row['M_Date']==date('m-d')){
	$caption=$Soccer;
	$bet_type=$zuqiubc."<br>".$banchang."<br>".$duying;
	$bet_type_tw=$zuqiubc_tw."<br>".$banchang_tw."<br>".$duying_tw;
	$bet_type_en=$zuqiubc_en."<br>".$banchang_en."<br>".$duying_en;
	}
	else{
	$caption=$Soccer." - ".$zaopan;
	$bet_type=$zuqiubc." - ".$zaopanbc."<br>".$banchang."<br>".$duying;
	$bet_type_tw=$zuqiubc_tw." - ".$zaopanbc_tw."<br>".$banchang_tw."<br>".$duying_tw;
	$bet_type_en=$zuqiubc_en." - ".$zaopanbc_en."<br>".$banchang_en."<br>".$duying_en;
	}

	$s_m_place=filiter_team(trim($s_m_place));



	$M_Rate1=$M_Rate;
	$lines2=$row['M_League'].$w_mid.$w_mb_team."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team."<br>";
	$lines2=$lines2."<FONT color=#cc0000>$w_m_place1</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_tw=$row['M_League_tw'].$w_mid.$w_mb_team_tw."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_tw."<br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000>$w_m_place1_tw</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_en=$row['M_League_en'].$w_mid.$w_mb_team_en."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_en."<br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000>$w_m_place1_en</FONT>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";
	

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
	$cor_point=$row['winloss_c']+0;

	$accept=0;

	$sql = "INSERT INTO web_db_io(odd_type,wtype,auth_code,hidden,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,betip,pay_type,corpor_turn,orderby,corpor_point,status,BetType1,BetType1_tw,BetType1_en) values ('$odd_f_type','HM','$auth_code','$hidden','$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate1','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$bet_type1','$bet_type1_tw','$bet_type1_en')";
	mysql_db_query($dbname,$sql) or die ($pwno);
	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

	$sql = "update web_member set Money='$havemoney',cancel=1 where memname='$memname'";
	mysql_db_query($dbname,$sql) or die ($pwno);
//if ($active==2){
//	$caption=str_replace($Soccer,trim($EarlyMarket),$caption);
//}

?>
<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
</head>
<body  id="OFIN" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$caption?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><font color="#FF0000"><?=$res_half?></font> - <?=$win?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> vs. <?=$s_tg_team?></span></div>
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
</body>
</html>
<?
}
}
mysql_close();
?>
