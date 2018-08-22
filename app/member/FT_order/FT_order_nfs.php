<?

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$tid=$_REQUEST['rtype'];
$gametype=$_REQUEST['gametype'];
$gtype=$_REQUEST['type'];
$sql = "select Memname,FS_R_Scene,FS_R_Bet,OpenType,language,pay_type,Money from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}


$langx=$_REQUEST['langx'];
//$body_js=getcss($langx);
$pay_type=$row['pay_type'];
require ("../include/traditional.$langx.inc.php");
switch($gametype){
case 'FT':
 		$langname=$Soccer;
		break;
case 'BK':
		$langname=$BasketBall;
		break;
case 'TN':
		$langname=$Tennis;
		break;
case 'BS':
		$langname=$bangqiu;
		break;
case 'VB':
		$langname=$Voll;
		break;
case 'OP':
		$langname=$qita;
		break;
}
wager_danger($uid,$dbname);order_accept($uid,$dbname);

$mysql = "select maxgold,id,date_format(mstart,'%m-%d') as gdate,$team as MB_Team,concat($ssleague,'<br>',$sleague) as league,rate as M_Rate from sp_match where `MID`=$gid and gid='$tid'";

$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
	exit;
}else{
	$memname=$row['Memname'];
	$credit=$row['Money'];

	$GMAX_SINGLE=$row['FS_R_Scene'];
	$GSINGLE_CREDIT=$row['FS_R_Bet'];
	//userlog($memname);
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	$mid=$row['id'];
	$gdate=$row['gdate'];

	$havesql="select sum(BetScore) as BetScore from web_db_io where m_name='$memname' and mid='$mid' and linetype=16";

	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;


	$btset=singleset('fs');
	$GMIN_SINGLE=$btset[0];
	$maxgold=$row['maxgold'];

	if($GSINGLE_CREDIT>$maxgold){
		$bettop=$maxgold;
	}else{
		$bettop=$GSINGLE_CREDIT;
	}

	$MB_Team=$row["MB_Team"];
	$MB_Team=filiter_team($MB_Team);
	$TG_Team=filiter_team($TG_Team);
	$M_Place=$MB_Team;
	$M_Sign="";
	$M_Rate=$row['M_Rate'];
	$caption="单一投注";
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
		<script>
			var count_win=false;
			//if (self==top) 	self.location.href="http://"+document.domain;
			//window.setTimeout("Win_Redirect()", 45000);
			var winRedirectTimer=45000;
			var winRedirect=0;
			window.onload = function (){
				//top.keepGold="";
				document.getElementById("gold").blur();
				document.getElementById("gold").focus();
//				if(""+top.resetCheck!="undefined"){
//					var reloadTime=document.getElementById("checkOrder");
//					reloadTime.checked=top.resetCheck;
//				}
				if(""+top.autoOddCheck!="undefined"){
					var reloadautoOdd=document.getElementById("autoOdd");
					reloadautoOdd.checked=top.autoOddCheck;
				}
//				onclickReloadTime();
				resetGold();
				parent.onloadSet(document.body.scrollWidth,document.body.scrollHeight,"bet_order_frame");
				check_ioradio();
			}
			//檢查賠率變色
			function check_ioradio(){

				var tmp_ior=document.getElementById("ioradio_fs").value;
				//alert("tmp_ior="+tmp_ior+",top.ioradio="+top.ioradio);
				if (top.ioradio==""){
					top.ioradio=tmp_ior;
				}
				if (top.ioradio!=tmp_ior){
					top.ioradio=tmp_ior;
				}

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
				if (""+top.keepGold!="undefined" && top.keepGold!="" ){
					document.getElementById("gold").value=top.keepGold;
					CountWinGold();
				}
			}
			function winReload(){
				var showTimer=document.getElementById("ODtimer").innerHTML;
				showTimer=showTimer*1-1;
				document.getElementById("ODtimer").innerHTML=showTimer;
				if (showTimer<=0){
					window.location.reload();
				}else{
					winRedirect=window.setTimeout("winReload()", 1000);
				}
			}
			function clearAllTimer(){
				window.clearTimeout(winRedirect);
				winRedirect=window.setTimeout("Win_Redirect()", winRedirectTimer);
			}
			//盤面自動重取賠率 end

			function Win_Redirect(){
				//var i=document.all.uid.value;
				//self.location='../select.php?uid='+i;

				parent.close_bet();
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
					CountWinGold();
					SubChk();

				}
				else if((key < 48 || key > 57) && (key > 95 || key < 106)){alert(top.message015); return false;}

				//if (isNaN(event.keyCode) == true)){alert(top.message015); return false;}
			}

			function SubChk()
			{
				if(document.all.gold.value=='')
				{
					document.all.gold.focus();
					alert(top.message001);
					return false;

				}
				else if(isNaN(document.all.gold.value) == true)
				{
					document.all.gold.focus();
					alert(top.message002);
					return false;

				}

				else if(eval(document.all.gold.value*1) < (document.all.gmin_single.value.replace(",",'')*1)){
					document.all.gold.focus();
					alert(top.message003+" "+top.mcurrency+" "+document.all.gmin_single.value);
					return false;

				}
				//if (document.all.rtype.value=="ODD" || document.all.rtype.value=="EVEN")
				//{
				else if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value*1)){
					document.all.gold.focus();
					//alert(top.message004+" "+top.mcurrency+" "+document.all.gmax_single.value+top.message005);
					alert(top.message004+" "+top.mcurrency+" "+document.all.gmax_single.value);
					return false;

				}
				//}
				else if (document.all.pay_type.value!='1') //不檢查現金顧客
				{
					if(eval(document.all.gold.value*1) > eval(document.all.singleorder.value))
					{
						document.all.gold.focus();
						alert(top.message006+" "+top.mcurrency+" "+document.all.singleorder.value);
						return false;

					}
					if((eval(document.all.restsinglecredit.value)+eval(document.all.gold.value*1)) > eval(document.all.singlecredit.value))
					{
						document.all.gold.focus();
						if (eval(document.all.restsinglecredit.value)==0)
						{
							alert(top.message007);
						}else{
							alert(top.message008+document.all.restsinglecredit.value+top.message009);
						}
						return false;

					}
				}
				else if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
				{
					document.all.gold.focus();
					alert(top.message010);
					return false;

				}


				if(!confirm(top.message011+document.all.pc.innerHTML+top.message016)){return false;}
				document.all.gold.blur();
				document.all.btnCancel.disabled = true;
				document.all.Submit.disabled = true;
				document.forms[0].submit();

			}
			function CountWinGold(){
				if(document.all.gold.value==''){
					document.all.gold.focus();
					document.all.pc.innerHTML="0";
					//alert(top.message014);
				}else{
					top.keepGold=document.getElementById("gold").value;
					var tmp_var=document.all.gold.value * document.all.ioradio_fs.value-document.all.gold.value;
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
					count_win=true;

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
		<script language="JavaScript" src="/js/football_order_tt.js"></script>
	</head>
	<!-- -->
	<body id="OFT" onselectstart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">

	<form name="LAYOUTFORM" action="/app/member/FT_order/FT_order_r_finish.php" method="post" onSubmit="return false">
		<div class="ord_main">
			<div class="ord_DIV">
				<!--div class="ord_returnBTN">返回体育项目</div-->
				<!--注单文字区-->
				<div class="ord_betAreaG">
					<h1><?=$caption?></h1>
					<div class="ord_noOrder" style="display:none">请把选项加入在您的注单。</div><!--没单文字-->
					<!--普通注单--><!--比分改变时ord_betArea_C-->
					<div id="ord_bet" class="ord_betArea">
						<ul class="ord_betArea_wordTop">
							<!-- 2016-12-14 足球多type所有细单改位罝显示  -->
							<li class="BlueWord"><?=$langname?>-<?=$Guan?></li>
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
						<div id="err_div" class="ord_warnG" style="display: none;"><span class="day_text"><?=$paicai1?></span></div>

						<!--确定下注区-->
						<div class="ord_TotalAreaG">
							<span id="Submit" class="ord_betBTN" onclick="CountWinGold();return SubChk();">确定交易</span><!--字数两行ord_betBTN02  不能按ord_betBTN_off-->
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

				<input type="hidden" name="uid" value="<?=$uid?>">
				<input type="hidden" name="langx" value="<?=$langx?>">
				<input type="hidden" name="active" value="6">
				<input type="hidden" name="line_type" value="3">
				<input type="hidden" name="gid" value="<?=$gid?>">
				<input type="hidden" name="tid" value="<?=$tid?>">
				<input type="hidden" id="ioradio_fs" name="ioradio_fs" value="<?=number_format($M_Rate,2)?>">
				<input type="hidden" name="gmax_single" value="<?=$bettop?>">

				<input type="hidden" value="<?=$GMIN_SINGLE?>" name=gmin_single>
				<input type="hidden" value="<?=$GMAX_SINGLE?>" name=singlecredit>
				<input type="hidden" value="<?=$GSINGLE_CREDIT?>" name=singleorder>
				<input type="hidden" name="restsinglecredit" value="<?=$have_bet?>">
				<input type="hidden" name="wagerstotal" value="0">
				<input type="hidden" name="restcredit" value="<?=$credit?>">
				<input type="hidden" name="pay_type" value="<?=$pay_type?>">
				<input type="hidden" name="gametype" value="<?=$gametype?>">
				<input type="hidden" name="rtype" value="<?=$rtype?>">
				<input type="hidden" name="wtype" value="<?=$wtype?>">
				<input type="hidden" id="maxgold" name="maxgold" value="1000000">
				<SCRIPT language=JavaScript>document.all.gold.focus();</SCRIPT>
			</div>
	</form>


	</body>
	</html>
<?
}
mysql_close();
?>
