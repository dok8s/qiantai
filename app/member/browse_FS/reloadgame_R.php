<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$rtype=$_REQUEST['rtype'];
$league_id=$_REQUEST['league_id'];
$area_id=$_REQUEST['area_id'];
$FStype=$_REQUEST['FStype'];
$langx=$_REQUEST['langx'];
$records=$_REQUEST['records'];
$pages=$_REQUEST['pages'];
$LegGame=$_REQUEST['LegGame'];
$choice=$_REQUEST['choice'];

if($rtype==''){$rtype='fs';}

$mysql = "select * from web_system";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	$mDate=date('m-d');
	switch($langx){
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		break;
	case "zh-tw":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		break;
	}
$base_url = "".$site."/app/member/browse_FS/loadgame_R.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename="".$site."/app/member/browse_FS/reloadgame_R.php?uid=$suid&langx=$langx&choice=$choice&LegGame=$LegGame&pages=$pages&records=$records&FStype=$FStype&area_id=$area_id&league_id=$league_id&rtype=".$rtype;
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
echo $msg;
?>