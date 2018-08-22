<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$league_id=$_REQUEST['league_id'];
$page_no=$_REQUEST['page_no'];
$g_date=$_REQUEST['g_date'];
$sql = "select OpenType,language,Memname,Money from web_member where Oid='$uid' and oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$dtime=date('Y-m-d H:i:s');
$sql="update web_member set active='$dtime' where Oid='$uid' and oid<>''";

mysql_db_query($dbname,$sql);

$open    = $row['OpenType'];
$memname = $row['Memname'];
$credit  = $row['Money'];
require ("../include/traditional.$langx.inc.php");
if ($league_id==''){
	$league='';
}else{
	$league=" and ".$m_league."='".$league_id."'";
}
if ($page_no==''){$page_no=0;}
$rate=set_rate($open);
$mDate=date('m-d');
$K=0;
if($g_date==""){
	$g_date="ALL";
}

$pagecount=40;
$offset		=	$page_no*$pagecount;
?>
<HEAD><TITLE></TITLE>
	<META http-equiv=Content-Type content="text/html; charset=utf-8">
	<SCRIPT language=JavaScript>

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
		<?php
            $mysql = "select * from web_system";
            $result = mysql_db_query($dbname,$mysql);
            $row = mysql_fetch_array($result);
            $mDate=date('m-d');
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
            $base_url = "".$site."/app/member/OP_future/index.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype";
            $thisHttp = new cHTTP();
            $thisHttp->setReferer($base_url);
            $filename="".$site."/app/member/OP_future/body_var.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype&mtype=$mtype&g_date=$g_date&league_id=$league_id&page_no=".$page_no;
            $thisHttp->getPage($filename);
            $msg  = $thisHttp->getContent();
//            $meg .= gzinflate(substr($msg,10));
            $pb=explode('t_page=',$meg);
            $pb=explode(';',$pb[1]);
            $t_page=$pb[0];
            if($t_page==""){
            $t_page=0;
            }
            preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
            $cou=sizeof($matches[0])-1;

            $gameCount=explode('gameCount=',$meg);
            $gameCount=explode(';',$gameCount[1]);
            $gameCount=$gameCount[0];
            if($gameCount=='' or $gameCount<0){
                $gameCount=0;
            }
            echo "parent.gameCount=$gameCount;\n";
        switch ($rtype){
        case "r":

            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','ior_MH','ior_MC','ior_MN','str_odd','str_even','ior_EOO','ior_EOE','hgid','hstrong','hratio','ior_HRH','ior_HRC','hratio_o','hratio_u','ior_HOUH','ior_HOUC','ior_HMH','ior_HMC','ior_HMN','more','eventid','hot','play');\n";
            echo "parent.str_renew = '$udpsecond';\n";
            echo "parent.retime=180;\n";
            echo "parent.gamount=0;\n";
            echo "parent.game_sw=0;\n";
            echo "parent.game_more=1;\n";
            echo "parent.str_more='$play_more';\n";


            $page_count=$cou/$pagecount;
            echo "parent.t_page=$t_page;\n";
            echo "parent.gamount=$cou;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");

                $m_dime=str_replace('O','',$datainfo[11]);

                $sql = "update other_play set display=$i,ShowType='$datainfo[7]',M_LetB='$datainfo[8]',M_Dime='$m_dime',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate='$datainfo[14]',MB_Win='$datainfo[15]',TG_Win='$datainfo[16]',s_single='$datainfo[20]',s_double='$datainfo[21]',r_show=3 where MID=$datainfo[0]";
                mysql_query($sql);
                if ($datainfo[9]<>''){
                    $datainfo[9]=change_rate($open,$datainfo[9]);
                    $datainfo[10]=change_rate($open,$datainfo[10]);
                }
                if ($datainfo[13]<>''){
                    $datainfo[13]=change_rate($open,$datainfo[13]);
                    $datainfo[14]=change_rate($open,$datainfo[14]);
                }
             $K=$i-1;
                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]');\n";
                    //$K=$K+1;
                }
            break;
        case "re":

            $mysql = "select datasite,uid_tw,uid_en from web_system";
            $result = mysql_db_query($dbname,$mysql);
            $row = mysql_fetch_array($result);
            $site=$row['datasite'];
            switch($langx)	{
            case "zh-tw":
                $suid=$row['uid_tw'];
                break;
            case "zh-cn":
                $suid=$row['uid'];
                break;
            case "en-us":
                $suid=$row['uid_en'];
                break;
            default:
                $suid=$row['uid_tw'];
                break;
            }

            $base_url = "".$site."/app/member/FT_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=$mtype";
            $thisHttp = new cHTTP();
            $thisHttp->setReferer($base_url);
            $filename="".$site."/app/member/FT_browse/body_var.php?rtype=re&uid=$suid&langx=$langx&mtype=$mtype";
            $thisHttp->getPage($filename);
            $msg  = $thisHttp->getContent();
            $meg .= gzinflate(substr($msg,10));
        $chs = new Chinese("UTF8","BIG5", $meg);
                        $meg=$chs->ConvertIT();
            preg_match_all("/Array\((.+?)\);/is",$meg,$matches);

            $cou=sizeof($matches[0]);
            echo "parent.retime=60;\n";
            echo "parent.str_renew = '$udpsecond';\n";
            if ($league_id<>''){
                echo "parent.game_sw=1;\n";
                echo "parent.l_name='$league_id';\n";
            }
            $page_count=$cou/$pagecount;
            echo "parent.t_page=$page_count;\n";
            echo "parent.gamount=$cou;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");

                $mb_dime_tw=str_replace('O','j',$datainfo[11]);
                $tg_dime_tw=str_replace('U','p',$datainfo[12]);
                $mb_dime=str_replace('O','',$datainfo[11]);
                $tg_dime=str_replace('U','小',$datainfo[12]);
                $sql = "update foot_match set ShowType='$datainfo[7]',M_LetB_RE='$datainfo[8]',MB_Dime_re='$mb_dime',MB_Dime_re_tw='$mb_dime_tw',MB_Dime_re_en='$datainfo[11]',TG_Dime_re='$tg_dime',TG_Dime_re_tw='$tg_dime_tw',TG_Dime_re_en='$datainfo[12]',MB_LetB_Rate_re='$datainfo[9]',TG_LetB_Rate_re='$datainfo[10]',TG_Dime_Rate_re='$datainfo[13]',MB_Dime_Rate_re='$datainfo[14]',MB_ball='$datainfo[18]',TG_ball='$datainfo[19]',RE_Show=1 where MID=$datainfo[0]";
                mysql_db_query($dbname,$sql) or die(error);
                if($datainfo[20]<>''){
                    $sql = "update foot_match set ShowType='$datainfo[7]',M_LetB_RE='$datainfo[8]',MB_Dime_re='$mb_dime',MB_Dime_re_tw='$mb_dime_tw',MB_Dime_re_en='$datainfo[11]',TG_Dime_re='$tg_dime',TG_Dime_re_tw='$tg_dime_tw',TG_Dime_re_en='$datainfo[12]',MB_LetB_Rate_re='$datainfo[9]',TG_LetB_Rate_re='$datainfo[10]',TG_Dime_Rate_re='$datainfo[13]',MB_Dime_Rate_re='$datainfo[14]',MB_ball='$datainfo[18]',TG_ball='$datainfo[19]',RE_Show=1 where MID=$datainfo[20]";
                    //mysql_db_query($dbname,$sql) or die(error);
                }
                if ($datainfo[9]<>''){
                    $datainfo[9]=change_rate($open,$datainfo[9]);
                    $datainfo[10]=change_rate($open,$datainfo[10]);
                }
                if ($datainfo[13]<>''){
                    $datainfo[13]=change_rate($open,$datainfo[13]);
                    $datainfo[14]=change_rate($open,$datainfo[14]);
                }
                $datainfo[19]=$datainfo[19]+0;
                $datainfo[18]=$datainfo[18]+0;
                if ($league_id<>''){
                    if ($league_id==$dateinfo[2]){
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]');\n";
                        $K=$K+1;
                    }
                }else{
                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]');\n";
                    $K=$K+1;
                }

                if ($gmid==''){
                    $gmid=$datainfo[0];
                }else{
                    $gmid=$gmid.','.$datainfo[0];
                }
            }

            $sql="update foot_match set RE_Show=0 where RE_Show=1 and locate(MID,'$gmid')<1";
            mysql_db_query($dbname,$sql) or die ("蕨@!");

            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB_re as M_LetB,$m_league as M_League,if(MB_Dime_Rate_re=0,'',FORMAT(MB_Dime_Rate_re-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate_re=0,'',FORMAT(TG_Dime_Rate_re-$rate,3)) as TG_Dime_Rate,ucase(MB_Dime_re_en) as MB_Dime,ucase(TG_Dime_re_en) as TG_Dime,if(MB_LetB_Rate_re=0,'',FORMAT(MB_LetB_Rate_re-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate_re=0,'',FORMAT(TG_LetB_Rate_re-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,mb_ball,tg_ball from foot_match where `m_start` < now( ) and Re_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by m_start,display";

            $result = mysql_db_query($dbname, $mysql);
            $cou=mysql_num_rows($result);
            echo "parent.str_renew = '$udpsecond';\n";
            echo "parent.retime=60;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.game_sw=0;\n";
            echo "parent.game_more=1;\n";
            echo "parent.str_more='$play_more';\n";

            while ($row=mysql_fetch_array($result)){
                if ($row[M_Time]=='H/T'){
                    $pdate=$row[M_Date].'<BR><font style=background-color=red>'.$zhongchang.'</font>';
                }else{
                    $pdate=$row[M_Date].'<BR>'.$row[M_Time];
                }

                echo "parent.GameFT[$K]= Array('$row[MID]','$pdate','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[TG_Dime_Rate]','$row[MB_Dime_Rate]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$row[mb_ball]','$row[tg_ball]','0','0');\n";
                $K=$K+1;
            }

            echo "parent.t_page=0;\n";
            echo "parent.str_renew = '$udpsecond';\n";
            echo "parent.retime=60;\n";
            echo "parent.gamount=0;\n";
            echo "parent.game_sw=0;\n";
            echo "parent.game_more=1;\n";
            echo "parent.str_more='$play_more';\n";
            break;
        case "hr":

            $mysql = "select MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>$re_red</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB_en as M_LetB,$m_league as M_League,MB_Win,TG_Win,M_Flat,if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,ucase(MB_Dime_en) as MB_Dime,ucase(TG_Dime_en) as TG_Dime,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,if(s_single=0,'',FORMAT(s_single-$rate,2)) as s_single,if(s_double=0,'',FORMAT(s_double-$rate,2)) as s_double from foot_match where  `m_start` > now( ) and hR_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by display limit $offset,1000;";
            $result = mysql_db_query($dbname, $mysql);
            $cou=mysql_num_rows($result);

            $page_count=$cou/$pagecount+$page_no;
            if ($cou>$pagecount and $sel_lid==''){
                $cou=$pagecount;
            }

            echo "parent.t_page=$page_count;\n";
            echo "parent.str_renew = '$ManualUpdate';\n";
            echo "parent.game_sw=1;\n";
            echo "parent.gamount=$cou;\n";
            while ($row=mysql_fetch_array($result)){
                echo "parent.GameFT[$K]= Array('$row[MID]','$row[pdate]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[TG_Dime_Rate]','$row[MB_Dime_Rate]','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]');\n";
                $K=$K+1;
            }


            echo "parent.t_page=0;\n";
            echo "parent.str_renew = '$ManualUpdate';\n";
            echo "parent.retime=0;\n";
            echo "parent.gamount=0;\n";
            break;
        case "pd":

            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,OVTG,ShowType from foot_match where `m_start` > now( ) and pd_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by display";
            $result = mysql_db_query($dbname, $mysql);
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
            }

            echo "parent.t_page=0;\n";
            echo "parent.retime=0;\n";
            echo "parent.gamount=0;\n";
            break;
        case "hpd":

            $mysql = "select MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>$re_red</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,OVTG,ShowType from foot_match where `m_start` > now( ) and hpd_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by display limit $offset,1000;";
            $result = mysql_db_query($dbname, $mysql);
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

            echo "parent.t_page=0;\n";
            echo "parent.str_renew = '$udpsecond';\n";
            echo "parent.retime=180;\n";
            echo "parent.gamount=0;\n";
            echo "parent.game_sw=0;\n";
            echo "parent.game_more=1;\n";
            echo "parent.str_more='$play_more';\n";
            break;
        case "t":
            echo "parent.retime=0;\n";
            $page_count=$cou/$pagecount;
            echo "parent.t_page=$page_count;\n";
            echo "parent.gamount=$cou;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");


                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]');\n";
                    $K=$K+1;
                }

        /*
            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowType,MB_Win,TG_Win,M_Flat from foot_match where `m_start` > now( ) and t_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by display limit $offset,1000;";
            $result = mysql_db_query($dbname, $mysql);
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
        */
                break;
        case "p":
        /*
            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB_P_Win,TG_P_Win,M_P_Flat,MB_MID,TG_MID,ShowType from foot_match where `m_start` > now( ) and p_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by display";
            $result = mysql_db_query($dbname, $mysql);

            $cou=mysql_num_rows($result);
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            while ($row=mysql_fetch_array($result)){
                //$mb_team=str_replace("[$bzmb]","",$row['MB_Team']);
                //$mb_team=$row['MB_Team'];
                //if (strlen(ltrim($row['M_Time']))<=5){
                //	$pdate=$row[M_Date].'<br>0'.$row[M_Time];
                //}else{
                //	$pdate=$row[M_Date].'<br>'.$row[M_Time];
                //}
                echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MB_P_Win]','$row[TG_P_Win]','$row[M_P_Flat]');\n";
                $K=$K+1;
            }
        */
            echo "parent.retime=0;\n";
            $page_count=$cou/$pagecount;
            echo "parent.t_page=$page_count;\n";
            echo "parent.gamount=$cou;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");


                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]');\n";
                    $K=$K+1;
                }
            break;
        case "pr":
        /*
            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,M_PR_LetB,if(TG_PR_LetB_Rate=0,'',FORMAT(TG_PR_LetB_Rate-$rate,3)) as TG_PR_LetB_Rate,if(MB_PR_LetB_Rate=0,'',FORMAT(MB_PR_LetB_Rate-$rate,3)) as MB_PR_LetB_Rate,MB_MID,TG_MID,ShowType,ucase(mb_dime_en) as MB_Dime,ucase(tg_dime_en) as TG_Dime,if(mb_pr_dime_rate=0,'',FORMAT(mb_pr_dime_rate-$rate,3)) as MB_Dime_Rate,if(tg_pr_dime_rate=0,'',FORMAT(tg_pr_dime_rate-$rate,3)) as TG_Dime_Rate from foot_match where `m_start` > now( ) and pr_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 order by display";
            $result = mysql_db_query($dbname, $mysql);
            $cou=mysql_num_rows($result);
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            while ($row=mysql_fetch_array($result)){
        //		$mb_team=trim($row['MB_Team']);
        //		if (strlen($row['M_Time'])==5){
        //			$pdate=$row[M_Date].'<br>0'.$row[M_Time];
        //		}else{
        //			$pdate=$row[M_Date].'<br>'.$row[M_Time];
        //		}
                echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_PR_LetB]','$row[MB_PR_LetB_Rate]','$row[TG_PR_LetB_Rate]','$row[MB_Dime]','$row[TG_Dime]','$row[MB_Dime_Rate]','$row[TG_Dime_Rate]');\n";
                $K=$K+1;
            }
        */
            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_PRH','ior_PRC','ratio_o','ratio_u','ior_POUH','ior_POUC','gidm','par_minlimit','par_maxlimit');\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");

                echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]');\n";
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
			if(parent.loading == 'N' && parent.ShowType != ''){
				parent.ShowGameList();
			}
		}

	</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad();"></body>
</html>

