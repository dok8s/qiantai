<?

include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$sorttype=$_REQUEST['sorttype'];
if($sorttype==""){
	$sorttype="T";
}
$league_id=$_REQUEST['league_id'];
$page_no=$_REQUEST['page_no'];
$g_date=$_REQUEST['g_date'];
$hot_game=$_REQUEST['hot_game'];

$sql = "select id,pay_type,LogIP,OpenType,language,Memname,credit,Money,date_format(logdate,'%Y-%m-%d') as logdate from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$open    = $row['OpenType'];
	$id	  = $row['id'];
	//$langx   = $row['language'];
	$memname = $row['Memname'];
	$credit  = $row['credit'];
	$logdate=date('Y-m-d');
	if($row['logdate']<>$logdate){
		if ($row['pay_type']==0){
			$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore from web_db_io where m_date>='$logdate' and m_name='$memname' and hidden=0";
			$result1 = mysql_db_query($dbname,$sql);
			$row1 = mysql_fetch_array($result1);
			$credit=$credit-$row1['betscore'];
			if($credit<0){$credit=0;}
			$sql="update web_member set logdate=now(), money='$credit',active=now() where id=$id";
		}else{
			$dtime=date('Y-m-d H:i:s');
			$sql="update web_member set logdate=now(),active='$dtime' where Oid='$uid' and Oid<>''";
		}
	}else{
		$dtime=date('Y-m-d H:i:s');
		$sql="update web_member set active='$dtime' where Oid='$uid' and Oid<>''";
	}
	mysql_db_query($dbname,$sql);

	require ("../include/traditional.$langx.inc.php");

	if ($page_no==''){$page_no=0;}

	$rate=set_rate($open);
	$mDate=date('m-d');
	$K=0;
$pagecount=60;
if($g_date==""){
$g_date="ALL";
}
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
top.today_gmt = '<?php echo date("Y-m-d"); ?>';
top.now_gmt='<?php echo date("H:i:s"); ?>';
top.SortType='<?=$sorttype?>';
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

	$base_url = "".$site."/app/member/FT_future/index.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype";
 	$filename="".$site."/app/member/FT_future/body_var.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype&g_date=$g_date&page_no=".$page_no."&hot_game=".$hot_game."&league_id=".$league_id;
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

switch ($rtype){
case "r":
	echo "parent.t_page=$t_page;\n";
	echo "parent.str_renew = '$ManualUpdate';\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	echo "parent.game_sw=0;\n";
	echo "parent.game_more=1;\n";
	echo "parent.str_more='$play_more';\n";
	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','ior_MH','ior_MC','ior_MN','str_odd','str_even','ior_EOO','ior_EOE','hgid','hstrong','hratio','ior_HRH','ior_HRC','hratio_o','hratio_u','ior_HOUH','ior_HOUC','ior_HMH','ior_HMC','ior_HMN','more','eventid','hot','play');\n";
	if($sorttype=="T"){
		for($i=0;$i<$cou;$i++){
			$messages=$matches[0][$i];
			$messages=str_replace(");",")",$messages);
			$messages=str_replace("cha(9)","",$messages);
			$datainfo=eval("return $messages;");
	
			$m_dime=str_replace('O','',$datainfo[11]);

			$sql = "update foot_match set display=$i,ShowType='$datainfo[7]',M_LetB='$datainfo[8]',M_Dime='$m_dime',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate='$datainfo[14]',MB_Win='$datainfo[15]',TG_Win='$datainfo[16]',s_single='$datainfo[20]',s_double='$datainfo[21]',r_show=3 where MID=$datainfo[0]";
			mysql_db_query($dbname,$sql) or die(error);
	
			if($datainfo[22]<>''){
				$m_dime=str_replace('O','',$datainfo[27]);
				$sql = "update foot_match set display=$i, ShowType='$datainfo[23]',M_LetB='$datainfo[24]',M_Dime='$m_dime',MB_LetB_Rate='$datainfo[25]',TG_LetB_Rate='$datainfo[26]',TG_Dime_Rate='$datainfo[29]',MB_Dime_Rate='$datainfo[30]',r_Show=4 where MID=$datainfo[22]";
				mysql_db_query($dbname,$sql) or die(error);
			}
	
			if ($datainfo[9]<>''){
				$datainfo[9]=change_rate($open,$datainfo[9]);
				$datainfo[10]=change_rate($open,$datainfo[10]);
			}
			if ($datainfo[13]<>''){
				$datainfo[13]=change_rate($open,$datainfo[13]);
				$datainfo[14]=change_rate($open,$datainfo[14]);
			}
	
			if ($datainfo[25]<>''){
				$datainfo[25]=change_rate($open,$datainfo[25]);
				$datainfo[26]=change_rate($open,$datainfo[26]);
			}
	
			if ($datainfo[20]<>''){
				$datainfo[20]=change_rate($open,$datainfo[20]);
				$datainfo[21]=change_rate($open,$datainfo[21]);
			}
			if ($datainfo[29]<>''){
				$datainfo[29]=change_rate($open,$datainfo[29]);
				$datainfo[30]=change_rate($open,$datainfo[30]);
			}
	
			
	
			$datainfo[1]=str_ireplace("Running Ball",$RunningBall,$datainfo[1]);
				echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]');\n";
				$K=$K+1;
		}
	}else{
		$offset=$page_no*60;
		$mysql = "select moredata,more,MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font color=red>$re_red</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB,$m_league as M_League,MB_Win,TG_Win,M_Flat,if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,concat('O',m_dime) as MB_Dime,concat('U',m_dime) as TG_Dime,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,if(s_single=0,'',FORMAT(s_single-$rate,2)) as s_single,if(s_double=0,'',FORMAT(s_double-$rate,2)) as s_double from foot_match where `m_start` > now( ) and R_Show=1 AND `m_Date` >'$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1  order by  M_League_tw,M_Time,display  limit $offset,60;";
		$result = mysql_db_query($dbname, $mysql);
		while ($row=mysql_fetch_array($result)){
			$mid=$row['MID']+1;
			$sql1="select MB_Win,TG_Win,M_Flat,if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,concat('O',m_dime) as MB_Dime,concat('U',m_dime) as TG_Dime,M_LetB,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,my_play_more from foot_match where mid=".$mid;
			$result1 = mysql_db_query($dbname, $sql1);
			$row2=mysql_fetch_array($result1);
			$cou1=mysql_num_rows($result1);
			if($cou1>0){
				echo "parent.GameFT[$K]= Array('$row[MID]','$row[pdate]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[TG_Dime_Rate]','$row[MB_Dime_Rate]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$Odd','$Even','$row[s_single]','$row[s_double]','$mid','$row2[ShowType]','$row2[M_LetB]','$row2[MB_LetB_Rate]','$row2[TG_LetB_Rate]','$row2[MB_Dime]','$row2[TG_Dime]','$row2[TG_Dime_Rate]','$row2[MB_Dime_Rate]','$row2[MB_Win]','$row2[TG_Win]','$row2[M_Flat]', '".($row2[my_play_more]+0)."','$row[eventid]','$row[hot]','$row[play]');\n";
			}else{
				echo "parent.GameFT[$K]= Array('$row[MID]','$row[pdate]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[TG_Dime_Rate]','$row[MB_Dime_Rate]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$Odd','$Even','$row[s_single]','$row[s_double]','$mid','$row2[ShowType]','$row2[M_LetB]','$row2[MB_LetB_Rate]','$row2[TG_LetB_Rate]','$row2[MB_Dime]','$row2[TG_Dime]','$row2[TG_Dime_Rate]','$row2[MB_Dime_Rate]','$row2[MB_Win]','$row2[TG_Win]','$row2[M_Flat]', '".($row2[my_play_more]+0)."','$row[eventid]','$row[hot]','$row[play]');\n";
			}
			$K=$K+1;
		}
	}
	break;
case "hr":
	if ($cou>$pagecount and $league_id==''){
		$cou=$pagecount;
	}

	echo "parent.t_page=$page_count;\n";
	echo "parent.str_renew = '$ManualUpdate';\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";

	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");

		$m_dime=str_replace('O','',$datainfo[11]);

		$sql = "update foot_match set ShowType='$datainfo[7]',M_LetB='$datainfo[8]',M_Dime='$m_dime',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate='$datainfo[14]',r_show=4 where MID=$datainfo[0]";
		mysql_db_query($dbname,$sql) or die(error);

		if ($datainfo[9]<>''){
			$datainfo[9]=change_rate($open,$datainfo[9]);
			$datainfo[10]=change_rate($open,$datainfo[10]);
		}

		if ($datainfo[13]<>''){
			$datainfo[13]=change_rate($open,$datainfo[13]);
			$datainfo[14]=change_rate($open,$datainfo[14]);
		}

		$datainfo[1]=str_ireplace("Running Ball",$RunningBall,$datainfo[1]);
			echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]');\n";
			$K=$K+1;
	}
	break;
case "pd":
	
	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_H1C0','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H4C0','ior_H4C1','ior_H4C2','ior_H4C3','ior_H0C0','ior_H1C1','ior_H2C2','ior_H3C3','ior_H4C4','ior_OVH','ior_H0C1','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3','ior_H0C4','ior_H1C4','ior_H2C4','ior_H3C4','ior_OVC');\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");

		$sql = "update foot_match set MB1TG0='$datainfo[8]',MB2TG0='$datainfo[9]',MB2TG1='$datainfo[10]',MB3TG0='$datainfo[11]',MB3TG1='$datainfo[12]',MB3TG2='$datainfo[13]',MB4TG0='$datainfo[14]',MB4TG1='$datainfo[15]',MB4TG2='$datainfo[16]',MB4TG3='$datainfo[17]',MB0TG0='$datainfo[18]',MB1TG1='$datainfo[19]',MB2TG2='$datainfo[20]',MB3TG3='$datainfo[21]',MB4TG4='$datainfo[22]',OVMB='$datainfo[23]',MB0TG1='$datainfo[24]',MB0TG2='$datainfo[25]',MB1TG2='$datainfo[26]',MB0TG3='$datainfo[27]',MB1TG3='$datainfo[28]',MB2TG3='$datainfo[29]',MB0TG4='$datainfo[30]',MB1TG4='$datainfo[31]',MB2TG4='$datainfo[32]',MB3TG4='$datainfo[33]',PD_Show=3 where MID=$datainfo[0]";
		mysql_db_query($dbname,$sql) or die(error);

		echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]');\n";
		$K=$K+1;
	}
	break;
case "hpd":



	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_H1C0','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H4C0','ior_H4C1','ior_H4C2','ior_H4C3','ior_H0C0','ior_H1C1','ior_H2C2','ior_H3C3','ior_H4C4','ior_OVH','ior_H0C1','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3','ior_H0C4','ior_H1C4','ior_H2C4','ior_H3C4','ior_OVC');\n";

	echo "parent.t_page=$t_page;\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");

		$sql = "update foot_match set MB1TG0='$datainfo[8]',MB2TG0='$datainfo[9]',MB2TG1='$datainfo[10]',MB3TG0='$datainfo[11]',MB3TG1='$datainfo[12]',MB3TG2='$datainfo[13]',MB4TG0='$datainfo[14]',MB4TG1='$datainfo[15]',MB4TG2='$datainfo[16]',MB4TG3='$datainfo[17]',MB0TG0='$datainfo[18]',MB1TG1='$datainfo[19]',MB2TG2='$datainfo[20]',MB3TG3='$datainfo[21]',MB4TG4='$datainfo[22]',OVMB='$datainfo[23]',MB0TG1='$datainfo[24]',MB0TG2='$datainfo[25]',MB1TG2='$datainfo[26]',MB0TG3='$datainfo[27]',MB1TG3='$datainfo[28]',MB2TG3='$datainfo[29]',MB0TG4='$datainfo[30]',MB1TG4='$datainfo[31]',MB2TG4='$datainfo[32]',MB3TG4='$datainfo[33]',PD_Show=4 where MID=$datainfo[0]";
		mysql_db_query($dbname,$sql) or die(error);
		
		$datainfo[1]=str_ireplace("Running Ball",$RunningBall,$datainfo[1]);

		echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]');\n";
		$K=$K+1;
	}
	break;
case "t":

	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_ODD','ior_EVEN','ior_T01','ior_T23','ior_T46','ior_OVER','ior_MH','ior_MC','ior_MN');\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";

	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");

		$sql = "update foot_match set S_0_1='$datainfo[10]',S_2_3='$datainfo[11]',S_4_6='$datainfo[12]',S_7UP='$datainfo[13]',T_Show=3 where MID=$datainfo[0]";
		mysql_db_query($dbname,$sql) or die(error);


			echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]');\n";
			$K=$K+1;

	}
	
	break;
case "f":


	echo "parent.t_page=$t_page;\n";
	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_FHH','ior_FHN','ior_FHC','ior_FNH','ior_FNN','ior_FNC','ior_FCH','ior_FCN','ior_FCC');\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");
		$sql = "update foot_match set MBMB='$datainfo[8]',MBFT='$datainfo[9]',MBTG='$datainfo[10]',FTMB='$datainfo[11]',FTFT='$datainfo[12]',FTTG='$datainfo[13]',TGMB='$datainfo[14]',TGFT='$datainfo[15]',TGTG='$datainfo[16]',F_Show=3 where MID=$datainfo[0]";
		mysql_db_query($dbname,$sql) or die(error);
		echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]');\n";
		$K=$k+1;
		
	}
	
	break;

case "p3":
	

	echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_PRH','ior_PRC','ratio_o','ratio_u','ior_POUH','ior_POUC','ior_PO','ior_PE','ior_MH','ior_MC','ior_MN','ior_H1C0','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H4C0','ior_H4C1','ior_H4C2','ior_H4C3','ior_H0C0','ior_H1C1','ior_H2C2','ior_H3C3','ior_H4C4','ior_OVH','ior_H0C1','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3','ior_H0C4','ior_H1C4','ior_H2C4','ior_H3C4','ior_OVC','ior_T01','ior_T23','ior_T46','ior_OVER','ior_FHH','ior_FHN','ior_FHC','ior_FNH','ior_FNN','ior_FNC','ior_FCH','ior_FCN','ior_FCC','hgid','hstrong','hratio','ior_HPRH','ior_HPRC','hratio_o','hratio_u','ior_HPOUH','ior_HPOUC','ior_HH1C0','ior_HH2C0','ior_HH2C1','ior_HH3C0','ior_HH3C1','ior_HH3C2','ior_HH4C0','ior_HH4C1','ior_HH4C2','ior_HH4C3','ior_HH0C0','ior_HH1C1','ior_HH2C2','ior_HH3C3','ior_HH4C4','ior_HOVH','ior_HH0C1','ior_HH0C2','ior_HH1C2','ior_HH0C3','ior_HH1C3','ior_HH2C3','ior_HH0C4','ior_HH1C4','ior_HH2C4','ior_HH3C4','ior_HOVC','ior_HPMH','ior_HPMC','ior_HPMN','more','gidm','par_minlimit','par_maxlimit');\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.minlimit_VAR='3';\n";
	echo "parent.maxlimit_VAR='10';\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	echo "parent.game_sw=0;\n";
	echo "parent.game_more=1;\n";
	echo "parent.g_date = 'ALL';\n";
	echo "parent.str_more='$play_more';\n";

	for($i=0;$i<$cou;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace(");",")",$messages);
		$messages=str_replace("cha(9)","",$messages);
		$datainfo=eval("return $messages;");
		
		
		$sql = "update foot_match set MB_PR_LetB_rate='$datainfo[9]',TG_PR_letb_rate='$datainfo[10]',S_Single='$datainfo[15]',S_Double='$datainfo[16]',MB_PR_Dime_Rate='$datainfo[13]',TG_PR_Dime_Rate='$datainfo[14]',P3_Show=1,more='$datainfo[32]',gidm='$datainfo[33]',par_minlimit='$datainfo[34]',par_maxlimit='$datainfo[35]' where MID=$datainfo[0]";
		mysql_db_query($dbname,$sql);
	
			$sql = "update foot_match set MB_PR_LetB_rate='$datainfo[23]',TG_PR_letb_rate='$datainfo[24]',S_Single='$datainfo[29]',S_Double='$datainfo[30]',MB_PR_Dime_Rate='$datainfo[28]',TG_PR_Dime_Rate='$datainfo[27]',more='$datainfo[32]',gidm='$datainfo[33]',par_minlimit='$datainfo[34]',par_maxlimit='$datainfo[35]',p3_show=1 where MID=$datainfo[20]";
		mysql_db_query($dbname,$sql);
	
			echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','','','','','','','','','','','','','','','','','','','','','','','','','','','','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]');\n";
	$K=$K+1;
	
	}
	break;	
}
mysql_close();
?>

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
  }
 }

</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad();"></body>
</html>
<?
}
mysql_close();
?>

