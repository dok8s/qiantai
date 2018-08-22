<?
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
$langx=$_REQUEST['langx'];
$odd_f_type=$_REQUEST['odd_f_type'];
$wagerDatas			=	$_REQUEST['wagerDatas'];

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/','_top')</script>";
	exit;
}
$memrow = mysql_fetch_array($result);
$langx=$memrow['language'];
$pay_type=$memrow['pay_type'];
$hidden=$memrow['hidden'];
require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");
	order_accept($uid,$dbname);

$memname=$memrow['Memname'];
$hmoney=$memrow['Money'];
$world=$memrow['world'];
$corprator=$memrow['corprator'];
$super=$memrow['super'];
//userlog($memname);
$w_ratio=$memrow['ratio'];
$w_current=$memrow['CurType'];
$GMAX_SINGLE=$memrow['BK_PR_Scene'];
$GSINGLE_CREDIT=$memrow['BK_PR_Bet'];
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


	if ($hmoney < $gold){
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
	
for($i=0;$i<count($data)-1;$i++){
	$data1=explode(',',$data[$i]);

	$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and FIND_IN_SET($data1[0],MID)>0 and linetype=8 and active=4";

	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$score=$haverow['BetScore']+0;

	if (($gold+$score > $GMAX_SINGLE) or ($gold+$score > $GSINGLE_CREDIT)){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}


	$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and FIND_IN_SET($data1[0],MID)>0 and linetype=8 and active=3";

	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$score=$haverow['BetScore']+0;

	if (($gold+$score > $GMAX_SINGLE) or ($gold+$score > $GSINGLE_CREDIT)){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}


	$sql="select * from bask_match where mid=$data1[0] and m_start>now() and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>''";
	$result = mysql_db_query($dbname,$sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		wager_order($uid,$langx);
		exit;			
	}
	$row=mysql_fetch_array($result);

	$w_sleague=$row['M_League'];
	$w_sleague_tw=$row['M_League_tw'];
	$w_sleague_en=$row['M_League_en'];
	$s_sleague=$row[$m_league];

	$w_tg_team=$row['TG_Team'];
	$w_tg_team_tw=$row['TG_Team_tw'];
	$w_tg_team_en=$row['TG_Team_en'];

	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));


	switch($data1[2]){
		case 'PRH':
				$lei_b			=	$res_total."-".$bask_letb;
				$s_m_place=$row[$mb_team];
				$w_m_place=$w_mb_team;
				$w_m_place_tw=$w_mb_team_tw;
				$w_m_place_en=$w_mb_team_en;
				$m_rate=$row["MB_PR_LetB_Rate"];
				$Mtype='R_H';
				$sign=$row['M_LetB'];
				$M_Letb=$row['M_LetB'];
				$mmid=$row['MB_MID'];
				break;
			case 'PRC':
				$lei_b			=	$res_total."-".$bask_letb;
				$s_m_place=$row[$tg_team];
				$w_m_place=$w_tg_team;
				$w_m_place_tw=$w_tg_team_tw;
				$w_m_place_en=$w_tg_team_en;
				$m_rate=$row["TG_PR_LetB_Rate"];
				$sign=$row['M_LetB'];
				$M_Letb=$row['M_LetB'];
				$Mtype='R_C';
				$mmid=$row['MB_MID'];
				break;
			case 'POUC':
				$lei_b			=	$res_total."-".$OverUnder2;
				$s_m_place=$body_mb_dimes.$row['M_Dime'];
				$w_m_place='大'.$row['M_Dime'];
				$w_m_place_tw='大'.$row['M_Dime'];;
				$w_m_place_en='Over'.$row['M_Dime'];;
				$m_rate=$row['MB_PR_Dime_Rate'];
				$M_Letb=$w_m_place_en;
				$sign='vs.';
				$Mtype='OU_C';
				$mmid=$row['MB_MID'];
				break;
			case 'POUH':
				$s_m_place=$body_tg_dimes.$row['M_Dime'];
				$lei_b			=	$res_total."-".$OverUnder2;
				$w_m_place='小'.$row['M_Dime'];
				$w_m_place_tw='小'.$row['M_Dime'];;
				$w_m_place_en='Under'.$row['M_Dime'];;
				$m_rate=$row['TG_PR_Dime_Rate'];
				$Mtype='OU_H';
				$M_Letb=$w_m_place_en;
				$sign='vs.';
				$mmid=$row['MB_MID'];
				break;
			case "MH":
				$w_m_place		=	$row["MB_Team"];
				$lei_b			=	$res_total." - ".$win;
				$w_m_place_tw	=	$row["MB_Team_tw"];
				$w_m_place_en	=	$row["MB_Team_en"];
				$s_m_place		=	$row["$mb_team"];
				$m_rate				=	$row['ior_MH'];
				$Mtype				=	'M_H';
				$M_Letb				=	'';
				$sign					=	'vs.';
				$mmid					=	$row['MB_MID'];
				break;
			case "MC":
				$w_m_place		=	$row["TG_Team"];
				$lei_b			=	$res_total." - ".$win;
				$w_m_place_tw	=	$row["TG_Team_tw"];
				$w_m_place_en	=	$row["TG_Team_en"];
				$s_m_place		=	$row["$tg_team"];
				$m_rate				=	$row['ior_MC'];
				$Mtype				=	'M_C';
				$M_Letb				=	'';
				$sign					=	'vs.';
				$mmid					=	$row['TG_MID'];
				break;
			case "PO":
				$w_m_place		=	'单';
				$lei_b			=	$res_total." - ".$OddEven;
				$w_m_place_tw	=	'單';
				$w_m_place_en	=	'Odd';
				$s_m_place		=	$Odd1;
				$m_rate				=	$row["s_single"];
				$Mtype				=	'OE_ODD';
				$M_Letb				=	'';
				$sign					=	'vs.';
				$mmid					=	$row['MB_MID'];
				break;
			case "PE":
				$w_m_place		=	'双';
				$w_m_place_tw	=	'雙';
				$lei_b			=	$res_total." - ".$OddEven;
				$w_m_place_en	=	'Even';
				$s_m_place		=	"$Even1";
				$m_rate				=	$row['s_double'];
				$Mtype				=	'OE_EVEN';
				$M_Letb				=	'';
				$sign					=	'vs.';
				$mmid					=	$row['TG_MID'];
				break;
			}

			if ($row['ShowType']=='H'){
				$s_mb_team=$row[$mb_team];
				$s_tg_team=$row[$tg_team];
				$w_l_team=$w_mb_team;
				$w_l_team_tw=$w_mb_team_tw;
				$w_l_team_en=$w_mb_team_en;
				$w_r_team=$w_tg_team;
				$w_r_team_tw=$w_tg_team_tw;
				$w_r_team_en=$w_tg_team_en;

			}else{
				$s_tg_team=$row[$mb_team];
				$s_mb_team=$row[$tg_team];
				$w_r_team=$w_mb_team;
				$w_r_team_tw=$w_mb_team_tw;
				$w_r_team_en=$w_mb_team_en;
				$w_l_team=$w_tg_team;
				$w_l_team_tw=$w_tg_team_tw;
				$w_l_team_en=$w_tg_team_en;
			}

			$s_tg_team=filiter_team($s_tg_team);
			$s_mb_team=filiter_team($s_mb_team);
			$s_m_place=filiter_team($s_m_place);

			if ($pl==""){
				$pl=$m_rate." ";
			}else{
				$pl=$pl.$m_rate." ";
			}

	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];

	//$Mtype=$res;
	$m_date=date('Y').'-'.$row['M_Date'];


	if(empty($showType)){
		$showType=$row['ShowType'];
		$mid=$row['MID'];
		$w_m_rate=$data1[7];
		$w_mtype=$Mtype;
		$w_mtype2=$M_Letb;
	}else{
		$showType.=','.$row['ShowType'];
		$mid=$mid.','.$row['MID'];
		$w_m_rate=$w_m_rate.','.$m_rate;
		$w_mtype=$w_mtype.','.$Mtype;
		$w_mtype2=$w_mtype2.','.$M_Letb;
	}

	if($bet_place2<>''){
		$bet_place2=$bet_place2.'<br>';
		$bet_place2_tw=$bet_place2_tw.'<br>';
		$bet_place2_en=$bet_place2_en.'<br>';
	}
//	//防空注单
//	if ($mid=='' or $w_m_rate==''){
//		wager_order($uid,$langx);
//		echo "<script language='javascript'>self.location='$turn_url';</script>";
//		exit();
//	}

	$bet_place=$bet_place."<div id=TR$i><div class=\"leag\"><span class=\"leag_txt\">".$s_sleague."</span></div>
    <div class=\"gametype\">".$lei_b."</div>
    <div class=\"teamName\"><span class=\"tName\">".$s_mb_team." <font color=#BB2700>".$sign."</font>".$s_tg_team."</span></div>
    <div class=\"team\" id=\"team".$i."\"><em>".$s_m_place."</em><em></em> @ <strong class=\"light\" id=\"P".$i."\">".number_format($m_rate,2)."</strong></div>
    <p class=\"errorP3\" style=\"display: none\"></p>
  </div>";
  
  if( $count==count($data)-2){

	$bet_place2=$bet_place2."<div><font class=today_league>".$w_sleague."</font><br><font class=his_h>".$w_l_team."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team."</font><BR>";
	$bet_place2=$bet_place2."<FONT class=his_result>$w_m_place</FONT>$bottom1&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div>";
	
	$bet_place2_tw=$bet_place2_tw."<div><font class=today_league>".$w_sleague_tw."</font><br><font class=his_h>".$w_l_team_tw."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team_tw."</font><BR>";
	$bet_place2_tw=$bet_place2_tw."<FONT class=his_result>$w_m_place_tw</FONT>$bottom1_tw&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div>";

	$bet_place2_en=$bet_place2_en."<div><font class=today_league>".$w_sleague_en."</font><br><font class=his_h>".$w_l_team_en."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team_en."</font><BR>";
	$bet_place2_en=$bet_place2_en."<FONT class=his_result>$w_m_place_en</FONT>$bottom1_tw&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div>";
	
	}
	else{
	$bet_place2=$bet_place2."<div><font class=today_league>".$w_sleague."</font><br><font class=his_h>".$w_l_team."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team."</font><BR>";
	$bet_place2=$bet_place2."<FONT class=his_result>$w_m_place</FONT>$bottom1&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div><div class=statement_textbox2></div>";
	
	$bet_place2_tw=$bet_place2_tw."<div><font class=today_league>".$w_sleague_tw."</font><br><font class=his_h>".$w_l_team_tw."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team_tw."</font><BR>";
	$bet_place2_tw=$bet_place2_tw."<FONT class=his_result>$w_m_place_tw</FONT>$bottom1_tw&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div><div class=statement_textbox2></div>";

	$bet_place2_en=$bet_place2_en."<div><font class=today_league>".$w_sleague_en."</font><br><font class=his_h>".$w_l_team_en."</font>&nbsp;". $sign ."&nbsp;<font class=his_a>".$w_r_team_en."</font><BR>";
	$bet_place2_en=$bet_place2_en."<FONT class=his_result>$w_m_place_en</FONT>$bottom1_tw&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($m_rate,2)."</b></FONT></div><div class=statement_textbox2></div>";
	
	}
	
	

	$tmp=$tmp*($data1[7]);
	$count++;
}

if($count==0 && count(explode(',',$mid))<2){

	wager_faile($uid,$STR_META,'server error!!'.rand(0,200));
	exit;
}

$turn_rate="BK_Turn_PR";
$turn="BK_Turn_PR";
$caption=$RqggOrder;
$bettime=date('Y-m-d H:i:s');

$order='C';
$gwin=round($gold*$tmp-$gold,2);

$auth_code=md5($bet_place2_tw.$gold.$w_mtype);

	$w_bettype1=$lanqiubc.$count.'串1';
	$w_bettype1_tw=$lanqiubc_tw.$count.'串1';
	$w_bettype1_en=$lanqiubc_en.$count.'parlay1';
	$w_bettype=$lanqiubc."<br>".$zongheguoguan;
	$w_bettype_tw=$lanqiubc_tw."<br>".$zongheguoguan_tw;
	$w_bettype_en=$lanqiubc_en."<br>".$zongheguoguan_en;

$bet_id=strtoupper(substr(md5(time()),0,rand(17,20)));


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

$ip_addr = $_SERVER['REMOTE_ADDR'];

$mysql="insert into web_db_io(odd_type,wtype,auth_code,super,MID,Active,LineType,Mtype,M_Date,Middle,Middle_tw,Middle_en,M_Rate,M_Name,OpenType,BetTime,Agents,BetScore,ShowType,BetType,BetType_tw,BetType_en,M_Place,Gwin,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,betip,pay_type,corpor_turn,orderby,corpor_point,hidden,BetType1,BetType1_tw,BetType1_en) values ('$odd_f_type','PR','$auth_code','$super','$mid','3','8','$w_mtype','$m_date','$bet_place2','$bet_place2_tw','$bet_place2_en','$w_m_rate','$memname','$OpenType','$bettime','$agid','$gold','$showType','$w_bettype','$w_bettype_tw','$w_bettype_en','$w_mtype2','$gwin','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$hidden','$w_bettype1','$w_bettype1_tw','$w_bettype1_en')";

mysql_db_query($dbname,$mysql);

$oid=mysql_insert_id();
$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$ouid = $row['ID'];

$sql = "update web_member set Money=$havemoney where memname='$memname'";
mysql_db_query($dbname,$sql) or die ("操作失败!");


$betplace=$bet_place;

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
<body id="OFIN" class="bodyset" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$bk_order_rqgg?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=show_voucher(17,$ouid)?></div></div>
    <div class="main"><?=$betplace?>
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
?>

