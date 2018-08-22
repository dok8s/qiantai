<?php
$langx=$_COOKIE['langx'];
$uid=$_COOKIE['uid_value'];
require ("../include/config.inc.php");
require("../include/traditional.$langx.inc.php");
?>
<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
	<title>hg0088</title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/my_account.css" rel="stylesheet" type="text/css">
	<script src="/js/lib/util.js"></script>
	<script src="/js/account/myaccount.js"></script>
</head>
<script>
	var type = top.account_type;
</script>
<body onLoad="init();">
<table cellspacing="0" cellpadding="0" class="acc_TB_main">
	<tr>

		<!--左边选单区-->
		<td><div class="acc_right_menuDIV">
				<h1><?=$my_account?></h1>
				<ul>
					<li id="history_data" onClick="linkEvent(this.id);"><?=$AccountHistory?></li>
					<li id="today_wagers" onClick="linkEvent(this.id);"><?=$WagerCondition1?></li>
					<li id="mem_conf" onClick="linkEvent(this.id);"><?=$pljs?></li>
					<li id="set_email" onClick="linkEvent(this.id);"><?=$pass_recovery?></li>
					<li id="chg_passwd" onClick="linkEvent(this.id);"><?=$passw?></li>
					<li id="scroll_history" onClick="linkEvent(this.id);"><?=$gglan?></li>
				</ul>
				<h1><?=$bangzu?></h1>
				<ul>
					<li id="sport_rules" onClick="linkEvent(this.id);"><?=$guize?></li>
					<li id="terms" onClick="linkEvent(this.id);"><?=$rules_terms?></li>
					<li id="result" onClick="linkEvent(this.id);"><?=$saiguo?></li>
					<li id="tutorials" onClick="linkEvent(this.id);"><?=$zhinan?></li>
					<li id="new_features" onClick="linkEvent(this.id);"><?=$new_function?></li>
					<li id="odds" onClick="linkEvent(this.id);"><?=$calculations?></li>
					<li id="contact_us" onClick="linkEvent(this.id);"><?=$lianxiz?></li>
					<li id="troubleshooting" onClick="linkEvent(this.id);"><?=$troubleshooting?></li>
				</ul>
			</div></td>
	</tr>
</table>

</body>
</html>
