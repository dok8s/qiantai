<?
include "../include/library.mem.php";
//echo "<script>if(self == top) parent.location='".BROWSER_IP."'<script>\n";
require ("../include/http.class.php");
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
//order_r15.php?gid=1814788&uid=77e3468c1fd915l8059&odd_f_type=H&langx=zh-cn&rtype=ARC&gnum=60385&strong=H&type=C&wtype=AR
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$wtype=$_REQUEST['wtype'];
$rtype=$_REQUEST['rtype'];
$strong=$_REQUEST['strong'];
$change=$_REQUEST['change'];
$odd_type=$_REQUEST['odd_f_type'];
$odd_f_type=$_REQUEST['odd_f_type'];
$sql = "select Memname,FT_R_Scene,FT_R_Bet,OpenType,language,pay_type,Money from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}else{

	wager_danger($uid,$dbname);order_accept($uid,$dbname);

	$langx=$_REQUEST['langx'];
	//$body_js=getcss($langx);
	$pay_type=$row['pay_type'];
	require ("../include/traditional.$langx.inc.php");

	if ($change==1){
		$bet_title=$nobettitle;
	}
	
	switch($wtype){
		case 'AR':
			$M_LetB='ratio_ar';
			$MB_LetB_Rate='ior_ARH';
			$TG_LetB_Rate='ior_ARC';
			$r=$kaichang." - 14:59".$fenzhong;
			break;
		case 'BR':
			$M_LetB='ratio_br';
			$MB_LetB_Rate='ior_BRH';
			$TG_LetB_Rate='ior_BRC';
			$r="15:00 - 29:59".$fenzhong;
			break;
		case 'CR':
			$M_LetB='ratio_cr';
			$MB_LetB_Rate='ior_CRH';
			$TG_LetB_Rate='ior_CRC';
			$r="30:00 - ".$banchang;
			break;
		case 'DR':
			$M_LetB='ratio_dr';
			$MB_LetB_Rate='ior_DRH';
			$TG_LetB_Rate='ior_DRC';
			$r=$xiabanchangkaishi." - 59:59".$fenzhong;
			break;
		case 'ER':
			$M_LetB='ratio_er';
			$MB_LetB_Rate='ior_ERH';
			$TG_LetB_Rate='ior_ERC';
			$r="60:00 - 74:59".$fenzhong;
			break;
		case 'FR':
			$M_LetB='ratio_fr';
			$MB_LetB_Rate='ior_FRH';
			$TG_LetB_Rate='ior_FRC';
			$r="75:00 - ".$quanchang;
			break;
	
	}

	$mysql = "select M_Start,maxgold,mb_team as team,M_Date,M_Time,$mb_team as MB_Team,MB_Team_en as MB_Team1,$tg_team as TG_Team,$m_league as M_League,ShowType,$MB_LetB_Rate as MB_LetB_Rate,$TG_LetB_Rate as TG_LetB_Rate,$M_LetB as M_LetB from foot_match where `m_start`>now() and `MID`=$gid and cancel<>1 and fopen=1 and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit;
	}else{
		$memname=$row['Memname'];
		$credit=$row['Money'];
		//userlog($memname);
		$GMAX_SINGLE=$row['FT_R_Scene'];
		$GSINGLE_CREDIT=$row['FT_R_Bet'];
		$open=$row['OpenType'];

		$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where m_name='$memname' and MID='$gid' and linetype=202 and mtype='$gtype'";
		$result1 = mysql_db_query($dbname,$havesql);
		$haverow = mysql_fetch_array($result1);
		$have_bet=$haverow['BetScore']+0;

		$row = mysql_fetch_array($result);
		//赛事前五分钟封盘
	$enddate=$row["M_Start"];
	$startdate=date('Y-m-d H:i:s');
	$minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
		/*赛事前五分钟封盘
		$enddate=$row["M_Start"];
		$startdate=date('Y-m-d H:i:s');
		$minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
		if($minute<=5)
		{
			wager_order($uid,$langx);
			echo "<script  language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';<script>";
		}
		*/
		$maxgold=$row['maxgold'];
		$btset=singleset('r');
		$GMIN_SINGLE=$btset[0];
		if($GSINGLE_CREDIT>$maxgold){
			$bettop=$maxgold;
		}else{
			$bettop=$GSINGLE_CREDIT;
		}

		if ($row['M_Date']==date('m-d')){
			$active=1;
			$css="OFT";
			$caption=$Soccer;
		}	else{
			$active=2;
			$css="OFU";
			$caption=$Soccer." - ".$zaopan;
		}

		if ($row['M_Sleague']==''){
			$m_league=$row['M_League'];
		}
		else{
			$m_league=$row['M_Sleague'];
		}

		$MB_Team=$row["MB_Team"];
		$TG_Team=$row["TG_Team"];
		$MB_Team=filiter_team($MB_Team);
		$TG_Team=filiter_team($TG_Team);
		$Sign=$row['M_LetB'];

		$ior=get_other_ioratio($odd_type,change_rate($open,$row["MB_LetB_Rate"]),change_rate($open,$row["TG_LetB_Rate"]),1);

		switch ($gtype){
		case "H":
			$M_Place=$MB_Team;
			$M_Rate=$ior[0];
			break;
		case "C":
			$M_Place=$TG_Team;
			$M_Rate=$ior[1];
			break;
		}
		if ($row['ShowType']=='C')
		{
			$Team=$MB_Team;
			$MB_Team=$TG_Team;
			$TG_Team=$Team;
		}
$team=$row["team"];
//echo $row["MB_Team1"];
$cou=count(explode('To Kick Off',$row["MB_Team1"]));
if($cou==2){

	if($minute<=5)
	{
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>pr.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	}
}


$bettop=maxgold($bettop,$M_Rate);
	?>
	<HTML>
	<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
<script language="JavaScript" src="/js/football_order1.js"></script>
	</head>
	<!-- onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;"-->
<body id="OFT"  class="bodyset" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_r15_finish.php" method="post" onSubmit="return false">
<div class="ord">
	<div class="title"><h1><?=$caption?></h1><div class="tiTimer" onClick="orderReload();"><span id="ODtimer">10</span><input type="checkbox" id="checkOrder" onClick="onclickReloadTime()" checked value="10"></div></div>
    <div class="main">
	  <div class="leag"><?=$m_league?></div>
      <div class="gametype"><?=$res_total?> - 15<?=$fenzhong?><?=$jinqiushu?>:<?=$r?> - <?=$rang?></div>
      <div class="teamName"><span class="tName"><?=$MB_Team?> <font color=#CC0000><?=$Sign?></font> <?=$TG_Team?></span></div>
      <p class="team"><em><?=$M_Place?></em> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
      <p class="auto"><input type="checkbox" id="autoOdd" name="autoOdd" onClick="onclickReloadAutoOdd()" checked value="Y"><span class="auto_info" title="<?=$zdjs_title?>"><?=$zdjs?></span></p>
      <p class="error" style="display: none;"></p>
      <div class="betdata">
          <p class="amount"><?=$Xzjr?><input name="gold" type="text" class="txt" id="gold" onKeyPress="return CheckKey(event)" onKeyUp="return CountWinGold1()" size="8" maxlength="10"></p>
          <p class="mayWin"><span class="bet_txt"><?=$Kyje?></span><font id="pc">0</font></p>
          <p class="minBet"><span class="bet_txt"><?=$Zdxe?></span><?=number_format($GMIN_SINGLE)?></p>
          <p class="maxBet"><span class="bet_txt"><?=$Dczg?></span><?=number_format($bettop)?></p>
    </div>
    </div>
  <div id="gWager" style="display: none;position: absolute;"></div>
  <div id="gbutton" style="display: block;position: absolute;"></div>
  <div class="betBox">
    <input type="button" name="btnCancel" value="<?=$Qxxz?>" onClick="parent.close_bet();" class="no">
    <input type="button" name="Submit" value="<?=$Qdxz?>" onClick="CountWinGold1();return SubChk();" class="yes">
  </div>
</div>
  <div id="gfoot" style="display: block;position: absolute;"></div>
  <div class="ord" id="line_window" style="display: none;">
    <div class="betChk" id="gdiv_table">
      <span class="notice">*SHOW_STR*</span>
      <input type="button" name="wgCancel" value="<?=$Qxxz?>" onClick="Close_div();" class="no">
      <input type="button" name="wgSubmit" value="<?=$Qdxz?>" onmousedown='Sure_wager();' class="yes">
    </div>
  </div>

<input type="hidden" value="<?=$uid?>" name=uid>
<input type="hidden" value="<?=$langx?>" name=langx>
	<input type="hidden" value="<?=$gid?>" name=gid>
	<INPUT type="hidden" id=ioradio_r_h  value="<?=number_format($M_Rate,2)?>" name=ioradio_r_h>
	<input type="hidden" value="<?=$bettop?>" name=gmax_single>
	<input type="hidden" value="<?=$GMIN_SINGLE?>" name=gmin_single>
	<input type="hidden" value="<?=$GMAX_SINGLE?>" name=singlecredit>
	<input type="hidden" value="<?=$GSINGLE_CREDIT?>" name=singleorder>
	<input type="hidden" value="<?=$active?>" name=active>
	<input type="hidden" value="0" name=gwin>
	<input type="hidden" value="202" name=line_type>
	<input type="hidden" value="<?=$pay_type?>" name=pay_type>
	<input type="hidden" value="<?=$gtype?>" name=type>
	<input type="hidden" value="<?=$rtype?>" name=rtype>
	<input type="hidden" value="<?=$wtype?>" name=wtype>
	<input type="hidden" value="<?=$have_bet?>" name=restsinglecredit>
	<input type="hidden" value="<?=$credit?>" name=restcredit>
	<input type="hidden" value="<?=$odd_f_type?>" name=odd_f_type>
</form>
</body>
</html>
	<?
	}
}
mysql_close();
?>

