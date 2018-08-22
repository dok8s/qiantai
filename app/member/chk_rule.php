<?

//if ($HTTP_SERVER_VARS['SERVER_ADDR']<>"58.64.136.81"){exit;}if (date('Y-m-d')>'2009-01-01'){exit;}


include "./include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

$str = time();
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
require ("./include/traditional.$langx.inc.php");
require ("./include/config.inc.php");
require ("./include/define_function_list.inc.php");

$sql = "select language,memname from web_member where Oid='$uid' and Oid<>''";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);

$memname=$row['memname'];

////userlog($memname);

$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Welcome</title>
<link href="/style/member/mem_index_data.css" rel="stylesheet" type="text/css">
</head>
<SCRIPT language="JavaScript" src="/js/top.js"></SCRIPT>
<body id="RCHK" onLoad="location.href='./FT_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>&showtype=<?=$showtype?>';" style="display:none">

<div id="container">
  <div id="header"><h1><span></span></h1></div>

  <div id="info">

    <?=$rule?>
	<div class="chk">
	  <form action="logout.php" method="get" name="myForm">
        <input type="hidden" name="uid" value="<?=$uid?>">
        <input type="hidden" name="langx" value="<?=$langx?>">
        <input name="submit" type="submit" style="width:80px" value="<?=$rule8?>">
      </form>
	  <form action="./FT_index.php" method="get" name="myForm">
        <input type="hidden" name="uid" value="<?=$uid?>">
        <input type="hidden" name="langx" value="<?=$langx?>">
        <input type="hidden" name="mtype" value="3">
        <input name="submit2" type="submit" style="width:80px" value="<?=$rule9?>">
      </form>
	</div>
    <br class="clear" />
    </div><!-- rule end -->
  </div>
  <!-- info end -->

</div>
<?=$rule_bottom?>

</body>
</html>
<!--iframe name='message' src='../readmsg.php?uid=<?=$uid?>&user=<?=$memname?>&langx=<?=$langx?>' style='width:0px;height:0px'-->
<?
}
mysql_close();
?>
