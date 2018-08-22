<?
include "./include/library.mem.php";
require ("./include/define_function_list.inc.php");
require ("./include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$loginName=$_REQUEST['password_safe'];
$chkname=$_REQUEST['chkname'];
if($chkname!=''){
	if (chkLoginName($chkname)){
		echo "<script>alert('登錄帳號未被使用');</script>";
		exit;
	}else{
		echo "<script>alert('登錄帳號已經被使用，請輸入其它帳號');</script>";
		exit;
	}
}
function chkLoginName($data){
	global $dbname;
	$sql = "select * from `web_member` where Memname='$data' or loginName='$data' ";

	$result = mysql_db_query($dbname,$sql);
	$count=mysql_num_rows($result);

	if ($count==0){
		return true;
	}else{
		return false;
	}
}
if($loginName!=''){
	if (chkLoginName($loginName)){
		$sql="update `web_member` set loginName='$loginName' where Oid='$uid'";
		mysql_db_query($dbname,$sql) or die (mysql_error());
		echo "<script>alert('眒傖髡党蜊腎翹梛瘍~~③隙笭陔腎��');top.location.href='./logout.php?uid=$uid&langx=$langx';</script>";
		exit;
	}
	else{
		echo "<script>alert('腎翹梛瘍眒掩妏蚚');history.go(-1);</script>";
		exit;
	}
}
?>
<html>
<head>
<title>變更密碼</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<link rel="stylesheet" href="/style/member/mem_order.css" type="text/css">
<style type="text/css">
<!--
iframe { width:0; height:0; border:0; clear:right;}
-->
</style>
</head>
<script language="JavaScript" src="/js/zh-tw.js" type="text/javascript"></script>
<script language="JavaScript" src="/js/chg_long_id.js" type="text/javascript"></script>
<script>
var passwd = "aaaaaa";
var langx='zh-tw';
</script>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" id="PWD">
<table width="450" border="0" align="center" cellpadding="1" cellspacing="1" class="pwd_side">
	<tr class="pwd_bg">
		<td colspan="2">
			<table border="0" cellpadding="1" cellspacing="1">
			  	<tr>
			  		<td width="400" class="pwd_title">設置登錄帳號</td>
					<td width="100" class="point" style="cursor:hand;" onClick="javascript:window.open('/tpl/member/zh-tw/guide.html');" >設置指引</td>
			  	</tr>
		 	</table>
	 	</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
			請使用閣下容易記得的名字或代號設定<font class="red_txt">「登錄帳號」</font>以供會員端登入使用。
		</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
			設置規則 : 必須有2個英文大小寫字母和數字(0~9)組合輸入限制(6~12字元)
			<br>例：oicq888 , england228 , tudou668 , soccer2009 , 888yahoo等...簡易的名字或代號，皆可依照您所喜好設置。

		</td>
	</tr>	
	<form name="ChgPwdForm" method="post">
		<tr>		
			<td width="100"align="right"   class="pwd_txt" >登錄帳號</td>
			<td width="350"class="pwd_txt">
				<input type="TEXT" name="password_safe" value="" size=12 maxlength=12 class="za_text_02">
				<input type="button" name="check" id='check' value="檢查" class="za_button" onclick='ChkMem();'>
				<font class="red_txt">注意：</font>設置後將無法修改。
			</td>
		</tr>
		<tr >
			<td colspan="2" align="center"  class="pwd_bg">
				<input type="button" value="確認" onClick="return SubChk();" class="za_button_01">&nbsp;
				<input type="button" name="cancel" value="取消" class="za_button_01" onClick="javascript:top.location.href='./logout.php?uid=<?=$uid?>&langx=<?=$langx?>';">
				<input type="hidden" name="uid" value="<?=$_REQUEST['uid']?>">
				<input type="hidden" name="action" value="1">
				<input type="hidden" name="username" value="agc01">
				<input type="hidden" name="password" value="qwe123">
			</td>
		</tr>
	</form>
</table>
<table align="center">
	<tr >
		<td class="white">
			<ul><li>如閣下的「登錄帳號」設置完成後<font class="red_txt">須以「登錄帳號」登入會員端，</font><BR>原「會員帳號」隻供識別身份使用，不可登入。</li></ul>
		</td>
	</tr>
</table>
<iframe id="getData"></iframe>
</body>
</html>