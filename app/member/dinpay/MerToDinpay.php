<?php
	include 'merchantProperties.php';	

  // 公共函数定义
  function StrToHex($string)
  {
     $hex="";
     for ($i=0;$i<strlen($string);$i++)
         $hex.=dechex(ord($string[$i]));
     $hex=strtoupper($hex);
     return $hex;
  }
  
  function getOrderId()
  {
	return rand(100000,999999)."".date("YmdHis");
  }
  
	$m_id		=	$p1_MerId;	
	$m_orderid	=	getOrderId();
	$m_oamount	=	$_POST['p3_Amt'];
	$m_ocurrency    =1;
	$m_url		=	$_POST['p8_Url'];
	$m_language	=	1;
	$s_name		=	$_POST['pa_MP'];

	$modate		=	date("Y-m-d H:i:s");
	$m_status	= 	0;

	//组织订单信息
	$m_info = $m_id."|".$m_orderid."|".$m_oamount."|".$m_ocurrency."|".$m_url."|".$m_language;
	$s_info = $s_name."|".$s_addr."|".$s_postcode."|".$s_tel."|".$s_eml;
	$r_info = $r_name."|".$r_addr."|".$r_postcode."|".$r_tel."|".$r_eml."|".$m_ocomment."|".$m_status."|".$modate;

	$OrderInfo = $m_info."|".$s_info."|".$r_info;

	//echo $OrderInfo;

	//订单信息先转换成HEX，然后再加密
	$key = $merchantKey;     //<--支付密钥--> 注:此处密钥必须与商家后台里的密钥一致

	$OrderInfo = StrToHex($OrderInfo);
	$digest = strtoupper(md5($OrderInfo.$key));
?>

<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
</head>
<body onload='document.FORM.submit();'>
<form name='FORM' method='post' action='https://payment.dinpay.com/PHPReceiveMerchantAction.do'>
	<input type='hidden' name='OrderMessage' value='<?= $OrderInfo?>'>
	<input type='hidden' name='digest' value='<?= $digest?>'>
	<input type='hidden' name='M_ID' value='<?= $m_id?>'>
        <input type="hidden" name="s" value="submit">
</form>
</body>
</html>
