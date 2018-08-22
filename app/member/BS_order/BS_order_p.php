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
require ("../include/traditional.$langx.inc.php");
//$body_js=getcss($langx);
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
			case "H":
				$team_s			=	$mb_team;
				$ratio			=	"MB_P_Win";
				break;
			case "C":
				$team_s			=	$tg_team;
				$ratio			=	"TG_P_Win";
				break;
			case "N":
				$team_s			=	"'$Draw'";
				$ratio			=	"M_P_Flat";
				break;	
			default:
				wager_faile($uid,$STR_META,'server error!!'.rand(0,200));
				break;
			}
			$sql="select mid,m_date,concat($mb_team,' VS. ',$tg_team) as team,concat($m_league,'-','$P_STR') as lea,$team_s as team_s,$ratio as ratio from foot_match where mid=$gid";
			$result = mysql_db_query($dbname,$sql);
			$cou=mysql_num_rows($result);
			if($cou==0){
				wager_order($uid,$langx);
			}
			$row = mysql_fetch_array($result);

			if(empty($gdate)){$gdate=$row['m_date'];}
			$IORSTR=$IORSTR.$row['ratio'].' ';
	
			$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and FIND_IN_SET($gid,MID)>0 and linetype=7 and active<3";
			$result = mysql_db_query($dbname,$havesql);
			$haverow = mysql_fetch_array($result);
			$score=$haverow['BetScore']+0;
			$SC=$SC.$score.' ';			

			$SCRIPTARRAY=$SCRIPTARRAY."\nscripts[$TEAMCOUNT]=new Array('$gid','','$type','','P','1','100','".$row['ratio']."');";
			$tcount=$TEAMCOUNT+1;
			  $CONTENT=$CONTENT."<div id=TR$tcount> 
				<p class=\"team\">".$row['lea'].$Parlay.'<br>
				  '.filiter_team($row['team']).'  <br>
				  <em>'.filiter_team($row['team_s']).'</em> @ <strong>'.$row['ratio']."</strong> 
				  <input type=\"button\" name=\"delteam$i\" value=\"$del_select\" onClick=\"delteams('$tcount')\" class=\"par\">
				</p>
			  </div>";
			$TEAMCOUNT++;

		}
	}
}

if ($gdate==date('m-d') or $gdate==''){
	$active=1;
	$css="OFT";
	$caption=$BzzgOrder;
}else{
	$active=2;
	$css="OFU";
	$caption=$ZcBzzgOrder;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>"> 
<link rel="stylesheet" href="/style/member/mem_order.css" type="text/css">
<script><?=$SCRIPTARRAY?>
</script>
</head>

<body id="<?=$css?>" onLoad="LoadSelect();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script language="JavaScript" src="/js/ft_parlay_order<?=$body_js?>.js"></script>
<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_p_finish.php" method="post" onSubmit="return false">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
    <div id="info">
      <p><?=$Name?><?=$memname?></p>
      <p><?=$Money?><?=$credit?></p>
      <p><?=$Ymoney?><?=$order_money?></p>
      <p class="error"><?=$Paicai?></p>
      <?=$CONTENT?>
      <p><?=$order_model?>
      <select id="wkind" name="wkind" size="1" onChange="chiang_wkind()"><option value="<?=$order_type?>" selected><?=$order_type?></option></select>
      <select id="wstar" name="wstar" size="1" onChange="chiang_wstar()"></select>
      <select id="wteam" name="wteam" size="1"></select>
    </p>
      <p><?=$Xzjr?><input type="text" id="gold" name="gold" size="8" maxlength="10" onKeyPress="return CheckKey()" onKeyUp="return CountWinGold('<?=$IORSTR?>',0)" class="txt"></p>
      <p><?=$Kyje?><FONT id=pc color=#cc0000>0</FONT></p>
      <p><?=$Zdxe?><?=$GMIN_SINGLE?></p>
      <p><?=$Dzxe?><?=$GSINGLE_CREDIT?></p>
      <p><?=$Dczg?><?=$GMAX_SINGLE?></p>
    </div>
    <p class="foot">
      <input type="button" name="btnCancel" value="<?=$Qxxz?>" onClick="Win_Redirect();" class="no">
      <input type="button" name="SUBMIT" value="<?=$Qdxz?>" onClick="CountWinGold('<?=$IORSTR?>',0);return CheckSubmit();" class="yes">
    </p>
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

<!--
    <INPUT type='hidden' value=<?=$uid?> name=uid>
	<INPUT type='hidden' value=<?=$TEAMCOUNT?> name=teamcount> 
    <INPUT type='hidden' value=<?=$G_ID?> name=gid>
	<INPUT type='hidden' value=0 name=gwin>
	<INPUT type='hidden' value=<?=$GSINGLE_CREDIT?> name=gmax_single>
	<INPUT type='hidden' value=<?=$GMIN_SINGLE?> name=gmin_single> 
	<INPUT type='hidden' value=<?=$GMAX_SINGLE?> name=singlecredit> 
	<INPUT type='hidden' value=<?=$GSINGLE_CREDIT?> name=singleorder> 
	<INPUT type='hidden' value=<?=$score1/$team?> name=wagerstotal> 
	<INPUT type='hidden' value=<?=$active?> name=active> 
	<INPUT type='hidden' value=7 name=line_type>   
	<input type=hidden value=<?=$pay_type?> name=pay_type>  
	<INPUT type='hidden' value=<?=$credit?> name=restcredit>   
	<INPUT type=hidden value="<?=$have_bet?>" name=sc>   
	<INPUT type=hidden value=<?=$m_date?> name=pdate>
-->
  </FORM>
<SCRIPT language=JavaScript>document.all.gold.focus();</SCRIPT>
</BODY>
</html>

