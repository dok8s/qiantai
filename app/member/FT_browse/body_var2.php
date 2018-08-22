<?


include "../include/library.mem.php";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$history=$_REQUEST['history'];
$mdate = $_REQUEST['mdate'];
$mDate = strpos($mdate,'-') ? $mdate : date('m-d');

$league_id=intval($_REQUEST['league_id']);
$league_id = $league_id==0 ? '' : $league_id;
$sel_lid = $league_id;
$page_no=$_REQUEST['page_no']+0;

$sql = "select pay_type,LogIP,OpenType,language,Memname,credit,Money,date_format(logdate,'%Y-%m-%d') as logdate from web_member where Oid!='' and Oid='$uid' and Status<>0";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$cou=1;
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$open    = $row['OpenType'];
	$memname = $row['Memname'];
	$credit  = $row['credit'];
	$logdate=date('Y-m-d');
	if($row['logdate']<>$logdate){
		if ($row['pay_type']==0){
			$sql="select sum(betscore) as betscore from web_db_io where m_date>='$logdate' and m_name='$memname' and hidden=0";
			$result1 = mysql_query($sql);
			$row1 = mysql_fetch_array($result1);
			$credit=$credit-$row1['betscore'];
			if($credit<0){$credit=0;}
			$sql="update web_member set logdate=now(), money='$credit',active=now() where id=$id";
		}else{
			$dtime=date('Y-m-d H:i:s');
			$sql="update web_member set logdate=now(),active='$dtime' where Oid!='' and Oid='$uid'";
		}
	}else{
		$dtime=date('Y-m-d H:i:s');
		$sql="update web_member set active='$dtime' where Oid!='' and Oid='$uid'";
	}
	mysql_query($sql);

	require ("../include/traditional.zh-tw.inc.php");
	if ($league_id==''){
		$league='';
	}else{
		$league=" and ".$m_league."='".$league_id."'";
	}
	$league='';
	if ($page_no==''){$page_no=0;}
	$rate=set_rate($open);
	//$mDate=date('m-d');
	$K=0;
	$pagecount=60;
	$offset = $page_no*$pagecount;

echo "
<HEAD><TITLE>ì瞴跑计</TITLE>
<META http-equiv=Content-Type content='text/html; charset=$charset'>
<SCRIPT language=JavaScript>
<!--";
?>
if(self == top) top.location='<?=BROWSER_IP?>/app/member/'
parent.flash_ior_set='Y';
parent.minlimit_VAR='3';
parent.maxlimit_VAR='10';
parent.username='<?=$memname?>';
parent.maxcredit='<?=$credit?>';
parent.code='チ刽(RMB)';
parent.uid='<?=$uid?>';
parent.msg='<?=$mem_msg?>';
parent.ltype='3';
parent.str_even = '<?=$Draw?>';
parent.str_submit = '<?=$Confirm?>';
parent.str_reset = '<?=$Resets?>';
parent.langx='<?=$langx?>';
parent.rtype='<?=$rtype?>';
parent.sel_lid='<?=$league_id?>';
<?php
if($history=='yes' && $rtype=='re')$rtype='re2';
switch ($rtype){
case "r":
	$mysql = "select moredata,more,MID,concat(M_Date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)),if(m_type=0,'','<br><font color=red>$run</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB,$m_league as M_League,MB_Win,TG_Win,M_Flat,if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,concat('O',m_dime) as MB_Dime,concat('U',m_dime) as TG_Dime,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,if(s_single=0,'',FORMAT(s_single-$rate,2)) as s_single,if(s_double=0,'',FORMAT(s_double-$rate,2)) as s_double from foot_match where m_Date='$mDate' and (r_show=1 or r_show=11) and is_hr=0 order by m_start limit $offset,1000;";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);
	$page_count=$cou/$pagecount+$page_no;
	if ($cou>$pagecount && $sel_lid==''){
		$cou=$pagecount;
	}
	echo "parent.t_page=$page_count;\n";
	echo "parent.str_renew = '$udpsecond';\n";
	echo "parent.retime=180;\n";
	echo "parent.gamount=$cou;\n";
	echo "parent.game_sw=0;\n";
	echo "parent.game_more=1;\n";
	echo "parent.str_more='$play_more';\n";
	while ($row=mysql_fetch_array($result)){
		$moredata = @unserialize($row['moredata']);
		$mid=$row['MID']+1;
		$sql1="select if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,concat('O',m_dime) as MB_Dime,concat('U',m_dime) as TG_Dime,M_LetB,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,mb_win,tg_win,m_flat from foot_match where mid=".$mid;
		$result1 = mysql_query( $sql1);
		$row2=mysql_fetch_array($result1);
		$cou1=mysql_num_rows($result1);
		if($cou1>0){
			echo "parent.GameFT[$K]= Array('$row[MID]','$row[pdate]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[TG_Dime_Rate]','$row[MB_Dime_Rate]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$Odd','$Even','$row[s_single]','$row[s_double]','$mid','$row2[ShowType]','$row2[M_LetB]','$row2[MB_LetB_Rate]','$row2[TG_LetB_Rate]','$row2[MB_Dime]','$row2[TG_Dime]','$row2[TG_Dime_Rate]','$row2[MB_Dime_Rate]','$row2[mb_win]','$row2[tg_win]','$row2[m_flat]','$row[more]', '$moredata[35]', '$moredata[36]', '$moredata[37]');\n";
		}else{
			echo "parent.GameFT[$K]= Array('$row[MID]','$row[pdate]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[TG_Dime_Rate]','$row[MB_Dime_Rate]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$Odd','$Even','$row[s_single]','$row[s_double]','$mid','$row2[ShowType]','$row2[M_LetB]','$row2[MB_LetB_Rate]','$row2[TG_LetB_Rate]','$row2[MB_Dime]','$row2[TG_Dime]','$row2[TG_Dime_Rate]','$row2[MB_Dime_Rate]','$row2[mb_win]','$row2[tg_win]','$row2[m_flat]','$row[more]', '$moredata[35]', '$moredata[36]', '$moredata[37]');\n";
		}
		$K=$K+1;
	}
	break;
case "re2":
	$mysql = "select moredata,more,mid,m_date,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as m_time,$mb_team as mb_team,$tg_team as tg_team,m_letb,$m_league as m_league,mb_win,tg_win,m_flat,mb_dime_rate,tg_dime_rate,m_dime,mb_letb_rate,tg_letb_rate,tg_letb_rate,mb_mid,tg_mid,showtype,m_type,s_single,s_double,mb_ball,tg_ball,re_show from foot_match where date_format( m_start,'%m-%d')='$mDate' and m_type=1 and is_hr=0 and m_start<now() and mid%2=0 order by m_start limit $offset,1000";
	
$result = mysql_query( $mysql) or exit("error 882116");
	$cou=mysql_num_rows($result);

	$arrs=array();

	while ($row=mysql_fetch_array($result)){
		$moredata = @unserialize($row['moredata']);
		foreach($moredata as $k=>$v){
			$row[$k]=$v;
		}
//		echo $row['re_show'];
		//if($row['mid']%2==0) continue;

		$hrmid=$row['mid']+1;
		$result1 = mysql_query("select moredata,m_dime,mb_dime_rate,tg_dime_rate,m_letb,mb_letb_rate,tg_letb_rate,mid,mb_mid,tg_mid,showtype,mb_win,tg_win,m_flat,mb_ball,tg_ball from foot_match where mid='$hrmid'") or exit("error 882117");
		$row2=mysql_fetch_array($result1);

		if(mysql_num_rows($result1)){
			$moredata2 = @unserialize($row2['moredata']);
			foreach($moredata2 as $k=>$v){
				$row2[$k]=$v;
			}
		}

		if($row['m_letb']=='' && $row['m_dime']==''){
			$row['mb_win']='';
			$row['tg_win']='';
			$row['m_flat']='';
			$row['mb_letb_rate']='';
			$row['tg_letb_rate']='';
			$row['tg_dime_rate']='';
			$row['mb_dime_rate']='';
		}
		if($row2['m_letb']=='' && $row2['m_dime']==''){
			$row2['mb_win']='';
			$row2['tg_win']='';
			$row2['m_flat']='';
			$row2['mb_letb_rate']='';
			$row2['tg_letb_rate']='';
			$row2['tg_dime_rate']='';
			$row2['mb_dime_rate']='';
		}

		$arr=array();
		$arr[]=$row['mid'];
		$arr[]="$row[m_date]<br>$row[m_time]";
		$arr[]=$row['m_league'];
		$arr[]=$row['mb_mid'];
		$arr[]=$row['tg_mid'];
		$arr[]=$row['mb_team'];
		$arr[]=$row['tg_team'];

		$arr[]=$row['showtype']=='C' ? 'C' : 'H';
		$arr[]=$row['m_letb'];
		$arr[]=$row['mb_letb_rate'];
		$arr[]=$row['tg_letb_rate'];
		$arr[]=$row['m_dime']=='' ? '' : 'O'.$row['m_dime'];
		$arr[]=$row['m_dime']=='' ? '' : 'U'.$row['m_dime'];
		$arr[]=$row['tg_dime_rate'];
		$arr[]=$row['mb_dime_rate'];
		$arr[]=$row['rcard_h'];
		$arr[]=$row['rcard_c'];
		$arr[]=$row['null'];
		$arr[]=$row['mb_ball'];
		$arr[]=$row['tg_ball'];

		$arr[]=$row2['mid'];
		$arr[]=$row2['showtype']=='C' ? 'C' : 'H';
		$arr[]=$row2['m_letb'];
		$arr[]=$row2['mb_letb_rate'];
		$arr[]=$row2['tg_letb_rate'];
		$arr[]=$row2['m_dime']=='' ? '' : 'O'.$row2['m_dime'];
		$arr[]=$row2['m_dime']=='' ? '' : 'U'.$row2['m_dime'];
		$arr[]=$row2['tg_dime_rate'];
		$arr[]=$row2['mb_dime_rate'];
		$arr[]=$row2['mb_ball'];
		$arr[]=$row2['tg_ball'];

		$arr[]=$row['null'];
		$arr[]=$row['null'];
		$arr[]=$row['mb_win'];
		$arr[]=$row['tg_win'];
		$arr[]=$row['m_flat'];
		$arr[]=$row2['mb_win'];
		$arr[]=$row2['tg_win'];
		$arr[]=$row2['m_flat'];
		$arr[]=$row['null'];
		$arr[]=$row['null'];
		$arr[]='Y';
		$arr[]="$row[m_date]<br>$row[m_time]";
		$arrs[] = $arr;
	}

	$cou = count($arrs);
	$t_page = $cou/60+$page_no;
	$gamount = min($cou,60);
	echo "parent.retime=600;\n";
	echo "parent.str_renew = '$udpsecond';\n";
	echo "parent.t_page=$t_page;\n";
	echo "parent.gamount=$gamount;\n";
	foreach($arrs as $k=>$arr){
		echo "parent.GameFT[$k]= Array('".join("','",$arr)."');\n";
	}
	break;
case "re":
	$mysql = "select datasite,uid_tw,uid_en,runball,b2,liveid from web_system";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$runball=$row['runball'];
	echo "top.liveid = '".$row['liveid']."';";
	//echo $row['b2'];
	//if($runball==1){
		$site=$row['datasite'];
		switch($langx){
		case "en-us":
			$suid=$row['uid_en'];
			break;
		default:
			$suid=$row['uid_tw'];
			break;
		}
if($row['b2']==0){
		$base_url = "".$site."/app/member/FT_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=3";
		$thisHttp = new cHTTP();
		$thisHttp->setReferer($base_url);
		$filename="".$site."/app/member/FT_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=3";
		$thisHttp->getPage($filename);
		$msg  = $thisHttp->getContent();
//		$meg .= gzinflate(substr($msg,10));
	switch($langx)	{
	case "zh-tw":
//	    $meg .= u2b(gzinflate(substr($msg,10)));
		$meg .= mb_convert_encoding(gzinflate(substr($msg,10)),"big5","UTF-8");
	//	$meg .= u2b($msg);
		break;
	case "zh-cn":
//		$meg .= u2g($msg);
		$meg .= u2g(gzinflate(substr($msg,10)));
    //	$meg .= mb_convert_encoding(gzinflate(substr($msg,10)),"GBK","UTF-8");
        
		break;
	}
	strlen($meg)<3 && $meg=$msg;
}else{
		$base_url = "http://odds.donbase.com";
		$thisHttp = new cHTTP();
		$thisHttp->setReferer($base_url);
		$filename="http://odds.donbase.com/zh-tw/FT_re.php";
		$thisHttp->getPage($filename);
		$meg  = $thisHttp->getContent();

$tttt=explode('<HEAD>',$meg);

	$arr=@preg_split ("/[^0-9]+/",$tttt[0]);
	$y = (int)$arr[0];
	$m = (int)$arr[1];
	$d = (int)$arr[2];
	$h = (int)$arr[3];
	$i = (int)$arr[4];
	$s = (int)$arr[5];
	$s=@mktime($h,$i,$s,$m, $d, $y);

	if ((time()-$s)>30){
		$meg='';
	}
}

		preg_match_all("/Array\('(.+?)\);/is",$meg,$matches);

		//$cou=sizeof($matches[0]);

		$kk=explode('parent.gamount=',$meg);
$kk2=explode(';',$kk[1]);
$cou=$kk2[0]+0;
		if($cou>0){
			$sql="update foot_match set RE_Show=11 where RE_Show=1 and m_date='".date('m-d')."'";
			mysql_query($sql) or die ("巨ア毖!");
		}
		echo "parent.retime=60;\n";
		echo "parent.str_renew = '$udpsecond';\n";
		if ($league_id<>''){
			echo "parent.game_sw=1;\n";
			echo "parent.l_name='$league_id';\n";
		}
		$page_count=$cou/$pagecount;
		echo "parent.t_page=$page_count;\n";
		echo "parent.gamount=$cou;\n";
		$maxi = count($matches[0]);
		for($i=0;$i<$maxi;$i++){
			$messages=$matches[0][$i];
			$messages=iconv("UTF-8","BIG5//IGNORE",$messages);
			$messages=str_replace(");",")",$messages);
			$messages=str_replace("cha(9)","",$messages);
			$datainfo=eval("return $messages;");

	 		if(strlen($datainfo[1])==2){
				$status=$datainfo[1];
				if($status<46){
					$notup=1;
				}else{
					$notup=0;
				}

			}else if(strlen($datainfo[1])==6){
				$status=$datainfo[1];
				$notup=1;
			}else if(strlen($datainfo[1])>6){
				$status='H/T';
				$notup=0;
			}else{
				$status='';
				$notup=0;
			}

			$close=1;
			$m_re_dime=str_replace('O','',$datainfo[11]);
			if(trim($m_re_dime)=='0'){
					$close=0;
			}

			$sql = "update foot_match set fopen='$close',ShowType='$datainfo[7]',M_re_LetB='$datainfo[8]',M_re_Dime='$m_re_dime',MB_re_LetB_Rate='$datainfo[9]',TG_re_LetB_Rate='$datainfo[10]',TG_re_Dime_Rate='$datainfo[13]',MB_re_Dime_Rate='$datainfo[14]',mb_ball='$datainfo[18]',tg_ball='$datainfo[19]',rcard_h='$datainfo[29]',rcard_c='$datainfo[30]',RE_Show=1,mb_win='$datainfo[33]',tg_win='$datainfo[34]',m_flat='$datainfo[35]' where MID=$datainfo[0]";
			mysql_query($sql);

			$gid3=$datainfo[0]+1;
			if($notup==1){
				$m_re_dime=str_replace('O','',$datainfo[25]);

				$close=1;
				if($datainfo[25]=='O 0' or $datainfo[26]=='U 0'){
					$close=0;
				}
				$sql = "update foot_match set fopen=$close,ShowType='$datainfo[21]',M_re_LetB='$datainfo[22]',M_re_Dime='$m_re_dime',MB_re_LetB_Rate='$datainfo[23]',TG_re_LetB_Rate='$datainfo[24]',TG_re_Dime_Rate='$datainfo[27]',MB_re_Dime_Rate='$datainfo[28]',mb_ball='$datainfo[18]',TG_ball='$datainfo[19]',rcard_h='$datainfo[29]',rcard_c='$datainfo[30]',RE_Show=1,mb_win='$datainfo[36]',tg_win='$datainfo[37]',m_flat='$datainfo[38]' where MID=$gid3";
				mysql_query($sql);
			}
			if ($datainfo[9]<>''){
				$datainfo[9]=change_rate($open,$datainfo[9]);
				$datainfo[10]=change_rate($open,$datainfo[10]);
			}
			if ($datainfo[13]<>''){
				$datainfo[13]=change_rate($open,$datainfo[13]);
				$datainfo[14]=change_rate($open,$datainfo[14]);
			}

				if ($datainfo[23]<>''){
					$datainfo[23]=change_rate($open,$datainfo[23]);
					$datainfo[24]=change_rate($open,$datainfo[24]);
				}
				if ($datainfo[27]<>''){
					$datainfo[27]=change_rate($open,$datainfo[27]);
					$datainfo[28]=change_rate($open,$datainfo[28]);
				}

			$datainfo[19]=$datainfo[19]+0;
			$datainfo[18]=$datainfo[18]+0;

			if($langx=='zh-cn'){
				$datainfo[5]	=	big52gb($datainfo[5]);
				$datainfo[6]	=	big52gb($datainfo[6]);
				$datainfo[2]	=	big52gb($datainfo[2]);
				$datainfo[1]	=	big52gb($datainfo[1]);
			}
			if ($league_id<>''){
				if ($league_id==$dateinfo[2]){
					echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]','$datainfo[38]','$datainfo[39]','$datainfo[40]','$datainfo[41]','$datainfo[42]');\n";
					$K=$K+1;
				}
			}else{
				echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]','$datainfo[38]','$datainfo[39]','$datainfo[40]','$datainfo[41]','$datainfo[42]');\n";
				$K=$K+1;
			}
		}
	/*}else{
		$mysql = "select MID,M_Date,if(M_Time='H/T','<font color=red>$zhongchang</font>',m_time) as M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_re_LetB as M_LetB,$m_league as M_League,if(MB_re_Dime_Rate=0,'',FORMAT(MB_re_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_re_Dime_Rate=0,'',FORMAT(TG_re_Dime_Rate-$rate,3)) as TG_Dime_Rate,if(m_re_dime='','',concat('O ',m_re_dime)) as MB_Dime,if(m_re_dime='','',concat('U ',m_re_dime)) as TG_Dime,if(MB_re_LetB_Rate=0,'',FORMAT(MB_re_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_re_LetB_Rate=0,'',FORMAT(TG_re_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,mb_ball,tg_ball from foot_match where `m_start` < now( ) and Re_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 and mid%2=1 order by display";
		//$mysql = "select MID,M_Date,if(M_Time='H/T','<font color=red>$zhongchang</font>',m_time) as M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_re_LetB as M_LetB,$m_league as M_League,if(MB_re_Dime_Rate=0,'',FORMAT(MB_re_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_re_Dime_Rate=0,'',FORMAT(TG_re_Dime_Rate-$rate,3)) as TG_Dime_Rate,if(m_re_dime='','',concat('O ',m_re_dime)) as MB_Dime,if(m_re_dime='','',concat('U ',m_re_dime)) as TG_Dime,if(MB_re_LetB_Rate=0,'',FORMAT(MB_re_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_re_LetB_Rate=0,'',FORMAT(TG_re_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,mb_ball,tg_ball from foot_match where Re_Show=1 and mid%2=1 order by display";
		$result = mysql_query( $mysql);
		$cou=mysql_num_rows($result);
		echo "parent.str_renew = '$udpsecond';\n";
		echo "parent.retime=60;\n";
		echo "parent.gamount=$cou;\n";

		while ($row=mysql_fetch_array($result)){
			$mid=$row['MID']+1;
			$sql = "select M_re_LetB as M_LetB,$m_league as M_League,if(MB_re_Dime_Rate=0,'',FORMAT(MB_re_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_re_Dime_Rate=0,'',FORMAT(TG_re_Dime_Rate-$rate,3)) as TG_Dime_Rate,if(m_re_dime='','',concat('O ',m_re_dime)) as MB_Dime,if(m_re_dime='','',concat('U ',m_re_dime)) as TG_Dime,if(MB_re_LetB_Rate=0,'',FORMAT(MB_re_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_re_LetB_Rate=0,'',FORMAT(TG_re_LetB_Rate-$rate,3)) as TG_LetB_Rate,ShowType from foot_match where mid=$mid and Re_Show=1 order by mid";
			$result2 = mysql_query( $sql);
			$row2=mysql_fetch_array($result2);
			echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[TG_Dime_Rate]','$row[MB_Dime_Rate]','','','','$row[mb_ball]','$row[tg_ball]','$mid','$row2[ShowType]','$row2[M_LetB]','$row2[MB_LetB_Rate]','$row2[TG_LetB_Rate]','$row2[MB_Dime]','$row2[TG_Dime]','$row2[TG_Dime_Rate]','$row2[MB_Dime_Rate]','','');\n";
			$K=$K+1;
		}*/
	//}

		@include("../../../../inc/msg.re.inc.php");
	break;
case "hr":
	$mysql = "select MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font color=red>$run</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team, M_LetB,$m_league as M_League,MB_Win,TG_Win,M_Flat,if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,concat('O',m_dime) as MB_Dime,concat('U',m_dime) as TG_Dime,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,if(s_single=0,'',FORMAT(s_single-$rate,2)) as s_single,if(s_double=0,'',FORMAT(s_double-$rate,2)) as s_double from foot_match where `m_Date` ='$mDate' and (r_show=1 or r_show=11 or r_show=2 or r_show=12) and is_hr=0 order by M_Start limit $offset,1000;";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);

	$page_count=$cou/$pagecount+$page_no;
	if ($cou>$pagecount and $sel_lid==''){
		$cou=$pagecount;
	}

	echo "parent.retime=0;\n";

	echo "parent.t_page=$page_count;\n";
	echo "parent.str_renew = '$ManualUpdate';\n";
	echo "parent.game_sw=1;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]= Array('$row[MID]','$row[pdate]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[TG_Dime_Rate]','$row[MB_Dime_Rate]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]');\n";
		$K=$K+1;
	}
	break;
case "pd":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType from foot_match where (pd_show=1 or pd_show=11) AND `m_Date`='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' order by display limit $offset,1000;";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);

	$page_count=$cou/$pagecount+$page_no;
	if ($cou>$pagecount and $sel_lid==''){
		$cou=$pagecount;
	}
	echo "parent.t_page=$page_count;\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[OVMB]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','$row[OVTG]');\n";
		$K=$K+1;
		//if($K>=$cou)break;
	}
	break;
case "hpd":
	$mysql = "select MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font color=red>$run</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType from foot_match where (pd_show=2 or pd_show=12) AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' order by display limit $offset,1000;";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);

	$page_count=$cou/$pagecount+$page_no;
	if ($cou>$pagecount and $sel_lid==''){
		$cou=$pagecount;
	}

	echo "parent.t_page=$page_count;\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]= Array('$row[MID]','$row[pdate]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[OVMB]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','$row[OVTG]');\n";
		$K=$K+1;
	}
	break;
case "t":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowType,MB_Win,TG_Win,M_Flat from foot_match where (t_show=1 or t_show=11) AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' order by display limit $offset,1000;";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);

	$page_count=$cou/$pagecount+$page_no;
	if ($cou>$pagecount and $sel_lid==''){
		$cou=$pagecount;
	}

	echo "parent.t_page=$page_count;\n";
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$S_Single=change_rate($open,$row['S_Single']);
		echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$S_Single','$S_Double','$row[S_0_1]','$row[S_2_3]','$row[S_4_6]','$row[S_7UP]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]');\n";
		$K=$K+1;
	}
	break;
case "f":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG,MB_MID,TG_MID,ShowType from foot_match where (f_show=1 or f_show=11) AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' order by display limit $offset,1000;";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);

	$page_count=$cou/$pagecount+$page_no;
	if ($cou>$pagecount and $sel_lid==''){
		$cou=$pagecount;
	}

	echo "parent.t_page=$page_count;\n";
	echo "parent.gamount=$cou;\n";
	echo "parent.retime=0;\n";

	while ($row=mysql_fetch_array($result)){
		echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MBMB]','$row[MBFT]','$row[MBTG]','$row[FTMB]','$row[FTFT]','$row[FTTG]','$row[TGMB]','$row[TGFT]','$row[TGTG]','Y');\n";
		$K=$K+1;
	}
	break;
case 'p3':
	$sql1 = "select more,`MID`,`M_Date`,`M_Time`,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,`ShowType`,`MB_Win`,`TG_Win`,`M_Flat`,`M_LetB`,`MB_LetB_Rate`,`TG_LetB_Rate`,`MB_Dime_Rate`,`TG_Dime_Rate`,`M_RE_LetB`,`MB_RE_LetB_Rate`,`TG_RE_LetB_Rate`,`M_RE_Dime`,`MB_RE_Dime_Rate`,`TG_RE_Dime_Rate`,`S_Single`,`S_Double`,`S_0_1`,`S_2_3`,`S_4_6`,`S_7UP`,`MB1TG0`,`MB2TG0`,`MB0TG1`,`MB0TG2`,`MB2TG1`,`MB1TG2`,`MB3TG0`,`MB0TG3`,`MB3TG1`,`MB1TG3`,`MB3TG2`,`MB2TG3`,`MB4TG0`,`MB0TG4`,`MB4TG1`,`MB1TG4`,`MB4TG2`,`MB2TG4`,`MB4TG3`,`MB3TG4`,`MB0TG0`,`MB1TG1`,`MB2TG2`,`MB3TG3`,`MB4TG4`,`OVMB`,`MBMB`,`MBTG`,`MBFT`,`FTFT`,`FTTG`,`TGMB`,`TGFT`,`TGTG`,`FTMB`,`MB_MID`,`TG_MID`,`M_Dime` from foot_match where p3_show<>1  AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' order by display limit $offset,1000;";
	$result = mysql_query( $sql1);
	$cou=mysql_num_rows($result);
	echo "parent.retime=0;\n";
	echo "parent.game_more=1;";
	echo "parent.str_more='$play_more';\n";
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID']+1;

		$sql2 = "select `MB_Win`,`TG_Win`,`M_Flat`,`ShowType`,`M_LetB`,`MB_LetB_Rate`,`TG_LetB_Rate`,`MB_Dime_Rate`,`TG_Dime_Rate`,`MB1TG0`,`MB2TG0`,`MB0TG1`,`MB0TG2`,`MB2TG1`,`MB1TG2`,`MB3TG0`,`MB0TG3`,`MB3TG1`,`MB1TG3`,`MB3TG2`,`MB2TG3`,`MB4TG0`,`MB0TG4`,`MB4TG1`,`MB1TG4`,`MB4TG2`,`MB2TG4`,`MB4TG3`,`MB3TG4`,`MB0TG0`,`MB1TG1`,`MB2TG2`,`MB3TG3`,`MB4TG4`,`OVMB`,`M_Dime` from foot_match where mid=$mid";
		$result1 = mysql_query( $sql2);
		$row1=mysql_fetch_array($result1);

$a1=$row[MB_LetB_Rate];
$a2=$row[TG_LetB_Rate];

$a1=$a1?mynumberformat(($a1+1-0.01),3):'';
$a2=$a2?mynumberformat(($a2+1-0.01),3):'';

$a3=$row[MB_Dime_Rate];
$a4=$row[TG_Dime_Rate];

$a3=$a3?mynumberformat(($a3+1-0.01),3):'';
$a4=$a4?mynumberformat(($a4+1-0.01),3):'';

$a5=$row1[MB_LetB_Rate];
$a6=$row1[TG_LetB_Rate];

$a5=$a5?mynumberformat(($a5+1-0.01),3):'';
$a6=$a6?mynumberformat(($a6+1-0.01),3):'';

$a7=$row1[MB_Dime_Rate];
$a8=$row1[TG_Dime_Rate];

$a7=$a7?mynumberformat(($a7+1-0.01),3):'';
$a8=$a8?mynumberformat(($a8+1-0.01),3):'';

$a9=$row[S_Single];
$a10=$row[S_Double];

$a9=$a9?mynumberformat(($a9-0.01),2):'';
$a10=$a10?mynumberformat(($a10-0.01),2):'';


		echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$a1','$a2','O$row[M_Dime]','U$row[M_Dime]','$a3','$a4','$a9','$a10','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[OVMB]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','0','$row[S_0_1]','$row[S_2_3]','$row[S_4_6]','$row[S_7UP]','$row[MBMB]','$row[MBFT]','$row[MBTG]','$row[FTMB]','$row[FTFT]','$row[FTTG]','$row[TGMB]','$row[TGFT]','$row[TGTG]','$mid','$row1[ShowType]','$row1[M_LetB]','$a5','$a6','O$row1[M_Dime]','U$row1[M_Dime]','$a8','$a7','$row1[MB1TG0]','$row1[MB2TG0]','$row1[MB2TG1]','$row1[MB3TG0]','$row1[MB3TG1]','$row1[MB3TG2]','$row1[MB4TG0]','$row1[MB4TG1]','$row1[MB4TG2]','$row1[MB4TG3]','$row1[MB0TG0]','$row1[MB1TG1]','$row1[MB2TG2]','$row1[MB3TG3]','$row1[MB4TG4]','$row1[OVMB]','$row1[MB0TG1]','$row1[MB0TG2]','$row1[MB1TG2]','$row1[MB0TG3]','$row1[MB1TG3]','$row1[MB2TG3]','$row1[MB0TG4]','$row1[MB1TG4]','$row1[MB2TG4]','$row1[MB3TG4]','','$row1[MB_Win]','$row1[TG_Win]','$row1[M_Flat]','$row[more]');\n";
		$K=$K+1;
	}
	break;
}
?>


 function onLoad()
 {
  if(top.<?=CASINO?>_mem_index.mem_order.location == 'about:blank')
   top.<?=CASINO?>_mem_index.mem_order.location = '<?=BROWSER_IP?>/app/member/select.php?uid=<?=$uid?>&langx=zh-tw';
  if(parent.retime > 0)
   parent.retime_flag='Y';
  else
   parent.retime_flag='N';
  parent.loading_var = 'N';
  if(parent.loading == 'N' && parent.ShowType != '')
  {
   parent.ShowGameList();
   //parent.body_browse.document.all.LoadLayer.style.display = 'none';
  }
 }

 function onUnLoad()
 {
  x = parent.body_browse.pageXOffset;
  y = parent.body_browse.pageYOffset;
  parent.body_browse.scroll(x,y);
  //obj_layer = parent.body_browse.document.getElementById('LoadLayer');
  //obj_layer.style.display = 'block';
 }

// -->
window.defaultStatus="Wellcome................."
</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad();" onUnLoad="onUnLoad()">
	<img id=im0 width=0 height=0><img id=im1 width=0 height=0><img id=im2 width=0 height=0><img id=im3 width=0 height=0><img id=im4 width=0 height=0>
<img id=im5 width=0 height=0><img id=im6 width=0 height=0>

</body>
</html>
<?
userlog($memname);
}

?>
