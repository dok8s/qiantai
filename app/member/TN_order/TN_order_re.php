<?

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

$gid=$_REQUEST['gid'];
$uid=$_REQUEST['uid'];
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$uid=$_REQUEST['uid'];
$gnum=$_REQUEST['gnum'];
$gtype=$_REQUEST['type'];
$odd_type=$_REQUEST['odd_f_type'];
$change=$_REQUEST['change'];
$sql = "select * from web_member where Oid='$uid' and oid<>'' and Status<>0";
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
////////////////////////////////////////////////////
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
	$base_url = "".$site."/app/member/TN_index.php?rtype=re&uid=$suid&langx=zh-cn&mtype=3";
	$thisHttp = new cHTTP();
	$thisHttp->setReferer($base_url);
	$filename="".$site."/app/member/TN_order/TN_order_re.php?gid=$gid&uid=$suid&type=$gtype&gnum=$gnum&odd_f_type=H";
	
	$thisHttp->getPage($filename);
	$msg  = $thisHttp->getContent();
	$msg_c=explode("@",$msg);

	if(sizeof($msg_c)<2)
	{
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
/////////////////////////////////////////////////
order_accept($uid,$dbname);
wager_danger($uid,$dbname);

if ($change==1){
	$bet_title=$nobettitle;
}

$mysql = "select maxgold ,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team, m_letb as M_LetB_HR_en,$m_league as M_League ,ShowType,mb_letb_rate as MB_LetB_Rate_HR,tg_letb_rate as TG_LetB_Rate_HR from tennis where `MID`=$gid and cancel<>1 and fopen=1";

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
	$GMAX_SINGLE=$mrow['TN_RE_Scene'];
	$GSINGLE_CREDIT=$mrow['TN_RE_Bet'];
	$open=$mrow['OpenType'];

	$maxgold=$row['maxgold'];

	if($GSINGLE_CREDIT>$maxgold){
		$bettop=$maxgold;
	}else{
		$bettop=$GSINGLE_CREDIT;
	}
	
	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where active=3 and M_Name='$memname' and MID='$gid' and LineType=9 and Mtype='$gtype'";
	$result = mysql_db_query($dbname,$havesql);

	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

	if(!$ptype){
		$gdate=date('Y-').$row['M_Date'];
		$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as gold from web_db_io where m_date='$gdate' and m_name='$memname' order by id";/*求出本日累计*/
		$result = mysql_query($sql);
		$haverow = mysql_fetch_array($result);
		$gold		=$haverow['gold']+0;
	    $credit=(($credit+$gold)<>$maxcredit)?($maxcredit-$gold):$credit;
	}

	$active=1;
	$css="";

	$m_league=$row['M_League'];
	$MB_Team=$row["MB_Team"];
	$TG_Team=$row["TG_Team"];
	$MB_Team=filiter_team($MB_Team);
	$TG_Team=filiter_team($TG_Team);
	$Sign=$row['M_LetB_HR_en'];
	$ior=get_other_ioratio($odd_type,change_rate($open,$row["MB_LetB_Rate_HR"]),change_rate($open,$row["TG_LetB_Rate_HR"]),1);

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
	$inball=$row['MB_Win'].":".$row['TG_Win'];

	if ($row['ShowType']=='C')
	{
		$inball=$row['TG_Win'].":".$row['MB_Win'];
		$Team=$MB_Team;
		$MB_Team=$TG_Team;
		$TG_Team=$Team;
	}
//	if ($Sign==''){
//		wager_order($uid,$langx);
//		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
//		exit();
//	}
//	if (($M_Rate+0)<=0){
//		wager_order($uid,$langx);
//		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
//		exit;
//	}
	if ($gnum - 600000 > 0){//让局
		$tit = "(滚球)让局";
	}else if ($gnum - 500000 > 0 and $gnum < 600000){//第5盘
		$tit = "(滚球)让盘局 - <font color=#FF0000>第五盘</font>";
	}else if ($gnum - 400000 > 0 and $gnum < 500000){//第4盘
		$tit = "(滚球)让盘局 - <font color=#FF0000>第四盘</font>";
	}else if ($gnum - 300000 > 0 and $gnum < 400000){//第3盘
		$tit = "(滚球)让盘局 - <font color=#FF0000>第三盘</font>";
	}else if ($gnum - 200000 > 0 and $gnum < 300000){//第2盘
		$tit = "(滚球)让盘局 - <font color=#FF0000>第二盘</font>";
	}else if ($gnum - 100000 > 0 and $gnum < 200000){//第1盘
		$tit = "(滚球)让盘局 - <font color=#FF0000>第一盘</font>";
	}else{
		$tit = "(滚球)让盘局";
	}
?>
	<html>
	<head>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
		<title>hg0088</title>
		<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
		<link href="/style/member/order.css" rel="stylesheet" type="text/css">
		<script language="JavaScript" src="/js/jquery-3.1.0.min.js"></script>
		<script language="JavaScript" src="/js/football_order1.js"></script>
		<script language="JavaScript" src="/js/football_order_tt.js"></script>
	</head>
	<!-- -->
	<body id="OFT" onselectstart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">

	<form name="LAYOUTFORM" action="/app/member/TN_order/TN_order_re_finish.php" method="post" onSubmit="return false">
		<div class="ord_main">
			<div class="ord_DIV">
				<!--div class="ord_returnBTN">返回体育项目</div-->
				<!--注单文字区-->
				<div class="ord_betAreaG">
					<h1>单一投注</h1>
					<div class="ord_noOrder" style="display:none">请把选项加入在您的注单。</div><!--没单文字-->
					<!--普通注单--><!--比分改变时ord_betArea_C-->
					<div id="ord_bet" class="ord_betArea">
						<ul class="ord_betArea_wordTop">
							<!-- 2016-12-14 足球多type所有细单改位罝显示  -->
							<li class="BlueWord"><?=$rang?></li>
							<li class="light_BrownWord upperWord"><?=$m_league?></li>
							<li class="dark_BrownWord"><?=$MB_Team?><tt class="ord_vWordNO"> v </tt><?=$TG_Team?><span style="display:none;" class="BlueWord">(1:0)</span></li>
						</ul>
						<ul class="ord_betArea_wordBottom">
							<li class="dark_BrownWord no_margin"><?=$M_Place?> <tt style="display:none;" class="RedWord fatWord">+1</tt> @ <span id="ioradio_id" class="redFatWord"><?=number_format($M_Rate,2)?></span></li>
						</ul>
						<div class="ord_Mask" style="display:none"></div><!--不能下注遮罩-->
					</div>



					<!--注单功能区-->
					<div class="ord_betFuntion">
						<!--手动输入数字-->
						<div class="ord_enterNUMG">
							<div class="ord_NUM noFloat"><input id="gold" name="gold" type="text" placeholder="投注额" onkeypress="return CheckKey(event)" onkeyup="return CountWinGold1()" size="8" maxlength="10"><span class="ord_delBTN" id="order_delBTN" onclick="clearsetfocus();"></span>
								<div class="ord_Mask" style="display:none"></div><!--不能下注遮罩--></div>
							<div class="ord_SUM"><span class="ord_SUM_L"><?=$Kyje?></span><span id="pc" class="ord_SUM_R">0.00</span></div>
						</div>

						<!--按钮输入数字-->
						<div class="ord_enterBTNG noFloat">
							<span id="moenyBTN_01" onclick="" class="" money="100">100</span>
							<span id="moenyBTN_02" onclick="" class="" money="200">200</span>
							<span id="moenyBTN_03" onclick="" class="" money="500">500</span>
							<span id="moenyBTN_04" onclick="" class="" money="1000">1,000</span>
							<span id="moenyBTN_05" onclick="" class="" money="2000">2,500</span>
							<span id="moenyBTN_06" onclick="" class="" money="5000">5,000</span>
						</div>

						<!--错误警告-->
						<div id="ord_warn" class="ord_warnG" style="display: none;"><span class="day_text"></span></div>

						<!--确定下注区-->
						<div class="ord_TotalAreaG">
							<span id="Submit" class="ord_betBTN" onclick="CountWinGold1();return SubChk();">确定交易</span><!--字数两行ord_betBTN02  不能按ord_betBTN_off-->
							<span id="btnCancel" name="btnCancel" class="ord_cancalBTN" onclick="parent.close_bet();">取消</span>

							<table cellspacing="0" cellpadding="0" class="ord_TotalTXT">
								<tbody><tr>
									<td width="40%"><?=$Zdxe?></td>
									<td width="60%" class="Word_Toright"><?=number_format($GMIN_SINGLE)?></td>
								</tr>
								<tr>
									<td><?=$Dczg?></td>
									<td class="Word_Toright"><?=number_format($GMAX_SINGLE)?></td>
								</tr>
								</tbody></table>
						</div>

						<!--自动接受更好赔率-->
						<div class="ord_AutoOddG noFloat"><input id="autoOdd" name="autoOdd" onclick="onclickReloadAutoOdd()" value="Y" class="ord_checkBox" type="checkbox"><span class="auto_info" title="<?=$zdjs_title?>"><?=$zdjs?></span></div>
					</div>

				</div>



				<div id="gWager" style="display: none;position: absolute;"></div>
				<div id="gbutton" style="display: block;position: absolute;"></div>
				<!--下注成功画面-->
				<div class="ord_betSuccG" style="display:none">

					<div class="ord_checkG noFloat"><input class="ord_checkBox" type="checkbox" id="ord_checkBox"><span>保留选项</span></div>
					<span id="OpenBets" class="ord_cancalBTN" style="display:none">查看我的注单</span>
					<span id="ChkBets" class="ord_cancalBTN">确认</span>
				</div>



				<!--交易遮罩-->
				<div id="confirm_div" class="ord_DIV_Mask" style="display:none" onkeypress="SumbitCheckKey(event)" tabindex="1">
					<!--交易确认单-->
					<div id="ord_conf" class="ord_confirmation">
						<h1>投注确认</h1>
						<ul>
							<li>交易金额: <tt id="confirm_gold" class="dark_BrownWord">50.00</tt></li>
							<li>可赢金额: <tt id="confirm_wingold" class="GreenWord">45.00</tt></li>
							<li id="confirm_msg">确定进行下注吗?</li>
						</ul>
						<div class="ord_miniBTNG">
							<span id="confirm_bet" onclick="betConfirmEvent();" class="ord_betBTN">确定下注</span>
							<span id="confirm_cancel" onclick="cancelConfirmEvent();" class="ord_cancalBTN">取消</span>
						</div>
					</div>

				</div>

				<input type=hidden value="<?=$langx?>" name=langx>
				<input type=hidden value="<?=$uid?>" name=uid>
				<input type=hidden value="<?=$gid?>" name=gid>
				<input type=hidden value="<?=$gnum?>" name=gnum>
				<INPUT type=hidden id=ioradio_r_h  value="<?=number_format($M_Rate,2)?>" name=ioradio_r_h>
				<input type=hidden value="<?=$bettop?>" name=gmax_single>
				<input type=hidden value="<?=$GMIN_SINGLE?>" name=gmin_single>
				<input type=hidden value="<?=$GMAX_SINGLE?>" name=singlecredit>
				<input type=hidden value="<?=$GSINGLE_CREDIT?>" name=singleorder>
				<input type=hidden value="<?=$active?>" name=active>
				<input type=hidden value="0" name=gwin>
				<input type=hidden value=9 name=line_type>
				<input type=hidden value="<?=$pay_type?>" name=pay_type>
				<input type=hidden value="<?=$gtype?>" name=type>
				<input type=hidden value="<?=$have_bet?>" name=restsinglecredit>
				<input type=hidden value="<?=$credit?>" name=restcredit>
				<input type="hidden" name="odd_f_type" value="<?=$odd_type?>">
			</div>
	</form>


	</body>
	</html>
<?
}
mysql_close();
?>

