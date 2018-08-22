<?

include "../include/library.mem.php";
include "./class.Chinese.php";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");


$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$mtype=$_REQUEST['mtype'];
$gtype=$_REQUEST['gtype'];
$gid=$_REQUEST['game_id'];  
$list_date=$_REQUEST['list_date'];


  require ("../include/traditional.$langx.inc.php");

  if ($list_date==""){
  	$today=$_REQUEST['today'];
  	if (empty($today)){
  		$today 					= 	date("Y-m-d");
  		$tomorrow 			=		"";
  		$lastday 				= 	date("Y-m-d",mktime (0,0,0,date("m"),date("d")-1,date("Y")));
  	}else{
  		$date_list_1		=		explode("-",$today);
  		$d1							=		mktime(0,0,0,$date_list_1[1],$date_list_1[2],$date_list_1[0]);
  		$tomorrow				=		date('Y-m-d',$d1+24*60*60);
  		$lastday				=		date('Y-m-d',$d1-24*60*60);

  		if ($today>=date('Y-m-d')){
  			$tomorrow='';
  		}
  	}
  	$list_date=$today;
  }else{
  	$today = $list_date;
  	$date_list=mktime(0,0,0,substr($list_date,5,2),substr($list_date,8,2),substr($list_date,0,4));
  	$tomorrow = date("Y-m-d",mktime (0,0,0,date("m",$date_list),date("d",$date_list)+1,date("Y",$date_list)));
  	$lastday  = date("Y-m-d",mktime (0,0,0,date("m",$date_list),date("d",$date_list)-1,date("Y",$date_list)));
  	if (strcmp($tomorrow,date("Y-m-d"))>0){
  		$tomorrow="";
  	}
  }



  $date_search=$yesterday.$tomorrow;
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
		$filename="".$site."/app/member/result/FT_result_new.php?game_id=$gid&gtype=FT&uid=$suid&langx=$langx";
	
		$thisHttp->getPage($filename);
		echo $msg  = $thisHttp->getContent();
   