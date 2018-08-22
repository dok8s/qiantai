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
}

$memrow = mysql_fetch_array($result);
$langx=$_REQUEST['langx'];
$open=$memrow['OpenType'];
$pay_type=$memrow['pay_type'];
$hidden=$memrow['hidden'];
$accept=$memrow['cancel'];

order_accept($uid,$dbname);

require ("../include/traditional.$langx.inc.php");
switch($gametype){
case 'FT':
 		$langname=$Soccer;
		break;
case 'BK':
		$langname=$BasketBall;
		break;
case 'TN':
		$langname=$Tennis;
		break;
case 'BS':
		$langname=$bangqiu;
		break;
case 'VB':
		$langname=$Voll;
		break;
case 'OP':
		$langname=$qita;
		break;
}
if($memrow['status']!=1){exit;}
//接收传递过来的参数：其中赔率和位置需要进行判断
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$rate=$_REQUEST['ioradio_fs'];
$active=$_REQUEST['active'];
$gold=$_REQUEST['gold'];
$line=$_REQUEST['line_type'];
$gwin=$_REQUEST['gwin'];

//下注时的赔率：应该根据盘口进行转换后，与数据库中的赔率进行比较。若不相同，返回下注。
$s_rate=$_REQUEST['ioradio_fs'];

//判断此赛程是否已经关闭：取出此场次信息
$mysql = "select * from sp_match where mid=$gid and mshow='Y'";

$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	wager_order($uid,$langx);
}else{
	$memname=$memrow['Memname'];
	$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";
	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}
//userlog($memname);
	$HMoney=$memrow['Money'];
	if ($HMoney < $gold){
		echo "<script language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
		exit();
	}

	$agid=$memrow['Agents'];
	$world=$memrow['world'];
	$corprator=$memrow['corprator'];
	$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];

	$w_ratio=1;

	$w_current=$memrow['CurType'];

	$havemoney=$HMoney-$gold;
	$memid=$memrow['ID'];


	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_team=filiter_team(trim($row['team']));
	$w_team=filiter_team(trim($row['team']));
	$w_team_tw=filiter_team(trim($row['team_tw']));
	$w_team_tw=filiter_team(trim($row['team_tw']));
	$w_team_en=filiter_team(trim($row['team_en']));
	$w_team_en=filiter_team(trim($row['team_en']));

	//取出当前字库的主客队伍名称
	//$gid=$row["mid"];


	//下注时间
	$sDate=substr($row["mstart"],0,10);


	$M_Date=substr($row["mstart"],5,5);

	//$showtype=$row["ShowType"];
	$bettime=date('Y-m-d H:i:s');
	$mtype=$row['gid'];

	//联盟处理:生成写入数据库的联盟样式和显示的样式，二者有区别
	$s_sleague=$row[$ssleague].'<br>'.$row[$sleague];

	//根据下注的类型进行处理：构建成新的数据格式，准备写入数据库

	$bet_type='总冠军';
	$bet_type_tw="羆玜瓁";
	$bet_type_en="Especial";
	$caption=$SBdxOrder;
	$accept=0;
	$turn="FS_Turn_R";
	$turn_rate="FS_Turn_R";

	$w_m_place=$row["team"];
	$w_m_place_tw=$row["team_tw"];
	$w_m_place_en=$row["team_en"];
	$s_m_place=$row[$team];
	$w_rate=$row["rate"];


	$Sign="";

	$gwin=($s_rate-1)*$gold;
	$w_rtype='M';
	$w_wtype='R';
	$w_mid='<br>';

	$s_m_place=filiter_team(trim($s_m_place));

	$lines2=$row['sleague'].'<br>'.$row['league'].'<br><FONT color=#cc0000>'.$w_team."</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
	$lines2_tw=$row['sleague_tw'].'<br>'.$row['league_tw'].'<br><FONT color=#cc0000>'.$w_team_tw."</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
	$lines2_en=$row['sleague_en'].'<br>'.$row['league_en'].'<br><FONT color=#cc0000>'.$w_team_en."</font>&nbsp;@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";

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


	$sql = "INSERT INTO web_db_io(wtype,auth_code,hidden,super,MID,Active,LineType,Mtype,M_Date,BetScore,m_rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,betip,pay_type,corpor_turn,orderby,corpor_point,status) values ('FS','$auth_code','$hidden','$super','$gid','$active','$line','$mtype','$I_Date','$gold','$rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','D','$corpor_point','$accept')";

	mysql_db_query($dbname,$sql) or die ("操作失败!");
	$ouid=mysql_insert_id();

	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

	$sql = "update web_member set Money='$havemoney',cancel=1 where memname='$memname'";
	mysql_db_query($dbname,$sql) or die ("操作失败!");
?>

<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
</head>
<!-- -->
<body   id="OFIN" class="bodyset" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$langname?> - <?=$Guan?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <p class="team"><em><?=$s_m_place?></em> @ <strong class="light" id="ioradio_id"><?=number_format($rate,2)?></strong></p>
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
mysql_close();
?>
