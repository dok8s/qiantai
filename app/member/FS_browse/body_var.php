<?
//if ($HTTP_SERVER_VARS['SERVER_ADDR']<>"58.64.136.81"){exit;}if (date('Y-m-d')>'2009-01-01'){exit;}

include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$league_id=$_REQUEST['sel_lid'];

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
 echo "<script>window.open('".BROWSER_IP."','_top')</script>";
 exit;
}

$open    = $row['OpenType'];
$langx   = $row['language'];
$memname = $row['Memname'];
$credit  = $row['Money'];

include "../include/traditional.$langx.inc.php";
if ($league_id==''){
 $league='';
}else{
 $league=" and ".$sleague."='".$league_id."'";
}

$mDate=date('m-d');
$K=0;
?>
<HEAD><TITLE>���y�ܼƭ�</TITLE>
 <META http-equiv=Content-Type content="text/html; charset=<?=$charset?>">
 <SCRIPT language=JavaScript>
  <!--
  if(self == top) location='<?=BROWSER_IP?>/app/member/'
  parent.username='<?=$memname?>';
  parent.maxcredit='<?=$credit?>';
  parent.code='�H����(RMB)';
  parent.uid='<?=$uid?>';
  parent.msg='<?=$mem_msg?>';
  parent.ltype='1';
  parent.str_even = '<?=$Draw?>';
  parent.str_submit = '<?=$Confirm?>';
  parent.str_reset = '<?=$Resets?>';
  <?

      echo "parent.retime=0;\n";
      echo "parent.gamount=0;\n";

  ?>

  function onLoad()
  {
   // if(top.SI2_mem_index.mem_order.location == 'about:blank')
   //  top.SI2_mem_index.mem_order.location = '<?=BROWSER_IP?>/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>';
   if(parent.retime > 0)
    parent.retime_flag='Y';
   else
    parent.retime_flag='N';
   parent.loading_var = 'N';
   if(parent.loading == 'N' && parent.ShowType != '')
   {
    parent.ShowGameList();
    parent.body_browse.document.all.LoadLayer.style.display = 'none';
   }
  }

  function onUnLoad()
  {
   x = parent.body_browse.pageXOffset;
   y = parent.body_browse.pageYOffset;
   parent.body_browse.scroll(x,y);
   obj_layer = parent.body_browse.document.getElementById('LoadLayer');
   obj_layer.style.display = 'block';
  }

  // -->
 </script>
</head>
<body bgcolor="#000000" onLoad="onLoad()" onUnLoad="onUnLoad()">
</body>
</html>
