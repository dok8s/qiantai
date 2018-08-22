<?
$WWW_DIR = str_replace('/app/member/include','/../', str_replace('\\','/', dirname(__FILE__)));
define('WWW_DIR', $WWW_DIR);

//require_once(WWW_DIR.'inc/global.php');

isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_FORWARDED_FOR'];

$dbhost = "localhost:17432";
$dbuser = "rv9999";
$dbpass = "jfidc~2014%@)";
$dbname = "xv89h_data";


$lnk = mysql_connect($dbhost,$dbuser,$dbpass) or exit("ERROR MySQL Connect");
mysql_select_db($dbname, $lnk);

$str="!and|update|from|where|order|by|*|delete|\'|insert|into|values|create|table|alert|database|script|iframe|<>|onload|\"|eval|base64_decode";  //非法字符 

$arr=explode("|",$str);//数组非法字符，变单个 
foreach ($_REQUEST as $key=>$value){
	for($i=0;$i<sizeof($arr);$i++){
		if (substr_count(strtolower($_REQUEST[$key]),$arr[$i])>0){       //检验传递数据是否包含非法字符 
		    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><SCRIPT language='javascript'>\nalert('含有非法字符".$arr[$i]."');window.open('index.php','_top');</script>";
            exit;
		}
		/*if(strlen($_REQUEST[$key])>100){			
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><SCRIPT language='javascript'>\nalert('字符串太长');window.open('index.php','_top');</script>";
            exit;
		}*/
	} 
} 

$uid = $_REQUEST['uid'];
$sql = "SELECT setip FROM web_member WHERE oid='$uid'";
$row = mysql_fetch_array(mysql_query($sql));
if($row['setip']!=''){
	$row['setip']=long2ip(ip2long($row['setip']));
	if($row['setip']!='0.0.0.0'){
		$_SERVER['REMOTE_ADDR']=$row['setip'];
	}
}

$sql = "select * from web_marquee where level=4 order by ntime desc limit 0,1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$msg_member=$row['message'];
$msg_member_tw=$row['message_tw'];
$msg_member_en=$row['message_en'];

$cou=count(explode('_order_',$_SERVER["REQUEST_URI"]));
if($cou==2){
	$sql = "select bet_time,acton from web_system";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	$bet_time=$row['bet_time'];
	//$act_time=$row['act_time'];
	$not_active=$row['acton'];
}
$sql = "select * from web_system ";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
//$cookie=$row['cookie'];
$uidcd= $row['cookie'];

?>
