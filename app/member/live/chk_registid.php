<?

include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");

$uid=$_REQUEST['uid'];
$gameary=$_REQUEST['gameary'];
$liveid=$_REQUEST['liveid'];
$regist_id=$_REQUEST['regist_id'];
$gid=$_REQUEST['gid'];
$langx=$_REQUEST['langx'];
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

$base_url = "".$site."/app/member/live/live.php?uid=$suid&langx=$langx&liveid=$liveid";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename = "".$site."/app/member/live/chk_registid.php?uid=$suid&langx=$langx&regist_id=$regist_id&liveid=$liveid&gid=$gid";
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$msg  = str_replace($site, '', $msg);
$msg  = str_replace($suid, '', $msg);
$msg  = str_replace('uid=', "uid=$uid", $msg);
$msg  = str_replace('<body', "<body onSelectStart=\"self.event.returnValue=false\" oncontextmenu=\"self.event.returnValue=false;window.event.returnValue=false;\"", $msg);
$msg  = str_replace("window.open('/tpl/logout_warn.html','_top')", "", $msg);
echo $msg;
mysql_close();
?>