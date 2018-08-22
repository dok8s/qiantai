<?php
include "./include/library.mem.php";
require ("./include/config.inc.php");
require ("./include/define_function_list.inc.php");
require ("./include/curl_http.php");

$gtype=$_REQUEST['gtype'];
if($gtype =='FU'){
	$gtype ="FT";
}
$langx='zh-cn';
$mysql = "select *  from web_system";
$result1 = mysql_db_query($dbname,$mysql);
$row1 = mysql_fetch_array($result1);
$b_http=$row1['Old_http'];
switch($langx){
	case 'en-us':
		$site=$row1['datasite_en'];
		$suid=$row1['uid_en'];
		$mima='Plaese input username/passwd and tryagain';
	case 'zh-vn':
		$site=$row1['datasite_tw'];
		$suid=$row1['uid_tw'];
	default:
		$site=$row1['datasite'];
		$suid=$row1['uid_cn'];
}
  $base_url = "".$site."/app/member/FT_browse/index.php?rtype=r&uid=$suid&langx=$langx&mtype=3";
  $filename="".$site."/app/member/FT_browse/body_var.php?rtype=r&uid=$suid&langx=$langx&mtype=3&delay=&page_no=0";
	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer($base_url);
	$data=$curl->fetch_url($filename);
	$data=str_replace('_.','parent.',$data);
	$data=str_replace('parent.GameFT=new Array();','',$data);
	$data=str_replace('parent.GameHead = new Array','',$data);
	$data=str_replace('g([','Array(',$data);
	$data=str_replace('])',')',$data);
	$da=date('Y-m-d H:i:s');
	$str = '<script>';
	if (sizeof(explode("gameCount",$data))>1){
		$gameCount=explode('gameCount=\'',$data);
		$gameCount=explode('\';',$gameCount[1]);
		$str = $str."var gameCount = '".$da.",".$gameCount[0]."';";
		$str = $str."parent.GameCount('".$da.",".$gameCount[0]."');";
	}else{
//		$str = $str."var gameCount='".$da.",FT|RB|0,FT|FT|0,FT|FU|0,FT|HOT_RB|0,FT|HOT_FT|0,FT|HOT_FU|0,BK|RB|0,BK|FT|0,BK|FU|0,BK|HOT_RB|0,BK|HOT_FT|0,BK|HOT_FU|0,BS|RB|0,BS|FT|0,BS|FU|0,BS|HOT_RB|0,BS|HOT_FT|0,BS|HOT_FU|0,TN|RB|0,TN|FT|0,TN|FU|0,TN|HOT_RB|0,TN|HOT_FT|0,TN|HOT_FU|0,VB|RB|0,VB|FT|0,VB|FU|0,VB|HOT_RB|0,VB|HOT_FT|0,VB|HOT_FU|0,OP|RB|0,OP|FT|0,OP|FU|0,OP|HOT_RB|0,OP|HOT_FT|0,OP|HOT_FU|0,FS|HOT_FT|0,FS|HOT_BK|0,FS|HOT_BS|0,FS|HOT_TN|0,FS|HOT_VB|0,FS|HOT_OP|0';
//			parent.GameCount('".$da.",FT|RB|0,FT|FT|0,FT|FU|0,FT|HOT_RB|0,FT|HOT_FT|0,FT|HOT_FU|0,BK|RB|0,BK|FT|0,BK|FU|0,BK|HOT_RB|0,BK|HOT_FT|0,BK|HOT_FU|0,BS|RB|0,BS|FT|0,BS|FU|0,BS|HOT_RB|0,BS|HOT_FT|0,BS|HOT_FU|0,TN|RB|0,TN|FT|0,TN|FU|0,TN|HOT_RB|0,TN|HOT_FT|0,TN|HOT_FU|0,VB|RB|0,VB|FT|0,VB|FU|0,VB|HOT_RB|0,VB|HOT_FT|0,VB|HOT_FU|0,OP|RB|0,OP|FT|0,OP|FU|0,OP|HOT_RB|0,OP|HOT_FT|0,OP|HOT_FU|0,FS|HOT_FT|0,FS|HOT_BK|0,FS|HOT_BS|0,FS|HOT_TN|0,FS|HOT_VB|0,FS|HOT_OP|0');";
	}
	echo $str."</script>";

?>
