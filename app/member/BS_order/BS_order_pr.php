<script>if(self == top) location='/'</script>
<?

include "../include/library.mem.php";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid   				=	$_REQUEST['uid'];
$tcount				=	$_REQUEST['tcount'];
$gold			    =	$_REQUEST['gold'];
$teamcount			=	$_REQUEST['teamcount'];
$wagerDatas			=	$_REQUEST['wagerDatas'];
$gdate			    =	$_REQUEST['gdate'];


$act=$_REQUEST['active'];

$sql = "select * from web_member where Oid='$uid' and oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$langx=$row['language'];
$pay_type=$row['pay_type'];
//$body_js=getcss($langx);
require ("../include/traditional.$langx.inc.php");
$memname=$row['Memname'];
$credit=$row['Money'];
$btset=singleset('p');
$GMIN_SINGLE=$btset[0];
$bettop=$btset[1];

$GMAX_SINGLE=$row['FT_P_Scene'];
$GSINGLE_CREDIT=$row['FT_P_Bet'];
$team=0;
$css='';
$G_ID=0;
$pl='';
$betplace='';

if ($act==1){

	$SCRIPTARRAY="var scripts=new Array();";
	$CONTENT='';
	$TEAMCOUNT=0;
	for ($i=1;$i<$teamcount+1;$i++){
		$type=$_REQUEST["game$i"];
		$gid=$_REQUEST["game_id$i"];
		if (!empty($type)){
			switch ($type){
			case "PRH":
				$team_s			=	$mb_team;
				$ratio			=	"mb_pr_letb_rate";
				$team			=	"m_letb";
				$gnum			=	"mb_mid";
				$teama			=	"if(showtype='H',$mb_team,$tg_team) as mb_team,if(showtype='H',$tg_team,$mb_team) as tg_team";
				break;
			case "PRC":
				$team_s			=	$tg_team;
				$ratio			=	"tg_pr_letb_rate";
				$team			=	"m_letb";
				$teama			=	"if(showtype='H',$mb_team,$tg_team) as mb_team,if(showtype='H',$tg_team,$mb_team) as tg_team";
				$gnum			=	"tg_mid";				
				break;
			case "POUC":
				$team_s			=	"concat('$body_mb_dimes',m_dime)";
				$ratio			=	"mb_pr_dime_rate";
				$team			=	"' VS.'";
				$gnum			=	"mb_mid";				
				$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
				break;	
			case "POUH":
				$team_s			=	"concat('$body_tg_dimes',m_dime)";
				$ratio			=	"mb_pr_dime_rate";
				$team			=	"' VS.'";
				$gnum			=	"tg_mid";				
				$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
				break;	
			default:
				wager_faile($uid,$STR_META,'server error!!'.rand(0,200));
				echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
				break;
			}

			

			$sql="select mid,m_date,$gnum as gnum,$team as team,$teama,showtype,concat($m_league,'-','$HandicapParlay') as lea,$team_s as team_s,$ratio as ratio from foot_match where mid=$gid";

			$result = mysql_db_query($dbname,$sql);
			$cou=mysql_num_rows($result);
			if($cou==0){
				wager_order($uid,$langx);
			}
			$row = mysql_fetch_array($result);

			if(empty($gdate)){$gdate=$row['m_date'];}
			$IORSTR=$IORSTR.$row['ratio'].' ';
	
			$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and FIND_IN_SET($gid,MID)>0 and linetype=8 and active<3";
			$result = mysql_db_query($dbname,$havesql);
			$haverow = mysql_fetch_array($result);
			$score=$haverow['BetScore']+0;
			$SC=$SC.$score.' ';			

			$SCRIPTARRAY=$SCRIPTARRAY."\nscripts[$TEAMCOUNT]=new Array('$gid','".$row['showtype']."','$type','','PR','1','100','".$row['ratio']."');";
			$tcount=$TEAMCOUNT+1;

			$teama=$row['tg_team'];

			$CONTENT=$CONTENT.'<div class="ord_betAreaP" id="TR'.$tcount.'"><span class="ord_betCloseBTN"  name="delteam'.$tcount.'" value="" onclick="delteams(\''.$tcount.'\')"></span>
	        <ul class="ord_betArea_wordTop">
	        	<li class="BlueWordS">'.$lei_b.'</li>
	            <li class="light_BrownWord upperWord">'.$pb1['0'].'</li>
	            <li class="dark_BrownWord">'.filiter_team($row['mb_team']).' <tt class="RedWord fatWord"></tt><tt class="ord_vWordNO"> '.$row['team'].' </tt>'.filiter_team($row['tg_team']).' <tt class="RedWord fatWord"></tt> <span class="BlueWordS"></span></li>
	        </ul>
	        <ul class="ord_betArea_wordBottom">
	        	<li class="dark_BrownWord no_margin"><tt>'.filiter_team($row['team_s']).'</tt> <tt class="RedWord fatWord"></tt> @ <span id="P'.$tcount.'" class="redFatWord">'.number_format($row['ratio'],2).'</span></li>
	        </ul>
				<div id="TR'.$tcount.'_Mask" class="ord_Mask" style="display:none;"><span class="ord_betCloseBTN" name="delteam'.$tcount.'" value="" onclick="delteams('.$tcount.')"></span></div><!--不能下注遮罩-->
	        </div>';
			$TEAMCOUNT++;

		}
	}
}

if ($gdate==date('m-d') or $gdate==''){
	$active=1;
	$css="OFT";
	$caption=$RqggOrder;
}else{
	$active=2;
	$css="OFU";
	$caption=$ZcRqggOrder;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
<link href="/style/member/order.css" rel="stylesheet" type="text/css">
<script><?=$SCRIPTARRAY?>
</script>
<script language="JavaScript" src="/js/ft_parlay_order.js"></script>
<script language="JavaScript" src="/js/jquery-3.1.0.min.js"></script>
<script language="JavaScript" src="/js/football_order_tt.js"></script>
</head>

<body id="<?=$css?>" onLoad="LoadSelect();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/BS_order/BS_order_pr_finish.php" method="post" onSubmit="return false">
	<div class="ord_main">
		<div class="ord_DIV">
			<h1><?=$zhgg?></h1>
			<div class="main">
				<?=$CONTENT?>
				<p class="error" style="display: none"></p>
				<p class="error" id="err_div" style="display:none;"><?=$Paicai?></p>

			</div>

			<!--注单功能区-->
			<div class="ord_betFuntion">
				<!--手动输入数字-->
				<div class="ord_enterNUMG">
					<div class="ord_NUM noFloat"><input id="gold" name="gold" type="text" placeholder="投注额" onKeyPress="return CheckKey('event')" onKeyUp="return CountWinGold('<?=$IORSTR?>','<?=$minlimit?>')" size="8" maxlength="10"><span class="ord_delBTN" id="order_delBTN" onclick="clearsetfocus();"></span>
						<div class="ord_Mask" style="display:none"></div><!--不能下注遮罩--></div>
					<div class="ord_SUM"><span class="ord_SUM_L"><?=$Kyje?></span><span id="pc" class="ord_SUM_R">0.00</span></div>
				</div>

				<!--按钮输入数字-->
				<div class="ord_enterBTNG noFloat">
					<span id="moenyBTN_01" onclick="" class="" money="100">100</span>
					<span id="moenyBTN_02" onclick="" class="" money="200">200</span>
					<span id="moenyBTN_03" onclick="" class="" money="500">500</span>
					<span id="moenyBTN_04" onclick="" class="" money="1000">1,000</span>
					<span id="moenyBTN_05" onclick="" class="" money="2500">2,500</span>
					<span id="moenyBTN_06" onclick="" class="" money="5000">5,000</span>
				</div>

				<!--错误警告-->
				<div id="ord_warn" class="ord_warnG" style="display: none;"><span class="day_text"></span></div>

				<!--确定下注区-->
				<div class="ord_TotalAreaG">
					<span id="Submit" class="ord_betBTN" onclick="CountWinGold('<?=$IORSTR?>','<?=$minlimit?>');return CheckSubmit();">确定交易</span><!--字数两行ord_betBTN02  不能按ord_betBTN_off-->
					<span id="btnCancel" name="btnCancel" class="ord_cancalBTN" onclick="Win_Redirect();">取消</span>

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
	</div>

	<input type="hidden" name="uid" value="<?=$uid?>">
	<input type="hidden" name="wid" value="{WID}">
	<input type="hidden" name="active" value="1">
	<input type="hidden" name="langxx" value="<?=$langx?>">
	<input type="hidden" name="teamcount" value="<?=$TEAMCOUNT?>">
	<input type="hidden" name="tcount" value="<?=$TEAMCOUNT?>">
	<input type="hidden" name="username" value="{USERNAME}">
	<input type="hidden" name="singlecredit" value="<?=$GMAX_SINGLE?>">
	<input type="hidden" name="gmax_single" value="<?=$GSINGLE_CREDIT?>">
	<input type="hidden" name="gmin_single" value="<?=$GMIN_SINGLE?>">
	<input type="hidden" name="restcredit" value="<?=$credit?>">
	<input type="hidden" name="wagerstotal" value="<?=$score1/$team?>">
	<input type="hidden" name="pay_type" value="<?=$pay_type?>">
	<input type="hidden" name="sc" value="<?=$SC?>">
	<input type="hidden" name="pdate" value="<?=$m_date?>">
	<input type="hidden" id="wagerDatas" name="wagerDatas" value="">
  </FORM>
<SCRIPT language=JavaScript>document.all.gold.focus();</SCRIPT>
</BODY>
</html>

