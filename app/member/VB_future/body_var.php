<?
include "../include/library.mem.php";
echo "<script>if(self == top) parent.location='/'</script>";
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

$sql = "select * from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/','_top')</script>";
	exit;
}
$open    = $row['OpenType'];
$langx   = $row['language'];
$memname = $row['Memname'];
$credit  = $row['Money'];
require ("../include/traditional.$langx.inc.php");

if ($page_no==''){$page_no=0;}
$pagecount=40;
$mDate=date('m-d');
$K=0;
if($g_date==""){
	$g_date="ALL";
}
?>
<HEAD><TITLE></TITLE>
	<META http-equiv=Content-Type content="text/html; charset=utf-8">
	<SCRIPT language=JavaScript>
		parent.username='<?=$memname?>';
		parent.maxcredit='<?=$credit?>';
		parent.code='H(RMB)';
		parent.uid='<?=$uid?>';
		parent.msg='<?=$mem_msg?>';
		parent.ltype='1';
		parent.str_even = '<?=$Draw?>';
		parent.str_submit = '<?=$Confirm?>';
		parent.str_reset = '<?=$Resets?>';
		parent.langx='<?=$langx?>';
		parent.rtype='<?php echo $rtype?>';
		parent.sel_lid='<?php echo $league_id?>';
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
            $base_url = "".$site."/app/member/VB_future/index.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=3";
            $thisHttp = new cHTTP();
            $thisHttp->setReferer($base_url);
            $filename="".$site."/app/member/VB_future/body_var.php?rtype=$rtype&uid=$suid&langx=$langx&mtype=3&g_date=$g_date&league_id=$league_id&page_no=".$page_no;
            $thisHttp->getPage($filename);
            $msg  = $thisHttp->getContent();
            $meg .= gzinflate(substr($msg,10));
            $meg=str_replace('parent.GameFT=new Array();','',$meg);
            $meg=str_replace('parent.GameHead = new Array','',$meg);
            $pb=explode('t_page=',$meg);
            $pb=explode(';',$pb[1]);
            $t_page=$pb[0];
            if($t_page==""){
            $t_page=0;
            }

            $gameCount=explode('gameCount=',$meg);
            $gameCount=explode(';',$gameCount[1]);
            $gameCount=$gameCount[0];
            if($gameCount=='' or $gameCount<0){
                $gameCount=0;
            }
            echo "parent.gameCount=$gameCount;\n";

            preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
            $cou=sizeof($matches[0])-1;

        switch ($rtype){
        case "r":
            /*
            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB,$m_league as M_League,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,$mb_dime as MB_Dime,$tg_dime as TG_Dime,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,s_single,s_double from volleyball where`m_start` > now( ) AND `m_Date` ='$mDate'".$league." and R_Show=1 and $mb_team<>'' order by m_start,mid";
            $result = mysql_db_query($dbname, $mysql);
            $cou_num=mysql_num_rows($result);
            $page_size=40;
            $page_count=$cou_num/$page_size;
            $offset=$page_no*40;
            echo "parent.t_page=$page_count;\n";
            $mysql=$mysql."  limit $offset,40;";
        //echo $mysql;
            $result = mysql_db_query($dbname, $mysql);
            $cou=mysql_num_rows($result);
            echo "parent.str_renew = '$udpsecond';\n";
            echo "parent.retime=180;\n";
            echo "parent.gamount=$cou;\n";

            while ($row=mysql_fetch_array($result)){
                $MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
                $TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);
                $MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
                $TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
                $s_single=change_rate($open,$row[s_single]);
                $s_double=change_rate($open,$row[s_double]);

                if ($row['M_Type']==1){
                    echo "parent.GameVB[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]<br><font style=background-color=red>$run</font>','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$Odd','$Even','$s_single','$s_double','0','0');\n";
                }else{
                    echo "parent.GameVB[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[M_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$row[MB_Dime]','$row[TG_Dime]','$TG_Dime_Rate','$MB_Dime_Rate','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$Odd','$Even','$s_single','$s_double','0','0');\n";
                }
            $K=$K+1;
            }
            */
            echo "parent.retime=180;\n";
            echo "parent.str_renew = '$udpsecond';\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_RH','ior_RC','ratio_o','ratio_u','ior_OUH','ior_OUC','ior_MH','ior_MC','ior_MN','str_odd','str_even','ior_EOO','ior_EOE','more','eventid','hot','play');\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
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
                        echo "parent.GameVB[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]');\n";
                        $K=$K+1;
                    }
                }else{
                    echo "parent.GameVB[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]','$datainfo[18]','$datainfo[19]','$datainfo[20]','$datainfo[21]','$datainfo[22]','$datainfo[23]','$datainfo[24]','$datainfo[25]');\n";
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
                echo "parent.GameVB[$K]= Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$row[MB1TG0]','$row[MB2TG0]','$row[MB2TG1]','$row[MB3TG0]','$row[MB3TG1]','$row[MB3TG2]','$row[MB4TG0]','$row[MB4TG1]','$row[MB4TG2]','$row[MB4TG3]','$row[MB0TG0]','$row[MB1TG1]','$row[MB2TG2]','$row[MB3TG3]','$row[MB4TG4]','$row[OVMB]','$row[MB0TG1]','$row[MB0TG2]','$row[MB1TG2]','$row[MB0TG3]','$row[MB1TG3]','$row[MB2TG3]','$row[MB0TG4]','$row[MB1TG4]','$row[MB2TG4]','$row[MB3TG4]','$row[OVTG]');\n";
                $K=$K+1;
            }

            $page_count=$cou/$pagecount;
            if ($cou>$pagecount and $sel_lid==''){
                $cou=$pagecount;
            }
            */
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.t_page=$t_page;\n";
            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ior_H2C0','ior_H2C1','ior_H3C0','ior_H3C1','ior_H3C2','ior_H0C2','ior_H1C2','ior_H0C3','ior_H1C3','ior_H2C3');\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");

                $sql = "update volleyball set MB1TG0='$datainfo[8]',MB2TG0='$datainfo[9]',MB2TG1='$datainfo[10]',MB3TG0='$datainfo[11]',MB3TG1='$datainfo[12]',MB3TG2='$datainfo[13]',MB4TG0='$datainfo[14]',MB4TG1='$datainfo[15]',MB4TG2='$datainfo[16]',MB4TG3='$datainfo[17]',PD_Show=1 where MID=$datainfo[0]";

                mysql_db_query($dbname,$sql) or die(error);


                if ($league_id<>''){
                    if ($league_id==$dateinfo[2]){
                        echo "parent.GameVB[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]');\n";
                        $K=$K+1;
                    }
                }else{
                        echo "parent.GameVB[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]','$datainfo[15]','$datainfo[16]','$datainfo[17]');\n";
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
                echo "parent.GameVB[$K]= Array('$row[MID]','$pdate','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$mb_team','$row[TG_Team]','$row[ShowType]','$row[MB_P_Win]','$row[TG_P_Win]','$row[M_P_Flat]');\n";
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
                        echo "parent.GameVB[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]');\n";
                        $K=$K+1;
                    }
                }else{
                    echo "parent.GameVB[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]');\n";
                    $K=$K+1;
                }
            }
            break;
        case "pr":
            /*
            $mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB_PR_LetB,TG_PR_LetB,$m_letb as M_PR_LetB,MB_MID,TG_MID,ShowType,$mb_dime as MB_Dime,$tg_dime as TG_Dime,MB_Dime_Rate,TG_Dime_Rate from volleyball where`m_start` > now( ) AND `m_Date` ='$mDate'".$league." and PR_Show=1 and $mb_team<>'' and MB_PR_LetB-0.03>0 order by m_start,mid";
            $result = mysql_db_query($dbname, $mysql);
            $cou=mysql_num_rows($result);
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            while ($row=mysql_fetch_array($result)){
                $MB_PR_LetB=change_rate($open,$row['MB_PR_LetB']);
                $TG_PR_LetB=change_rate($open,$row['TG_PR_LetB']);
                $M_letb=$row['M_PR_LetB'];
                $mb_team=trim($row['MB_Team']);

                if (strlen($row['M_Time'])==5){
                    $pdate=$row[M_Date].'<br>0'.$row[M_Time];
                }else{
                    $pdate=$row[M_Date].'<br>'.$row[M_Time];
                }
                echo "parent.GameVB[$K]= Array('$row[MID]','$pdate','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$mb_team','$row[TG_Team]','$row[ShowType]','$row[M_PR_LetB]','$row[MB_PR_LetB]','$row[TG_PR_LetB]','$row[MB_Dime]','$row[TG_Dime]','$row[MB_Dime_Rate]','$row[TG_Dime_Rate]');\n";
                $K=$K+1;
            }

            $page_count=$cou/$pagecount;
            if ($cou>$pagecount and $sel_lid==''){
                $cou=$pagecount;
            }
        */
            echo "parent.retime=0;\n";
            echo "parent.gamount=$cou;\n";
            echo "parent.GameHead = new Array('gid','datetime','league','gnum_h','gnum_c','team_h','team_c','strong','ratio','ior_PRH','ior_PRC','ratio_o','ratio_u','ior_POUH','ior_POUC','gidm','par_minlimit','par_maxlimit');\n";
            echo "parent.t_page=$t_page;\n";
            for($i=0;$i<$cou;$i++){
                $messages=$matches[0][$i];
                $messages=str_replace(");",")",$messages);
                $messages=str_replace("cha(9)","",$messages);
                $datainfo=eval("return $messages;");
                $sql = "update volleyball set MB_PR_LetB_rate='$datainfo[9]',TG_PR_letb_rate='$datainfo[10]',MB_PR_Dime_Rate='$datainfo[13]',TG_PR_Dime_Rate='$datainfo[14]',PR_Show=1 where MID=$datainfo[0]";
                mysql_db_query($dbname,$sql) or die(error);

                if ($league_id<>''){
                    if ($league_id==$dateinfo[2]){
                        echo "parent.GameVB[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]');\n";
                        $K=$K+1;
                    }
                }else{
                    echo "parent.GameVB[$K]= Array('$datainfo[0]','$datainfo[1]','$datainfo[2]','$datainfo[3]','$datainfo[4]','$datainfo[5]','$datainfo[6]','$datainfo[7]','$datainfo[8]','$datainfo[9]','$datainfo[10]','$datainfo[11]','$datainfo[12]','$datainfo[13]','$datainfo[14]');\n";
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
			if(parent.loading == 'N' && parent.ShowType != '')
			{
				parent.ShowGameList();
			}
		}

	</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad();"></body>
</html>
