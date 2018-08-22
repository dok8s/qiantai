<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
require ("../include/config.inc.php");
require ("../include/curl_http.php");
require ("../include/address.mem.php");
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$league_id=trim($_REQUEST['league_id']);
require ("../include/traditional.$langx.inc.php");
if ($rtype=='fs'){
	$type="and Gtype!='FI'";
}else if ($rtype=='fi'){
	$type="and Gtype='FI'";
}
$fstype=$_REQUEST['FStype'];
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$open=$row['OpenType'];
$memname=$row['UserName'];
$credit=$row['Money'];

$m_date=date('Y-m-d');
$time=date('H:i:s');
$K=0;
?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<script>
<?
	$mysql = "select datasite,uid,uid_tw,uid_en from web_system_data where ID=1";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$site=$row['datasite'];
	switch($langx)	{
	case "zh-tw":
		$suid=$row['uid_tw'];
		break;
	case "zh-cn":
		$suid=$row['uid'];
		break;
	case "en-us":
		$suid=$row['uid_en'];
		break;
	case "th-tis":
		$suid=$row['uid_en'];
		break;
	}
	
	
$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/browse_FS/loadgame_R.php?rtype=fs&uid=$suid&langx=$langx&mtype=3");
$allcount=0;
$html_data=$curl->fetch_url("".$site."/app/member/browse_FS/reloadgame_R.php?uid=$suid&langx=$langx&rtype=fs&league_id=$league_id&FStype=$fstype");
//echo "".$site."/app/member/browse_FS/reloadgame_R.php?uid=$suid&langx=$langx&rtype=fs&league_id=$league_id";
$a = array(
"if(self == top)",
"<script>",
"</script>",
"new Array()",
"new Array();",
"\n\n"
);

$b = array(
"",
"",
"",
"",
"",
""
);
	$msg = str_replace($a,$b,$html_data);
	
	preg_match_all("/new Array\((.+?)\);/is",$msg,$matches);
	$cou_num=sizeof($matches[0]);
	preg_match_all("/parent.areasarray=(.+?);/is",$html_data,$areasarray);
	preg_match_all("/parent.itemsarray=(.+?);/is",$html_data,$itemsarray);
	preg_match_all("/parent.itemsarray=(.+?);/is",$html_data,$leaguearray);
?>
parent.sessions='2';
parent.nowtime='<?=$time?>';
parent.records=40;
parent.gamount=<?=$cou_num?>;
parent.areasarray=<?=$areasarray[1][0] ?>;
parent.itemsarray=<?=$itemsarray[1][0] ?>;
parent.leaguearray=<?=$leaguearray[1][0] ?>;
parent.msg='<?=$mem_msg?>';
var ordersR=new Array();
var gidx=new Array();
var GameFT=new Array();
<?php 
for($i=0;$i<$cou_num;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace("new Array(","",$messages);
	    $messages=str_replace(");","",$messages);
		echo "GameFT[$i] = new Array(".$messages.");"."\n";
		$datainfo=explode(",",$messages);
        echo "gidx[".$datainfo[0]."]=$i;"."\n";	
}
?>
parent.GameFT=GameFT;
parent.gidx=gidx;
parent.ordersR=ordersR;
parent.showgame_table();
</script>
