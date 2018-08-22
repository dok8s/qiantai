
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript">
var langx ='zh-tw'
</script>
<meta name="Robots" contect="none">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="../../../style/member/reset.css" rel="stylesheet" type="text/css">
<link href="../../../style/member/my_account.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../../../style/member/mem_pass.css" type="text/css">
<link href="../../../style/member/mem_pass.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
iframe { width:0; height:0; border:0; clear:right;}
-->
</style>
</head>
<script language="JavaScript" src="/js/zh-cn.js" type="text/javascript"></script>
<script language="JavaScript" src="/js/forgot_pwd.js" type="text/javascript"></script>
<script language="JavaScript" src="/js/HttpRequest.js" type="text/javascript"></script>
<script>
var langx='zh-cn';
</script>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" id="PWD" onLoad="onLoads();">
<div class="for_main">
<h1><span class="chg_left">Khôi phục mật khẩu</span></h1>

<!--帐号密码+邮件-->
<div class="main_bg for_email" id="div_set_email" style="display:none;">
              <table border="0" cellpadding="0" cellspacing="0" class="main_bg_w">
                <tr>
                     <td class="chgtext_box" colspan="2">
                       <div class="for_chtext_1"><span class="red">Lưu ý: </ span> Bạn phải đăng ký khôi phục mật khẩu để sử dụng tính năng này. & nbsp; & nbsp; Nếu bạn chưa đăng ký email, vui lòng liên hệ trực tuyến của bạn.</div>
                       <div class="for_chtext_2">Vui lòng nhập thông tin bên dưới và chúng tôi sẽ giúp bạn đặt lại mật khẩu của mình.</div>
                     </td>
                </tr>
		<tr>		
			<td>
                Tài khoản &nbsp;&nbsp; hoặc &nbsp;&nbsp; Đăng nhập vào
            <div class="for_pad"><input type="TEXT" id="username" class="for_input" onKeyDown="key_value(event,'getVerify')"></div>
            </td>
		</tr>
		<tr>		
			<td>
                Email
            <div class="for_pad"><input type="TEXT" id="setEmail" class="for_input" onKeyDown="key_value(event,'getVerify')"></div>
            </td>
		</tr>
        <tr>
        <td><div id="err_info" class="for_err_info" style="display:none;"><font id="msg_err">Tài khoản hoặc thông tin đăng nhập bạn đã nhập không khớp với email. Vui lòng thử lại.</font></div>
        </tr>
</table>

<div class="foot">
      <input type="button" name="cancel" value="Hủy bỏ" onClick="do_cancel('2');" class="chg_no">
	  <input type="button" value="Bước tiếp theo" onClick="do_submit('getVerify');" class="chg_yes">
</div>

</div>

<!--输入验证码-->
<div class="main_bg verify_h" id="div_set_verify" style="display:;">
              <table border="0" cellpadding="0" cellspacing="0" class="main_bg_w">
                <tr>
                     <td class="chgtext_box" colspan="2">
                       <div class="chtext_1">Vui lòng nhập mã xác minh</div>
                     </td>
                </tr>
		<tr>		
			<td class="keyin">
            <input type="TEXT" id="myVerify" name="myVerify" class="for_m_btn_txt" style="text-transform:uppercase" onKeyDown="key_value(event,'chkVerify')">
            <input type="button" id="check" name="check" value="Tạo mã xác minh" onClick="do_submit('getVerify');" class="for_m_btn">
            </td>
		</tr>
        <tr>
        <td><div id="verify_show_info" class="err_info_ID" style="display:none;"><font id="verify_info">Mã xác minh bạn đã nhập không đúng. Vui lòng thử lại.</font></div>
        </tr>
</table>

<div class="foot">
      <input type="button" name="cancel" value="Hủy bỏ" onClick="do_cancel();" class="chg_no">
	  <input type="button" value="Gửi" onClick="do_submit('chkVerify');"  class="chg_yes">
</div>

</div>


<!--新密码-->
<div class="main_bg" id="div_set_pwd" style="display:none;">
              <table border="0" cellpadding="0" cellspacing="0" class="main_bg_w">
                <tr>
                     <td class="chgtext_box" colspan="2">
                       <div class="for_chtext_2">Vui lòng nhập mật khẩu mới</div>
                     </td>
                </tr>
		<tr>		
			<td>
                Mật khẩu
            <div class="for_pad"><input type="password" id="passwd" name="passwd" value="" size=12 maxlength=12 class="for_input" onKeyDown="key_value(event,'setPwd')"></div>
            </td>
		</tr>
		<tr>		
			<td>
                Xác nhận mật khẩu
            <div class="for_pad"><input type="password" id="pwd_chk" name="pwd_chk" value="" size=12 maxlength=12 class="for_input" onKeyDown="key_value(event,'setPwd')"></div>
            </td>
		</tr>
        <tr>
        <td><div id="pwd_show_info" class="for_err_info" style="display:none;"><font id="pwd_info">Vui lòng nhập mật khẩu mới</font></div>
        </tr>
</table>

<div class="foot">
      <input type="button" name="cancel" value="Hủy bỏ" onClick="do_cancel();" class="chg_no">
	  <input type="button" value="Gửi" onClick="do_submit('setPwd');"  class="chg_yes">
</div>

</div>

<!--成功讯息-->
    <div class="main_bg for_succ" id="div_set_done" style="display: none">
        <div class="for_chtext_3">Mật khẩu đã thay đổi thành công <br> Vui lòng đăng nhập bằng mật khẩu mới</div>
        <input id="to_login" type="button" value="Tiếp tục đăng nhập" onClick="do_cancel('2');"  class="chg_yes">
    </div>

<iframe id="getData" style="height:0px;"></iframe>

</div>
</body>
</html>
