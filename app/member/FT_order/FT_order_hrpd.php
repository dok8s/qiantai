<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

$gid=$_REQUEST['gid'];
$uid=$_REQUEST['uid'];
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$uid=$_REQUEST['uid'];
$gtype=$_REQUEST['rtype'];
$odd_type=$_REQUEST['odd_f_type'];
$odd_f_type=$_REQUEST['odd_f_type'];

$change=$_REQUEST['change'];
$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$mrow = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}


$pay_type=$mrow['pay_type'];
$langx=$_REQUEST['langx'];
require ("../include/traditional.$langx.inc.php");



order_accept($uid,$dbname);
wager_danger($uid,$dbname);
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
$filename="".$site."/app/member/FT_order/FT_order_hrpd.php?gid=$gid&uid=$suid&rtype=$gtype&odd_f_type=H&langx=$langx";
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

$mysql = "select  M_Start,maxgold,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowType,ior_HRH1C0,ior_HRH2C0,ior_HRH0C0,ior_HRH0C1,ior_HRH0C2,ior_HRH2C1,ior_HRH3C0,ior_HRH1C1,ior_HRH1C2,ior_HRH0C3,ior_HRH3C1,ior_HRH3C2,ior_HRH2C2,ior_HRH1C3,ior_HRH2C3,ior_HRH3C3,ior_HROVH from foot_match where `MID`=$gid and cancel<>1 and fopen=1";

$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);

	

$btset=singleset('r');
$GMIN_SINGLE=$btset[0];

$cou=mysql_num_rows($result);
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit;
}else{
	$memname=$mrow['Memname'];
	$credit=$mrow['Money'];
	$maxcredit=$mrow['Credit'];
	$ptype=$mrow['pay_type'];
	//userlog($memname);
	$GMAX_SINGLE=$mrow['FT_PD_Scene'];
	$GSINGLE_CREDIT=$mrow['FT_PD_Bet'];
	$open=$mrow['OpenType'];

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

	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where M_Name='$memname' and MID='$gid' and LineType=64 and Mtype='$gtype'";
	$result = mysql_db_query($dbname,$havesql);

	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

	$active=1;
	$css="";

	$m_league=$row['M_League'];
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	$TG_Team=filiter_team($TG_Team);
	$Sign="vs";
	if ($gtype=="HROVH"){
		$M_Place=$pdscore;
		$M_Rate=$row['ior_HROVH'];
	}else{
		$M_Place="";
		$M_Sign=$gtype;
		
		$M_Rate='ior_H'.$gtype;
		$M_Sign=str_replace("H","",$M_Sign);
		$M_Sign=str_replace("C",":",$M_Sign);
		$M_Sign=str_replace("R","",$M_Sign);
		$M_Rate=$row[$M_Rate];
	}
	$caption=$Soccer;
	
$bettop=maxgold($bettop,$M_Rate);
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
<script language="JavaScript" src="/js/football_order2.js"></script>
</head>
<!---->
<body  id="OFT" class="bodyset" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_hrpd_finish.php" method="post" onSubmit="return false">
<div class="ord">
	<div class="title"><h1><?=$Soccer?></h1><div class="tiTimer" onClick="orderReload();"><span id="ODtimer">10</span><input type="checkbox" id="checkOrder" onClick="onclickReloadTime()" checked value="10"></div></div>
    <div class="main">
	  <div class="leag"><?=$m_league?></div>
      <div class="gametype"><span style="color:red;"><?=$body_sb?> <?=$run?> - <?=$Correctscore?></span></div>
      <div class="teamName"><span class="tName"><?=$MB_Team?> <font color=#CC0000><?=$Sign?></font> <?=$TG_Team?> <font color="#BB2636"><strong><?=$inball?></strong></font></span></div>
      <p class="team"><em><?=$M_Place?></em><font color=#CC0000><?=$M_Sign?></font> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
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
	<input type="hidden" value="64" name=line_type>
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

