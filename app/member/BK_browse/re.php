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
echo $url=BROWSER_IP.'/app/member/get_game_allbets.php?uid='.$uid.'&langx='.$langx.'& gtype=BK&showtype=RB&gid='.$gid.'& ltype='.$ltype.'&date='.$date;

$xml =simpleXML_load_file($url);
$code=$xml->code;

if($code=='615'){
	$games=$xml->game;
	foreach($games as $game){
		$ds="";
		$MID=$game->gid;//MID
		$ds=$ds."gidm='".$game->gidm."',";//gidm 同一球队的场多下注的唯一标识
		
		//单双
		$ds=$ds."s_single='".$game->ior_REOO."',";
		$ds=$ds."s_double='".$game->ior_REOE."',";
		
		//球队得分
		//主队
		$ds=$ds."ior_PDH0='".$game->ior_RPDH0."',";
		$ds=$ds."ior_PDH1='".$game->ior_RPDH1."',";
		$ds=$ds."ior_PDH2='".$game->ior_RPDH2."',";
		$ds=$ds."ior_PDH3='".$game->ior_RPDH3."',";
		$ds=$ds."ior_PDH4='".$game->ior_RPDH4."',";
		
		//客队
		$ds=$ds."ior_PDC0='".$game->ior_RPDC0."',";
		$ds=$ds."ior_PDC1='".$game->ior_RPDC1."',";
		$ds=$ds."ior_PDC2='".$game->ior_RPDC2."',";
		$ds=$ds."ior_PDC3='".$game->ior_RPDC3."',";
		$ds=$ds."ior_PDC4='".$game->ior_RPDC4."' ";
		
		$sql = "update bask_match set ".$ds." where MID='".$MID."'";
		mysql_db_query($dbname,$sql);
		
	}
}

?>
