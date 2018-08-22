<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");

$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$sorttype=$_REQUEST['sorttype'];
if($sorttype==""){
	$sorttype="T";
}
if($mtype==""){
	$mtype=3;
}
$K=0;

$rtype=$_REQUEST['rtype'];
$delay=$_REQUEST['delay'];
$league_id=$_REQUEST['league_id'];
$page_no=$_REQUEST['page_no']+0;
$hot_game=$_REQUEST['hot_game'];
if($hot_game=="undefined"){
	$hot_game="";
}
$sql = "select id,pay_type,LogIP,OpenType,language,Memname,credit,Money,date_format(logdate,'%Y-%m-%d') as logdate from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$open    = $row['OpenType'];
$id	  = $row['id'];
$memname = $row['Memname'];
$credit  = $row['credit'];
$logdate=date('Y-m-d');
$dtime=date('Y-m-d H:i:s');
if($row['logdate']<>$logdate){
	if ($row['pay_type']==0){
		$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore from web_db_io where m_date>='$logdate' and m_name='$memname' and hidden=0";
		$result1 = mysql_db_query($dbname,$sql) or die('credit');
		$row1 = mysql_fetch_array($result1);
		$credit=$credit-$row1['betscore'];
		if($credit<0){$credit=0;}
		$sql="update web_member set logdate=now(), money='$credit',active=now() where id=$id";
	}else{
		$sql="update web_member set logdate=now(),active='$dtime' where Oid='$uid' and Oid<>''";
	}
}else{
	$sql="update web_member set active='$dtime' where Oid='$uid' and Oid<>''";
}
mysql_db_query($dbname,$sql);

require ("../include/traditional.$langx.inc.php");

if ($page_no==''){$page_no=0;}
$rate=set_rate($open);
$mDate=date('m-d');
$K=0;
$pagecount=60;
$offset = $page_no*$pagecount;

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
	case "zh-vn":
		$suid=$row['uid_tw'];
		$site=$row['datasite_tw'];
		$la="tw";
		$mima='密碼錯誤次數過多';
		break;
	default:
		$suid=$row['uid_cn'];
		$site=$row['datasite'];
		$la="cn";
		$mima='Quá nhiều mật khẩu không chính xác';
		break;
}
$b_http=$row['Old_http'];

$base_url = "".$site."/app/member/FT_browse/index.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype";
$filename="".$site."/app/member/FT_browse/body_var.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype&delay=&page_no=".$page_no;
$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt");
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer($base_url);
$meg=$curl->fetch_url($filename);
$pb=explode('t_page=',$meg);
$pb=explode(';',$pb[1]);
$t_page=$pb[0];
if($t_page==""){
	$t_page=1;
}

$meg=str_replace('_.','parent.',$meg);
$meg=str_replace('parent.GameFT=new Array();','',$meg);
$meg=str_replace('parent.GameHead = new Array','',$meg);
$meg=str_replace('g([','Array(',$meg);
$meg=str_replace('])',')',$meg);
preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
$gamount1=explode('gamount=',$meg);
$gamount1=explode(';',$gamount1[1]);
$cou=$gamount1[0];
if($cou==""){
	$cou=0;
}

$gameCount=explode('gameCount=',$meg);
$gameCount=explode(';',$gameCount[1]);
$gameCount=$gameCount[0];
if($gameCount=='' or $gameCount<0){
    $gameCount=0;
}
?>
<HEAD><TITLE></TITLE>
	<META http-equiv=Content-Type content="text/html; charset=utf-8">
	<SCRIPT language=JavaScript>
		<!--
		if(self == top) location='<?=BROWSER_IP?>/app/member/';
		parent.flash_ior_set='Y';
		parent.minlimit_VAR='';
		parent.maxlimit_VAR='';
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
		parent.gameCount=<?=$gameCount?>;


		<?php


        switch ($rtype){
        case "r":

            echo "parent.t_page=$t_page;\n";
            echo "parent.str_renew = '$udpsecond';\n";
            echo "parent.retime=180;\n";
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
                    $sql = "update foot_match set display=$i,ShowType='$datainfo[7]',M_LetB='$datainfo[8]',M_Dime='$m_dime',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate='$datainfo[14]',MB_Win='$datainfo[15]',TG_Win='$datainfo[16]',s_single='$datainfo[20]',s_double='$datainfo[21]',r_show=1 where MID=$datainfo[0]";
                    mysql_db_query($dbname,$sql);

                    if($datainfo[22]<>''){
                        $m_dime=str_replace('O','',$datainfo[27]);
                        $sql = "update foot_match set display=$i, ShowType='$datainfo[23]',M_LetB='$datainfo[24]',M_Dime='$m_dime',MB_LetB_Rate='$datainfo[25]',TG_LetB_Rate='$datainfo[26]',TG_Dime_Rate='$datainfo[29]',MB_Dime_Rate='$datainfo[30]',r_Show=1 where MID=$datainfo[22]";
                        mysql_db_query($dbname,$sql);
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
                    $dtime=match_start($datainfo[1]);
                    //echo $dtime."--".date("Y-m-d H:i:s");
                    if($dtime > date("Y-m-d H:i:s")){
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[39]');\n";
                        $K=$K+1;
                    }
                }
            }else{
                $offset=$page_no*60;
                $mysql = "select moredata,more,MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font color=red>$re_red</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB,$m_league as M_League,MB_Win,TG_Win,M_Flat,if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,concat('O',m_dime) as MB_Dime,concat('U',m_dime) as TG_Dime,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,if(s_single=0,'',FORMAT(s_single-$rate,2)) as s_single,if(s_double=0,'',FORMAT(s_double-$rate,2)) as s_double from foot_match where `m_start` > now( ) and R_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1  order by M_League_tw,M_Time,display;";
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
        case "re":
        echo "parent.GameHead = new Array('gid','timer','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','no1','no2','no3','score_h','score_c','hgid','hstrong','hratio','ior_HRH','ior_HRC','hratio_o','hratio_u','ior_HOUH','ior_HOUC','redcard_h','redcard_c','lastestscore_h','lastestscore_c','ior_MH','ior_MC','ior_MN','ior_HMH','ior_HMC','ior_HMN','str_odd','str_even','ior_EOO','ior_EOE','eventid','hot','center_tv','play','datetime','retimeset','more');\n";




            if(sizeof(explode("gamount=",$meg))<=1){
                echo "parent.retime=6;\n";
            }else{
                echo "parent.retime=30;\n";
            }

                echo "parent.str_renew = '$udpsecond';\n";
                if ($league_id<>''){
                    echo "parent.game_sw=1;\n";
                    echo "parent.l_name='$league_id';\n";
                }
                echo "parent.game_more=1;\n";
                echo "parent.t_page=$t_page;\n";
                echo "parent.gamount=$cou;\n";
                echo "parent.str_more='$play_more';\n";
                for($i=0;$i<$cou;$i++){
                    $messages=$matches[0][$i];
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

                    $sql = "update foot_match set m_time='$status',fopen=$close,ShowType='$datainfo[7]',M_re_LetB='$datainfo[8]',M_re_Dime='$m_re_dime',MB_re_LetB_Rate='$datainfo[9]',TG_re_LetB_Rate='$datainfo[10]',TG_re_Dime_Rate='$datainfo[13]',MB_re_Dime_Rate='$datainfo[14]',mb_ball='$datainfo[18]',tg_ball='$datainfo[19]',rcard_h='$datainfo[29]',rcard_c='$datainfo[30]',mb_win='$datainfo[33]',tg_win='$datainfo[34]',m_flat='$datainfo[35]',str_odd='$datainfo[41]',str_even='$datainfo[42]',RE_Show=1 where MID=$datainfo[0]";
                    mysql_db_query($dbname,$sql);

                    $gid3=$datainfo[0]+1;
                    if($notup==1){
                        $m_re_dime=str_replace('O','',$datainfo[25]);

                        $close=1;
                        if($datainfo[25]=='O 0' or $datainfo[26]=='U 0'){
                            $close=0;
                        }
                        $sql = "update foot_match set m_time='$status',fopen=$close,ShowType='$datainfo[7]',M_re_LetB='$datainfo[22]',M_re_Dime='$m_re_dime',MB_re_LetB_Rate='$datainfo[23]',TG_re_LetB_Rate='$datainfo[24]',TG_re_Dime_Rate='$datainfo[27]',MB_re_Dime_Rate='$datainfo[28]',mb_ball='$datainfo[18]',TG_ball='$datainfo[19]',rcard_h='$datainfo[29]',rcard_c='$datainfo[30]',str_odd='$datainfo[39]',str_even='$datainfo[40]',RE_Show=1,mb_win='$datainfo[36]',tg_win='$datainfo[37]',m_flat='$datainfo[38]',str_odd='$datainfo[41]',str_even='$datainfo[42]' where MID=$gid3";
                        mysql_db_query($dbname,$sql);
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


                    if ($league_id<>''){
                        if ($league_id==$dateinfo[2]){
                            echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]','$datainfo[38]','$datainfo[39]','$datainfo[40]','$datainfo[41]','$datainfo[42]','$datainfo[43]','$datainfo[44]','$datainfo[45]','$datainfo[46]','$datainfo[47]','$datainfo[48]','$datainfo[49]');\n";
                            $K=$K+1;
                        }
                    }else{
                            echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]','$datainfo[38]','$datainfo[39]','$datainfo[40]','$datainfo[41]','$datainfo[42]','$datainfo[43]','$datainfo[44]','$datainfo[45]','$datainfo[46]','$datainfo[47]','$datainfo[48]','$datainfo[49]');\n";
                        $K=$K+1;
                    }
                }


            break;
        case "pd":
            if($sorttype=="T"){
                $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType from foot_match where `m_start` > now( ) and pd_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by display";
            }else{
                $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType from foot_match where `m_start` > now( ) and pd_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by M_League_tw,M_Time,display";
            }

            $result = mysql_db_query($dbname, $mysql);
            $cou=mysql_num_rows($result);
            //echo $mysql;
            $page_count1=$cou/$pagecount;
            if($page_count1==(int)$page_count1){
            $page_count=$page_count1+$page_no;
            }
            else{
            $page_count=(int)$page_count1+1+$page_no;
            }
        $t_page=$page_count;

            echo "parent.t_page=$t_page;\n";
            echo "parent.retime=180;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_H1C0','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H4C0','ior_H4C1','ior_H4C2','ior_H4C3','ior_H0C0','ior_H1C1','ior_H2C2','ior_H3C3','ior_H4C4','ior_OVH','ior_H0C1','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3','ior_H0C4','ior_H1C4','ior_H2C4','ior_H3C4','ior_OVC');\n";
            while ($row=mysql_fetch_array($result)){
                    echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[OVMB]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','$row[OVTG]');\n";
                $K=$K+1;
            }
            break;
        case "rpd":

            echo "parent.t_page=$t_page;\n";
            echo "parent.retime=180;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.GameHead = new Array('gid','timer','league','gnum_h','gnum_c','team_h','team_c','strong','ior_RH1C0','ior_RH2C0','ior_RH2C1','ior_RH3C0','ior_RH3C1','ior_RH3C2','ior_RH4C0','ior_RH4C1','ior_RH4C2','ior_RH4C3','ior_RH0C0','ior_RH1C1','ior_RH2C2','ior_RH3C3','ior_RH4C4','ior_ROVH','ior_RH0C1','ior_RH0C2','ior_RH1C2','ior_RH0C3','ior_RH1C3','ior_RH2C3','ior_RH0C4','ior_RH1C4','ior_RH2C4','ior_RH3C4','ior_ROVC','score_h','score_c','redcard_h','redcard_c','lastestscore_h','lastestscore_c','eventid','hot','center_tv','play','datetime','retimeset');
        \n";

            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");
                $dtime=match_start($datainfo[1]);
                $sql = "update foot_match set ior_RH1C0='$datainfo[8]',ior_RH2C0='$datainfo[9]',ior_RH2C1='$datainfo[10]',ior_RH3C0='$datainfo[11]',ior_RH3C1='$datainfo[12]',ior_RH3C2='$datainfo[13]',ior_RH4C0='$datainfo[14]',ior_RH4C1='$datainfo[15]',ior_RH4C2='$datainfo[16]',ior_RH4C3='$datainfo[17]',ior_RH0C0='$datainfo[18]',ior_RH1C1='$datainfo[19]',ior_RH2C2='$datainfo[20]',ior_RH3C3='$datainfo[21]',ior_RH4C4='$datainfo[22]',ior_RH0C1='$datainfo[24]',ior_RH0C2='$datainfo[25]',ior_RH1C2='$datainfo[26]',ior_RH0C3='$datainfo[27]',ior_RH1C3='$datainfo[28]',ior_RH2C3='$datainfo[29]',ior_RH0C4='$datainfo[30]',ior_RH1C4='$datainfo[31]',ior_RH2C4='$datainfo[32]',ior_RH3C4='$datainfo[33]',ior_ROVH='$datainfo[34]' where MID=$datainfo[0]";
                mysql_db_query($dbname,$sql);

                echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]','$datainfo[38]','$datainfo[39]','$datainfo[40]','$datainfo[41]','$datainfo[42]','$datainfo[43]','$datainfo[44]','$datainfo[45]','$datainfo[46]');\n";
                $K=$K+1;

            }
            break;
        case "hrpd":

            echo "parent.t_page=$t_page;\n";
            echo "parent.retime=180;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.GameHead = new Array('gid','timer','league','gnum_h','gnum_c','team_h','team_c','strong','ior_RH1C0','ior_RH2C0','ior_RH2C1','ior_RH3C0','ior_RH3C1','ior_RH3C2','ior_RH4C0','ior_RH4C1','ior_RH4C2','ior_RH4C3','ior_RH0C0','ior_RH1C1','ior_RH2C2','ior_RH3C3','ior_RH4C4','ior_ROVH','ior_RH0C1','ior_RH0C2','ior_RH1C2','ior_RH0C3','ior_RH1C3','ior_RH2C3','ior_RH0C4','ior_RH1C4','ior_RH2C4','ior_RH3C4','ior_ROVC','score_h','score_c','lastestscore_h','lastestscore_c','eventid','hot','center_tv','play','datetime','retimeset');
        \n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");
                $dtime=match_start($datainfo[1]);
                $sql = "update foot_match set ior_HRH1C0='$datainfo[8]',ior_HRH2C0='$datainfo[9]',ior_HRH2C1='$datainfo[10]',ior_HRH3C0='$datainfo[11]',ior_HRH3C1='$datainfo[12]',ior_HRH3C2='$datainfo[13]',ior_HRH0C0='$datainfo[18]',ior_HRH1C1='$datainfo[19]',ior_HRH2C2='$datainfo[20]',ior_HRH3C3='$datainfo[21]',ior_HRH0C1='$datainfo[24]',ior_HRH0C2='$datainfo[25]',ior_HRH1C2='$datainfo[26]',ior_HRH0C3='$datainfo[27]',ior_HRH1C3='$datainfo[28]',ior_HRH2C3='$datainfo[29]',ior_HROVH='$datainfo[34]' where MID=$datainfo[0]";

                mysql_db_query($dbname,$sql);
                if($dtime>date("Y-m-d H:i:s")){
                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]','$datainfo[38]','$datainfo[39]','$datainfo[40]','$datainfo[41]','$datainfo[42]','$datainfo[43]','$datainfo[44]');\n";
                    $K=$K+1;
                }
            }
            break;
        case "hpd":

            echo "parent.t_page=$t_page;\n";
            echo "parent.retime=180;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_H1C0','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H4C0','ior_H4C1','ior_H4C2','ior_H4C3','ior_H0C0','ior_H1C1','ior_H2C2','ior_H3C3','ior_H4C4','ior_OVH','ior_H0C1','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3','ior_H0C4','ior_H1C4','ior_H2C4','ior_H3C4','ior_OVC');\n";
            if($sorttype=="T"){
                for($i=0;$i<$cou;$i++){
                        $messages=$matches[0][$i];
                        $messages=str_replace(");",")",$messages);
                        $messages=str_replace("cha(9)","",$messages);
                        $datainfo=eval("return $messages;");
                    $dtime=match_start($datainfo[1]);
                    if($dtime>date("Y-m-d H:i:s")){
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]');\n";
                        $K=$K+1;
                    }
                }
            }else{
                $offset=$page_no*60;
                $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType from foot_match where `m_start` > now( ) and pd_Show=2 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by M_League_tw,M_Time,display limit $offset,60";
                $result = mysql_db_query($dbname, $mysql);
                while ($row=mysql_fetch_array($result)){
                    echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[OVMB]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','$row[OVTG]');\n";
                    $K=$K+1;
                }
            }
            break;
        case "t":



            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_T01','ior_T23','ior_T46','ior_OVER','ior_MH','ior_MC','ior_MN');\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.retime=60;\n";
            echo "parent.gamount=$cou;\n";
            if($sorttype=="T"){
                for($i=0;$i<$cou;$i++){
                        $messages=$matches[0][$i];
                        $messages=str_replace(");",")",$messages);
                        $messages=str_replace("cha(9)","",$messages);
                        $datainfo=eval("return $messages;");
                        $dtime=match_start($datainfo[1]);
                        if($dtime>date("Y-m-d H:i:s")){
                            if($datainfo[8]<>"" or $datainfo[9]<>"" or $datainfo[10]<>"" or $datainfo[11]<>""){
                                echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]');\n";
                                $K=$K+1;
                            }
                        }

                }
            }else{
                $offset=$page_no*60;
                $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowType,S_Single,S_Double,MB_Win,TG_Win,M_Flat from foot_match where `m_start` > now( ) and t_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by M_League_tw,M_Time,display limit $offset,60;";
                $result = mysql_db_query($dbname, $mysql);
                while ($row=mysql_fetch_array($result)){
                    $S_Single=$row['S_Single'];
                    $S_Double=$row['S_Double'];
                    echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$S_Single','$S_Double','$row[S_0_1]','$row[S_2_3]','$row[S_4_6]','$row[S_7UP]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]');\n";
                    $K=$K+1;
                }

            }
            break;
        case "rt":

            echo "parent.GameHead = new Array('gid','timer','league','gnum_h','gnum_c','team_h','team_c','strong','ior_RT01','ior_RT23','ior_RT46','ior_ROVER','score_h','score_c','redcard_h','redcard_c','lastestscore_h','lastestscore_c','eventid','hot','center_tv','play','datetime','retimeset');\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.retime=60;\n";
            echo "parent.gamount=$cou;\n";

                for($i=0;$i<$cou;$i++){
                        $messages=$matches[0][$i];
                        $messages=str_replace(");",")",$messages);
                        $messages=str_replace("cha(9)","",$messages);
                        $datainfo=eval("return $messages;");
                        $dtime=match_start($datainfo[1]);
                        $sql = "update foot_match set ior_RT01='$datainfo[8]',ior_RT23='$datainfo[9]',ior_RT46='$datainfo[10]',ior_ROVER='$datainfo[11]' where MID=$datainfo[0]";
                        mysql_db_query($dbname,$sql);

                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]');\n";
                        $K=$K+1;


                }
            break;
        case "f":


            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_FHH','ior_FHN','ior_FHC','ior_FNH','ior_FNN','ior_FNC','ior_FCH','ior_FCN','ior_FCC');\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.retime=60;\n";
            $sql = "update foot_match set f_show=0 where f_show=1";
            mysql_db_query($dbname,$sql);
            if($sorttype=="T"){
                for($i=0;$i<$cou;$i++){
                        $messages=$matches[0][$i];
                        $messages=str_replace(");",")",$messages);
                        $messages=str_replace("cha(9)","",$messages);
                        $datainfo=eval("return $messages;");
                        $sql = "update foot_match set MBMB='$datainfo[8]',MBFT='$datainfo[9]',MBTG='$datainfo[10]',FTMB='$datainfo[11]',FTFT='$datainfo[12]',FTTG='$datainfo[13]',TGMB='$datainfo[14]',TGFT='$datainfo[15]',TGTG='$datainfo[16]',F_Show=1 where MID=$datainfo[0]";
                        mysql_db_query($dbname,$sql);
                        $dtime=match_start($datainfo[1]);
                        if($dtime>date("Y-m-d H:i:s")){
                                echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]');\n";
                                $K=$K+1;
                        }
                }
            }else{
                $offset=$page_no*60;
                $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG,MB_MID,TG_MID,ShowType from foot_match where `m_start` > now( ) and f_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by M_League_tw,M_Time,display limit $offset,60;";
                $result = mysql_db_query($dbname, $mysql);
                while ($row=mysql_fetch_array($result)){
                    echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MBMB]','$row[MBFT]','$row[MBTG]','$row[FTMB]','$row[FTFT]','$row[FTTG]','$row[TGMB]','$row[TGFT]','$row[TGTG]');\n";
                    $K=$K+1;
                }

            }

            break;
        case "rf":
            echo "parent.GameHead = new Array('gid','timer','league','gnum_h','gnum_c','team_h','team_c','strong','ior_RFHH','ior_RFHN','ior_RFHC','ior_RFNH','ior_RFNN','ior_RFNC','ior_RFCH','ior_RFCN','ior_RFCC','score_h','score_c','redcard_h','redcard_c','lastestscore_h','lastestscore_c','eventid','hot','center_tv','play','datetime','retimeset');\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.retime=60;\n";
            $sql = "update foot_match set f_show=0 where f_show=1";
            mysql_db_query($dbname,$sql);
                for($i=0;$i<$cou;$i++){
                        $messages=$matches[0][$i];
                        $messages=str_replace(");",")",$messages);
                        $messages=str_replace("cha(9)","",$messages);
                        $datainfo=eval("return $messages;");

                        $sql = "update foot_match set ior_RFHH='$datainfo[8]',ior_RFHN='$datainfo[9]',ior_RFHC='$datainfo[10]',ior_RFNH='$datainfo[11]',ior_RFNN='$datainfo[12]',ior_RFNC='$datainfo[13]',ior_RFCH='$datainfo[14]',ior_RFCN='$datainfo[15]',ior_RFCC='$datainfo[16]' where MID=$datainfo[0]";
                        mysql_db_query($dbname,$sql);

                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]');\n";
                                $K=$K+1;
                }


            break;
        case 'p3':

            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_PRH','ior_PRC','ratio_o','ratio_u','ior_POUC','ior_POUH','ior_PO','ior_PE','ior_MH','ior_MC','ior_MN','ior_H1C0','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H4C0','ior_H4C1','ior_H4C2','ior_H4C3','ior_H0C0','ior_H1C1','ior_H2C2','ior_H3C3','ior_H4C4','ior_OVH','ior_H0C1','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3','ior_H0C4','ior_H1C4','ior_H2C4','ior_H3C4','ior_OVC','ior_T01','ior_T23','ior_T46','ior_OVER','ior_FHH','ior_FHN','ior_FHC','ior_FNH','ior_FNN','ior_FNC','ior_FCH','ior_FCN','ior_FCC','hgid','hstrong','hratio','ior_HPRH','ior_HPRC','hratio_o','hratio_u','ior_HPOUH','ior_HPOUC','ior_HH1C0','ior_HH2C0','ior_HH2C1','ior_HH3C0','ior_HH3C1','ior_HH3C2','ior_HH4C0','ior_HH4C1','ior_HH4C2','ior_HH4C3','ior_HH0C0','ior_HH1C1','ior_HH2C2','ior_HH3C3','ior_HH4C4','ior_HOVH','ior_HH0C1','ior_HH0C2','ior_HH1C2','ior_HH0C3','ior_HH1C3','ior_HH2C3','ior_HH0C4','ior_HH1C4','ior_HH2C4','ior_HH3C4','ior_HOVC','ior_HPMH','ior_HPMC','ior_HPMN','more','gidm','par_minlimit','par_maxlimit');\n";

                echo "parent.t_page=$t_page;\n";
                echo "parent.gamount=$cou;\n";
                echo "parent.retime=180;\n";
                echo "parent.game_more=1;";
                echo "parent.str_more='$play_more';\n";
                for($i=0;$i<$cou;$i++){
                    $messages=$matches[0][$i];
                    $messages=str_replace(");",")",$messages);
                    $messages=str_replace("cha(9)","",$messages);
                    $datainfo=eval("return $messages;");
                    $dtime=match_start($datainfo[1]);
                    if($dtime>date("Y-m-d H:i:s")){
                        $sql = "update foot_match set MB_PR_LetB_rate='$datainfo[9]',TG_PR_letb_rate='$datainfo[10]',S_Single='$datainfo[15]',S_Double='$datainfo[16]',MB_PR_Dime_Rate='$datainfo[13]',TG_PR_Dime_Rate='$datainfo[14]',P3_Show=1,more='$datainfo[32]',gidm='$datainfo[33]',par_minlimit='$datainfo[34]',par_maxlimit='$datainfo[35]' where MID=$datainfo[0]";
                mysql_db_query($dbname,$sql);

                    $sql = "update foot_match set MB_PR_LetB_rate='$datainfo[23]',TG_PR_letb_rate='$datainfo[24]',S_Single='$datainfo[29]',S_Double='$datainfo[30]',MB_PR_Dime_Rate='$datainfo[28]',TG_PR_Dime_Rate='$datainfo[27]',more='$datainfo[32]',gidm='$datainfo[33]',par_minlimit='$datainfo[34]',par_maxlimit='$datainfo[35]',p3_show=1 where MID=$datainfo[20]";
                mysql_db_query($dbname,$sql);

                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','','','','','','','','','','','','','','','','','','','','','','','','','','','','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]');\n";
                    $K=$K+1;
                    }
                }
            break;
        }
		mysql_close();

        ?>
		function onLoad(){
			if(parent.parent.mem_order.location == 'about:blank'){
				parent.parent.mem_order.location = '<?=BROWSER_IP?>/app/member/select.php?uid=<?=$uid?>&langx=<?=$langx?>';
			}
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

		// -->
		window.defaultStatus="Wellcome................."
	</script>
</head>
<body bgcolor="#FFFFFF" onload="onLoad();">
</body>
</html>

