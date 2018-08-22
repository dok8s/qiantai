<?

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);
$langx=$_REQUEST['langx'];
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}

$mdate=date('m-d');
?>
<html>
<head>
<title>body_football_f</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
<link rel="stylesheet" href="/style/member/mem_body.css" type="text/css">
<script language="JavaScript">
 var ReloadTimeID;

 function onLoad() 
 {
  parent.loading = 'N';
  parent.ShowType = 'CS';
  if(parent.loading_var == 'N')
  {
   parent.ShowGameList();
   obj_layer = document.getElementById('LoadLayer');
   obj_layer.style.display = 'none';
  }
//  if(parent.retime_flag == 'Y')
   count_down();
 }
  
//倒數自動更新時間 
 function count_down(){
  setTimeout('count_down()',1000);
  if (parent.retime_flag == 'Y'){
	  if(parent.retime <= 0)
	  {
	   if(parent.loading_var == 'N')
	    reload_var();
	   return;
	  }
	  parent.retime--;
	  obj_cd = document.getElementById('cd');
	  obj_cd.innerHTML = parent.retime;
  }
 }
 
 function reload_var()
 {
	parent.loading_var == 'Y';
	parent.body_var.location.reload();
 }
 function chg_league()
 {
  var obj_league = document.getElementById('sel_lid');
  parent.body_var.location="./body_var.php?uid="+parent.uid+"&rtype=fs&mtype=<?=$mtype?>&langx=zh-tw&sel_lid="+obj_league.value;
 }
</script>
<SCRIPT language="javascript" src="/js/key_even.js"></SCRIPT>
</head>
<body id="MFS" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false" onLoad="onLoad();">
<div id="LoadLayer">loading...............................................................................</div>
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td id="ad">
      <span id="real_msg"></span>
	  <p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$message?></a></p>
	</td>
  </tr>
  <tr>
    <td class="top">
  	  <h1><em><?=$guancap?></em><input type="button" name="Submit323" value="<?=$Refresh?>" class="new" onClick="javascript:reload_var()">
  	  <span><?=$Paicai?></span></h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
	  <h2><span id="pg_txt"></span>
	    <div class="a">
		<?=$sel_league?>
          <select name="sel_lid" onChange="chg_league()" class="za_select" id="sel_lid">
          <option value=""><?=$sel_all?></option>
<?
	$mysql = "select distinct $sleague as M_League FROM `sp_match` WHERE mstart>now() and mshow=1";

	$result = mysql_db_query($dbname, $mysql);
	while ($league=mysql_fetch_array($result)){
		echo "<OPTION value='$league[M_League]'>$league[M_League]</OPTION>";
	}
	?>

  	</select>
	    </div>
	  </h2>
      <table id="game_table" border="0" cellspacing="1" cellpadding="0" class="game">
        <tr> 
          <!--th class="time">時間</th-->
          <th width="446"><?=$guanlea?></th>
          <th><?=$prate?></th>
 </tr>
      </table> 
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>

</body>
</html>
<?
mysql_close();
?>
<?=$bottom?>
