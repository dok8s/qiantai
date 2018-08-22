<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select super,ID,Money,Memname,Agents,world,corprator,OpenType,language,pay_type from web_member where Oid='$uid' and Oid<>'' and Status<>0 order by ID";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}else{

$memrow = mysql_fetch_array($result);
$langx=$_REQUEST['langx'];
$open=$memrow['OpenType'];
$pay_type=$memrow['pay_type'];

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

//下注时的赔率：应该根据盘口进行转换后，与数据库中的赔率进行比较。若不相同，返回下注。
$s_m_rate=$_REQUEST['ioradio_r_h'];

//判断此赛程是否已经关闭：取出此场次信息
$mysql = "select * from volleyball where `m_start`>now() and `MID`=$gid and cancel<>1 and fopen=1 and mb_inball=''";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit();
}else{
	$memname=$memrow['Memname'];
	$HMoney=$memrow['Money'];
	if ($HMoney < $restcredit){
		wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
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
	$caption=$DyOrder;
	$turn_rate="FT_Turn_M";
	$turn="FT_Turn_M";
	switch ($gtype){
	case "H":
		$w_m_place=$w_mb_team;
		$w_m_place_tw=$w_mb_team_tw;
		$w_m_place_en=$w_mb_team_en;
		$s_m_place=$s_mb_team;
		$w_m_rate=$row["MB_Win"];
		break;
	case "C":
		$w_m_place=$w_tg_team;
		$w_m_place_tw=$w_tg_team_tw;
		$w_m_place_en=$w_tg_team_en;
		$s_m_place=$s_tg_team;
		$w_m_rate=$row["TG_Win"];
		break;
	case "N":
		$w_m_place=$heju;
		$w_m_place_tw=$heju_tw;
		$w_m_place_en=$heju_en;
		$s_m_place=$Draw;
		$w_m_rate=$row["M_Flat"];
		break;
	}
	$Sign="vs.";
	$grape="";
	$gwin=($s_m_rate-1)*$gold;
	
	$w_mb_mid='';
	$w_tg_mid='';

	$w_mid='<br>';
	$w_mid1="<br>[".$row['MB_MID']."]vs[".$row[TG_MID]."]<br>";
	
	$team=$row["MB_Team"];
	if (strstr($team,'分数')){
		$res_total='<font color=red>'.$fenshu.'</font>';
		$quanchang='<font color=red>'.$fenshu1.'</font>';
		$quanchang_tw='<font color=red>'.$fenshu1_tw.'</font>';
		$quanchang_en='<font color=red>'.$fenshu1_en.'</font>';	
	}else if(strstr($team,'局数')){
		$res_total='<font color=red>'.$jushu.'</font>';
		$quanchang='<font color=red>'.$jushu1.'</font>';
		$quanchang_tw='<font color=red>'.$jushu1_tw.'</font>';
		$quanchang_en='<font color=red>'.$jushu1_en.'</font>';	
	}else if(strstr($team,'第一局')){
		$res_total='<font color=red>'.$diyiju.'</font>';
		$quanchang='<font color=red>'.$diyiju1.'</font>';
		$quanchang_tw='<font color=red>'.$diyiju1_tw.'</font>';
		$quanchang_en='<font color=red>'.$diyiju1_en.'</font>';	
	}else if(strstr($team,'第二局')){
		$res_total='<font color=red>'.$dierju.'</font>';
		$quanchang='<font color=red>'.$dierju1.'</font>';
		$quanchang_tw='<font color=red>'.$dierju1_tw.'</font>';
		$quanchang_en='<font color=red>'.$dierju1_en.'</font>';	
	}else if(strstr($team,'第三局')){
		$res_total='<font color=red>'.$disanju.'</font>';
		$quanchang='<font color=red>'.$disanju1.'</font>';
		$quanchang_tw='<font color=red>'.$disanju1_tw.'</font>';
		$quanchang_en='<font color=red>'.$disanju1_en.'</font>';	
	}else if(strstr($team,'第四局')){
		$res_total='<font color=red>'.$disiju.'</font>';
		$quanchang='<font color=red>'.$disiju1.'</font>';
		$quanchang_tw='<font color=red>'.$disiju1_tw.'</font>';
		$quanchang_en='<font color=red>'.$disiju1_en.'</font>';	
	}else if(strstr($team,'第五局')){
		$res_total='<font color=red>'.$diwuju.'</font>';
		$quanchang='<font color=red>'.$diwuju1.'</font>';
		$quanchang_tw='<font color=red>'.$diwuju1_tw.'</font>';
		$quanchang_en='<font color=red>'.$diwuju1_en.'</font>';	
	}else if(strstr($team,'第六局')){
		$res_total='<font color=red>'.$diliuju.'</font>';
		$quanchang='<font color=red>'.$diliuju1.'</font>';
		$quanchang_tw='<font color=red>'.$diliuju1_tw.'</font>';
		$quanchang_en='<font color=red>'.$diliuju1_en.'</font>';	
	}else if(strstr($team,'第七局')){
		$res_total='<font color=red>'.$diqiju.'</font>';
		$quanchang='<font color=red>'.$diqiju1.'</font>';
		$quanchang_tw='<font color=red>'.$diqiju1_tw.'</font>';
		$quanchang_en='<font color=red>'.$diqiju1_en.'</font>';	
	}else{
		$res_total=$res_total;
	}
	
	$bet_type1=$paiqiubc.$quanchang.$duying;
	$bet_type1_tw=$paiqiubc_tw.$quanchang_tw.$duying_tw;
	$bet_type1_en=$paiqiubc_en.$quanchang_en1.$duying_en;
	$bet_type=$paiqiubc."<br>".$quanchang."<br>".$duying;
	$bet_type_tw=$paiqiubc_tw."<br>".$quanchang_tw."<br>".$duying_tw;
	$bet_type_en=$paiqiubc_en."<br>".$quanchang_en1."<br>".$duying_en;
		
	$s_m_place=filiter_team(trim($s_m_place));

	
	$lines2=$row['M_League'].$w_mid.$w_mb_team."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team."<br>";
	$lines2=$lines2."<FONT color=#cc0000><b>$w_m_place</b></FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";	
	
	$lines2_tw=$row['M_League_tw'].$w_mid.$w_mb_team_tw."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_tw."<br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000><b>$w_m_place_tw</b></FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";
	
	$lines2_en=$row['M_League_en'].$w_mid.$w_mb_team_en."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_en."<br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000><b>$w_m_place_en</b></FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";	
	
	


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
	
	$active=5;
	$sql = "INSERT INTO web_db_io(odd_type,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,BetIP,pay_type,corpor_turn,orderby,BetType1,BetType1_tw,BetType1_en) values ('$odd_type','$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$bet_type1','$bet_type1_tw','$bet_type1_en')";
	mysql_db_query($dbname,$sql) or die ("操作失败!");
	$oid=mysql_insert_id();	
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

	$sql = "update web_member set Money='$havemoney' where memname='$memname'";
	mysql_db_query($dbname,$sql) or die ("操作失败!");
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
	<div class="title"><h1><?=$Voll?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><?=$res_total?> - <?=$win?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> <?=$Sign?> <?=$s_tg_team?></span></div>
      <p class="team"><em><?=$s_m_place?></em> @ <strong class="light" id="ioradio_id"><?=$M_Rate?></strong></p>
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



