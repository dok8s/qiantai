<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$langx=$_REQUEST['langx'];
$sql = "select BK_OU_Scene,BK_OU_Bet,status,cancel,super,ID,Money,Memname,Agents,world,corprator,OpenType,language,pay_type,hidden from web_member where Oid='$uid' and Oid<>'' and Status<>0 order by ID";

$result = mysql_db_query($dbname,$sql);

$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$memrow = mysql_fetch_array($result);

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
$odd_type=$_REQUEST['odd_f_type'];
//下注时的赔率：应该根据盘口进行转换后，与数据库中的赔率进行比较。若不相同，返回下注。
$s_m_rate=$_REQUEST['ioradio_r_h'];

//判断此赛程是否已经关闭：取出此场次信息
$mysql = "select * from bask_match where `MID`=$gid  and cancel<>1 and fopen=1 and mb_inball=''";//and M_Start>now()
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	wager_order($uid,$langx);
}else{
	$memname=$memrow['Memname'];
	$HMoney=$memrow['Money'];
	$agid=$memrow['Agents'];
	$world=$memrow['world'];
	$corprator=$memrow['corprator'];
	$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];
	$w_current=$memrow['CurType'];
	$accept=$memrow['cancel'];

	$GMAX_SINGLE=$memrow['BK_OU_Scene'];
	$GSINGLE_CREDIT=$memrow['BK_OU_Bet'];
//userlog($memname);
	$havemoney=$HMoney-$gold;
	$memid=$memrow['ID'];

	if ($HMoney <((($_REQUEST['ioradio_r_h']<0 && $odd_type=='I')?abs($_REQUEST['ioradio_r_h']*$gold):$gold))){
		wager_order($uid,$langx);
	}

	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where m_name='$memname' and MID='$gid' and M_Date>now()";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = @mysql_fetch_array($result);
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
	}

	$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}$accept=0;
	if($memrow['status']!=1){exit;}

	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));

	$w_tg_team=filiter_team(trim($row['TG_Team']));
	$w_tg_team=filiter_team(trim($row['TG_Team']));
	$w_tg_team_tw=filiter_team(trim($row['TG_Team_tw']));
	$w_tg_team_tw=filiter_team(trim($row['TG_Team_tw']));
	$w_tg_team_en=filiter_team(trim($row['TG_Team_en']));
	$w_tg_team_en=filiter_team(trim($row['TG_Team_en']));

	//取出当前字库的主客队伍名称

	$s_tg_team=filiter_team($row[$tg_team]);
	$s_mb_team=filiter_team($row[$mb_team]);

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

		$caption=$bk_order_dx;
		$turn_rate="BK_Turn_OU_".$opentype;
		$ior=get_other_ioratio($odd_type,change_rate($open,$row["MB_Dime_Rate"]),change_rate($open,$row["TG_Dime_Rate"]),1);
		switch ($gtype){
	case "C":
		$w_m_place		=	'大'.$row["M_Dime"];
		$w_m_place_tw	=	'大'.$row["M_Dime"];
		$w_m_place_en	=	'Over'.$row["M_Dime"];
		$s_m_place		=	$body_mb_dimes.$row["M_Dime"];
		$w_m_rate=$ior[1];
		$ior_m_rate=$ior[0];
		$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_ou.php?gid=".$gid."&uid=".$uid."&type=C&gnum=".$row[TG_MID];
		break;
	case "H":
		$w_m_place		=	'小'.$row["M_Dime"];
		$w_m_place_tw	=	'小'.$row["M_Dime"];
		$w_m_place_en	=	'Under'.$row["M_Dime"];
		$s_m_place		=	$body_tg_dimes.$row["M_Dime"];
		$w_m_rate=$ior[0];$ior_m_rate=$ior[1];
		$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_ou.php?gid=".$gid."&uid=".$uid."&type=H&gnum=".$row[MB_MID];
		break;
	}
		$turn_url=$turn_url."&odd_f_type=$odd_type";
		//水位与数据库水位不等时提示
		if ($M_Rate<>$w_m_rate){
			$turn_url=$turn_url.'&change=1';
			echo "<script language='javascript'>self.location='$turn_url';</script>";
			exit;
		}
		

//		//防空注单
//		if ($w_m_place=='' or $s_m_place=='' or $w_m_place_tw=='' or $w_m_place_en==''){
//			wager_order($uid,$langx);
//			echo "<script language='javascript'>self.location='$turn_url';</script>";
//			exit();
//		}

		$team=$row['MB_Team'];
		$wtype='OU';
		if (strstr($team,'上半')){
			$xzlb=' - <font color=gray>['.$body_sb.']</font>';
			$xzlb1=' - <font color=gray>['.$shangban.']</font>';
			$xzlb2=' - <font color=gray>['.$shangban_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$shangban_en1.']</font>';
			
			$bet_type=$shangban;
			$bet_type_tw=$shangban_tw;
			$bet_type_en=$shangban_en1;
			$wtype='HR';
		}else if(strstr($team,'下半')){
			$xzlb=' - <font color=gray>['.$body_xb.']</font>';
			$xzlb1=' - <font color=gray>['.$xiaban.']</font>';
			$xzlb2=' - <font color=gray>['.$xiaban_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$xiaban_en1.']</font>';
			
			$bet_type=$xiaban;
			$bet_type_tw=$xiaban_tw;
			$bet_type_en=$xiaban_en1;
		}else if(strstr($team,'第1节')){
			$xzlb=' - <font color=gray>['.$part1.']</font>';
			$xzlb1=' - <font color=gray>['.$diyijie.']</font>';
			$xzlb2=' - <font color=gray>['.$diyijie_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$diyijie_en.']</font>';
			
			$bet_type=$diyijie;
			$bet_type_tw=$diyijie_tw;
			$bet_type_en=$diyijie_en;

		}else if(strstr($team,'第2节')){
			$xzlb=' - <font color=gray>['.$part2.']</font>';
			$xzlb1=' - <font color=gray>['.$dierjie.']</font>';
			$xzlb2=' - <font color=gray>['.$dierjie_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$dierjie_en.']</font>';
			
			$bet_type=$dierjie;
			$bet_type_tw=$dierjie_tw;
			$bet_type_en=$dierjie_en;

		}else if(strstr($team,'第3节')){
			$xzlb=' - <font color=gray>['.$part3.']</font>';
			$xzlb1=' - <font color=gray>['.$disanjie.']</font>';
			$xzlb2=' - <font color=gray>['.$disanjie_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$disanjie_en.']</font>';
			
			$bet_type=$disanjie;
			$bet_type_tw=$disanjie_tw;
			$bet_type_en=$disanjie_en;
		}else if(strstr($team,'第4节')){
			$xzlb=' - <font color=gray>['.$part4.']</font>';
			$xzlb1=' - <font color=gray>['.$disijie.']</font>';
			$xzlb2=' - <font color=gray>['.$disijie_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$disijie_en.']</font>';
			
			$bet_type=$disijie;
			$bet_type_tw=$disijie_tw;
			$bet_type_en=$disijie_en;
		}else{
			$xzlb='';
			$xzlb1='';
			$xzlb2='';
			$xzlb3='';
			
			$bet_type=$quanchang;
			$bet_type_tw=$quanchang_tw;
			$bet_type_en=$quanchang_en1;
		}

		$Sign="vs.";
		$grape=$w_m_place_en;
		$turn="BK_Turn_Ou";
		$gwin=$w_m_rate>0?($odd_type=='E'?($w_m_rate-1):$w_m_rate)*$gold:$gold;


	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	$w_mid1="<br>[".$row['MB_MID']."]vs[".$row[TG_MID]."]<br>";
	$bet_type1=$lanqiubc.$bet_type.$daxiao;
	$bet_type1_tw=$lanqiubc_tw.$bet_type_tw.$daxiao_tw;
	$bet_type1_en=$lanqiubc_en.$bet_type_en.$daxiao_en;
	$bet_type=$lanqiubc."<br>".$bet_type."<br>".$daxiao;
	$bet_type_tw=$lanqiubc_tw."<br>".$bet_type_tw."<br>".$daxiao_tw;
	$bet_type_en=$lanqiubc_en."<br>".$bet_type_en."<br>".$daxiao_en;
	if ($w_m_rate==''){
		echo "<script language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
	$s_m_place=filiter_team(trim($s_m_place));
	$w_mid='<br>';

	$lines2=$w_sleague.$w_mid.$w_mb_team."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team."<br>";
	$lines2=$lines2."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;$bottom1&nbsp$xzlb1@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_tw=$w_sleague_tw.$w_mid.$w_mb_team_tw."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_tw."<br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;$bottom1_tw&nbsp$xzlb2@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_en=$w_sleague_en.$w_mid.$w_mb_team_en."&nbsp;&nbsp;".$Sign."&nbsp;&nbsp;".$w_tg_team_en."<br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;$bottom1_en&nbsp$xzlb3@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";
	
	

	$I_Date=Date('Y')."-".$M_Date;
$ip_addr = $_SERVER['REMOTE_ADDR'];

	$auth_code=md5($lines2_tw.$gold.$gtype);

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

	$sql = "INSERT INTO web_db_io(odd_type,wtype,auth_code,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,betip,pay_type,corpor_turn,orderby,corpor_point,status,hidden,BetType1,BetType1_tw,BetType1_en) values ('$odd_type','$wtype','$auth_code','$super','$gid','3','3','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$hidden','$bet_type1','$bet_type1_tw','$bet_type1_en')";
	mysql_db_query($dbname,$sql) or die ("error!");

	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

	$havemoney=$HMoney-(($M_Rate<0 && $odd_type=='I')?abs($M_Rate*$gold):$gold);

	$sql = "update web_member set Money='$havemoney',cancel=1 where memname='$memname'";
	mysql_db_query($dbname,$sql) or die ("error!");

?>


<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
</head>
<body   id="OFIN" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$BasketBall?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><?=$res_total?> - <?=$OverUnder2?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> <?=$Sign?> <?=$s_tg_team?></span></div>
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
mysql_close();
}
?>
