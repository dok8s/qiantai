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
$url=BROWSER_IP.'/app/member/get_game_allbets.php?uid='.$uid.'&langx='.$langx.'&gtype=FT&showtype=FT&gid='.$gid.'&ltype='.$ltype.'&date='.$date;
//echo "<script>alert('".$url."');<script>";
$xml =simpleXML_load_file($url);
$code=$xml->code;

if($code=='615'){
	$games=$xml->game;
	foreach($games as $game){
		//全场
		$ds="";
		$MID=$game->gid;//MID
		$ds=$ds."gidm='".$game->gidm."',";//gidm 同一球队的场多下注的唯一标识

		//15分钟: 让球 - 上半场开始 - 14:59分钟
		$ds=$ds."ratio_ar='".$game->ratio_ar."',";//让球盘口
		$ds=$ds."ior_ARH='".$game->ior_ARH."',";//让球主队赔率
		$ds=$ds."ior_ARC='".$game->ior_ARC."',";//让球客队赔率
		// 大 / 小-
		$ds=$ds."ratio_aouo='".$game->ratio_aouo."',";//大小主队盘口
		$ds=$ds."ratio_aouu='".$game->ratio_aouu."',";//大小客队盘口
		$ds=$ds."ior_AOUO='".$game->ior_AOUO."',";//大小主队赔率
		$ds=$ds."ior_AOUU='".$game->ior_AOUU."',";//大小客队赔率
		//独赢 
		$ds=$ds."ior_AMH='".$game->ior_AMH."',";//主队赔率
		$ds=$ds."ior_AMC='".$game->ior_AMC."',";//和赔率
		$ds=$ds."ior_AMN='".$game->ior_AMN."',";//客队赔率




		//15分钟: 让球 - 15:00 - 29:59分钟
		$ds=$ds."ratio_br='".$game->ratio_br."',";//让球盘口
		$ds=$ds."ior_BRH='".$game->ior_BRH."',";//让球主队赔率
		$ds=$ds."ior_BRC='".$game->ior_BRC."',";//让球客队赔率
		// 大 / 小
		$ds=$ds."ratio_bouo='".$game->ratio_bouo."',";//大小主队盘口
		$ds=$ds."ratio_bouu='".$game->ratio_bouo."',";//大小客队盘口
		$ds=$ds."ior_BOUO='".$game->ior_BOUO."',";//大小主队赔率
		$ds=$ds."ior_BOUU='".$game->ior_BOUU."',";//大小客队赔率
		//独赢
		$ds=$ds."ior_BMH='".$game->ior_BMH."',";//主队赔率
		$ds=$ds."ior_BMC='".$game->ior_BMC."',";//和赔率
		$ds=$ds."ior_BMN='".$game->ior_BMN."',";//客队赔率



		//15分钟: 让球 - 30:00 - 半场
		$ds=$ds."ratio_cr='".$game->ratio_cr."',";//让球盘口
		$ds=$ds."ior_CRH='".$game->ior_CRH."',";//让球主队赔率
		$ds=$ds."ior_CRC='".$game->ior_CRC."',";//让球客队赔率
		//大 / 小
		$ds=$ds."ratio_couo='".$game->ratio_couo."',";//大小主队盘口
		$ds=$ds."ratio_couu='".$game->ratio_couo."',";//大小客队盘口
		$ds=$ds."ior_COUO='".$game->ior_COUO."',";//大小主队赔率
		$ds=$ds."ior_COUU='".$game->ior_COUU."',";//大小客队赔率
		//独赢
		$ds=$ds."ior_CMH='".$game->ior_CMH."',";//主队赔率
		$ds=$ds."ior_CMC='".$game->ior_CMC."',";//和赔率
		$ds=$ds."ior_CMN='".$game->ior_CMN."',";//客队赔率



		//15分钟: 让球 - 下半场开始 - 59:59分钟
		$ds=$ds."ratio_dr='".$game->ratio_dr."',";//让球盘口
		$ds=$ds."ior_DRH='".$game->ior_DRH."',";//让球主队赔率
		$ds=$ds."ior_DRC='".$game->ior_DRC."',";//让球客队赔率
		//大 / 小
		$ds=$ds."ratio_douo='".$game->ratio_douo."',";//大小主队盘口
		$ds=$ds."ratio_douu='".$game->ratio_douo."',";//大小客队盘口
		$ds=$ds."ior_DOUO='".$game->ior_DOUO."',";//大小主队赔率
		$ds=$ds."ior_DOUU='".$game->ior_DOUU."',";//大小客队赔率
		//独赢
		$ds=$ds."ior_DMH='".$game->ior_DMH."',";//主队赔率
		$ds=$ds."ior_DMC='".$game->ior_DMC."',";//和赔率
		$ds=$ds."ior_DMN='".$game->ior_DMN."',";//客队赔率



		//15分钟: 让球 - 60:00 - 74:59分钟
		$ds=$ds."ratio_er='".$game->ratio_er."',";//让球盘口
		$ds=$ds."ior_ERH='".$game->ior_ERH."',";//让球主队赔率
		$ds=$ds."ior_ERC='".$game->ior_ERC."',";//让球客队赔率
		//大 / 小
		$ds=$ds."ratio_eouo='".$game->ratio_eouo."',";//大小主队盘口
		$ds=$ds."ratio_eouu='".$game->ratio_eouo."',";//大小客队盘口
		$ds=$ds."ior_EOUO='".$game->ior_EOUO."',";//大小主队赔率
		$ds=$ds."ior_EOUU='".$game->ior_EOUU."',";//大小客队赔率
		//独赢
		$ds=$ds."ior_EMH='".$game->ior_EMH."',";//主队赔率
		$ds=$ds."ior_EMC='".$game->ior_EMC."',";//和赔率
		$ds=$ds."ior_EMN='".$game->ior_EMN."',";//客队赔率


		//15分钟: 让球 - 75:00 - 全场
		$ds=$ds."ratio_fr='".$game->ratio_fr."',";//让球盘口
		$ds=$ds."ior_FRH='".$game->ior_FRH."',";//让球主队赔率
		$ds=$ds."ior_FRC='".$game->ior_FRC."',";//让球客队赔率
		//大 / 小
		$ds=$ds."ratio_fouo='".$game->ratio_fouo."',";//大小主队盘口
		$ds=$ds."ratio_fouu='".$game->ratio_fouo."',";//大小客队盘口
		$ds=$ds."ior_FOUO='".$game->ior_FOUO."',";//大小主队赔率
		$ds=$ds."ior_FOUU='".$game->ior_FOUU."',";//大小客队赔率
		//独赢
		$ds=$ds."ior_FMH='".$game->ior_FMH."',";//主队赔率
		$ds=$ds."ior_FMC='".$game->ior_FMC."',";//和赔率
		$ds=$ds."ior_FMN='".$game->ior_FMN."',";//客队赔率


		//输赢比分
		$ds=$ds."ior_WMH1='".$game->ior_WMH1."',";//净赢1球（主）
		$ds=$ds."ior_WMC1='".$game->ior_WMC1."',";//净赢1球（客）

		$ds=$ds."ior_WMH2='".$game->ior_WMH2."',";//净赢2球（主）
		$ds=$ds."ior_WMC2='".$game->ior_WMC2."',";//净赢2球（客）

		$ds=$ds."ior_WMH3='".$game->ior_WMH3."',";//净赢3球（主）
		$ds=$ds."ior_WMC3='".$game->ior_WMC3."',";//净赢3球（客）

		$ds=$ds."ior_WMHOV='".$game->ior_WMHOV."',";//净赢4球或更多（主）
		$ds=$ds."ior_WMCOV='".$game->ior_WMCOV."',";//净赢4球或更多（客）


		$ds=$ds."ior_WM0='".$game->ior_WM0."',";//无进球
		$ds=$ds."ior_WMN='".$game->ior_WMN."',";//任何进球和局


		//双赢盘
		$ds=$ds."ior_DCHN='".$game->ior_DCHN."',";//主
		$ds=$ds."ior_DCCN='".$game->ior_DCCN."',";//客
		$ds=$ds."ior_DCHC='".$game->ior_DCHC."',";//和


		//三项让球投注
		$ds=$ds."ratio_W3H='".$game->ratio_w3h."',";//盘口(主)
		$ds=$ds."ratio_W3C='".$game->ratio_w3c."',";//盘口(客)
		$ds=$ds."ratio_W3N='".$game->ratio_w3n."',";//盘口(和)

		$ds=$ds."ior_W3H='".$game->ior_W3H."',";//赔率(主)
		$ds=$ds."ior_W3C='".$game->ior_W3C."',";//赔率(客)
		$ds=$ds."ior_W3N='".$game->ior_W3N."',";//赔率(和)


		//落后反超获胜
		$ds=$ds."ior_BHH='".$game->ior_BHH."',";//赔率(主)
		$ds=$ds."ior_BHC='".$game->ior_BHC."',";//赔率(客)


		//赢得任一半场
		$ds=$ds."ior_WEH='".$game->ior_WEH."',";//赔率(主)
		$ds=$ds."ior_WEC='".$game->ior_WEC."',";//赔率(客)


		//赢得所有半场
		$ds=$ds."ior_WBH='".$game->ior_WBH."',";//赔率(主)
		$ds=$ds."ior_WBC='".$game->ior_WBC."',";//赔率(客)


		//最先 / 最后进球
		$ds=$ds."ior_PGFH='".$game->ior_PGFH."',";//主最先
		$ds=$ds."ior_PGLH='".$game->ior_PGLH."',";//主最后

		$ds=$ds."ior_PGFC='".$game->ior_PGFC."',";//客最先
		$ds=$ds."ior_PGLC='".$game->ior_PGLC."',";//客最后

		$ds=$ds."ior_PGFN='".$game->ior_PGFN."',";//无进球


		//会进球 / 不会进球
		$ds=$ds."ior_RCFH='".$game->ior_RCFH."',";//主会进球
		$ds=$ds."ior_RCLH='".$game->ior_RCLH."',";//主不会进球

		$ds=$ds."ior_RCFC='".$game->ior_RCFC."',";//客会进球
		$ds=$ds."ior_RCLC='".$game->ior_RCLC."',";//客不会进球


		//双方球队进球
		$ds=$ds."ior_TSY='".$game->ior_TSY."',";//是
		$ds=$ds."ior_TSN='".$game->ior_TSN."',";//否


		//球队入球数

		//大小 -全场
		$ds=$ds."ratio_ouho='".$game->ratio_ouho."',";//主队大盘口
		$ds=$ds."ratio_ouhu='".$game->ratio_ouhu."',";//主队小盘口
		$ds=$ds."ior_OUHO='".$game->ior_OUHO."',";//主队大赔率
		$ds=$ds."ior_OUHU='".$game->ior_OUHU."',";//主队小赔率

		$ds=$ds."ratio_ouco='".$game->ratio_ouco."',";//客队大盘口
		$ds=$ds."ratio_oucu='".$game->ratio_oucu."',";//客队小盘口
		$ds=$ds."ior_OUCO='".$game->ior_OUCO."',";//客队大赔率
		$ds=$ds."ior_OUCU='".$game->ior_OUCU."',";//客队小赔率







		//零失球
		$ds=$ds."ior_CSH='".$game->ior_CSH."',";//主
		$ds=$ds."ior_CSC='".$game->ior_CSC."',";//客


		//零失球获胜
		$ds=$ds."ior_WNH='".$game->ior_WNH."',";//主
		$ds=$ds."ior_WNC='".$game->ior_WNC."',";//客

		//先进两球的一方
		$ds=$ds."ior_F2GH='".$game->ior_F2GH."',";//主
		$ds=$ds."ior_F2GC='".$game->ior_F2GC."',";//客

		//先进三球的一方
		$ds=$ds."ior_F3GH='".$game->ior_F3GH."',";//主
		$ds=$ds."ior_F3GC='".$game->ior_F3GC."',";//客

		//最多进球的半场
		$ds=$ds."ior_HGH='".$game->ior_HGH."',";//上半场
		$ds=$ds."ior_HGC='".$game->ior_HGC."',";//下半场

		//最多进球的半场 - 独赢
		$ds=$ds."ior_MGH='".$game->ior_MGH."',";//上半场
		$ds=$ds."ior_MGC='".$game->ior_MGC."',";//下半场
		$ds=$ds."ior_MGN='".$game->ior_MGN."',";//和


		//双半场进球
		$ds=$ds."ior_SBH='".$game->ior_SBH."',";//主
		$ds=$ds."ior_SBC='".$game->ior_SBC."',";//客


		//首个进球方式
		$ds=$ds."ior_FGS='".$game->ior_FGS."',";//射门
		$ds=$ds."ior_FGH='".$game->ior_FGH."',";//头球
		$ds=$ds."ior_FGN='".$game->ior_FGN."',";//无进球
		$ds=$ds."ior_FGP='".$game->ior_FGP."',";//点球
		$ds=$ds."ior_FGF='".$game->ior_FGF."',";//任意球
		$ds=$ds."ior_FGO='".$game->ior_FGO."',";//乌龙球


		//首个进球时间 - 三项
		$ds=$ds."ior_T3G1='".$game->ior_T3G1."',";//第26分钟或之前
		$ds=$ds."ior_T3G2='".$game->ior_T3G2."',";//第27分钟或之后
		$ds=$ds."ior_T3GN='".$game->ior_T3GN."',";//无进球


		//首个进球时间
		$ds=$ds."ior_T1G1='".$game->ior_T1G1."',";//0 - 14:59分钟
		$ds=$ds."ior_T1G2='".$game->ior_T1G2."',";//15 - 29:59分钟
		$ds=$ds."ior_T1G3='".$game->ior_T1G3."',";//30 - 半场
		$ds=$ds."ior_T1G4='".$game->ior_T1G4."',";//下半场开始 - 59:59分钟
		$ds=$ds."ior_T1G5='".$game->ior_T1G5."',";//60 - 74:59分钟
		$ds=$ds."ior_T1G6='".$game->ior_T1G6."',";//75分钟 - 全场
		$ds=$ds."ior_T1GN='".$game->ior_T1GN."',";//无进球


		//先开球球队
		$ds=$ds."ior_TKH='".$game->ior_TKH."',";//主
		$ds=$ds."ior_TKC='".$game->ior_TKC."',";//客


		//点球惩罚(不包括点球赛)
		$ds=$ds."ior_PAH='".$game->ior_PAH."',";//是
		$ds=$ds."ior_PAC='".$game->ior_PAC."',";//否


		//红卡(球员)
		$ds=$ds."ior_RCDH='".$game->ior_RCDH."',";//是
		$ds=$ds."ior_RCDC='".$game->ior_RCDC."',";//否


		//第一颗 / 最后一颗角球
		$ds=$ds."ior_CNFH='".$game->ior_CNFH."',";//主队第一颗
		$ds=$ds."ior_CNLH='".$game->ior_CNLH."',";//主队最后一颗
		$ds=$ds."ior_CNFN='".$game->ior_CNFN."',";//无
		$ds=$ds."ior_CNFC='".$game->ior_CNFC."',";//客队第一颗
		$ds=$ds."ior_CNLC='".$game->ior_CNLC."',";//客队最后一颗


		//首个 / 最后罚牌
		$ds=$ds."ior_CDFH='".$game->ior_CDFH."',";//主队首个罚牌
		$ds=$ds."ior_CDLH='".$game->ior_CDLH."',";//主队最后罚牌
		$ds=$ds."ior_CDFN='".$game->ior_CDFN."',";//无
		$ds=$ds."ior_CDFC='".$game->ior_CDFC."',";//客队首个罚牌
		$ds=$ds."ior_CDLC='".$game->ior_CDLC."',";//客队最后罚牌


		//第一张 / 最后一张黄卡
		$ds=$ds."ior_YCFH='".$game->ior_YCFH."',";//主队第一张黄卡
		$ds=$ds."ior_YCLH='".$game->ior_YCLH."',";//主队最后一张黄卡
		$ds=$ds."ior_YCFN='".$game->ior_YCFN."',";//无
		$ds=$ds."ior_YCFC='".$game->ior_YCFC."',";//客队第一张黄卡
		$ds=$ds."ior_YCLC='".$game->ior_YCLC."',";//客队最后一张黄卡


		//最先 / 最后替补球队
		$ds=$ds."ior_STFH='".$game->ior_STFH."',";//主队最先替补球队
		$ds=$ds."ior_STLH='".$game->ior_STLH."',";//主队最后替补球队
		$ds=$ds."ior_STFN='".$game->ior_STFN."',";//无
		$ds=$ds."ior_STFC='".$game->ior_STFC."',";//客队最先替补球队
		$ds=$ds."ior_STLC='".$game->ior_STLC."',";//客队最后替补球队


		//最先 / 最后越位
		$ds=$ds."ior_OSFH='".$game->ior_OSFH."',";//主队最先越位
		$ds=$ds."ior_OSLH='".$game->ior_OSLH."',";//主队最后越位
		$ds=$ds."ior_OSFN='".$game->ior_OSFN."',";//无
		$ds=$ds."ior_OSFC='".$game->ior_OSFC."',";//客队最先越位
		$ds=$ds."ior_OSLC='".$game->ior_OSLC."'";//客队最后越位

		//echo $ds."<BR>";
		$sql = "update foot_match set ".$ds." where MID='".$MID."'";
		mysql_db_query($dbname,$sql);

		//全场结束


		//上半场
		$ds1="";
		$MID1=$game->hgid;//MID
		//上半入球数
		$ds1=$ds1."ior_HT0='".$game->ior_HT0."',";//0
		$ds1=$ds1."ior_HT1='".$game->ior_HT1."',";//1
		$ds1=$ds1."ior_HT2='".$game->ior_HT2."',";//2
		$ds1=$ds1."ior_HTOV='".$game->ior_HTOV."',";//3或者以上

		//球队入球数

		//大小 -上半场
		$ds1=$ds1."ratio_houho='".$game->ratio_houho."',";//主队大盘口
		$ds1=$ds1."ratio_houhu='".$game->ratio_houhu."',";//主队小盘口
		$ds1=$ds1."ior_HOUHO='".$game->ior_HOUHO."',";//主队大赔率
		$ds1=$ds1."ior_HOUHU='".$game->ior_HOUHU."',";//主队小赔率

		//单双 -上半场
		$ds1=$ds1."ior_HEOO='".$game->ior_HEOO."',";//主队单赔率
		$ds1=$ds1."ior_HEOE='".$game->ior_HEOE."',";//主队双赔率

		$ds1=$ds1."ratio_houco='".$game->ratio_houco."',";//客队大盘口
		$ds1=$ds1."ratio_houcu='".$game->ratio_houcu."',";//客队小盘口
		$ds1=$ds1."ior_HOUCO='".$game->ior_HOUCO."',";//客队大赔率
		$ds1=$ds1."ior_HOUCU='".$game->ior_HOUCU."'";//客队小赔率

		$sql1 = "update foot_match set ".$ds1." where MID='".$MID1."'";
		mysql_db_query($dbname,$sql1);

	}
}

?>
