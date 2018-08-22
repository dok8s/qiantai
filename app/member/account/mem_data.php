<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$flag=$_REQUEST["flag"];
$mtype=$_REQUEST['mtype'];
require ("../include/traditional.$langx.inc.php");


$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
		echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{

	$row = mysql_fetch_array($result);
	$memname=$row['Memname'];
	$credit=$row['Credit'];
	$page='chg_passwd.php?uid='.$uid;

?>
<SCRIPT>
var dataAry = new Object();
var dataAry = new Object();
dataAry['FT']=new Object();
dataAry['FT']['R']='R|<?=$row["FT_R_Scene"]?>|<?=$row["FT_R_Bet"]?>|none';
dataAry['FT']['RE']='RE|<?=$row["FT_RE_Scene"]?>|<?=$row["FT_RE_Bet"]?>|none';
dataAry['FT']['M']='M|<?=$row["FT_M_Scene"]?>|<?=$row["FT_M_Bet"]?>|none';
dataAry['FT']['DT']='DT|<?=$row["FT_PC_Scene"]?>|<?=$row['FT_PC_Bet']?>|none';
dataAry['FT']['RDT']='RDT|<?=$row["FT_PC_Scene"]?>|<?=$row["FT_PC_Bet"]?>|none';
dataAry['BK']=new Object();
dataAry['BK']['R']='R|<?=$row["BK_R_Scene"]?>|<?=$row["BK_R_Bet"]?>|none';
dataAry['BK']['RE']='RE|<?=$row["BK_RE_Scene"]?>|<?=$row["BK_RE_Bet"]?>|none';
dataAry['BK']['M']='M|<?=$row["BK_PC_Scene"]?>|<?=$row["BK_PC_Bet"]?>|none';
dataAry['BK']['DT']='DT|<?=$row["BK_PC_Scene"]?>|<?=$row["BK_PC_Bet"]?>|none';
dataAry['OP']=new Object();
dataAry['OP']['R']='R|<?=$row["OP_R_Scene"]?>|<?=$row["OP_R_Bet"]?>|none';
dataAry['OP']['RE']='RE|<?=$row["OP_RE_Scene"]?>|<?=$row["OP_RE_Bet"]?>|none';
dataAry['OP']['M']='M|<?=$row["OP_M_Scene"]?>|<?=$row["OP_M_Bet"]?>|none';
dataAry['OP']['DT']='DT|<?=$row["OP_PC_Scene"]?>|<?=$row["OP_PC_Bet"]?>|none';
dataAry['FS']=new Object();
dataAry['FS']['R']='FS|<?=$row["FS_R_Scene"]?>|<?=$row["FS_R_Bet"]?>|none';
</SCRIPT><html>
<head>
<meta name="Robots" contect="none">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body_ftc1.css" type="text/css">
<link rel="stylesheet" href="/style/member/mem_body_his1.css" type="text/css">
<SCRIPT language="JavaScript" src="/js/mem_conf.js"></SCRIPT>
<script>
var legStr = "Extreme Major Competition-";

function onLoad(){
	ShowTable("FT");
}
</script>
</head>
<body class="bodyset HIS" onLoad="onLoad()">
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td class="top">
  	  <h1><em><?=$pljs?></em></h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
            <table width="100%" border="0" cellpadding="1" cellspacing="0" class="btn_table">
	              <tr>
                    <td id="FT_td" onClick="ShowTable('FT');" class="btn_on"><?=$Soccer?></td>
	                  <td id="BK_td" onClick="ShowTable('BK');" class="btn_out"><?=$BasketBall?></td>
	                  <td id="OP_td" onClick="ShowTable('OP');" class="btn_out"><?=$zhgg1?></td>
	                  <td id="FS_td" onClick="ShowTable('FS');" class="btn_out" style="border-right:none;"><?=$spmatch?></td>
	              </tr>
            </table>
				<span id="show_T" name="show_T"></span>
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
<span id="table_content" name="table_content" style="position:absolute; display: none">
	<xmp>
      <tr class="*TR_CLASS*">
        <td width="400">*TYPE*1</td>
        <td class="center">*S_MATCH*</td>
        <td class="center">*S_BET*</td>
      </tr>
  </xmp>
</span>
<span id="body_T" name="body_T" style="position:absolute; display: none">
	<xmp>
    <table border="0" cellspacing="0" cellpadding="0" class="game">
      <tr> 
        <th><strong><?=$leixin?></strong></th>
        <th ><strong>*LEGSTR*<?=$dcxe1?></strong></th>
        <th ><strong>*LEGSTR*<?=$dzxe1?></strong></th>
      </tr>
      *t_replace*
    </table>
  </xmp>
</span>
</body>
</html>
<?
//userlog($memname);
}
?>


