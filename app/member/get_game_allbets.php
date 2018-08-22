<?
header('Content-Type:text/xml');
include "./include/library.mem.php";
require ("./include/config.inc.php");
require ("./include/curl_http.php");
require ("./include/define_function_list.inc.php");

$gid   = $_REQUEST['gid'];
$uid   = $_REQUEST['uid'];
$ltype = $_REQUEST['ltype'];
$langx = $_REQUEST['langx'];
$gtype = $_REQUEST['gtype'];
$showtype = $_REQUEST['showtype'];
$date = $_REQUEST['date'];


$mysql = "select * from web_system";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
switch($langx){
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		$la="en";
		$mima='Plaese input username/passwd and tryagain';
		break;
	case "zh-tw":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		$la="tw";
		$mima='密碼錯誤次數過多';
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		$la="cn";
		$mima='密码错误次数过多';
		break;
}
$base_url = "".$site."/app/member/".$gtype."_index.php?uid=$suid&langx=$langx&mtype=3";
$filename="".$site."/app/member/get_game_allbets.php?uid=$suid&langx=$langx&gtype=$gtype&showtype=$showtype&gid=$gid&ltype=$ltype&date=$date";
$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer($base_url);
echo $meg=$curl->fetch_url($filename);


?>
