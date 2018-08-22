<?php

include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");

$gid   = $_REQUEST['gid'];
$uid   = $_REQUEST['uid'];
$ltype = $_REQUEST['ltype'];
$langx = $_REQUEST['langx'];
$gtype = $_REQUEST['gtype'];
$date = $_REQUEST['date'];
$url=BROWSER_IP.'/app/member/get_game_allbets.php?uid='.$uid.'&langx='.$langx.'& gtype=FT&showtype=RB&gid='.$gid.'& ltype='.$ltype.'&date='.$date;

$xml =simpleXML_load_file($url);
$code=$xml->code;

if($code=='615'){
	$games=$xml->game;
	foreach($games as $game){
		$ds="";
		$MID=$game->gid;//MID
		$ds=$ds."gidm='".$game->gidm."',";//gidm 同一球队的场多下注的唯一标识
		
		//15分钟: 让球 - 上半场开始 - 14:59分钟
		$ds=$ds."ratio_ar='".$game->ratio_are."',";//让球盘口
		$ds=$ds."ior_ARH='".$game->ior_AREH."',";//让球主队赔率
		$ds=$ds."ior_ARC='".$game->ior_AREC."',";//让球客队赔率
		// 大 / 小-
		$ds=$ds."ratio_aouo='".$game->ratio_arouo."',";//大小主队盘口
		$ds=$ds."ratio_aouu='".$game->ratio_arouo."',";//大小客队盘口
		$ds=$ds."ior_AOUO='".$game->ior_AROUO."',";//大小主队赔率
		$ds=$ds."ior_AOUU='".$game->ior_AROUU."',";//大小客队赔率
		//独赢 
		$ds=$ds."ior_AMH='".$game->ior_ARMH."',";//主队赔率
		$ds=$ds."ior_AMC='".$game->ior_ARMC."',";//和赔率
		$ds=$ds."ior_AMN='".$game->ior_ARMN."',";//客队赔率
		
		
		
		
		//15分钟: 让球 - 15:00 - 29:59分钟
		$ds=$ds."ratio_br='".$game->ratio_bre."',";//让球盘口
		$ds=$ds."ior_BRH='".$game->ior_BERH."',";//让球主队赔率
		$ds=$ds."ior_BRC='".$game->ior_BERC."',";//让球客队赔率
		// 大 / 小
		$ds=$ds."ratio_bouo='".$game->ratio_brouo."',";//大小主队盘口
		$ds=$ds."ratio_bouu='".$game->ratio_brouo."',";//大小客队盘口
		$ds=$ds."ior_BOUO='".$game->ior_BROUO."',";//大小主队赔率
		$ds=$ds."ior_BOUU='".$game->ior_BROUU."',";//大小客队赔率
		//独赢
		$ds=$ds."ior_BMH='".$game->ior_BRMH."',";//主队赔率
		$ds=$ds."ior_BMC='".$game->ior_BRMC."',";//和赔率
		$ds=$ds."ior_BMN='".$game->ior_BRMN."',";//客队赔率
		
		
		//15分钟比分
		$ds=$ds."MB15_Ball='".$game->score_h_A."',";//
		$ds=$ds."TG15_Ball='".$game->score_c_A."',";//
		
		$ds=$ds."MB16_Ball='".$game->score_h_B."',";//
		$ds=$ds."TG16_Ball='".$game->score_c_B."',";//
		
		$ds=$ds."MB17_Ball='".$game->score_h_D."',";//
		$ds=$ds."TG17_Ball='".$game->score_c_D."',";//
		
		$ds=$ds."MB18_Ball='".$game->score_h_E."',";//
		$ds=$ds."TG18_Ball='".$game->score_c_E."',";//
		
		
		//15分钟: 让球 - 下半场开始 - 59:59分钟
		$ds=$ds."ratio_dr='".$game->ratio_dre."',";//让球盘口
		$ds=$ds."ior_DRH='".$game->ior_DREH."',";//让球主队赔率
		$ds=$ds."ior_DRC='".$game->ior_DREC."',";//让球客队赔率
		//大 / 小
		$ds=$ds."ratio_douo='".$game->ratio_drouo."',";//大小主队盘口
		$ds=$ds."ratio_douu='".$game->ratio_drouo."',";//大小客队盘口
		$ds=$ds."ior_DOUO='".$game->ior_DROUO."',";//大小主队赔率
		$ds=$ds."ior_DOUU='".$game->ior_DROUU."',";//大小客队赔率
		//独赢
		$ds=$ds."ior_DMH='".$game->ior_DRMH."',";//主队赔率
		$ds=$ds."ior_DMC='".$game->ior_DRMC."',";//和赔率
		$ds=$ds."ior_DMN='".$game->ior_DRMN."',";//客队赔率
		
		
		
		//15分钟: 让球 - 60:00 - 74:59分钟
		$ds=$ds."ratio_er='".$game->ratio_ere."',";//让球盘口
		$ds=$ds."ior_ERH='".$game->ior_EREH."',";//让球主队赔率
		$ds=$ds."ior_ERC='".$game->ior_EREC."',";//让球客队赔率
		//大 / 小
		$ds=$ds."ratio_eouo='".$game->ratio_erouo."',";//大小主队盘口
		$ds=$ds."ratio_eouu='".$game->ratio_erouo."',";//大小客队盘口
		$ds=$ds."ior_EOUO='".$game->ior_EROUO."',";//大小主队赔率
		$ds=$ds."ior_EOUU='".$game->ior_EROUU."',";//大小客队赔率
		//独赢
		$ds=$ds."ior_EMH='".$game->ior_ERMH."',";//主队赔率
		$ds=$ds."ior_EMC='".$game->ior_ERMC."',";//和赔率
		$ds=$ds."ior_EMN='".$game->ior_ERMN."',";//客队赔率
		
		
		
		
		
		//输赢比分
		$ds=$ds."ior_WMH1='".$game->ior_RWMH1."',";//净赢1球（主）
		$ds=$ds."ior_WMC1='".$game->ior_RWMC1."',";//净赢1球（客）
		
		$ds=$ds."ior_WMH2='".$game->ior_RWMH2."',";//净赢2球（主）
		$ds=$ds."ior_WMC2='".$game->ior_RWMC2."',";//净赢2球（客）
		
		$ds=$ds."ior_WMH3='".$game->ior_RWMH3."',";//净赢3球（主）
		$ds=$ds."ior_WMC3='".$game->ior_RWMC3."',";//净赢3球（客）
		
		$ds=$ds."ior_WMHOV='".$game->ior_RWMHOV."',";//净赢4球或更多（主）
		$ds=$ds."ior_WMCOV='".$game->ior_RWMCOV."',";//净赢4球或更多（客）
		
		
		$ds=$ds."ior_WM0='".$game->ior_RWM0."',";//无进球
		$ds=$ds."ior_WMN='".$game->ior_RWMN."',";//任何进球和局
		
		
		//双赢盘
		$ds=$ds."ior_DCHN='".$game->ior_RDCHN."',";//主
		$ds=$ds."ior_DCCN='".$game->ior_RDCCN."',";//客
		$ds=$ds."ior_DCHC='".$game->ior_RDCHC."',";//和
		
		
		
		
		//赢得任一半场
		$ds=$ds."ior_WEH='".$game->ior_RWEH."',";//赔率(主)
		$ds=$ds."ior_WEC='".$game->ior_RWEC."',";//赔率(客)
		
		
		//赢得所有半场
		$ds=$ds."ior_WBH='".$game->ior_RWBH."',";//赔率(主)
		$ds=$ds."ior_WBC='".$game->ior_RWBC."',";//赔率(客)
		
		//第一进球
		$ds=$ds."ior_ARGH='".$game->ior_ARGH."',";//主
		$ds=$ds."ior_ARGC='".$game->ior_ARGC."',";//客
		$ds=$ds."ior_ARGN='".$game->ior_ARGN."',";//无
		
		//第二进球
		$ds=$ds."ior_BRGH='".$game->ior_BRGH."',";//主
		$ds=$ds."ior_BRGC='".$game->ior_BRGC."',";//客
		$ds=$ds."ior_BRGN='".$game->ior_BRGN."',";//无
		
		//第三进球
		$ds=$ds."ior_CRGH='".$game->ior_CRGH."',";//主
		$ds=$ds."ior_CRGC='".$game->ior_CRGC."',";//客
		$ds=$ds."ior_CRGN='".$game->ior_CRGN."',";//无
		
		//第四进球
		$ds=$ds."ior_DRGH='".$game->ior_DRGH."',";//主
		$ds=$ds."ior_DRGC='".$game->ior_DRGC."',";//客
		$ds=$ds."ior_DRGN='".$game->ior_DRGN."',";//无
		
		//第五进球
		$ds=$ds."ior_ERGH='".$game->ior_ERGH."',";//主
		$ds=$ds."ior_ERGC='".$game->ior_ERGC."',";//客
		$ds=$ds."ior_ERGN='".$game->ior_ERGN."',";//无
		
		//第六进球
		$ds=$ds."ior_FRGH='".$game->ior_FRGH."',";//主
		$ds=$ds."ior_FRGC='".$game->ior_FRGC."',";//客
		$ds=$ds."ior_FRGN='".$game->ior_FRGN."',";//无
		
		//第七进球
		$ds=$ds."ior_GRGH='".$game->ior_GRGH."',";//主
		$ds=$ds."ior_GRGC='".$game->ior_GRGC."',";//客
		$ds=$ds."ior_GRGN='".$game->ior_GRGN."',";//无
		
		//第八进球
		$ds=$ds."ior_IRGH='".$game->ior_IRGH."',";//主
		$ds=$ds."ior_IRGC='".$game->ior_IRGC."',";//客
		$ds=$ds."ior_IRGN='".$game->ior_IRGN."',";//无
		
		//第九进球
		$ds=$ds."ior_IRGH='".$game->ior_IRGH."',";//主
		$ds=$ds."ior_IRGC='".$game->ior_IRGC."',";//客
		$ds=$ds."ior_IRGN='".$game->ior_IRGN."',";//无
		
		
		//第十进球
		$ds=$ds."ior_JRGH='".$game->ior_JRGH."',";//主
		$ds=$ds."ior_JRGC='".$game->ior_JRGC."',";//客
		$ds=$ds."ior_JRGN='".$game->ior_JRGN."',";//无
		
		
		//球队入球数
		
		//大小 -全场
		$ds=$ds."ratio_ouho='".$game->ratio_rouho."',";//主队大盘口
		$ds=$ds."ratio_ouhu='".$game->ratio_rouhu."',";//主队小盘口
		$ds=$ds."ior_OUHO='".$game->ior_ROUHO."',";//主队大赔率
		$ds=$ds."ior_OUHU='".$game->ior_ROUHU."',";//主队小赔率
		
		$ds=$ds."ratio_ouco='".$game->ratio_rouco."',";//客队大盘口
		$ds=$ds."ratio_oucu='".$game->ratio_roucu."',";//客队小盘口
		$ds=$ds."ior_OUCO='".$game->ior_ROUCO."',";//客队大赔率
		$ds=$ds."ior_OUCU='".$game->ior_ROUCU."',";//客队小赔率
		
		
		
		
		
		//K
		//滚球波胆
		$ds=$ds."ior_RH1C0='".$game->ior_RH1C0."',";//1-0
		$ds=$ds."ior_RH2C0='".$game->ior_RH2C0."',";//2-0
		$ds=$ds."ior_RH0C0='".$game->ior_RH0C0."',";//0-0
		$ds=$ds."ior_RH0C1='".$game->ior_RH0C1."',";//0-1
		$ds=$ds."ior_RH0C2='".$game->ior_RH0C2."',";//0-2
		
		$ds=$ds."ior_RH2C1='".$game->ior_RH2C1."',";//2-1
		$ds=$ds."ior_RH3C0='".$game->ior_RH3C0."',";//3-0
		$ds=$ds."ior_RH1C1='".$game->ior_RH1C1."',";//1-1
		$ds=$ds."ior_RH1C2='".$game->ior_RH1C2."',";//1-2
		$ds=$ds."ior_RH0C3='".$game->ior_RH0C3."',";//0-3
		
		$ds=$ds."ior_RH3C1='".$game->ior_RH3C1."',";//3-1
		$ds=$ds."ior_RH3C2='".$game->ior_RH3C2."',";//3-2
		$ds=$ds."ior_RH2C2='".$game->ior_RH2C2."',";//2-2
		$ds=$ds."ior_RH1C3='".$game->ior_RH1C3."',";//1-3
		$ds=$ds."ior_RH2C3='".$game->ior_RH2C3."',";//2-3
		
		
		$ds=$ds."ior_RH4C0='".$game->ior_RH4C0."',";//4-0
		$ds=$ds."ior_RH4C1='".$game->ior_RH4C1."',";//4-1
		$ds=$ds."ior_RH3C3='".$game->ior_RH3C3."',";//3-3
		$ds=$ds."ior_RH0C4='".$game->ior_RH0C4."',";//0-4
		$ds=$ds."ior_RH1C4='".$game->ior_RH1C4."',";//1-4
		
		
		$ds=$ds."ior_RH4C2='".$game->ior_RH4C2."',";//4-2
		$ds=$ds."ior_RH4C3='".$game->ior_RH4C3."',";//4-3
		$ds=$ds."ior_RH4C4='".$game->ior_RH4C4."',";//4-4
		$ds=$ds."ior_RH2C4='".$game->ior_RH2C4."',";//2-4
		$ds=$ds."ior_RH3C4='".$game->ior_RH3C4."',";//3-4
		
		$ds=$ds."ior_ROVH='".$game->ior_ROVH."',";//其他
		
		
		
		
		
		
		//总入球数
		$ds=$ds."ior_RT01='".$game->ior_RT01."',";//0-1
		$ds=$ds."ior_RT23='".$game->ior_RT23."',";//2-3
		$ds=$ds."ior_RT46='".$game->ior_RT46."',";//4-6
		$ds=$ds."ior_ROVER='".$game->ior_ROVER."',";//7或以上
		
		
		
		
		
		
		
		//半场 / 全场
		$ds=$ds."ior_RFHH='".$game->ior_RFHH."',";//主 / 主
		$ds=$ds."ior_RFNH='".$game->ior_RFNH."',";//和 / 主
		$ds=$ds."ior_RFCH='".$game->ior_RFCH."',";//客 / 主
		
		$ds=$ds."ior_RFHN='".$game->ior_RFHN."',";//主 / 和
		$ds=$ds."ior_RFNN='".$game->ior_RFNN."',";//和 / 和
		$ds=$ds."ior_RFCN='".$game->ior_RFCN."',";//客 / 和
		
		$ds=$ds."ior_RFHC='".$game->ior_RFHC."',";//主 / 客
		$ds=$ds."ior_RFNC='".$game->ior_RFNC."',";//和 / 客
		$ds=$ds."ior_RFCC='".$game->ior_RFCC."',";//客 / 客
		
		
		
		
		
		
		//J
		
		/*//单双 -全场
		$ds=$ds."ior_EOO='".$game->ior_EOO."',";//主队单赔率
		$ds=$ds."ior_EOE='".$game->ior_EOE."',";//主队双赔率
		
		//单双 -上半场
		$ds=$ds."ior_HEOO='".$game->ior_HEOO."',";//主队单赔率
		$ds=$ds."ior_HEOE='".$game->ior_HEOE."',";//主队双赔率
		
		*/
		//双方球队进球
		$ds=$ds."ior_TSY='".$game->ior_RTSY."',";//是
		$ds=$ds."ior_TSN='".$game->ior_RTSN."',";//否
		
		//零失球
		$ds=$ds."ior_CSH='".$game->ior_RCSH."',";//主
		$ds=$ds."ior_CSC='".$game->ior_RCSC."',";//客
		
		
		//零失球获胜
		$ds=$ds."ior_WNH='".$game->ior_RWNH."',";//主
		$ds=$ds."ior_WNC='".$game->ior_RWNC."',";//客
		
		//最多进球的半场
		$ds=$ds."ior_HGH='".$game->ior_RHGH."',";//上半场
		$ds=$ds."ior_HGC='".$game->ior_RHGC."',";//下半场
		
		//最多进球的半场 - 独赢
		$ds=$ds."ior_MGH='".$game->ior_RMGH."',";//上半场
		$ds=$ds."ior_MGC='".$game->ior_RMGC."',";//下半场
		$ds=$ds."ior_MGN='".$game->ior_RMGM."',";//和
		
		
		//双半场进球
		$ds=$ds."ior_SBH='".$game->ior_RSBH."',";//主
		$ds=$ds."ior_SBC='".$game->ior_RSBC."',";//客
		
		
		
		
		//首个进球时间 - 三项
		$ds=$ds."ior_T3G1='".$game->ior_RT3G1."',";//第26分钟或之前
		$ds=$ds."ior_T3G2='".$game->ior_RT3G2."',";//第27分钟或之后
		$ds=$ds."ior_T3GN='".$game->ior_RT3GN."',";//无进球
		
		
		//首个进球时间
		$ds=$ds."ior_T1G1='".$game->ior_RT1G1."',";//0 - 14:59分钟
		$ds=$ds."ior_T1G2='".$game->ior_RT1G2."',";//15 - 29:59分钟
		$ds=$ds."ior_T1G3='".$game->ior_RT1G3."',";//30 - 半场
		$ds=$ds."ior_T1G4='".$game->ior_RT1G4."',";//下半场开始 - 59:59分钟
		$ds=$ds."ior_T1G5='".$game->ior_RT1G5."',";//60 - 74:59分钟
		$ds=$ds."ior_T1G6='".$game->ior_RT1G6."',";//75分钟 - 全场
		$ds=$ds."ior_T1GN='".$game->ior_RT1GN."'";//无进球
		
		
		
		//echo $ds."<BR>";
		$sql = "update foot_match set ".$ds." where MID='".$MID."'";
		mysql_db_query($dbname,$sql);
		echo $sql.'<BR>';
		//上半场
		$ds1="";
		$MID1=$game->hgid;//MID
		
		//球队入球数
		//大小 -上半场
		$ds1=$ds1."ratio_houho='".$game->ratio_hruho."',";//主队大盘口
		$ds1=$ds1."ratio_houhu='".$game->ratio_hruhu."',";//主队小盘口
		$ds1=$ds1."ior_HOUHO='".$game->ior_HRUHO."',";//主队大赔率
		$ds1=$ds1."ior_HOUHU='".$game->ior_HRUHU."',";//主队小赔率
		
		$ds1=$ds1."ratio_houco='".$game->ratio_hruco."',";//客队大盘口
		$ds1=$ds1."ratio_houcu='".$game->ratio_hrucu."',";//客队小盘口
		$ds1=$ds1."ior_HOUCO='".$game->ior_HRUCO."',";//客队大赔率
		$ds1=$ds1."ior_HOUCU='".$game->ior_HRUCU."',";//客队小赔率
		//滚球上半波胆
		$ds1=$ds1."ior_HRH1C0='".$game->ior_HRH1C0."',";//1-0
		$ds1=$ds1."ior_HRH2C0='".$game->ior_HRH2C0."',";//2-0
		$ds1=$ds1."ior_HRH0C0='".$game->ior_HRH0C0."',";//0-0
		$ds1=$ds1."ior_HRH0C1='".$game->ior_HRH0C1."',";//0-1
		$ds1=$ds1."ior_HRH0C2='".$game->ior_HRH0C2."',";//0-2
		
		$ds1=$ds1."ior_HRH2C1='".$game->ior_HRH2C1."',";//2-1
		$ds1=$ds1."ior_HRH3C0='".$game->ior_HRH3C0."',";//3-0
		$ds1=$ds1."ior_HRH1C1='".$game->ior_HRH1C1."',";//1-1
		$ds1=$ds1."ior_HRH1C2='".$game->ior_HRH1C2."',";//1-2
		$ds1=$ds1."ior_HRH0C3='".$game->ior_HRH0C3."',";//0-3
		
		$ds1=$ds1."ior_HRH3C1='".$game->ior_HRH3C1."',";//3-1
		$ds1=$ds1."ior_HRH3C2='".$game->ior_HRH3C2."',";//3-2
		$ds1=$ds1."ior_HRH2C2='".$game->ior_HRH2C2."',";//2-2
		$ds1=$ds1."ior_HRH1C3='".$game->ior_HRH1C3."',";//1-3
		$ds1=$ds1."ior_HRH2C3='".$game->ior_HRH2C3."',";//2-3
		
		
		$ds1=$ds1."ior_HRH3C3='".$game->ior_HRH3C3."',";//3-3
		$ds1=$ds1."ior_HROVH='".$game->ior_HROVH."',";//其他
		
		//单双上半场
		$ds1=$ds1."ior_HREOO='".$game->ior_HREOO."',";//单
		$ds1=$ds1."ior_HREOE='".$game->ior_HREOE."',";//双
		
		//总入球数上半场
		$ds1=$ds1."ior_HRT0='".$game->ior_HRT0."',";//0
		$ds1=$ds1."ior_HRT1='".$game->ior_HRT1."',";//1
		$ds1=$ds1."ior_HRT2='".$game->ior_HRT2."',";//2
		$ds1=$ds1."ior_HRTOV='".$game->ior_HRTOV."'";//3或以上
		
		
		
		$sql1 = "update foot_match set ".$ds1." where MID='".$MID1."'";
		mysql_db_query($dbname,$sql1);
		
	}
}

?>
