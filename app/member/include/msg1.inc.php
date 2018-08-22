<?
//@include("./include/msg.inc.php");

$exArr=array();
$exArr['zh-cn']='';
$exArr['zh-tw']='_tw';
$exArr['en-us']='_en';
$ex = isset($exArr[$langx]) ? $exArr[$langx] : $exArr['zh-tw'];

$sql = "select memname from web_member where oid='$uid'";
$result = mysql_query($sql) or exit('error inc001');
$row = mysql_fetch_array($result);
$memname = $row['memname'];

mysql_query("update message set readcount=readcount+1 where member='$memname' limit 1");
$sql = "select message,message_tw from message where member='$memname'";
$result = mysql_query($sql);// or exit("error 998".mysql_error());
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou>0){
	$talert=$row['message'.$ex];
}else{
	$sql='select s2alert as msg_member_alert,alert2_tw as msg_member_tw from web_system';
	$result = mysql_query($sql);// or exit("error 999");
	$row = mysql_fetch_array($result);
	if($row['msg_member_alert']==1 ){
		$row['msg_member']=big52gb($row['msg_member_tw']);
		$talert=$row['msg_member'.$ex];
	}
}

if($talert<>''){
	$type = strlen($ShowType)>1 ? $ShowType : $showtype;
	echo "<script> alert('  $talert  '); </script>";
	/*
	echo "<script>
	try{top.game_alert.indexOf('$type')}catch(err){top.game_alert='';}
	if (top.game_alert.indexOf('$type')==-1){ alert('  $talert  '); top.game_alert+='$type,'} </script>";
	*/
}
//echo $sql;
//exit;
?>
<!-- -->
