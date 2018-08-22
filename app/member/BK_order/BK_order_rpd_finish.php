<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$langx=$_REQUEST['langx'];
$odd_type=$_REQUEST['odd_f_type'];
$sql = "select status,cancel,super,ID,Money,Memname,Agents,world,corprator,OpenType,language,pay_type,BK_R_Scene,BK_R_Bet,hidden from web_member where Oid='$uid' and Oid<>'' and Status<>0 order by ID";

$result = mysql_db_query($dbname,$sql);

$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}

$memrow = mysql_fetch_array($result);
$open=$memrow['OpenType'];
$pay_type=$memrow['pay_type'];
$hidden=$memrow['hidden'];

$accept=$memrow['cancel'];
if($memrow['status']!=1){exit;}
order_accept($uid,$dbname);


require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");

$odd_type=$_REQUEST['odd_f_type'];




//接收传递过来的参数：其中赔率和位置需要进行判断
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['type'];
$M_Rate=$_REQUEST['ioradio_r_h'];
$active=$_REQUEST['active'];
$gold=$_REQUEST['gold'];
$line=$_REQUEST['line_type'];
$gwin=$_REQUEST['gwin'];

//下注时的赔率：应该根据盘口进行转换后，与数据库中的赔率进行比较。若不相同，返回下注。
$s_m_rate=$_REQUEST['ioradio_r_h'];

//判断此赛程是否已经关闭：取出此场次信息
$mysql = "select * from bask_match where `MID`=$gid  and cancel<>1 and fopen=1 and mb_inball=''"  ;//and M_Start>now()
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
	exit;
}else{
	$memname=$memrow['Memname'];
	$HMoney=$memrow['Money'];
	$agid=$memrow['Agents'];
	$world=$memrow['world'];
	$corprator=$memrow['corprator'];
	$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];
	$w_current=$memrow['CurType'];
	$accept=$memrow['cancel'];
//userlog($memname);
	$havemoney=$HMoney-$gold;
	$memid=$memrow['ID'];

	$GMAX_SINGLE=$memrow['BK_R_Scene'];
	$GSINGLE_CREDIT=$memrow['BK_R_Bet'];

	$sql2="select if(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(bettime))<$bet_time,2,0) as cancel from web_db_io where m_name='$memname' group by m_name";
	$resultaf = mysql_db_query($dbname,$sql2);
	$rowaf = mysql_fetch_array($resultaf);
	if($rowaf['cancel']==2){
		$accept=1;
	}

	if($memrow['status']!=1){exit;}

	if ($HMoney <((($_REQUEST['ioradio_r_h']<0 && $odd_type=='I')?abs($_REQUEST['ioradio_r_h']*$gold):$gold))){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}

	$havesql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as BetScore from web_db_io where m_name='$memname' and MID='$gid' and linetype=1 and mtype='$gtype' and active=3";
	$result = mysql_db_query($dbname,$havesql);
	$haverow = mysql_fetch_array($result);
	$have_bet=$haverow['BetScore']+0;

	if ($have_bet+$gold > $GMAX_SINGLE){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}

	if ($gold > $GMAX_SINGLE){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}

	if ($gold > $GSINGLE_CREDIT){
		wager_order($uid,$langx);
		echo "<SCRIPT language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}$accept=0;
	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));

	$w_tg_team=filiter_team(trim($row['TG_Team']));
	$w_tg_team=filiter_team(trim($row['TG_Team']));
	$w_tg_team_tw=filiter_team(trim($row['TG_Team_tw']));
	$w_tg_team_tw=filiter_team(trim($row['TG_Team_tw']));
	$w_tg_team_en=filiter_team(trim($row['TG_Team_en']));
	$w_tg_team_en=filiter_team(trim($row['TG_Team_en']));

	//取出当前字库的主客队伍名称

	$s_tg_team=filiter_team($row[$tg_team]);
	$s_mb_team=filiter_team($row[$mb_team]);

	//下注时间
	$M_Date=$row["M_Date"];
	$sDate=Date('Y').'-'.$M_Date;
	$showtype=$row["ShowType"];
	$bettime=date('Y-m-d H:i:s');

		$w_sleague=$row['M_League'];
		$w_sleague_tw=$row['M_League_tw'];
		$w_sleague_en=$row['M_League_en'];
		$s_sleague=$row[$m_league];

		$order='A';

	 

		$caption=$bk_order_rq;
		$turn_rate="BK_Turn_R_".$opentype;
		$mbid=$row['MB_MID'];

		$team=$row['MB_Team'];
		if (strstr($team,'上半')){
			$xzlb=' - <font color=gray>['.$body_sb.']</font>';
			$xzlb1=' - <font color=gray>['.$shangban.']</font>';
			$xzlb2=' - <font color=gray>['.$shangban_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$shangban_en1.']</font>';
			
			$bet_type=$shangban;
			$bet_type_tw=$shangban_tw;
			$bet_type_en=$shangban_en1;
		}else if(strstr($team,'下半')){
			$xzlb=' - <font color=gray>['.$body_xb.']</font>';
			$xzlb1=' - <font color=gray>['.$xiaban.']</font>';
			$xzlb2=' - <font color=gray>['.$xiaban_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$xiaban_en1.']</font>';
			
			$bet_type=$xiaban;
			$bet_type_tw=$xiaban_tw;
			$bet_type_en=$xiaban_en1;
		}else if(strstr($team,'第1节')){
			$xzlb=' - <font color=gray>['.$part1.']</font>';
			$xzlb1=' - <font color=gray>['.$diyijie.']</font>';
			$xzlb2=' - <font color=gray>['.$diyijie_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$diyijie_en.']</font>';
			
			$bet_type=$diyijie;
			$bet_type_tw=$diyijie_tw;
			$bet_type_en=$diyijie_en;

		}else if(strstr($team,'第2节')){
			$xzlb=' - <font color=gray>['.$part2.']</font>';
			$xzlb1=' - <font color=gray>['.$dierjie.']</font>';
			$xzlb2=' - <font color=gray>['.$dierjie_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$dierjie_en.']</font>';
			
			$bet_type=$dierjie;
			$bet_type_tw=$dierjie_tw;
			$bet_type_en=$dierjie_en;

		}else if(strstr($team,'第3节')){
			$xzlb=' - <font color=gray>['.$part3.']</font>';
			$xzlb1=' - <font color=gray>['.$disanjie.']</font>';
			$xzlb2=' - <font color=gray>['.$disanjie_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$disanjie_en.']</font>';
			
			$bet_type=$disanjie;
			$bet_type_tw=$disanjie_tw;
			$bet_type_en=$disanjie_en;
		}else if(strstr($team,'第4节')){
			$xzlb=' - <font color=gray>['.$part4.']</font>';
			$xzlb1=' - <font color=gray>['.$disijie.']</font>';
			$xzlb2=' - <font color=gray>['.$disijie_tw.']</font>';
			$xzlb3=' - <font color=gray>['.$disijie_en.']</font>';
			
			$bet_type=$disijie;
			$bet_type_tw=$disijie_tw;
			$bet_type_en=$disijie_en;
		}else{
			$xzlb='';
			$xzlb1='';
			$xzlb2='';
			$xzlb3='';
			
			$bet_type=$quanchang;
			$bet_type_tw=$quanchang_tw;
			$bet_type_en=$quanchang_en1;
		}

		switch ($gtype){
		case "RPDH0":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$lxl='0'.$huozhe1.' 5';
			$lxl_tw='0'.$huozhe1_tw.' 5';
			$lxl_en='0'.$huozhe1_en.' 5';
			$fenlei='0'.$huozhe.' 5';
			$s_m_place=$s_mb_team;
			$w_m_rate=$row['ior_PDH0'];
			$wtype='RPDH';
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_rpd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[TG_MID];
			break;
		case "RPDH1":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$lxl='1'.$huozhe1.' 6';
			$lxl_tw='1'.$huozhe1_tw.' 6';
			$lxl_en='1'.$huozhe1_en.' 6';
			$fenlei='1'.$huozhe.' 6';
			$s_m_place=$s_mb_team;
			$w_m_rate=$row['ior_PDH1'];
			$wtype='RPDH';
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_rpd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[TG_MID];
			break;
		case "RPDH2":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$lxl='2'.$huozhe1.' 7';
			$lxl_tw='2'.$huozhe1_tw.' 7';
			$lxl_en='2'.$huozhe1_en.' 7';
			$fenlei='2'.$huozhe.' 7';
			$s_m_place=$s_mb_team;
			$wtype='RPDH';
			$w_m_rate=$row['ior_PDH2'];
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_rpd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[TG_MID];
			break;
		case "RPDH3":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$lxl='3'.$huozhe1.' 8';
			$lxl_tw='3'.$huozhe1_tw.' 8';
			$lxl_en='3'.$huozhe1_en.' 8';
			$fenlei='3'.$huozhe.' 8';
			$s_m_place=$s_mb_team;
			$wtype='RPDH';
			$w_m_rate=$row['ior_PDH3'];
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_rpd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[TG_MID];
			break;
		case "RPDH4":
			$w_m_place=$w_mb_team;
			$w_m_place_tw=$w_mb_team_tw;
			$w_m_place_en=$w_mb_team_en;
			$lxl='4'.$huozhe1.' 9';
			$lxl_tw='4'.$huozhe1_tw.' 9';
			$lxl_en='4'.$huozhe1_en.' 9';
			$fenlei='4'.$huozhe.' 9';
			$s_m_place=$s_mb_team;
			$wtype='RPDH';
			$w_m_rate=$row['ior_PDH4'];
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_rpd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[TG_MID];
			break;
		case "RPDC0":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$lxl='0'.$huozhe1.' 5';
			$lxl_tw='0'.$huozhe1_tw.' 5';
			$lxl_en='0'.$huozhe1_en.' 5';
			$fenlei='0'.$huozhe.' 5';
			$s_m_place=$s_tg_team;
			$wtype='RPDC';
			$w_m_rate=$row['ior_PDC0'];
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_rpd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[MB_MID];
			break;
		case "RPDC1":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$lxl='1'.$huozhe1.' 6';
			$lxl_tw='1'.$huozhe1_tw.' 6';
			$lxl_en='1'.$huozhe1_en.' 6';
			$fenlei='1'.$huozhe.' 6';
			$s_m_place=$s_tg_team;
			$wtype='RPDC';
			$w_m_rate=$row['ior_PDC1'];
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_rpd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[MB_MID];
			break;
		case "RPDC2":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$lxl='2'.$huozhe1.' 7';
			$lxl_tw='2'.$huozhe1_tw.' 7';
			$lxl_en='2'.$huozhe1_en.' 7';
			$fenlei='2'.$huozhe.' 7';
			$s_m_place=$s_tg_team;
			$wtype='RPDC';
			$w_m_rate=$row['ior_PDC2'];
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_rpd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[MB_MID];
			break;
		case "RPDC3":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$lxl='3'.$huozhe1.' 8';
			$lxl_tw='3'.$huozhe1_tw.' 8';
			$lxl_en='3'.$huozhe1_en.' 8';
			$fenlei='3'.$huozhe.' 8';
			$s_m_place=$s_tg_team;
			$wtype='RPDC';
			$w_m_rate=$row['ior_PDC3'];
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_pd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[MB_MID];
			break;
		case "RPDC4":
			$w_m_place=$w_tg_team;
			$w_m_place_tw=$w_tg_team_tw;
			$w_m_place_en=$w_tg_team_en;
			$lxl='4'.$huozhe1.' 9';
			$lxl_tw='4'.$huozhe1_tw.' 9';
			$lxl_en='4'.$huozhe1_en.' 9';
			$fenlei='4'.$huozhe.' 9';
			$s_m_place=$s_tg_team;
			$wtype='RPDC';
			$w_m_rate=$row['ior_PDC4'];
			$turn_url=BROWSER_IP."/app/member/BK_order/BK_order_pd.php?gid=".$gid."&uid=".$uid."&type=$gtype&gnum=".$row[MB_MID];
			break;
		
		
		}
		$turn_url=$turn_url."&odd_f_type=$odd_type";

		//水位与数据库水位不等时提示
		if ($M_Rate<>$w_m_rate){
	//	echo $M_Rate."<>".$w_m_rate;exit;
			$turn_url=$turn_url.'&change=1';
			echo "<script language='javascript'>self.location='$turn_url';</script>";
			exit;
		}

		//防空注单
		if ($w_m_place=='' or $s_m_place==''){
			$turn_url=$turn_url.'&change=1';
			echo "<script language='javascript'>self.location='$turn_url';</script>";
			exit();
		}

		$Sign='vs';
		$grape=$Sign;
		IF ($showtype=="H"){
			$l_team=$s_mb_team;
			$r_team=$s_tg_team;

			$w_l_team=$w_mb_team;
			$w_l_team_tw=$w_mb_team_tw;
			$w_l_team_en=$w_mb_team_en;
			$w_r_team=$w_tg_team;
			$w_r_team_tw=$w_tg_team_tw;
			$w_r_team_en=$w_tg_team_en;
		}ELSE{

			$r_team=$s_mb_team;
			$l_team=$s_tg_team;

			$w_r_team=$w_mb_team;
			$w_r_team_tw=$w_mb_team_tw;
			$w_r_team_en=$w_mb_team_en;
			$w_l_team=$w_tg_team;
			$w_l_team_tw=$w_tg_team_tw;
			$w_l_team_en=$w_tg_team_en;
		}

		$s_mb_team=$l_team;
		$s_tg_team=$r_team;

		$w_mb_team=$w_l_team;
		$w_mb_team_tw=$w_l_team_tw;
		$w_mb_team_en=$w_l_team_en;

		$w_tg_team=$w_r_team;
		$w_tg_team_tw=$w_r_team_tw;
		$w_tg_team_en=$w_r_team_en;


		$turn="BK_Turn_R";
		$gwin=($s_m_rate-1)*$gold;

	$w_mb_mid=$row['MB_MID'];
	$w_tg_mid=$row['TG_MID'];
	$w_mid1="<br>[".$row['MB_MID']."]vs[".$row[TG_MID]."]<br>";
	$bet_type1=$lanqiubc.$bet_type.$zoudi1.$qiuduidefen1.$w_m_place." -".$zuihouyiwei1;
	$bet_type1_tw=$lanqiubc_tw.$bet_type_tw.$zoudi1_tw.$qiuduidefen1_tw.$w_m_place_tw." -".$zuihouyiwei1_tw;
	$bet_type1_en=$lanqiubc_en.$bet_type_en.$zoudi1_en.$qiuduidefen1_en.$w_m_place_en." -".$zuihouyiwei1_en;
	$bet_type=$lanqiubc."<br>".$bet_type."<br>".$zoudi1.$qiuduidefen1.$w_m_place." -".$zuihouyiwei1;
	$bet_type_tw=$lanqiubc_tw."<br>".$bet_type_tw."<br>".$zoudi1_tw.$qiuduidefen1_tw.$w_m_place_tw." -".$zuihouyiwei1_tw;
	$bet_type_en=$lanqiubc_en."<br>".$bet_type_en."<br>".$zoudi1_en.$qiuduidefen1_en.$w_m_place_en." -".$zuihouyiwei1_en;
if ($w_m_rate==''){
		echo "<script language='javascript'>parent.location='".BROWSER_IP."/app/member/select.php?uid=$uid&langx=$langx';</script>";
		exit();
	}
	$s_m_place=filiter_team(trim($s_m_place));
	$w_mid='<br>';
	
	$bottom1="<font color=\"#0000BB\">[".$zoudi1.$qiuduidefen1.$w_m_place." -".$zuihouyiwei1."]</font>";
	$bottom1_tw="<font color=\"#0000BB\">[".$zoudi1_tw.$qiuduidefen1_tw.$w_m_place_tw." -".$zuihouyiwei1_tw."]</font>";
	$bottom_en1="<font color=\"#0000BB\">[".$zoudi1_en.$qiuduidefen1_en.$w_m_place_en." -".$zuihouyiwei1_en."]</font>";

	$lines2=$w_sleague.$w_mid.$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#CC0000><b>vs</b></FONT>&nbsp;&nbsp;".$w_tg_team."&nbsp;$bottom1<br>";
	$lines2=$lines2."<FONT color=#cc0000>$w_m_place&nbsp;".$lxl."</FONT>&nbsp$xzlb1@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_tw=$w_sleague_tw.$w_mid.$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#CC0000><b>vs</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."&nbsp;$bottom1_tw<br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000>$w_m_place_tw&nbsp;".$lxl_tw."</FONT>&nbsp$xzlb2@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";

	$lines2_en=$w_sleague_en.$w_mid.$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#CC0000><b>vs</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."&nbsp;$bottom1_en<br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000>$w_m_place_en&nbsp;".$lxl_en."</FONT>&nbsp$xzlb3@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";
	

	$I_Date=Date('Y')."-".$M_Date;
$ip_addr = $_SERVER['REMOTE_ADDR'];

	$auth_code=md5($lines2_tw.$gold.$gtype);

	$sql="SELECT web_member.$turn as turn,web_agents.winloss_s,web_agents.winloss_a,web_agents.winloss_c,web_agents.$turn_rate as ag_turn,web_world.$turn_rate as wd_turn,web_corprator.$turn_rate AS cop_turn FROM web_member, web_agents,web_world,web_corprator WHERE (web_member.Memname =  '$memname' and web_member.Agents=web_agents.Agname and web_member.corprator=web_corprator.agname )AND web_agents.world = web_world.Agname AND web_agents.corprator = web_corprator.Agname";

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$turn=$row['turn']+0;
	$agent_rate=$row['ag_turn']+0;
	$world_rate=$row['wd_turn']+0;
	$corpro_rate=$row['cop_turn']+0;
	$agent_point=$row['winloss_a']+0;
	$world_point=$row['winloss_s']+0;
	$corpor_point=$row['winloss_c']+0;

	$sql = "INSERT INTO web_db_io(odd_type,wtype,auth_code,super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,betip,pay_type,corpor_turn,orderby,corpor_point,status,hidden,BetType1,BetType1_tw,BetType1_en) values ('$odd_type','$wtype','$auth_code','$super','$gid','3','121','$gtype','$I_Date','$gold','$M_Rate','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$corpor_point','$accept','$hidden','$bet_type1','$bet_type1_tw','$bet_type1_en')";
	mysql_db_query($dbname,$sql) or die ("error!");

	$oid=mysql_insert_id();
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

	$havemoney=$HMoney-(($M_Rate<0 && $odd_type=='I')?abs($M_Rate*$gold):$gold);

	$sql = "update web_member set Money='$havemoney',cancel=1 where memname='$memname'";
	mysql_db_query($dbname,$sql) or die ("error!");

?>


<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" href="/style/member/mem_order_ft.css" type="text/css">
</head>
<body   id="OFIN" class="bodyset"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div class="ord">
	<div class="title"><h1><?=$BasketBall?></h1></div>
	<div class="fin_title"><div class="fin_acc"><?=$jylsd?></div><div class="fin_uid"><?=$zdh?><?=show_voucher($line,$ouid)?></div></div>
    <div class="main">
	  <div class="leag"><?=$s_sleague?></div>
      <div class="gametype"><?=$res_total?> - <?=$zoudi?><?=$qiuduidefen?><?=$s_m_place?> -<?=$zuihouyiwei?></div>
      <div class="teamName"><span class="tName"><?=$s_mb_team?> <font color=#cc0000>vs</font> <?=$s_tg_team?></span></div>
      <p class="team"><em><?=$s_m_place?> <?=$fenlei?><?=$xzlb?></em> @ <strong class="light" id="ioradio_id"><?=number_format($M_Rate,2)?></strong></p>
      <div class="betdata">
          <p class="minBet"><span class="bet_txt"><?=$Xzjr?></span><?=number_format($gold)?></p>
    </div>
    </div>
  <div class="betBox"> 
  	<input type="button" name="PRINT" value="<?=$Prints?>" onClick="window.print()" class="yes">
    <input type="button" name="FINISH" value="<?=$Likai?>" onClick="parent.close_bet();" class="no">
   
  </div>
</div>
  
</body>
</html>
<script>
parent.parent.header.reloadPHP1.location.href='../reloadCredit.php?uid=<?=$uid?>&langx=<?=$langx?>';
</script>
<?
mysql_close();
}
?>
