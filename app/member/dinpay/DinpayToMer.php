<? header("content-Type: text/html; charset=utf-8");?> 
<?php

include 'merchantProperties.php';	
  // 公共函数定义
  function HexToStr($hex)
  {
     $string="";
     for ($i=0;$i<strlen($hex)-1;$i+=2)
         $string.=chr(hexdec($hex[$i].$hex[$i+1]));
     return $string;
  } 

//=========================== 把商家的相关信息返回去 =======================
					
	$m_id		= 	'';			 //商家号	
	$m_orderid	= 	'';			//商家订单号
	$m_oamount	= 	'';			//支付金额
	$m_ocurrency= 	'';			//币种		
	$m_language	= 	'';			//语言选择
	$s_name		= 	'';			//消费者姓名
	$s_addr		= 	'';			//消费者住址
	$s_postcode	= 	''; 		//邮政编码
	$s_tel		= 	'';			//消费者联系电话
	$s_eml		= 	'';			//消费者邮件地址
	$r_name		= 	'';			//消费者姓名
	$r_addr		= 	'';			//收货人住址
	$r_postcode	= 	''; 		//收货人邮政编码
	$r_tel		= 	'';			//收货人联系电话
	$r_eml		= 	'';			//收货人电子地址
	$m_ocomment	= 	''; 		//备注
	$modate		=	'';			//返回日期
	$State		=	'';			//支付状态2成功,3失败
	
	//接收组件的加密
	$OrderInfo	=	$_POST['OrderMessage'];			//订单加密信息

	$signMsg 	=	$_POST['Digest'];				//密匙
	//接收新的md5加密认证

	//检查签名
	$key = $merchantKey;   //<--支付密钥--> 注:此处密钥必须与商家后台里的密钥一致
	//$digest = $MD5Digest->encrypt($OrderInfo.$key);
	$digest = strtoupper(md5($OrderInfo.$key));
//print_r($_POST);
?>
<?php
	if ($digest == $signMsg)
	{
		//解密
		//$decode = $DES->Descrypt($OrderInfo, $key);
		$OrderInfo = HexToStr($OrderInfo);
		//=========================== 分解字符串 ====================================
		$parm=explode("|", $OrderInfo);

		$m_id		= 	$parm[0];				
		$m_orderid	= 	$parm[1];		
		$m_oamount	= 	$parm[2];			
		$m_ocurrency= 	$parm[3];				
		$m_language	= 	$parm[4];			
		$s_name		= 	$parm[5];				
		$s_addr		= 	$parm[6];				
		$s_postcode	= 	$parm[7];		
		$s_tel		= 	$parm[8];			
		$s_eml		= 	$parm[9];			
		$r_name		= 	$parm[10];			
		$r_addr		= 	$parm[11];				
		$r_postcode	= 	$parm[12];			
		$r_tel		= 	$parm[13];			
		$r_eml		= 	$parm[14];			
		$m_ocomment	= 	$parm[15];
		$modate		=	$parm[16];
		$State		=	$parm[17];
			//print_r($parm);
		if ($State == 2)
			{
				if ($s_name==""){
				  echo "返回信息错误!";
				  exit;
				}else{
				  $sql="select * from web_member where memname = '".$s_name."'";
					$result=mysql_db_query($dbname,$sql);
					$row=mysql_fetch_array($result);
					$agents=$row['Agents'];
					$world=$row['world'];
					$corprator=$row['corprator'];
					$super=$row['super'];
					$admin=$row['Admin'];
				}
				
				
				$sql="select * from sys800 where Order_Code = '".$m_orderid."'";
				$result = mysql_db_query($dbname,$sql);
				$cou=mysql_num_rows($result);
				if ($cou==0){
				    $date=date("Y-m-d");
					$datetime=date("Y-m-d H:i:s");
				    $sql = "insert into sys800 set checked=1,payway='W',gold='$m_oamount',AddDate='$date',type='S',Memname='$s_name',agents='$agents',world='$world',corprator='$corprator',super='$super',Admin='$admin',curtype='RMB',date='$datetime',name='$s_name',user='$s_name',waterno='".$_REQUEST['rb_BankId']."',Order_Code='$m_orderid'";
				    mysql_db_query($dbname,$sql);
				    $sql_amt = "update web_member set Credit=Credit+$m_oamount,Money=Money+$m_oamount  where Memname='$s_name'";
				    mysql_db_query($dbname,$sql_amt);
			        echo "<Script language=javascript>alert('交易成功,请回首页重新登入.');</script>";//window.open('http://ww060.com','_top')
				}
			}
		else 
			{
				echo "支付失败";
				exit;
			}
?>
<?php
	}else{
?>
	失败，信息可能被篡改
<?php
	}
?>
<!--
对于使用dinpay实时反馈接口的商户请注意：
    为了从根本上解决订单支付成功而商户收不到反馈信息的问题(简称掉单).
我公司决定在信息反馈方面实行服务器端对服务器端的反馈方式.即客户支付过后.
我们系统会对商户的网站进行两次支付信息的反馈(即对同一笔订单信息进行两次反馈).
第一次是服务器端对服务器端的反馈.第二次是以页面的形式反馈.两次反馈的时延差在10秒之内.
    请商户那边做好对我们反馈信息的处理. 对我们系统反馈相同的订单信息您那边只
    做一次处理就可以了.以确保消费者的每一笔订单信息在您那边只得到一次相应的服务!!
-->
