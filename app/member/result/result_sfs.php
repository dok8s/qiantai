<?
include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/http.class.php");


$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$mtype=$_REQUEST['mtype'];
$gtype=$_REQUEST['game_type'];  
$list_date=$_REQUEST['list_date'];

$sql = "select language,memname from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
 // $langx=$_REQUEST['langx'];
  require ("../include/traditional.$langx.inc.php");
	$memname=$row['memname'];
//userlog($memname);
  if ($list_date==""){
  	$today=$_REQUEST['today'];
  	if (empty($today)){
  		$today 					= 	date("Y-m-d");
  		$tomorrow 			=		"";
  		$lastday 				= 	date("Y-m-d",mktime (0,0,0,date("m"),date("d")-1,date("Y")));
  	}else{
  		$date_list_1		=		explode("-",$today);
  		$d1							=		mktime(0,0,0,$date_list_1[1],$date_list_1[2],$date_list_1[0]);
  		$tomorrow				=		date('Y-m-d',$d1+24*60*60);
  		$lastday				=		date('Y-m-d',$d1-24*60*60);

  		if ($today>=date('Y-m-d')){
  			$tomorrow='';
  		}
  	}
  	$list_date=$today;
  }else{
  	$today = $list_date;
  	$date_list=mktime(0,0,0,substr($list_date,5,2),substr($list_date,8,2),substr($list_date,0,4));
  	$tomorrow = date("Y-m-d",mktime (0,0,0,date("m",$date_list),date("d",$date_list)+1,date("Y",$date_list)));
  	$lastday  = date("Y-m-d",mktime (0,0,0,date("m",$date_list),date("d",$date_list)-1,date("Y",$date_list)));
  	if (strcmp($tomorrow,date("Y-m-d"))>0){
  		$tomorrow="";
  	}
  }

if($gtype == 'NFS' || $gtype == 'FI')
  {
	  
		$yesterday='<a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&today='.$lastday.'&uid='.$uid.'&langx='.$langx.'">'.$res_yestoday.'</a>';
		if (!empty($tomorrow)){
			$tomorrow='  / <a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&today='.$tomorrow.'&uid='.$uid.'&langx='.$langx.'">'.$res_tommrow.'</a>';
		}
  }
  else
  {
		$yesterday='<a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&list_date='.$lastday.'&uid='.$uid.'&langx='.$langx.'">'.$res_yestoday.'</a>';
		if (!empty($tomorrow)){
			$tomorrow='  / <a href="'.BROWSER_IP.'/app/member/result/result.php?game_type='.$gtype.'&list_date='.$tomorrow.'&uid='.$uid.'&langx='.$langx.'">'.$res_tommrow.'</a>';
		}
		
  }

  $date_search=$yesterday.$tomorrow;
 $mysql = "select * from web_system";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
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
 $base_url = "".$site."/app/member/FT_browse/index.php?rtype=re&uid=$suid&langx=$langx&mtype=$mtype";
		$thisHttp = new cHTTP();
		$thisHttp->setReferer($base_url);

		
			$filename="".$site."/app/member/result/result_sfs.php?game_type=$gtype&list_date=$today&uid=$suid&langx=$langx";
	
		
		$thisHttp->getPage($filename);
		$msg  = $thisHttp->getContent();
		preg_match_all("/Array\((.+?)\);/is",$msg,$matches);
	$cou=sizeof($matches[0]);
                //$chs = new Chinese("UTF8","BIG5", $mem_msg);
switch($gtype){
case "FT":
$caption=$Soccer.':'.$saiguo;
$caption1=$zqgj.':'.$saiguo;
$caption2=$zqts.':'.$saiguo;
break;
case "FS":
$caption=$zqgj.':'.$saiguo;
break;
case "SFS";
$caption=$zqts.':'.$saiguo;
break;
case "BK";
$caption=$str_BK.':'.$saiguo;
break;
case "TN";
$caption=$Tennis.':'.$saiguo;
break;
case "VB";
$caption=$Voll.':'.$saiguo;
break;
case "BS";
$caption=$bangqiu.':'.$saiguo;
break;
case "OP";
$caption=$str_OP.':'.$saiguo;
break;
} 

$res=split('<table border="0" cellspacing="1" cellpadding="0" class="game">',$msg);

?>


<html>
<head>
<title>FT_result</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<? if($langx=="en-us"){?>
<link rel="stylesheet" href="/style/member/mem_body_result_en.css" type="text/css">
<link rel="stylesheet" href="/style/member/mem_body_ft_en.css" type="text/css">
<? }else{?>
<link rel="stylesheet" href="/style/member/mem_body_result.css" type="text/css">
<link rel="stylesheet" href="/style/member/mem_body_ft.css" type="text/css">
<? }?>
<SCRIPT language="javascript" src="/js/result.js"></SCRIPT>
<SCRIPT language="javascript" src="/js/<?=$langx?>.js"></SCRIPT>
<script>
function Check(uid,gtype,gid,lang,i){
	document.getElementById("show_table").style.top=document.getElementById("moreid_"+i).offsetTop+10;
	var ss="./result_sp.php?uid="+uid+"&gtype="+gtype+"&gid="+gid+"&langx="+lang;
	SP_Data.location ="./result_sp.php?uid="+uid+"&gtype="+gtype+"&gid="+gid+"&langx="+lang;

}
</script>
</head>
<body id="MRSU" >
<table border="0" cellpadding="0" cellspacing="0" id="box">
	<tr>
		<td class="top"><h1><em><?=$caption?></em></h1></td>
	</tr>
	<tr>
		<td class="mem">
        <h2>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="fav_bar">
              <tr>
                <td id="page_no">
                    <select name="selgtype" onChange="chg_gtype(selgtype.value,'game_type=<?=$gtype?>&uid=<?=$uid?>&langx=<?=$langx?>&list_date=')">
                      <option value="FT"><?=$caption?></option>
                      <option value="FS"><?=$caption1?></option>
                      <option value="SFS" selected><?=$caption2?></option>
                    </select>
                </td>
                <td id="tool_td">
              
                  <table border="0" cellspacing="0" cellpadding="0" class="tool_box">
                    <tr>
                        <td class="searh">
                      <span class="rig"><a href="/app/member/result/result.php?uid=<?=$uid?>&langx=<?=$langx?>&game_type=<?=$gtype?>&list_date=<?=$today?>"><?=$date_search?></a> 
                        &nbsp;&nbsp;<?=$xzrq?> : <input id="today_gmt" type=TEXT name="today" value="<?=$today?>" size="9" maxlength="10" class="txt">
                        <input type="button" value="查询" onClick="onchangeDate('result.php?uid=<?=$uid?>','<?=$gtype?>','<?=$langx?>')"></span>
                    <!--/form-->
                </td>
                
                 <td class="rsu_refresh"><!--秒數更新--><div onClick="javascript:refreshReload()"><font id="refreshTime" ></font></div></td>
               <!--td class="leg_btn"><div onClick="javascript:chg_league();" id="sel_league">選擇聯賽</div></td-->
                <td class="OrderType"></td>
                    </tr>
                  </table>
              
                </td>
              </tr>
            </table>
            </h2>
        <table border="0" cellspacing="0" cellpadding="0" class="game">
				<tr> 
					<th class="time"><?=$Times?></th>
					
					<th class="rsu"><?=$saiguo?></th>
				
				</tr>
			
			</table>
        
        
        
			
			<? if ($res[1]==""){?>
			</td>
			</tr>
			<tr><td id="foot"><b>&nbsp;</b></td></tr>
</table></body>
</html>
<? } else{?>
<table border="0" cellspacing="1" cellpadding="0" class="game">
<? echo $res[1];}?>