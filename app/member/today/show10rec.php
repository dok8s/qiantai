<?


include "../include/library.mem.php";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
//	echo "<script>window.open('".BROWSER_IP."','_top')<script>";
//	exit;
}

$row = mysql_fetch_array($result);
$memname=$row['Memname'];
//$langx=$row['language'];

require ("../include/traditional.$langx.inc.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
<script>
window.onload = function (){
	parent.onloadSet(document.body.scrollWidth,document.body.scrollHeight,"rec_frame");
}

function re_load(){
	window.location.href=window.location;
}
</script>
</head>
<!---->
<body id="OHIS" class="bodyset" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">

<div style='display:'>
<div class="ord">
<div class="title"><h1><?=$zxjy?></h1><div class="tiTimer" onClick="re_load();"></div></div>
  <div class="show">
    
<?
if($langx=='zh-cn'){
$middle="Middle";
}
if($langx=='zh-tw'){
$middle="Middle_tw";
}
if($langx=='en-us'){
$middle="Middle_en";
}
$mDate=date('Y-m-d');
$sql = "select danger,mid,mtype,active,wtype,showtype,linetype,date_format(BetTime,'%m-%d %H:%i:%s') as betime,Middle,BetScore,M_Date,Gwin,M_Place,M_Rate,Active from web_db_io where hidden=0 and Middle<>'' and M_Name='$memname' and m_Date>='$mDate' and m_result='' and (linetype<>7 and linetype<>8) order by id desc limit 0,10";
$result = mysql_db_query($dbname,$sql);
while ($row = mysql_fetch_array($result)){
?>
<div class="tname">

<?
$linetype=$row['linetype'];
$row['Middle']=str_replace("<b>","",$row['Middle']);
$row['Middle']=str_replace("</b>","",$row['Middle']);
$middle=explode('<br>',$row['Middle']);
?>
<em><font class="his_h">
<?
echo $middle[count($middle)-2];
?>
</font><br>
<?
echo $middle[count($middle)-1];

?></em>
<b class="gold"><span class="fin_gold">RMB <?=number_format($row['BetScore'])?></span></b>
<?
switch($row['danger']){
case 1:
	echo '<div style="padding-left:20px; height:15px;color:#0033FF; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian.'</div>';
	break;
case 3:
	echo '<div style="padding-left:20px; height:15px;color:#009900; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian1.'</div>';
	break;
case 2:
	echo '<div style="padding-left:20px; height:15px;color:#FF0000; font-weight:bold;background: url(/images/member/order_icon.gif) no-repeat  -220px 0px;">'.$weixian2.'</div>';
	break;
default:
	break;

}
?>
 <b></b></p>
</div>
<?
}
mysql_close();
?>
</div>
<div style='display:none' class="show_info"><span class="show_top"></span><?=$nimei?></div>
</body>
</html>
