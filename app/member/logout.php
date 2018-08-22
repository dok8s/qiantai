<?
include "./include/library.mem.php";
require ("./include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "update web_member set oid='',logdate=date_add(now(),interval -3 minute) where Oid='$uid' and Oid<>''";
//$result = mysql_db_query($dbname,$sql);
mysql_db_query($dbname,$sql);
echo "<script>window.open('".BROWSER_IP."/app/member/index.php','_top')</script>";
?>
