<?

require ("../include/config.inc.php");

$uid=$_REQUEST['uid'];
$sql = "select id,memname,status from web_member where oid='$uid' and Status<>0";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	exit;
}
$row = mysql_fetch_array($result);

$action = $_REQUEST['action'];
$chatid = intval($_REQUEST['chatid']);
$message = str_replace(array('<','>'),array('&lt;','&gt;'),$_REQUEST['message']);

$onlocal="thisClose();";

if($action=='send'){
	mysql_query("UPDATE web_chat SET state='1' WHERE id='$chatid'");
	if($message!='isread' && $message!=''){
		$to_id = 199999999;
		$to_name = 'sys';
		$from_id = intval($row['id']);
		$from_name = $row['memname'];
		if($from_id<1){exit;}
		$time = date("Y-m-d H:i:s");
		mysql_query("insert into web_chat (from_id,to_id,from_name,to_name,message,state,time) values ('$from_id','$to_id','$from_name','$to_name','$message','0','$time')" );
		$message = "send ok";
	}
}
else{

	$id = intval($row['id']);
	$sql = "SELECT id,message,state,time FROM web_chat WHERE to_id='$id' and state='0' ORDER BY id ASC LIMIT 0,1";
	$result = mysql_query($sql);
	$rt = mysql_fetch_array($result);
	if(!isset($rt['message'])){
		$message = "not msg";
	}else{
		//mysql_query("UPDATE web_chat SET state='1' WHERE id='$rt[id]'");
		$chatid = $rt['id'];
		$message = "$rt[message]";
		$onlocal = "thisOpen();";
	}
}
?>

<html>
<head>
<title>会话</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
body,div,td {FONT-SIZE: 12px; word-break:break-all;}
.closeimg{cursor:hand;}
.close{
	cursor:hand;
	padding: 3px;
	color:#0000FF;
	onmouseover:expression(
		onmouseover=function(){
			this.style.color='#FFFFFF';
			this.style.backgroundColor='#CC0000';
		}
	);
	onmouseout:expression(
		onmouseout=function(){
			this.style.color='#0000FF';
			this.style.backgroundColor='';
		}
	);
</style>

<script>

function thisClose(){
	parent.refresh='yes';
	var divChat = parent.document.getElementById('chat');
	divChat.style.display="none";
}
function thisOpen(){
	parent.refresh='no';
	var divChat = parent.document.getElementById('chat');
	divChat.style.display="";
}
function isread(){
	if(form1.message.value==''){
		form1.message.value='isread';
	}
	form1.submit();
}
function send_chk(){
	if(form1.message.value==''){
		form1.message.focus();
		alert('内容不要为空');
		return false;
	}
	thisClose();
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >

<table width="580" border="0" cellpadding="3" cellspacing="0">
 <form id="form1" name="form1" method="post" action="" onSubmit="return send_chk();">
 <INPUT TYPE="hidden" NAME="action" value="send">
 <INPUT TYPE="hidden" NAME="chatid" value="<?=$chatid?>">
  <tr>
    <td width="522" height="50"><?=$message?></td>
    <td width="42" align="right" valign="top"><img class="closeimg" onClick="isread();" src="/images/close.jpg" width="16" height="16" alt="关闭"></td>
  </tr>
  <tr>
    <td height="25"  bgcolor="#EEDC9E">回复内容：<input name="message" type="text" size="70" style="border: 1px solid #333333;">    </td>
    <td height="25"  bgcolor="#EEDC9E"><input type="submit" name="Submit" value="发送"></td>
  </tr>
  </form>
</table>
</body></html>
<script> <?=$onlocal?> </script>