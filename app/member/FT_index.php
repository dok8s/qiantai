<?php

include "./include/library.mem.php";
require ("./include/define_function_list.inc.php");
require ("./include/config.inc.php");

$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
setcookie('langx',$langx);
setcookie('uid_value',$uid);

$memname = IsMember($uid);
require ("./include/traditional.$langx.inc.php");

//$showtype = !empty($_REQUEST['showtype'])?$_REQUEST['showtype']:'';
//if ($showtype=="future"){
//	$header="future";
//	$body=BROWSER_IP."/app/member/FT_future/index.php?uid=$uid&langx=$langx&mtype=$mtype";
//}else{
//	$header="";
//	$body=BROWSER_IP."/app/member/FT_browse/index.php?uid=$uid&langx=$langx&mtype=$mtype";
//}

if($mtype==""){
	$mtype=3;
}
$mysql = "select * from web_system";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$mDate=date('m-d');
switch($langx){
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		break;
	case "zh-vn":
		$suid=$row['uid_vn'];
		$site=$row['datasite_vn'];
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		break;
}
?>
<html>
<head>
	<title><?=$nihao?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="/style/member/reset_indexFT.css" rel="stylesheet" type="text/css">
	<link href="/style/member/warn_web.css" rel="stylesheet" type="text/css">
	<script src="/conf/script_FT_index.php"></script>

	<script src="/js/util.js"></script>
	<script src="/js/jquery-3.1.0.min.js"></script>
	<script src="/js/CookieManager.js"></script>
	<script src="/js/HttpRequest.js"></script>
	<script src="/js/ParseHTML.js"></script>
	<script src="/js/JQAnimate.js"></script>
	<script src="/js/getView.js"></script>
	<script src="/js/top_show.js"></script>
	<!--<script src="/js/hasLogin.js"></script>-->
	<script>
		top.newWinObj = new Array();
		top.mem_status='Y';
	</script>

	<script src="/js/initHeader.js"></script>
<!--	<script src="/js/XmlNode.js"></script>-->
<!--	<script src="/js/HttpRequestXML.js"></script>-->

	<link rel="stylesheet" type="text/css" href="/style/member/header.css"></head>

<body id="FT_index_body" onload="init();setSizeTV(this);" onresize="setSizeTV(this);" style="overflow-y:hidden" class="index_body">
<div id="loadingMain" class="index_MDIV" style="display: none;"></div>
<div id="top_div" class="indexMain_DIV indexW_min">
	<!--大load-->
	<table class="indexMain_TB coffee" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr class="wt">
			<td id="header" class="index_headTD" colspan="3" url="/app/member/FT_header.php?uid=<?=$uid?>&showtype=&langx=<?=$langx?>&mtype=2&showKR=N">
			</td>
		</tr>

		<tr class="wt">

			<td class="index_leftTD">
				<div id="loadingL" class="index_loadDIV" style="display:none"></div>
				<iframe onload="iframe_onError(this,showerror);" id="mem_order" name="mem_order" noresize="" scrolling="NO" src="./order/order.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=2" width="100%" height="100%" frameborder="0"></iframe>
			</td>
			<td class="index_midTD">
				<div id="status_s_zh-vn" class="status_errDIV" style="display:none">您的帳戶狀態已被改為 “只能看帳”。<br>您只能繼續查看<tt onclick="showMyAccount('OpenBets');">交易狀況</tt>和<tt onclick="showMyAccount('Statement');">帳戶歷史</tt>。</div>
				<div id="status_s_zh-cn" class="status_errDIV" style="display:none">Trạng thái tài khoản của bạn đã được đổi thành "Chỉ đọc".<br> Bạn chỉ có thể tiếp tục xem <tt onclick = "showMyAccount ('OpenBets');">trạng thái giao dịch</ tt> và <tt onclick = "showMyAccount ('Statement');">lịch sử tài khoản</ tt></div>
				<div id="status_s_en-us" class="status_errDIV" style="display:none">Your account has been changed to ‘View Only’ access.<br>You may only access <tt onclick="showMyAccount('OpenBets');">Open Bets</tt> and <tt onclick="showMyAccount('Statement');">Statements</tt>.</div>
				<div id="status_s_ko-kr" class="status_errDIV" style="display:none">고객님의 계정이 "조회 전용" 상태로 전환 되었습니다.<br>고객님은 <tt onclick="showMyAccount('OpenBets');">미정산 베팅</tt> 및 <tt onclick="showMyAccount('Statement');">계정내역에</tt> 한하여 이용하실 수 있습니다.</div>

				<div id="body_view" name="body_view" style="display:;width:100%;height:100%;">
					<iframe onload="iframe_onErrorFT(this,showerrorFT);" id="body" name="body" src="./FT_browse/index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>&league_id=" width="100%" height="100%" frameborder="0"></iframe>
				</div>
			</td>
			<td id="top_tv" style="display:none" class="index_rightTD coffee">
				<div id="noTV" class="index_noDIV" style="display:none"></div>
				<div id="loadingR" class="index_loadDIV" style="display:none"></div>
				<iframe onload="iframe_onError(this,showerror);" id="show_tv" name="show_tv" src="./live/live.php?uid=<?=$uid?>&langx=zh-cn&opentype=self" noresize="" scrolling="NO" width="100%" height="100%" frameborder="0"></iframe>
			</td>


		</tr>

		</tbody></table>

<!--		<div id="loading" class="index_loadDIV" style="display: none;"><div class="index_loadDIV_edge"></div></div>-->
</div>


</body>
</html>