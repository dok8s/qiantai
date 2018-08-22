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
$odd_f_type=$_REQUEST['odd_f_type'];
if($odd_f_type==""){
	$odd_f_type="H";
}
$act=$_REQUEST['active'];

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
wager_danger($uid,$dbname);order_accept($uid,$dbname);

require ("../include/traditional.$langx.inc.php");
$memname=$row['Memname'];
$credit=$row['Money'];
$btset=singleset('p');
$GMIN_SINGLE=$btset[0];
$bettop=$GSINGLE_CREDIT;
//userlog($memname);
$GMAX_SINGLE=$row['OP_PC_Scene'];
$GSINGLE_CREDIT=$row['OP_PC_Bet'];
$team=0;
$css='';
$G_ID=0;
$pl='';
$betplace='';


$act=1;
if ($act==1){

	$SCRIPTARRAY='var scripts=new Array();var rtype="P3"';
	$CONTENT='';
	$TEAMCOUNT=0;
	for ($i=1;$i<$teamcount+1;$i++){
		$type=$_REQUEST["game$i"];
		$gid=$_REQUEST["game_id$i"];

		if (!empty($type)){
			$ggid .= $gid."," ;
			switch ($type){
				case "PRH":
					$team_s			=	$mb_team;
					$lei_b			=	$Handicap;
					$ratio			=	"mb_letb_rate+1-0.01";
					$team				=	"m_letb";
					$gnum				=	"mb_mid";
					$teama			=	"if(showtype='H',$mb_team,$tg_team) as mb_team,if(showtype='H',$tg_team,$mb_team) as tg_team";
					$leagues		=	$m_league;
					break;
				case "PRC":
					$team_s			=	$tg_team;
					$lei_b			=	$Handicap;
					$ratio			=	"tg_letb_rate+1-0.01";
					$team				=	"m_letb";
					$teama			=	"if(showtype='H',$mb_team,$tg_team) as mb_team,if(showtype='H',$tg_team,$mb_team) as tg_team";
					$gnum				=	"tg_mid";
					$leagues		=	$m_league;
					break;
				case "HPRH":
					$team_s			=	$mb_team;
					$lei_b			=	"<font color=red>".$body_sb."</font> - ".$rang;
					$ratio			=	"mb_letb_rate+1-0.01";
					$team				=	"m_letb";
					$gnum				=	"mb_mid";
					$leagues		=$m_league;
					$teama			=	"if(showtype='H',$mb_team,$tg_team) as mb_team,if(showtype='H',$tg_team,$mb_team) as tg_team";
					$gid=$gid+1;
					break;
				case "HPRC":
					$team_s			=	$tg_team;
					$lei_b			=	"<font color=red>".$body_sb."</font> - ".$rang;
					$ratio			=	"tg_letb_rate+1-0.01";
					$team				=	"m_letb";
					$teama			=	"if(showtype='H',$mb_team,$tg_team) as mb_team,if(showtype='H',$tg_team,$mb_team) as tg_team";
					$gnum				=	"tg_mid";
					$leagues		=	$m_league;
					$gid=$gid+1;
					break;
				case "POUC":
					$lei_b			=	$res_total." - ".$OverUnder2;
					$team_s			=	"concat('$body_mb_dimes',m_dime)";
					$ratio			=	"mb_dime_rate+1-0.01";
					$team				=	"' vs.'";
					$gnum				=	"mb_mid";
					$leagues		=	$m_league;
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					break;
				case "POUH":
					$lei_b			=	$res_total." - ".$OverUnder2;
					$team_s			=	"concat('$body_tg_dimes',m_dime)";
					$ratio			=	"tg_dime_rate+1-0.01";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$leagues		=	$m_league;
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					break;
				case "HPOUC":
					$team_s			=	"concat('$body_mb_dimes',m_dime)";
					$lei_b			=	"<font color=red>".$body_sb."</font> - ".$OverUnder2;
					$ratio			=	"mb_dime_rate+1-0.01";
					$team				=	"' vs.'";
					$gnum				=	"mb_mid";
					$leagues		=	"concat($m_league,'-','$hungeguoguan')";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	$m_league;
					$gid=$gid+1;
					break;
				case "HPOUH":
					$team_s			=	"concat('$body_tg_dimes',m_dime)";
					$lei_b			=	"<font color=red>".$body_sb."</font> - ".$OverUnder2;
					$ratio			=	"tg_dime_rate+1-0.01";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$leagues		=	"concat($m_league,'-','$hungeguoguan')";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	$m_league;
					$gid=$gid+1;
					break;
				case "PO":
					$team_s			=	"'$Odd1'";
					$lei_b			=	$res_total." - ".$OddEven;
					$ratio			=	"S_Single";
					$team				=	"' vs.'";
					$gnum				=	"mb_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	$m_league;
					break;
				case "PE":
					$team_s			=	"'$Even'";
					$lei_b			=	$res_total." - ".$OddEven;
					$ratio			=	"S_Double";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	$m_league;
					break;
				case "MH"://全场独赢
					$lei_b			=	$res_total." - ".$win;
					$team_s			=	$mb_team;
					$ratio			=	"mb_win";
					$team				=	"' vs.'";
					$gnum				=	"mb_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	$m_league;
					break;
				case "MC"://全场独赢
					$lei_b			=	$res_total." - ".$win;
					$team_s			=	$tg_team;
					$ratio			=	"tg_win";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	$m_league;
					break;
				case "MN"://全场独赢
					$lei_b			=	$res_total." - ".$win;
					$team_s			=	"'$Draw'";
					$ratio			=	"m_flat";
					$team				=	"' vs.'";
					$gnum				=	"''";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	$m_league;
					break;
				case "HPMH"://上半独赢
					$team_s			=	$mb_team;
					$lei_b			=	"<font color=red>".$body_sb."</font> - ".$win;
					$ratio			=	"mb_win";
					$team			=	"' vs.'";
					$gnum			=	"mb_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	$m_league;
					$gid=$gid+1;
					break;
				case "HPMC"://上半独赢
					$team_s			=	$tg_team;
					$lei_b			=	"<font color=red>".$body_sb."</font> - ".$win;
					$ratio			=	"tg_win";
					$team			=	"' vs.'";
					$gnum			=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					$gid=$gid+1;
					break;
				case "HPMN"://上半独赢
					$team_s			=	"'$Draw'";
					$lei_b			=	"<font color=red>".$body_sb."</font> - ".$win;
					$ratio			=	"m_flat";
					$team			=	"' vs.'";
					$gnum			=	"''";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					$gid=$gid+1;
					break;
				case "0~1":
					$team_s			=	"'0~1'";
					$ratio			=	"S_0_1";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$lei_b			=	$res_total." - ".$rqs;
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league)";
					break;
				case "2~3":
					$team_s			=	"'2~3'";
					$lei_b			=	$res_total." - ".$rqs;
					$ratio			=	"S_2_3";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "4~6":
					$team_s			=	"'4~6'";
					$lei_b			=	$res_total." - ".$rqs;
					$ratio			=	"S_4_6";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "OVER":
					$team_s			=	"'(7UP)'";
					$lei_b			=	$res_total." - ".$rqs;
					$ratio			=	"s_7up";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "FHH":
					$team_s			=	"concat($mb_team,' / ',$mb_team)";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"MBMB";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "FHN":
					$team_s			=	"concat($mb_team,' / ','$Draw')";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"MBFT";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "FHC":
					$team_s			=	"concat($mb_team,' / ',$tg_team)";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"MBTG";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "FNH":
					$team_s			=	"concat('$Draw',' / ',$mb_team)";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"FTMB";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "FNN":
					$team_s			=	"concat('$Draw',' / ','$Draw')";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"FTFT";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "FNC":
					$team_s			=	"concat('$Draw',' / ',$tg_team)";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"FTTG";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "FCH":
					$team_s			=	"concat($tg_team,' / ',$mb_team)";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"TGMB";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";

					break;
				case "FCN":
					$team_s			=	"concat($tg_team,' / ','$Draw')";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"TGFT";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				case "FCC":
					$team_s			=	"concat($tg_team,' / ',$tg_team)";
					$lei_b			=	$res_total." - ".$HalfFullTime;
					$ratio			=	"TGTG";
					$team				=	"' vs.'";
					$gnum				=	"tg_mid";
					$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
					$leagues		=	"$m_league";
					break;
				default:
					if(strlen($type)==4 || $type=='OVH'){
						if ($type=="OVH"){
							$team_s	=	"'$pdscore'";
							$team		=	"'vs.'";
							$ratio	=	"OVMB";
						}else{
							$team_s	=	"''";
							$M_Sign=$type;
							$M_Sign=str_replace("H","'(",$M_Sign);
							$M_Sign=str_replace("C",":",$M_Sign);
							$team=$M_Sign.")'";
							$M_Rate=str_replace("H","MB",$type);
							$M_Rate=str_replace("C","TG",$M_Rate);
							$ratio=$M_Rate;
						}
						$lei_b			=	$res_total." - ".$Correctscore;
						$gnum				=	"mb_mid";
						$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
						$leagues		=	"concat($m_league,'-','$hungeguoguan')";
					}else if(strlen($type)==5 || $type=='HOVH'){
						if ($type=="HOVH"){
							$team_s	=	"'$pdscore'";
							$team		=	"'vs.'";
							$ratio	=	"OVMB";
						}else{
							$type=substr($type,1,strlen($type));
							$team_s	=	"''";
							$M_Sign=$type;
							$M_Sign=str_replace("H","'(",$M_Sign);
							$M_Sign=str_replace("C",":",$M_Sign);
							$team=$M_Sign.")'";

							$M_Rate=str_replace("H","MB",$type);
							$M_Rate=str_replace("C","TG",$M_Rate);
							$ratio=$M_Rate;
							$leagues		=	"concat($m_league,'<FONT COLOR=\"#BB0000\"> - [$body_sb]</FONT>-','$hungeguoguan')";
						}
						$lei_b			=	$res_half." - ".$Correctscore;
						$gnum				=	"mb_mid";
						$teama			=	"$mb_team as mb_team,$tg_team as tg_team";
						//$leagues		=	"concat($m_league,'-','$hungeguoguan')";
					}else{
						wager_order($uid,$langx);
						//wager_faile($uid,$STR_META,'server error!!'.rand(0,200));
						echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
					}
					break;
			}

			$sql="select mid,m_date,$gnum as gnum,$team as team,$teama,showtype,$leagues as lea,$team_s as team_s,$ratio as ratio from other_play where mid=$gid";

			$result = mysql_db_query($dbname,$sql);
			$cou=mysql_num_rows($result);

			if($cou==0){
				wager_order($uid,$langx);
				echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
				exit();
			}
			$row = mysql_fetch_array($result);

			if(empty($gdate)){$gdate=$row['m_date'];}
			$IORSTR=$IORSTR.$row['ratio'].' ';

			$SCRIPTARRAY=$SCRIPTARRAY."\nscripts[$TEAMCOUNT]=new Array('$gid','$type','".$row['showtype']."','1','100','".$row['ratio']."');";
			$tcount=$TEAMCOUNT+1;
			$teama=$row['tg_team'];

			$half = str_replace("<font color=gray> - [$body_sb]</font>",'' , $teama) ;
			if (count(explode("$half" , $CONTENT))>1){
				wager_Repeat($uid,$langx);
			}else{
				$CONTENT=$CONTENT.'<div class="ord_betAreaP" id="TR'.$tcount.'"><span class="ord_betCloseBTN"  name="delteam'.$tcount.'" value="" onclick="delteams(\''.$tcount.'\')"></span>
	        <ul class="ord_betArea_wordTop">
	        	<li class="BlueWordS">'.$lei_b.'</li>
	            <li class="light_BrownWord upperWord">'.$row['lea'].'</li>
	            <li class="dark_BrownWord">'.filiter_team($row['mb_team']).' <tt class="RedWord fatWord"></tt><tt class="ord_vWordNO"> '.$row['team'].' </tt>'.filiter_team($row['tg_team']).' <tt class="RedWord fatWord"></tt> <span class="BlueWordS"></span></li>
	        </ul>
	        <ul class="ord_betArea_wordBottom">
	        	<li class="dark_BrownWord no_margin"><tt>'.filiter_team($row['team_s']).'</tt> <tt class="RedWord fatWord"></tt> @ <span id="P'.$tcount.'" class="redFatWord">'.number_format($row['ratio'],2).'</span></li>
	        </ul>
				<div id="TR'.$tcount.'_Mask" class="ord_Mask" style="display:none;"><span class="ord_betCloseBTN" name="delteam'.$tcount.'" value="" onclick="delteams('.$tcount.')"></span></div><!--不能下注遮罩-->
	        </div>';
				$TEAMCOUNT++;
			}
			$ioratio=$row['ratio'];
		}
	}

	if($teamcount==2){
		$minlimit1=$_REQUEST["minlimit1"];
		$minlimit2=$_REQUEST["minlimit2"];
		if($minlimit1==$minlimit2 and $minlimit1==2){
			$minlimit=2;
		}else{
			$minlimit=3;
		}
	}else{
		$minlimit=3;
	}
}


//串下注总额
$ggid = substr($ggid,0,-1);
$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and MID = '$ggid' and linetype=17 and active<3";
$result = mysql_db_query($dbname,$havesql);
$haverow = mysql_fetch_array($result);
$score=$haverow['BetScore']+0;
$SC=$SC.$score.' ';
$score1=$score1+$score;

$CONTENT=str_replace("<font color=gray> - [$body_sb]</font>",'',$CONTENT);

if ($gdate==date('m-d') or $gdate==''){
	$active=1;
	$css="OFT";
}else{
	$active=2;
	$css="OFU";
}
$caption=$Soccer;

if ($active==2){
	$caption=$Soccer." - ".$zaopan;
}else{
	$caption=$Soccer;
}
?>
<script>
	var iorstr='<?=$IORSTR?>';
	var minlimit='<?=$minlimit?>';
	var maxlimit='10';
</script>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/order.css" rel="stylesheet" type="text/css">
	<script><?=$SCRIPTARRAY?>
	</script>
	<script>
		var count_win=false;
		//alert(self.name);
		//window.setTimeout("Win_Redirect()", 45000);
		var winRedirectTimer=45000;
		var winRedirect=0;

		function onLoad(){
			//top.keepGold="";
			document.getElementById("gold").blur();
			document.getElementById("gold").focus();
			if(""+top.resetCheck!="undefined"){
				var reloadTime=document.getElementById("checkOrder");
				reloadTime.checked=top.resetCheck;
			}

			//onclickReloadTime();
			resetGold();

			parent.onloadSet(document.body.scrollWidth,document.body.scrollHeight,"bet_order_frame");
			LoadSelect();
			check_sel_team();
			try{
				if (killgid!=""){
					parent.parent.body.killgid(killgid);
				}
			}catch(E){}
		}
		//檢查所選隊伍 是否變動過
		function check_sel_team(){
			//alert(top.scripts)
			if(""+top.scripts!="undefined"){
				try{
					for (i=0;i < scripts.length;i++){
						//scripts[0]=new Array('505643','PRH','H','0','0','1.9');

						ms=get_ms(scripts[i][1]);
						gidm_new=parent.parent.body.get_gidm(scripts[i][0],ms);
						for (s=0;s < top.scripts.length;s++){
							//alert("1");
							ms=get_ms(top.scripts[s][1]);
							gidm_old=parent.parent.body.get_gidm(top.scripts[s][0],ms);
							//搜尋有沒出現在舊的ary裡面
							//alert(gidm_old+"----"+gidm_new);
							if (gidm_old==gidm_new&&gidm_old!=""){
								//如果找到同gid判斷是否有改變過 rtype
								//alert(scripts[i][1]+"...."+top.scripts[s][1]);
								if (scripts[i][1]!=top.scripts[s][1]||scripts[i][0]!=top.scripts[s][0]){
									//alert(scripts[i][1]+"---"+top.scripts[s][1]);
									document.getElementById("team"+(i+1)).className="team_ch";
								}
								break;
							}
						}
					}
				}catch(E){
					//alert("err");
				}
			}
			top.scripts=scripts;


		}
		function get_ms(tmp){
			//alert(tmp+"--"+tmp.length)
			if (tmp.length >= 4){
				if (tmp.substring(0,2)=="HH"||tmp.substring(0,2)=="HP"){
					return "H";
				}
			}else{
				if (tmp.substring(0,1)=="H"){
					return "H";
				}
			}
			return "";
		}
		//盤面自動重取賠率 start
		function onclickReloadTime(){
			var reloadTime=document.getElementById("checkOrder");
			top.resetCheck=reloadTime.checked;
			window.clearTimeout(winRedirect);
			if (!reloadTime.checked){
				//winRedirect=window.setTimeout("Win_Redirect()", winRedirectTimer);
			}else{
				winRedirect=window.setTimeout("winReload()", 1000);
			}
		}
		function onclickReloadAutoOdd(){
			var reloadautoOdd=document.getElementById("autoOdd");
			top.autoOddCheck=reloadautoOdd.checked;
		}
		function orderReload(){
			window.location.href=window.location;
		}
		function resetTimer(){
			//回復reload時間
			onclickReloadTime();
		}
		function resetGold(){
			if (""+top.keepGold_PR!="undefined" && top.keepGold_PR!="" ){
				document.getElementById("gold").value=top.keepGold_PR;
				if(rtype=="P"){
					var mode = 0;
				} else if(rtype=="PR") {
					var mode = 1;
				} else if(rtype=="P3"){
					var mode = 3;
				}
				CountWinGold(iorstr,mode);
			}
		}
		function winReload(){
			var showTimer=document.getElementById("ODtimer").innerHTML;
			showTimer=showTimer*1-1;
			document.getElementById("ODtimer").innerHTML=showTimer;
			if (showTimer<=0){
				//去執行過關盤面,OP_mem_showgame_p3.js
				//alert(top.ordergid.length);
				try{
					if (top.ordergid.length > 0){
						parent.parent.body.orderParlayParam();
					}else{
						document.getElementById("ODtimer").innerHTML="10";
						winRedirect=window.setTimeout("winReload()", 1000);
					}
				}catch(E){
					document.getElementById("ODtimer").innerHTML="10";
					winRedirect=window.setTimeout("winReload()", 1000);
				}
				//window.location.reload();
			}else{
				winRedirect=window.setTimeout("winReload()", 1000);
			}
		}
		//盤面自動重取賠率 end


		function Win_Redirect(){
			/*
			 var i=document.all.uid.value;
			 var pdate=document.all.pdate.value;
			 var page=document.URL;
			 //top.orderArray=new Array();
			 //top.ordergid=new Array();

			 parent.parent.body.orderRemoveALL();
			 go_page="../select.php?uid="+i;
			 self.location=go_page;
			 */
			//去執行過關盤面,OP_mem_showgame_p3.js
			try{
				parent.parent.body.orderRemoveALL();
			}catch (E) {}
			top.scripts=new Array();
			parent.close_bet();
		}
		/*
		 function resort(ary){
		 var tempary=new Array();
		 for(var i=0;i<ary.length;i++){
		 if (ary[i]!=0){
		 tempary[tempary.length]=ary[i];
		 }
		 }
		 return tempary;
		 }

		 */
		function delteams(teamid){
			/*
			 alert(scripts[teamid-1][0]);
			 for(var i=0;i<top.ordergid.length;i++){
			 //	alert("gid==>"+top.ordergid[i]);
			 var obj=top.orderArray["G"+top.ordergid[i]];
			 if (obj.gid==scripts[teamid-1][0] || obj.hgid==scripts[teamid-1][0]){
			 top.orderArray["G"+top.ordergid[i]]="undefined";
			 top.ordergid[i]=0;

			 }
			 }

			 top.ordergid=resort(top.ordergid);
			 */
//alert(parent.parent.body.name)
			//alert(teamid);
			//去執行過關盤面,OP_mem_showgame_p3.js
			try{
				parent.parent.body.orderRemoveGid(scripts[teamid-1][0]);
			}catch(E){}
			try{
				parent.parent.body.orderParlayParam();
			}catch(E){}
			eval("TR"+teamid+".style.display='none'");
			document.all.teamcount.value=document.all.teamcount.value-1;
			scripts[teamid-1][0]="0";
			LoadSelect();
		}

		function LoadSelect(){
			if(rtype=="P"){
				var mode = 0;
			} else if(rtype=="PR") {
				var mode = 1;
			} else if(rtype=="P3"){
				var mode = 3;
			}
			//if (top.paramData.length == 0){
//	 top.paramData=scripts;
			//}else if (top.paramData.length==scripts.length){
			//alert(top.paramData.length+"=="+scripts.length);
			//if (top.paramData.length==scripts.length){
			//top.paramData=scripts;

			for (s=0;s < scripts.length ;s++){

				for (i=0;i < parent.parent.paramData.length ;i++){
					//check GID
					if (parent.parent.paramData[i][0]==scripts[s][0]){
						if (parent.parent.paramData[i][3]!=scripts[s][3]||parent.parent.paramData[i][4]!=scripts[s][4]||parent.parent.paramData[i][5]!=scripts[s][5]){
							//eval("document.getElementById('P"+(s+1)+"').style.background='#FFDFDF'");
							document.getElementById("P"+(s+1)).className="lightOn";
							//put gold
							if(document.all.gold.value==""){
								document.all.gold.value=parent.parent.goldData;
								document.all.gold.focus();
								CountWinGold(iorstr,mode);
							}
						}
					}
				}
			}
			parent.parent.paramData=new Array();
			//}

			//document.all.wteam.style.display="none"
			//alert("===>"+minlimit);
			if(document.all.teamcount.value <= (minlimit*1-1)){
				//document.all.btnCancel.disabled = true;
				document.all.SUBMIT.disabled = true;
				//document.all.wkind.style.display="none"
				//document.all.wstar.style.display="none"
				document.all.gold.style.display="none"
			}
			if (document.all.teamcount.value <= 0){
				//alert(document.all.teamcount.value);
				Win_Redirect();
				//document.all.wstar.length = 1;
				//document.all.wstar.options[0]=new Option(document.all.teamcount.value+top.message017,document.all.teamcount.value);
			}

		}

		function chiang_wkind(){
			if(document.all.wkind.value == 'M'){
				document.all.wstar.length = document.all.teamcount.value-2;
				for(i=2; i<document.all.teamcount.value; i++)
					document.all.wstar.options[i-2]=new Option(i+top.message017,i);
				document.all.wteam.style.display="block";
				document.all.wteam.length = 1;
				var count=0;
				var start=eval(document.all.wstar.value)+1;
				document.all.wteam.options[count++]=new Option(document.all.teamcount.value+top.message018,document.all.teamcount.value)
			}else{
				document.all.wstar.length = 1;
				document.all.wstar.options[0]=new Option(document.all.teamcount.value+top.message017,document.all.teamcount.value);
				document.all.wteam.style.display="none";
			}
		}

		function chiang_wstar(){
			if(document.all.wkind.value == 'M'){
				document.all.wteam.style.display="block";
				document.all.wteam.length = 1;
				var count=0;
				var start=eval(document.all.wstar.value)+1;
				document.all.wteam.options[0]=new Option(document.all.teamcount.value+top.message018,document.all.teamcount.value)
			}else{
				document.all.wteam.style.display="none";
			}
		}

		function CheckKey(evt){
			var key = window.event ? evt.keyCode : evt.which;
			//alert(key)
			//var keychar = String.fromCharCode(key);
			//alert(keychar)

			if(key == 32){
				return false;
			}

			if(key == 13) {
				CountWinGold(iorstr,3);
				CheckSubmit();
			}
			else if((key < 48 || key > 57) && (key > 95 || key < 106)){alert(top.message015); return false;}

			//if (isNaN(event.keyCode) == true)){alert(top.message015); return false;}
		}


		function CheckSubmit(){

			if (parent.parent.paramData.length == 0||(""+parent.parent.paramData.length=="undefined")){
				parent.parent.paramData=scripts;
				//alert("aaa==>"+parent.parent.paramData+"==bbb===>"+scripts);
			}
			if(document.all.gold.value==''){
				document.all.gold.focus();
				alert(top.message001);
				return false;
			}else if(document.all.teamcount.value <= (minlimit*1-1)){
				alert(top.message019+minlimit+top.message020);
				return false;
			}else if(document.all.teamcount.value > maxlimit*1){
				alert(top.message021 + document.all.teamcount.value + top.message022);
				return false;
			}else if(document.all.gold.value==''){
				alert(top.message023);
				document.all.gold.focus();
				return false;
			}else if(document.all.gold.value*1 < (document.all.gmin_single.value.replace(",",'')*1)){
				document.all.gold.focus();
				alert(top.message003+" "+top.mcurrency+" "+document.all.gmin_single.value);
				return false;
				//檢查現金顧客
			}else if (document.all.pay_type.value =='1') {
				if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value)){
					document.all.gold.focus();
					alert(top.message024);
					return false;
				}
			}else if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value)){
				document.all.gold.focus();
				alert(top.message025);
				return false;
			}else if(!confirm(top.message011+document.all.pc.innerHTML+top.message016)){return false;}
			document.all.btnCancel.disabled = true;
			document.all.Submit.disabled = true;
			document.all.gold.readOnly=true;
			document.all.gold.blur();
			document.all.wagerDatas.value="";
			for (kk=0;kk<scripts.length;kk++){
				if (scripts[kk][0]!="0")  document.all.wagerDatas.value+=scripts[kk].toString()+"|";
			}
			//將金額放到暫存
			parent.parent.goldData=document.all.gold.value;

			//top.orderArray=new Array();
			//top.ordergid=new Array();

			document.forms[0].submit();
			parent.parent.body.orderRemoveALL();
		}

		//計算彩金
		function CountWinGold(chk,mode){
			/*------------------------------------------------
			 * edit date --- 2005/7/14						*
			 * From anson										*
			 * Content --- from 202 to 206					*
			 -------------------------------------------------*/
			//document.all.pc.innerHTM=chk;
			chk=chk.split(' ');
			var iortmp="";
			if(document.all.gold.value==''){
				document.getElementById("gold").blur();
				document.getElementById("gold").focus();
				document.all.pc.innerHTML="0";
				top.keepGold_PR="";
				//alert(top.message014);
			}else{
				top.keepGold_PR=document.getElementById("gold").value;
				counttmp=document.all.tcount.value;
				gold1=document.all.gold.value;
				if(counttmp>1){
					//	document.all.pc.innerHTML=chk[1];
					tmp=1;
					for(q=0;q<counttmp;q++){
						if (scripts[q][0] != "0"){
							if(mode=="3"||mode=="1"){
								tmp*=((parseFloat(chk[q])));
							}else{
								tmp*=(mode+(parseFloat(chk[q])));
							}

						}
					}

					var tmp_var=gold1*tmp-gold1;
					tmp_var=Math.round(tmp_var*100);
					tmp_var=tmp_var/100;
					if (tmp_var*1 > document.getElementById("maxgold").value*1){
						document.getElementById("err_div").style.display="";
					}else{
						document.getElementById("err_div").style.display="none";
					}

					parent.onloadSet(document.body.scrollWidth,document.body.scrollHeight,"bet_order_frame");
					tmp_var=addComma(tmp_var);
					tmp_var=printf(tmp_var,2);
					document.all.pc.innerHTML=tmp_var;

				}
			}
		}

		//千分位符號
		function addComma(vals){
			var integer = "";
			var decimal = "";
			var tmpval = "";

			var pn = (vals<0)?"-":"";
			vals = ""+Math.abs(vals);
			if(vals.indexOf(".")>=0){
				var valarr = vals.split(".");
				integer = valarr[0];
				decimal = valarr[1];
				tmpval = valarr[0];
			}else{
				integer = vals;
				tmpval = vals;
			}
			for (ii=integer.length;ii>3;ii-=3){
				var comma_index = ii-3;
				var strA = tmpval.substring(0,comma_index);
				var strB = tmpval.substring(comma_index);
				tmpval = strA+","+strB;
			}
			if(vals.indexOf(".")>=0){
				tmpval += "."+decimal;
			}
			tmpval = pn+tmpval;
			return tmpval;
		}
		//小數點位數
		function printf(vals, points) {
			vals = "" + vals;
			var cmd = new Array();
			cmd = vals.split(".");
			if (cmd.length > 1){
				for (ii=0; ii<(points-cmd[1].length); ii++) vals = vals + "0";
			}else{
				vals = vals + ".";
				for (ii=0; ii<points; ii++) vals = vals + "0";
			}
			return vals;
		}
	</script>
	<script language="JavaScript" src="/js/jquery-3.1.0.min.js"></script>
	<script language="JavaScript" src="/js/football_order_tt.js"></script>
</head>

<body id="OFTP3" class="bodyset" onLoad="onLoad();LoadSelect();"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form name="LAYOUTFORM" action="/app/member/OP_order/OP_order_p3_finish.php" method="post" onSubmit="return false">
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
	<input type="hidden" name="langx" value="<?=$langx?>">
	<input type="hidden" name="teamcount" value="<?=$TEAMCOUNT?>">
	<input type="hidden" name="tcount" value="<?=$TEAMCOUNT?>">
	<input type="hidden" name="username" value="{USERNAME}">
	<input type="hidden" name="singlecredit" value="<?=$GMAX_SINGLE?>">
	<input type="hidden" name="gmax_single" value="<?=$GSINGLE_CREDIT?>">
	<input type="hidden" name="gmin_single" value="<?=$GMIN_SINGLE?>">
	<input type="hidden" name="restcredit" value="<?=$credit?>">
	<input type="hidden" name="wagerstotal" value="<?=$score1?>">
	<input type="hidden" name="pay_type" value="<?=$pay_type?>">
	<input type="hidden" name="sc" value="<?=$SC?>">
	<input type="hidden" name="pdate" value="<?=$m_date?>">
	<input type="hidden" value="<?=$odd_f_type?>" name=odd_f_type>
	<input type="hidden" id="wagerDatas" name="wagerDatas" value="">
	<input type="hidden" id="maxgold" name="maxgold" value="1000000">

</FORM>
</body>
</html>



