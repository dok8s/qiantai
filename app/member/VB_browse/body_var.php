<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='/'</script>";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$league_id=$_REQUEST['league_id'];
$page_no=$_REQUEST['page_no'];
$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/','_top')</script>";
	exit;
}
$open    = $row['OpenType'];
//$langx   = $row['language'];
$memname = $row['Memname'];
$credit  = $row['Money'];
require ("../include/traditional.$langx.inc.php");

if ($page_no==''){$page_no=0;}
$pagecount=40;
$mDate=date('m-d');
$K=0;
?>
<HEAD><TITLE>asd</TITLE>
	<META http-equiv=Content-Type content="text/html; charset=utf-8">
	<SCRIPT language=JavaScript>
		<!--
		if(self == top) location='//app/member/'
		parent.flash_ior_set='Y';
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
		parent.rtype='<?php echo $rtype?>';
		parent.sel_lid='<?php echo $league_id?>';
		top.today_gmt = '<?php echo date('Y-m-d');?>';
		top.now_gmt = '<?php echo date('H:i:s');?>';
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
            $base_url = "".$site."/app/member/VB_browse/index.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype";
            $filename="".$site."/app/member/VB_browse/body_var.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=$mtype&delay=$delay&league_id=$league_id&page_no=".$page_no;
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

            $t_page=$pb[0]?$pb[0]:0;
            $pattern = '/Array\((.+?)\);/is';
            preg_match_all($pattern,$meg,$matches);
            $gamount1=explode('gamount=',$meg);
            $gamount1=explode(';',$gamount1[1]);
            $cou=$gamount1[0];
            $gameCount=explode('gameCount=',$meg);
            $gameCount=explode(';',$gameCount[1]);
            $gameCount=$gameCount[0];
            if($gameCount=='' || $gameCount<0){
                $gameCount=0;
            }
            echo "parent.gameCount=$gameCount;\n";

        switch ($rtype){
        case "r":
            echo "parent.minlimit_VAR='';\n";
            echo "parent.maxlimit_VAR='';\n";
            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','ior_MH','ior_MC','ior_MN','str_odd','str_even','ior_EOO','ior_EOE','more','eventid','hot','center_tv','play');\n";
            echo "parent.retime=180;\n";
            echo "parent.str_renew = '$udpsecond';\n";
            echo "parent.t_page=$t_page;\n";
                if(!$cou)$cou=0;
            echo "parent.gamount=$cou;\n";

            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                //$messages=iconv("UTF-8","big5//IGNORE",$messages);
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");

                $m_dime=str_replace('O','',$datainfo[11]);

                $sql = "update volleyball set ShowType='$datainfo[7]',M_LetB='$datainfo[8]',M_Dime='$m_dime',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate='$datainfo[14]',MB_Win='$datainfo[15]',TG_Win='$datainfo[16]',s_single='$datainfo[20]',s_double='$datainfo[21]',r_show=1 where MID=$datainfo[0]";

                mysql_db_query($dbname,$sql) or die(error);

                if ($datainfo[9]<>''){
                    $datainfo[9]=change_rate($open,$datainfo[9]);
                    $datainfo[10]=change_rate($open,$datainfo[10]);
                }
                if ($datainfo[13]<>''){
                    $datainfo[13]=change_rate($open,$datainfo[13]);
                    $datainfo[14]=change_rate($open,$datainfo[14]);
                }

                if ($league_id<>''){
                    if ($league_id==$dateinfo[2]){
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]');\n";
                        $K=$K+1;
                    }
                }else{
                $datainfo[1]=str_ireplace("Running Ball",$RunningBall,$datainfo[1]);
                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]');\n";
                    $K=$K+1;
                }
            }
            break;
        case "re":
                $sql="update volleyball set RE_Show=0 where RE_show=1 and ((re_uptime +  INTERVAL 30 SECOND) < now() or re_uptime='0000-00-00 00:00:00')";
                mysql_db_query($dbname,$sql);
        echo "parent.GameHead = new Array('gid','timer','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','no1','no2','no3','score_h','score_c','no4','no5','no6','no7','no8','no9','no10','no11','no12','lastestscore_h','lastestscore_c','eventid','hot','center_tv','play','datetime','retimeset','more');\n";
            echo "parent.minlimit_VAR='';\n";
            echo "parent.maxlimit_VAR='';\n";
                echo "parent.retime=30;\n";
                echo "parent.str_renew = '$udpsecond';\n";
                if ($league_id<>''){
                    echo "parent.game_sw=1;\n";
                    echo "parent.l_name='$league_id';\n";
                }
                $page_count=$cou/$pagecount;
                echo "parent.t_page=$t_page;\n";
                if(!$cou)$cou=0;
                echo "parent.gamount=$cou;\n";
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

                        $sql = "update volleyball set m_time='$status',fopen=$close,ShowType='$datainfo[7]',M_RE_LetB='$datainfo[8]',M_Dime='$m_re_dime',MB_LetB_Rate='$datainfo[9]',TG_LetB_Rate='$datainfo[10]',TG_Dime_Rate='$datainfo[13]',MB_Dime_Rate='$datainfo[14]',mb_ball='$datainfo[18]',tg_ball='$datainfo[19]',re_Show=1 where MID=$datainfo[0]";
                        mysql_db_query($dbname,$sql);

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
                            echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]');\n";
                            $K=$K+1;
                        }
                    }else{
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]','$datainfo[26]','$datainfo[27]','$datainfo[28]','$datainfo[29]','$datainfo[30]','$datainfo[31]','$datainfo[32]','$datainfo[33]','$datainfo[34]','$datainfo[35]','$datainfo[36]','$datainfo[37]');\n";
                        $K=$K+1;
                    }
                }
            break;
        case "pd":
        /*
            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,OVTG,ShowType from volleyball where`m_start` > now( ) AND `m_Date` ='$mDate'".$league." and PD_Show=1 and MB2TG1!=0 and $mb_team<>'' order by m_start,mid";

            $result = mysql_db_query($dbname, $mysql);
            $cou=mysql_num_rows($result);
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            while ($row=mysql_fetch_array($result)){
                echo "parent.GameFT[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[OVMB]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','$row[OVTG]');\n";
                $K=$K+1;
            }

            $page_count=$cou/$pagecount;
            if ($cou>$pagecount and $sel_lid==''){
                $cou=$pagecount;
            }
            */
            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3');\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.minlimit_VAR='';\n";
            echo "parent.maxlimit_VAR='';\n";
            echo "parent.retime=0;\n";
                if(!$cou)$cou=0;
            echo "parent.gamount=$cou;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");

                $sql = "update volleyball set MB1TG0='$datainfo[8]',MB2TG0='$datainfo[9]',MB2TG1='$datainfo[10]',MB3TG0='$datainfo[11]',MB3TG1='$datainfo[12]',MB3TG2='$datainfo[13]',MB4TG0='$datainfo[14]',MB4TG1='$datainfo[15]',MB4TG2='$datainfo[16]',MB4TG3='$datainfo[17]',PD_Show=1 where MID=$datainfo[0]";

                mysql_db_query($dbname,$sql) or die(error);


                if ($league_id<>''){
                    if ($league_id==$dateinfo[2]){
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]');\n";
                        $K=$K+1;
                    }
                }else{
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]');\n";
                    $K=$K+1;
                }

            }
            break;
        case "p":
            /*
            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB_P_Win,TG_P_Win,M_P_Flat,MB_MID,TG_MID,ShowType from volleyball where`m_start` > now( ) AND `m_Date` ='$mDate'".$league." and P_Show=1 and $mb_team<>'' order by m_start,mid";
            $result = mysql_db_query($dbname, $mysql);

            $cou=mysql_num_rows($result);
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            while ($row=mysql_fetch_array($result)){
                $mb_team=str_replace("[$bzmb]","",$row['MB_Team']);
                if (strlen(ltrim($row['M_Time']))<=5){
                    $pdate=$row[M_Date].'<br>0'.$row[M_Time];
                }else{
                    $pdate=$row[M_Date].'<br>'.$row[M_Time];
                }
                echo "parent.GameFT[$K]= Array('$row[MID]','$pdate','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$mb_team','$row[TG_Team]','$row[ShowType]','$row[MB_P_Win]','$row[TG_P_Win]','$row[M_P_Flat]');\n";
                $K=$K+1;
            }
            $page_count=$cou/$pagecount;
            if ($cou>$pagecount and $sel_lid==''){
                $cou=$pagecount;
            }
        */
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");
                $sql = "update volleyball set MB_P_Win='$datainfo[8]',TG_P_Win='$datainfo[9]',M_P_Flat ='$datainfo[10]',P_Show=1 where MID=$datainfo[0]";
                mysql_db_query($dbname,$sql) or die(error);


                if ($league_id<>''){
                    if ($league_id==$dateinfo[2]){
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]');\n";
                        $K=$K+1;
                    }
                }else{
                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]');\n";
                    $K=$K+1;
                }
            }
            break;
        case "pr":

        echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_PRH','ior_PRC','ratio_o','ratio_u','ior_POUC','ior_POUH','gidm','par_minlimit','par_maxlimit');\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.minlimit_VAR='0';\n";
            echo "parent.maxlimit_VAR='0';\n";
            echo "parent.retime=0;\n";
                if(!$cou)$cou=0;
            echo "parent.gamount=$cou;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");
                $sql = "update volleyball set MB_PR_LetB_rate='$datainfo[9]',TG_PR_letb_rate='$datainfo[10]',MB_PR_Dime_Rate='$datainfo[13]',TG_PR_Dime_Rate='$datainfo[14]',PR_Show=1 where MID=$datainfo[0]";
                mysql_db_query($dbname,$sql) or die(error);

                if ($league_id<>''){
                    if ($league_id==$dateinfo[2]){
                        echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]');\n";
                        $K=$K+1;
                    }
                }else{
                    echo "parent.GameFT[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]');\n";
                    $K=$K+1;
                }
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
