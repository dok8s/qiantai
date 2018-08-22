<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];

// 判断用户
$memname=IsMember($uid);

//$langx=$row['language'];
require ("../include/traditional.$langx.inc.php");
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
  <script language="JavaScript" src="/js/lib/util.js"></script>
  <script language="JavaScript" src="/js/conf/<?=$langx?>.js"></script>
  <script src="/js/jquery-3.1.0.min.js"></script>
  <script language="JavaScript" src="/js/account/setEmail.js"></script>

</head>
<script>
</script>
<body id="CHG" onLoad="onLoads();">
<form id="myform" method="post">
  <input type="hidden" name="uid" value="<?=$uid?>">
  <input type="hidden" name="langx" value="<?=$langx?>">
  <div class="acc_leftMain">
    <!--header-->
    <div class="acc_header noFloat"><h1><?=$pass_recovery?></h1></div>

    <!--输入电子邮件-->
    <div class="acc_password_DataMain" id="div_set_email" style="display: none">
      <ul>
        <li>Vui lòng nhập địa chỉ email bạn muốn sử dụng để khôi phục mật khẩu。</li>
      </ul>

      <table cellspacing="0" cellpadding="0" class="acc_maillTB">
        <tr>
          <td>
            <span class="acc_maill_BRspan">Email</span>
            <input id="setEmail" name="setEmail" type="text" placeholder="" class="acc_maill_txt" onKeyDown="key_value(event,'getVerify')"/>
          </td>
        </tr>
        <tr>
          <td id="mail_info" class="FG_errG_top">
            <div class="acc_err_info"><font id="mail_info_msg">ERR</font></div>
          </td>
        </tr>
        <tr>
          <td class="acc_mailBTN">
            <span class="acc_passCancelBTN" onClick="do_cancel('1');">Hủy bỏ</span>
            <span class="acc_passSubmitBTN" onClick="do_submit('getVerify','setEmail');">Bước tiếp</span>
          </td>
        </tr>
      </table>
    </div>

    <!--输入验证码-->
    <div class="acc_password_DataMain" id="div_set_verify" style="display: none">
      <!-- <ul>
          <li>验证码已发送到您的电子邮件</li>
      </ul> -->

      <table cellspacing="0" cellpadding="0" class="acc_codeTBt0">
        <tr>
          <td>
            <span id="myEmail"></span><span class="acc_changeBTN" onClick="changeDiv('div_set_email');">更改</span>
          </td>
        </tr>
        <tr>
          <td class="acc_codeTD">
            <span class="acc_maill_BRspan">Vui lòng nhập mã xác minh tại đây</span>
            <div>
              <input id="myVerify" name="myVerify" type="text" class="acc_code_txt" style="text-transform:uppercase" onKeyDown="key_value(event,'chkVerify')"/>
              <span class="acc_codeBTN" onClick="do_submit('getVerify','myEmail');">Tạo mã xác minh</span>
            </div>
          </td>
        </tr>
        <tr>
          <td id="err_info" class="acc_mailBTN" style="display:none;">
            <div class="acc_err_info"><font id="hr_info">Vui lòng nhập mật khẩu hiện tại của bạn.</font></div>
          </td>
        </tr>
        <tr>
          <td class="acc_codeTD">
            <span class="acc_passCancelBTN" onClick="do_cancel('2');">Hủy bỏ</span>
            <span class="acc_passSubmitBTN" onClick="do_submit('chkVerify');">Gửi</span>
          </td>
        </tr>
      </table>
    </div>

    <!--密码恢复完成-->
    <div class="acc_password_DataMain" id="div_set_done" style="display: none">
      <ul>
        <li>Email khôi phục mật khẩu</li>
      </ul>

      <table cellspacing="0" cellpadding="0" class="acc_codeTB">
        <tr>
          <td>
            <span id="Email_done"></span><span class="acc_changeBTN" onClick="changeDiv('div_set_email');">Thay đổi</span><span class="acc_changeBTNC" onClick="do_submit('remove');">Xóa</span>
          </td>
        </tr>
        <tr>
          <td class="acc_mailBTN">Khi bạn sử dụng tính năng 'Quên mật khẩu', mã xác minh sẽ được gửi đến email này</td>
        </tr>
      </table>
    </div>

    <!--删除电子邮件-->
    <div class="acc_password_DataMainL" id="div_rm_done" style="display: none">
      <ul>
        <li>Email khôi phục mật khẩu đã bị xóa</li>
      </ul>
      <table cellspacing="0" cellpadding="0" class="acc_codeTB">
        <tr>
          <td class="txtC">
            <span id=""></span><span id="new_mail" class="acc_changeBTNC" onClick="changeDiv('div_set_email');">Tăng</span>
          </td>
        </tr>
      </table>
    </div>
  </div>
</form>
</body>
</html>
