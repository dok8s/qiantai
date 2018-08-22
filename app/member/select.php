<?php
include "./include/library.mem.php";
require ("./include/define_function_list.inc.php");
require ("./include/config.inc.php");
require ("./include/http.class.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
if($mtype==""){
	$mtype=3;
}
$langx=$_REQUEST['langx'];


if($langx=="en-us"){
	$css="_en";
}
$sql = "select Memname,loginName,Money,language,LogDate,credit from web_member where Oid='$uid' and Oid<>'' and Status<>0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$mydate= date('Y-m-d');
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}

$memname=$row['Memname'];
$loginName=$row['loginName'];
$credit=$row['Money'];

userlog($memname);

$sql = "select * from web_system";
$resultaaa = mysql_db_query($dbname,$sql);
$rowaaa = mysql_fetch_array($resultaaa);
if($rowaaa['anop']==1){
		$credit='<font color=red>tγ̨ΤƤAеy..</font>';
}

require ("./include/traditional.$langx.inc.php");
$old_http=$rowaaa['Old_http'];
$active=$_REQUEST['show'];

if ($active==''){
	echo "<script>parent.mem_order.location='./select.php?uid=$uid&langx=$langx&mtype=$mtype&act=1&show='+top.show;</script>";
	exit;
}

?>
<script> 
top.uid = '<?=$uid?>';
top.langx = '<?=$langx?>';
top.liveid = ''
top.casino = 'SI2';
top.mtype = '<?=$mtype?>';

top.str_input_pwd ="<?=$str_input_pwd?>";
top.str_input_repwd = "<?=$str_input_repwd?>";
top.str_err_pwd = "<?=$str_err_pwd?>";
top.str_pwd_limit = "<?=$str_pwd_limit?>";
top.str_pwd_limit2 = "<?=$str_pwd_limit2?>";
top.str_pwd_NoChg = "<?=$str_pwd_NoChg?>!!";
top.str_input_longin_id = "<?=$str_input_longin_id?>";
top.str_longin_limit1 = "<?=$str_longin_limit1?>";
top.str_longin_limit2 = "<?=$str_longin_limit2?>";
top.str_o="<?=$strOdd?>";
top.str_e="<?=$strEven?>";
top.str_checknum="<?=$str_checknum?>";
top.str_irish_kiss="<?=$str_irish_kiss?>";
top.dPrivate="<?=$dPrivate?>";
top.dPublic="<?=$dPublic?>";
top.grep="<?=$grep?>";
top.grepIP="<?=$grepIP?>";
top.IP_list="<?=$IP_list?>";
top.Group="<?=$Group?>";
top.choice="<?=$choice?>";
top.account="<?=$account?>";
top.password="<?=$password1?>";
top.S_EM="<?=$S_EM?>";
top.alldata="<?=$alldata?>";
top.webset="<?=$webset?>";
top.str_renew="<?=$str_renew?>";
top.outright="<?=$outright?>";
top.financial="<?=$financial?>";
top.str_HCN = new Array("<?=$str_HCN1?>","<?=$str_HCN2?>","<?=$str_HCN3?>");

//====== Live TV
top.str_FT ="<?=$str_FT?>";
top.str_BK ="<?=$str_BK?>";
top.str_TN ="<?=$str_TN?>";
top.str_VB ="<?=$str_VB?>";
top.str_BS ="<?=$str_BS?>";
top.str_OP ="<?=$str_OP?>";




top.str_fs_FT ="<?=$str_fs_FT?>";
top.str_fs_BK ="<?=$str_fs_BK?>";
top.str_fs_TN ="<?=$str_fs_TN?>";
top.str_fs_VB ="<?=$str_fs_VB?>";
top.str_fs_BS ="<?=$str_fs_BS?>";
top.str_fs_OP ="<?=$str_fs_OP?>";

top.str_game_list ="<?=$str_game_list?>";
top.str_second ="<?=$str_second?>";
top.str_demo ="<?=$str_demo?>";
top.str_alone ="<?=$str_alone?>";
top.str_back ="<?=$str_back?>";
top.str_RB ="<?=$str_RB?>";

top.str_ShowMyFavorite="<?=$str_ShowMyFavorite?>";
top.str_ShowAllGame="<?=$str_ShowAllGame?>";
top.str_delShowLoveI="<?=$str_delShowLoveI?>";


top.strRtypeSP = new Array();
top.strRtypeSP["PGF"]="<?=$strRtypeSP1?>";
top.strRtypeSP["OSF"]="<?=$strRtypeSP2?>";
top.strRtypeSP["STF"]="<?=$strRtypeSP3?>";
top.strRtypeSP["CNF"]="<?=$strRtypeSP4?>";
top.strRtypeSP["CDF"]="<?=$strRtypeSP5?>";
top.strRtypeSP["RCF"]="<?=$strRtypeSP6?>";
top.strRtypeSP["YCF"]="<?=$strRtypeSP7?>";
top.strRtypeSP["GAF"]="<?=$strRtypeSP8?>";
top.strRtypeSP["PGL"]="<?=$strRtypeSP9?>";
top.strRtypeSP["OSL"]="<?=$strRtypeSP10?>";
top.strRtypeSP["STL"]="<?=$strRtypeSP11?>";
top.strRtypeSP["CNL"]="<?=$strRtypeSP12?>";
top.strRtypeSP["CDL"]="<?=$strRtypeSP13?>";
top.strRtypeSP["RCL"]="<?=$strRtypeSP14?>";
top.strRtypeSP["YCL"]="<?=$strRtypeSP15?>";
top.strRtypeSP["GAL"]="<?=$strRtypeSP16?>";
top.strRtypeSP["PG"]="<?=$strRtypeSP17?>";
top.strRtypeSP["OS"]="<?=$strRtypeSP18?>";
top.strRtypeSP["ST"]="<?=$strRtypeSP19?>";
top.strRtypeSP["CN"]="<?=$strRtypeSP20?>";
top.strRtypeSP["CD"]="<?=$strRtypeSP21?>";
top.strRtypeSP["RC"]="<?=$strRtypeSP22?>";
top.strRtypeSP["YC"]="<?=$strRtypeSP23?>";
top.strRtypeSP["GA"]="<?=$strRtypeSP24?>";


top.strOver="<?=$strOver?>";
top.strUnder="<?=$strUnder?>";
top.strOdd="<?=$strOdd?>";
top.strEven="<?=$strEven?>";


//下注警语
top.message001="<?=$message001?>";
top.message002="<?=$message002?>";
top.message003="<?=$message003?>";
top.message004="<?=$message004?>";
top.message005="<?=$message005?>";
top.message006="<?=$message006?>";
top.message007="<?=$message007?>";
top.message008="<?=$message008?>";
top.message009="<?=$message009?>";
top.message010="<?=$message010?>";
top.message011="<?=$message011?>";
top.message012="<?=$message012?>";
top.message013="<?=$message013?>";
top.message014='<?=$message014?>';
top.message015="<?=$message015?>";
top.message016="<?=$message016?>";
top.message017="<?=$message017?>";
top.message018="<?=$message018?>";
top.message019="<?=$message019?>";
top.message020="<?=$message020?>";
top.message021="<?=$message021?>";
top.message022="<?=$message022?>";
top.message023="<?=$message023?>";
top.message024="<?=$message024?>";
top.message025="<?=$message025?>";
top.message026="<?=$message026?>";
top.message027="<?=$message027?>";
top.message028="<?=$message028?>";
top.message029="<?=$message029?>";
top.message030="<?=$message030?>";


top.page="<?=$page?>";
top.refreshTime="<?=$refreshTime?>";
top.showmonth="<?=$showmonth?>";
top.showday="<?=$showday?>";

top.str_RB ="<?=$str_RB?>";
top.Half1st="<?=$Half1st?>";
top.Half2nd="<?=$Half2nd?>";

top.mem_logut="<?=$mem_logut?>";
top.retime1H="<?=$retime1H?>";
top.retime2H="<?=$retime2H?>";

top.str_otb_close="<?=$str_otb_close?>";

//奧運用
top.no_oly="<?=$no_oly?>";
//会员详细 conf
top.conf_R="<?=$conf_R?>";
top.conf_RE="<?=$conf_RE?>";
top.conf_RE_BK="<?=$conf_RE_BK?>";
top.conf_M="<?=$conf_M?>";
top.conf_M_BK ="<?=$conf_M_BK?>";
top.conf_DT="<?=$conf_DT?>";
top.conf_RDT="<?=$conf_RDT?>";
top.conf_FS="<?=$conf_FS?>";
top.str_more="<?=$str_more?>";
//new type
top.str_all_bets="<?=$str_all_bets?>";
top.str_TV_RB = "<?=$str_TV_RB?>";
top.str_TV_FT = "<?=$str_TV_FT?>";
top.addtoMyMarket='<?=$addtoMyMarket?>';

top.str_result = new Object();
top.str_result["No"] = "<?=$str_result_No?>";
top.str_result["Y"] = "<?=$str_result_Y?>";
top.str_result["N"] = "<?=$str_result_N?>";
top.str_result["F​​G_S"] = "<?=$str_result_FG_S?>";
top.str_result["F​​G_H"] = "<?=$str_result_FG_H?>";
top.str_result["F​​G_N"] = "<?=$str_result_FG_N?>";
top.str_result["F​​G_P"] = "<?=$str_result_FG_P?>";
top.str_result["F​​G_F"] = "<?=$str_result_FG_F?>";
top.str_result["F​​G_O"] = "<?=$str_result_FG_O?>";

top.str_result["T3G_1"] = "<?=$str_result_T3G_1?>";
top.str_result["T3G_2"] = "<?=$str_result_T3G_2?>";
top.str_result["T3G_N"] = "<?=$str_result_T3G_N?>";

top.str_result["T1G_N"] = "<?=$str_result_T1G_N?>";
top.str_result["T1G_1"] = "<?=$str_result_T1G_1?>";
top.str_result["T1G_2"] = "<?=$str_result_T1G_2?>";
top.str_result["T1G_3"] = "<?=$str_result_T1G_3?>";
top.str_result["T1G_4"] = "<?=$str_result_T1G_4?>";
top.str_result["T1G_5"] = "<?=$str_result_T1G_5?>";
top.str_result["T1G_6"] = "<?=$str_result_T1G_6?>";

top.statu = new Array();
top.statu["HT"] = "<?=$statu_HT?>";
top.statu["1H"] = "<?=$statu_1H?>";
top.statu["2H"] = "<?=$statu_2H?>";


//BK
top.str_BK_MS = new Array();
top.str_BK_MS[0] = "";
top.str_BK_MS[1] = "<?=$str_BK_MS1?>";
top.str_BK_MS[2] = "<?=$str_BK_MS2?>";
top.str_BK_MS[3] = "<?=$str_BK_MS3?>";
top.str_BK_MS[4] = "<?=$str_BK_MS4?>";
top.str_BK_MS[5] = "<?=$str_BK_MS5?>";
top.str_BK_MS[6] = "<?=$str_BK_MS6?>";

top.str_BK_OT = "<?=$str_BK_OT?>";

top.str_midfield = "<?=$str_midfield?>";

top.str_BK_Market_Main = "<?=$str_BK_Market_Main?>";
top.str_BK_Market_All = "<?=$str_BK_Market_All?>";
                        
top.str_BK_Period_View = "<?=$str_BK_Period_View?>";
top.str_BK_Period_Hide = "<?=$str_BK_Period_Hide?>";

top.str_TN_Market_Main = "<?=$str_TN_Market_Main?>";
top.str_TN_Market_All = "<?=$str_TN_Market_All?>";
top.str_TN_Period_View = "<?=$str_TN_Period_View?>";
top.str_TN_Period_Hide = "<?=$str_TN_Period_Hide?>";

top.TN_set_1="<?=$TN_set_1?>";
top.TN_set_2="<?=$TN_set_2?>";
top.TN_set_3="<?=$TN_set_3?>";
top.TN_set_4="<?=$TN_set_4?>";
top.TN_set_5="<?=$TN_set_5?>";
</script>
<html>
<head>
<meta name="Robots" contect="none">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/order<?=$cla?>.css" rel="stylesheet" type="text/css">
</head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 ">

<script>

top.str_order_FT = "<?=$str_order_FT?>";
top.str_order_BK = "<?=$str_order_BK?>";
top.str_order_TN = "<?=$str_order_TN?>";
top.str_order_VB = "<?=$str_order_VB?>";
top.str_order_BS = "<?=$str_order_BS?>";
top.str_order_OP = "<?=$str_order_OP?>";
 
//--------------------------------public function ----------------------------
 
function setRefreshPos(){
		var refresh_right= body_browse.document.getElementById('refresh_right');
		refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
		//refresh_right.style.top= 39;
	}
 
function parseArray(gameHead,gameData){
	var gameObj=new Object();
	for (var i=0;i<gameHead.length;i++){
		if (gameHead[i]!=""){	
			eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
		}
	}
	return gameObj;
}
 
 
function check_ioratio(rec,rtype,GameData){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		//alert(oldObjDataFT[rec]);
		if (""+oldObjDataFT[rec]=="undefined" || oldObjDataFT[rec].gid != GameData.gid){
			var gameObj=new Object();
			gameObj.gid=GameData.gid;
			oldObjDataFT[rec]=gameObj;
		}
		
		var new_ioratio=eval("GameData."+rtype);
		var old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		
		
		if (""+old_ioratio=="undefined"){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			old_ioratio=eval("oldObjDataFT[rec]."+rtype);
		}
		
		//alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
		if (""+new_ioratio=="undefined" || new_ioratio==""){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return;
		}
		
		/*
		if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #FF0000;' ";
		}
		if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
			eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='border: 1px solid #00FF00;' ";
		}
		*/
		
		if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
	    	eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
			return "  style='background-color : yellow' ";
		}
		
		return true;
	}
 
}

function showLeg(leg){
	for (var i=0;i<myLeg[leg].length;i++){
	if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");
				
		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
 
}
function showLegIcon(leg,state,gnumH,display){
	var  ary=body_browse.document.getElementsByName(leg);
			
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	try{
		body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		body_browse.document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
}
//----------------------
 

function show_page(){
	//alert(rtype)
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
	if (t_page==0){
		t_page=1;
		//obj_pg.innerHTML = "";
		//return;
	}
	var tmp_lid="";
	if (rtype=="re"){
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
	}else{
		tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
	}
	//alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
	if(tmp_lid=='ALL'&&!top.swShowLoveI){
		var disabled="";
		if (t_page==1){
			disabled="disabled";
			}
		var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
		for(var i=0;i<t_page;i++){
			if (pg==i){
		 		pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
		 	}else{
		  		pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
		  	}
		}
		pghtml+="</select>";
		obj_pg.innerHTML = pghtml;
	}else{
		obj_pg.innerHTML = "";
	}
}
 

function  change_time(get_time){
	
	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){
			
			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}	
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");
		
	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];
	
}
 

function dis_ShowLoveI(){
 
if(top.swShowLoveI){
  body_browse.document.getElementById("sel_league").style.display="none";
 }else{
  body_browse.document.getElementById("sel_league").style.display="";
 }
 
}
 
 
function changeTitleStr(s,at){
	if (s.charAt(at)=="H"){
		return "H";
	}else if(s.charAt(at)=="C"){
		return "A";
	}else if(s.charAt(at)=="N"){
		return "D";
	}
	return "";
}
 
 
function loadingOK(){
	//alert("loadingOK")
	try{
		body_browse.document.getElementById("refresh_btn").className="refresh_btn";
	}catch(E){}
	try{
	body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
	}catch(E){}
	try{	
	body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
	}catch(E){}
}
 
 
var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){
	
if( (""+countHOT=="") || (""+countHOT=="undefined") ){
	
	 body_browse.document.getElementById("euro_btn").style.display="none";
	 body_browse.document.getElementById("euro_up").style.display="none";
			
}else{	
		
	if(""+top.hot_game=="undefined"){
		top.hot_game="";
	}	
	var gtypeHOT =new Array("FT","BK","TN","VB","OP");
	var countgames=countHOT.split(",");
	recordHash=new Array();
	var head_str="";
	
	if(rtype == "re"){
		head_str="RB";
	}else{
		head_str=top.head_FU;
	}
	//alert(head_str);
	
	for( var i=0;i<countgames.length;i++){
		var detailgame=countgames[i].split("|");
		recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
	}
	if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
		body_browse.document.getElementById("euro_btn").style.display="none";
		body_browse.document.getElementById("euro_up").style.display="none";
		//body_browse.document.getElementById("euro_close").style.display="";
		if(top.hot_game!=""){
			top.hot_game="";
			body_browse.reload_var();
		}
	}else{	
		if(top.hot_game!=""){
			body_browse.document.getElementById("euro_btn").style.display="none";
			body_browse.document.getElementById("euro_up").style.display="";
		}else{
			body_browse.document.getElementById("euro_btn").style.display="";
			body_browse.document.getElementById("euro_up").style.display="none";
		}
		//body_browse.document.getElementById("euro_close").style.display="none";	
	}
	//alert(recordHash[top.head_gtype+"_HOT_RB"]);
	//alert(recordHash[top.head_gtype+"_HOT_FT"]);
	//alert(recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
	//parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
	/*
	var today_hot=0;
	var early_hot=0;
	for( var i=0;i<gtypeHOT.length;i++){
		try{
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
		parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
		}catch(E){}
			
		today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
		early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
	}	
	
		parent.mem_order.showHOT(today_hot,early_hot);
	*/	
	try{
		parent.mem_order.getCountHOT(countHOT);
	}catch(e){}
		
 }		
 	
}
 
</script>
<script>

function bodyLoad(){
	close_bet();
	setMsg(msg);
	//reload_live_game(GameHead,GameData);
	//window.onscroll();
	//document.getElementById('main').onscroll=scroll;
	//var obj=document.getElementById('main');
	//obj.
	scroll();
	try{
		//var gamecountHot=parent.body.getCountHOT();
		getCountHOT(countHOT);
		goRB();
		document.getElementById('euro_open').style.zIndex=-1;
	}catch(e){
		document.getElementById('euro_open').style.display='none';
	}	
}
window.onresize = scroll;
function setMsg(msg){
	document.getElementById('real_msg').innerHTML=msg;
}
 
function showOrder(){
	
	try{
		bet_order_frame.resetTimer();
	}catch(e){}
	document.getElementById('rec_frame').height=0;
	rec_frame.document.close();
	document.getElementById('order_button').className="ord_on";
	document.getElementById('record_button').className="record_btn";
	var betDiv=document.getElementById('bet_div');
	var rec5Div=document.getElementById('rec5_div');
	betDiv.style.display="";
	rec5Div.style.display="none";
	document.getElementById('pls_bet').style.display="none";
	document.getElementById('info_div').style.display='';
	//document.getElementById('switch_web').style.display="";
	//scroll();
	
	top.open_Rec="";
	try{
		//var gamecountHot=parent.body.getCountHOT();
		getCountHOT(countHOT);
	}catch(e){
		document.getElementById('euro_open').style.display='none';
	}	
	
}
 
function showRec(){
 
	try{
		bet_order_frame.clearAllTimer();
	}catch(e){}
	try{		
		close_bet();
	}catch(e){}
	//	bet_order_frame.document.close();
	
	document.getElementById('order_button').className="ord_btn";
	document.getElementById('record_button').className="record_on";
	//document.getElementById('info_div').style.display='none';
	
	var betDiv=document.getElementById('bet_div');
	var rec5Div=document.getElementById('rec5_div');
	
	betDiv.style.display="none";
	rec5Div.style.display="";
	rec5_div.focus();
	//alert(top.uid);
	rec_frame.location.replace("./today/show10rec.php?uid="+top.uid+"&langx="+top.langx);
	document.getElementById('pls_bet').style.display="none";
	
	try{	
		if(tenrec_id ==""){
			top.open_Rec="";
		}else{
			top.open_Rec="Y";
		}	
	}catch(e){}	
		
	try{
		//var gamecountHot=parent.body.getCountHOT();
		getCountHOT(countHOT);
	}catch(e){
		document.getElementById('euro_open').style.display='none';
	}			
 
	//scroll();
	//alert("showRec");
}
function onloadSet(w,h,frameName){
	
	//alert("width="+w+",height="+h+",frameName="+frameName);
	//document.getElementById(frameName).style.display="";
	document.getElementById(frameName).width  =216;
	document.getElementById(frameName).height =h;
	//document.getElementById(frameName).height =311;
	document.getElementById('pls_bet').style.display="none";
	if (frameName=="rec_frame"){
		try{	
			if(tenrec_id!=""){
				top.open_Rec="Y";
				document.getElementById('info_div').style.display='none';
				//document.getElementById('switch_web').style.display="none";	
				document.getElementById('euro_open').style.display='none';
			}else{
				top.open_Rec="";
			}	
		}catch(e){}	
			
		try{
			//var gamecountHot=parent.body.getCountHOT();
			getCountHOT(countHOT);
		}catch(e){
			document.getElementById('euro_open').style.display='none';
		}		
	}
 
	//scroll();
}
//var top.ioradio="";
 
function betOrder(gtype,wtype,param){
		//alert(gtype+","+wtype+","+param)
	if (wtype=="P3"||wtype=="PR"){
		//top.keepGold_PR="";
	}else{
		top.keepGold="";
		top.keepGold_PR="";
	}
	top.ioradio="";
	var url=parseUrl(gtype,wtype,param);
	document.getElementById('order_button').className="ord_on";
	document.getElementById('record_button').className="record_btn";
	document.getElementById('pls_bet').style.display="none";
	document.getElementById('rec_frame').height=0;
	rec_frame.document.close();
	document.getElementById('rec5_div').style.display="none";
	document.getElementById('bet_div').style.display="";
	bet_order_frame.location.replace(url);
	
	document.getElementById('info_div').style.display='none';
	//document.getElementById('switch_web').style.display="none";
	
	//document.getElementById('euro_close').style.display='none';
	document.getElementById('euro_open').style.display="none";
	document.getElementById('xisimg').style.display="none";
	
	top.open_bet="Y";	
	top.open_Rec="";
	//bet_order_frame.onload=onloadSet;
	//alert("betorder")
}
 
function parseUrl(gtype,wtype,param){
	var rm15 = new Array("ARM","BRM","ERM","DRM");
	var re15 = new Array("ARE","BRE","ERE","DRE")
	var rou15 = new Array("AROU","BROU","EROU","DROU");
	var m15 = new Array("AM","BM","CM","DM","EM","FM");
	var r15 = new Array("AR","BR","CR","DR","ER","FR")
	var ou15 = new Array("AOU","BOU","COU","DOU","EOU","FOU");
	var singleGame = new Array(
		"RWM","RDC","RWE","RWB","ARG","BRG","CRG","DRG","ERG","FRG","GRG","HRG","IRG","JRG","RTS","RCS","RWN","RHG","RMG","RSB","RT3G","RT1G"
		,"WM","DC","BH","WE","WB","PG","TS","CS","WN","F2G","F3G","HG","MG","SB","FG","T3G","T1G","TK","PA","RCD","ST","OS"
	);
	var rouhc = new Array("ROUH","ROUC","HRUH","HRUC");
	var ouhc = new Array("OUH","OUC","HOUH","HOUC");
	var urlArray=new Array();
	urlArray['R']=new Array("../"+gtype+"_order/"+gtype+"_order_r.php");
	urlArray['HR']=new Array("../"+gtype+"_order/"+gtype+"_order_hr.php");
	urlArray['OU']=new Array("../"+gtype+"_order/"+gtype+"_order_ou.php");
	urlArray['HOU']=new Array("../"+gtype+"_order/"+gtype+"_order_hou.php");
	urlArray['M']=new Array("../"+gtype+"_order/"+gtype+"_order_m.php");
	urlArray['HM']=new Array("../"+gtype+"_order/"+gtype+"_order_hm.php");
	urlArray['EO']=new Array("../"+gtype+"_order/"+gtype+"_order_t.php");
	urlArray['REO']=new Array("../"+gtype+"_order/"+gtype+"_order_rt.php");
	urlArray['HEO']=new Array("../"+gtype+"_order/"+gtype+"_order_t.php");
	urlArray['HREO']=new Array("../"+gtype+"_order/"+gtype+"_order_rt.php");
	urlArray['PD']=new Array("../"+gtype+"_order/"+gtype+"_order_pd.php");
	urlArray['RPD']=new Array("../"+gtype+"_order/"+gtype+"_order_rpd.php");
	urlArray['HPD']=new Array("../"+gtype+"_order/"+gtype+"_order_hpd.php");
	urlArray['HRPD']=new Array("../"+gtype+"_order/"+gtype+"_order_hrpd.php");
	urlArray['F']=new Array("../"+gtype+"_order/"+gtype+"_order_f.php");
	urlArray['RF']=new Array("../"+gtype+"_order/"+gtype+"_order_rf.php");
	urlArray['T']=new Array("../"+gtype+"_order/"+gtype+"_order_t.php");
	urlArray['HT']=new Array("../"+gtype+"_order/"+gtype+"_order_ht.php");
	urlArray['RT']=new Array("../"+gtype+"_order/"+gtype+"_order_rt.php");
	urlArray['HRT']=new Array("../"+gtype+"_order/"+gtype+"_order_rt.php");
	urlArray['SP']=new Array("../"+gtype+"_order/"+gtype+"_order_sp.php");
	urlArray['P']=new Array("../"+gtype+"_order/"+gtype+"_order_p.php");
	urlArray['P3']=new Array("../"+gtype+"_order/"+gtype+"_order_p3.php");
	urlArray['PR']=new Array("../"+gtype+"_order/"+gtype+"_order_pr.php");
	urlArray['RE']=new Array("../"+gtype+"_order/"+gtype+"_order_re.php");
	urlArray['HRE']=new Array("../"+gtype+"_order/"+gtype+"_order_hre.php");
	urlArray['ROU']=new Array("../"+gtype+"_order/"+gtype+"_order_rou.php");
	urlArray['HROU']=new Array("../"+gtype+"_order/"+gtype+"_order_hrou.php");
	urlArray['RM']=new Array("../"+gtype+"_order/"+gtype+"_order_rm.php");
	urlArray['HRM']=new Array("../"+gtype+"_order/"+gtype+"_order_hrm.php");
	urlArray['NFS']=new Array("../"+gtype+"_order/"+gtype+"_order_nfs.php");
	
	
	urlArray['RE15']=new Array("../"+gtype+"_order/"+gtype+"_order_re15.php");
	urlArray['ROU15']=new Array("../"+gtype+"_order/"+gtype+"_order_rou15.php");
	urlArray['RM15']=new Array("../"+gtype+"_order/"+gtype+"_order_rm15.php");
	
	urlArray['R15']=new Array("../"+gtype+"_order/"+gtype+"_order_r15.php");
	urlArray['OU15']=new Array("../"+gtype+"_order/"+gtype+"_order_ou15.php");
	urlArray['M15']=new Array("../"+gtype+"_order/"+gtype+"_order_m15.php");
	
	urlArray['SINGLE']=new Array("../"+gtype+"_order/"+gtype+"_order_single.php");
	urlArray['ROUHC']=new Array("../"+gtype+"_order/"+gtype+"_order_rouhc.php");
	urlArray['OUHC']=new Array("../"+gtype+"_order/"+gtype+"_order_ouhc.php");
	urlArray['W3']=new Array("../"+gtype+"_order/"+gtype+"_order_w3.php");
 
	if(!Array.indexOf){
		Array.prototype.indexOf = function(obj){
			for(var i=0; i<this.length; i++){
				if(this[i]==obj){
					return i;
				}
			}
			return -1;
		}
	}
	if(ouhc.indexOf(wtype) != -1){
		wtype = "OUHC";
	}
	if(rouhc.indexOf(wtype) != -1){
		wtype = "ROUHC";
	}
	if(singleGame.indexOf(wtype) != -1){
		wtype = "SINGLE";
	}
	if(re15.indexOf(wtype) != -1){
		wtype = "RE15";
	}
	if(rou15.indexOf(wtype) != -1){
		wtype = "ROU15";
	}	
	if(rm15.indexOf(wtype) != -1){
		wtype = "RM15";
	}	
	if(r15.indexOf(wtype) != -1){
		wtype = "R15";
	}
	if(ou15.indexOf(wtype) != -1){
		wtype = "OU15";
	}	
	if(m15.indexOf(wtype) != -1){
		wtype = "M15";
	}	
	   
	var url=urlArray[wtype]+"?"+param;
	//document.write(url);   
	return url;

}
function close_bet(){
	document.getElementById('pls_bet').style.display="none";
	//document.getElementById('bet_div').style.display="";
	document.getElementById('bet_order_frame').height =0;
	//alert("close bet 1");
	bet_order_frame.document.close();
	//alert("close bet 2");
//	bet_order_frame.document.body.className="ord_main";
//	bet_order_frame.document.body.bgColor="red";
	//bet_order_frame.document.body.style.background-color="red";
	//document.getElementById('pls_bet').style.backgroundColor="#007000";
	//alert(document.getElementById('pls_bet').style.backgroundColor);
	
	bet_order_frame.document.writeln("<html><link href=\"../../../style/member/mem_order_sel.css\" rel=\"stylesheet\" type=\"text/css\">");
	bet_order_frame.document.writeln("<body class=\"bet_info\" style='margin:0;'>");
	
	bet_order_frame.document.writeln(document.getElementById('pls_bet').innerHTML);
	bet_order_frame.document.writeln("</body></html>");
	//alert("write order frame");
//	bet_order_frame.location.replace("");
	document.getElementById('bet_order_frame').height = bet_order_frame.document.body.scrollHeight;
	//document.getElementById('bet_order_frame').height = 20;
	document.getElementById('info_div').style.display='';
	//document.getElementById('switch_web').style.display="";
	top.scripts=new Array();
	top.keepGold="";
	top.keepGold_PR="";
	try{
		parent.body.orderRemoveALL();
	}catch (E) {}
		
	top.open_bet="";			
	try{
		//var gamecountHot=parent.body.getCountHOT();
		getCountHOT(countHOT);
	}catch(e){
		document.getElementById('euro_open').style.display='none';
	}		
		
}
function Show10List(){
	var objs=document.getElementById('reloadPHP');
    if (parent.refresh_var=='Y'||(""+parent.refresh_var=="undefined")){
    	objs.src = "./today/show10rec.php?uid="+top.uid;
    }else{
    	objs.src="../../../tpl/member/"+top.langx+"/show10rec_norefresh.html?uid="+top.uid;
    }
}
 
function show_record(){
	if (parent.show=='N'||(""+parent.show=="undefined")){
		parent.show='';
	}else{
		parent.show='N';
	}
	self.location = "./select.php?uid="+top.uid+"&langx="+top.langx+"$mtype="+top.mtype+"&show="+parent.show;
}
function reload_var(){
	parent.refresh_var='Y';
	self.location.reload();
}
function Hot_click(a,b,c){
    parent.location=a+"&league_id=3";
}
function OpenLive(){
	if (top.liveid == undefined) {
		parent.self.location = "";
		return;
	}
	window.open("./live/live.php?langx="+top.langx+"&uid="+top.uid+"&liveid="+top.liveid,"Live","width=780,height=580,top=0,left=0,status=no,toolbar=no,scrollbars=yes,resizable=no,personalbar=no");
}
 
var ObjDataLive=new Array();
function reload_live_game(Game_Head,gamedata){
	for (var j=0;j < gamedata.length;j++){
		if (gamedata[j]!=null){
			ObjDataLive[j]=parseArray(Game_Head,gamedata[j]);
		}	
	}
	var showtableData;
	var trdata;
	if(document.all){
		showtableData=document.getElementById('livetableData').innerText;
	 	trdata=document.getElementById('DataTR').innerText;
	} else{
		showtableData=document.getElementById('livetableData').textContent;
	 	trdata=document.getElementById('DataTR').textContent;
	}
	var showlayers="";
	if(ObjDataLive.length > 0){
		for ( i=0 ;i < ObjDataLive.length;i++){
			showlayers+=getLayer(trdata,i);
		}
	}else{
		var tmp_layer=trdata;
		tmp_layer=tmp_layer.replace("*TIME*","");
		tmp_layer=tmp_layer.replace("*TEAMS*","<?=$wuzhi?>");
		showlayers = tmp_layer;
	}
	var showtable=document.getElementById('showLive_table');
	showtableData=showtableData.replace("*showDataTR*",showlayers);
	showtable.innerHTML=showtableData;
}
//
function getLayer(onelayer,gamerec){
	onelayer=onelayer.replace("*TIME*",ObjDataLive[gamerec].time+":");
	onelayer=onelayer.replace("*TEAMS*",ObjDataLive[gamerec].teamH+" VS "+ObjDataLive[gamerec].teamC);
	return onelayer; 
	
}
 
 
//window.onscroll = scroll;
 
function scroll(){
	//return; 
	var refresh_right = document.getElementById('info_div');
	
	var msg_height=(refresh_right.style.height.replace("px","")*1);
	var recframe=document.getElementById('rec_frame');
	//alert(recframe.height+"---"+document.body.scrollHeight+"---"+msg_height);
	//if(recframe.height+msg_height < document.body.scrollHeight){
		//alert("1");
		refresh_right.style.top=document.body.scrollHeight - msg_height-15;
	//}else{
		//alert("2");
		//refresh_right.style.top=recframe.height*1+msg_height+250;
		//refresh_right.style.left=0;
	//}
	
}
function showMoreMsg(){
	var MoreMsgObj = window.open('./scroll_history.php?uid='+top.uid+'&langx='+top.langx,"History","width=617,height=500,top=0,left=0,status=no,toolbar=no,scrollbars=1,resizable=no,personalbar=no");
	MoreMsgObj.focus();
}
var xmlHttp;
function createXHR(){
 if (window.XMLHttpRequest) {
  xmlHttp = new XMLHttpRequest();
 }else if (window.ActiveXObject) {
  xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
 }
 
 if (!xmlHttp) {
  alert('<?=$xmlhttpis?>');
  return false;
 }
}
function sendRequest(url){

 createXHR();
 xmlHttp.open('GET',url,true);
 xmlHttp.onreadystatechange=catchResult;
 xmlHttp.send(null);
}
 
 
 
function catchResult(){
 if (xmlHttp.readyState==4){
  s=xmlHttp.responseText;
  if (xmlHttp.status == 200) {
  //alert("ѳɹ~~"+s+":");
  // location.reload();  
  document.getElementById('showURL').innerHTML=s;
  
  var obj = document.getElementById('newdomain');
  obj.submit();
      // document.getElementById(s).innerHTML='<img src="058/btn_cart.gif" width="129" height="32" align="absmiddle" />';
  }else{
       alert('<?=$cuowu?>'+xmlHttp.status+'\('+xmlHttp.statusText+'\)');
      }
 }
}
function showHOT(){
	var countgtype =new Array("FT","BK","TN","VB","BS","OP");
	//alert(top.open_bet+"---"+mem_enable)
	//alert("top.open_bet:"+top.open_bet+",mem_enable="+mem_enable+",top.open_Rec="+top.open_Rec);
	if(top.open_bet =="Y" || mem_enable=="S" || top.open_Rec=="Y"){
		document.getElementById('euro_open').style.display="none";	
	}else{
	  var today_RB=0;
	  for( var i=0;i<countgtype.length;i++){
			today_RB +=recordHash[countgtype[i]+"_RB"];
			
			var tmp_obj_RB=document.getElementById(countgtype[i]+"_RB");
		
					tmp_obj_RB.innerHTML=eval("top.str_order_"+countgtype[i]) + "("+recordHash[countgtype[i]+"_RB"]+")";
					//alert(tmp_obj_RB.innerHTML);
					if(recordHash[countgtype[i]+"_RB"]*1==0){
						tmp_obj_RB.style.display="none";
					}else{
						tmp_obj_RB.style.display="";
					}
			
		}
		//alert("today_RB=="+today_RB);	   			
		if (today_RB > 0) {
			document.getElementById('euro_open').style.display="";
			document.getElementById('xisimg').style.display="";
		}else{
			
			document.getElementById('euro_open').style.display="none";
		}	
			
 	}
 	
}
 
 function showRB(gtypeFT){
	if(recordHash[gtypeFT+"_RB"]*1==0){
		//alert(top.no_oly);
		return;		
	}	
top.hot_game="";
top.head_FU="FT";	
parent.header.location.href="http://"+document.domain+"/app/member/"+gtypeFT+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;

parent.body.location.href="http://"+document.domain+"/app/member/"+gtypeFT+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype;	
parent.header.chg_button_bg(gtypeFT,"rb");	
 
}
 
 
function showHotRB(gtypeFT){
	if(recordHash[gtypeFT+"_HOT_RB"]*1==0){
		//alert(top.no_oly);
		return;
	}
	top.hot_game="HOT_";
	//top.head_FU="FT";
	parent.header.location.href="http://"+document.domain+"/app/member/"+gtypeFT+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
	parent.body.location.href="http://"+document.domain+"/app/member/"+gtypeFT+"_browse/index.php?rtype=re&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
	parent.header.chg_button_bg(gtypeFT,"rb");
}
 
function showHotFT(gtypeFT){
	if(recordHash[gtypeFT+"_HOT_FT"]*1==0){
		//alert(top.no_oly);
		return;
	}
	top.hot_game="HOT_";
	parent.header.location.href="http://"+document.domain+"/app/member/"+gtypeFT+"_header.php?uid="+top.uid+"&showtype=&langx="+top.langx+"&mtype="+top.mtype;
	parent.body.location.href="http://"+document.domain+"/app/member/"+gtypeFT+"_browse/index.php?rtype=r&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype="+top.showtype+"&hot_game="+top.hot_game;
	parent.header.chg_button_bg(gtypeFT,"today");
}

 
function showHotFU(gtypeFU){
	if(recordHash[gtypeFU+"_HOT_FU"]*1==0){
		//alert(top.no_oly);
		return;		
	}
	top.hot_game="HOT_";
	parent.header.location.href="http://"+document.domain+"/app/member/"+gtypeFU+"_header.php?uid="+top.uid+"&showtype=future&langx="+top.langx+"&mtype="+top.mtype;
	//parent.body.location.href="http://"+document.domain+"/app/member/"+top.head_gtype+"_future/index.php?rtype=r&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype=future&hot_game="+top.hot_game;
	parent.body.location.href="http://"+document.domain+"/app/member/"+gtypeFU+"_future/index.php?rtype=r&uid="+top.uid+"&langx="+top.langx+"&mtype="+top.mtype+"&showtype=future&hot_game="+top.hot_game;
	
	parent.header.chg_button_bg(gtypeFU,"early");
 
}
 
function Eurover(act){
	if(act.className=="hot_btn"){
		act.className='hot_up';
	}else if(act.className=="early_btn"){
		act.className='early_up';
	}else if(act.className=="rb_btn"){
		act.className='rb_up';
	}
}
 
function Eurout(act){
	if(act.className=="hot_up"){
		act.className='hot_btn';
	}else if(act.className=="early_up"){
		act.className='early_btn';
	}else if(act.className=="rb_up"){
		act.className='rb_btn';
	}
}
 
var recordHash=new Array();
function getCountHOT(countHOT){
	this.countHOT = countHOT;
	//alert("getCountHOT==>"+countHOT);
	var countgtype =new Array("FT","BK","TN","VB","BS","OP");
	var countgames=countHOT.split(",");
		for( var i=0;i<countgames.length;i++){
			var detailgame=countgames[i].split("|");
			recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
		}
		
		if((recordHash["FT_HOT_RB"]*1 + recordHash["FT_HOT_FT"]*1 + recordHash["FT_HOT_FU"]*1) >= 1){
			document.getElementById("euro_menu_all").style.display = "";
			document.getElementById("HOT_rb").innerHTML = "("+recordHash["FT_HOT_RB"]+")";
			document.getElementById("HOT_today").innerHTML = "("+recordHash["FT_HOT_FT"]+")";
			document.getElementById("HOT_early").innerHTML = "("+recordHash["FT_HOT_FU"]+")";
		}else{
			document.getElementById("euro_menu_all").style.display = "none";
		}
	return showHOT();
}
 
function goRB(){
	document.getElementById('RB_btn').className="rb_over";
	//document.getElementById('today_btn').className="hot_btn";
	//document.getElementById('early_btn').className="early_btn";						
	document.getElementById('RB_oly').style.display="";
	//document.getElementById('today_oly').style.display="none";
	//document.getElementById('early_oly').style.display="none";
}
 
function goHOT_FT(){
	document.getElementById('RB_btn').className="rb_btn";
	document.getElementById('today_btn').className="hot_over";
	document.getElementById('early_btn').className="early_btn";					
	document.getElementById('RB_oly').style.display="none";
	document.getElementById('today_oly').style.display="";
	document.getElementById('early_oly').style.display="none";
}
 
function goHOT_FU(){
	document.getElementById('RB_btn').className="rb_btn";
	document.getElementById('today_btn').className="hot_btn";
	document.getElementById('early_btn').className="early_over";						
	document.getElementById('RB_oly').style.display="none";
	document.getElementById('today_oly').style.display="none";
	document.getElementById('early_oly').style.display="";
}

function goEuro_HOT(types){
	var ary = types.split("_");
	var tmpGtype = ary[0];
	var tmpTypes = ary[1];
	var langx = "";
	
	switch(top.langx){
		case "zh-tw":
			langx = "tw";
			break;
		case "zh-cn":
			langx = "cn";
			break;
		case "en-us":
			langx = "en";
			break;
		default:
			langx = "en";
			break;
	}
	
	document.getElementById('HOT_rb_btn').className = "rb_left_"+langx+"_out";
	document.getElementById('HOT_today_btn').className = "hot_left_"+langx+"_out";
	document.getElementById('HOT_early_btn').className = "early_left_"+langx+"_out";
	
	switch(tmpTypes){
		case "rb":
			document.getElementById('HOT_rb_btn').className = "rb_left_"+langx+"_on";
			showHotRB(tmpGtype);
			break;
		case "today":
			document.getElementById('HOT_today_btn').className = "hot_left_"+langx+"_on";
			showHotFT(tmpGtype);
			break;
		case "early":
			document.getElementById('HOT_early_btn').className = "early_left_"+langx+"_on";
			showHotFU(tmpGtype);
			break;
		default:
			break;
	}
}


</script>



<?
if($langx=="en-us"){
$msg_member='message_en';}
else if($langx=="zh-tw"){
$msg_member='message_tw';
} else{
$msg_member='message';
}
$sql = "select $msg_member as message,ntime from web_marquee where level=4 order by id desc limit 0,1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$mes=$row['message'];

?>

<?
////////////////////////////////////////////////////

$mysql = "select *  from web_system";
$result1 = mysql_query($mysql);
$row1 = mysql_fetch_array($result1);

switch($langx){
	case 'zh-tw':
			$site=$row1['datasite_tw'];
			$suid=$row1['uid_tw'];
			break;
	case 'en-us':
			$site=$row1['datasite_en'];
			$suid=$row1['uid_en'];
			break;
	default:
			$site=$row1['datasite'];
			$suid=$row1['uid_cn'];
			break;
}

$base_url = "".$site."/app/member/FT_index.php?uid=$suid&langx=$langx&mtype=$mtype";
$thisHttp = new cHTTP();
$thisHttp->setReferer($base_url);
$filename="".$site."/app/member/select.php?uid=$suid&langx=$langx";
// $thisHttp->setCookies('nn1aab3b',$uidcd);
$thisHttp->getPage($filename);
$msg  = $thisHttp->getContent();
$pb=explode("countHOT= '",$msg);
$pb=explode("' ;",$pb[1]);
 $countHOT=$pb[0];
$pb1=explode("var GameData = new Array();",$msg);
$pb1=explode("var GameHead = new Array('gtype','time','league','teamH','teamC','gidm');",$pb1[1]);
$GameData=$pb1[0];



///////////////////////////////////////////////////
?>
<script>
gamedate = '<?=$mydate?>';
var GameData = new Array();
<?=$GameData?>
var GameHead = new Array('gtype','time','league','teamH','teamC','gidm');
var msg='<?=$mes?>';
var chgURL_domain='<?=$old_http?>';
var mtype='<?=$mtype?>';
var mem_enable='Y';
var countHOT= '<?=$countHOT?>' ;
</script>

<body id="OSEL" class="bodyset" onLoad="bodyLoad();">
<div class="ord_main" id="div_ord_main">

	<div class="ord_on" id="order_button" onClick="showOrder();"><?=$jyd?></div>
	<div class="record_btn" id="record_button" onClick="showRec();"><?=$zxjy?></div>
	<div class="ord_memu">
		<span id="title_menu" onClick="showMenu('menu')" class="ord_memuBTN_on"><?=$muluo?></span>
		<span id="title_betslip" onClick="showOrder()" class="ord_memuBTN"><?=$jiaoyidan?></span>
		<span id="title_mybets" onClick="showRec()" class="ord_memuBTN no_margin"><?=$myzhudan?><span id="count_mybet" class="ord_msg">0</span></span>
	</div>

	<!--menu-->
	<div id="div_menu" name="div_menu" class="ord_DIV">
		<!--過關下注數-->
		<div id="show_parlay" class="ord_parlyG noFloat" onClick="showMenu('betslip')" style="display:none">
			<ul><li>Parlay Bet Slip</li></ul>
			<span id="count_parlay" class="ord_parlyNUM">0</span>
		</div>

		<!--滾球區-->
		<div id="oly_main111">
			<!--滚球 -->
			<div id="RB_oly">
				<div id="FT_RB" onClick="showRB('FT');" class="oly_tr" ></div>
				<div id="BK_RB" onClick="showRB('BK');" class="oly_tr" ></div>
				<div id="TN_RB" onClick="showRB('TN');" class="oly_tr"></div>
				<div id="VB_RB" onClick="showRB('VB');" class="oly_tr" ></div>
				<div id="BS_RB" onClick="showRB('BS');" class="oly_tr" ></div>
				<div id="OP_RB" onClick="showRB('OP');" class="oly_tr" ></div>
			</div>

		</div>
		<div id="euro_open" class="ord_sportMenu_InPlayG" style="display:none">
			<h1><?=$gunball?></h1>
			<div id="div_rb" class="ord_sportMenu_InPlay">
				<div id="FT_div_rb" style="display:none;" class="ord_sportFT_nor_off noFloat" onClick="Go_RB_page('FT');"><span class="ord_sportName"><?=$str_order_FT?></span><span id="RB_FT_games" class="ord_sportDigit">0</span></div>
				<div id="BK_div_rb" style="display:none;" class="ord_sportBK_nor_off noFloat" onClick="Go_RB_page('BK');"><span class="ord_sportName"><?=$str_order_BK?></span><span id="RB_BK_games" class="ord_sportDigit">0</span></div>
				<div id="TN_div_rb" style="display:none;" class="ord_sportTN_nor_off noFloat" onClick="Go_RB_page('TN');"><span class="ord_sportName"><?=$str_order_TN?></span><span id="RB_TN_games" class="ord_sportDigit">0</span></div>
				<div id="VB_div_rb" style="display:none;" class="ord_sportVB_nor_off noFloat" onClick="Go_RB_page('VB');"><span class="ord_sportName"><?=$str_order_VB?></span><span id="RB_VB_games" class="ord_sportDigit">0</span></div>
				<div id="BM_div_rb" style="display:none;" class="ord_sportBM_nor_off noFloat" onClick="Go_RB_page('BM');"><span class="ord_sportName"><?=$str_order_BM?></span><span id="RB_BM_games" class="ord_sportDigit">0</span></div>
				<div id="TT_div_rb" style="display:none;" class="ord_sportTT_nor_off noFloat" onClick="Go_RB_page('TT');"><span class="ord_sportName"><?=$str_order_TT?></span><span id="RB_TT_games" class="ord_sportDigit">0</span></div>
				<div id="BS_div_rb" style="display:none;" class="ord_sportBS_nor_off noFloat" onClick="Go_RB_page('BS');"><span class="ord_sportName"><?=$str_order_BS?></span><span id="RB_BS_games" class="ord_sportDigit">0</span></div>
				<div id="SK_div_rb" style="display:none;" class="ord_sportSK_nor_off noFloat" onClick="Go_RB_page('SK');"><span class="ord_sportName"><?=$str_order_SK?></span><span id="RB_SK_games" class="ord_sportDigit">0</span></div>
				<div id="OP_div_rb" style="display:none;" class="ord_sportOT_nor_off noFloat" onClick="Go_RB_page('OP');"><span class="ord_sportName"><?=$str_order_OP?></span><span id="RB_OP_games" class="ord_sportDigit">0</span></div>
			</div>
			<div id="RB_nodata" style="display:none;" class="ord_noInPlay"><?=$meiyousaishi?></div><!--沒賽-->
		</div>


		<!-- 特殊賽事 -->
		<div id="sp_game" style="display:none;" class="ord_sportMenu_WorldCupG">
			<h1 id="sp_name">world cup</h1>

			<div id="sp_show" class="ord_sportMenu_WorldCup"></div>

			<div id="sp_model" style="display:none;">
				<div id="sp_game_FT" onClick="goToSPGame('FT','');" class="noFloat"><span class="ord_sportName">Today's Matches</span><span class="ord_sportDigitWC">*FT_COUNT*</span></div>
				<div id="sp_game_FU" onClick="goToSPGame('FU','');" class="noFloat"><span class="ord_sportName">Early Matches</span><span class="ord_sportDigitWC">*FU_COUNT*</span></div>
				<div id="sp_game_P3" onClick="goToSPGame('P3','');" class="noFloat"><span class="ord_sportName">Parlay</span><span class="ord_sportDigitWC">*P3_COUNT*</span></div>
			</div>
		</div>
		<!-- 特殊賽事 End -->


		<!-- 精選賽事 -->
		<div id="hot_game" style="display:none;" class="ord_sportMenu_highG">
			<h1 id="hot_name"><?=$jingxuan?></h1>
			<div class="ord_sportMenu_high">
				<div class="ord_sportFT_high noFloat" onclick="showHotDiv('FT');" =""="">
				<span class="ord_sportName">
					<span class="ordH3">足球</span>
					<span class="ordH4">顶级赛事</span>
				</span>
				<span class="ord_sportArr_on" id="arrow_FT" ></span>
			</div>
			<ul id="_hot_div">
				<li id="hot_game_FT" onClick="goToHotGame('FT','*GTYPE*');"><h5>Today's Matches</h5><h6>*FT_COUNT*</h6></li>
				<li id="hot_game_FU" onClick="goToHotGame('FU','*GTYPE*');"><h5>Early Matches</h5><h6>*FU_COUNT*</h6></li>
				<li id="hot_game_P3" onClick="goToHotGame('P3','*GTYPE*');"><h5>Parlay</h5><h6>*P3_COUNT*</h6></li>
			</ul>
		</div>
	</div>
	<!-- 精選賽事 End -->


	<!--球類有下拉區-->
	<div class="ord_sportMenu_TodayG">
		<h1><?=$tiyu?></h1>
		<div class="ord_memu2">
			<span id="title_today" onClick="chgShowType('today');" class="ord_memuBTN_on"><?=$today?></span>
			<span id="title_early" onClick="chgShowType('early');" class="ord_memuBTN"><?=$early?></span>
			<span id="title_parlay" onClick="chgShowType('parlay');" class="ord_memuBTN no_margin"><?=$parlay2?></span></div>
		<div id="sportMenu_Today" class="ord_sportMenu_Today" >
			<div id="title_FT" style="display:none;" onClick="chgTitle('FT');" class="ord_sportFT_on noFloat"><span class="ord_sportName"><?=$str_order_FT?></span><span id="FT_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_FT" select="wtype_FT_r" style="display:none">
				<li id="wtype_FT_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$rangf1?></li>
				<li id="wtype_FT_pd" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);"><?=$bodan?></li>
				<li id="wtype_FT_t" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);"><?=$dans?></li>
				<li id="wtype_FT_f" onClick="chgWtype(this.id);chg_type(this.id,parent.FT_lid_type);"><?=$banquan?></li>
				<li id="wtype_FT_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
			</ul>

			<div id="title_BK" style="display:none;" onClick="chgTitle('BK');" class="ord_sportBK_off noFloat"><span class="ord_sportName"><?=$str_order_BK?></span><span id="BK_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_BK" select="wtype_BK_r" style="display:none">
				<li id="wtype_BK_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.BK_lid_type);"><?=$HomeTeam?></li>
				<li id="wtype_BK_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$spmatch?></li>
			</ul>

			<div id="title_TN" style="display:none;" onClick="chgTitle('TN');" class="ord_sportTN_off noFloat"><span class="ord_sportName"><?=$str_order_TN?></span><span id="TN_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_TN" select="wtype_TN_r" style="display:none">
				<li id="wtype_TN_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$HomeTeam?></li>
				<li id="wtype_TN_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.TN_lid_type);"><?=$bodan?></li>
				<li id="wtype_TN_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
			</ul>

			<div id="title_VB" style="display:none;" onClick="chgTitle('VB');" class="ord_sportVB_off noFloat"><span class="ord_sportName"><?=$str_order_VB?></span><span id="VB_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_VB" select="wtype_VB_r" style="display:none">
				<li id="wtype_VB_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$HomeTeam?></li>
				<li id="wtype_VB_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.VB_lid_type);"><?=$bodan?></li>
				<li id="wtype_VB_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
			</ul>

			<div id="title_BM" style="display:none;" onClick="chgTitle('BM');" class="ord_sportBM_off noFloat"><span class="ord_sportName"><?=$str_order_BM?></span><span id="BM_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_BM" select="wtype_BM_r" style="display:none">
				<li id="wtype_BM_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$HomeTeam?></li>
				<li id="wtype_BM_pd35" onClick="chgWtype(this.id);chg_type(this.id,parent.BM_lid_type);"><?=$bodan?></li>
				<li id="wtype_BM_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
			</ul>

			<div id="title_TT" style="display:none;" onClick="chgTitle('TT');" class="ord_sportTT_off noFloat"><span class="ord_sportName"><?=$str_order_TT?> Tennis</span><span id="TT_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_TT" select="wtype_TT_r" style="display:none">
				<li id="wtype_TT_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,'');"><?=$HomeTeam?></li>
				<li id="wtype_TT_pd57" onClick="chgWtype(this.id);chg_type(this.id,parent.TT_lid_type);"><?=$bodan?></li>
				<li id="wtype_TT_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
			</ul>

			<div id="title_BS" style="display:none;" onClick="chgTitle('BS');" class="ord_sportBS_off noFloat"><span class="ord_sportName"><?=$str_order_BS?></span><span id="BS_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_BS" select="wtype_BS_r" style="display:none">
				<li id="wtype_BS_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.BS_lid_type);"><?=$HomeTeam?></li>
				<li id="wtype_BS_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
			</ul>

			<div id="title_SK" style="display:none;" onClick="chgTitle('SK');" class="ord_sportSK_off noFloat"><span class="ord_sportName"><?=$str_order_SK?></span><span id="SK_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_SK" select="wtype_SK_r" style="display:none">
				<li id="wtype_SK_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.SK_lid_type);"><?=$HomeTeam?></li>
				<li id="wtype_SK_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
			</ul>

			<div id="title_OP" style="display:none;" onClick="chgTitle('OP');" class="ord_sportOT_off noFloat"><span class="ord_sportName"><?=$str_order_OP?></span><span id="OP_games" class="ord_sportDigit">0</span></div>
			<ul id="wager_OP" select="wtype_OP_r" style="display:none">
				<li id="wtype_OP_r" class="On" onClick="chgWtype(this.id);chg_type(this.id,parent.OP_lid_type);"><?=$HomeTeam?></li>
				<li id="wtype_OP_fs" onClick="chgWtype(this.id);chg_type(this.id,'');parent.sel_league='';parent.sel_area='';top.hot_game='';" class="no_margin"><?=$outright?></li>
			</ul>

		</div>

		<div id="FT_today_nodata" style="display:none;" class="ord_noInSports"><?=$meiyousaishi?></div><!--沒賽-->
		<div id="FT_early_nodata" style="display:none;" class="ord_noInSports"><?=$meiyousaishi_early?></div><!--沒賽-->
		<div id="FT_parlay_nodata" style="display:none;" class="ord_noInSports"><?=$meiyousaishi_parlay?></div><!--沒賽-->

		<!--小廣告-->
		<div id="hideAD" class="ord_adG">
			<span><img src="/images/member/order_ad03<?=$css?>.jpg"/></span>
			<span><a href="https://www.live228.com/" target="_blank"><img src="/images/member/order_ad01<?=$css?>.jpg"/></a></span>
			<!--				<span><a href="http://www.433.com/" target="_blank"><img src="/images/member/order_ad02--><?//=$css?><!--.jpg"/></a></span>-->
		</div>

	</div>

</div>

<!--bet slip-->
<div id="div_betslip" name="div_bet" class="ord_DIV">
	<!--沒單文字-->
	<h1 id="SIN_BET">SINGLE BET</h1>
	<h1 id="PAR_BET" style="display:none">Parlay</h1>
	<div id="bet_nodata" class="ord_noOrder" style="display:none">Please add a selection to your Bet Slip.</div>

	<iframe id="bet_order_frame" name="bet_order_frame" scrolling="NO" frameborder="NO" border="0" width="200" height="0" allowtransparency="true"></iframe>
</div>




<!--my bets-->
<div id="div_mybets" name="div_mybets" class="ord_mainHight">
	<!--沒單-->
	<!--div id="rec5_nodata" class="ord_noMyBet">您沒有未結算注單</div-->

	<iframe id="rec_frame" name="rec_frame" scrolling='no' frameborder="NO" border="0" width="200" height="100%" allowtransparency="true"></iframe>
</div>



</div>
<iframe id="loadPHP" name="loadPHP" width="0" height="0" style="display:none;"></iframe>
<iframe id="reloadPHP" name="reloadPHP"  width="0" height="0" style="display:none;"></iframe>
</body>
</html>


<body  id="OSEL" class="bodyset" onLoad="bodyLoad();">
  <div id="main" style="overflow-y:auto;width:224;height:100%">

   <div id="menu">
    <div class="ord_on" id="order_button" onClick="showOrder();"><?=$jyd?></div>
    <div class="record_btn" id="record_button" onClick="showRec();"><?=$zxjy?></div>
  </div>

  <div id="order_div" name="order_div" style="overflow-x:hidden;">
    <div id="pls_bet" name="pls_bet" style="background-color:#E3CFAA;left:0;top:0; display:none;">
     <img src="/images/member/order_none.jpg" width="216" height="22">
    	<div style="width:216; height:63px; text-align:center; padding-top:16px;">
    		<font style="font:0.75em Arial, Helvetica, sans-serif; font-weight:bold;"><?=$dianj?></font>
    	</div>
  </div>
    <div id="bet_div" name="bet_div">
      <iframe id="bet_order_frame" name="bet_order_frame" scrolling="NO" frameborder="NO" border="0" height="0"></iframe>
    </div>
    <div id="rec5_div" name="rec5_div">
      <iframe id="rec_frame" name="rec_frame" scrolling='NO' frameborder="NO" border="0" height="0"></iframe>
    </div>
  </div>

<!-- 奥运   Start -->
		<!--<div id="euro_banner" class="euro_btn"></div>-->
		<div id="euro_menu_all" class="left_btn" style="display:none;">
			<div id="euro_banner" class="euro_btn"></div>
			<div class="rb_left_cn_out" id="HOT_rb_btn" onMouseOver="Eurover(this);" onMouseOut="Eurout(this);" onClick="goEuro_HOT('FT_rb');"><br /><span id="HOT_rb" class=" text_s"></span></div>
			<div class="hot_left_cn_out" id="HOT_today_btn" onMouseOver="Eurover(this);" onMouseOut="Eurout(this);" onClick="goEuro_HOT('FT_today');"><br /><span id="HOT_today" class="text_s"></span></div>
			<div class="early_left_cn_out" id="HOT_early_btn" onMouseOver="Eurover(this);" onMouseOut="Eurout(this);" onClick="goEuro_HOT('FT_early');"><br /><span id="HOT_early" class="text_s"></span></div>
		</div>
    <!-- 已开赛 -->

    <div id="euro_open" style="display:none;">
        <div id="euro_menu">
						<div class="rb_btn" id="RB_btn"  onmouseover="Eurover(this);" onMouseOut="Eurout(this);" onClick="goRB();"></div>
            <!--<div class="hot_btn" id="today_btn"  onmouseover="Eurover(this);" onMouseOut="Eurout(this);" onClick="goHOT_FT();"></div>
            <div class="early_btn" id="early_btn"  onmouseover="Eurover(this);" onMouseOut="Eurout(this);" onClick="goHOT_FU();"></div>-->
        </div>

         <!--div id="oly_main"-->
         <div id="oly_main111">
            <!--滚球 -->
            <div id="RB_oly">
                <div id="FT_RB" onClick="showRB('FT');" class="oly_tr" ></div>
                <div id="BK_RB" onClick="showRB('BK');" class="oly_tr" ></div>
                <div id="TN_RB" onClick="showRB('TN');" class="oly_tr"></div>
                <div id="VB_RB" onClick="showRB('VB');" class="oly_tr" ></div>
                <div id="BS_RB" onClick="showRB('BS');" class="oly_tr" ></div>
                <div id="OP_RB" onClick="showRB('OP');" class="oly_tr" ></div>
            </div>

         </div>

    </div>

<!-- 奥运   End -->



 <div>

	 <style>
	 .left_banner { margin-top:8px;}
.live228_cn { background:url(/images/member/live228_cn.jpg) no-repeat 0 0; width:216px; height:244px; display:block; cursor:pointer;}
	 </style>
<a href="" target="_blank"><img id="xisimg" src="../../images/live228_cn.jpg" border="0" style="margin-top:8px;; position:relative; left:-3px;"></a>

</div>

<div id='showURL'></div>
</body>
</html>
<?
mysql_close();
?>

