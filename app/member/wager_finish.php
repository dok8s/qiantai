<?
//if ($HTTP_SERVER_VARS['SERVER_ADDR']<>"58.64.136.81"){exit;}if (date('Y-m-d')>'2009-01-01'){exit;}

include "./include/library.mem.php";
require ("./include/config.inc.php");
require ("./include/define_function_list.inc.php");
$titleStr=$_REQUEST['titleStr'];
$styleID=$_REQUEST['styleID'];
$msgStr=urldecode($_REQUEST['msgStr']);
$langx=$_REQUEST['str_meta'];
$ls=$_REQUEST['LS'];
$uid=$_REQUEST['uid'];

include("include/traditional.$langx.inc.php");

if($styleID=='BLUE'){
	if($ls=='p'){
		$msgtext=$msgStr.rand(10,100);
	}else if($ls=='r'){
		$msgtext=$bet_repeat.rand(0,100);
	}else if($ls=='g'){
		$msgtext=$bet_singlemax.rand(0,100);
	}else{
		$msgtext=$bet_close.rand(0,100);
	}
	$title="Attention";
}else if($styleID=='PINK'){
	$msgtext=$zdqrz1;
	$title=$zdqrz;
}else{
	$msgtext=$OrderSucc;
	$title=substr($order_voucher,0,8);
}
?>

<html>
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Attention</title>
<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
<link href="/style/member/order.css" rel="stylesheet" type="text/css">
<script>killgid = '';
	pdate = '';
	error_flag = '1X001';
	error_wtype = 'RM';
</script>
	<script language="JavaScript" src="/js/order_finish.js"></script>
</head>

<body id="<?=$styleID?>">
<div id="TV_Order" class="">
	<div class="ord_DIV">

		<h1 id="SIN_BET">单一投注</h1>
		<h1 id="PAR_BET" style="display:none">综合过关</h1>
		<!--错误警告-->
		<div class="ord_warnG"><span><?=$msgtext?></span></div>
		<!--确定下注区-->
		<div class="ord_TotalAreaG">
			<span id="betBTN" class="ord_betBTN_off" onclick="parent.backBet();">确定交易</span>
			<span class="ord_cancalBTN" onclick="parent.close_bet();">取消</span>
		</div>

	</div>
</div>

</body>
</html>