<?
include "./include/library.mem.php";
require ("./include/config.inc.php");
require ("./include/define_function_list.inc.php");


$mysql = "select ID,BetType,BetType_tw,Middle,Middle_tw,Middle1,Middle1_tw,BetType1,BetType1_tw,Middle2,Middle2_tw from web_db_io ";// where BetTime='2013-05-09 23:31:38'limit 0,30";
$result = mysql_query($mysql);
while($row = mysql_fetch_array($result)){
	$BetType = iconv("gb2312","utf-8//IGNORE",$row['BetType']);
	$BetType1 = iconv("gb2312","utf-8//IGNORE",$row['BetType1']);
	$Middle = iconv("gb2312","utf-8//IGNORE",$row['Middle']);
	$Middle1 = iconv("gb2312","utf-8//IGNORE",$row['Middle1']);
	$Middle2 = iconv("gb2312","utf-8//IGNORE",$row['Middle2']);

	$BetType_tw = iconv("big5","utf-8//IGNORE",$row['BetType_tw']);
	$BetType1_tw = iconv("big5","utf-8//IGNORE",$row['BetType1_tw']);
	$Middle_tw = iconv("big5","utf-8//IGNORE",$row['Middle_tw']);
	$Middle1_tw = iconv("big5","utf-8//IGNORE",$row['Middle1_tw']);
	$Middle2_tw = iconv("big5","utf-8//IGNORE",$row['Middle2_tw']);

	$msql="update web_db_io set BetType='$BetType',BetType_tw='$BetType_tw',Middle='$Middle',Middle_tw='$Middle_tw',Middle1='$Middle1',Middle1_tw='$Middle1_tw',BetType1='$BetType1',BetType1_tw='$BetType1_tw',Middle2='$Middle2',Middle2_tw='$Middle2_tw' where ID='".$row['ID']."'";
	mysql_query($msql);
	echo $msql."<br>";
}


?>
<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body   id="OFIN" class="bodyset" >
</body>
</html>