<?php
require ("./include/config.inc.php");
$uid = $_REQUEST['uid'];
$langx = $_REQUEST['langx'];
$paysql = "select Address from web_payment where Switch=1";
$payresult = mysql_db_query($dbname,$paysql);
$payrow=mysql_fetch_array($payresult);
$address=$payrow['Address'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>选择支付方式</title>
<style type="text/css">
<!--
body {
	background-color: #333;
}
-->
</style></head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="460" valign="top"><table width="700" border="0" cellspacing="10" cellpadding="0">
      <tr>
        <td width="150" align="center" valign="middle" bgcolor="#F5F5F5"><strong>网银在线</strong></td>
        <td width="550"><a href="GolPay/register.php?uid=<?=$uid?>&langx=<?=$langx?>"><img border="0" src="onlinepay.jpg" width="85" height="53" /></a></td>
      </tr>
      <tr>
        <td align="center" valign="middle" bgcolor="#F5F5F5"><strong>银行汇款</strong></td>
        <td><a href="Bank/index.php?uid=<?=$uid ?>&langx=<?=$langx ?>"><img src="mepay.jpg" border="0" width="85" height="53" /></a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
