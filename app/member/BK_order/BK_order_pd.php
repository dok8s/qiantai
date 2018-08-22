<?

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/http.class.php");
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gnum=$_REQUEST['gnum'];
$gtype=$_REQUEST['rtype'];
$change=$_REQUEST['change'];
$odd_type=$_REQUEST['odd_f_type'];
$langx=$_REQUEST['langx'];
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
wager_danger($uid,$dbname);
order_accept($uid,$dbname);

require ("../include/traditional.$langx.inc.php");

if ($change==1){
	$bet_title=$nobettitle;
}


///////////////////////////////////////////////////

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
$base_url = "".$site."/app/member/BK_index.php?rtype=re&uid=$suid&mtype=3";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename="".$site."/app/member/BK_order/BK_order_pd.php?gid=$gid&uid=$suid&rtype=$gtype&gnum=$gnum&odd_f_type=H&langx=$langx";


$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$msg_c=explode("@",$msg);

if(sizeof($msg_c)<2)
{
	wager_order($uid,$langx);
}

/////////////////////////////////////////*/

$mysql = "select M_Start, mb_team,mb_mid,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowType,ior_PDH0,ior_PDH1,ior_PDH2,ior_PDH3,ior_PDH4,ior_PDC1,ior_PDC2,ior_PDC3,ior_PDC4,ior_PDC0 from bask_match where `MID`='$gid'  and cancel<>1 and fopen=1";
//exit;
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	wager_order($uid,$langx);
}else{

	$memname=$row['Memname'];
	$credit=$row['Money'];
//userlog($memname);
	$btset=singleset('r');
	$GMIN_SINGLE=$btset[0];
	$bettop=$btset[1];

	$GMAX_SINGLE=$row['BK_R_Scene'];
	$GSINGLE_CREDIT=$row['BK_R_Bet'];
	$open=$row['OpenType'];
	$bettop=$GSINGLE_CREDIT;

	$row = mysql_fetch_array($result);
/*/赛事前五分钟封盘	
  	$enddate=$row["M_Start"];
	$startdate=date('Y-m-d H:i:s');
	$minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
	if($minute<=5)
	{
		echo "<script  language='javascript'>alert('赛事已关闭');self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
	}*/
	$m_league=$row['M_League'];


	$active=3;
	$css="_bk";

	$team=$row['mb_team'];

	if (strstr($team,'上半')){
		$xzlb1=$body_sb;
		$xzlb='<font color=#666666>['.$body_sb.'] - </font>';
	}else if(strstr($team,'下半')){
		$xzlb1=$body_xb;
		$xzlb='<font color=#666666>['.$body_xb.'] - </font>';
	}else if(strstr($team,'第1节')){
		$xzlb='<font color=#666666>['.$part1.'] - </font>';
		$xzlb1=$part1;
	}else if(strstr($team,'第2节')){
		$xzlb='<font color=#666666>['.$part2.'] - </font>';
		$xzlb1=$part2;
	}else if(strstr($team,'第3节')){
		$xzlb='<font color=#666666>['.$part3.'] - </font>';
		$xzlb1=$part3;
	}else if(strstr($team,'第4节')){
		$xzlb='<font color=#666666>['.$part4.'] - </font>';
		$xzlb1=$part4;
	}else{
		$xzlb='';
		$xzlb1=$res_total;
	}


	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore))  as BetScore from web_db_io where m_name='$memname' and MID='$gid' and linetype=111 and mtype='$gtype' and active=3";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	$TG_Team=filiter_team($TG_Team);
	$Sign="vs";

	//$ior=get_other_ioratio($odd_type,change_rate($open,$row["ior_MH"]),change_rate($open,$row["ior_MC"]),1);

		switch ($gtype){
		case "PDH0":
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_PDH0"];
			$fenlei='0'.$huozhe.' 5';
			break;
		case "PDH1":
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_PDH1"];
			$fenlei='1'.$huozhe.' 6';
			break;
		case "PDH2":
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_PDH2"];
			$fenlei='2'.$huozhe.' 7';
			break;
		case "PDH3":
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_PDH3"];
			$fenlei='3'.$huozhe.' 8';
		case "PDH4":
			$M_Place=$MB_Team;
			$M_Rate=$row["ior_PDH4"];
			$fenlei='4'.$huozhe.' 9';
			break;
			
		case "PDC0":
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_PDC0"];
			$fenlei='0'.$huozhe.' 5';
			break;
		case "PDC1":
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_PDC1"];
			$fenlei='1'.$huozhe.' 6';
			break;
		case "PDC2":
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_PDC2"];
			$fenlei='2'.$huozhe.' 7';
			break;
		case "PDC3":
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_PDC3"];
			$fenlei='3'.$huozhe.' 8';
		case "PDC4":
			$M_Place=$TG_Team;
			$M_Rate=$row["ior_PDC4"];
			$fenlei='4'.$huozhe.' 9';
			break;
		
		}
	if ($row['ShowType']=='C')
	{
		$Team=$MB_Team;
		$MB_Team=$TG_Team;
		$TG_Team=$Team;
	}
$bettop=maxgold($bettop,$M_Rate);
?>

	<HTML>
	<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
<script language="JavaScript" src="/js/football_order2.js"></script>
	</head>
<body id="OFT" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/BK_order/BK_order_pd_finish.php" method="post" onSubmit="return false">
<div class="ord">
	<div class="title"><h1><?=$BasketBall?></h1><div class="tiTimer" onClick="orderReload();"><span id="ODtimer">10</span><input type="checkbox" id="checkOrder" onClick="onclickReloadTime()" checked value="10"></div></div>
    <div class="main">
	  <div class="leag"><?=$m_league?></div>
      <div class="gametype"><?=$xzlb1?> - <?=$qiuduidefen?><?=$M_Place?> -<?=$zuihouyiwei?></div>
      <div class="teamName"><span class="tName"><?=$MB_Team?> <font color=#CC0000><?=$Sign?></font> <?=$TG_Team?></span></div>
      <p class="team"><em><?=$M_Place?> <?=$fenlei?><?=$xzlb?></em> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
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
	
		<input type=hidden value=<?=$uid?> name=uid>
		<input type=hidden value="<?=$langx?>" name=langx>
	<input type=hidden value=<?=$gid?> name=gid>
	<INPUT type=hidden id=ioradio_r_h  value=<?=number_format($M_Rate,2)?> name=ioradio_r_h>
	<input type=hidden value=<?=$bettop?> name=gmax_single>
	<input type=hidden value=<?=$GMIN_SINGLE?> name=gmin_single>
	<input type=hidden value=<?=$GMAX_SINGLE?> name=singlecredit>
	<input type=hidden value=<?=$GSINGLE_CREDIT?> name=singleorder>
	<input type=hidden value=<?=$active?> name=active>
	<input type=hidden value=0 name=gwin>
	<input type=hidden value=111 name=line_type>
	<input type=hidden value=<?=$pay_type?> name=pay_type>
	<input type=hidden value=<?=$gtype?> name=type>
	<input type=hidden value=<?=$have_bet?> name=restsinglecredit>
	<input type=hidden value=<?=$credit?> name=restcredit>
	<input type="hidden" name="odd_f_type" value="<?=$odd_type?>">
</form>
</body>
</html>
	<?
	}

mysql_close();
?>
