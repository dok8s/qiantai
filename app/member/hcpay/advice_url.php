<?
include_once("config.php");

//MD5私钥
$MD5key = $memberkey;

//订单号
$BillNo = $_POST["BillNo"];
//金额
$Amount = $_POST["Amount"];
//支付状态
$Succeed = $_POST["Succeed"];
//支付结果
$Result = $_POST["Result"];
//取得的MD5校验信息
$SignMD5info = $_POST["SignMD5info"]; 
//备注
$Remark = $_POST["Remark"];



//校验源字符串
$md5src = $BillNo."&".$Amount."&".$Succeed."&".$MD5key;
//MD5检验结果
$md5sign = strtoupper(md5($md5src));

if ($SignMD5info==$md5sign)
{
	if ($Succeed=="88") //支付成功
	{
				
				$sql="select * from sys800 where Order_Code = '".$BillNo."'";
				$result = mysql_db_query($dbname,$sql);
				$cou=mysql_num_rows($result);
				if ($cou>0){
					$row=mysql_fetch_array($result);		  
			  		$sql="update sys800 set checked=1 where Order_Code='".$BillNo."'";
					mysql_db_query($dbname,$sql);
				    $sql_amt = "update web_member set Credit=Credit+$Amount,Money=Money+$Amount  where Memname='".$row['memname']."'";
				    mysql_db_query($dbname,$sql_amt);
			        echo "ok";
					exit;
				}else{
					echo "交易信息被篡改";exit;	
				}
				  //设置为成功订单,主意订单的重复处理
	}else if($opstate=="-1"){
				  //支付失败
		  echo "请求参数错误";
	}
}else{
	echo "签名错误";
}
?>