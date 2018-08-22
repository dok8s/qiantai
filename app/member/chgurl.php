<?
include "./include/library.mem.php";
require ("./include/define_function_list.inc.php");
require ("./include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select Memname,loginName,Money,language,LogDate,credit from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}

$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];
if($mtype==""){
$mtype=3;
}
$chgURL_domain="http://".$_REQUEST['chgURL_domain'];
$ts=date("Y-m-d", $_REQUEST['ts']);
?>
<html>
<head>
<SCRIPT language="JavaScript">
function onLoads(){
var obj = document.getElementById('newdomain');
obj.submit();
}
</SCRIPT><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body onload='onLoads();'>
<form id='newdomain' action='<?=$chgURL_domain?>' method='POST' target='_top' >
<input type='hidden' name='uid' value='<?=$uid?>'><input type='hidden' name='langx' value='<?=$langx?>'><input type='hidden' name='mtype' value='<?=$mtype?>'><input type='hidden' name='today_gmt' value='<?=$ts?>'></form>
</body>
</html>
<?
mysql_close();
?>