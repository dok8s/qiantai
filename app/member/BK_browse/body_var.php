<?php
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$sorttype=$_REQUEST['sorttype'];
if($sorttype==""){
	$sorttype="T";
}
$rtype=$_REQUEST['rtype'];
$langx   = $_REQUEST['langx'];
$page_no=$_REQUEST['page_no']+0;
$league_id=$_REQUEST['league_id'];

$sql = "select Memname,Money,OpenType,language from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
	$open    = $row['OpenType'];
	
	$memname = $row['Memname'];
	$credit  = $row['Money'];

//userlog($memname);
	require ("../include/traditional.$langx.inc.php");
	$dtime=date('Y-m-d H:i:s');
	$sql="update web_member set active='$dtime' where Oid='$uid' and Oid<>''";
	mysql_db_query($dbname,$sql);
	$mDate=date('m-d');
	$K=0;
	$mysql = "select * from web_system";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	switch($langx){
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		$la="en";
		$mima='Plaese input username/passwd and tryagain';
		break;
	case "zh-tw":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		$la="tw";
		$mima='密碼錯誤次數過多';
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		$la="cn";
		$mima='密码错误次数过多';
		break;
	}
	$b_http=$row['Old_http'];
	
	$base_url = "".$site."/app/member/BK_browse/index.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype";
	$filename="".$site."/app/member/BK_browse/body_var.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype&league_id=$league_id&page_no=".$page_no;
	$curl = &new Curl_HTTP_Client();
	$curl->store_cookies("cookies.txt"); 
	$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	$curl->set_referrer($base_url);
	$meg=$curl->fetch_url($filename);
	$meg=str_replace('_.','parent.',$meg);
	$meg=str_replace('parent.GameFT=new Array();','',$meg);
	$meg=str_replace('parent.GameHead = new Array','',$meg);
	$meg=str_replace('g([','Array(',$meg);
	$meg=str_replace('])',')',$meg);
	$pb=explode('t_page=',$meg);
	$pb=explode(';',$pb[1]);
	$t_page=$pb[0];
	$gamount1=explode('gamount=',$meg);
	$gamount1=explode(';',$gamount1[1]);
	$gamount1=$gamount1[0];

	$gameCount=explode('gameCount=',$meg);
	$gameCount=explode(';',$gameCount[1]);
	$gameCount=$gameCount[0];
	
	
	preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
	$cou=$gamount1;
	
	$gameCount=explode('gameCount=',$meg);
	$gameCount=explode(';',$gameCount[1]);
	$gameCount=$gameCount[0];
?>
<HEAD><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<SCRIPT language=JavaScript>
<!--
if(self == top) location='<?=BROWSER_IP?>/app/member/'
parent.flash_ior_set='Y';
parent.username='<?=$memname?>';
parent.maxcredit='<?=$credit?>';
parent.code='H(RMB)';
parent.uid='<?=$uid?>';
parent.msg='<?=$mem_msg?>';
parent.ltype='3';
parent.str_even = '<?=$Draw?>';
parent.str_submit = '<?=$Confirm?>';
parent.str_reset = '<?=$Resets?>';
parent.langx='<?=$langx?>';
parent.rtype='<?=$rtype?>';
parent.sel_lid='<?=$league_id?>';
top.today_gmt = '<?php echo date('Y-m-d');?>';
top.now_gmt = '<?php echo date('H:i:s');?>';
parent.GameFT=new Array();
parent.gameCount=<?=$gameCount?>;
top.SortType='<?=$sorttype?>';
parent.clean_data_sw='N';
parent.game_more=1;
parent.retime_flag = 'Y';
parent.gameCount=<?=$gameCount?$gameCount:0;?>;
<?
	

if($rtype=='r_all' or $rtype=='r_sub' or $rtype=='r_no' or $rtype=='r_main'){
	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','ior_MH','ior_MC','ior_MN','str_odd','str_even','ior_EOO','ior_EOE','ratio_ouho','ratio_ouhu','ior_OUHO','ior_OUHU','ratio_ouco','ratio_oucu','ior_OUCO','ior_OUCU','more','eventid','hot','center_tv','play','gidm','isMaster');\n";
	echo "parent.retime=180;\n";
	echo "parent.minlimit_VAR=''\n";
	echo "parent.maxlimit_VAR=''\n";
	echo "parent.g_date = '';\n";
	echo "parent.str_renew = '$udpsecond';\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.gamount=$cou;\n";

	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");
		
		if ($datainfo[11]<>''){
			$mb_dime=str_replace('O','',$datainfo[11]);
			$mb_dime=str_replace('','',$mb_dime);
		}
		$datainfo1[22]=str_replace('O','',$datainfo[22]);
		$datainfo1[23]=str_replace('U','',$datainfo[23]);
		$datainfo1[26]=str_replace('O','',$datainfo[26]);
		$datainfo1[27]=str_replace('U','',$datainfo[27]);
		
		$sql = "update bask_match set m_letb='$datainfo[8]',mb_dime_rate='$datainfo[13]',tg_dime_rate='$datainfo[14]',m_dime='$mb_dime',ShowType='$datainfo[7]',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',s_single='$datainfo[20]',s_double='$datainfo[21]',ior_MH='$datainfo[15]',ior_MC='$datainfo[16]',ior_MN='$datainfo[17]',ratio_ouho='$datainfo1[22]',ratio_ouhu='$datainfo1[23]',ior_ouho='$datainfo[24]',ior_ouhu='$datainfo[25]',ratio_ouco='$datainfo1[26]',ratio_oucu='$datainfo1[27]',ior_ouco='$datainfo[28]',ior_oucu='$datainfo[29]' where MID=$datainfo[0]";
		mysql_db_query($dbname, $sql);

		$datainfo[9]=change_rate($open,$datainfo[9]);
		$datainfo[10]=change_rate($open,$datainfo[10]);
		$datainfo[13]=change_rate($open,$datainfo[13]);
		$datainfo[14]=change_rate($open,$datainfo[14]);
		
		if ($datainfo[20]<>''){
			$datainfo[20]=number_format(change_rate($open,$datainfo[20]),2);
			$datainfo[21]=number_format(change_rate($open,$datainfo[21]),2);
			$Odd1=$Odd;
			$Even1=$Even;
		}else{
			$Odd1='';
			$Even1='';
		}
		
		$dtime=match_start($datainfo[1]);
			$datainfo[1]=str_ireplace("Running Ball",$RunningBall,$datainfo[1]);
		
			echo "parent.GameFT[$K]= new Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$Odd1','$Even1','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]');\n";
			$K=$K+1;
	}
}
if($rtype=='re_all' or $rtype=='re_sub' or $rtype=='re_no' or $rtype=='re_main'){
	echo "parent.retime=30;\n";
	echo "parent.g_date = '';\n";
	echo "parent.str_renew = '$udpsecond';\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.gamount=$cou;\n";
	echo "parent.minlimit_VAR=''\n";
	echo "parent.maxlimit_VAR=''\n";
	echo "parent.GameHead = new Array('gid','timer','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','no1','no2','no3','score_h','score_c','no4','no5','no6','no7','no8','no9','no10','no11','no12','ior_MH','ior_MC','str_odd','str_even','ior_EOO','ior_EOE','ratio_ouho','ratio_ouhu','ior_OUHO','ior_OUHU','ratio_ouco','ratio_oucu','ior_OUCO','ior_OUCU','eventid','hot','center_tv','play','datetime','retimeset','more','gidm','isMaster','nowSession','scoreH','scoreC','lastGoal','lastTime');\n";
	
	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");
		$mb_dime=str_replace('O','',$datainfo[11]);
		$datainfo1[35]=str_replace('O','',$datainfo[35]);
		$datainfo1[36]=str_replace('U','',$datainfo[36]);
		$datainfo1[39]=str_replace('O','',$datainfo[39]);
		$datainfo1[40]=str_replace('U','',$datainfo[40]);
		$sql = "update bask_match set uptime='".date('Y-m-d H:i:s')."',m_letb='$datainfo[8]',mb_dime_rate='$datainfo[13]',tg_dime_rate='$datainfo[14]',m_dime='$mb_dime',ShowType='$datainfo[7]',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',re_show=1,ior_MH='$datainfo[29]',ior_MC='$datainfo[30]',ratio_ouho='$datainfo1[35]',ratio_ouhu='$datainfo1[36]',ior_ouho='$datainfo[37]',ior_ouhu='$datainfo[38]',ratio_ouco='$datainfo1[39]',ratio_oucu='$datainfo1[40]',ior_ouco='$datainfo[41]',ior_oucu='$datainfo[42]' where MID=$datainfo[0]";
	
		mysql_db_query($dbname, $sql);
		$datainfo[9]=change_rate($open,$datainfo[9]);
		$datainfo[10]=change_rate($open,$datainfo[10]);
		$datainfo[13]=change_rate($open,$datainfo[13]);
		$datainfo[14]=change_rate($open,$datainfo[14]);
		if ($datainfo[17]<>''){
			$datainfo[17]=number_format(change_rate($open,$datainfo[17]),2);
			$datainfo[18]=number_format(change_rate($open,$datainfo[18]),2);
			$Odd1=$Odd;
			$Even1=$Even;
		}else{
			$Odd1='';
			$Even1='';
		}
		echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$Odd1','$Even1','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]','$datainfo[38]','$datainfo[39]','$datainfo[40]','$datainfo[41]','$datainfo[42]','$datainfo[43]','$datainfo[44]','$datainfo[45]','$datainfo[46]','$datainfo[47]','$datainfo[48]','$datainfo[49]','$datainfo[50]','$datainfo[51]','$datainfo[52]','$datainfo[53]','$datainfo[54]','$datainfo[55]','$datainfo[56]');\n";
		$K=$K+1;
	}
}
if($rtype=="p3"){
	echo "parent.t_page=$t_page;\n";
	echo "parent.retime=180;\n";
	echo "parent.gamount=$cou;\n";
	echo "parent.minlimit_VAR='0';\n";
	echo "parent.maxlimit_VAR='0';\n";
	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_PRH','ior_PRC','ratio_o','ratio_u','ior_POUC','ior_POUH','ior_PO','ior_PE','ior_MH','ior_MC','ior_MN','more','gidm','par_minlimit','par_maxlimit');\n";
	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		//$messages=iconv("UTF-8","BIG5//IGNORE",$messages);
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");
		$datainfo[9]=change_rate($open,$datainfo[9]);
		$datainfo[10]=change_rate($open,$datainfo[10]);
		$datainfo[13]=change_rate($open,$datainfo[13]);
		$datainfo[14]=change_rate($open,$datainfo[14]);
		$m_dime=str_replace('O','',$datainfo[11]);
		
		$sql = "update bask_match set MB_PR_LetB_rate='$datainfo[9]',TG_PR_letb_rate='$datainfo[10]',m_dime='$m_dime',MB_PR_Dime_Rate='$datainfo[13]',TG_PR_Dime_Rate='$datainfo[14]',m_letb='$datainfo[8]',gidm='$datainfo[21]',par_minlimit='$datainfo[22]',par_maxlimit='$datainfo[23]',PR_Show=1 where MID=$datainfo[0]";
		mysql_db_query($dbname,$sql) or die(error);
		
		$dtime=match_start($datainfo[1]);
		if($dtime>date("Y-m-d H:i:s")){
			$datainfo[1]=str_ireplace("Running Ball",$RunningBall,$datainfo[1]);
			echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]');\n";
			$K=$K+1;
		}
	}
}
mysql_close();
?>
//

function onLoad(){
	if(parent.retime > 0)
		parent.retime_flag='Y';
	else
		parent.retime_flag='N';
	parent.loading_var = 'N';
	
	if(parent.loading == 'N' && parent.ShowType != ''){
		parent.ShowGameList();
		//parent.body_browse.document.all.LoadLayer.style.display = 'none';
	}
	
}

</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad();">

</body>
</html>

