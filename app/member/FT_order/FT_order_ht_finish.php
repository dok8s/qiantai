<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select status,cancel,super,hidden,ID,Money,Memname,Agents,world,corprator,OpenType,language,pay_type,hidden from web_member where Oid='$uid' and Oid<>'' and Status<>0 order by ID";
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
if($memrow['status']!=1){exit;}
order_accept($uid,$dbname);

require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");
$odd_f_type=$_REQUEST['odd_f_type'];


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
	echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit();
}else{
	$memname=$memrow['Memname'];
	$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";	
	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}
	$HMoney=$memrow['Money'];


	if ($HMoney < $gold){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
	$accept=0;
	$agid=$memrow['Agents'];
	$world=$memrow['world'];
	$corprator=$memrow['corprator'];$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];

	$w_ratio=1;

	$w_current=$memrow['CurType'];

	$havemoney=$HMoney-$gold;
	$memid=$memrow['ID'];

	//取出写入数据库的四种语言的客队名称
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


	//根据下注的类型进行处理：构建成新的数据格式，准备写入数据库
	$order='A';

		$bet_type=$ruqiushu;
		$bet_type_tw=$ruqiushu_tw;
		$bet_type_en=$ruqiushu_en;
		
		//$caption=$RqsOrder;
		$turn_rate="FT_Turn_T";
		switch ($gtype){
		case "HT0":
			$w_m_place='0';
			$w_m_place_tw='0';
			$w_m_place_en='0';
			$s_m_place='0';
			$w_m_rate=$row["ior_HT0"];
			break;
		case "HT1":
			$w_m_place='1';
			$w_m_place_tw='1';
			$w_m_place_en='1';
			$s_m_place='1';
			$w_m_rate=$row["ior_HT1"];
			break;
		case "HT2":
			$w_m_place='2';
			$w_m_place_tw='2';
			$w_m_place_en='2';
			$s_m_place='2';
			$w_m_rate=$row["ior_HT2"];
			break;
		case "HTOV":
			$w_m_place='3或以上';
			$w_m_place_tw='3或以上';
			$w_m_place_en='3up';
			$s_m_place=$san;
			$w_m_rate=$row["ior_HTOV"];
			break;
		}
		$turn="FT_Turn_T";
		$Sign="vs.";
		$order='B';
		$gwin=($s_m_rate-1)*$gold;
		$w_wtype='T';
		$w_rtype=$gtype;

	$bottom1=" - <font color=#666666>[上半]</font>";
	$bottom1_tw=" - <font color=#666666>[上半]</font>";
	$bottom1_en=" - <font color=#666666>[1st half]</font>";
	$Sign="vs.";
	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	$w_mb_mid='';
	$w_tg_mid='';
	
	$w_mid1="<br>[".$row['MB_MID']."]vs[".$row[TG_MID]."]<br>";
	$w_mid='<br>';
	$bet_type1=$zuqiubc.$bet_type;
	$bet_type1_tw=$zuqiubc_tw.$bet_type_tw;
	$bet_type1_en=$zuqiubc_en.$bet_type_en;
	if ($M_Date==date('m-d')){
		$bet_type=$zuqiubc."<br>".$bet_type;
		$bet_type_tw=$zuqiubc_tw."<br>".$bet_type_tw;
		$bet_type_en=$zuqiubc_en."<br>".$bet_type_en;
		$caption=$Soccer;
	}else{
		$caption=$Soccer." - ".$zaopan;
		$bet_type=$zuqiubc." - ".$zaopanbc."<br>".$bet_type;
		$bet_type_tw=$zuqiubc_tw." - ".$zaopanbc_tw."<br>".$bet_type_tw;
		$bet_type_en=$zuqiubc_en." - ".$zaopanbc_en."<br>".$bet_type_en;
	}

	$s_m_place=filiter_team(trim($s_m_place));


	$lines2=$row['M_League'].$w_mid.$w_mb_team."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team."<br>";
	$lines2=$lines2."<FONT color=#cc0000><b>$w_m_place</b></FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_tw=$row['M_League_tw'].$w_mid.$w_mb_team_tw."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_tw."<br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000><b>$w_m_place_tw</b></FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_en=$row['M_League_en'].$w_mid.$w_mb_team_en."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_en."<br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000><b>$w_m_place_en</b></FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";
	
	

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

	$sql = "INSERT INTO web_db_io(odd_type,wtype,auth_code,hidden,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,BetIP,pay_type,corpor_turn,orderby,corpor_point,status,BetType1,BetType1_tw,BetType1_en) values ('$odd_f_type','T','$auth_code','$hidden','$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$bet_type1','$bet_type1_tw','$bet_type1_en')";
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
if($gtype=="ODD" or $gtype=="EVEN"){
	$name1=$strOdd."/".$strEven;
	}else{
	$name1=$rqs;
	}
?>
<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
</head>
<body   id="OFIN" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$caption?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><font color="#FF0000"><?=$body_sb?></font> - <?=$name1?></div>
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
<script>
parent.parent.header.reloadPHP1.location.href='../reloadCredit.php?uid=<?=$uid?>&langx=<?=$langx?>';
</script>
<?
}
}
mysql_close();
?>
