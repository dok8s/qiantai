<?php
	require ("./include/config.inc.php");

	$uid=$_REQUEST['uid'];
	$user=$_REQUEST['user'];
	$langx=$_REQUEST['langx'];
	require ("./include/traditional.$langx.inc.php");
	$id=$_REQUEST['id'];
	$reply=trim($_REQUEST['reply']);
	if($_REQUEST['doDontShow']==1){
		$mysql="update message set history = concat('<!--reply_$langx--><br><font style=\"color:#555\">[',now(),']</font>','<span style=\"color:#BD7734\">用户设置了不再显示该信息</span>',history),isShow=0 where id=".$id;
		mysql_db_query($dbname,$mysql);
		echo "<script>window.close();</script>";
		exit;
	}
	if($langx=='zh-tw'||$langx=='th-tis'){
		$reply=big52gb($reply);
	}

	function big52gb($Text) {
		$filename = "./include/big5-gb.table";
		$fp = fopen($filename, "rb");
		$BIG5_DATA = fread($fp,filesize($filename));
		fclose($fp);
        $max = strlen($Text)-1;
        for($i=0;$i<$max;$i++) {
                $h = ord($Text[$i]);
                if($h>=0x80) {
                        $l = ord($Text[$i+1]);
                        if($h==161 && $l==64) {
                                        $gbstr = "　";
                        }else{
                                        $p = ($h-160)*510+($l-1)*2;
                                        $gbstr = $BIG5_DATA[$p].$BIG5_DATA[$p+1];
                        }
                        $Text[$i] = $gbstr[0];
                        $Text[$i+1] = $gbstr[1];
                        $i++;
                }
        }
        return $Text;
	}
	if($reply!=''){
		$mysql="update message set history = concat('<!--reply_$langx--><br><font style=\"color:#555\">[',now(),']</font>','<span style=\"color:#01059A\">用户回复：</span><span style=\"color:#f00\">".$reply."</span>',history),isShow=0 where id=".$id;
		mysql_db_query($dbname,$mysql);
		?>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Welcome</title>
	<link href="/style/member/mem_order.css" rel="stylesheet" type="text/css">
	<style type="text/css">
	<!--
	html, body { margin:0; padding-top:2px;text-align:center;}
	em{width:65px;white-space: nowrap;color:#000;text-align:right;font-size: 12px;}
	-->
	</style>
	<base target="_self"/>
	</head>
	<body>
	<script>alert('<?=$lang_msg_replySuccess?>');window.close();</script>
	</body>
	</html>
		<?
		exit;
	}
if($id!=""&&$id!=0){
?>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
	<title>Welcome</title>
	<link href="/style/member/mem_order.css" rel="stylesheet" type="text/css">
	<style type="text/css">
	<!--
	html, body { margin:0; padding-top:2px;text-align:center;}
	em{width:65px;white-space: nowrap;color:#000;text-align:right;font-size: 12px;}
	-->
	</style>
	<base target="_self"/>
	<script>
		function doDontShow(){
			if(confirm("<?=$lang_msg_confirmDontShow?>?")){
				document.forms[0].action="?id=<?=$id?>&doDontShow=1";
				document.forms[0].submit();
			}
	}
	</script>
	</head>
	<body>
<div class="chg" ><h4><?=$lang_msg_content?></h4>
	 <form method=post action="?id=<?=$id?>">
	 <input type="hidden" name="uid" value="<?=$uid?>">
     <input type="hidden" name="langx" value="<?=$langx?>">
     <input type="hidden" name="user" value="<?=$user?>">
		<div class="chg_bg">
			<table cellpadding="0" cellspacing="0">
				<tr>
      					<td valign="bottom" align="left" style="font-size:13px;">
						<?
						$sql = "select id,message,message_tw from message where id=".$id;
						$result = mysql_db_query($dbname, $sql);
						$row= mysql_fetch_array($result);
						switch($langx){
						case 'zh-tw':
							$talert=$row['message_tw'];
							break;
						case 'zh-cn':
							$talert=$row['message'];
							break;
						}
						echo $talert;
						?>
						</td>
						</tr>
						<tr>
						<td valign="bottom" align="center">
						<textarea name="reply" cols="45" rows="5"><?=$lang_msg_replyValue?>:</textarea>
						</td>
						</tr>
						<tr>
						<td valign="bottom" align="center">
						<input type=submit name="Submit" value="<?=$lang_msg_Submit?>" class="yes">
						<input style="display:none" type=button name="dontShow" value="<?=$lang_msg_dontShow?>" onClick="javascript:doDontShow();" class="yes">
						<input type=button name="close" value="<?=$lang_msg_close?>" class="no" onClick="javascript:window.close();">
						</td>
						</tr>
			</table>
<!-- 			<hr color="#993300" noshade>
			<font color="#CC0000">
				<p align="left">1.盞絏惠ㄏノダ计</p>
				<p align="left">2.盞絏ゲ斗ぶ6じ程12じ</p><br>
			</font> -->
		</div>
	</form>
</div>
	</body>
	</html>
<?
			exit;
}
	$sql = "select id,message,message_tw from message where member='$user' and isShow=1";
	$result = mysql_db_query($dbname, $sql);
	while ($row = mysql_fetch_array($result))
	{
		switch($langx){
		case 'zh-tw':
			$talert=$row['message_tw'];
			break;
		case 'zh-cn':
			$talert=$row['message'];
			break;
		}
		if ($talert<>''){
			//$content.="alert('$talert');";
			$content.="alert('$talert');window.showModalDialog('?id=".$row['id']."&langx=".$langx."&uid=".$uid."&user=".$user."', '', 'dialogHeight=230px;dialogWidth=380px;center=yes;status=no;help=no;statusbar=no;scroll=yes;');";
		}
		$mysql="update message set readcount = readcount + 1 where id=".$row['id'];
		mysql_db_query($dbname,$mysql);
		$mysql="select history from message where id=".$row['id'];
		$result_history=mysql_db_query($dbname,$mysql);
		$row_history=mysql_fetch_array($result_history);
		$history=$row_history["history"];
		$history=substr($history,0,11);
		if($history!="<!--read-->"){
			$mysql="update message set history = concat('<!--read--><br><font style=\"color:#555\">[',now(),']</font>','<span style=\"color:#86C031\">用户阅读了信息',history) where id=".$row['id'];
			mysql_db_query($dbname,$mysql);
		}else{
//			$mysql="update message set history = concat('<!--read--><br><font style=\"color:#555\">[',now(),']</font>','<span style=\"color:#86C031\">用户再次阅读了信息</span>',history) where id=".$row['id'];
//			mysql_db_query($dbname,$mysql);
		}
	}
	echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$charset."\"></head><body><script>".$content."</script></body></html>";
	mysql_close();
?>