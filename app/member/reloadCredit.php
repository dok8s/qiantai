<?

include "./include/library.mem.php";
require ("./include/config.inc.php");
require ("./include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo json_encode($info);
	exit;
}
$row = mysql_fetch_array($result);
$info['info']=number_format($row['Money']);
$info['state']=1;
echo json_encode($info);
exit;
