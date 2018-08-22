<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");

$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$gameary=$_REQUEST['gameary'];
$liveid=$_REQUEST['liveid'];
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
mysql_close();
$base_url = "http://66.133.87.20/app/member/live/live.php?uid=$suid&langx=$langx&liveid=$liveid";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename = "http://66.133.87.20/app/member/live/getVideoFMS.php?uid=$suid&langx=$langx&gameary=$gameary&liveid=$liveid";
echo $filename;exit;
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$msg  = str_replace($site, '', $msg);
$msg  = str_replace($suid, '', $msg);
$msg  = str_replace('uid=', "uid=$uid", $msg);
$msg  = str_replace('<body', "<body onSelectStart=\"self.event.returnValue=false\" oncontextmenu=\"self.event.returnValue=false;window.event.returnValue=false;\"", $msg);
$msg  = str_replace("window.open('/tpl/logout_warn.html','_top')", "", $msg);
echo $msg;
?>