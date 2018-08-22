<?php
include_once("config.php");


$MD5key = $memberkey;		//MD5私钥
$MerNo = $p1_memberid;					//商户号
$BillNo =getOrderId();		//[必填]订单号(商户自己产生：要求不重复)
$Amount = round(intval($_REQUEST["p3_Amt"]),2);				//[必填]订单金额

$ReturnURL = $result_url;			//[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
$Remark = $_REQUEST['pa_MP'];  //[选填]升级。


$md5src = $MerNo."&".$BillNo."&".$Amount."&".$ReturnURL."&".$MD5key;		//校验源字符串
$SignInfo = strtoupper(md5($md5src));		//MD5检验结果


$AdviceURL =$notify_url;   //[必填]支付完成后，后台接收支付结果，可用来更新数据库值
$orderTime =date("YmdHis");   //[必填]交易时间YYYYMMDDHHMMSS
$defaultBankNumber =$_REQUEST['rtype'];;   //[选填]银行代码s 

//送货信息(方便维护，请尽量收集！如果没有以下信息提供，请传空值:'')
//因为关系到风险问题和以后商户升级的需要，如果有相应或相似的内容的一定要收集，实在没有的才赋空值,谢谢。

$products="game card";// '------------------物品信息

//在这里对订单进行入库保存
		$sql="select * from web_member where memname = '".$Remark."'";
		$result=mysql_db_query($dbname,$sql);
		$row=mysql_fetch_array($result);
		$agents=$row['Agents'];
		$world=$row['world'];
		$corprator=$row['corprator'];
		$super=$row['super'];
		$admin=$row['Admin'];


		$date=date("Y-m-d");
		$datetime=date("Y-m-d H:i:s");
		$sql = "insert into sys800 set checked=0,payway='W',gold='$Amount',AddDate='$date',type='S',Memname='$Remark',agents='$agents',world='$world',corprator='$corprator',super='$super',Admin='$admin',curtype='RMB',date='$datetime',name='$Remark',user='$Remark',waterno='".$defaultBankNumber."',Order_Code='$BillNo',notes='该订单用户正在支付中'";

		 mysql_db_query($dbname,$sql);

function getOrderId()
{
	return rand(100000,999999)."".date("YmdHis");
}
?>
<html>
<head>
<title>To hcpay Page</title>
</head>
<body onLoad="document.hcpay.submit();">
<form name='hcpay' action='<?php echo $BankUrl; ?>' method='post'>
    <input type="hidden" name="MerNo" value="<?=$MerNo?>">
    <input type="hidden" name="BillNo" value="<?=$BillNo?>">
    <input type="hidden" name="Amount" value="<?=$Amount?>">
    <input type="hidden" name="ReturnURL" value="<?=$ReturnURL?>" >
	<input type="hidden" name="AdviceURL" value="<?=$AdviceURL?>" >
	<input type="hidden" name="orderTime" value="<?=$orderTime?>">
	<input type="hidden" name="defaultBankNumber" value="<?=$defaultBankNumber?>">
    <input type="hidden" name="SignInfo" value="<?=$SignInfo?>">
    <input type="hidden" name="Remark" value="<?=$Remark?>">
    <input type="hidden" name="products" value="<?=$products?>">
</form>
</body>
</html>