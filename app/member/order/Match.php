<?php
require ("../include/config.inc.php");
$langx=!empty($_REQUEST['langx'])?$_REQUEST['langx']:'zh-cn';
require ("../include/traditional.$langx.inc.php");
/**
 * Created by PhpStorm.
 * User: LIYUQING
 * Date: 2017-8-23
 * Time: 13:29
 */
function getFootMatch($page_no){
    $K=0;
    $offset=$page_no*60;
    $mysql = "select moredata,more,MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font color=red>$re_red</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB,$m_league as M_League,MB_Win,TG_Win,M_Flat,if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,concat('O',m_dime) as MB_Dime,concat('U',m_dime) as TG_Dime,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,if(s_single=0,'',FORMAT(s_single-$rate,2)) as s_single,if(s_double=0,'',FORMAT(s_double-$rate,2)) as s_double from foot_match where `m_start` > now( ) and R_Show=1 AND `m_Date` ='$mDate'".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1  order by  M_League_tw,M_Time,display  limit $offset,60;";
    $result = mysql_query( $mysql);
    while ($row=mysql_fetch_array($result)){
        $mid=$row['MID']+1;
        $sql1="select MB_Win,TG_Win,M_Flat,if(MB_Dime_Rate=0,'',FORMAT(MB_Dime_Rate-$rate,3)) as MB_Dime_Rate,if(TG_Dime_Rate=0,'',FORMAT(TG_Dime_Rate-$rate,3)) as TG_Dime_Rate,concat('O',m_dime) as MB_Dime,concat('U',m_dime) as TG_Dime,M_LetB,if(MB_LetB_Rate=0,'',FORMAT(MB_LetB_Rate-$rate,3)) as MB_LetB_Rate,if(TG_LetB_Rate=0,'',FORMAT(TG_LetB_Rate-$rate,3)) as TG_LetB_Rate,MB_MID,TG_MID,ShowType,my_play_more from foot_match where mid=".$mid;
        $result1 = mysql_query( $sql1);
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