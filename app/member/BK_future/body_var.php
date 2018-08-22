<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$g_date=$_REQUEST['g_date'];
$page_no=$_REQUEST['page_no'];
$sql = "select Memname,Money,OpenType,language from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	/*echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;*/
}else{
	$open    = $row['OpenType'];
	$langx   = $row['language'];
	$memname = $row['Memname'];
	$credit  = $row['Money'];

	require ("../include/traditional.$langx.inc.php");
	
	$mDate=date('m-d');

if($g_date==""){
$g_date="ALL";
}

?>
<HEAD><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<SCRIPT language=JavaScript>

//if(self == top) location='<?=BROWSER_IP?>/app/member/'
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
top.today_gmt = '<?php echo date("Y-m-d"); ?>';
top.now_gmt='<?php echo date("H:i:s"); ?>';
parent.g_date = '<?=$g_date?>';
<?
	$mysql = "select * from web_system";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
	switch($langx){
	case "en-us":
		$suid=$row['uid_en'];
		$site=$row['datasite_en'];
		break;
	case "zh-tw":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		break;
	}
	switch($rtype){
		case "r":
			$rtype1='r_main';
			break;
		case "all":
			$rtype1='r_all';
			break;
		case "rq4":
			$rtype1='re_sub';
			break;
		case "p3":
			$rtype1='p3';
			break;
	}
	$base_url = "".$site."/app/member/BK_future/index.php?rtype=$rtype1&uid=$suid&langx=$langx&mtype=$mtype";
	$filename="".$site."/app/member/BK_future/body_var.php?rtype=$rtype1&uid=$suid&langx=$langx&mtype=$mtype&g_date=$g_date&league_id=$league_id&page_no=".$page_no;
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
	preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
	$gamount1=explode('gamount=',$meg);
	$gamount1=explode(';',$gamount1[1]);
	$cou=$gamount1[0];
	$gameCount=explode('gameCount=',$meg);
	$gameCount=explode(';',$gameCount[1]);
	$gameCount=$gameCount[0];
	if($gameCount=='' or $gameCount<0){
		$gameCount=0;
	}
	echo "parent.gameCount=$gameCount;\n";
	$K=0;
switch ($rtype){
case "all":
	echo "parent.retime=180;\n";
	echo "parent.str_renew = '$udpsecond';\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.gamount=$cou;\n";
	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','str_odd','str_even','ior_EOO','ior_EOE','more','eventid','hot','play');\n";
	
	for($i=0;$i<$cou;$i++){
		$mb_dime1='';
		$tg_dime1='';
		$mb_dime1_tw='';
		$tg_dime1_tw='';
		$mb_dime1_en='';
		$tg_dime1_en='';
		$tg_dime=str_replace('p','',$datainfo[12]);

		$messages=$matches[0][$i];

		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");

		$datainfo[15]=str_replace("$Odd","",$datainfo[15]);
		$datainfo[16]=str_replace("$Even","",$datainfo[16]);


		if ($datainfo[11]<>''){
			$mb_dime=str_replace('','',$datainfo[11]);
	
			$mb_dime=str_replace('O','',$mb_dime);
			$mb_dime=str_replace('j','',$mb_dime);
	
			$tg_dime=str_replace('p','',$datainfo[12]);
			$tg_dime=str_replace('小','',$tg_dime);
			$tg_dime=str_replace('U','',$tg_dime);
	
	
			$mb_dime1=''.$mb_dime;
			$mb_dime1_en='O'.$mb_dime;
			$mb_dime1_tw='j'.$mb_dime;
	
			$tg_dime1_tw='p'.$tg_dime;
			$tg_dime1='小'.$tg_dime;
			$tg_dime1_en='U'.$tg_dime;

		}
		
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
		echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$Odd1','$Even1','$datainfo[20]','$datainfo[21]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[34]');\n";
		$K=$K+1;
	}
	break;
case "r":
	echo "parent.retime=180;\n";
	echo "parent.str_renew = '$udpsecond';\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.gamount=$cou;\n";
	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','str_odd','str_even','ior_EOO','ior_EOE','more','eventid','hot','play');\n";

	for($i=0;$i<$cou;$i++){
		$mb_dime1='';
		$tg_dime1='';
		$mb_dime1_tw='';
		$tg_dime1_tw='';
		$mb_dime1_en='';
		$tg_dime1_en='';
		$tg_dime=str_replace('p','',$datainfo[12]);

		$messages=$matches[0][$i];

		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");

		$datainfo[15]=str_replace("$Odd","",$datainfo[15]);
		$datainfo[16]=str_replace("$Even","",$datainfo[16]);


		if ($datainfo[11]<>''){
			$mb_dime=str_replace('','',$datainfo[11]);
	
			$mb_dime=str_replace('O','',$mb_dime);
			$mb_dime=str_replace('j','',$mb_dime);
	
			$tg_dime=str_replace('p','',$datainfo[12]);
			$tg_dime=str_replace('小','',$tg_dime);
			$tg_dime=str_replace('U','',$tg_dime);
	
	
			$mb_dime1=''.$mb_dime;
			$mb_dime1_en='O'.$mb_dime;
			$mb_dime1_tw='j'.$mb_dime;
	
			$tg_dime1_tw='p'.$tg_dime;
			$tg_dime1='小'.$tg_dime;
			$tg_dime1_en='U'.$tg_dime;

		}
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
		echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$Odd1','$Even1','$datainfo[20]','$datainfo[21]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[34]');\n";
		$K=$K+1;
	}
	break;
case "rq4":
echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','str_odd','str_even','ior_EOO','ior_EOE','more','eventid','hot','play');\n";
	echo "parent.retime=180;\n";
	echo "parent.str_renew = '$udpsecond';\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.gamount=$cou;\n";

	for($i=0;$i<$cou;$i++){
		$mb_dime1='';
		$tg_dime1='';
		$mb_dime1_tw='';
		$tg_dime1_tw='';
		$mb_dime1_en='';
		$tg_dime1_en='';
		$tg_dime=str_replace('p','',$datainfo[12]);

		$messages=$matches[0][$i];

		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");

		$datainfo[15]=str_replace("$Odd","",$datainfo[15]);
		$datainfo[16]=str_replace("$Even","",$datainfo[16]);


		if ($datainfo[11]<>''){
			$mb_dime=str_replace('','',$datainfo[11]);
	
			$mb_dime=str_replace('O','',$mb_dime);
			$mb_dime=str_replace('j','',$mb_dime);
	
			$tg_dime=str_replace('p','',$datainfo[12]);
			$tg_dime=str_replace('小','',$tg_dime);
			$tg_dime=str_replace('U','',$tg_dime);
	
	
			$mb_dime1=''.$mb_dime;
			$mb_dime1_en='O'.$mb_dime;
			$mb_dime1_tw='j'.$mb_dime;
	
			$tg_dime1_tw='p'.$tg_dime;
			$tg_dime1='小'.$tg_dime;
			$tg_dime1_en='U'.$tg_dime;

		}
		$sql = "update bask_match set m_letb='$datainfo[8]',mb_dime_rate='$datainfo[13]',tg_dime_rate='$datainfo[14]',mb_dime='$mb_dime1',mb_dime_tw='$mb_dime1_tw',mb_dime_en='$mb_dime1_en',tg_dime='$tg_dime1',tg_dime_tw='$tg_dime1_tw',tg_dime_en='$tg_dime1_en',ShowType='$datainfo[7]',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',s_single='$datainfo[17]',s_double='$datainfo[18]' where MID=$datainfo[0]";
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
		echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$Odd1','$Even1','$datainfo[20]','$datainfo[21]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[34]');\n";
		$K=$K+1;
	}
	break;
case "p3":
	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_PRH','ior_PRC','ratio_o','ratio_u','ior_POUC','ior_POUH','gidm','par_minlimit','par_maxlimit');\n";
	echo "parent.retime=0;\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.gamount=$cou;\n";
	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];

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
		
		echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[21]','$datainfo[22]','$datainfo[23]');\n";
		$K=$K+1;	
	}
	break;
}
?>
//

 function onLoad()
 {
  if(parent.retime > 0)
   parent.retime_flag='Y';
  else
   parent.retime_flag='N';
  parent.loading_var = 'N';

  if(parent.loading == 'N' && parent.ShowType != '')
  {
   parent.ShowGameList();
//   parent.body_browse.document.all.LoadLayer.style.display = 'none';
  }
 }

</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad();"</body>
</html>
<?
}
mysql_close();
?>
