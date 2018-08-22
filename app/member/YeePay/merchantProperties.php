<?php

/*
 * @Description ױ֧Ʒͨýӿڷ 
 * @V3.0
 * @Author rui.xin
 */

#	̻p1_MerId,ԼԿmerchantKey Ҫױ֧ƽ̨
require ("../include/config.inc.php");
$paysql = "select `Business`,`Keys` from web_payment_data where Switch=1";
$payresult = mysql_db_query($dbname,$paysql);
$payrow=mysql_fetch_array($payresult);
$business=$payrow['Business'];
$keys=$payrow['Keys'];

//$p1_MerId	  = "$business";	#̻
//$merchantKey  = "$keys";		#̻Կ
$p1_MerId	  = $business;	#̻
$merchantKey  = $keys;		#̻Կ
$logName	  = "YeePay_HTML.log";

?> 