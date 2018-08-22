<?php

/*
 * @Description ױ֧Ʒͨýӿڷ 
 * @V3.0
 * @Author rui.xin
 */

require ("../include/config.inc.php");
$paysql = "select `Business`,`Keys` from web_payment_data where Switch=1";
$payresult = mysql_db_query($dbname,$paysql);
$payrow=mysql_fetch_array($payresult);
$business=$payrow['Business'];
$keys=$payrow['Keys'];

$p1_MerId	  = "$business";	#̻
$merchantKey  = "$keys";		#̻Կ
//$p1_MerId	  = "2090145";	#̻
//$merchantKey  = "ejhoiaubfli3u740989^RY_8y09";		#̻Կ


	$s_addr		=	'深圳市快汇宝信息技术有限公司罗湖区东门百货广场东座2308';
	$s_postcode	=	'518000';
	$s_tel		=	'0755-88833166';
	$s_eml		=	'service@hg7171.com';
	$r_name		=	'王立';
	$r_addr		=	'深圳市快汇宝信息技术有限公司罗湖区东门百货广场东座2308';
	$r_postcode	=	'100080';
	$r_tel		=	'0755-82384511';
	$r_eml		=	'service@hg7171.com';
	$m_ocomment	=	'欢迎使用快汇宝在线支付';

?> 