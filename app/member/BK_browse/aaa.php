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
$url=BROWSER_IP.'/app/member/get_game_allbets.php?uid='.$uid.'&langx='.$langx.'&gtype=BK&showtype=FT&gid='.$gid.'&ltype='.$ltype.'&date='.$date;
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
		
		//让球盘
		$ds=$ds."m_letb='".$game->ratio."',";
		$ds=$ds."MB_LetB_Rate='".$game->ior_RH."',";
		$ds=$ds."TG_LetB_Rate='".$game->ior_RC."',";
		$ds=$ds."ShowType='".$game->strong."',";
		//大小
		$ds=$ds."m_dime='".$game->ratio_o."',";
		$ds=$ds."mb_dime_rate='".$game->ior_OUH."',";
		$ds=$ds."tg_dime_rate='".$game->ior_OUC."',";
		
		//独赢
		$ds=$ds."ior_MH='".$game->ior_MH."',";
		$ds=$ds."ior_MC='".$game->ior_MC."',";
		
		//单双
		$ds=$ds."s_single='".$game->ior_EOO."',";
		$ds=$ds."s_double='".$game->ior_EOE."',";
		
		//球队得分
		//主队
		$ds=$ds."ratio_ouho='".$game->ratio_ouho."',";
		$ds=$ds."ratio_ouhu='".$game->ratio_ouhu."',";
		$ds=$ds."ior_OUHO='".$game->ior_OUHO."',";
		$ds=$ds."ior_OUHU='".$game->ior_OUHU."',";
		
		$ds=$ds."ior_PDH0='".$game->ior_PDH0."',";
		$ds=$ds."ior_PDH1='".$game->ior_PDH1."',";
		$ds=$ds."ior_PDH2='".$game->ior_PDH2."',";
		$ds=$ds."ior_PDH3='".$game->ior_PDH3."',";
		$ds=$ds."ior_PDH4='".$game->ior_PDH4."',";
		
		//客队
		$ds=$ds."ratio_ouco='".$game->ratio_ouco."',";
		$ds=$ds."ratio_oucu='".$game->ratio_oucu."',";
		$ds=$ds."ior_OUCO='".$game->ior_OUCO."',";
		$ds=$ds."ior_OUCU='".$game->ior_OUCU."',";
		
		$ds=$ds."ior_PDC0='".$game->ior_PDC0."',";
		$ds=$ds."ior_PDC1='".$game->ior_PDC1."',";
		$ds=$ds."ior_PDC2='".$game->ior_PDC2."',";
		$ds=$ds."ior_PDC3='".$game->ior_PDC3."',";
		$ds=$ds."ior_PDC4='".$game->ior_PDC4."' ";
		
		$sql = "update bask_match set ".$ds." where MID='".$MID."'";
		mysql_db_query($dbname,$sql);
		
		
	}
}

?>
