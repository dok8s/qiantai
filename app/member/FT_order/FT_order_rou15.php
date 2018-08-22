<?
include "../include/library.mem.php";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$odd_type=$_REQUEST['odd_f_type'];
$odd_f_type=$_REQUEST['odd_f_type'];
$gnum=$_REQUEST['gnum'];
$change=$_REQUEST['change'];
$rtype=$_REQUEST['rtype'];
$wtype=$_REQUEST['wtype'];

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/','_top')</script>";
	exit;
}
$langx=$_REQUEST['langx'];
//$body_js=getcss($langx);
$pay_type=$row['pay_type'];
wager_danger($uid,$dbname);order_accept($uid,$dbname);

require ("../include/traditional.$langx.inc.php");
/////////////////////////////////////////////////////////////////////

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
$base_url = "".$site."/app/member/FT_index.php?rtype=re&uid=$suid&mtype=3";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename="".$site."/app/member/FT_order/FT_order_rou15.php?gid=$gid&uid=$suid&type=$gtype&gnum=$gnum&odd_f_type=H&langx=$langx&wtype=$wtype&rtype=$rtype";

$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$msg_c=explode("@",$msg);

if(sizeof($msg_c)<2)
{	
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit();
}else{
	$ms=explode("<em class=\"bold\">(",$msg);
	$ms=explode(")",$ms[1]);
	$t_inball=$ms[0];
}

////////////////////////////////////////////////////////////////////
if ($change==1){
	$bet_title=$nobettitle;
}

switch($wtype){
	case "AROU":
		$m_re_dime='ratio_aouo';
		$mb_re_dime_rate='ior_AOUO';
		$tg_re_dime_rate='ior_AOUU';
		$leix=$res_total.' '.$run." - 15".$fenzhong." : ".$ou.' - '.$shangbanchangkaishi." - 14:59".$fenzhong;
		$MB_Ball="MB15_Ball";
		$TG_Ball="TG15_Ball";
		break; 
	case "BROU":
		$m_re_dime='ratio_bouo';
		$mb_re_dime_rate='ior_BOUO';
		$tg_re_dime_rate='ior_BOUU';
		$leix=$res_total.' '.$run." - 15".$fenzhong." : ".$ou." - 15:00 - 29:59".$fenzhong;
		$MB_Ball="MB16_Ball";
		$TG_Ball="TG16_Ball";
		break;	
	case "DROU":
		$m_re_dime='ratio_douo';
		$mb_re_dime_rate='ior_DOUO';
		$tg_re_dime_rate='ior_DOUU';
		$leix=$res_total.' '.$run." - 15".$fenzhong." : ".$ou." - ".$xiabanchangkaishi." - 59:59".$fenzhong;
		$MB_Ball="MB17_Ball";
		$TG_Ball="TG17_Ball";
		break;	
	case "EROU":
		$m_re_dime='ratio_eouo';
		$mb_re_dime_rate='ior_EOUO';
		$tg_re_dime_rate='ior_EOUU';
		$MB_Ball="MB18_Ball";
		$TG_Ball="TG18_Ball";
		$leix=$res_total.' '.$run." - 15".$fenzhong." : ".$ou." - 60:00 - 74:59".$fenzhong;
		break;	

}
//echo $m_re_dime;exit;
$mysql = "select maxgold,$MB_Ball as mb_ball,$TG_Ball as tg_ball,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,concat('$body_mb_dimes',$m_re_dime) as MB_Dime,concat('$body_tg_dimes',$m_re_dime) as TG_Dime,$mb_re_dime_rate as MB_Dime_Rate,$tg_re_dime_rate as TG_Dime_Rate from foot_match where `MID`=$gid and cancel<>1 and fopen=1 and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>''";// and now()>date_add(m_start,interval 40 second)";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
//echo $mysql;exit;
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit();
}else{
	$memname=$row['Memname'];
	$credit=$row['Money'];
	$maxcredit=$row['Credit'];
	$ptype=$row['pay_type'];
//userlog($memname);
	$GMAX_SINGLE=$row['FT_ROU_Scene'];
	$GSINGLE_CREDIT=$row['FT_ROU_Bet'];
	$open=$row['OpenType'];

	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where M_Name='$memname' and MID='$gid' and LineType=1015 and Mtype='$gtype'";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore'];
	if ($have_bet==''){
		$have_bet=0;
	}

	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);

	$btset=singleset('ou');
	$GMIN_SINGLE=$btset[0];
		$maxgold=$row['maxgold'];

	if($GSINGLE_CREDIT>$maxgold){
		$bettop=$maxgold;
	}else{
		$bettop=$GSINGLE_CREDIT;
	}
	
	if(!$ptype){
		$gdate=date('Y-').$row['M_Date'];
		$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as gold from web_db_io where m_date='$gdate' and m_name='$memname' order by id";/*求出本日累计*/
		$result = mysql_query($sql);
		$haverow = mysql_fetch_array($result);
		$gold		=$haverow['gold']+0;
	    $credit=(($credit+$gold)<>$maxcredit)?($maxcredit-$gold):$credit;
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
	$ior=get_other_ioratio($odd_type,change_rate($open,$row["MB_Dime_Rate"]),change_rate($open,$row["TG_Dime_Rate"]),1);

	switch ($gtype){
	case "O":
		$M_Place=$row["MB_Dime"];
		$M_Rate=$ior[0];
		break;
	case "U":
		$M_Place=$row["TG_Dime"];
		$M_Rate=$ior[1];
		break;
	}
	$inball=$row['mb_ball'].":".$row['tg_ball'];
	if($inball!=$t_inball){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit;
	}
	if (($M_Rate+0)==0 or $M_Place==''){

		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
$tmp_id='1'.substr(rand(time(),1),0,4);
		$ratio_id=$tmp_id.$tmp_id*$M_Rate*100;

$bettop=maxgold($bettop,$M_Rate);
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
<script language="JavaScript" src="/js/football_order1.js"></script>

</head>

<body  id="OFT" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_rou15_finish.php" method="post" onSubmit="return false">
<div class="ord">
	<div class="title"><h1><?=$Soccer?></h1><div class="tiTimer" onClick="orderReload();"><span id="ODtimer">10</span><input type="checkbox" id="checkOrder" onClick="onclickReloadTime()" checked value="10"></div></div>
    <div class="main">
	  <div class="leag"><?=$m_league?></div>
      <div class="gametype"><?=$leix?></div>
      <div class="teamName"><span class="tName"><?=$MB_Team?> vs. <?=$TG_Team?> <font color="#BB2636"><strong>(<?=$inball?>)</strong></font></span></div>
      <p class="team"><em><?=$M_Place?></em> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
      <p class="auto"><input type="checkbox" id="autoOdd" name="autoOdd" onClick="onclickReloadAutoOdd()" checked value="Y"><span class="auto_info" title="<?=$zdjs_title?>"><?=$zdjs?></span></p>
      	
	  <p class="error" style="display:none;"><?=$bet_title?></p>
	 
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
	<input type="hidden" value="1015" name=line_type>
	<input type="hidden" value="<?=$pay_type?>" name=pay_type>
	<input type="hidden" value="<?=$gtype?>" name=type>
	<input type="hidden" value="<?=$have_bet?>" name=restsinglecredit>
	<input type="hidden" value="<?=$credit?>" name=restcredit>
	<input type="hidden" value="<?=$odd_f_type?>" name=odd_f_type>
	<input type="hidden" value="<?=$wtype?>" name=wtype>
</form>
</body>
</html>
<?
}
mysql_close();
?>
