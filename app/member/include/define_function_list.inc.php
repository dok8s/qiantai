<?
function cp1252_utf8($val){
	return mb_convert_encoding($val, "cp1252", "utf8");
}
function utf8_cp1252($val){
	return mb_convert_encoding($val, "utf8", "cp1252");
}


function wagers_log($sql){
   $dir_date="D:/apmz/tmp/".date("Y-m-d",time());
   $file_date=date("H",time());
   if(!is_dir($dir_date)){mkdir($dir_date,0777);}
   $file_log=fopen($dir_date."/".$file_date.".txt","a");
   fwrite($file_log,$sql."\n");
   fclose($file_log);
}


function is_utf8($liehuo_net) 
{ 
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$liehuo_net) == true) { 
		return true; 
	} 
	else 
	{ 
		return false; 
	}
}

function  get_other_ioratio($odd_type, $iorH, $iorC , $showior){
	if($iorH!="" ||$iorC!=""){
		$out =chg_ior($odd_type,$iorH,$iorC,$showior);
	}else{
		$out[0]=$iorH;
		$out[1]=$iorC;
	}
	return $out;
}
/**
 * 转换赔率
 * @param odd_f
 * @param $H_ratio
 * @param $C_ratio
 * @param showior
 * @return
 */
function chg_ior($odd_f,$iorH,$iorC,$showior){
	if($iorH < 3) $iorH *=1000;
	if($iorC < 3) $iorC *=1000;
	#$iorH=parseFloat($iorH);
	#$iorC=parseFloat($iorC);
	
	switch($odd_f){
	case "H":	//香港盘
		$ior = get_HK_ior($iorH,$iorC);
		break;
	case "M":	//马来盘
		$ior = get_MA_ior($iorH,$iorC);
		break;
	case "I" :	//欧洲盘
		$ior = get_IND_ior($iorH,$iorC);
		break;
	case "E":	//印尼盘
		$ior = get_EU_ior($iorH,$iorC);
		break;
	default:	//香港盘
		$ior[0]=$iorH ;
		$ior[1]=$iorC ;
	}
	$ior[0]=number_format(intval($ior[0]/10)/100,3,'.','');
	$ior[1]=number_format(intval($ior[1]/10)/100,3,'.','');
	
	return $ior;
}

/**
 * 换算成输水盘赔率
 * @param $H_ratio
 * @param $C_ratio
 * @return
 */
function get_HK_ior( $H_ratio, $C_ratio){
	//var $out_ior=new Array();
	if ($H_ratio <= 1000 && $C_ratio <= 1000){
		$out_ior[0]=$H_ratio;
		$out_ior[1]=$C_ratio;
		return $out_ior;
	}
	$line=2000 - ( $H_ratio + $C_ratio );
	if ($H_ratio > $C_ratio){ 
		$lowRatio=$C_ratio;
		$nowType = "C";
	}else{
		$lowRatio = $H_ratio;
		$nowType = "H";
	}
	if (((2000 - $line) - $lowRatio) > 1000){
		//对盘马来盘
		$nowRatio = ($lowRatio + $line) * (-1);
	}else{
		//对盘香港盘
		$nowRatio=(2000 - $line) - $lowRatio;	
	}
	if ($nowRatio < 0){
		$highRatio = abs(1000 / $nowRatio) * 1000;
	}else{
		$highRatio = (2000 - $line - $nowRatio) ;
	}
	if ($nowType == "H"){
		$out_ior[0]=$lowRatio;
		$out_ior[1]=$highRatio;
	}else{
		$out_ior[0]=$highRatio;
		$out_ior[1]=$lowRatio;
	}
	return $out_ior;
}
/**
 * 换算成马来盘赔率
 * @param $H_ratio
 * @param $C_ratio
 * @return
 */
function get_MA_ior( $H_ratio, $C_ratio){
	//var $out_ior=new Array();
	if (($H_ratio <= 1000 && $C_ratio <= 1000)){
		$out_ior[0]=$H_ratio;
		$out_ior[1]=$C_ratio;
		return $out_ior;
	}
	$line=2000 - ( $H_ratio + $C_ratio );
	if ($H_ratio > $C_ratio){ 
		$lowRatio = $C_ratio;
		$nowType = "C";
	}else{
		$lowRatio = $H_ratio;
		$nowType = "H";
	}
	$highRatio = ($lowRatio + $line) * (-1);
	if ($nowType == "H"){
		$out_ior[0]=$lowRatio;
		$out_ior[1]=$highRatio;
	}else{
		$out_ior[0]=$highRatio;
		$out_ior[1]=$lowRatio;
	}
	return $out_ior;
}
/**
 * 换算成印尼盘赔率
 * @param $H_ratio
 * @param $C_ratio
 * @return
 */
function get_IND_ior( $H_ratio, $C_ratio){
	//var $out_ior=new Array();
	$out_ior = get_HK_ior($H_ratio,$C_ratio);
	$H_ratio=$out_ior[0];
	$C_ratio=$out_ior[1];
	$H_ratio /= 1000;
	$C_ratio /= 1000;
	if($H_ratio < 1){
		$H_ratio=(-1) / $H_ratio;
	}
	if($C_ratio < 1){
		$C_ratio=(-1) / $C_ratio;
	}
	$out_ior[0]=$H_ratio*1000;
	$out_ior[1]=$C_ratio*1000;
	return $out_ior;
}
/**
 * 换算成欧洲盘赔率
 * @param $H_ratio
 * @param $C_ratio
 * @return
 */
function get_EU_ior($H_ratio, $C_ratio){
	//var $out_ior=new Array();
	$out_ior = get_HK_ior($H_ratio,$C_ratio);
	$H_ratio=$out_ior[0];
	$C_ratio=$out_ior[1];       
	$out_ior[0]=$H_ratio+1000;
	$out_ior[1]=$C_ratio+1000;
	return $out_ior;
}




function maxgold($top,$rate){

	return $rate<=1?$top:(int)($top/($rate*100))*100;

}


function wager_finish($langx){

	if($langx=='zh-cn'){
		$OrderSucc = '请至交易状况查询';
	}else if($langx=='zh-tw'){
		$OrderSucc = '請至交易狀況查詢';
	}else{
		$OrderSucc = 'Stake Placed"to check your wager!!!';
	}
	echo "<script language=javascript>window.setTimeout('sendsubmit()',500);function sendsubmit(){alert('".$OrderSucc."');}</script>";
	exit;
}
function wager_finish_re($langx){

	if($langx=='zh-cn'){
		$OrderSucc = '请至交易状况查询';
	}else if($langx=='zh-tw'){
		$OrderSucc = '請至交易狀況查詢';
	}else{
		$OrderSucc = 'Stake Placed"to check your wager!!!';
	}
		echo "<script language=javascript>window.setTimeout('sendsubmit()',500);function sendsubmit(){alert('".$OrderSucc."');}</script>";

	exit;
}
function chk_pwd($str=''){
	$r=0;
	$len=strlen($str);
	if($len<6 || $len>12){
		$r=1;
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script>
  alert(\'⊕密码必须至少4个字符，最多12个字符，并只能有数字(0-9)，及英文大小字母 \‘)
</script>
<script>
   history.go(-1);</script>';
		exit;
	}
}
function wager_danger($uid,$dbname){
	$cou1=count(explode('_order_',$_SERVER["REQUEST_URI"]));
	$cou2=count(explode('_index.php',$_SERVER["HTTP_REFERER"]));
	$cou3=count(explode('_browse.php',$_SERVER["HTTP_REFERER"]));

	if($cou3==2 || $cou2==2){
		$sql="update web_member set cancel=0 where Oid='$uid' and oid<>''";
	}else{
		$sql="update web_member set cancel=1 where Oid='$uid' and oid<>''";
	}

	mysql_query($sql) or die ("执行失败!");
}

function wager_order($uid,$langx){
	echo "<script language=javascript>
			window.location.href='".BROWSER_IP."/app/member/wager_finish.php?uid=$uid&styleID=BLUE&LS=s&str_meta=$langx&msgStr=';
	</script>";
	exit;
}

function wager_order_p3($uid,$langx,$msg){
	$msg=urlencode($msg);
	echo "<script language=javascript>
			window.location.href='".BROWSER_IP."/app/member/wager_finish.php?uid=$uid&styleID=BLUE&LS=p&str_meta=$langx&msgStr=$msg';
	</script>";
	exit;
}

function wager_order_pr($langx){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=$langx'>
	<script language=javascript>
		window.showModalDialog('/app/member/wager_finish.php?styleID=BLUE&LS=p&str_meta=$langx', '', 'dialogHeight=130px;dialogWidth=280px;center=yes;status=no;help=no;statusbar=no;scroll=no;');
	</script>";
	exit;
}

function order_accept($uid,$dbname){
	$cou=count(explode('_order_',$_SERVER["REQUEST_URI"]));
	if($cou==2){
		$sql = "select anop from web_system";
		$resultaaa = mysql_query($sql);
		$rowaaa = mysql_fetch_array($resultaaa);
		if($rowaaa['anop']==1){
		echo "<script>
	window.location.href='".BROWSER_IP."/app/member/wager_finish.php?titleStr=Attention&styleID=BLUE&LS=p&msgStr=系统最佳优化中，请稍后...&str_meta=zh-tw&uid=$uid&browser_ip=".BROWSER_IP."';
	</script>";
		exit;
		}
	}
}

function wterror($msg){
	$test="<html>";
	$test=$test."<head>";
	$test=$test."<title>error</title>";
	$test=$test."<meta http-equiv=Content-Type content=text/html; charset=utf-8>";
	$test=$test."<STYLE> A:visit { color=#6633cc; text-decoration: none ;}";
	$test=$test."tr {  font-family: Arial; font-size: 12px; color: #CC0000}";
	$test=$test.".b_13set {  font-size: 15px; font-family: Arial; color: #FFFFFF; padding-top: 2px; padding-left: 5px}";
	$test=$test.".b_tab {  border: 1px #000000 solid; background-color: #D2D2D2}";
	$test=$test.".b_back {  height: 20px; padding-top: 5px; color: #FFFFFF; cursor: hand; padding-left: 50px}";
	$test=$test."a:link {  color: #0000FF}";
	$test=$test."a:hover {  color: #CC0000}";
	$test=$test."a:visited {  color: #0000FF}";
	$test=$test."</STYLE>";
	$test=$test."</head>";
	$test=$test."<body text=#000000 leftmargin=0 topmargin=10 bgcolor=535E63 vlink=#0000FF alink=#0000FF>";
	$test=$test."<table width=600 border=0 cellspacing=0 cellpadding=0 align=center>";
	$test=$test."  <tr>";
	$test=$test."    <td width=36><img src=/images/member/control/error_p11.gif width=36 height=63></td>";
	$test=$test."    <td background=/images/member/control/error_p12b.gif>&nbsp;</td>";
	$test=$test."    <td width=160><img src=/images/member/control/error_p13.gif width=160 height=63></td>";
	$test=$test."  </tr>";
	$test=$test."</table>";
	$test=$test."<table width=598 border=0 cellspacing=0 cellpadding=0 align=center class=b_tab>";
	$test=$test."  <tr bgcolor=#000000> ";
	$test=$test."    <td ><img src=/images/member/control/error_dot.gif width=23 height=22></td>";
	$test=$test."    <td class=b_13set width=573>皜?nbsp;??nbsp;??nbsp;瘣</td>";
	$test=$test."  </tr>";
	$test=$test."  <tr> ";
	$test=$test."    <td colspan=2 align=center><br>";
	$test=$test."      $msg<BR><br>";
	$test=$test."      &nbsp; </td>";
	$test=$test."  </tr>";
	$test=$test."  <tr> ";
	$test=$test."    <td colspan=2>";
	$test=$test."      <table width=598 border=0 cellspacing=0 cellpadding=0 bgcolor=A0A0A0>";
	$test=$test."        <tr>";
	$test=$test."          <td>&nbsp;</td>";
	$test=$test."          <td background=/images/member/control/error_p3.gif width=120><a href=javascript:history.go(-1)><span class=b_back>?本?函?</span></a></td>";
	$test=$test."        </tr>";
	$test=$test."      </table>";
	$test=$test."    </td>";
	$test=$test."  </tr>";
	$test=$test."</table>";
	$test=$test."</body>";
	$test=$test."</html>";
	return $test;
}

function show_voucher($line,$id){

	$id=$id+1000000000;
	switch($line){
	case 4:
		$show_voucher='DT48'.substr(($id-2714),2);
		break;
	case 34:
		$show_voucher='DT48'.substr(($id-2714),2);
		break;
	case 5:
		$show_voucher='DT48'.substr(($id-2714),2);
		break;
	case 15:
		$show_voucher='DT48'.substr(($id-2714),2);
		break;
	case 17:
		$show_voucher='PM48'.substr(($id-2714),2);
		break;
	case 25:
		$show_voucher='DT48'.substr(($id-2714),2);
		break;
	case 104:
		$show_voucher='DT48'.substr(($id-2714),2);
		break;
	case 105:
		$show_voucher='DT48'.substr(($id-2714),2);
		break;
	case 6:
		$show_voucher='DT48'.substr(($id-2714),2);
		break;
	case 7:
		$show_voucher='P48'.substr(($id-88782),2);
		break;
	case 8:
		$show_voucher='PR48'.substr(($id-65782),2);
		break;
	case 14:
		$show_voucher='DT48'.substr(($id-12714),2);
	case 24:
		$show_voucher='DT48'.substr(($id-12714),2);
	case 16:
		$show_voucher='DT48'.substr(($id-12714),2);
		break;
	default:
		$show_voucher='OU48'.substr($id,2);
		break;
	}
	return $show_voucher;
}

function change_rate($c_type,$c_rate){
	switch($c_type){
	case 'A':
		$t_rate='0.03';
		break;
	case 'B':
		$t_rate='0.01';
		break;
	case 'C':
		$t_rate='0';
		break;
	case 'D':
		$t_rate='-0.01';
		break;
	}
	$change_rate=number_format($c_rate-$t_rate,2);
	if ($change_rate<=0.01){
		$change_rate='';
	}
	return $change_rate;
}

function filiter_team($repteam){
	$repteam=explode('<font color=gray>',$repteam);
	$repteam=$repteam[0];
	$repteam=trim(str_replace(" ","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#990000>-","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-","",$repteam));
	$repteam=trim(str_replace("</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#666666>","",$repteam));
	$repteam=trim(str_replace("-","",$repteam));
	$repteam=trim(str_replace("[主]","",$repteam));
	$repteam=trim(str_replace("[中]","",$repteam));
	$repteam=trim(str_replace("[中]","",$repteam));
	$repteam=trim(str_replace("[主]","",$repteam));
	$repteam=trim(str_replace("[Home]","",$repteam));
	$repteam=trim(str_replace("[Mid]","",$repteam));
	$repteam=trim(str_replace("[上半场]","",$repteam));
	$repteam=trim(str_replace("[下半场]","",$repteam));
	$repteam=trim(str_replace("[上半場]","",$repteam));
	$repteam=trim(str_replace("[下半場]","",$repteam));
	$repteam=trim(str_replace("(上半)-","",$repteam));
	$repteam=trim(str_replace("(下半)-","",$repteam));
	$repteam=trim(str_replace("(上半)","",$repteam));
	$repteam=trim(str_replace("(下半)","",$repteam));

	$repteam=trim(str_replace("(2end)","",$repteam));
	$repteam=trim(str_replace("(2ndHalf)","",$repteam));

	$repteam=trim(str_replace("(上半)","",$repteam));
	$repteam=trim(str_replace("(下半)","",$repteam));
	$repteam=trim(str_replace("[第1節]","",$repteam));
	$repteam=trim(str_replace("[第2節]","",$repteam));
	$repteam=trim(str_replace("[第3節]","",$repteam));
	$repteam=trim(str_replace("[第4節]","",$repteam));

	$repteam=trim(str_replace("[第1节]","",$repteam));
	$repteam=trim(str_replace("[第2节]","",$repteam));
	$repteam=trim(str_replace("[第3节]","",$repteam));
	$repteam=trim(str_replace("[第4节]","",$repteam));
	$repteam=trim(str_replace("[第一節]","",$repteam));
	$repteam=trim(str_replace("[第二節]","",$repteam));
	$repteam=trim(str_replace("[第三節]","",$repteam));
	$repteam=trim(str_replace("[第四節]","",$repteam));

	$repteam=trim(str_replace("[第一节]","",$repteam));
	$repteam=trim(str_replace("[第二节]","",$repteam));
	$repteam=trim(str_replace("[第三节]","",$repteam));
	$repteam=trim(str_replace("[第四节]","",$repteam));
	$repteam=trim(str_replace("[Q1]","",$repteam));
	$repteam=trim(str_replace("[Q2]","",$repteam));
	$repteam=trim(str_replace("[Q3]","",$repteam));
	$repteam=trim(str_replace("[Q4]","",$repteam));

	$repteam=trim(str_replace("[2end]","",$repteam));
	$repteam=trim(str_replace("[2ndHalf]","",$repteam));
	
	$repteam=str_replace("(上半)","",trim($repteam));
	$repteam=str_replace("(1stHalf)","",$repteam);
	
	$filiter_team=$repteam;
	return $filiter_team;
}
function filiter_team1($repteam){
	$repteam=trim(str_replace(" ","",$repteam));
	$repteam=trim(str_replace("[主]","",$repteam));
	$repteam=trim(str_replace("[中]","",$repteam));
	$repteam=trim(str_replace("[中]","",$repteam));
	$repteam=trim(str_replace("[主]","",$repteam));
	$repteam=trim(str_replace("[Home]","",$repteam));
	$repteam=trim(str_replace("[Mid]","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#990000>-[上半场]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#990000>-[下半场]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#990000>-[上半場]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#990000>-[下半場]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#666666>[上半]-</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#666666>[下半]-</font>","",$repteam));

	$repteam=trim(str_replace("<fontcolor=#990000>-[2end]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=#990000>-[2nd Half]</font>","",$repteam));

	
	$repteam=trim(str_replace("<fontcolor=gray>-[上半]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[下半]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[第1節]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[第2節]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[第3節]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[第4節]</font>","",$repteam));

	$repteam=trim(str_replace("<fontcolor=gray>-[第1节]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[第2节]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[第3节]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[第4节]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[Q1]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[Q2]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[Q3]</font>","",$repteam));
	$repteam=trim(str_replace("<fontcolor=gray>-[Q4]</font>","",$repteam));

	$repteam=trim(str_replace("<font color=gray>-[2end]</font>","",$repteam));
	$repteam=trim(str_replace("<font color=gray>-[2ndHalf]</font>","",$repteam));
	
	$filiter_team=$repteam;
	return $filiter_team;
}
function fileter0($rate){
	for($i=1;$i<strlen($rate);$i++){
		if (substr($rate, -$i, 1)<>'0'){
			if (substr($rate, -$i, 1)=='.'){
				$fileter0=substr($rate,0,strlen($rate)-$i);
			}else{
				$fileter0=substr($rate,0,strlen($rate)-$i+1);
			}
			break;
		}
	}
	return $fileter0;
}

function singleset($ptype){
	global $uid;
	require_once ("config.inc.php");
	$sql="select $ptype as p,max,setmin from web_system";
	$row = mysql_fetch_array(mysql_query($sql));
	if($row['setmin']==1){
		$sql="select $ptype as p,max from web_member where Oid='$uid'";
		$mem = mysql_fetch_array(mysql_query($sql));
		$mem['p']=intval($mem['p']);
		$mem['max']=intval($mem['max']);
		//if($mem['p']>0) $row['p']=max($row['p'],$mem['p']);
		//if($mem['max']>0) $row['max']=min($row['max'],$mem['max']);
		if($mem['p']>0)   $row['p']=$mem['p'];
		if($mem['max']>0) $row['max']=$mem['max'];
	}
	return array(intval($row['p']),intval($row['max']));
}

function set_rate($c_type){
	switch($c_type){
	case 'A':
		$t_rate='0.03';
		break;
	case 'B':
		$t_rate='0.01';
		break;
	case 'C':
		$t_rate='0';
		break;
	case 'D':
		$t_rate='-0.01';
		break;
	}
	return $t_rate;
}

function userlog($user){
   $IP_add=$_SERVER['REMOTE_ADDR'];
   /*
   $today=getdate();
   if(!is_dir(FILE_PATH."/log/user_log")){mkdir(FILE_PATH."/log/user_log",0777);}
   $dir_date=FILE_PATH."/log/user_log/".date("Y-m-d",time());
   $file_date=date("H",time());
   if(!is_dir($dir_date)){mkdir($dir_date,0777);}
   $file_log=fopen($dir_date."/user_log.".$file_date.".log","a");
   fwrite($file_log,date("i:s",time())."\t".REMOTE_ADDR."\t$user\t".$_SERVER["REQUEST_URI"]."\t".HTTP_USER_AGENT."\t".HTTP_ACCEPT_LANGUAGE."\n");
   fclose($file_log);*/
}

function mynumberformat($number, $decimals=2, $dec_point=".", $thousands_sep=""){
	return number_format($number, $decimals, $dec_point, $thousands_sep);
}

function read_file_content($FileName) 
{ 
	$fp=fopen($FileName,"r"); 
	$data=""; 
	while(!feof($fp)) 
	{ 
	$data.=fread($fp,4096); 
	} 
	fclose($fp); 
	return $data; 
} 

function match_start($dtime){
	/*蔚隙腔奀潔輛俴蛌遙*/
	$dtime=strtoupper($dtime);
	$mdate=explode('<BR>',strtoupper($dtime));
	$m_date=$mdate[0];
	$m_time=strtolower($mdate[1]);
	$hhmmstr=explode(":",$m_time);
	$hh=$hhmmstr[0];
	$ap=substr($m_time,strlen($m_time)-1,1);

	if ($ap=='p' and $hh<>12){
		$hh+=12;
	}

	$dd=explode("-",$m_date);
	if($dd[0]<>12 and date('m')==12){
		$yy=date('Y')+1;
	}else{
		$yy=date('Y');
	}
	$timestamp = $yy."-".$m_date." ".$hh.":".substr($hhmmstr[1],0,strlen($hhmmstr[1])-1).":00";
	return $timestamp;
}
// ajax 判断用户登入状态
function IsMemberAjax($uid){
	$sql = "select id,pay_type,LogIP,OpenType,language,Memname,credit,Money,date_format(logdate,'%Y-%m-%d') as logdate from web_member where Oid='$uid' and Oid<>'' and Status<>0";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		$info['state'] = 0;
		$info['msg'] = '请先登入';
		$info['do_cancel'] = 1;
		$info['url'] = '/tpl/logout_warn.html';
		echo json_encode($info);
		exit;
	}
	$row = mysql_fetch_array($result);
	return $row['Memname'];
}
// 跳转 判断用户登入状态
function IsMember($uid,$type=0){
	$sql = "select id,pay_type,LogIP,OpenType,language,Memname,credit,Money,date_format(logdate,'%Y-%m-%d') as logdate from web_member where Oid='$uid' and Oid<>'' and Status<>0";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		echo "<script>window.open('http://".$_SERVER['SERVER_NAME']."/tpl/logout_warn.html','_top')</script>";
		exit;
	}
	$row = mysql_fetch_array($result);
	if($type){
		return $row;
	}else{
		return $row['Memname'];
	}
}

//+++2018/03/22
function IsMember2($uid,$type=0){
	$sql = "select id,pay_type,LogIP,OpenType,language,loginname,credit,Money,date_format(logdate,'%Y-%m-%d') as logdate from web_member where Oid='$uid' and Oid<>'' and Status<>0";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		echo "<script>window.open('http://".$_SERVER['SERVER_NAME']."/tpl/logout_warn.html','_top')</script>";
		exit;
	}
	$row = mysql_fetch_array($result);
	if($type){
		return $row;
	}else{
		return $row['loginname'];
	}
}

function IsMember3($uid,$type=0){
	$sql = "select Money,date_format(logdate,'%Y-%m-%d') as logdate from web_member where Oid='$uid' and Oid<>'' and Status<>0";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		echo "<script>window.open('http://".$_SERVER['SERVER_NAME']."/tpl/logout_warn.html','_top')</script>";
		exit;
	}
	$row = mysql_fetch_array($result);
	if($type){
		return $row;
	}else{
		return $row['Money'];
	}
}

//$mailto='13800000000@139.com';  //收件人
//$subject="测试邮件"; //邮件主题
//$body=date('时间：Y年m月d日   H:i:s');  //邮件内容
//sendmailto($mailto,$subject,$body);
function sendmailto($mailto, $mailsub, $mailbd){
	require 'email.class.php';
	//##########################################
	$smtpserver     = "smtp.qq.com"; //SMTP服务器
	$smtpserverport = 25; //SMTP服务器端口
	$smtpusermail   = "2576766466@qq.com"; //SMTP服务器的用户邮箱
	$smtpemailto    = $mailto;
	$smtpuser       = "2576766466@qq.com"; //SMTP服务器的用户帐号
	$smtppass       = "*******"; //SMTP服务器的用户密码 (oelghewuvidybijc)
	$mailsubject    = $mailsub; //邮件主题
	$mailsubject    = "=?UTF-8?B?" . base64_encode($mailsubject) . "?="; //防止乱码
	$mailbody       = $mailbd; //邮件内容
	//$mailbody = "=?UTF-8?B?".base64_encode($mailbody)."?="; //防止乱码
	$mailtype       = "HTML"; //邮件格式（HTML/TXT）,TXT为文本邮件. 139邮箱的短信提醒要设置为HTML才正常
	##########################################
	$smtp           = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug    = true; //是否显示发送的调试信息
	$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
}
//随机生成器字符串(长度)数字+英文字母
function randomCodeStr($length){
	$key = '';
	$pattern='123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqistuvwxyz0123456789AbCdEfGhIjKlMnOpQrStUvWxYz01234567890';
	for($i=0;$i<$length;$i++){
		$key.=$pattern{mt_rand(0,35)};    //生成php随机数
	}
	$newTime=substr(time(),-4);//截取时间轴,获取后4位
	return $newTime.$key;
}
//随机数生成器(纯数字)
function randomCode($length=3){
	$key = '';
	$pattern='012345678901234567890123456789012345678909876543210';
	for($i=0;$i<$length;$i++){
		$key.=$pattern{mt_rand(0,35)};    //生成php随机数
	}
	$time=substr(time(),-3);//截取时间轴,获取后3位
	return $time.$key;
}
//邮件发送类(接收者邮件地址,邮件标题,邮件内容)
function sendMail($address,$addressName='申请人',$title,$message){
	$config=array(
		'SMTP_HOST'=>'smtp.qq.com',
		'SMTP_PORT'=>'25',
		'SMTP_USER'=>'2576766466@qq.com',
		'SMTP_PASS'=>'*******',
		'FROM_EMAIL'=>'465027687@qq.com',
		'FROM_NAME'=>'系统',
		'SMTP_ISHTML'=>1
	);
	require 'class.phpmailer.php';
	$mail=new PHPMailer();				 //建立邮件发送类
	$mail->IsSMTP();					 //使用SMTP方式发送
	$mail->CharSet='UTF-8';				 //设置发送邮件使用编码格式
	$mail->SMTPAuth=true;				 //启用SMTP验证功能
	$mail->Host=$config['SMTP_HOST'];	 //您的企业邮局SMTP域名(SMTP 服务器)可以同时设置多个主机,格式:"smtp1.example.com:25;smtp2.example.com".
	$mail->Port=$config['SMTP_PORT'];	 //SMTP服务器的端口号
	$mail->Username=$config['SMTP_USER'];//SMTP服务器用户名
	$mail->Password=$config['SMTP_PASS'];//SMTP服务器密码
	$mail->From=$config['FROM_EMAIL'];	 //发件人Email地址
	$mail->FromName=$config['FROM_NAME'];//发件人称呼
	$mail->IsHTML($config['SMTP_ISHTML']);//是否使用HTML格式
	$mail->AddAddress($address,$addressName);//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
	$mail->Subject=$title;				 //邮件主题
	$mail->Body=$message;				 //邮件正文,可以使用HTML/text,如果是HTML,会设置IsHTML为true.
	$mail->SMTPAuth=false;				 //SMTP服务器是否需要认证,使用了用户名和密码变量.
	return($mail->Send());				 //true 邮件发送成功 false 发送失败
}

?>