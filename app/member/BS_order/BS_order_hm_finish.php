<?
//if ($HTTP_SERVER_VARS['SERVER_ADDR']<>"58.64.137.236"){exit;}if (date('Y-m-d')>'2009-01-01'){exit;}

include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select super,ID,Money,Memname,Agents,world,corprator,OpenType,language,pay_type from web_member where Oid='$uid' and oid<>'' and Status<>0 order by ID";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}else{

$memrow = mysql_fetch_array($result);
$langx=$memrow['language'];
$open=$memrow['OpenType'];
$pay_type=$memrow['pay_type'];

require ("../include/traditional.$langx.inc.php");
require ("../include/traditional.inc.php");
$odd_f_type=$_REQUEST['odd_f_type'];

switch ($odd_f_type){
case "H":
		$ph=$xg;
		$ph_tw=$xg_tw;
		$ph_en=$xg_en;
		break;
case "M":
		$ph=$ml;
		$ph_tw=$ml_tw;
		$ph_en=$ml_en;
		break;
case "I":
		$ph=$yn;
		$ph_tw=$yn_tw;
		$ph_en=$yn_en;
		break;
case "E":
		$ph=$oz;
		$ph_tw=$oz_tw;
		$ph_en=$oz_en;
		break;
}
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
$mysql = "select * from foot_match where `m_start`>now() and `MID`=$gid and cancel<>1 and fopen=1 and mb_inball=''";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);
if($cou==0){
	wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
	exit();
}else{
	$memname=$memrow['Memname'];
	$HMoney=$memrow['Money'];
	if ($HMoney < $restcredit){
		wager_order($uid,$langx);
	echo "<SCRIPT language='javascript'>self.location='".BROWSER_IP."/app/member/select.php?uid=$uid';</script>";
	exit();
	}

	$agid=$memrow['Agents'];
	$world=$memrow['world'];
	$corprator=$memrow['corprator'];$super=$memrow['super'];
	$opentype=$memrow['OpenType'];
	$w_ratio=$memrow['ratio'];

	$w_ratio=1;

	$w_current=$memrow['CurType'];
	
	$havemoney=$HMoney-$gold;
	$memid=$memrow['ID'];

	$w_tg_team=filiter_team($row['TG_Team']);
	$w_tg_team_tw=filiter_team($row['TG_Team_tw']);
	$w_tg_team_en=filiter_team($row['TG_Team_en']);
	
	//取出四种语言的主队名称，并去掉其中的“主”和“中”字样
	$w_mb_team=filiter_team(trim($row['MB_Team']));
	$w_mb_team=filiter_team(trim($row['MB_Team']));	
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_tw=filiter_team(trim($row['MB_Team_tw']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	$w_mb_team_en=filiter_team(trim($row['MB_Team_en']));
	
	//取出当前字库的主客队伍名称
	
	$s_mb_team=filiter_team($row[$mb_team]);
	$s_tg_team=filiter_team($row[$tg_team]);
	
	//下注时间
	$M_Date=$row["M_Date"];
	$sDate=Date('Y').'-'.$M_Date;
	$showtype=$row["ShowType"];
	$bettime=date('Y-m-d H:i:s');
		
	
	//联盟处理:生成写入数据库的联盟样式和显示的样式，二者有区别
	if ($row[$m_sleague]==''){
		$w_sleague=$row['M_League'];
		$w_sleague_tw=$row['M_League_tw'];
		$w_sleague_en=$row['M_League_en'];
		$s_sleague=$row[$m_league];
	}else{
		$w_sleague=$row['M_Sleague'];
		$w_sleague_tw=$row['M_Sleague_tw'];
		$w_sleague_en=$row['M_Sleague_en'];
		$s_sleague=$row[$m_sleague];
	}
	
	//根据下注的类型进行处理：构建成新的数据格式，准备写入数据库
	$order='A';
	
	$bet_type='半场独赢';
	$bet_type_tw="半场独赢";
	$bet_type_en="1st 1x2";
	$btype="-<font color=red><b>[$body_sb]</b></font>";
	$caption=$SbdyOrder;
	$turn_rate="FT_Turn_M";
	$turn="FT_Turn_M";
	switch ($gtype){
	case "H":
		$w_m_place=$w_mb_team;
		$w_m_place_tw=$w_mb_team_tw;
		$w_m_place_en=$w_mb_team_en;
		$s_m_place=$row[$mb_team];
		$w_m_rate=$row["MB_Win"];
		break;
	case "C":
		$w_m_place=$w_tg_team;
		$w_m_place_tw=$w_tg_team_tw;
		$w_m_place_en=$w_tg_team_en;
		$s_m_place=$row[$tg_team];
		$w_m_rate=$row["TG_Win"];
		break;
	case "N":
		$w_m_place="和局";
		$w_m_place_tw="㎝Ы";
		$w_m_place_en="flat";
		$s_m_place=$Draw;
		$w_m_rate=$row["M_Flat"];
	break;
	}
	$Sign="VS.";
	$grape="";
	$gwin=($s_m_rate-1)*$gold;
	$w_rtype='VM';
	$w_wtype='V';		
	
	$bottom1_tw="<font color=red>-&nbsp;</font><font color=#666666>[]</font>&nbsp;";
	$bottom1="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
	$bottom1_en="<font color=red>-&nbsp;</font><font color=#666666>[1st]</font>&nbsp;";

	$w_mid="<br>";

	$bet_type="足球".$bet_type;
	$bet_type_tw="ì瞴".$bet_type_tw;
	$bet_type_en="Soccer".$bet_type_en;
		
	$s_m_place=filiter_team(trim($s_m_place));
//exit;
	$M_Rate1=$M_Rate;

	$lines2=$row['M_League'].$w_mid.$w_mb_team."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team."<br>";
	$lines2=$lines2."<FONT color=#cc0000>$w_m_place</FONT>&nbsp;$bottom1@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";	
	
	$lines2_tw=$row['M_League_tw'].$w_mid.$w_mb_team_tw."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_tw."<br>";
	$lines2_tw=$lines2_tw."<FONT color=#cc0000>$w_m_place_tw</FONT>&nbsp;$bottom1_tw@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";
	
	$lines2_en=$row['M_League_en'].$w_mid.$w_mb_team_en."&nbsp;&nbsp;<FONT COLOR=#0000BB><b>".$Sign."</b></FONT>&nbsp;&nbsp;".$w_tg_team_en."<br>";
	$lines2_en=$lines2_en."<FONT color=#cc0000>$w_m_place_en</FONT>&nbsp;$bottom1_en@&nbsp;<FONT color=#cc0000><b>".$M_Rate."</b></FONT>";	


	$I_Date=Date('Y')."-".$M_Date;
$ip_addr = $_SERVER['REMOTE_ADDR'];
	
	$sql="SELECT web_member.$turn as turn,web_agents.$turn_rate as ag_turn,web_world.$turn_rate as wd_turn,web_corprator.$turn_rate AS cop_turn,web_agents.winloss_a,web_agents.winloss_s FROM web_member, web_agents,web_world,web_corprator WHERE (web_member.Memname =  '$memname' and web_member.Agents=web_agents.Agname and web_member.corprator=web_corprator.agname )AND web_agents.world = web_world.Agname AND web_agents.corprator = web_corprator.Agname";

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$turn=$row['turn']+0;
	$agent_rate=$row['ag_turn']+0;
	$world_rate=$row['wd_turn']+0;
	$corpro_rate=$row['cop_turn']+0;
	$agent_point=$row['winloss_a']+0;
	$world_point=$row['winloss_s']+0;
	$cor_point=$row['winloss_c']+0;

	
	$sql = "INSERT INTO web_db_io(super,MID,Active,LineType,Mtype,M_Date,BetScore,M_Rate,M_Name,BetTime,Gwin,M_Place,BetType,BetType_tw,BetType_en,Middle,Middle_tw,Middle_en,ShowType,OpenType,Agents,TurnRate,world,corprator,agent_rate,world_rate,agent_point,world_point,betip,pay_type,corpor_turn,orderby,pankou,pankou_tw,pankou_en) values ('$super','$gid','$active','$line','$gtype','$I_Date','$gold','$M_Rate1','$memname','$bettime','$gwin','$grape','$bet_type','$bet_type_tw','$bet_type_en','$lines2','$lines2_tw','$lines2_en','$showtype','$opentype','$agid','$turn','$world','$corprator','$agent_rate','$world_rate','$agent_point','$world_point','$ip_addr','$pay_type','$corpro_rate','$order','$ph','$ph_tw','$ph_en')";
	mysql_db_query($dbname,$sql) or die ("操作失败!");
	$oid=mysql_insert_id();	
	$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID from web_db_io where id=".$oid;

	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$ouid = $row['ID'];

	$sql = "update web_member set Money='$havemoney' where memname='$memname'";
	mysql_db_query($dbname,$sql) or die ("操作失败!");
if ($active==2){
	$caption=str_replace($Soccer,trim($EarlyMarket),$caption);
}

?>
<html>
<head>
<title>ft_r_order_finish</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>"> 
<link rel="stylesheet" href="/style/member/mem_order.css" type="text/css">
<script>window.setTimeout("self.location='../select.php?uid=<?=$uid?>'", 45000);</script>
</head>
<body id="OFIN" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
  <div class="ord">
    <span><h1><?=$caption?></h1></span>
      <div id="info">
       <p><?=$Name?><?=$memname?></p>
  	<p><?=$Money?><?=$havemoney?></p>
  	<p><em><?=$jylsd?><?=show_voucher($line,$ouid)?></em></p>
  	<p class="team"><?=$s_sleague?>&nbsp;<?=$btype?>&nbsp;<?=$M_Date?><BR><?=$s_mb_team?>&nbsp;&nbsp;<font color=#cc0000><?=$Sign?></font>&nbsp;&nbsp;<?=$s_tg_team?> 
      <br><em><?=$s_m_place?></em>@<em><strong><?=$M_Rate?></strong></em></p>
  	<p><?=$Xzjr?><?=$gold?></p>
	<p><?=$Kyje?><FONT id=pc color=#cc0000><?=$gwin?></FONT></p>
    </div>
    <p class="foot">
      <input type="button" name="FINISH" value="<?=$Likai?>" onClick="self.location='../select.php?uid=<?=$uid?>'" class="no">
      <input type="button" name="PRINT" value="<?=$Prints?>" onClick="window.print()" class="yes">
    </p>
  </div>
</body>
</html>

<!--<link rel="stylesheet" href="/style/member/mem_order_fin.css" type="text/css">
<SCRIPT>window.setTimeout("self.location='../select.php?uid=<?=$uid?>'", 45000);</SCRIPT>
<meta content="MSHTML 6.00.2800.1515" name=GENERATOR>
</head>
<body oncontextmenu=window.event.returnValue=false text=#000000 leftMargin=0 topMargin=0>
<TABLE class=o_tab_finish cellSpacing=0 cellPadding=0 width=220 border=0>
  <TBODY>
  <TR>
    <TD class=o_title_finish><?=$caption?></TD></TR>
  <TR>
   	<TD class=o_title_down></TD>
  </TR>
  <TR>
    	<TD><?=$Name?><?=$memname?></TD></TR>
  	<TR>
    	<TD><?=$Money?><?=$havemoney?></TD></TR>
  	<TR>
    	<TD><FONT color=#cc0000><?=show_voucher($line,$ouid)?></FONT></TD></TR>
  	<TR>
    	<TD class=o_error height=1></TD></TR>
  	<TR>
    	<TD class=o_team><?=$s_sleague?>&nbsp;<?=$btype?>&nbsp;<?=$M_Date?><BR><?=$s_mb_team?>&nbsp;&nbsp;<font color=#cc0000><?=$Sign?></font>&nbsp;&nbsp;<?=$s_tg_team?> 
      <FONT color=#cc0000><BR><SPAN style="COLOR: rgb(255,0,0)"><?=$s_m_place?></SPAN><FONT color=#000000>@</FONT> <SPAN style="COLOR: rgb(255,0,0)"><B><?=$M_Rate?></B></SPAN></FONT></TD>
  	</TR>
  	<TR>
    	<TD class=o_error height=1></TD>
  	</TR>
	<TR>
    	<TD><?=$Xzjr?><?=$gold?></TD></TR>
	<TR>
    	<TD><?=$Kyje?><FONT id=pc color=#cc0000><?=$gwin?></FONT></TD>
	</TR>
  <tr> 
      <td class="o_foot">
        <input type="BUTTON" name="FINISH" value="<?=$Likai?>" onClick="self.location='/app/member/select.php?uid=<?=$uid?>'" class="za_button"> 
      &nbsp;&nbsp; <input type="BUTTON" name="PRINT" value="<?=$Prints?>" onClick="window.print()" class="za_button">
 			</td>
    </tr>
  </table>
   -->
<?
wager_finish($langx);
?>
</body>
</html>
<?
}
}
mysql_close();
?>
