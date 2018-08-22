<?

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['rtype'];
$odd_f_type=$_REQUEST['odd_f_type'];
$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$langx=$_REQUEST['langx'];
$pay_type=$row['pay_type'];

//$body_js=getcss($langx);
require ("../include/traditional.$langx.inc.php");

	wager_danger($uid,$dbname);order_accept($uid,$dbname);


$mysql = "select maxgold,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ior_PGFH,ior_PGFC,ior_PGLH,ior_PGLC,ior_PGFN from foot_match where `MID`=$gid and cancel<>1 and fopen=1";// `m_start`>now() and

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
	$GMAX_SINGLE=$row['FT_M_Scene'];
	$GSINGLE_CREDIT=$row['FT_M_Bet'];

	$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and MID='$gid' and linetype=1";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);

	$btset=singleset('m');
	$GMIN_SINGLE=$btset[0];
	$maxgold=$row['maxgold'];

	if($GSINGLE_CREDIT>$maxgold){
		$bettop=$maxgold;
	}else{
		$bettop=$GSINGLE_CREDIT;
	}

	if ($row['M_Date']==date('m-d')){
		$active=1;
		$css="OFT";
		$caption=$Soccer;
	}
	else{
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
	//echo $gtype;
	switch ($gtype){
	case "PGFH":
		$M_Place=$MB_Team;
		$jinqiu=$zuixianjinqiu;
		$M_Rate=$row["ior_PGFH"];
		break;
	case "PGFC":
		$M_Place=$TG_Team;
		$jinqiu=$zuixianjinqiu;
		$M_Rate=$row["ior_PGFC"];
		break;
	case "PGLH":
		$M_Place=$MB_Team;
		$jinqiu=$zuihoujinqiu;
		$M_Rate=$row["ior_PGLH"];
		break;
	case "PGLC":
		$M_Place=$TG_Team;
		$jinqiu=$zuihoujinqiu;
		$M_Rate=$row["ior_PGLC"];
		break;
	case "PGFN":
		$M_Place=$wujinqiu;
		$jinqiu=$wujinqiu;
		$M_Rate=$row["ior_PGFN"];
		break;
	}

?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
<script language="JavaScript" src="/js/football_order2.js"></script>
</head>
<!-- -->
<body  id="OFT" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_sp_finish.php" method="post" onSubmit="return false">
<div class="ord">
	<div class="title"><h1><?=$caption?></h1><div class="tiTimer" onClick="orderReload();"><span id="ODtimer">10</span><input type="checkbox" id="checkOrder" onClick="onclickReloadTime()" checked value="10"></div></div>
    <div class="main">
	  <div class="leag"><?=$m_league?></div>
      <div class="gametype"><font color="#0000FF"><?=$jinqiu?></font></div>
      <div class="teamName"><span class="tName"><?=$MB_Team?> vs. <?=$TG_Team?></span></div>
      <p class="team"><em><?=$M_Place?></em> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
      <p class="auto"><input type="checkbox" id="autoOdd" name="autoOdd" onClick="onclickReloadAutoOdd()" checked value="Y"><span class="auto_info" title="<?=$zdjs_title?>"><?=$zdjs?></span></p>
      <p class="error" style="display: none;"></p>
      <div class="betdata">
          <p class="amount"><?=$Xzjr?><input name="gold" type="text" class="txt" id="gold" onKeyPress="return CheckKey(event)" onKeyUp="return CountWinGold1()" size="8" maxlength="10"></p>
          <p class="mayWin"><span class="bet_txt"><?=$Kyje?></span><font id="pc">0</font></p>
          <p class="minBet"><span class="bet_txt"><?=$Zdxe?></span><?=number_format($GMIN_SINGLE)?></p>
          <p class="maxBet"><span class="bet_txt"><?=$Dczg?></span><?=number_format($GMAX_SINGLE)?></p>
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
	<input type="hidden" value="101" name=line_type>
	<input type="hidden" value="<?=$pay_type?>" name=pay_type>
	<input type="hidden" value="<?=$gtype?>" name=type>
	<input type="hidden" value="<?=$have_bet?>" name=restsinglecredit>
	<input type="hidden" value="<?=$credit?>" name=restcredit>
	<input type="hidden" value="<?=$odd_f_type?>" name=odd_f_type>
</form>
</body>
</html>

<?
}
mysql_close();
?>
