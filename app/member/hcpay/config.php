<?php
//ƽ̨̻IDҪԼ̻ID

require ("../include/config.inc.php");
$paysql = "select `Business`,`Keys` from web_payment_data where Switch=1";
$payresult = mysql_db_query($dbname,$paysql);
$payrow=mysql_fetch_array($payresult);

$business=$payrow['Business'];
$keys=$payrow['Keys'];

$p1_memberid	  = "$business";	#̻
$memberkey        = "$keys";		#̻Կ
$UserId=$p1_memberid;


//ӿԿҪԼԿҪ̨õһ
//¼APIƽ̨̻-->ȫ-->ԿãԼԿ

$SalfStr=$memberkey;


//صַҪ³ڵƽ̨صַ

$BankUrl="https://pay.ecpss.com/sslpayment";

//ֵַ̨֪ͨ

$result_url="http://".$_SERVER["HTTP_HOST"]."/result_url.php";


//ֵûվϵתַ

$notify_url="http://".$_SERVER["HTTP_HOST"]."/advice_url.php";
?>