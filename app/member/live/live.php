<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");

$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$liveid=$_REQUEST['liveid'];
$eventid=$_REQUEST['eventid'];
$autoOddCheck=$_REQUEST['autoOddCheck'];
$openlive=$_REQUEST['openlive'];
if($openlive != 'Y')$openlive='N';
$gtype=$_REQUEST['gtype'];
if($gtype == 'undefined')$gtype='';
require ("../include/traditional.$langx.inc.php");

$sql = "select pay_type,LogIP,OpenType,language,Memname,credit,Money,date_format(logdate,'%Y-%m-%d') as logdate from web_member where Oid='$uid' and Status<>0";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('/tpl/logout_warn.html','_top')</script>";
	exit;
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
$base_url = "".$site."/app/member/live/live.php?uid=$suid&langx=$langx&liveid=$liveid";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename = "".$site."/app/member/live/live.php?uid=$suid&langx=$langx&liveid=$liveid";
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$msg  = str_replace($site, '', $msg);
$msg  = str_replace($suid, '', $msg);
$msg  = str_replace('uid=', "uid=$uid", $msg);
$msg  = str_replace("window.open('/tpl/logout_warn.html','_top')", "", $msg);
$script1  = explode("<script>", $msg);
$script2 = array();
$script2  = explode("</script>", $script1[1]);
$msgNot=(!$script2[2])?false:true;

?>

<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
	<title>Xem cảnh</title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/live.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?
		if($msgNot){
			echo '<script>'.$script2[0]."</script>";
		}else{
			?>
			<script>
				var uid = '<?=$uid?>';
				var langx = '<?=$langx?>';
				var mtvid = '';
				var eventid = '';
				var eventlive = '';
				var mcurrency = 'USD';
				var videoData = '';
				var GameDate = '';
				var o_path = '';
				top.autoOddCheck = false;
			</script>
			<?
		}
	?>
	<script language="javascript" src="/js/jquery-3.1.0.min.js"></script>
	<script language="javascript" src="/js/live.js"></script>
	<script language="javascript" src="/js/zh-cn.js"></script>
	<script>
		top.str_order_FT = "<?=$str_order_FT?>";
		top.str_order_BK = "<?=$str_order_BK?>";
		top.str_order_TN = "<?=$str_order_TN?>";
		top.str_order_VB = "<?=$str_order_VB?>";
		top.str_order_BS = "<?=$str_order_BS?>";
		top.str_order_OP = "<?=$str_order_OP?>";
		top.str_date_list="<?=$syrq?>";
		top.openlive ="<?=$openlive?>";
		var isonload_TV ="<?=$openlive?>";
	</script>

</head>
<body onload="onloads();" scrolling="no" onclose="unLoad();" onselectstart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;" class="liveTV liveTVBG">
<?
if($openlive == "Y"){
	require ("live_open.php");
}else{
	require ("live_index.php");
}
mysql_close();
?>
</body>
</html>
