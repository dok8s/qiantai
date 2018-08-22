<?php
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$flag=$_REQUEST["flag"];
$mtype=$_REQUEST['mtype'];
require ("../include/traditional.$langx.inc.php");


$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
		echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{

	$row = mysql_fetch_array($result);
	$memname=$row['Memname'];
	$credit=$row['Credit'];
	$page='chg_passwd.php?uid='.$uid;

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
		<script src="/js/conf/zh-cn.js"></script>
		<script src="/js/account/mem_conf.js?t=2"></script>
		<SCRIPT>
var dataAry = new Object();
var dataAry = new Object();
dataAry['FT']=new Object();
dataAry['FT']['R']='R|<?=$row["FT_R_Scene"]?>|<?=$row["FT_R_Bet"]?>|none';
dataAry['FT']['RE']='RE|<?=$row["FT_RE_Scene"]?>|<?=$row["FT_RE_Bet"]?>|none';
dataAry['FT']['M']='M|<?=$row["FT_M_Scene"]?>|<?=$row["FT_M_Bet"]?>|none';
dataAry['FT']['DT']='DT|<?=$row["FT_PC_Scene"]?>|<?=$row['FT_PC_Bet']?>|none';
dataAry['FT']['RDT']='RDT|<?=$row["FT_PC_Scene"]?>|<?=$row["FT_PC_Bet"]?>|none';
dataAry['BK']=new Object();
dataAry['BK']['R']='R|<?=$row["BK_R_Scene"]?>|<?=$row["BK_R_Bet"]?>|none';
dataAry['BK']['RE']='RE|<?=$row["BK_RE_Scene"]?>|<?=$row["BK_RE_Bet"]?>|none';
dataAry['BK']['M']='M|<?=$row["BK_PC_Scene"]?>|<?=$row["BK_PC_Bet"]?>|none';
dataAry['BK']['DT']='DT|<?=$row["BK_PC_Scene"]?>|<?=$row["BK_PC_Bet"]?>|none';
dataAry['OP']=new Object();
dataAry['OP']['R']='R|<?=$row["OP_R_Scene"]?>|<?=$row["OP_R_Bet"]?>|none';
dataAry['OP']['RE']='RE|<?=$row["OP_RE_Scene"]?>|<?=$row["OP_RE_Bet"]?>|none';
dataAry['OP']['M']='M|<?=$row["OP_M_Scene"]?>|<?=$row["OP_M_Bet"]?>|none';
dataAry['OP']['DT']='DT|<?=$row["OP_PC_Scene"]?>|<?=$row["OP_PC_Bet"]?>|none';
dataAry['FS']=new Object();
dataAry['FS']['FS']='FS|<?=$row['FS_R_Scene']?>|<?=$row['FS_R_Bet']?>|none';
</SCRIPT>
</head>

<body onLoad="init();">	
	<div class="acc_leftMain">
		<!--header-->
		<div class="acc_header noFloat"><h1>Cài đặt chi tiết</h1></div>
        
        <!--main-->
        <div class="acc_set_DataMain">
        <div class="acc_set_header"><ul>
        	<li id="title_FT" onClick="chgGtype('FT');" class="on">Bóng đá</li>
        	<li id="title_BK" onClick="chgGtype('BK');">Bóng rổ</li>
        	<li id="title_OP" onClick="chgGtype('OP');">Bóng tích hợp</li>
        	<li id="title_FS" onClick="chgGtype('FS');">Quán quân</li></ul>
        </div>
        	
        	
        	
				<div id="div_FT" style="display:none">
					<xmp>
		        	<table cellspacing="0" cellpadding="0" class="acc_setTB">
		              <tr>
		                <th>Loại cược</th>
		                <th>Duy nhất cao</th>
		                <th>Ghi chú duy</th>
		              </tr>
		              
		              *CONTENT*
		
		          </table>
          </xmp> 
        </div>    
        
        
        
        <div id="div_BK" style="display:none">    
          <xmp>
		          <table cellspacing="0" cellpadding="0" class="acc_setTB">
		              <tr>
                          <th>Loại cược</th>
                          <th>Duy nhất cao</th>
                          <th>Ghi chú duy</th>
		              </tr>
		              
		              *CONTENT*
		          </table>  
          </xmp>   
        </div>  
          
          
          
          
          
        <div id="div_OP" style="display:none">  
         	<xmp>
	          <table cellspacing="0" cellpadding="0" class="acc_setTB">
	              <tr>
                      <th>Loại cược</th>
                      <th>Duy nhất cao</th>
                      <th>Ghi chú duy</th>
	              </tr>
	              
	             	*CONTENT*
	          </table>
         	</xmp> 
         </div>
         
         
         
        <div id="div_FS" style="display:none">  
        	<xmp>   
	          <table cellspacing="0" cellpadding="0" class="acc_setTB">
		            <tr>
                        <th>Loại cược</th>
                        <th>Duy nhất cao</th>
                        <th>Ghi chú duy</th>
		            </tr>
	          	 	*CONTENT*
	          </table>  
         	</xmp> 
         </div>
            
          
          
          <div id="model_tr" name="model_tr" style="display: none">
							<xmp>
						      <tr>
						        <td class="Word_Paddleft">*TYPE*</td>
						        <td>*S_MATCH*</td>
						        <td class="no_line">*S_BET*</td>
						      </tr>
						  </xmp>
					</div>
							  

        </div>

	</div>        
</body>
</html>
<?
//userlog($memname);
}
?>
