<?

include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");

$uid=$_REQUEST['uid'];
$gtype=$_REQUEST['gtype'];
$gidm=$_REQUEST['gidm'];
$gdate=$_REQUEST['gdate'];
$gameary=$_REQUEST['gameary'];
$liveid=$_REQUEST['liveid'];
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
$filename = "".$site."/app/member/live/game_ioratio_view.php?uid=$suid&langx=$langx&gidm=$gidm&gdate=$gdate&"."gtype=".$gtype;
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$msg  = str_replace($site, '', $msg);
$msg  = str_replace($suid, '', $msg);
$msg  = str_replace('uid=', "uid=$uid", $msg);
$msg  = str_replace("uid = '';", "uid='$uid';", $msg);
$msg  = str_replace("uid ='';", "uid='$uid';", $msg);
$msg  = str_replace("uid='';", "uid='$uid';", $msg);
$msg  = str_replace('<body', "<body onSelectStart=\"self.event.returnValue=false\" oncontextmenu=\"self.event.returnValue=false;window.event.returnValue=false;\"", $msg);
$msg  = str_replace("window.open('tpl/logout_warn.html','_top')", "", $msg);
$msg  = str_replace("window.open('/tpl/logout_warn.html','_top')", "", $msg);
$script1  = explode("<script>", $msg);
$script2 = array();
$script2  = explode("</script>", $script1[1]);
$msgNot=(!$script2[2])?true:false;
//var_dump($script2);
mysql_close();

?>

<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
	<title>观看现场</title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/live.css" rel="stylesheet" type="text/css">
	<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
	<?
	if($msgNot){
		echo '<script>'.$script2[0]."</script>";
	}else{
		?>
		<script>
			var liveTV='Y';
			var uid ='<?=$uid?>';
			var odd_f_type ='H';
			var odd_f_str = 'H,M,I,E';
			var Format=new Array();
			Format[0]=new Array( 'H','Tấm Hồng Kông','Y');
			Format[1]=new Array( 'M','Đĩa Malay','Y');
			Format[2]=new Array( 'I','Tấm Indonesia','Y');
			Format[3]=new Array( 'E','Đĩa châu Âu','Y');
			var game_gidm='';
			var gidmstr='';
			var iorpoints =2;
			var show_ior=100;
			var title_strbig ='Lớn';
			var title_strsmall ='Nhỏ';
			var flash_ior_set ='Y';
			var str_even = 'Phòng';
			var str_submit = 'Xác định';
			var str_reset = 'Đặt lại';
			var langx='<?=$langx?>';
			var GameData = new Array();
			var GameFT = new Array();
			var o_path="./game_ioratio.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&gdate=<?=$gdate?>";
		</script>
		<?
	}
	?>
	<script language="javascript" src="/js/ratioForm_Single_rule.js"></script>
	<script language="javascript" src="/js/game_ioratio.js"></script>
	<script language="javascript" src="/js/get_ioratio.js"></script>
	<script language="javascript" src="/js/flash_ior_mem.js"></script>

</head>
<body onload="onloads();" class="" style="height: 450px;">

<div id="game">
	<!--无法投注-->
	<div id="bet_none" class="live_closeDIV" style="display:none"><span>Sự kiện bạn đã chọn tạm thời không khả dụng.</span></div>
	<!--无法投注 End-->
	<!--玩法没开-->
	<div id="none_div" class="live_noList_high" style="display:none;">Không có sự kiện giao dịch nào được chọn.</div>
	<!--玩法没开 End-->
	<span id="live_refresh" class="live_refreshBTN" style="display:none">&nbsp;&nbsp;4&nbsp;</span>
	<div id="right_div" class="live_scrollBar" style="display:none"></div>
</div>
<?
require ("live_box.php");
?>
<iframe id="reloadPHP" name="reloadPHP" src="/ok.html" style="display:none" width="0" height="0"></iframe>
</body>
</html>
