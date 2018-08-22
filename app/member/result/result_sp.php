<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");



$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$gtype=$_REQUEST['gtype'];  
$gid=$_REQUEST['gid']; 




	  $mysql = "select * from web_system";
		$result = mysql_db_query($dbname,$mysql);
		$row = mysql_fetch_array($result);
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
 		$base_url = "".$site."/app/member/FT_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=$mtype";
		$thisHttp = new cHTTP();
		$thisHttp->setReferer($base_url);
	   $filename="".$site."/app/member/result/result_sp.php?uid=$suid&gtype=$gtype&gid=$gid&langx=$langx";
		
		$thisHttp->getPage($filename);
		echo $msg  = $thisHttp->getContent();
	?>	