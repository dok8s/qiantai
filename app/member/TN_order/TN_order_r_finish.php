<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gnum = $_REQUEST['gnum'];

require ("../include/http.class.php");

$sql = "select tick,pretick,status,cancel,hidden,super,ID,Money,Memname,Agents,world,corprator,OpenType,language,ratio,pay_type,TN_R_Scene,TN_R_Bet from web_member where Oid='$uid' and oid<>'' and Status<>0 order by ID";

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
$tick=$memrow['tick'];
	$pretick=$memrow['pretick'];
	
if($memrow['status']!=1){exit;}
order_accept($uid,$dbname);

require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");

//接收传递过来的参数：其中赔率和位置需要进行判断
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$M_Rate=$_REQUEST['ioradio_r_h'];
$active=$_REQUEST['active'];
$gold=$_REQUEST['gold'];
$line=$_REQUEST['line_type'];
$gwin=$_REQUEST['gwin'];
$odd_type=$_REQUEST['odd_f_type'];
//下注时的赔率：应该根据盘口进行转换后，与数据库中的赔率进行比较。若不相同，返回下注。
$s_m_rate=$_REQUEST['ioradio_r_h'];

//判断此赛程是否已经关闭：取出此场次信息
$mysql = "select * from tennis where `m_start`>now() and `MID`=$gid and cancel<>1 and fopen=1 and mb_inball=''";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit();
}else{
	$memname=$memrow['Memname'];
//userlog($memname);
	$sql="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";

	$result1 = mysql_db_query($dbname,$sql);
	$row1 = mysql_fetch_array($result1);

	if($row1['cancel']==2){
		$accept=1;
	}

	$HMoney=$memrow['Money'];
	$GMAX_SINGLE=$memrow['TN_R_Scene'];
	$GSINGLE_CREDIT=$memrow['TN_R_Bet'];

	if ($HMoney <((($_REQUEST['ioradio_r_h']<0 && $odd_type=='I')?abs($_REQUEST['ioradio_r_h']*$gold):$gold))){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}

	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where m_name='$memname' and MID='$gid' and linetype=2 and mtype='$gtype'";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

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
	}$accept=0;
//echo ORDER_ACCEPT;
	$agid=$memrow['Agents'];
	$world=$memrow['world'];
	$corprator=$memrow['corprator'];$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];

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


$cou=count(explode('先开球',$w_tg_team));
if($cou==2){

	$mysql1 = "select * from web_system";
	$result1 = mysql_db_query($dbname,$mysql1);
	$row1 = mysql_fetch_array($result1);
	$mDate=date('m-d');
	switch($langx){
	case "en-us":
		$suid=$row1['uid_en'];
		$site=$row1['datasite_en'];
		break;
	case "zh-tw":
		$suid=$row1['uid_tw'];
		$site=$row1['datasite_tw'];
		break;
	default:
		$suid=$row1['uid_cn'];
		$site=$row1['datasite'];
		break;
	}

	$base_url = "".$site."/app/member/TN_index.php?rtype=r&uid=$suid&langx=zh-cn&mtype=3";
	$thisHttp = new cHTTP();
	$thisHttp->setReferer($base_url);
	$filename="".$site."/app/member/TN_order/TN_order_r.php?gid=$gid&uid=$suid&type=$gtype&gnum=$gnum";

	$thisHttp->getPage($filename);
	$msg  = $thisHttp->getContent();
	$msg_c=explode("@",$msg);

	if(sizeof($msg_c)<2)
	{
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
}

	//取出当前字库的主客队伍名称

	$s_mb_team=filiter_team($row[$mb_team]);
	$s_tg_team=filiter_team($row[$tg_team]);

	//下注时间
	$M_Date=$row["M_Date"];
	$sDate=Date('Y').'-'.$M_Date;
	$showtype=$row["ShowType"];
	$bettime=date('Y-m-d H:i:s');


	//联盟处理:生成写入数据库的联盟样式和显示的样式，二者有区别

	$w_sleague=$row['M_League'];
	$w_sleague_tw=$row['M_League_tw'];
	$w_sleague_en=$row['M_League_en'];
	$s_sleague=$row[$m_league];

	//根据下注的类型进行处理：构建成新的数据格式，准备写入数据库
	$order='A';
		
		$caption=$RqOrder;
		$turn_rate="TN_Turn_R_".$opentype;

$ior=get_other_ioratio($odd_type,change_rate($open,$row["MB_LetB_Rate"]),change_rate($open,$row["TG_LetB_Rate"]),1);

		switch ($gtype){
		case "H":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$s_m_place=$s_mb_team;
			
			$w_m_rate=$ior[0];$ior_m_rate=$ior[1];
			break;
		case "C":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$s_m_place=$s_tg_team;
			
			$w_m_rate=$ior[1];$ior_m_rate=$ior[0];
			break;
		}
		$Sign=$row['M_LetB'];
		$grape=$Sign;
		IF ($showtype=="H"){
			$l_team=$s_mb_team;
			$r_team=$s_tg_team;

			$w_l_team=$w_mb_team;
			$w_l_team_tw=$w_mb_team_tw;
			$w_l_team_en=$w_mb_team_en;
			$w_r_team=$w_tg_team;
			$w_r_team_tw=$w_tg_team_tw;
			$w_r_team_en=$w_tg_team_en;
		}ELSE{

			$r_team=$s_mb_team;
			$l_team=$s_tg_team;

			$w_r_team=$w_mb_team;
			$w_r_team_tw=$w_mb_team_tw;
			$w_r_team_en=$w_mb_team_en;
			$w_l_team=$w_tg_team;
			$w_l_team_tw=$w_tg_team_tw;
			$w_l_team_en=$w_tg_team_en;
		}

		$s_mb_team=$l_team;
		$s_tg_team=$r_team;

		$w_mb_team=$w_l_team;
		$w_mb_team_tw=$w_l_team_tw;
		$w_mb_team_en=$w_l_team_en;

		$w_tg_team=$w_r_team;
		$w_tg_team_tw=$w_r_team_tw;
		$w_tg_team_en=$w_r_team_en;


		$turn="TN_Turn_R";
		$gwin=($s_m_rate)*$gold;
		if ($gnum - 600000 > 0){//让局
			$tit = "让局";
			$rp = $rangju;
			$rp_tw = $rangju_tw;
			$rp_en = $rangju_en;
		}else if ($gnum - 500000 > 0 and $gnum < 600000){//第5盘
			$tit = "让盘 - <font color=#FF0000>第五盘</font>";
			$rp = $rangpan."<br><font color=#FF0000>".$diwuju1."</font>";
			$rp_tw =$rangpan_tw."<br><font color=#FF0000>".$diwuju1_tw."</font>";
			$rp_en = $rangpan_en."<br><font color=#FF0000>".$diwuju1_en."</font>";
		}else if ($gnum - 400000 > 0 and $gnum < 500000){//第4盘
			$tit = "让盘 - <font color=#FF0000>第四盘</font>";
			$rp = $rangpan."<br><font color=#FF0000>".$disiju1."</font>";
			$rp_tw =$rangpan_tw."<br><font color=#FF0000>".$disiju1_tw."</font>";
			$rp_en = $rangpan_en."<br><font color=#FF0000>".$disiju1_en."</font>";
		}else if ($gnum - 300000 > 0 and $gnum < 400000){//第3盘
			$tit = "让盘 - <font color=#FF0000>第三盘</font>";
			$rp = $rangpan."<br><font color=#FF0000>".$disanju1."</font>";
			$rp_tw =$rangpan_tw."<br><font color=#FF0000>".$disanju1_tw."</font>";
			$rp_en = $rangpan_en."<br><font color=#FF0000>".$disanju1_en."</font>";
		}else if ($gnum - 200000 > 0 and $gnum < 300000){//第2盘
			$tit = "让盘 - <font color=#FF0000>第二盘</font>";
			$rp = $rangpan."<br><font color=#FF0000>".$dierju1."</font>";
			$rp_tw =$rangpan_tw."<br><font color=#FF0000>".$dierju1_tw."</font>";
			$rp_en = $rangpan_en."<br><font color=#FF0000>".$dierju1_en."</font>";
		}else if ($gnum - 100000 > 0 and $gnum < 200000){//第1盘
			$tit = "让盘 - <font color=#FF0000>第一盘</font>";
			$rp = $rangpan."<br><font color=#FF0000>".$diyiju1."</font>";
			$rp_tw =$rangpan_tw."<br><font color=#FF0000>".$diyiju1_tw."</font>";
			$rp_en = $rangpan_en."<br><font color=#FF0000>".$diyiju1_en."</font>";
		}else{
			$tit = "让盘";
			$rp = $rangpan;
			$rp_tw = $rangpan_tw;
			$rp_en = $rangpan_en;
		}

	$w_mid1="<br>[".$row['MB_MID']."]vs[".$row[TG_MID]."]<br>";
	$w_mid="<br>";
	$bet_type1=$wangqiubc.$rp;
	$bet_type1_tw=$wangqiubc_tw.$rp_tw;
	$bet_type1_en=$wangqiubc_tw.$rp_en;
	$bet_type=$wangqiubc."<br>".$rp;
	$bet_type_tw=$wangqiubc_tw."<br>".$rp_tw;
	$bet_type_en=$wangqiubc_en."<br>".$rp_en;
	

	$s_m_place=filiter_team(trim($s_m_place));

	//$M_Rate1=$M_Rate;
	$M_Rate1=$M_Rate;
if($M_Rate==0){

wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit();
}
	$lines2=$row['M_League'].$w_mid.$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team."&nbsp;&nbsp;<br>";
	$lines2=$lines2."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_tw=$row['M_League_tw'].$w_mid.$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."&nbsp;&nbsp;<br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines2_en=$row['M_League_en'].$w_mid.$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."&nbsp;&nbsp;<br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";
	
	$lines3=$row['M_League'].$w_mid.$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team."&nbsp;&nbsp;<br><div>$res_total1</div>";
	$lines3=$lines3."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines3_tw=$row['M_League_tw'].$w_mid.$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."&nbsp;&nbsp;<br><div>$res_total_tw</div>";
	$lines3_tw=$lines3_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines3_en=$row['M_League_en'].$w_mid.$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#cc0000><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."&nbsp;&nbsp;<br><div>$res_total_en</div>";
	$lines3_en=$lines3_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";
	
	$lines4=$row['M_League'].$w_mid1.$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team."&nbsp;&nbsp;<br>";
	$lines4=$lines4."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines4_tw=$row['M_League_tw'].$w_mid1.$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."&nbsp;&nbsp;<br>";
	$lines4_tw=$lines4_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$lines4_en=$row['M_League_en'].$w_mid1.$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."&nbsp;&nbsp;<br>";
	$lines4_en=$lines4_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$M_Rate1."</b></FONT>";

	$auth_code=md5($lines2_tw.$gold.$gtype);

	$I_Date=Date('Y')."-".$M_Date;
$ip_addr = $_SERVER['REMOTE_ADDR'];

	$sql="SELECT web_member.$turn as turn,web_agents.winloss_s,web_agents.winloss_a,web_agents.winloss_c,web_agents.$turn_rate as ag_turn,web_world.$turn_rate as wd_turn,web_corprator.$turn_rate AS cop_turn FROM web_member, web_agents,web_world,web_corprator WHERE (web_member.Memname =  '$memname' and web_member.Agents=web_agents.Agname and web_member.corprator=web_corprator.agname )AND web_agents.world = web_world.Agname AND web_agents.corprator = web_corprator.Agname";

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$turn=$row['turn']+0;
	$agent_rate=$row['ag_turn']+0;
	$world_rate=$row['wd_turn']+0;
	$corpro_rate=$row['cop_turn']+0;
	$agent_point=$row['winloss_a']+0;
	$world_point=$row['winloss_s']+0;
	$corpor_point=$row['winloss_c']+0;
$active=4;

$gwin=$w_m_rate>0?($odd_type=='E'?($w_m_rate-1):$w_m_rate)*$gold:$gold;

	$sql = "INSERT INTO web_db_io(odd_type,tick,pretick,wtype,auth_code,hidden,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,Middle1,Middle1_tw,Middle1_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,BetIP,pay_type,corpor_turn,orderby,corpor_point,status,BetType1,BetType1_tw,BetType1_en,Middle2,Middle2_tw,Middle2_en) values ('$odd_type','$tick','$pretick','R','$auth_code','$hidden','$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$lines3','$lines3_tw','$lines3_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$bet_type1','$bet_type1_tw','$bet_type1_en','$lines4','$lines4_tw','$lines4_en')";

	mysql_db_query($dbname,$sql) or die ("操作失败!");
	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

$havemoney=$HMoney-(($M_Rate<0 && $odd_type=='I')?abs($M_Rate*$gold):$gold);

	$sql = "update web_member set Money='$havemoney',cancel=1 where memname='$memname'";
	mysql_db_query($dbname,$sql) or die ("操作失败!");
if ($active==2){
	$caption=str_replace($Soccer,trim($EarlyMarket),$caption);
}
$caption=$Tennis.substr($caption,4,strlen($caption));
?>
<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
</head>
<body   id="OFIN" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$Tennis?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=show_voucher($line,$ouid)?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><?=$tit?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> <font color=#cc0000><?=$Sign?></font> <?=$s_tg_team?></span></div>
      <p class="team"><em><?=$s_m_place?><?=$xzlb?></em> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
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
