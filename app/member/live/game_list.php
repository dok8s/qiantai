<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");

$gdate=$_REQUEST['gdate'];
$gtype=$_REQUEST['gtype'];
$langx=$_REQUEST['langx'];
if(empty($gdate)){
	$gdate=date('Y-m-d');
}
if(empty($gtype)){

	$gtype='FT';
}

$mysql = "select * from web_system";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
switch($langx){
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		break;
	case "zh-vn":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		break;
}

$base_url = "".$site."/app/member/live/live.php?uid=$suid&langx=$langx&liveid=$suid";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);

$filename = "".$site."/app/member/live/game_list.php?uid=$suid&langx=$langx&gtype=$gtype&gdate=$gdate";
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$msg  = str_replace($site, '', $msg);
$msg  = str_replace($suid, '', $msg);
$msg  = str_replace('uid=', "uid=$uid", $msg);
$msg  = str_replace('<body', "<body onSelectStart=\"self.event.returnValue=false\" oncontextmenu=\"self.event.returnValue=false;window.event.returnValue=false;\"", $msg);
$msg  = str_replace("window.open('tpl/logout_warn.html','_top')", "", $msg);
$msg  = str_replace("window.open('/tpl/logout_warn.html','_top')", "", $msg);
echo $msg;
mysql_close();
?>