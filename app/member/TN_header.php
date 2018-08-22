<?
include "./include/library.mem.php";
require ("./include/config.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$langx=$_REQUEST['langx'];
$showtype=$_REQUEST['showtype'];
if($mtype==""){
	$mtype=3;
}
$sql = "select status,memname ,loginName,Money,language,pay_Type from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$pay_Type=$row['pay_Type'];
$status=$row['status'];
	$loginName=$row['loginName'];
	$credit=number_format($row['Money']);
	$mDate=date('m-d');

require ("include/traditional.$langx.inc.php");
switch ($showtype){
case "future":
	$style='TU';
	break;
default:
	$style='TN';
	break;
}
$paysql = "select Address from web_payment_data where Switch=1";
$payresult = mysql_query($paysql);
$payrow=mysql_fetch_array($payresult);
$address=$payrow['Address'];

switch($langx){
	case 'en-us':
		$css='_en';
		break;
	case 'zh-cn':
		$css='_cn';
		break;
	default:
		$css='';
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_header_ft<?=$css?>.css" type="text/css">
<SCRIPT language="JavaScript" src="/js/header.js"></SCRIPT>
</head>

<body id="H<?=$style?>" class="bodyset"  onLoad="SetRB('TN','<?=$uid?>');onloaded();"  >
<div style="z-index:3000;float: left; display:none;">
	<iframe id="memOnline" name="memOnline" scrolling="NO" frameborder="NO" border="0" height="500" width="800" ></iframe>
</div>
<div id="container">
  <input type="hidden" id="uid" name="uid" value="<?=$uid?>">
  <input type="hidden" id="langx" name="langx" value="<?=$langx?>">
  <div id="header"><span>
    <h1>&nbsp;</h1>
    </span></div>
<? if($showtype=='future'){?>
 <div id="welcome">
    <ul class="level1">
      <!--会员帐号-->
      <li class="name"><?=$nihao?>, <strong id="userid"><?=$loginName?></strong>
      	<div id="head_date" style="display:none;"><span id=head_year></span><?=$his_year?><span id=head_month></span><?=$his_month?><span id=head_day></span><?=$his_day?> <span id=head_hour></span>:<span id=head_min></span></div>
      </li>
      <li class="rb" id="rb_btn" style="visibility:hidden;"><a href="<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=re&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>" onClick="chg_button_bg('TN','rb');" target="body"><?=$RunningBall?></a> </li>
        
 
      
      </li>
      <li class="today" id="today_btn"><span id="todayType" style="display:none;"><?=$jrss?></span><a href="javascript:chg_button_bg('TN','today');chg_index('<?=BROWSER_IP?>/app/member/TN_header.php?uid=<?=$uid?>&showtype=&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TN_lid_type,'<?=CASINO?>');" id="todayshow" style="display:;"><?=$jrss?></a></li>
      <li class="early_on" id="early_btn"><span id="earlyType" style="display:none;"><?=$zaopan?></span><a href="#" onClick="chg_button_bg('TN','early');chg_type('<?=BROWSER_IP?>/app/member/TN_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TU_lid_type,'<?=CASINO?>');" id="earlyshow" style="display:;"><?=$zaopan?></a></li>
      <!--Live TV-->
      <li class="live_tv"><a href="#" onClick="OpenLive()" >&nbsp;</a></li>
	  <? if($pay_Type==1){ ?>
      <li class="early_on" id=""><span id="todayType" style="display:none;">在线存款</span><a href="<?=$address ?>/register.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$memname ?>"  target="body"id="todayshow" style="display:;">在线存款</a></li> 
      <li class="early_on" id=""><span id="earlyType" style="display:none;">在线提款</span><a href="<?=BROWSER_IP?>/app/member/YeePay/withdrawal.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$memname ?>" target="body" id="earlyshow" style="display:;">在线提款</a></li> 
      <li class="early_on" id=""><span id="todayType" style="display:none;">存取款记录</span><a href="<?=BROWSER_IP?>/app/member/YeePay/record.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$memname ?>" target="body" id="todayshow" style="display:;">存取款记录</a></li>
	  <? } ?>
    </ul>
    <div class="pass"><a href="#" id="chg_pwd" onClick="Go_Chg_pass();"><?=$passw?></a></div>
  </div>
  
  <!-- Today Menu Start -->  
  <div id="nav" style="display:none;">
    <ul class="level1">
      <li class="ft"><span class="ball"><a href="javascript:chg_button_bg('FT','early');chg_index('<?=BROWSER_IP?>/app/member/FT_header.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/FT_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>&showtype=future',parent.FU_lid_type,'<?=CASINO?>');"><?=$Soccer?> (<strong class="game_sum" id="FT_games"></strong>)</a></span></li>
      <li class="bk"><span class="ball"><a href="javascript:chg_button_bg('BK','early');chg_index('<?=BROWSER_IP?>/app/member/BK_header.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/BK_future/index.php?rtype=all&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.BU_lid_type,'<?=CASINO?>');"><?=$BasketBall?><span class="ball_nf"></span><?=$mszq?> (<strong class="game_sum" id="BK_games"></strong>)</a></span></li>
      <li class="tn"><span class="ball"><a href="javascript:chg_button_bg('TN','early');chg_index('<?=BROWSER_IP?>/app/member/TN_header.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/TN_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TU_lid_type,'<?=CASINO?>');"><?=$Tennis?> (<strong class="game_sum" id="TN_games"></strong>)</a></span></li>
      <li class="vb"><span class="ball"><a href="javascript:chg_button_bg('VB','early');chg_index('<?=BROWSER_IP?>/app/member/VB_header.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/VB_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.VU_lid_type,'<?=CASINO?>');"><?=$Voll?><span class="ball_bad"></span><?=$ymq?><span class="ball_tt"></span><?=$ppq?> (<strong class="game_sum" id="VB_games"></strong>)</a></span></li>
      <li class="bs"><span class="ball"><a href="javascript:chg_button_bg('BS','early');chg_index('<?=BROWSER_IP?>/app/member/BS_header.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/BS_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.BSFU_lid_type,'<?=CASINO?>');"><?=$bangqiu?> (<strong class="game_sum" id="BS_games"></strong>)</a></span></li>
      <li class="op"><span class="ball"><a href="javascript:chg_button_bg('OP','early');chg_index('<?=BROWSER_IP?>/app/member/OP_header.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/OP_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.OM_lid_type,'<?=CASINO?>');"><?=$qita?> (<strong class="game_sum" id="OP_games"></strong>)</a></span></li>
    </ul>
  </div>
  
 
  <div id="type" style="display:none;">
    <ul>
      <li class="re"><a id="re_class" class="type_out" href="javascript:void(0);" onClick="chg_type('<?=BROWSER_IP?>/app/member/TN_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TU_lid_type,'<?=CASINO?>');chg_type_class('re_class');"><?=$dd?></a></li>
      <!--li class="rb"><a href="<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=re&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>" target="body"><?=$RunningBall?></a></li-->
      <!--li class="par"><a href="<?=BROWSER_IP?>/app/member/TN_future/index.php?rtype=p&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>" target="body">标准过关</a></li-->
      <li class="hpa"><a id="hpa_class" class="type_out" href="<?=BROWSER_IP?>/app/member/TN_future/index.php?rtype=pr&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>" target="body" onClick="chg_type_class('hpa_class');"><?=$zhgg?></a></li>
      <li class="fs"><a id="fs_class" class="type_out" href="<?=BROWSER_IP?>/app/member/browse_FS/loadgame_R.php?uid=<?=$uid?>&langx=<?=$langx?>&FStype=TN&mtype=<?=$mtype?>" onClick="parent.sel_league='';parent.sel_area='';chg_type_class('fs_class');top.hot_game='';"  target="body"><?=$Guan?></a></li>
      <li class="result"><a id="result_class" class="type_out" href="<?=BROWSER_IP?>/app/member/result/result_tn.php?game_type=TN&uid=<?=$uid?>&langx=<?=$langx?>" target="body" onClick="chg_type_class('result_class');"><?=$saiguo?></a></li>
    </ul>
  </div>
  <!-- Today Menu End -->
 
   <!-- <?=$RunningBall?>Menu Start -->
   <div id="nav_re" style="display:none;">
    <ul class="level1">
      <li class="ft"><span class="ball"><a href="#" onClick="Go_RB_page('FT');chg_button_bg('FT','rb');"><?=$Soccer?> (<strong class="game_sum" id="RB_FT_games"></strong>)</a></span></li>
      <li class="bk"><span class="ball"><a href="#" onClick="Go_RB_page('BK');chg_button_bg('BK','rb');"><?=$BasketBall?><span class="ball_nf"></span><?=$mszq?> (<strong class="game_sum" id="RB_BK_games"></strong>)</a></span></li>                           
      <li class="tn"><span class="ball"><a href="#" onClick="Go_RB_page('TN');chg_button_bg('TN','rb');"><?=$Tennis?> (<strong class="game_sum" id="RB_TN_games"></strong>)</a></span></li>
      <li class="vb"><span class="ball"><a href="#" onClick="Go_RB_page('VB');chg_button_bg('VB','rb');"><?=$Voll?><span class="ball_bad"></span><?=$ymq?><span class="ball_tt"></span><?=$ppq?> (<strong class="game_sum" id="RB_VB_games"></strong>)</a></span></li>
      <li class="bs"><span class="ball"><a href="#" onClick="Go_RB_page('BS');chg_button_bg('BS','rb');"><?=$bangqiu?> (<strong class="game_sum" id="RB_BS_games"></strong>)</a></span></li>
      <li class="op"><span class="ball"><a href="#" onClick="Go_RB_page('OP');chg_button_bg('OP','rb');"><?=$qita?> (<strong class="game_sum" id="RB_OP_games"></strong>)</a></span></li>  
    </ul>
  </div>  
  
  <div id="type_re" style="display:none;">
    <ul>
	  <li class="re"><a  id="rb_class" class="type_out" href="javascript:void(0);" onClick="chg_button_bg('TN','rb');chg_type('<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=re&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TN_lid_type,''<?=CASINO?>'); chg_type_class('rb_class');"><?=$rangpandaxiao?></a></li>
      <li class="result"><a id="result_class" class="type_out" href="<?=BROWSER_IP?>/app/member/result/result.php?game_type=TN&uid=<?=$uid?>&langx=<?=$langx?>" target="body" onClick="chg_button_bg('TN','rb');chg_type_class('result_class');"><?=$saiguo?></a></li>
     </ul>
  </div>    
</div>

<? }else{?>
<div id="welcome">
    <ul class="level1">
      <!--会员帐号-->
      <li class="name"><?=$nihao?>, <strong id="userid"><?=$loginName?></strong>
      	<div id="head_date" style="display:none;"><span id=head_year></span><?=$his_year?><span id=head_month></span><?=$his_month?><span id=head_day></span><?=$his_day?> <span id=head_hour></span>:<span id=head_min></span></div>
      </li>
      <li class="rb" id="rb_btn" style="visibility:hidden;"><a href="#" onClick="chg_head('<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=re&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TN_lid_type,'<?=CASINO?>'); chg_button_bg('TN','rb');" id="rbyshow" style="display:;"><?=$RunningBall?></a>
     
 
      
      </li>
      <li class="today_on" id="today_btn"><span id="todayType" style="display:none;"><?=$jrss?></span><a href="#" onClick="chg_button_bg('TN','today');chg_type('<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TN_lid_type,'<?=CASINO?>');" id="todayshow" style="display:;"><?=$jrss?></a></li>
      <li class="early" id="early_btn"><span id="earlyType" style="display:none;"><?=$zaopan?></span><a href="javascript:chg_button_bg('TN','early');chg_index('<?=BROWSER_IP?>/app/member/TN_header.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/TN_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TU_lid_type,'<?=CASINO?>');" id="earlyshow" style="display:;"><?=$zaopan?></a></li>
      <!--Live TV-->
      <li class="live_tv"><a href="#" onClick="OpenLive()" >&nbsp;</a></li>
	  <? if($pay_Type==1){ ?>
      <li class="early_on" id=""><span id="todayType" style="display:none;">在线存款</span><a href="<?=$address ?>/register.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$memname ?>"  target="body"id="todayshow" style="display:;">在线存款</a></li> 
      <li class="early_on" id=""><span id="earlyType" style="display:none;">在线提款</span><a href="<?=BROWSER_IP?>/app/member/YeePay/withdrawal.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$memname ?>" target="body" id="earlyshow" style="display:;">在线提款</a></li> 
      <li class="early_on" id=""><span id="todayType" style="display:none;">存取款记录</span><a href="<?=BROWSER_IP?>/app/member/YeePay/record.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$memname ?>" target="body" id="todayshow" style="display:;">存取款记录</a></li>
	  <? } ?>
    </ul>
    <div class="pass"><a href="#" id="chg_pwd" onClick="Go_Chg_pass();"><?=$passw?></a></div>
  </div>
  
  <!-- Today Menu Start -->  
  <div id="nav" style="display:none;">
    <ul class="level1">
      <li class="ft"><span class="ball"><a href="javascript:chg_button_bg('FT','today');chg_index('<?=BROWSER_IP?>/app/member/FT_header.php?uid=<?=$uid?>&showtype=&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/FT_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>&showtype=',parent.FT_lid_type,'<?=CASINO?>');"><?=$Soccer?> (<strong class="game_sum" id="FT_games"></strong>)</a></span></li>
      <li class="bk"><span class="ball"><a href="javascript:chg_button_bg('BK','today');chg_index('<?=BROWSER_IP?>/app/member/BK_header.php?uid=<?=$uid?>&showtype=&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/BK_browse/index.php?rtype=r_main&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.BK_lid_type,'<?=CASINO?>');"><?=$BasketBall?><span class="ball_nf"></span><?=$mszq?> (<strong class="game_sum" id="BK_games"></strong>)</a></span></li>
      <li class="tn"><span class="ball"><a href="javascript:chg_button_bg('TN','today');chg_index('<?=BROWSER_IP?>/app/member/TN_header.php?uid=<?=$uid?>&showtype=&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TN_lid_type,'<?=CASINO?>');"><?=$Tennis?> (<strong class="game_sum" id="TN_games"></strong>)</a></span></li>
      <li class="vb"><span class="ball"><a href="javascript:chg_button_bg('VB','today');chg_index('<?=BROWSER_IP?>/app/member/VB_header.php?uid=<?=$uid?>&showtype=&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/VB_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.VB_lid_type,'<?=CASINO?>');"><?=$Voll?><span class="ball_bad"></span><?=$ymq?><span class="ball_tt"></span><?=$ppq?> (<strong class="game_sum" id="VB_games"></strong>)</a></span></li>
      <li class="bs"><span class="ball"><a href="javascript:chg_button_bg('BS','today');chg_index('<?=BROWSER_IP?>/app/member/BS_header.php?uid=<?=$uid?>&showtype=&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/BS_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.BS_lid_type,'<?=CASINO?>');"><?=$bangqiu?> (<strong class="game_sum" id="BS_games"></strong>)</a></span></li>
      <li class="op"><span class="ball"><a href="javascript:chg_button_bg('OP','today');chg_index('<?=BROWSER_IP?>/app/member/OP_header.php?uid=<?=$uid?>&showtype=&langx=<?=$langx?>&mtype=<?=$mtype?>','<?=BROWSER_IP?>/app/member/OP_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.OP_lid_type,'<?=CASINO?>');"><?=$qita?> (<strong class="game_sum" id="OP_games"></strong>)</a></span></li>
    </ul>
  </div>
    
  <div id="type" style="display:none;">
    <ul>
      <!--li class="rb"><a id="rb_class" class="type_out" href="#" onClick="chg_type('<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=re&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>',parent.TN_lid_type,'<?=CASINO?>'); chg_button_bg('TN','rb');chg_type_class('rb_class');" ><?=$RunningBall?><span class="rb_sum"> (<span class="game_sum" id="subRB_games"></span>)</span></a></li-->
      <li class="re"><a id="re_class" class="type_out" href="javascript:void(0);" onClick="chg_button_bg('TN','today');chg_type('<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>','parent.TN_lid_type','<?=CASINO?>');chg_type_class('re_class');"><?=$dd?></a></li>
   
      <!--li class="par"><a href="<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=p&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>" target="body">标准过关</a></li-->
      <li class="hpa"><a id="hpa_class" class="type_out" href="<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=pr&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>" target="body" oncLick="chg_button_bg('TN','today');chg_type_class('hpa_class');"><?=$zhgg?></a></li>
      <li class="fs"><a id="fs_class" class="type_out" href="<?=BROWSER_IP?>/app/member/browse_FS/loadgame_R.php?uid=<?=$uid?>&langx=<?=$langx?>&FStype=TN&mtype=<?=$mtype?>" onClick="chg_button_bg('TN','today');parent.sel_league='';parent.sel_area='';chg_type_class('fs_class');top.hot_game='';"  target="body"><?=$Guan?></a></li>
      <li class="result"><a id="result_class" class="type_out" href="<?=BROWSER_IP?>/app/member/result/result.php?game_type=TN&uid=<?=$uid?>&langx=<?=$langx?>" target="body" onClick="chg_button_bg('TN','today');chg_type_class('result_class');"><?=$saiguo?></a></li>
    </ul>
  </div>
  <!-- Today Menu End -->
 
  <!-- <?=$RunningBall?>Menu Start -->
  <div id="nav_re" style="display:none;">
    <ul class="level1">
      <li class="ft"><span class="ball"><a href="#" onClick="Go_RB_page('FT');chg_button_bg('FT','rb');"><?=$Soccer?> (<strong class="game_sum" id="RB_FT_games"></strong>)</a></span></li>
      <li class="bk"><span class="ball"><a href="#" onClick="Go_RB_page('BK');chg_button_bg('BK','rb');"><?=$BasketBall?><span class="ball_nf"></span><?=$mszq?> (<strong class="game_sum" id="RB_BK_games"></strong>)</a></span></li>                           
      <li class="tn"><span class="ball"><a href="#" onClick="Go_RB_page('TN');chg_button_bg('TN','rb');"><?=$Tennis?> (<strong class="game_sum" id="RB_TN_games"></strong>)</a></span></li>
      <li class="vb"><span class="ball"><a href="#" onClick="Go_RB_page('VB');chg_button_bg('VB','rb');"><?=$Voll?><span class="ball_bad"></span><?=$ymq?><span class="ball_tt"></span><?=$ppq?> (<strong class="game_sum" id="RB_VB_games"></strong>)</a></span></li>
      <li class="bs"><span class="ball"><a href="#" onClick="Go_RB_page('BS');chg_button_bg('BS','rb');"><?=$bangqiu?> (<strong class="game_sum" id="RB_BS_games"></strong>)</a></span></li>
      <li class="op"><span class="ball"><a href="#" onClick="Go_RB_page('OP');chg_button_bg('OP','rb');"><?=$qita?> (<strong class="game_sum" id="RB_OP_games"></strong>)</a></span></li>  
    </ul>
  </div>  
  
  <div id="type_re" style="display:none;">
    <ul>
      <li class="re"><a id="rb_class" class="type_out" href="javascript:void(0);" onClick="chg_button_bg('TN','rb');chg_type('<?=BROWSER_IP?>/app/member/TN_browse/index.php?rtype=re&uid=<?=$uid?>&langx=<?=$langx?>&mtype=<?=$mtype?>','parent.TN_lid_type','<?=CASINO?>');chg_type_class('rb_class');"><?=$rangpandaxiao?></a></li>
      <li class="result"><a id="rb_result_class" class="type_out" href="<?=BROWSER_IP?>/app/member/result/result.php?game_type=TN&uid=<?=$uid?>&langx=<?=$langx?>" target="body" onClick="chg_button_bg('TN','rb');chg_type_class('rb_result_class');"><?=$saiguo?></a></li>
     </ul>
  </div>    
  <!-- <?=$RunningBall?>Menu End -->
</div>

<? }?>
 
    <!--主选单-->
    <div id="back">
    	<ul>
   		   <? if($langx=="zh-tw"){?>
<li class="lang_top"><a href="#"><?=$fanti?><!--[if IE 7]><!--></a><!--<![endif]-->
			<!--[if lte IE 6]><table><tr><td><![endif]-->

                <ul class="pd">
                    <li class="tw" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('zh-tw')"><?=$fanti?></a></li>
					<li class="cn" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('zh-cn')"><?=$jianti?></a></li>
                    <li class="us" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('en-us')"><?=$english?></a></li>
       	    </ul>
             <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>   		  
<? }else if($langx=="en-us"){?>
<li class="lang_top"><a href="#"><?=$english?><!--[if IE 7]><!--></a><!--<![endif]-->
			<!--[if lte IE 6]><table><tr><td><![endif]-->

                <ul class="pd">
				<li class="us" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('en-us')"><?=$english?></a></li>
				<li class="tw" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('zh-tw')"><?=$fanti?></a></li>
                <li class="cn" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('zh-cn')"><?=$jianti?></a></li>
       	    </ul>
             <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>
<? }else{ ?>
<li class="lang_top"><a href="#"><?=$jianti?><!--[if IE 7]><!--></a><!--<![endif]-->
			<!--[if lte IE 6]><table><tr><td><![endif]-->

                <ul class="pd">
                    <li class="cn" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('zh-cn')"><?=$jianti?></a></li>
                    <li class="tw" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('zh-tw')"><?=$fanti?></a></li>
                    <li class="us" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" onClick="changeLangx('en-us')"><?=$english?></a></li>
       	    </ul>
             <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>
<? }?>
           <? if($pay_Type==1){ ?>
           <li class="mail" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" OnClick="window.open('#','QA','location=no,status=no,width=800,height=600,toolbar=no,top=0,left=0,scrollbars=no,resizable=no,personalbar=yes');"><?=$lianxi?></a></li>
		   <? }else{ ?>
		   <li class="mail" onClick="OnMouseOverEvent();"><a href="javascript:void(0);" OnClick="window.open('/tpl/member/zh-cn/QA_conn.html','QA','location=no,status=no,width=783,height=428,toolbar=no,top=0,left=0,scrollbars=no,resizable=no,personalbar=yes');"><?=$lianxiz?></a></li>
		   <? } ?>
           <li class="qa" onClick="OnMouseOverEvent();"><a href="#"><?=$bangzu?><!--[if IE 7]><!--></a><!--<![endif]-->
			<!--[if lte IE 6]><table><tr><td><![endif]-->

                <ul class="pd">
                       <li class="qa_on"><a href="#"><?=$bangzu?></a></li>
                       <li class="msg"><a href="#" onClick="parent.mem_order.showMoreMsg();"><?=$gglan?></a></li>
                       <li class="roul"><a href="#" OnClick="window.open('/tpl/member/<?=$langx?>/QA_sport.html','QA','location=no,status=no,width=800,height=428,toolbar=no,top=0,left=0,scrollbars=yes,resizable=yes,personalbar=yes');"><?=$guize?></a></li>
                       <li class="wap"><a href="#" OnClick="window.open('/tpl/member/<?=$langx?>/roul_mp.html','WAP','location=no,status=no,width=680,height=500,toolbar=no,top=0,left=0,scrollbars=no,resizable=no,personalbar=yes');"><?=$zhinan?></a></li>
                       <li class="odd"><a href="#"><?=$pljs?></a></li>
         	 </ul>
             <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>
   		  <li class="home" onMouseOver="OnMouseOutEvent()"><a href="<?=BROWSER_IP?>/app/member/logout.php?uid=<?=$uid?>&langx=<?=$langx?>" target="_top"><?=$tuichu?></a></li>
	  </ul>
  </div>  
<div id="mem_box">
  <div id="mem_main"><span class="his"><a href="<?=BROWSER_IP?>/app/member/history/history_data.php?uid=<?=$uid?>&langx=<?=$langx?>" target="body"><?=$AccountHistory?></a></span> | <span class="wag"><a href="<?=BROWSER_IP?>/app/member/today/today_wagers.php?uid=<?=$uid?>&langx=<?=$langx?>" target="body"><?=$WagerCondition1?></a></span></div>
  <div id="credit_main"><span id="credit"></span>
    <input name="" type="button" class="re_credit" value="" onClick="javascript:reloadCrditFunction();">
  </div>
</div>

<div id="extra2"><a href="http://ba566_mem.cvssp.com/app/member/mem_add.php?langx=<?=$langx?>" target="_blank"></a></div>
<iframe id="reloadPHP" name="reloadPHP"  width="0" height="0"></iframe>
<? include("huihua/chat_member.inc.php"); ?>
<iframe id="reloadPHP" name="reloadPHP1" src="reloadCredit.php?uid=<?=$uid?>&langx=<?=$langx?>"  width="0" height="0"></iframe>
<iframe id=memOnline name=memOnline  width=0 height=0></iframe> 
</body>
</html>
<? mysql_close();?>