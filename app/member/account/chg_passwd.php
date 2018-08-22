<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
require ("../include/traditional.$langx.inc.php");
$flag = !empty($_REQUEST['flag'])?$_REQUEST['flag']:0;
$action = !empty($_REQUEST['action'])?$_REQUEST['action']:0;

// 判断用户
$memname=IsMember($uid);

$mysql="Select language,Passwd from web_member where Oid='$uid' and Oid<>''";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$agpawd=$row['Passwd'];

if($langx=='zh-vn') {
	$lan = 'zh-vn';

}
if($langx=='zh-cn') {
	$lan = 'zh-cn';
}
if($langx=='en-us') {
	$lan = 'en-us';
	$css = '_en';
}
if ($action==1) {
	$pasd = strtolower($_REQUEST["password"]);
	$chg_date = date('Y-m-d H:i:s');
	$mysql = "update web_member set Passwd='$pasd',Active='2008-02-01 12:00:00',logdate='2008-02-01 12:00:00',lastpawd='$chg_date',Oid='' where Oid='$uid' and Oid<>''";
	mysql_query($mysql) or die ($pwno);
	if ($flag == 3) {
		$url = BROWSER_IP . "/app/member/chk_rule.php?mtype=3&uid=$uid&langx=$langx";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
		<script language=javascript>
		alert('" . $pwok . "');
		top." . CASINO . "_mem_index.location = '" . $url . "';</script>";
	} else {
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
		echo "<Script language=javascript>alert('" . $biang . "');</script>";
		echo "<script>top.location='/index.php';self.window.close();</script>";
		exit;
	}
	exit;
}else {
	if ($flag == 3) {
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
	<script>
	alert('" . $henjiu . "');
	</script>";
	}
}
mysql_close();
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
	<script language="JavaScript" src="/js/account/chg_passwd.js"></script>
</head>
<script>
var pass = "<?=$agpawd?>";
</script>
<body id="CHG" onLoad="onLoads();">
	<form id="myform" method=post onSubmit="return SubChk();" target="chg_pwd">
		<input type="hidden" name="msg" value="">
		<input type="hidden" name="action" value="1">
		<input type="hidden" name="uid" value="">
		<input type="hidden" name="flag" value="1">
		<input type="hidden" name="langx" value="zh-cn">
	<div class="acc_leftMain">
		<!--header-->
		<div class="acc_header noFloat"><h1><?=$passw?></h1></div>

        <!--main-->
        <div class="acc_password_DataMain" id="chg_pwd_main" style="display:;">
        	<ul>
            	<li><?=$tishi?></li>
                <li><?=$shuom?></li>
                <li>1. <?=$shuom1?></li>
                <li class="acc_lastli">2. <?=$shuom2?></li>
            </ul>

            <table cellspacing="0" cellpadding="0" class="acc_passwordTB">
              <tr>
                <td><?=$account_pasd?></td>
                <td><input id="oldpassword" name="oldpassword" type="password" class="acc_password_txt"/></td>
              </tr>
              <tr>
                <td><?=$account_caption?></td>
                <td><input id="password" name="password" type="password" class="acc_password_txt"/></td>
              </tr>
              <tr>
                <td><?=$account_repasd?></td>
                <td><input id="REpassword" name="REpassword" type="password" class="acc_password_txt"/></td>
              </tr>
               <tr>
              <td colspan="2" id="err_info" style="display:none;">
              <div class="acc_err_info"><font id="hr_info"><?=$account_q?></font></div>
              </td>
              </tr>
              <tr>
              <td colspan="2">
              	<span class="acc_passCancelBTN" onClick="do_cancel('1');"><?=$acc_cancle?></span>
              	<span class="acc_passSubmitBTN" onClick="do_submit();"><?=$tijiao?></span>
              </td>
              </tr>
            </table>
			<input type=submit id="OK" name="OK" style="display:none">
        </div>

      <!-- 密码恢复 -->
      <div class="acc_password_forMain" id="SetMyEmail" style="display:none;">
        <ul>
          <li class="big_title">Khôi phục mật khẩu hiện khả dụng</li>
          <li>Vui lòng đăng ký email của bạn để sử dụng tính năng Quên mật khẩu.</li>
        </ul>

          <div class="acc_fgBTNG noFloat">
            <span class="acc_passCancelBTN" onClick="do_cancel('1');"><?=$Likai?></span>
            <span id="go_setEmail" class="acc_passSubmitBTN" onClick="parent.order.linkEvent('set_email');">Đăng ký ngay</span>
          </div>

      </div>

	</div>
	</form>
	<iframe id="chg_pwd" name="chg_pwd" scrolling="NO" frameborder="NO" border="0" width="200" height="0" allowtransparency="true" style="display: none;"></iframe>
</body>
</html>
