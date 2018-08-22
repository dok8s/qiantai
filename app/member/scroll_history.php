<?
include "./include/library.mem.php";
require ("./include/config.inc.php");
require ("./include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$select_date=$_REQUEST["select_date"];
$fField=$_REQUEST['fField'];
$find=$_REQUEST['find'];
if($select_date==''){
	$select_date='-4';
}
$sql = "select language,memname from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);

	$memname=$row['memname'];
//userlog($memname);
if ($langx==''){
	$langx='zh-cn';
}
require ("./include/traditional.$langx.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Robots" contect="none">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>History</title>
<link rel="stylesheet" href="/style/member/mem_body_ft.css" type="text/css">
<link rel="stylesheet" href="/style/member/scroll.css" type="text/css">
<script>
top.langx='<?=$langx?>';
var select_date='<?=$select_date?>';
var t_page='1';
var page_no='';
var langx='<?=$langx?>';
var fField='<?=$fField?>';
</script>
<SCRIPT language="JavaScript" src="/js/scroll_history.js"></SCRIPT>
<script language="JavaScript" src="/js/<?=$langx?>.js"></script>

</head>
<body id="MSG" class="bodyset" onLoad="init_scroll()"; onKeyDown="checkKey(event.keyCode)">

<table border="0" cellpadding="0" cellspacing="0" id="box_top">
  <tr>
    <td class="top"><h1><em><?=$gglan?></em></h1></td>
  </tr>
  <tr>
    <td class="mem his_top"><div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="menu_set">
        <tr class="table_main_settings_tr">
          <td id="page_no2"><span id="pg_txt"></span> <span  style="display: none;" id="t_pge"></span>
            <!--<span id="today" onClick="chg_date(0);">今日</span>-->
            <span onClick="chg_date('all');"><a href="#" ><font id="all" color="#ffffff"><?=$quanbu?></font></a></span> / <span onClick="chg_date(0);"><a href="#" ><font id="today" color="#ffffff"><?=$jinri?></font></a></span> / <span onClick="chg_date(-1);"><a href="#" ><font id="yesterday" color="#ffffff"><?=$zuori?></font></a></span> / <span onClick="chg_date(-2);"  ><a href="#"><font id="before" color="#ffffff"><?=$zuori1?></font></a></span>
          <td class="search"><input type="text" id="findField" name="" value="" class="ccroll_input">
          <input type="button"  id="findbutton" name="" onClick="FindNext();" value="<?=$souxun?>" class="ccroll_btn">
          </td>
          <td class="rsu_refresh"><div onClick="reload_var();"><font id="refreshTime"></font></div></td>
          <!--td width="50"><input type="submit" name="button" id="button" value="" onClick="reload_var();" class="his_refresh" /></td-->
        </tr>
      </table>
    </div>
      <table border="0" cellspacing="0" cellpadding="4" class="game">
        <tr>
          <th width="40"><?=$xuhao?></th>
          <th width="70"><?=$his_date?></th>
          <th align="left" class="info"><?=$scroll_message?></th>
        </tr>
      </table></td>
  </tr>
</table>
 
 
<table border="0" cellpadding="0" cellspacing="0" id="box">

  <tr>
    <td class="mem his_body">
    
    <table border="0" cellspacing="0" cellpadding="4" class="game">
        <?
		if($find==true){
			$sql="select date_format(ntime,'%y-%m-%d') as ntime,$shistory as message from web_marquee where (message like '%".$fField."%' or message_tw like '%".$fField."%' or message_en like '%".$fField."%') and level=4 and mshow=1 order by id desc";
		}else{
			$ndate="";
			if($select_date=="" or $select_date==0){
			$ndate=date('Y-m-d');
			$sql="select date_format(ntime,'%y-%m-%d') as ntime,$shistory as message from web_marquee where ndate='$ndate' and level=4 and mshow=1 order by id desc";
			}
			if($select_date==-1){
			 $ndate=date('Y-m-d',strtotime('-1 day'));
			$sql="select date_format(ntime,'%y-%m-%d') as ntime,$shistory as message from web_marquee where ndate='$ndate' and  level=4 and mshow=1 order by id desc";
			}
			if($select_date==-2){
			$ndate=date('Y-m-d',strtotime('-1 day'));
			$sql="select date_format(ntime,'%y-%m-%d') as ntime,$shistory as message from web_marquee where ndate<'$ndate' and level=4 and mshow=1 order by id desc";
			}
			if($select_date=='all' or $select_date==-4){
			
			$sql="select date_format(ntime,'%y-%m-%d') as ntime,$shistory as message from web_marquee where level=4 and mshow=1 order by id desc";
			}
		}
	$result = mysql_db_query($dbname,$sql);
	$icount=1;
	while ($row = mysql_fetch_array($result))
	{
			if($icount%2==0){
	?>
	
		<tr class="color_bg1" style="display: block" onMouseOver="overbars(this,'color_bg3');" onMouseOut="outbars(this,'color_bg2')">
          <td width="40" class="m_cen"><?=$icount?></td>
          <td width="70" class="m_cen"><?=$row['ntime']?></td>
		  <? if($find==true){
		  		$row['message']=str_replace($fField,'<font color="FF0F00">'.$fField.'</font>',$row['message']);
			}
		  ?>
		  
		  
          <td align="left" class="m_lef"><?=trim($row['message'])?></td>
        </tr>
		<? }else{?>
		<tr class="color_bg2" style="display: block" onMouseOver="overbars(this,'color_bg3');" onMouseOut="outbars(this,'color_bg2')">
          <td width="40" class="m_cen"><?=$icount?></td>
          <td width="70" class="m_cen"><?=$row['ntime']?></td>
		  <? if($find==true){
		  		$row['message']=str_replace($fField,'<font color="FF0F00">'.$fField.'</font>',$row['message']);
			}
		  ?>
		  
		  
          <td align="left" class="m_lef"><?=trim($row['message'])?></td>
        </tr>

		<? }?>
<?
$icount++;
}
mysql_close();
?>

      </table> 
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>

</body>
</html>
