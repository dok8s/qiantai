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
		echo "<script>alert('�n���b�����Q�ϥ�');</script>";
		exit;
	}else{
		echo "<script>alert('�n���b���w�g�Q�ϥΡA�п�J�䥦�b��');</script>";
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
		echo "<script>alert('�ѳɹ��޸ĵ�¼�ʺ�~~������µ���');top.location.href='./logout.php?uid=$uid&langx=$langx';</script>";
		exit;
	}
	else{
		echo "<script>alert('��¼�ʺ��ѱ�ʹ��');history.go(-1);</script>";
		exit;
	}
}
?>
<html>
<head>
<title>�ܧ�K�X</title>
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
			  		<td width="400" class="pwd_title">�]�m�n���b��</td>
					<td width="100" class="point" style="cursor:hand;" onClick="javascript:window.open('/tpl/member/zh-tw/guide.html');" >�]�m����</td>
			  	</tr>
		 	</table>
	 	</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
			�ШϥλդU�e���O�o���W�r�ΥN���]�w<font class="red_txt">�u�n���b���v</font>�H�ѷ|���ݵn�J�ϥΡC
		</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
			�]�m�W�h : ������2�ӭ^��j�p�g�r���M�Ʀr(0~9)�զX��J����(6~12�r��)
			<br>�ҡGoicq888 , england228 , tudou668 , soccer2009 , 888yahoo��...²�����W�r�ΥN���A�ҥi�̷ӱz�ҳߦn�]�m�C

		</td>
	</tr>	
	<form name="ChgPwdForm" method="post">
		<tr>		
			<td width="100"align="right"   class="pwd_txt" >�n���b��</td>
			<td width="350"class="pwd_txt">
				<input type="TEXT" name="password_safe" value="" size=12 maxlength=12 class="za_text_02">
				<input type="button" name="check" id='check' value="�ˬd" class="za_button" onclick='ChkMem();'>
				<font class="red_txt">�`�N�G</font>�]�m��N�L�k�ק�C
			</td>
		</tr>
		<tr >
			<td colspan="2" align="center"  class="pwd_bg">
				<input type="button" value="�T�{" onClick="return SubChk();" class="za_button_01">&nbsp;
				<input type="button" name="cancel" value="����" class="za_button_01" onClick="javascript:top.location.href='./logout.php?uid=<?=$uid?>&langx=<?=$langx?>';">
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
			<ul><li>�p�դU���u�n���b���v�]�m������<font class="red_txt">���H�u�n���b���v�n�J�|���ݡA</font><BR>��u�|���b���v�����ѧO�����ϥΡA���i�n�J�C</li></ul>
		</td>
	</tr>
</table>
<iframe id="getData"></iframe>
</body>
</html>