<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$sql = "select * from web_member where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$paysql = "select Address from web_payment_data where Switch=1";
$payresult = mysql_db_query($dbname,$paysql);
$payrow=mysql_fetch_array($payresult);
$address=$payrow['Address'];
?>
<html>
<head>
<title>History</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">
<style>
<!--
#MFT #box { width:480px;}
#MFT .news { white-space: normal!important; color:#300; text-align:left; padding:2px 4px;}
.STYLE1 {color: #FF0000}
-->
</style>
<script language="JAVAScript">
<!--
//去掉空格
function check_null(string) { 
var i=string.length;
var j = 0; 
var k = 0; 
var flag = true;
while (k<i){ 
if (string.charAt(k)!= " ") 
j = j+1; 
k = k+1; 
} 
if (j==0){ 
flag = false;
} 
return flag; 
}
function VerifyData() {
if (document.main.p3_Amt.value == "") {
			alert("请输入存款金额！")
			document.main.p3_Amt.focus();
			return false;
}
if (document.main.p3_Amt.value !="") {
		  if(document.main.p3_Amt.value <100 )
		  {
			alert("充值不能小于100元！")
			document.main.p3_Amt.focus();
			return false;
		  }
}
document.main.action="<?=$address ?>/MerToDinpay.php";
}
-->
</script>
</HEAD>
<BODY id="MFT" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form method="post" name="main" onSubmit="return VerifyData()" target="_blank">
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td class="top">
  	  <h1><em>在线充值</em></h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
      <table border="0" cellspacing="1" cellpadding="0" class="game">
		<tr class="b_rig">
		  <td width="15%" height="30"><div align="right">阁下姓名：</div></td>
		  <td width="87%"><div align="left"><?=$row['Alias']?></div></td>
		</tr>
		<tr class="b_rig">
		  <td width="15%" height="30"><div align="right">会员帐号：</div></td>
		  <td width="87%"><div align="left"><?=$row['loginname']?></div></td>
		</tr>
		<tr class="b_rig">
		  <td height="30"><div align="right">目前额度：</div></td>
		  <td width="87%"><div align="left"><?=$row['Money']?></div></td>
		</tr>
        <tr class="b_rig">
		  <td align="right" height="30"><div align="right">手机号码：</div></td>
		  <td width="87%"><div align="left"><?=$row['phone']?></div></td>
		</tr>
		<tr class="b_rig">
		  <td height="30"><div align="right">充值金额：</div></td>
		  <td width="87%"><div align="left">
		  <input id="p3_Amt" maxLength="12" size="12" name="p3_Amt" style="width:180px">&nbsp;*
		  <input type="hidden" name="pa_MP" id="pa_MP" value="<?=$row['Memname']?>" />
		  <input type="hidden" name="p8_Url" id="p8_Url" value="<?=$address?>/DinpayToMer.php" />
		  <input size="50" type="hidden" name="pr_NeedResponse" id="pr_NeedResponse" value="1" />                           
		  <span class="style1">注:最低值100元 单位:元</span></div></td>
		</tr>
		<tr class="b_rig">
		  <td height="30" colspan="2" align="center"><span class="STYLE1">注意：交易成功后请点击返回支付网站可以查看您的订单信息。</span></td>
		  </tr>
		<tr class="b_rig">
		  <td colSpan="2" height="30"><div align="center"> 
		  <input class="input" type="submit" value="立即充值" name="submit">
		  <input class="input" type="reset" value="重新填写" name="submit2"></div></td>
		</tr>
      </table>
    </td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
</form>
</BODY>
</HTML>
