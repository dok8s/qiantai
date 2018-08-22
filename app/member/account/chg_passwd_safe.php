<?php

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$action = !empty($_REQUEST['action'])?$_REQUEST['action']:0;
$password_safe = !empty($_REQUEST['password_safe'])?$_REQUEST['password_safe']:'';
$username	=	$_REQUEST['username'];
$password	=	$_REQUEST['password'];
$langx		=	$_REQUEST['langx'];

if($action==1){
	
	$sql = "select id from `web_member` where memname='$username' and passwd = '$password'";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		show_error("Mật khẩu không chính xác, vui lòng nhập lại");
		exit;
	}
	$sql = "select id from `web_member` where memname='$password_safe' or loginname='$password_safe'";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		$sql="update `web_member` set loginname='$password_safe' where memname='$username' and passwd = '$password'";
		mysql_query($sql);
		
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		echo "<script>alert('Đã sửa đổi thành công tài khoản đăng nhập ~~ Vui lòng đăng nhập lại');self.location='/app/member/index.php';</script>";
	}else{
		show_error("    Tài khoản đăng nhập bạn đã nhập $password_safe Đã được sử dụng, vui lòng quay lại trang trước và nhập lại!!");
	}
	exit;
}

function show_error($errstring){
	echo '
<html>
<head>
<title>error</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
<!--
body { text-align:center; background-color:#535E63;}
div { width:230px; font:12px Arial, Helvetica, sans-serif; border:1px solid #333; margin:auto;}
p { color:#C00; background-color:#CCC; margin:0; padding:15px 6px;}
h1 { font-size:1.2em; margin:0; padding:4px; background-color:#000; color:#FFF;letter-spacing: 0.5em;}
span { display:block; background-color:#A0A0A0; padding:4px; margin:0;}
a:link, a:visited {  color: #FFF; text-decoration: none;}
a:hover {  color: #FF0}
-->
</style>
</head>
<body>

<div>
  <h1>Thông báo lỗi</h1>
  <p>'.$errstring.'</p>

  <span><a href="javascript:history.go(-1)">&raquo; Quay lại trang trước</a></span>  
</div>

</body>
</html>
';
}
?>

<html>
<head>
<title>Thiết lập tài khoản đăng nhập</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
var passwd = '<?=$password?>';
var langx='zh-tw';
</script>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" id="PWD">
<table width="450" border="0" align="center" cellpadding="1" cellspacing="1" class="pwd_side">
	<tr class="pwd_bg">
		<td colspan="2">
			<table border="0" cellpadding="1" cellspacing="1">
			  	<tr>
			  		<td width="400" class="pwd_title">Thiết lập tài khoản đăng nhập</td>
					<td width="100" class="point" style="cursor:hand;" onClick="javascript:window.open('/tpl/member/zh-tw/guide.html');" >Hướng dẫn thiết lập</td>
			  	</tr>
		 	</table>
	 	</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
            Vui lòng sử dụng tên hoặc bộ mã mà bạn có thể dễ dàng nhớ.<font class="red_txt">「Đăng nhập tài khoản」</font>Để đăng nhập thành viên
		</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
            Quy tắc cài đặt: Phải có 2 chữ hoa và chữ thường và chữ số (0 ~ 9) giới hạn nhập vào kết hợp (6 ~ 12 ký tự)
			<br>Ví dụ: oicq888, england228, tudou668, soccer2009, 888yahoo, v.v ... Tên hoặc mã đơn giản có thể được đặt theo sở thích của bạn.

		</td>
	</tr>	
	<form name="ChgPwdForm" method="post">
		<tr>		
			<td width="100"align="right"   class="pwd_txt" >Đăng nhập tài khoản</td>
			<td width="350"class="pwd_txt">
				<input type="TEXT" name="password_safe" value="" size=12 maxlength=12 class="za_text_02">
				<input type="button" name="check" id='check' value="Kiểm tra" class="za_button" onclick='ChkMem();'>
				<font class="red_txt">Lưu ý: </ font> sẽ không bị sửa đổi sau khi cài đặt.
			</td>
		</tr>
		<tr >
			<td colspan="2" align="center"  class="pwd_bg">
				<input type="button" value="Xác nhận" onClick="return SubChk();" class="za_button_01">&nbsp;
				<input type="button" name="cancel" value="Hủy bỏ" class="za_button_01" onClick="javascript:history.go(-2);">
				<input type="hidden" name="action" value="1">
				<input type="hidden" name="uid" value="<?=$uid?>">
				<input type="hidden" name="username" value="<?=$username?>">
				<input type="hidden" name="password" value="<?=$password?>">
			</td>
		</tr>
	</form>
</table>
<table align="center">
	<tr >
		<td class="white">
			<ul><li>Nếu cài đặt "Đăng nhập tài khoản" của bạn hoàn tất, <font class = "red_txt"> bạn phải đăng nhập vào thành viên bằng "Đăng nhập tài khoản". </ Font> <BR> Tài khoản thành viên ban đầu chỉ dành cho mục đích nhận dạng và không thể đăng nhập được.</li></ul>
		</td>
	</tr>
</table>
<iframe id="getData"></iframe>
</body>
</html>
