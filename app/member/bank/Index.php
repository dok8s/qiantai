<?php
require ("../include/config.inc.php");
include ("../include/login_session.php");
include("function.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
require ("../include/traditional.$langx.inc.php");
mysql_select_db($dbname);
$sql = "select * from web_member where Oid='$uid' and Status<>0";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}

if ($_GET['bankid']=='') { $_GET['bankid']=1; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网银确认</title>
<style>
body {
	font-size: 12px;
	margin: 0;
}
.content, legend {
	border: 1px solid #ccc;
	padding: 5px;
}
</style>
<script src="day.js"></script>
<script>
function trim(str){ //删除左右两端的空格
	return str.replace(/(^\s*)|(\s*$)/g, "");
}
function copyToClipboard(id) 
{ 
var d = trim(document.getElementById(id).innerHTML); 
window.clipboardData.setData('text', d); 
alert("复制成功\r\n\r\n"+d);
}
function toChange(id)
{
	window.location.replace("?bankid="+id+"&uid=<?=($uid)?>&langx=<?=($langx)?>");
}
</script>
</head>
<body>
<?php
	if (!isset($_POST['submit']))
	{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="500" valign="top"><table class="content" width="600" border="0" cellspacing="0" cellpadding="0">
      <form name="form1" id="form1" method="post" action="<?=($_SERVER['PHP_SELF'])?>?uid=<?=($uid)?>&langx=<?=($langx)?>">
        <tr>
          <td><p>a.请您选择存款银行，出现收款代表资料<br />
            b.请至网路银行进行转帐汇款 <br />
            c.转帐汇款完成后，请将资料填入存款金额及汇款资料，汇款资料为汇款人名称及日期<br />
          </p></td>
        </tr>
        <tr>
          <td><fieldset>
            <legend>银行帐户资料</legend>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td>请选择银行：
                  <label>
                    <select name="bankid" id="bankid" onchange="toChange(this.value);">
                      <?php
				  $sql = "select * from `banks`";
				  $query = mysql_query($sql) or die(mysql_error());
				  while ($rs = mysql_fetch_array($query))
				  {
					  if ($_GET['bankid']==$rs['id'])
					  	$select = 'selected="selected"';
					  else
					  	$select = '';
				  ?>
                      <option <?=($select)?> value="<?=($rs['id'])?>">
                        <?=($rs['bankname'])?>
                        </option>
                      <?php
				  }
				  ?>
                    </select>
                  </label></td>
              </tr>
              <tr>
                <td><?php
			  	$sql = "select * from `banks` where `id` = '".$_GET['bankid']."';";
				$query = mysql_query($sql) or die(mysql_error());
				$rs = mysql_fetch_array($query);				
			  ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50%">银行：<strong>
                        <?=($rs['bankname'])?>
                        </strong>
                        <input type="hidden" name="bank" id="bank" value="<?=($rs['bankname'])?>" /></td>
                      <td width="50%">[<a href="<?=($rs['url'])?>" target="_blank">转到网上银行</a>]</td>
                    </tr>
                    <tr>
                      <td width="50%">收款人姓名：<strong><span id="username">
                        <?=($rs['username'])?>
                        </span></strong>
                        <input type="hidden" name="bank_address" id="bank_address" value="<?=($rs['username'])?>" /></td>
                      <td width="50%">[<a href="javascript:void(0);" onclick="copyToClipboard('username');">点击复制收款人姓名</a>]</td>
                    </tr>
                    <tr>
                      <td width="50%">收款帐号：<strong><span id="banknum">
                        <?=($rs['banknum'])?>
                      </span></strong> <input type="hidden" name="bank_account" id="bank_account" value="<?=($rs['banknum'])?>" /></td>
                      <td width="50%">[<a href="javascript:void(0);" onclick="copyToClipboard('banknum');">点击复制收款帐号</a>]</td>
                    </tr>
                    <tr>
                      <td width="50%">开户网点：<strong>
                        <?=($rs['address'])?>
                      </strong></td>
                      <td width="50%"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </fieldset></td>
        </tr>
        <tr>
          <td><fieldset>
            <legend>汇款资料</legend>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td> 汇款金额：
                  <label>
                    <input type="text" name="cash" id="cash" />
                    RMB </label>
                  <br />
                  汇款姓名：
                  <label>
                    <input type="text" name="myname" id="myname" value="<?=($row['Alias'])?>" />
                    <input type="hidden" name="username" id="username" value="<?=($row['Memname'])?>" />
                  </label>
                  <br />
                  汇款日期：
                  <label>
                    <input type="text" onfocus="ShowCalendar('getday');" name="getday" onclick="javascript:ShowCalendar('getday')" id="getday" />
                    <a href="#" onclick="javascript:ShowCalendar('getday')">选择</a> </label>
                  <select name="hour">
                    <?=(hour_option(date("H",time())))?>
                  </select>
                  时
                  <select name="minute">
                    <?=(minute_option(date("i",time())))?>
                  </select>
                  分</td>
              </tr>
            </table>
          </fieldset></td>
        </tr>
        <tr>
          <td><label>
            <input type="submit" name="submit" id="submit" value="提交资料" />
            <input type="reset" name="reset" id="reset" value="重新填写" />
          </label></td>
        </tr>
      </form>
    </table></td>
  </tr>
</table>
<?php
	}
	else
	{
		$cash = trim($_POST['cash']);
		$myname = trim($_POST['myname']);
		$username = trim($_POST['username']);
		$getday = trim($_POST['getday'])." ".$_POST['hour'].":".$_POST['minute'].":00";
		if (!is_numeric($cash))
			echo "<script>alert('汇款金额只能输入数字！');history.back();</script>";
		if ($myname == "" || $_POST['getday'] == "")
			echo "<script>alert('您的名字和汇款日期必须填写完整！');history.back();</script>";
		$sql="select * from web_member where Memname = '".$username."'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$agents=$row['Agents'];
		$world=$row['World'];
		$corprator=$row['Corprator'];
		$super=$row['Super'];
		$admin=$row['Admin'];
		$phone=$row['Phone'];
		$contact=$row['Contact'];
		$notes=$row['Notes'];
		$bank = $_POST['bank'];
		$bank_account=$_POST['bank_account'];
		$bank_address=$_POST['bank_address'];
		$order_code = date("YmdHis",time()).code(5);
		$sql = "insert into `sys800` set checked=0,Payway='N',gold='$cash',AddDate='".date("Y-m-d",time())."',type='S',Memname='$username',agents='$agents',world='$world',corprator='$corprator',super='$super',Admin='$admin',curtype='RMB',date='$getday',name='$myname',waterno='',Bank='$bank',Cancel='0',contact='$contact',notes='$notes',Bank_Account='$bank_account',Bank_Address='$bank_address',phone='$phone',Order_Code='$order_code'";
		mysql_query($sql) or die(mysql_error());
?>
<table width="600" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="center"><img src="mailok2.gif" width="180" height="58" /></td>
  </tr>
  <tr>
    <td align="center"><font color="#999999">您好：您的汇款信息已提交成功,请等待工作人员的审核，并请于10分钟之内查询您的帐户余额。</font><a href="../chbank.php?uid=<?=($uid)?>&langx=<?=($langx)?>">返回继续操作</a></td>
  </tr>
</table>
<?php
	}
?>
</body>
</html>
<?php
mysql_close();
?>